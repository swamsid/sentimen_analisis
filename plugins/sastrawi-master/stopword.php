<?php
require_once __DIR__ . '/vendor/autoload.php';

function stopword(String $str){
	$stopWordFactory  = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
	$stopWord = $stopWordFactory->createStopWordRemover();

	$words = $stopWord->remove($str);

	return $words;
}
