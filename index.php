<?php
    session_start();
    include 'lib/connection.php';

    if(!isset($_SESSION['login']))
        echo '<script> window.location = "login.php" </script>';

    $sql = "SELECT (SELECT COUNT(*) FROM klasifikasi WHERE k_hasil = 'positif') AS positif, (SELECT COUNT(*) FROM klasifikasi WHERE k_hasil = 'negatif') AS negatif";
    $result = $con->query($sql) or die (mysqli_error($con));
    $pie = $result->fetch_array();

    $total = $pie['positif'] + $pie['negatif'];
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Dashboard v.4</title>

    <?php include 'pages/_partials/_head.php' ?>

</head>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        
            <?php include 'pages/_partials/_nav.php' ?>

            <div class="wrapper wrapper-content">
                <div class="container">
                    <div class="row" style="margin-top: -20px;">
                        <div class="col-md-12">
                            <div class="alert alert-info text-center">
                                Jangan Lupa Untuk Memperbarui Data Terbaru. Terakhir diperbarui pada tanggal <b>19/01/2019</b>.<br/>
                                <a class="btn btn-primary btn-sm" href="#" style="margin-top: 15px;" id="generate">Perbarui Data Sekarang</a>.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5">
                            <div class="col-md-12" style="padding: 0px;">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                        <div>
                                            <span class="pull-right text-right">
                                                <!-- All sales: 162,862 -->
                                            </span>
                                            <h3 class="font-bold no-margins">
                                               Status Sentimen Positif / Negatif.
                                            </h3>
                                            <small>&nbsp;Berdasarkan Total <?= $total ?> Data</small>
                                        </div>

                                        <div class="m-t-sm">

                                            <div class="row">
                                                <div class="col-md-6" style="background: none">
                                                    <canvas id="pieChart" width="100%"></canvas>
                                                </div>
                                                <div class="col-md-6" style="background: none;">
                                                    <ul class="stat-list">
                                                        <li>
                                                            <h2 class="no-margins"><?= $pie['positif'] ?></h2>
                                                            <small>Total Data Positif</small>
                                                            <div class="progress progress-mini">
                                                                <div class="progress-bar" style="width: <?= ($pie['positif'] / $total) * 100 ?>%;"></div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <h2 class="no-margins "><?= $pie['negatif'] ?></h2>
                                                            <small>Total Data Negatif</small>
                                                            <div class="progress progress-mini">
                                                                <div class="progress-bar" style="width: <?= ($pie['negatif'] / $total) * 100 ?>%;"></div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="m-t-md">
                                            <small>
                                                <strong>Kesimpulan Analisa:</strong> 
                                                <?= ($pie['positif'] > $pie['negatif']) ? 'Penilaian pelanggan terhadap perusahaan rata-rata positif. Perusahaan harus mempertahankan atau meningkatkan agar lebih baik.' : 'Penilaian pelanggan terhadap perusahaan rata-rata negatif. Perusahaan perlu memperhatikan kinerjanya lebih teliti agar menjadi lebih baik.' ?>
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <span class="label label-warning pull-right">Data has changed</span>
                                        <h5>Trend Total Data Perbulan</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="row text-center">
                                            <div style="object-fit: scale-down; width: 100%; background: red; padding: 0px;">
                                                <img class="img img-responsive" src="world_cloud/demo/getimg.php"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <!-- <span class="label label-warning pull-right">Data has changed</span> -->
                                    <h5>Trend Total Data per 6 Bulan Terakhir</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-md-12" style="background: none;">
                                            <canvas id="lineChart" height="114"></canvas>
                                        </div>

                                        <!-- <div class="col-md-5" style="background: none;">
                                            <table width="100%" border="0" style="font-size: 8pt;">
                                                <thead>
                                                    <tr>
                                                        <td class="text-center" style="padding-top: 10px;">Nilai Negatif</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center" style="border-bottom: 1px solid #ddd; font-weight: 600;">80%</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="ibox-footer">
                                    <div class="row">
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

    <div class="modal inmodal" id="modalGenerate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="height: 550px;">
                    <div class="row" id="button-content">
                        <div class="col-md-12 text-center">
                            Apa anda yakin ingin melakukan perbaruan data sekarang ?
                        </div>

                        <div class="col-md-12 text-center m-t">
                            <button class="btn btn-primary btn-sm" id="confirm-generate">Ya, perbarui sekarang !</button> &nbsp; &nbsp;
                            <button class="btn btn-white btn-sm" data-dismiss="modal">Tidak, jangan dulu deh</button>
                        </div>
                    </div>

                    <div class="row" id="data-content" style="display: none;">
                        <div class="col-md-12">
                            <div id="loading">
                                <div class="spiner-example">
                                    <div class="sk-spinner sk-spinner-wave">
                                        <div class="sk-rect1"></div>
                                        <div class="sk-rect2"></div>
                                        <div class="sk-rect3"></div>
                                        <div class="sk-rect4"></div>
                                        <div class="sk-rect5"></div>
                                    </div>
                                </div> <br/>

                                <div class="text-center" style="margin-top: -40px;">
                                    <span id="text-loading">Sedang mengambil data terbaru. Harap Tunggu ....</span>
                                </div>
                            </div>
                            
                            <div id="result" style="display: none;">
                                <div class="row">
                                    <div class="alert alert-success">
                                        <b>Proses pengambilan data selesai</b>. Berikut adalah data yang berhasil diambil.
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12" style="height: 400px; overflow-y: scroll; border-bottom: 1px solid #eee; padding: 0px;">
                                        <table class="table table-bordered" style="font-size: 10pt;">
                                            <thead>
                                                <tr>
                                                    <th width="25%" class="text-center" style="position: sticky; top: 0;">kode data</th>
                                                    <th class="text-center" style="position: sticky; top: 0;">Nama</th>
                                                </tr>
                                            </thead>

                                            <tbody id="data-result"></tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-12 m-t text-right">
                                        <button class="btn btn-success btn-sm" id="ekstrasi">mulai ekstrasi data</button>
                                    </div>
                                </div>

                            </div>

                            <div id="result2" style="display: none;">
                                <div class="row">
                                    <div class="alert alert-success">
                                        <b>Proses ekstrasi data selesai</b>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 text-center" style="height: 100px; overflow-y: scroll; border-bottom: 1px solid #eee; padding: 0px;">
                                        <h1>Total <span id="counter">10</span> Data berhasil diekstrasi..</h1>
                                    </div>
                                    
                                    <div class="col-md-12 m-t text-right">
                                        <a href="crawling.php">
                                            <button class="btn btn-success btn-sm">Lihat Data</button>
                                        </a>
                                    </div>
                                </div>

                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'pages/_partials/_script.php' ?>

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/dist/chart.min.js"></script>
    <script src="js/plugins/chartJs/label/src/plugin.js"></script>
    <script src="js/plugins/axios/dist/axios.min.js"></script>

    <?php
        $bulanSekarang = date('Y-m').'-01';
        $bulanLalu = date('Y-m-d', strtotime('-5 month', strtotime($bulanSekarang)));
        $bulan = $data = [];

        while(strtotime($bulanSekarang) >= strtotime($bulanLalu)){
            $sql = "SELECT count(*) from data_crawling where DATE_FORMAT(created_at, '%m/%Y') = '".date('m/Y', strtotime($bulanLalu))."'";
            $result = $con->query($sql) or die (mysqli_error($con));
            $line = $result->fetch_array();
            array_push($data, $line[0]);
            array_push($bulan, date('m/Y', strtotime($bulanLalu)));

            $bulanLalu = date('Y-m-d', strtotime('+1 month', strtotime($bulanLalu)));
        }
    ?>

    <script>
        $(document).ready(function() {  

            var lineConfig = {
                type: 'line',
                data: {
                    labels: ['<?= $bulan[0] ?>', '<?= $bulan[1] ?>', '<?= $bulan[2] ?>', '<?= $bulan[3] ?>', '<?= $bulan[4] ?>', '<?= $bulan[5] ?>'],
                    datasets: [{
                        label: 'Unfilled',
                        fill: true,
                        backgroundColor: 'rgba(10, 9, 200, 0.3)',
                        borderColor: '#0099CC',
                        data: [<?= $data[0] ?>, <?= $data[1] ?>, <?= $data[2] ?>, <?= $data[3] ?>, <?= $data[4] ?>, <?= $data[5] ?>],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Line Chart'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Value'
                            },
                            ticks: {
                                min: 0,
                                max: 100,
                            }
                        }]
                    },
                }
            };

            var pieConfig = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [<?= $pie['positif'] ?>, <?= $pie['negatif'] ?>],
                        backgroundColor: [
                            '#00C851', '#ff4444'
                        ],
                        label: 'Dataset 1'
                    }],
                    labels: [
                        'Positif',
                        'Negatif',
                    ]
                },
                options: {
                    responsive:true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        enabled: false
                    },
                    plugins: {
                        labels: {
                            render: 'percentage',
                            fontColor: ['white', 'white',],
                            precision: 2
                        }
                    },
                    hover: {
                      onHover: function(e) {
                         var point = this.getElementAtEvent(e);
                         if (point.length) e.target.style.cursor = 'pointer';
                         else e.target.style.cursor = 'default';
                      }
                   }
                }
            };

            var lineChart = document.getElementById("lineChart").getContext("2d");
            var myLineChart = Chart.Line(lineChart, lineConfig);

            var pieChart = document.getElementById('pieChart').getContext('2d');
            var myPie = new Chart(pieChart, pieConfig);

            $('#pieChart').click(function(evt){
                var activePoints = myPie.getElementsAtEventForMode(evt, 'point', myPie.options);
                var firstPoint = activePoints[0];
                var label = myPie.data.labels[firstPoint._index];
                var value = myPie.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
                alert(label + ": " + value);
            });

            $('#generate').click(function(evt){
                evt.preventDefault();
                
                $('#text-loading').html('Sedang mengambil data terbaru. Harap Tunggu ....');
                $('#data-content').fadeOut(0);
                $('#result').fadeOut(0);
                $('#button-content').fadeIn(200);
                $('#loading').fadeIn(100);

                $('#modalGenerate').modal({backdrop: 'static', keyboard: false})
                $('#modalGenerate').modal('show');
            });

            $("#confirm-generate").click(function(){
                $('#button-content').fadeOut(200);

                setTimeout(function(alpha){
                    $('#data-content').fadeIn(200);

                    axios.get('curl.php')
                            .then((resp) => {

                                if(resp.data.status == 'berhasil'){
                                    $('#loading').fadeOut(100);
                                    
                                    let dataHtml = "";
                                    $.each(resp.data.data, function(index, data){
                                        dataHtml += '<tr>'+
                                                        '<td class="text-center">'+data.id_post+'</td>'+
                                                        '<td>'+data.input+'</td>'+
                                                    '</tr>';
                                    });

                                    if(!resp.data.data.length){
                                        dataHtml += '<tr>'+
                                                        '<td class="text-center text-muted" colspan="2"><small>Data sudah terupdate..</small></td>'+
                                                    '</tr>';
                                    }

                                    setTimeout(function(ert){
                                        $('#data-result').html(dataHtml)
                                        $('#result').fadeIn(200);
                                    }, 105)
                                }else{
                                    alert(resp.data.text);
                                }
                            }).catch((err) => {
                                alert('terjadi kesalahan sistem '+err);
                            })

                }, 205)
            })

            $('#ekstrasi').click(function(){
                $('#result').fadeOut(100);
                $('#text-loading').html('Sedang melakukan ekstrasi. Harap Tunggu ....')
                setTimeout(function(){
                    $('#loading').fadeIn(200);
                    axios.get('ekstrasi.php')
                            .then((resp) => {

                                // console.log(resp);

                                if(resp.data.status == 'berhasil'){
                                    $('#loading').fadeOut(100);

                                    setTimeout(function(ert){
                                        $('#counter').html(resp.data.counter)
                                        $('#result2').fadeIn(200);
                                    }, 150)
                                }else{
                                    alert(resp.data.text);
                                }
                            }).catch((err) => {
                                alert('terjadi kesalahan sistem '+err);
                            })
                }, 205)
            })

        });
    </script>

</body>

</html>
