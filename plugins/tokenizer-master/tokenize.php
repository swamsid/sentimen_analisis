<?php
require_once __DIR__ . '/vendor/autoload.php';

function tokenize(String $str){
	$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
	$tokenizer = $tokenizerFactory->createDefaultTokenizer();

	$tokens = $tokenizer->tokenize($str);

	return $tokens;
}
