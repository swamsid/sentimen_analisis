 <?php
    session_start();
    include '../../lib/connection.php';

    $sql = "SELECT * FROM case_folding join data_crawling on dc_id = cf_data where cf_data = '".$_GET['id']."'";
    $result = $con->query($sql) or die (mysqli_error($con));
    $cf = $result->fetch_array();
 ?>
 
 <div class="col-md-12" style="font-weight: bold; padding: 0px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Hasil Case Folding
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
      <?= $cf['cf_case_folding'] ?>
 </div>

 <div class="col-md-12" style="font-weight: bold; padding: 0px; margin-top: 20px;">
     <i class="fa fa-arrow-right"></i> &nbsp;Inputan Data
 </div>

 <div class="col-md-12" style="font-weight: normal; background: white; padding: 8px 10px; margin-top: 8px; box-shadow: 0px 0px 5px #ddd;">
    <?= $cf['dc_inputan'] ?>
 </div>