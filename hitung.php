<?php
    session_start();
    include 'lib/connection.php';

    $allData = "SELECT count(*) from data_crawling";
    $allResult = $con->query($allData) or die (mysqli_error($con));
    $all = $allResult->fetch_array();

    $trainingData = "SELECT COUNT(*) FROM data_crawling WHERE dc_id IN (SELECT k_data FROM klasifikasi)";
    $trainingResult = $con->query($trainingData) or die (mysqli_error($con));
    $training = $trainingResult->fetch_array();
    
    $testing = $all[0] - $training[0];
    
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Dashboard v.4</title>

    <?php include 'pages/_partials/_head.php' ?>
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <style>
        .my-table{
            width: 100%;
            font-size: 8pt;
        }

        .my-table th{
            text-align: center;
            padding: 5px;
            background: #eee;
            border: 1px solid #ddd;
        }

        .my-table td{
            padding: 5px;
            border: 1px solid #ddd;
        }

        .my-table tfoot td{
            background: #eee;
        }
    </style>

</head>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        
            <?php include 'pages/_partials/_nav.php' ?>

            <div class="wrapper wrapper-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12" style="padding: 0px;">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Lakukan perhitungan klasifikasi</h5>
                                    </div>
                                    <div class="ibox-content" style="min-height: 450px;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <table width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="75%" class="text-center">Total Seluruh Data</th>
                                                            <th width="5%">:</th>
                                                            <th class="text-right">
                                                                <label class="label label-danger"><?= $all[0]; ?></label>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="col-md-4" style="border-left: 1px dashed #ccc;">
                                                <table width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="75%" class="text-center">Data untuk training</th>
                                                            <th width="5%">:</th>
                                                            <th class="text-right">
                                                                <label class="label label-danger"><?= $training[0]; ?></label>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="col-md-4" style="border-left: 1px dashed #ccc;">
                                                <table width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="75%" class="text-center">Data yang di testing</th>
                                                            <th width="5%">:</th>
                                                            <th class="text-right">
                                                                <label class="label label-danger"><?= $testing; ?></label>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row m-t">
                                            <div class="col-md-12 text-center" style="border-top: 1px dashed #ccc; padding-top: 40px;">
                                                <div id="loading" style="display: none; padding-bottom: 50px;">
                                                    <div class="spiner-example">
                                                        <div class="sk-spinner sk-spinner-wave">
                                                            <div class="sk-rect1"></div>
                                                            <div class="sk-rect2"></div>
                                                            <div class="sk-rect3"></div>
                                                            <div class="sk-rect4"></div>
                                                            <div class="sk-rect5"></div>
                                                        </div>
                                                    </div> <br/>

                                                    <div class="text-center" style="margin-top: -80px;">
                                                        <span id="text-loading">Sedang melakukan perhitungan. Harap Tunggu ....</span>
                                                    </div>
                                                </div>

                                                <div id="button">
                                                    <button class="btn btn-success btn-sm" <?php echo ($testing == 0) ? 'disabled' : '' ?> style="margin-bottom: 20px;" id="proses">Mulai lakukan perhitungan</button> <br>
                                                    
                                                    <?php
                                                        if($testing == 0)
                                                            echo '<span class="text-muted">Tidak ada data testing, sehingga tidak bisa melakukan perhitungan.</span>';
                                                    ?>
                                                </div>

                                                <div id="result" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="label label-primary">Perhitungan Berhasil . Berikut adalah hasil yang didapat .</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 text-left">
                                                            <h3>Tabel Data Master</h3>
                                                        </div>
                                                        <div class="col-md-12 text-left" style="margin-top: 5px; margin-bottom: 20px; max-width: 100%; max-height: 500px; overflow: scroll;">
                                                            <table class="my-table">
                                                                <thead id="tabel-master-head">
                                                                
                                                                </thead>

                                                                <tbody id="tabel-master-body">

                                                                </tbody>

                                                                <tfoot id="tabel-master-footer"></tfoot>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="row m-t-lg">
                                                        <div class="col-md-6 text-left">
                                                            <h3>Tabel Data Training Positif</h3>
                                                        </div>
                                                        <div class="col-md-6 text-left">
                                                            <h3>Proses Perhitungan Data Positif</h3>
                                                        </div>
                                                        <div class="col-md-6 text-left" style="margin-top: 5px; margin-bottom: 20px; max-width: 100%; max-height: 500px; overflow: scroll;">
                                                            <table class="my-table">
                                                                <thead id="tabel-positif-head">
                                                                
                                                                </thead>

                                                                <tbody id="tabel-positif-body">
                                                                
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6" style="margin-top: 5px; margin-bottom: 20px; max-width: 100%; max-height: 500px; overflow: scroll;">
                                                            <pre id="hitung-positif" style="text-align: left; background: white;">
                                                            
                                                            </pre>
                                                        </div>
                                                    </div>

                                                    <div class="row m-t-lg">
                                                        <div class="col-md-6 text-left">
                                                            <h3>Tabel Data Training Negatif</h3>
                                                        </div>
                                                        <div class="col-md-6 text-left">
                                                            <h3>Proses Perhitungan Data Negatif</h3>
                                                        </div>
                                                        <div class="col-md-6 text-left" style="margin-top: 5px; margin-bottom: 20px; max-width: 100%; max-height: 500px; overflow: scroll;">
                                                            <table class="my-table">
                                                                <thead id="tabel-negatif-head">
                                                                
                                                                </thead>

                                                                <tbody id="tabel-negatif-body">
                                                                
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6" style="margin-top: 5px; margin-bottom: 20px; max-width: 100%; max-height: 500px; overflow: scroll;">
                                                            <pre id="hitung-negatif" style="text-align: left; background: white;">
                                                            
                                                            </pre>
                                                        </div>
                                                    </div>

                                                    <div class="row m-t-lg">
                                                        <div class="col-md-12 text-left">
                                                            <h3>Hasil Perhitungan Testing</h3>
                                                        </div>
                                                        <div class="col-md-12 text-left" style="margin-top: 5px;" id="hasil-testing">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ibox-footer">
                                        <div class="row text-center">
                                            <small class="text-muted">Data rekap hitungan disini hanya bisa ditampilkan 1 (satu) kali.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </row>
                </div>

            </div>

            <div class="footer">
                <div class="pull-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company &copy; 2014-2015
                </div>
            </div>

        </div>
    </div>

    <?php include 'pages/_partials/_script.php' ?>
    <script src="js/plugins/axios/dist/axios.min.js"></script>

    <script type="text/javascript">
        var hasilPositif = new Object; var hasilNegatif = new Object();
        var nilaiPositif = 0; var nilaiNegatif = 0;
        var hasilTestingPositif = new Object(); var hasilTestingNegatif = new Object();

        $(document).ready(function(){
            $('#proses').click(function(evt){
                evt.preventDefault();
                $('#button').fadeOut(100);

                setTimeout(() => {
                    $('#loading').fadeIn();
                    axios.get('proses_hitung.php')
                            .then((resp) => {

                                console.log(resp.data);

                                if(resp.data.status == 'berhasil'){
                                    $('#loading').fadeOut(100);

                                        generateTabelMaster(resp.data.words, resp.data.dataTraining, resp.data.dataTesting);
                                        
                                        generateTabelpositifHead(resp.data.dataTraining, resp.data.wordCountable);
                                        generateTabelNegatifHead(resp.data.dataTraining, resp.data.wordCountable);
                                        generateHitungPositif(resp.data.totTraining, resp.data.totPositif, resp.data.wordCountable, resp.data.positifKeluar, resp.data.words);
                                        generateHitungNegatif(resp.data.totTraining, resp.data.totNegatif, resp.data.wordCountable, resp.data.negatifKeluar, resp.data.words);
                                        hitungTesting(resp.data.dataTesting);
                                        generateTableTesting(resp.data.dataTesting);

                                    setTimeout(function(ert){
                                        $('#result').fadeIn(200);
                                    }, 1000)
                                }else{
                                    alert(resp.data.text);
                                }
                            }).catch((err) => {
                                alert('terjadi kesalahan sistem '+err);
                            })

                }, 100);
            })
        })

        // fungsi untuk generate tabel master
            function generateTabelMaster(words, training, testing){

                // generate head
                    let id = 1;
                    let html = '<tr>'+
                                    '<th width="10%">##</th>';

                    let htmlBody = '';

                    $.each(training, function(idx, data){
                        html += '<th> doc '+(id)+'</th>'

                        id++;
                    });

                    $.each(testing, function(idx, data){
                        html += '<th> doc '+(id)+'</th>'

                        id++;
                    });

                    html += '</tr>';

                    $('#tabel-master-head').append(html);

                // generate Body
                    $.each(words, function(idx, data){
                        htmlBody += '<tr>'+
                                        '<td>'+data+'</td>';

                        $.each(training, function(alpha, train){
                            let stemmer = train.stemmer.split('|');
                            let counter = 0;

                            $.each(stemmer, function(beta, stem){
                                if(stem == data){
                                    counter += 1;
                                }
                            })

                            let styles = (counter > 0) ? 'background: rgba(0, 255, 0, 0.2); font-weight: bold;' : '';

                            htmlBody += '<td class="text-center" style="'+styles+'">'+counter+'</td>';
                        })

                        $.each(testing, function(alpha, train){
                            let stemmer = train.stemmer.split('|');
                            let counter = 0;

                            $.each(stemmer, function(beta, stem){
                                if(stem == data){
                                    counter += 1;
                                }
                            })

                            let styles = (counter > 0) ? 'background: rgba(0, 255, 0, 0.2); font-weight: bold;' : '';

                            htmlBody += '<td class="text-center" style="'+styles+'">'+counter+'</td>';
                        })

                        htmlBody += '</tr>';

                    });

                    htmlFooter = '<tr>'+
                                    '<td class="text-center">Kelas</td>';

                    $.each(training, function(alpha, train){
                        htmlFooter += '<td class="text-center">'+train.kelas+'</td>';
                    })

                    $.each(testing, function(alpha, train){
                        htmlFooter += '<td class="text-center">???</td>';
                    })

                    $('#tabel-master-body').append(htmlBody);
                    $('#tabel-master-footer').append(htmlFooter);
            }

        // fungsi untuk generate tabel positif
            function generateTabelpositifHead(training, pPositif){
                // generate head
                    let id = 1;
                    let html = '<tr>'+
                                    '<th width="30%">##</th>';

                    let htmlBody = '';

                    $.each(training, function(idx, data){
                        if(data.kelas == 'positif'){
                            html += '<th> doc '+(id)+'</th>';
                        }

                        id++;
                    });

                    html += '</tr>';

                    $('#tabel-positif-head').append(html);

                // generate Body
                    $.each(pPositif, function(idx, positif){
                        // if(positif.kelasText == 'positif' || positif.kelasText == 'multi'){
                            htmlBody += '<tr>'+
                                    '<td>'+positif.value+'</td>';

                            $.each(training, function(alpha, train){
                                if(train.kelas == 'positif'){
                                    let stemmer = train.stemmer.split('|');
                                    let counter = 0;

                                    $.each(stemmer, function(beta, stem){
                                        if(stem == positif.value && positif.kelasText == 'positif'){
                                            counter += 1;
                                        }
                                    })

                                    let styles = (counter > 0) ? 'background: rgba(0, 255, 0, 0.2); font-weight: bold;' : '';

                                    htmlBody += '<td class="text-center" style="'+styles+'">'+counter+'</td>';
                                }
                            })
                        // }
                    });

                    htmlBody += '</tr>';

                    $('#tabel-positif-body').append(htmlBody);
            }

            function generateHitungPositif(totTraining, totPositif, pPositif, positifKeluar, words){
                let html = '';

                html += "P('positif')    = "+totPositif+'/'+totTraining+' = '+totPositif/totTraining;
                nilaiPositif = totPositif/totTraining;
                html += '\n\n';

                $.each(pPositif, function(idx, positif){
                    if(positif.kelasText == 'positif' || positif.kelasText == 'multi'){
                        $counter = positif.countPositif;
                    }else{
                        $counter = 0;
                    }

                    html += '   P ('+positif.value+' | Positif)';

                    html += ' = ('+$counter+' + 1) / '+positifKeluar+' + |'+words.length+'|';

                    html += ' = '+($counter + 1) / (positifKeluar + words.length);

                    html += '\n';

                    hasilPositif[idx] = ($counter + 1) / (positifKeluar + words.length);
                })

                // console.log(hasilPositif);

                $('#hitung-positif').html(html);
            }

        // fungsi untuk generate tabel negatif
            function generateTabelNegatifHead(training, pNegatif){
                // generate head
                    let id = 1;
                        let html = '<tr>'+
                                        '<th width="30%">##</th>';

                        let htmlBody = '';

                        $.each(training, function(idx, data){
                            if(data.kelas == 'negatif'){
                                html += '<th> doc '+(id)+'</th>';
                            }

                            id++;
                        });

                        html += '</tr>';

                        $('#tabel-negatif-head').append(html);

                // generate Body
                    $.each(pNegatif, function(idx, negatif){
                        // if(negatif.kelasText == 'negatif' || negatif.kelasText == 'multi'){
                            htmlBody += '<tr>'+
                                    '<td>'+negatif.value+'</td>';

                            $.each(training, function(alpha, train){
                                if(train.kelas == 'negatif'){
                                    let stemmer = train.stemmer.split('|');
                                    let counter = 0;

                                    $.each(stemmer, function(beta, stem){
                                        if(stem == negatif.value && negatif.kelasText == 'negatif'){
                                            counter += 1;
                                        }
                                    })

                                    let styles = (counter > 0) ? 'background: rgba(0, 255, 0, 0.2); font-weight: bold;' : '';

                                    htmlBody += '<td class="text-center" style="'+styles+'">'+counter+'</td>';
                                }
                            })
                        // }
                    });

                    htmlBody += '</tr>';

                    $('#tabel-negatif-body').append(htmlBody);
            }

            function generateHitungNegatif(totTraining, totNegatif, pNegatif, negatifKeluar, words){
                let html = '';

                html += "P('negatif')    = "+totNegatif+'/'+totTraining+' = '+totNegatif/totTraining;
                nilaiNegatif = totNegatif/totTraining;
                html += '\n\n';

                $.each(pNegatif, function(idx, negatif){
                    if(negatif.kelasText == 'negatif' || negatif.kelasText == 'multi'){
                        $counter = negatif.countNegatif;
                    }else{
                        $counter = 0;
                    }

                    html += '  P ('+negatif.value+' | negatif)';

                    html += ' = ('+$counter+' + 1) / '+negatifKeluar+' + |'+words.length+'|';

                    html += ' = '+($counter + 1) / (negatifKeluar + words.length);

                    html += '\n';

                    hasilNegatif[idx] = ($counter + 1) / (negatifKeluar + words.length);
                })

                // console.log(hasilNegatif);

                $('#hitung-negatif').html(html);
            }

        // function menghitung data testing
            function hitungTesting(dataTesting){
                $.each(dataTesting, function(idx, testing){
                    hasilTestingPositif[idx] = new Object();
                    hasilTestingNegatif[idx] = new Object();

                    $.each(testing.stemmer.split('|'), function(alpha, stem){
                        if(hasilPositif[stem]){
                            hasilTestingPositif[idx][stem] = {
                                'value'  : hasilPositif[stem],
                                'text'   : stem
                            };
                        }

                        if(hasilNegatif[stem]){
                            hasilTestingNegatif[idx][stem] = {
                                'value'  : hasilNegatif[stem],
                                'text'   : stem
                            };
                        }
                    })
                })

                // console.log(hasilTestingNegatif);

            }

        // generate tabel testing
            function generateTableTesting(dataTesting){

                var html = '';

                $.each(dataTesting, function(idx, testing){
                    if(testing.stemmer != ""){
                        let np = nilaiPositif; let nn = nilaiNegatif;

                        html += '<div class="col-md-12">'+
                                    '<h5> - Dokumen Testing '+(idx + 1)+' &nbsp;<i class="fa fa-arrow-right"></i> &nbsp;<span class="text-navy">"'+testing.inputan+'"</span></h5>'
                                +'</div>';

                        html += '<div style="padding: 0px 15px; margin-top: 15px; margin-bottom: 25px;">'+
                                    '<table class="my-table">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>Hasil Stemming</th>'+
                                                '<th>Nilai Positif</th>'+
                                                '<th>Nilai Negatif</th>'+
                                                '<th>Kesimpulan</th>'+
                                            '</tr>'+
                                        '</thead>'+

                                        '<tbody>'+
                                            '<tr>'+
                                                '<td class="text-center">'+testing.stemmer+'</td>';

                        $.each(hasilTestingPositif[idx], function(alpha, positif){
                            np += positif.value;
                        });

                        $.each(hasilTestingNegatif[idx], function(alpha, negatif){
                            nn += negatif.value;
                        });

                        let kesimpulan = (np > nn) ? 'Positif' : 'Negatif';
                        let clas = (np > nn) ? 'text-success' : 'text-danger';

                        html += '<td class="text-center">'+np+'</td>'+
                                '<td class="text-center">'+nn+'</td>'+
                                '<td class="text-center '+clas+'" style="font-weight: bold;">'+kesimpulan+'</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                '</div>';
                    }
                })

                $('#hasil-testing').html(html);

            }
    </script>

</body>

</html>
