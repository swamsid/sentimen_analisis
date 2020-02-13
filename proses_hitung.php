<?php
    session_start();
    include 'lib/connection.php';

    // inisialisai variabel
        $dataTraining = $dataTesting = $words = [];
        $wordCountable = [];

        $totPositif = $totNegatif = $totTraning = $positifKeluar = $negatifKeluar = 0;
        $hasilPositif = $hasilNegatif = $hasilTestingPositif = $hasilTestingNegatif = [];

    // proses mengambil data training sekaligus mengambil text potongan dari hasil stemmer
        $trainingData = "SELECT * FROM stemmer left join klasifikasi on s_data = k_stemmer  WHERE s_data IN (SELECT k_stemmer FROM klasifikasi)";
        $trainingResult = $con->query($trainingData) or die (mysqli_error($con));
        $a = 1;

        while($training = $trainingResult->fetch_assoc()){
            // echo $training['s_stemmer'];

            // if(!$training['s_stemmer'] == ""){
                foreach(explode('|', $training['s_stemmer']) as $key => $glue){
                    
                    $cek = "SELECT count(*) as counter from kamus_liu where kl_value ='".$glue."'";
                    $execute = $con->query($cek) or die (mysqli_error($con));

                    while($rest = $execute->fetch_assoc()){
                        // echo $rest['counter'];
                        if($rest['counter'] != '0'){
                            $pos = $neg = 0;

                            if($training['k_hasil'] == 'positif')
                                $pos += 1;
                            else
                                $neg += 1;

                            if(!in_array($glue, $words) && $training['s_stemmer'] != ''){
                                array_push($words, $glue);
                            }

                            if(!array_key_exists($glue, $wordCountable)){

                                $wordCountable[$glue] = [
                                    'value'             => $glue,
                                    'countPositif'      => $pos,
                                    'countNegatif'      => $neg,
                                    'kelasText'         => ''
                                ];
                            }else{
                                $wordCountable[$glue]['countPositif'] += $pos;
                                $wordCountable[$glue]['countNegatif'] += $neg;
                            }
                        }
                    }

                }



                if($training['k_hasil'] == 'positif'){
                    $totPositif += 1;
                }else{
                    $totNegatif += 1;
                }
            // }

            array_push($dataTraining, [
                'stemmer'       => $training['s_stemmer'],
                'kelas'         => $training['k_hasil'],
                'hasNegatif'    => 0,
                'hasPositif'    => 0
            ]);

            $totTraning += 1;
        };

    // proses mengambil data testing sekaligus mengambil text potongan dari hasil stemmer
        $trainingData = "SELECT * FROM stemmer left join stopword on stopword.s_data = stemmer.s_data left join tokenize on stopword.s_data = t_data left join case_folding on t_data = cf_data left join data_crawling on cf_data = dc_id WHERE stemmer.s_data NOT IN (SELECT k_stemmer FROM klasifikasi)";
        $trainingResult = $con->query($trainingData) or die (mysqli_error($con));

        while($training = $trainingResult->fetch_assoc()){
            // echo $training['s_stemmer'];

            if(!$training['s_stemmer'] == ""){
                foreach(explode('|', $training['s_stemmer']) as $key => $glue){                        
                    $cek = "SELECT count(*) as counter from kamus_liu where kl_value ='".$glue."'";
                    $execute = $con->query($cek) or die (mysqli_error($con));

                    while($rest = $execute->fetch_assoc()){
                        if($rest['counter'] != '0'){
                            if(!in_array($glue, $words) && $training['s_stemmer'] != ''){
                                array_push($words, $glue);
                            }

                            // if(!array_key_exists($glue, $wordCountable)){
                            //     $wordCountable[$glue] = [
                            //         'value'     => $glue,
                            //         'count'     => 1,
                            //         'kelasText' => ''
                            //     ];
                            // }else{
                            //     $wordCountable[$glue]['count'] += 1;
                            // }
                        }
                    }

                }
            }

            array_push($dataTesting, [
                'idStem'    => $training['s_data'],
                'idData'    => $training['dc_id'],
                'inputan'   => $training['dc_inputan'],
                'stemmer'   => $training['s_stemmer'],
                'kelas'     => null
            ]);
        };

    // proses menentukan kelas text
        foreach($wordCountable as $key => $word){
            $loop = 0;

            $cek = "SELECT * from kamus_liu where kl_value ='".$word["value"]."'";
            $execute = $con->query($cek) or die (mysqli_error($con));

            while($rest = $execute->fetch_assoc()){
                if($wordCountable[$key]['kelasText'] == ''){
                    $wordCountable[$key]['kelasText'] = $rest['kl_kelas'];

                    if($rest['kl_kelas'] == 'positif'){
                        $positifKeluar += $wordCountable[$key]['countPositif'];
                        // echo $wordCountable[$key]['value'].'<br/>';
                    }else{
                        $negatifKeluar += $wordCountable[$key]['countNegatif'];
                    }
                }else{
                    if($wordCountable[$key]['kelasText'] != $rest['kl_kelas']){
                        $wordCountable[$key]['kelasText'] == 'multi';
                    }
                }
            }

        }

    // menentukan kelas sebenarnya pada data training
        foreach($dataTraining as $key => $training){
            $bucketCek = [];
            foreach(explode('|', $training['stemmer']) as $alpha => $stem){
                if(!array_key_exists($stem, $bucketCek)){
                    $keyId = array_search($stem, array_column($wordCountable, 'value'));

                    if($keyId !== false){
                        if($wordCountable[$stem]['kelasText'] == 'positif'){
                            $dataTraining[$key]['hasPositif'] = 1;
                        }else if($wordCountable[$stem]['kelasText'] == 'negatif'){
                            $dataTraining[$key]['hasNegatif'] = 1;
                        }else{
                            $dataTraining[$key]['hasPositif'] = 1;
                            $dataTraining[$key]['hasNegatif'] = 1;
                        }

                        $bucketCek[$stem] = $stem;
                    }
                }
            }
        }

        // print_r($dataTraining);

    // proses hitung data testing
        foreach($wordCountable as $key => $wordCount){
            if($wordCount['kelasText'] == 'positif'){
                $hasilNegatif[$key] = (0 + 1) / ($negatifKeluar + count($words));
            }else{
                $hasilNegatif[$key] = ($wordCount['countNegatif'] + 1) / ($negatifKeluar + count($words));
            }
        }

        foreach($wordCountable as $key => $wordCount){
            if($wordCount['kelasText'] == 'negatif'){
                $hasilPositif[$key] = (0 + 1) / ($positifKeluar + count($words));
            }else{
                $hasilPositif[$key] = ($wordCount['countPositif'] + 1) / ($positifKeluar + count($words));
            }
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
                        
            // $execute = $con->query($query) or die (mysqli_error($con));
        }


    // echo json_encode($count($wordCountable));

    echo json_encode([
        'status'        => 'berhasil',
        'positifKeluar' => $positifKeluar,
        'negatifKeluar' => $negatifKeluar,
        'totTraining'   => $totTraning,
        'totPositif'    => $totPositif,
        'totNegatif'    => $totNegatif,
        'words'         => $words,
        'dataTraining'  => $dataTraining,
        'dataTesting'   => $dataTesting,
        'wordCountable' => $wordCountable
    ]);

?>