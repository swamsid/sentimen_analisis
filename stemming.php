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
                                    <span class="label label-warning pull-right">Total Data 1</span>
                                    <h5>Data Testing Hasil Stemming</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Kode</th>
                                                    <th class="text-center">Hasil Stemming</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr class="gradeX">
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">TXT-01120</td>
                                                    <td>
                                                        terima | kasih | cepat | banyak
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-xs btn-primary btn-detail" data-id="1" data-conteks="testing">
                                                            <i class="fa fa-folder-open"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" style="padding: 0px;">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <span class="label label-warning pull-right">Data has changed</span>
                                    <h5>Data Training Hasil Stemming</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Kode</th>
                                                    <th class="text-center">Hasil Stemming</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr class="gradeX">
                                                    <td class="text-center">1</td>
                                                    <td class="text-center">TXT-01120</td>
                                                    <td>
                                                        terima | kasih | cepat | banyak
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-xs btn-primary btn-detail" data-id="1" data-conteks="training">
                                                            <i class="fa fa-folder-open"></i>
                                                        </button>
                                                    </td>
                                                </tr>
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
                        <span class="modal-title" style="font-size: 14pt; font-weight: 600">Detail Hasil Stemming</span>
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
                $('#detail-wrap').load('pages/stemming/detail.php?id='+ctx.data('id')+'&ctx='+ctx.data('conteks'));
            })
        })
    </script>

</body>

</html>
