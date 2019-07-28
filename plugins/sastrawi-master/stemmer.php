<?php
require_once __DIR__ . '/vendor/autoload.php';

function stemmer(String $str){
	$stemmerFactory  = new \Sastrawi\Stemmer\StemmerFactory();
	$stemmer = $stemmerFactory->createStemmer();

	$words = $stemmer->stem($str);

	return $words;
}
