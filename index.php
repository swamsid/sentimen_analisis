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
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="col-md-12" style="padding: 0px;">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                        <div>
                                            <span class="pull-right text-right">
                                                All sales: 162,862
                                            </span>
                                            <h3 class="font-bold no-margins">
                                               Status Sentimen Positif / Negatif.
                                            </h3>
                                            <small>&nbsp;Berdasarkan Total 4920 Data</small>
                                        </div>

                                        <div class="m-t-sm">

                                            <div class="row">
                                                <div class="col-md-6" style="background: none">
                                                    <canvas id="pieChart" width="100%"></canvas>
                                                </div>
                                                <div class="col-md-6" style="background: none;">
                                                    <ul class="stat-list">
                                                        <li>
                                                            <h2 class="no-margins">2,346</h2>
                                                            <small>Total orders in period</small>
                                                            <div class="progress progress-mini">
                                                                <div class="progress-bar" style="width: 48%;"></div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <h2 class="no-margins ">4,422</h2>
                                                            <small>Orders in last month</small>
                                                            <div class="progress progress-mini">
                                                                <div class="progress-bar" style="width: 60%;"></div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="m-t-md">
                                            <small>
                                                <strong>Kesimpulan Analisa:</strong> The value has been changed over time, and last month reached a level over $50,000.
                                            </small>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-warning pull-right">Data has changed</span>
                                    <h5>Trend Total Data Perbulan</h5>
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

    <?php include 'pages/_partials/_script.php' ?>

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/dist/chart.min.js"></script>
    <script src="js/plugins/chartJs/label/src/plugin.js"></script>


    <script>
        $(document).ready(function() {

            var lineConfig = {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'Unfilled',
                        fill: true,
                        backgroundColor: 'rgba(10, 9, 200, 0.3)',
                        borderColor: '#0099CC',
                        data: [51, 42, 46, 65, 71, 81],
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
                        data: [80, 70],
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

        });
    </script>

</body>

</html>
