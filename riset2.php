<?php
	function bacaHTML($url){
	// inisialisasi CURL
	$data = curl_init();
	// setting CURL
	curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($data, CURLOPT_URL, $url);
	// menjalankan CURL untuk membaca isi file
	$hasil = curl_exec($data);
	curl_close($data);
	return $hasil;
	}
								
	$kodeHTML =  bacaHTML('https://mediakonsumen.com/?s=indihome#gsc.tab=0');
    $pecah = explode('<article', $kodeHTML);
    $pecahlagi = explode('</article>', $pecah[0]);
    
    print_r($pecah);
?>