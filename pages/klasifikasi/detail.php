<?php
    session_start();
    include '../../lib/connection.php';
    include '../../plugins/tokenizer-master/tokenize.php';
    include '../../plugins/sastrawi-master/stopword.php';
    include '../../plugins/sastrawi-master/stemmer.php';

    $sql = "SELECT * FROM klasifikasi join data_crawling on dc_id = k_data where k_data = ".$_GET['id'];
    $result = $con->query($sql) or die (mysqli_error($con));
    $row = $result->fetch_assoc();

    $tokenize = tokenize(strtolower($row['dc_inputan']));
    $stopword = tokenize(stopword(strtolower($row['dc_inputan'])));
    $stemmer = tokenize(stopword(stemmer($row['dc_inputan'])));

    // var_dump($tokenize);
?>


<div class="col-md-12" style="font-weight: bold; padding: 0px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Inputan Data
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
      <?= $row['dc_inputan'] ?>
 </div>

 <div class="col-md-12" style="font-weight: bold; padding: 0px; margin-top: 20px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Hasil Stemming
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
      <?= implode(' | ', $stemmer) ?>
 </div>

 <div class="col-md-12" style="font-weight: bold; padding: 0px; margin-top: 20px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Hasil Perhitungan Klasifikasi
 </div>

 <div class="col-md-12" style="font-weight: normal; padding: 8px 10px; margin-top: 8px;">
      <div class="row">
          <div class="col-md-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span> Nilai Positif </span>
                            <h2 class="font-bold"><?= (is_null($row['k_positif'])) ? 'null' : number_format($row['k_positif'], 4) ?></h2>
                        </div>
                    </div>
                </div>
          </div>

          <div class="col-md-4">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span> Nilai Negatif </span>
                            <h2 class="font-bold"><?= (is_null($row['k_negatif'])) ? 'null' : number_format($row['k_negatif'], 4) ?></h2>
                        </div>
                    </div>
                </div>
          </div>

          <div class="col-md-4">
                <div class="widget style1 blue-bg">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span> Hasil Akhir </span>
                            <h2 class="font-bold"><?= ($row['k_positif'] > $row['k_negatif']) ? 'Positif' : 'Negatif' ?></h2>
                        </div>
                    </div>
                </div>
          </div>
      </div>
 </div>