<?php
    session_start();
    include 'lib/connection.php';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Dashboard v.4</title>

    <?php include 'pages/_partials/_head.php' ?>
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

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
                                
                                    <h5>Data Testing Hasil Tokenizing</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                <th width="5%" class="text-center">No</th>
                                                    <th width="10%" class="text-center">Kode</th>
                                                    <th width="70%" class="text-center">Hasil Tokenizing</th>
                                                    <th width="15%" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                                $sql = "SELECT * FROM tokenize join case_folding on cf_data = t_data join data_crawling on dc_id = cf_data";
                                                $result = $con->query($sql) or die (mysqli_error($con));
                                                $idx = 1;

                                                while($row = $result->fetch_assoc()){
                                            ?>
                                                    <tr class="gradeX">
                                                        <td class="text-center"><?= $idx ?></td>
                                                        <td class="text-center"><?= $row['dc_post_id'] ?></td>
                                                        <td class="text-left"><?= str_replace('|', ' | ', $row['t_tokenize']) ?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-xs btn-primary btn-detail" data-id="<?= $row['dc_id'] ?>">
                                                                <i class="fa fa-folder-open"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    $idx++;
                                                };
                                            ?>
                                            </tbody>
                                        </table>
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

        <div class="modal inmodal" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                    <div class="modal-header" style="padding: 10px;">
                        <span class="modal-title" style="font-size: 14pt; font-weight: 600">Detail Hasil Tokenizing</span>
                    </div>
                    <div class="modal-body">
                       <div class="row" id="detail-wrap">
                           <center><small>Sedang Mengambil Data</small></center>
                       </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <?php include 'pages/_partials/_script.php' ?>
    <script src="js/plugins/dataTables/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

            $('.btn-detail').click(function(evt){
                evt.preventDefault();

                var ctx = $(this);

                $('#detail-wrap').html('<center><small>Sedang Mengambil Data</small></center>');
                $('#modal-detail').modal('show');
                $('#detail-wrap').load('pages/tokenizing/detail.php?id='+ctx.data('id')+'&ctx='+ctx.data('conteks'));
            })
        })
    </script>

</body>

</html>
