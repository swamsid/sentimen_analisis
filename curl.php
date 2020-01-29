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

    try{

        // curl media konsumen
            $html = get_html('https://mediakonsumen.com/?s=indihome#gsc.tab=0');
            $dom = new DomDocument();

            @$dom->loadHTML($html);

            $classname = "type-post";
            $finder = new DomXPath($dom);
            $spaner = $finder->query("//*[contains(@class, '$classname')]");
            $span = $spaner->item(8);

            $spaner2 = $finder->query("//*[contains(@class, 'article-content')]");
            $span2 = $spaner2->item(0);

            $data = []; $loop = 0;

            foreach ($spaner as $key => $dd) {
                // print_r($dd);
                if($dd->tagName == 'article'){
                    $child = $spaner2->item($loop);
                    $input = $tanggal = $auth = "Tidak Ada"; $links = "mediakonsumen.com";

                    $link =  $child->getElementsByTagName('h2');
                    $tgl =  $child->getElementsByTagName('time');
                    $author =  $child->getElementsByTagName('span');

                    if($link->item(0)){
                        // print_r($author->item());

                        $input = $link->item(0)->nodeValue;

                        if($tgl->item(0)){
                            $tgl = $tgl->item(0)->nodeValue;
                        }
                        if($author->item(1)){
                            $auth = $author->item(2)->nodeValue;
                        }

                        array_push($data, [
                            'input'     => mysqli_real_escape_string($con, trim($input)),
                            'tgl'       => mysqli_real_escape_string($con, preg_replace('/\s+/', ' ', $tgl)),
                            'author'    => mysqli_real_escape_string($con, $auth),
                            'link'      => mysqli_real_escape_string($con, $links),
                            'sumber'    => mysqli_real_escape_string($con, 'mediakonsumen.com'),
                            'id_post'   => 'Mk'.$dd->attributes[0]->nodeValue
                        ]);
                    }

                    $loop++;
                }
                
            }
            


        // // curl Twitter
        //     $html = get_html('https://twitter.com/search?f=live&q=indihome%20since%3A2019-01-01%20until%3A2019-05-31&src=typed_query');
        //     $dom = new DomDocument();

        //     // echo $html;

        //     @$dom->loadHTML($html);

        //     $classname="stream-item-header";
        //     $finder = new DomXPath($dom);
        //     $spaner = $finder->query("//*[contains(@class, '$classname')]");
        //     $span = $spaner->item(0);

        //     $authors = $tgl = [];

        //     foreach ($spaner as $key => $dd) {

        //         $author = $dd->getElementsByTagName('b');
        //         $tgls = $dd->getElementsByTagName('span');

        //         if($author->item(0)){
        //             array_push($authors, '@'.$author->item(0)->nodeValue);
        //         }

        //         if($tgls->item(5)){
        //             array_push($tgl, $tgls->item(5)->nodeValue);
        //         }
                

        //     }

        //     $classname="js-tweet-text-container";
        //     $finder = new DomXPath($dom);
        //     $spaner = $finder->query("//*[contains(@class, '$classname')]");
        //     $span = $spaner->item(0);

        //     $inputans = [];

        //     foreach ($spaner as $key => $dd) {

        //         $inputan = $dd->getElementsByTagName('p');

        //         if($inputan->item(0)){
        //             array_push($inputans, $inputan->item(0)->nodeValue);
        //         }

        //     }

        //     foreach ($inputans as $key => $value) {
        //         array_push($data, [
        //             'input'     => mysqli_real_escape_string($con, trim($value)),
        //             'tgl'       => mysqli_real_escape_string($con, preg_replace('/\s+/', ' ', $tgl[$key])),
        //             'author'    => mysqli_real_escape_string($con, $authors[$key]),
        //             'link'      => mysqli_real_escape_string($con, 'twitter.com'),
        //             'sumber'    => mysqli_real_escape_string($con, 'twitter.com'),
        //             'id_post'   => 'Tw'
        //         ]);
        //     }
        
        $queryCek = "select * from data_crawling";
        $excuteOne = $con->query($queryCek) or die (mysqli_error($con));
        
        $postId = []; $dataReturned = []; $trigered = false;
        
        while($row = $excuteOne->fetch_assoc()){
            array_push($postId, $row['dc_post_id']);
        }

        $query = 'insert into data_crawling(dc_post_id, dc_author, dc_tanggal, dc_link, dc_sumber, dc_inputan, created_at) values ';

        foreach ($data as $key => $dts) {
            if(!in_array($dts['id_post'], $postId)){
                $trigered = true;
                array_push($dataReturned, $dts);
                $query .= '("'.$dts['id_post'].'", "'.$dts['author'].'", "'.$dts['tgl'].'", "'.$dts['link'].'", "'.$dts['sumber'].'", "'.$dts['input'].'", "'.date('Y-m-d H:i:s').'"),';
            } 
        }

        $qryVal = rtrim($query, ',');

        if($trigered)
            $excute = $result = $con->query($qryVal.'; ') or die (mysqli_error($con));
        
        echo json_encode([
            'status'    => 'berhasil',
            'text'      => 'Data Berhasil Diambil',
            'data'      => $dataReturned
        ]);

        return true;

    }catch(Exception $e){
        echo json_encode([
            'status'    => 'error',
            'text'      => 'Data error, gagal ketika diambil '.$e
        ]);

        return false;
    }

?>