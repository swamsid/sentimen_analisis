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

                    $h2 =  $child->getElementsByTagName('h2');
                    $tgl =  $child->getElementsByTagName('time');
                    $author =  $child->getElementsByTagName('span');

                    $link = $h2->item(0)->getElementsByTagName('a');

                    // print_r($link->item(0));

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
                            'link'      => mysqli_real_escape_string($con, $link->item(0)->attributes[0]->nodeValue),
                            'sumber'    => mysqli_real_escape_string($con, 'mediakonsumen.com'),
                            'id_post'   => 'Mk'.$dd->attributes[0]->nodeValue
                        ]);
                    }

                    $loop++;
                }
                
            }

            // print_r($data);
            

        // curl Twitter
            $html = get_html('https://twitter.com/search?f=live&q=indihome%20since%3A2019-01-01%20until%3A2020-12-30&src=typed_query');
            $dom = new DomDocument();

            // echo $html;

            @$dom->loadHTML($html);

            $classname="js-stream-item";
            $finder = new DomXPath($dom);
            $spaner = $finder->query("//*[contains(@class, '$classname')]");

            $spaner2 = $finder->query("//*[contains(@class, 'stream-item-header')]");
            $span = $spaner->item(0);
            $authors = []; $tgl = []; $ids = []; $loop = 0;

            // print_r($span->childNodes[2]);

            foreach ($spaner as $key => $dd) {
                $child = $spaner2->item(20);

                // print_r($dd);

                $author = $dd->getElementsByTagName('b');
                $tgls = $dd->getElementsByTagName('span');

                if($author->item(0)){
                    array_push($authors, $author->item(0)->nodeValue);
                }

                if($tgls->item(5)){
                    array_push($tgl, $tgls->item(5)->nodeValue);
                }

                array_push($ids, $dd->attributes[1]->nodeValue);
                
                $loop++;
            }

            // echo $loop;

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
                    'author'    => mysqli_real_escape_string($con, '@'.$authors[$key]),
                    'link'      => mysqli_real_escape_string($con, 'https://twitter.com/'.$authors[$key].'/status/'.$ids[$key]),
                    'sumber'    => mysqli_real_escape_string($con, 'twitter.com'),
                    'id_post'   => 'Tw-'.mysqli_real_escape_string($con, $ids[$key]),
                ]);
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

            $loop = 0;

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

        // $queryCek = "select * from data_crawling";
        // $excuteOne = $con->query($queryCek) or die (mysqli_error($con));
        
        // $postId = []; $dataReturned = []; $trigered = false;
        
        // while($row = $excuteOne->fetch_assoc()){
        //     array_push($postId, $row['dc_post_id']);
        // }

        // $query = 'insert into data_crawling(dc_post_id, dc_author, dc_tanggal, dc_link, dc_sumber, dc_inputan, created_at) values ';

        // foreach ($data as $key => $dts) {
        //     if(!in_array($dts['id_post'], $postId)){
        //         $trigered = true;
        //         array_push($dataReturned, $dts);
        //         $query .= '("'.$dts['id_post'].'", "'.$dts['author'].'", "'.$dts['tgl'].'", "'.$dts['link'].'", "'.$dts['sumber'].'", "'.$dts['input'].'", "'.date('Y-m-d H:i:s').'"),';
        //     } 
        // }

        // $qryVal = rtrim($query, ',');

        // if($trigered)
        //     $excute = $result = $con->query($qryVal.'; ') or die (mysqli_error($con));
        
        // echo json_encode([
        //     'status'    => 'berhasil',
        //     'text'      => 'Data Berhasil Diambil',
        //     'data'      => $dataReturned
        // ]);

        // return true;

    }catch(Exception $e){
        echo json_encode([
            'status'    => 'error',
            'text'      => 'Data error, gagal ketika diambil '.$e
        ]);

        return false;
    }

?>