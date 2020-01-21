<?php
require_once __DIR__ . '/vendor/autoload.php';

function tokenize(String $str){
	$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
	$tokenizer = $tokenizerFactory->createDefaultTokenizer();

	$tokens = $tokenizer->tokenize($str);

	$result = [];

	foreach($tokens as $id => $token){
		// echo ctype_punct('...') ? 'yaa' : 'bkan';
		if(!checkValidity($token) && !ctype_punct($token)){
			array_push($result, $token);
		}
	}
	
	return $result;
}

function checkValidity(String $str){
	$dictionary = [
		',', '.', ';', ':', '?', '!', '"', '(', ')', '\'',
        '[', ']', '+', '=', '*', '&', '^', '%', '$', '#',
        '@', '~', '`', '{', '}', '\\', '|', '>', '<', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
	];

	return in_array($str, $dictionary, true);
}
