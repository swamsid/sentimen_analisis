<?php
    session_start();
    include 'lib/connection.php';
    include 'plugins/tokenizer-master/tokenize.php';
    include 'plugins/sastrawi-master/stopword.php';
    include 'plugins/sastrawi-master/stemmer.php';

    $sql = "SELECT * FROM data_crawling WHERE dc_id NOT IN (SELECT cf_data FROM case_folding)";

    try{

        $result = $con->query($sql) or die (mysqli_error($con));
        $check = 0;

        while($row = $result->fetch_assoc()){
            $false = false;

            $caseFolding = strtolower($row['dc_inputan']);
            $tokenize = tokenize($caseFolding);
            $stopword = tokenize(stopword(strtolower($caseFolding)));
            $stemmer = tokenize(stopword(stemmer($caseFolding)));

            $sqlCaseFolding = "insert into case_folding (cf_data, cf_case_folding) values (".$row['dc_id'].", '".$caseFolding."')";
            $sqlTokenizing = "insert into tokenize (t_data, t_tokenize) values (".$row['dc_id'].", '".implode('|', $tokenize)."')";
            $sqlStopword = "insert into stopword (s_data, s_stopword) values (".$row['dc_id'].", '".implode('|', $stopword)."')";
            $sqlStemmer = "insert into stemmer (s_data, s_stemmer) values (".$row['dc_id'].", '".implode('|', $stemmer)."')";

            if($excute1 = $con->query($sqlCaseFolding) or die (mysqli_error($con))){
                // $check++;
            }else{
                $sqlDeleteCaseFolding = "delete from case_folding where cf_data = ".$row['dc_id'];

                $con->query($sqlDeleteCaseFolding) or die (mysqli_error($con));
                $false = true;
            }

            if($excute2 = $con->query($sqlTokenizing) or die (mysqli_error($con))){
                // $check++;
            }else{
                $sqlDeleteTokenizing = "delete from tokenize where t_data = ".$row['dc_id'];

                $con->query($sqlDeleteTokenizing) or die (mysqli_error($con));
                $false = true;
            }

            if($excute3 = $con->query($sqlStopword) or die (mysqli_error($con))){
                // $check++;
            }else{
                $sqlDeleteStopword = "delete from stopword where s_data = ".$row['dc_id'];

                $con->query($sqlDeleteStopword) or die (mysqli_error($con));
                $false = true;
            }

            if($excute4 = $con->query($sqlStemmer) or die (mysqli_error($con)) ){
                // $check++;
            }else{
                $sqlDeleteStemmer = "delete from stemmer where s_data = ".$row['dc_id'];

                $con->query($sqlDeleteStemmer) or die (mysqli_error($con));
                $false = true;
            }
            
            if(!$false){
                $check++;
            }
        }

        echo json_encode([
            'status'    => 'berhasil',
            'text'      => 'Data berhasil di ekstrasi..',
            'counter'   => $check
        ]);

    }catch(Exception $e){
        echo json_encode([
            'status'    => 'error',
            'text'      => 'Data error, gagal ketika diambil '.$e
        ]);

        return false;
    }

?>