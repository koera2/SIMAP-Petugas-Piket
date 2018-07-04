<?php  
	// session_start();
	date_default_timezone_set("Asia/Jakarta");

	if (empty($_SESSION['nip'])) {
		echo "<script>document.location.href='../../../index.php'</script>";
	}
	$kd_rombel = $_GET['rombel'];
	$rayon = $_GET['kd_rayon'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$dari = $_GET['dari'];
	$sampai = $_GET['sampai'];
	$semester = $_GET['semester'];
	$tpel = $_GET['tp'];

	if (isset($_GET['rombelM']) OR isset($_GET['rombelP']) OR isset($_GET['rombelS'])) {
		$inc = "format_excel_rombel.php";
		if (isset($_GET['rombelM'])){
			$nama = "Laporan Kinerja Siswa Rombel ".$kd_rombel." Bulan ".$bulan." ".$tahun.".xls";
		}elseif (isset($_GET['rombelP'])){
			$nama = "Laporan Kinerja Siswa Rombel ".$kd_rombel." Periode ".$dari." sampai ".$sampai.".xls";
		}elseif (isset($_GET['rombelS'])){
			$nama = "Laporan Kinerja Siswa Rombel ".$kd_rombel." Semester ".$semester." tp ".$tpel.".xls";
		}
	}elseif(isset($_GET['rayonM']) OR isset($_GET['rayonP']) OR isset($_GET['rayonS']) OR isset($_GET['rayon'])) {
		$inc = "format_excel_rayon.php";
		if (isset($_GET['rayonM'])){
			$nama = "Laporan Kinerja Siswa Rayon ".$rayon." Bulan ".$bulan." ".$tahun.".xls";
		}elseif (isset($_GET['rayon'])){
			$nama = "Laporan Kinerja Siswa Rayon ".$rayon.".xls";
		}elseif (isset($_GET['rayonP'])){
			$nama = "Laporan Kinerja Siswa Rayon ".$rayon." Periode ".$dari." sampai ".$sampai.".xls";
		}elseif (isset($_GET['rayonS'])){
			$nama = "Laporan Kinerja Siswa Rayon ".$rayon." Semester ".$semester." tp ".$tpel.".xls";
		}
	}elseif(isset($_GET['siswa'])){
		$inc = "format_excel_siswa.php";
		$nama = "Laporan Kinerja - ".$_GET['nis'].".xls";
	}elseif(isset($_GET['alasan'])){
		$inc = "format_excel_grafik.php";
	    $nama = "Laporan Alasan Siswa Melanggar Periode ".$dari." sampai ".$sampai.".xls";
	}

	header("Content-type: application/vnd.ms-excel;charset:UTF-8");
	header("Content-type: application/image/png");
	header("Content-Disposition: attachment; filename=$nama");
	include($inc);
?>