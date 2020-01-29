<?php

	$dictionaryFile = 'plugins/sastrawi-master/data/kata-dasar.txt';

	$word = 'menekankan';
	$arrayKataDasar = explode(PHP_EOL, file_get_contents($dictionaryFile));

	echo json_encode($arrayKataDasar);

?>