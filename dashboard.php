<?php
	session_start();
	include "connection.php";
    include "components/role_session.php";
    

	$merchant 	= executeScalar("select count(merchant_id) from merchant where merchant_status = 'Aktif'");
	$lapak 		= executeScalar("select count(lapak_id) from lapak as l join block as b on l.block_id = b.block_id where b.status_block = 'active'");
    $block 		= executeScalar("select count(block_id) from block where status_block = 'active'");
	$move 		= executeScalar("select count(move_log_id) from move_log");
    $payment    = executeScalar("select sum(rent_total) from rent where rent_sts = 'Lunas' and rent_sts2 != 'Batal'");

    function headScript(){
		$headScript=file_get_contents("headScript.html");
		return $headScript;
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="img/logo.png">
        <link rel="shortcut icon" href="img/logo.png" />
        <title>Dashboard | PISS</title>

        <?php echo headScript(); ?>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            /* hide all elements & show preloader*/
            document.documentElement.className += 'js';
            
            /* display variabel */
            var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
        </script>
    </head>
    <body>
        <div id="wrapper">
            <?php include "components/sidebar.php" ?>

            <div id="page-wrapper">
                <br><br><br><br>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-group fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge" id="merchant"></div>
                                        <div>Pedagang Aktif</div>
                                    </div>
                                </div>
                            </div>
                            <a href="merchant.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Lihat Detail</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-building fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge" id="block" style="font-size: 32px; padding-top: 10px;">0</div>
                                        <div>Blok Tersedia</div>
                                    </div>
                                </div>
                            </div>
                            <a href="block.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Lihat Detail</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-th fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge" id="lapak">0</div>
                                        <div>Lapak Tersedia</div>
                                    </div>
                                </div>
                            </div>
                            <a href="lapak.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Lihat Detail</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-retweet fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge" id="move"></div>
                                        <div>Perpindahan Lapak</div>
                                    </div>
                                </div>
                            </div>
                            <a href="move_select.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Lihat Detail</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-money fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge" id="payment" style="font-size: 32px; padding-top: 10px;">0</div>
                                        <div>Omzet Pembayaran Lapak</div>
                                    </div>
                                </div>
                            </div>
                            <a href="rent.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Lihat Detail</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div> -->
                </div>
                
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a data-toggle="tab" href="#block" style="background-color: #428bca; color: #ffffff;">Blok & Lapak</a></li>
                        <li><a data-toggle="tab" href="#merchant2" style="background-color: transparent; color: #428bca;">Pedagang</a></li>
                        <!-- <li><a data-toggle="tab" href="#revenue" style="background-color: transparent; color: #428bca;">Pendapatan</a></li> -->
                        </ul>

                        <div class="tab-content">
                            <div id="block" class="tab-pane fade in active">
                                <br />
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div id="Area1"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
                                        <div id="Area2"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div id="Area3"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
                                        <div id="Area4"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
                                        <!--<div id="Area5"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>-->
                                    </div>
                                </div>
                            </div>
                            <div id="merchant2" class="tab-pane fade">
                                <br />
                                <div id="Area7"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div id="Area6"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div id="Area8"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
                                    </div>
                                </div>
                            </div>
                            <div id="revenue" class="tab-pane fade">
                                <br />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="Area5"><div class="alert alert-info" onclick="clearNotif()"><center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal deadline -->
        <!-- <div class="modal fade" id="modaldl"  name="modaldl" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog" style="width: 1000px; margin-top: 80px;">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #428bca; color: #fff; border-radius: 5px 5px 0px 0px; font-size: 20px;">
                        <i class="fa fa-credit-card fa-fw"></i> Batas Sewa 1 Bulan Terakhir
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="data_dl" style="margin-bottom: 0px;">
                            <div class="alert alert-info" onclick="clearNotif()">
                                <h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3>
                            </div>
                        </div>
                        <input type="hidden" id="value_id" />
                    </div>
                </div>
            </div>
        </div> -->
        
        <!-- jQuery -->
        <script src="js/jquery.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.colorbox.js"></script>
        <!-- highcharts -->
        <script src="highcharts/js/highcharts.js"></script>
        <script src="highcharts/js/highcharts-more.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>
        <script>
            // function openColorBox(){
            //     $.colorbox({iframe:true, width:"80%", height:"80%", href: "modal_deadline.php"});
            // }
            // setTimeout(openColorBox, 500);
            // $(document).ready(function(){
            //     $("#notifArea").html(alertLoadProcess);
            //     setTimeout('$("html").removeClass("js")',1000); 
            //     loadChart();
                
            // });

            $(document).ready(function(){
                $("#modaldl").modal('show');
                $("#notifArea").html(alertLoadProcess);
                $('#data_dl').load("modal_deadline.php",function(){clearNotif();});
                setTimeout('$("html").removeClass("js")',500); 
                loadChart();
                
                //Modal Password
                $('#modalPassword').on('shown.bs.modal', function (e) {
                    $("#notifArea").html(alertLoadProcess);
                    $("#data_password").load("password.php",function(){clearNotif();});
                })
            });

            //Meload Chart
            function loadChart(){
                $("#notifArea").html(alertLoadProcess);
                $("#Area1").load("line_block1.php",function(){clearNotif();});
                $("#Area2").load("line_block2.php",function(){clearNotif();});
                $("#Area3").load("line_block3.php",function(){clearNotif();});
                $("#Area4").load("line_block4.php",function(){clearNotif();});
                $("#Area5").load("line_revenue1.php",function(){clearNotif();});
                $("#Area6").load("line_merchant_type.php",function(){clearNotif();});
                $("#Area7").load("line_merchant_block.php",function(){clearNotif();});
                $("#Area8").load("line_merchant_sts.php",function(){clearNotif();});
                //$("#Area5").load("line_block5.php",function(){clearNotif();});
            }
            function clearNotif(){$("#notifArea").html("");}
        </script>
        <script>
            function animateValue(id, start, end, duration, isCurrency = false) {
                let obj = document.getElementById(id);
                let range = end - start;
                let current = start;
                let increment = end > start ? Math.ceil(range / (duration / 10)) : -1;
                let stepTime = 10; // Kecepatan update dalam milidetik
                let timer = setInterval(function () {
                    current += increment;
                    if (current >= end) {
                        current = end;
                        clearInterval(timer);
                    }
                    obj.innerHTML = isCurrency ? formatRupiah(current) : current;
                }, stepTime);
            }

            function formatRupiah(angka) {
                return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            $(document).ready(function () {
                animateValue("merchant", 0, <?php echo $merchant; ?>, 1500);
                animateValue("lapak", 0, <?php echo $lapak; ?>, 1500);
                animateValue("move", 0, <?php echo $move; ?>, 1500);
                // animateValue("payment", 0, <?php echo $payment; ?>, 1500, true);
                animateValue("block", 0, <?php echo $block; ?>, 1500);
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.nav-tabs li a').on('click', function() {
                    $('.nav-tabs li a').css({'background-color': 'transparent', 'color': '#428bca'}); // Reset semua tab
                    $(this).css({'background-color': '#428bca', 'color': '#ffffff'}); // Tab yang aktif
                });
            });
        </script>
    </body>
</html>