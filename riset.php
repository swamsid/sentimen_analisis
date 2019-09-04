<?php

	session_start();
	include 'lib/connection.php';
    include 'plugins/tokenizer-master/tokenize.php';
    include 'plugins/sastrawi-master/stopword.php';
    include 'plugins/sastrawi-master/stemmer.php';

	$sql = "SELECT * FROM data_crawling";
    $result = $con->query($sql) or die (mysqli_error($con));
    $dataTesting = [];
    $casefolding = $tokenize = $filtering = $stemming = [];

    $res2 = $con->query($sql) or die (mysqli_error($con));
    $count = count($res2->fetch_all());

    $training = number_format(0.8 * $count);
    $testing = $count - $training;

    while($row = $result->fetch_assoc()){
    	array_push($dataTesting, $row['dc_inputan']);
    	array_push($casefolding, strtolower($row['dc_inputan']));
    	array_push($tokenize, tokenize(strtolower($row['dc_inputan'])));
    	array_push($filtering, tokenize(stopword(strtolower($row['dc_inputan']))));
    	array_push($stemming, tokenize(stopword(stemmer($row['dc_inputan']))));
    }

    $hasil = []; 

    foreach($stemming as $key => $data){

    	$sqlCek = "SELECT * FROM kamus_liu where text = '".$data[0]."'";
    	$resultCek = $con->query($sqlCek) or die (mysqli_error($con));
    	$countCek = count($resultCek->fetch_all());

    	// print $data[0].' = '.$countCek;

    	if($countCek > 0){

    		array_push($hasil, $data[0]);
    	}

    	// print json_encode($data);
    }

    print json_encode($hasil)

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Cek</title>

		<style type="text/css">
			#mytable{
				width: 100%;
				border-collapse: collapse;
			}

			#mytable th{
				border: 1px solid #ddd;
				padding: 5px 0px;
			}

			#mytable td{
				border: 1px solid #ddd;
				text-align: center;
				padding: 5px 0px;
			}
		</style>
	</head>
	<body>

		<div style="width: 1000px; overflow-y: scroll;">
			<table id="mytable">
				<tr>
					<th>No</th>
					<?php
						foreach($hasil as $key => $val) {
					?>
							<th><?php echo $val; ?></th>
					<?php
						}
					?>
				</tr>

					<?php
						foreach($stemming as $key => $val) {
					?>
							<tr>
								<td>No <?= $key+1; ?></td>
								<?php

									$bg = "";

									if(($key+1) <= 25){
										$bg = "rgba(255, 0, 0, 0.3)";
									}

									foreach($hasil as $key => $vel) {
										$rest = 0;
										if(in_array($vel, $val)){
											$rest = 1;
										}

								?>
									<td style="background: <?= $bg ?>"><?= $rest; ?></td>
								<?php
									}
								?>
							</tr>
					<?php
						}
					?>
			</table>
		</div>

	</body>
</html>