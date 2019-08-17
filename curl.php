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


    $html = get_html('https://mediakonsumen.com/?s=indihome#gsc.tab=0');
    $dom = new DomDocument();

    @$dom->loadHTML($html);

    $classname = "article-content";
    $finder = new DomXPath($dom);
    $spaner = $finder->query("//*[contains(@class, '$classname')]");
    $span = $spaner->item(0);

    // var_dump($span->nodeValue);

    $data = [];

    foreach ($spaner as $key => $dd) {
        $input = $tanggal = $auth = "Tidak Ada"; $links = "mediakonsumen.com";

        $link =  $dd->getElementsByTagName('h2');
        $tgl =  $dd->getElementsByTagName('time');
        $author =  $dd->getElementsByTagName('span');

        if($link->item(0)){
            // var_dump($author->item(1)->nodeValue);

            $input = $link->item(0)->nodeValue;

            if($tgl->item(0)){
                $tgl = $tgl->item(0)->nodeValue;
            }
            if($author->item(1)){
                $auth = $author->item(1)->nodeValue;
            }

            array_push($data, [
                'input'     => mysqli_real_escape_string($con, trim($input)),
                'tgl'       => mysqli_real_escape_string($con, preg_replace('/\s+/', ' ', $tgl)),
                'author'    => mysqli_real_escape_string($con, $auth),
                'link'      => mysqli_real_escape_string($con, $links),
                'sumber'    => mysqli_real_escape_string($con, 'mediakonsumen.com')
            ]);
        }
    }

    $html = get_html('https://twitter.com/search?f=live&q=indihome%20since%3A2019-01-01%20until%3A2019-05-31&src=typed_query');
    $dom = new DomDocument();

    // echo $html;

    @$dom->loadHTML($html);

    $classname="stream-item-header";
    $finder = new DomXPath($dom);
    $spaner = $finder->query("//*[contains(@class, '$classname')]");
    $span = $spaner->item(0);

    $authors = $tgl = [];

    foreach ($spaner as $key => $dd) {

        $author = $dd->getElementsByTagName('b');
        $tgls = $dd->getElementsByTagName('span');

        if($author->item(0)){
            array_push($authors, '@'.$author->item(0)->nodeValue);
        }

        if($tgls->item(5)){
            array_push($tgl, $tgls->item(5)->nodeValue);
        }
        

    }

    $classname="js-tweet-text-container";
    $finder = new DomXPath($dom);
    $spaner = $finder->query("//*[contains(@class, '$classname')]");
    $span = $spaner->item(0);

    $inputans = [];

    foreach ($spaner as $key => $dd) {

        $inputan = $dd->getElementsByTagName('p');

        if($inputan->item(0)){
            array_push($inputans, $inputan->item(0)->nodeValue);
        }

    }

    foreach ($inputans as $key => $value) {
        array_push($data, [
            'input'     => mysqli_real_escape_string($con, trim($value)),
            'tgl'       => mysqli_real_escape_string($con, preg_replace('/\s+/', ' ', $tgl[$key])),
            'author'    => mysqli_real_escape_string($con, $authors[$key]),
            'link'      => mysqli_real_escape_string($con, 'twitter.com'),
            'sumber'    => mysqli_real_escape_string($con, 'twitter.com')
        ]);
    }

    // echo json_encode($data);

    $trct = 'TRUNCATE data_crawling;';
    $exe = $result = $con->query($trct) or die (mysqli_error($con));

    $query = 'insert into data_crawling(dc_id, dc_author, dc_tanggal, dc_link, dc_sumber, dc_inputan) values ';

    foreach ($data as $key => $dts) {
        $query .= '("'.($key+1).'", "'.$dts['author'].'", "'.$dts['tgl'].'", "'.$dts['link'].'", "'.$dts['sumber'].'", "'.$dts['input'].'"),';
    }

    $qryVal = rtrim($query, ',');
    $excute = $result = $con->query($qryVal.'; ') or die (mysqli_error($con));
    
    echo 'Berhasil Ditambahkan Ke Database';

?>