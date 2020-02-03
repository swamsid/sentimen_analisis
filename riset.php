<?php

	session_start();
	include 'lib/connection.php';

	function get_html($url){
		// persiapkan curl
		$ch = curl_init(); 

		// set url 
		curl_setopt($ch, CURLOPT_URL, $url);

		// return the transfer as a string 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

		// $output contains the output string 
		$output = curl_exec($ch); 

		// tutup curl 
		curl_close($ch);      

		// menampilkan hasil curl
		return $output;
	}

	// curl detik com
		$html = get_html('https://www.detik.com/search/searchall?query=indihome&siteid=2');
		$dom = new DomDocument();

		@$dom->loadHTML($html);

		$classname  = "list-berita";
		$finder 	= new DomXPath($dom);
		$spaner 	= $finder->query("//*[contains(@class, '$classname')]");
		$span 		= $spaner->item(0);
		$articles 	=  $span->getElementsByTagName('article');

		// print_r($article->item(1));

		$data = []; $loop = 0;

		foreach ($articles as $key => $article) {

			$input 	= $article->getElementsByTagName('h2');
			$tgl 	= $article->getElementsByTagName('span');
			$link 	= $article->getElementsByTagName('a');

			$explode 		= explode(' ', $tgl->item(3)->nodeValue);
			$linkExplode 	= explode('/', $link->item(0)->attributes[0]->value);

			array_push($data, [
				'input'     => mysqli_real_escape_string($con, trim($input->item(0)->nodeValue)),
				'tgl'       => mysqli_real_escape_string($con, preg_replace('/\s+/', ' ', $explode[1].' '.$explode[2].' '.$explode[3])),
				'author'    => mysqli_real_escape_string($con, 'Detik Inet'),
				'link'      => mysqli_real_escape_string($con, $link->item(0)->attributes[0]->value),
				'sumber'    => mysqli_real_escape_string($con, 'detik.com'),
				'id_post'   => 'Dc'.$linkExplode[4]
			]);
			
		}

		print_r($data);
?>