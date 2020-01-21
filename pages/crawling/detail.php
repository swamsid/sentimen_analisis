<?php
    session_start();
    include '../../lib/connection.php';
    include '../../plugins/tokenizer-master/tokenize.php';
    include '../../plugins/sastrawi-master/stopword.php';
    include '../../plugins/sastrawi-master/stemmer.php';

    $sql = "SELECT * FROM data_crawling where dc_id = ".$_GET['id'];
    $result = $con->query($sql) or die (mysqli_error($con));
    $row = $result->fetch_assoc();

    $tokenize = tokenize(strtolower($row['dc_inputan']));
    $stopword = tokenize(stopword(strtolower($row['dc_inputan'])));
    $stemmer = tokenize(stopword(stemmer(strtolower($row['dc_inputan']))));

    // var_dump($tokenize);
?>


<div class="col-md-12" style="font-weight: bold; padding: 0px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Inputan Data
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
      <?= $row['dc_inputan'] ?>
 </div>

 <div class="col-md-12" style="font-weight: bold; padding: 0px; margin-top: 20px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Hasil Case Folding
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
      <?= strtolower($row['dc_inputan']) ?>
 </div>

 <div class="col-md-12" style="font-weight: bold; padding: 0px; margin-top: 20px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Hasil Tokenizing
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
      <?= implode(' | ', $tokenize) ?>
 </div>

 <div class="col-md-12" style="font-weight: bold; padding: 0px; margin-top: 20px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Hasil Filtering
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
      <?= implode(' | ', $stopword) ?>
 </div>

 <div class="col-md-12" style="font-weight: bold; padding: 0px; margin-top: 20px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Hasil Stemming
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
      <?= implode(' | ', $stemmer) ?>
 </div>