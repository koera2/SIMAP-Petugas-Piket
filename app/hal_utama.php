<?php  
	include 'config/koneksi.php';
	include 'library/fungsi.php';
	session_start();
	$aksi = new oop();

	if (empty($_SESSION['nip'])) {
		$aksi->redirect("index.php");
	}
	
	if (isset($_GET['logout'])) {
		unset($_SESSION['nip']);
		unset($_SESSION['nama']);
		unset($_SESSION['tp']);
		unset($_SESSION['foto']);
		unset($_SESSION['hak_akses']);
		unset($_SESSION['rombel']);
		unset($_SESSION['tanggal']);
    	unset($_SESSION['rombel_ubah']);
		unset($_SESSION['tanggal_ubah']);
		$aksi->alert("Logout Berhasil !!!","index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php  
		if (@$_GET['menu'] == "dashboard"){?>
			<title>PETUGAS PIKET | DASHBOARD</title>
		<?php }elseif(@$_GET['menu'] == "absensi_form" || @$_GET['menu'] == "absensi_laporan" ){ ?>
			<title>PETUGAS PIKET | ABSENSI SISWA</title>
		<?php }elseif(@$_GET['menu'] == "izin_form" || @$_GET['menu'] == "izin_laporan" ){ ?>
			<title>PETUGAS PIKET | IZIN SISWA</title>
		<?php }elseif(@$_GET['menu'] == "kinerja_form" || @$_GET['menu'] == "kinerja_laporan" ){ ?>
			<title>PETUGAS PIKET | KINERJA SISWA</title>
		<?php }elseif(@$_GET['menu'] == "profil"){ ?>
			<title>PETUGAS PIKET | PROFIL</title>
		<?php }else{ ?>
			<title>PETUGAS PIKET</title>
		<?php } ?>
	<link rel="shortcut icon" href="assets/images/defaultimage.png">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
<!-- dist -->
	<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="assets/dist/css/skins/skin-blue.min.css">
	<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<!-- plugins -->
	<link rel="stylesheet" href="assets/plugins/bootstrap-slider/slider.css">
	<link rel="stylesheet" href="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
	<link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="assets/plugins/fullcalendar/fullcalendar.min.css">
	<link rel="stylesheet" href="assets/plugins/fullcalendar/fullcalendar.print.css" media="print">
	<link rel="stylesheet" href="assets/plugins/iCheck/all.css">
	<link rel="stylesheet" href="assets/plugins/iCheck/flat/blue.css">
	<link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="assets/plugins/ionslider/ion.rangeSlider.css">
	<link rel="stylesheet" href="assets/plugins/ionslider/ion.rangeSlider.skinNice.css">
	<link rel="stylesheet" href="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
	<link rel="stylesheet" href="assets/plugins/pace/pace.min.css">
	<link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
	<link rel="stylesheet" href="assets/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- select 2-->
	<link rel="stylesheet" type="text/css" href="assets/select2/css/select2.css">
	<link rel="stylesheet" type="text/css" href="assets/select2/css/select2-bootrstrap.css">
<!-- http -->
	<link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
	<link rel="stylesheet" href="assets/fonts/ionicons.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
	<div class="wrapper">
<!-- NAVBAR -->
		<header class="main-header">
		    <!-- Logo -->
		    <a href="#" class="logo">
		      <!-- mini logo for sidebar mini 50x50 pixels -->
		      <span class="logo-mini"><b>P</b>KT</span>
		      <!-- logo for regular state and mobile devices -->
		      <span class="logo-lg"><b>PETUGAS</b> PIKET</span>
		    </a>
		    <!-- Header Navbar: style can be found in header.less -->
		    <nav class="navbar navbar-static-top">
		      <!-- Sidebar toggle button-->
		      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		        <span class="sr-only">Toggle navigation</span>
		      </a>

		      <div class="navbar-custom-menu">
		        <ul class="nav navbar-nav">
		          <li class="dropdown user user-menu">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		              <img src="assets/images/<?php echo $_SESSION['foto'] ?>" class="user-image" alt="User Image">
		              <span class="hidden-xs" style="padding-right: 10px;"><?php echo @$_SESSION['nama']; ?></span>
		            </a>
		            <ul class="dropdown-menu">
		              <!-- User image -->
		              <li class="user-header">
		                <img  src="assets/images/<?php echo $_SESSION['foto'] ?>" class="img-circle" alt="User Image">

		                <p>
		                  <?php echo @$_SESSION['nama']; ?>
		                  <small><b><?php if($_SESSION['hak_akses']=="piket"){echo "PETUGAS PIKET";}else{echo "KESISWAAN";} ?></b></small>
		                </p>
		              </li>
		          
		              <!-- Menu Footer-->
		              <li class="user-footer">
		                <div class="pull-left">
		                  <a href="?menu=profil" class="btn btn-default btn-flat">PROFIL</a>
		                </div>
		                <div class="pull-right">
		                  <a href="?logout" onclick="return confirm('Yakin Akan Keluar dari Aplikasi ini ?')" class="btn btn-default btn-flat">KELUAR</a>
		                </div>
		              </li>
		            </ul>
		          </li>
		        </ul>
		      </div>
		    </nav>
		</header>
<!-- END NAVBAR -->

<!-- SIDEBAR -->
		 <!-- Left side column. contains the logo and sidebar -->
		  <aside class="main-sidebar">
		    <section class="sidebar">
		      <div class="user-panel">
		        <div class="pull-left image">
		          <img src="assets/images/<?php echo $_SESSION['foto'] ?>" class="img-circle" alt="User Image">
		        </div>
		        <div class="pull-left info">
		          <p><a href="?menu=profil" style="color: white;"><?php echo @$_SESSION['nama']; ?></a></p>
		          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		        </div>
		      </div>
		    
		      <ul class="sidebar-menu">

		        <li class="header">MENU UTAMA</li>
		        <li class="treeview <?php if(@$_GET['menu']=="dashboard"){ echo 'active';} ?>">
		          <a href="hal_utama.php?menu=dashboard">
		            <i class="fa fa-dashboard text-red"></i> <span>DASHBOARD</span>
		          </a>
		        </li>

		        <li class="treeview <?php if(@$_GET['menu']=="absensi_form" || @$_GET['menu']=="absensi_laporan" ){ echo 'active';} ?>">
		          <a href="#">
		            <i class="fa fa-hand-o-up text-aqua"></i> 
		            <span>ABSENSI SISWA</span>
		            <span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
		          </a>
		          <ul class="treeview-menu">
		            <li class="<?php if(@$_GET['menu']=='absensi_form'){echo 'active';} ?>">
		            	<a href="hal_utama.php?menu=absensi_form&input"><i class="fa fa-circle-o"></i>FORM ABSENSI</a>
		            </li>
		            <li class="<?php if(@$_GET['menu']=='absensi_laporan'){echo 'active';} ?>">
		            	<a href="hal_utama.php?menu=absensi_laporan&rombelM"><i class="fa fa-circle-o"></i> LAPORAN ABSENSI</a>
		            </li>
		          </ul>
		        </li>

		         <li class="treeview <?php if(@$_GET['menu']=="izin_form" || @$_GET['menu']=="izin_laporan" ){ echo 'active';} ?>">
		          <a href="#">
		            <i class="fa fa-male text-yellow"></i> 
		            <span>IZIN SISWA</span>
		            <span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
		          </a>
		          <ul class="treeview-menu">
		            <li class="<?php if(@$_GET['menu']=='izin_form'){echo 'active';} ?>">
		            	<a href="hal_utama.php?menu=izin_form&daftar"><i class="fa fa-circle-o"></i>FORM IZIN</a>
		            </li>
		            <li class="<?php if(@$_GET['menu']=='izin_laporan'){echo 'active';} ?>">
		            	<a href="hal_utama.php?menu=izin_laporan&rombelM"><i class="fa fa-circle-o"></i> LAPORAN IZIN</a>
		            </li>
		          </ul>
		        </li>

		         <li class="treeview <?php if(@$_GET['menu']=="kinerja_form" || @$_GET['menu']=="kinerja_laporan" || @$_GET['menu']=="surat_peringatan" ){ echo 'active';} ?>">
		          <a href="#">
		            <i class="fa fa-spinner text-green"></i> 
		            <span>KINERJA SISWA</span>
		            <span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
		          </a>
		          <ul class="treeview-menu">
		            <li class="<?php if(@$_GET['menu']=="kinerja_form"){ echo 'active';} ?>">
		              <a href="hal_utama.php?menu=kinerja_form&daftar"><i class="fa fa-circle-o"></i>FORM KINERJA</a>
		            </li>
		            <li class="<?php if(@$_GET['menu']=="kinerja_laporan"){ echo 'active';} ?>">
		              <a href="hal_utama.php?menu=kinerja_laporan&rombelM"><i class="fa fa-circle-o"></i> LAPORAN KINERJA</a>
		            </li>
		            <li class="<?php if(@$_GET['menu']=="surat_peringatan"){ echo 'active';} ?>">
		              <a href="hal_utama.php?menu=surat_peringatan&daftar"><i class="fa fa-circle-o"></i> SURAT PERINGATAN</a>
		            </li>
		          </ul>
		        </li>
		        <li><a href="?logout" onclick="return confirm('Yakin akan keluar dari Aplikasi ini ?')"><i class="fa fa-power-off text-red"></i> <span>KELUAR</span></a></li>

		        <li class="header">LABEL</li>
		        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>PENTING</span></a></li>
		        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>PERINGATAN</span></a></li>
		        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>INFORMASI</span></a></li>
		      </ul>
		    </section>
		    <!-- /.sidebar -->
		  </aside>
<!-- END SIDEBAR -->

<!-- CONTENT -->
		
<!-- END CONTENT -->
	<?php 
		switch (@$_GET['menu']) {
			case 'dashboard': include 'piket/index.php'; break;	
			case 'absensi_form': include 'piket/absensi/form.php'; break;	
			case 'absensi_laporan': include 'piket/absensi/laporan.php'; break;	
			case 'izin_form': include 'piket/izin/form.php'; break;	
			case 'izin_laporan': include 'piket/izin/laporan.php'; break;	
			case 'kinerja_form': include 'piket/kinerja/form.php'; break;	
			case 'kinerja_laporan': include 'piket/kinerja/laporan.php'; break;	
			case 'surat_peringatan': include 'piket/sp/sp.php'; break;	
			case 'profil': include 'piket/profil/profil.php'; break;	
			default:$aksi->redirect("hal_utama.php?menu=dashboard");break;
	}

	 ?>
<!-- FOOTER -->
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<strong>Versi</strong> 1.2
			</div>
			
			<strong>Copyright &copy; 2018 <a href="#">Muhammad Ramdan - Muhammad Nur Alfi - Muhammad Rozinul Miqdad - Muhammad Lutfi Akhdan -  Muhamad Firdaus - Sherline Marceline Cendana &nbsp;</a></strong>
		</footer>
<!-- END FOOTER -->
	</div>
	<script src="assets/js/jquery-2.2.3.min.js"></script>
	<script src="assets/js/jquery-ui.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/sweetalert.min.js"></script>
	<script src="assets/select2/js/select2.full.js"></script>
	<script src="assets/js/show-password.js"></script>

	<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script src="assets/plugins/highchart/code/highcharts.js"></script>
	<script src="assets/plugins/highchart/code/modules/exporting.js"></script>

	<!-- <script src="assets/js/jquery-2.2.3.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/sweetalert.min.js"></script>

	<script src="assets/dist/js/app.min.js"></script>
	<script src="assets/dist/js/demo.js"></script>
	<script src="assets/dist/js/pages/dashboard2.js"></script>
	<script src="assets/dist/js/pages/dashboard.js"></script>

	<script src="assets/plugins/bootstrap-slider/bootstrap-slider.js"></script>
	<script src="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	<script src="assets/plugins/chartjs/Chart.min.js"></script>
	<script src="assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script> -->
	<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="assets/plugins/morris/morris.min.js"></script>
	<!-- <script src="assets/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="assets/plugins/fastclick/fastclick.js"></script>
	<script src="assets/plugins/flot/jquery.flot.categories.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.pie.min.js"></script>
	<script src="assets/plugins/flot/jquery.flot.resize.min.js"></script>
	<script src="assets/plugins/fullcalendar/fullcalendar.min.js"></script>
	<script src="assets/plugins/iCheck/icheck.min.js"></script>
	<script src="assets/plugins/input-mask/jquery.inputmask.js"></script>
	<script src="assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script src="assets/plugins/ionslider/ion.rangeSlider.min.js"></script>
	<script src="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/plugins/knob/jquery.knob.js"></script>
	<script src="assets/plugins/pace/pace.min.js"></script>
	<script src="assets/plugins/select2/select2.full.min.js"></script>
	<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
	<script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script> -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
	<script>
		$('.select2').select2();
		$('.select2').css("width","100%");
		  $(function () {
		    $("#example").DataTable();
		  	for (var i = 0; i <=100; i++) {
			    $("#example"+i).DataTable();
		  	}
		    $("#example2").DataTable();
		    //untuk dashboard
		    $("#izin1").DataTable();
		    $("#izin2").DataTable();
		    $("#absensi1").DataTable();
		    $("#absensi2").DataTable();
		    $("#kinerja1").DataTable();
		    $("#kinerja2").DataTable();

		    // $('#absensi1').DataTable({"paging": true, "lengthChange": false, "searching": false, "ordering": true, "info": true, "autoWidth": false });
		    // $('#absensi2').DataTable({"paging": true, "lengthChange": false, "searching": false, "ordering": true, "info": true, "autoWidth": false });
		    // $('#izin1').DataTable({"paging": true, "lengthChange": false, "searching": false, "ordering": true, "info": true, "autoWidth": false });
		    // $('#izin2').DataTable({"paging": true, "lengthChange": false, "searching": false, "ordering": true, "info": true, "autoWidth": false });
		    // $('#kinerja1').DataTable({"paging": true, "lengthChange": false, "searching": false, "ordering": true, "info": true, "autoWidth": false });
		    // $('#kinerja2').DataTable({"paging": true, "lengthChange": false, "searching": false, "ordering": true, "info": true, "autoWidth": false });
		    $('#form_kinerja1').DataTable({"paging": true, "lengthChange": false, "searching": false, "ordering": true, "info": true, "autoWidth": false });

		});

	  $(function () {
			$('#password').password().on('show.bs.password', function (e) {
				$('#methods').prop('checked', true);
			}).on('hide.bs.password', function (e) {
				$('#methods').prop('checked', false);
			});
			$('#methods').click(function () {
				$('#password').password('toggle');
			});
		});
	 </script>

	<!-- <script type="text/javascript">

            Highcharts.chart('chart_kinerja', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'World\'s largest cities per 2014'
                },
                subtitle: {
                    text: 'Source: <a href="http://en.wikipedia.org/wiki/List_of_cities_proper_by_population">Wikipedia</a>'
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Population (millions)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Population in 2008: <b>{point.y:.1f} millions</b>'
                },
                series: [{
                    name: 'Population',
                    data: [
                        ['Shanghai', 23.7],
                        ['Lagos', 16.1],
                        ['Istanbul', 14.2],
                        ['Karachi', 14.0],
                        ['Mumbai', 12.5],
                        ['Moscow', 12.1],
                        ['São Paulo', 11.8],
                        ['Beijing', 11.7],
                        ['Guangzhou', 11.1],
                        ['Delhi', 11.1],
                        ['Shenzhen', 10.5],
                        ['Seoul', 10.4],
                        ['Jakarta', 10.0],
                        ['Kinshasa', 9.3],
                        ['Tianjin', 9.3],
                        ['Tokyo', 9.0],
                        ['Cairo', 8.9],
                        ['Dhaka', 8.9],
                        ['Mexico City', 8.9],
                        ['Lima', 8.9]
                    ],
	                    dataLabels: {
	                        enabled: true,
	                        rotation: -90,
	                        color: '#FFFFFF',
	                        align: 'right',
	                        format: '{point.y:.1f}', // one decimal
	                        y: 10, // 10 pixels down from the top
	                        style: {
	                            fontSize: '13px',
	                            fontFamily: 'Verdana, sans-serif'
	                        }
	                    }
                }]
            });
	</script> --> 
	</body>
</html>