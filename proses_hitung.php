<?php
    session_start();
    include 'lib/connection.php';

    // inisialisai variabel
        $dataTraining = $dataTesting = $words = [];
        $pPositif = $pNegatif = [];

        $totPositif = $totNegatif = $totTraning = $positifKeluar = $negatifKeluar = 0;
        $hasilPositif = $hasilNegatif = $hasilTestingPositif = $hasilTestingNegatif = [];

    // proses mengambil data training sekaligus mengambil text potongan dari hasil stemmer
        $trainingData = "SELECT * FROM stemmer left join klasifikasi on s_data = k_stemmer  WHERE s_data IN (SELECT k_stemmer FROM klasifikasi)";
        $trainingResult = $con->query($trainingData) or die (mysqli_error($con));

        while($training = $trainingResult->fetch_assoc()){
            foreach(explode('|', $training['s_stemmer']) as $key => $glue){
                if(!in_array($glue, $words) && $training['s_stemmer'] != ''){
                    array_push($words, $glue);
                }
                

                if($training['k_hasil'] == 'positif'){
                    if(!array_key_exists($glue, $pPositif)){
                        $pPositif[$glue] = [
                            'value'     => $glue,
                            'count'     => 1,
                            'kelasDok'  => 'positif',
                            'kelasText' => ''
                        ];
                    }else{
                        $pPositif[$glue]['count'] += 1;
                    }

                    // $positifKeluar += 1;
                }else{
                    if(!array_key_exists($glue, $pNegatif)){
                        $pNegatif[$glue] = [
                            'value'     => $glue,
                            'count'     => 1,
                            'kelasDok'  => 'negatif',
                            'kelasText' => ''
                        ];
                    }else{
                        $pNegatif[$glue]['count'] += 1;
                    }

                    // $negatifKeluar += 1;
                }
            }

            array_push($dataTraining, [
                'stemmer'   => $training['s_stemmer'],
                'kelas'     => $training['k_hasil']
            ]);

            $totTraning += 1;
            if($training['k_hasil'] == 'positif')
                $totPositif += 1;
            else
                $totNegatif += 1;
        };

        // echo json_encode($pNegatif);

    // proses menentukan kelas dari masing-masing text potongan hasil stemmer yang keluar
        foreach($pPositif as $key => $pieces){
            $token = 0; $kelas = '';
            $cek = "SELECT * from kamus_liu where kl_value ='".$pieces['value']."'";
            $execute = $con->query($cek) or die (mysqli_error($con));

            while($value = $execute->fetch_assoc()){
                $kelas = $value['kl_kelas'];
                $token++;
            }

            if($token == 1){
                $pPositif[$key]['kelasText'] = $kelas;
                if($kelas == $pieces['kelasDok'])
                    $positifKeluar += $pieces['count'];
            }else{
                $pPositif[$key]['kelasText'] = 'multi';
                $positifKeluar += $pieces['count'];
            }
        }

        foreach($pNegatif as $key => $pieces){
            $token = 0; $kelas = '';
            $cek = "SELECT * from kamus_liu where kl_value ='".$pieces['value']."'";
            $execute = $con->query($cek) or die (mysqli_error($con));

            while($value = $execute->fetch_assoc()){
                $kelas = $value['kl_kelas'];
                $token++;
            }

            if($token == 1){
                $pNegatif[$key]['kelasText'] = $kelas;
                if($kelas == $pieces['kelasDok'])
                    $negatifKeluar += $pieces['count'];
            }else{
                $pNegatif[$key]['kelasText'] = 'multi';
                $negatifKeluar += $pieces['count'];
            }
        }

        // echo json_encode($pPositif);

    // proses mengambil data testing
        $testingData = "SELECT * FROM stemmer left join stopword on stopword.s_data = stemmer.s_data left join tokenize on stopword.s_data = t_data left join case_folding on t_data = cf_data left join data_crawling on cf_data = dc_id WHERE stemmer.s_data NOT IN (SELECT k_stemmer FROM klasifikasi)";
        $testingResult = $con->query($testingData) or die (mysqli_error($con));

        while($testing = $testingResult->fetch_assoc()){
            foreach(explode('|', $testing['s_stemmer']) as $key => $glue){
                if(!in_array($glue, $words) && $testing['s_stemmer'] != ''){
                    array_push($words, $glue);
                }
            }

            array_push($dataTesting, [
                'idStem'    => $testing['s_data'],
                'idData'    => $testing['dc_id'],
                'stemmer'   => $testing['s_stemmer'],
                'kelas'     => null,
                'inputan'   => $testing['dc_inputan']
            ]);
        };

    // menghitung hasil positif dan negatif
        foreach($pNegatif as $key => $positif){
            if($positif['kelasText'] == 'negatif' || $positif['kelasText'] == 'multi')
                $hasilNegatif[$key] = ($positif['count'] + 1) / ($negatifKeluar + count($words));
        }

        // echo json_encode($hasilNegatif);

        foreach($pPositif as $key => $positif){
            if($positif['kelasText'] == 'positif' || $positif['kelasText'] == 'multi')
                $hasilPositif[$key] = ($positif['count'] + 1) / ($positifKeluar + count($words));
        }

    // menghitung detail hasil data testing
        foreach($dataTesting as $key => $testing){
            foreach(explode('|', $testing['stemmer']) as $beta => $stem){
                if(array_key_exists($stem, $hasilPositif)){
                    $hasilTestingPositif[$key][$stem] = [
                        'value'  => $hasilPositif[$stem],
                        'text'   => $stem
                    ];
                }

                if(array_key_exists($stem, $hasilNegatif)){
                    $hasilTestingNegatif[$key][$stem] = [
                        'value'  => $hasilNegatif[$stem],
                        'text'   => $stem
                    ];
                }
            }
        }

        // echo json_encode($hasilTestingNegatif);

    // menghitung hasil akhir per data testing dan menyimpan di database
        foreach($dataTesting as $key => $testing){
            $nn = $totNegatif/$totTraning ; $np = $totPositif/$totTraning;

            // echo json_encode($hasilTestingNegatif);

            if(isset($hasilTestingPositif[$key])){
                foreach($hasilTestingPositif[$key] as $alpha => $positif){
                    $np += $positif['value'];
                }
            }

            if(isset($hasilTestingNegatif[$key])){
                foreach($hasilTestingNegatif[$key] as $beta => $negatif){
                    $nn += $negatif['value'];
                }
            }

            $ha = ($np > $nn) ? 'positif' : 'negatif';

            $query = 'insert into klasifikasi(k_stemmer, k_data, k_positif, k_negatif, k_hasil) values 
                        ('.$testing['idStem'].', '.$testing['idData'].', '.$np.', '.$nn.', "'.$ha.'")';
                        
            $execute = $con->query($query) or die (mysqli_error($con));
        }
    

    // echo json_encode($hasilTestingPositif);

    echo json_encode([
        'words'          => $words,
        'dataTraining'  => $dataTraining,
        'dataTesting'   => $dataTesting,
        'pPositif'      => $pPositif,
        'pNegatif'     => $pNegatif,
        'totTraining'   => $totTraning,
        'totPositif'    => $totPositif,
        'totNegatif'    => $totNegatif,
        'positifKeluar' => $positifKeluar,
        'negatifKeluar' => $negatifKeluar,
        'status'        => 'berhasil'
    ])
?>