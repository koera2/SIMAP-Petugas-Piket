<?php 
	session_start();
	if (empty($_SESSION['nip'])) {
		echo "<script>document.location.href='../../../index.php'</script>";
	}
	if (isset($_GET['rombelM']) OR isset($_GET['rombelP']) OR isset($_GET['rombelS'])) {
		$inc = "format_pdf_rombel.php";
	}elseif(isset($_GET['rayonM']) OR isset($_GET['rayonP']) OR isset($_GET['rayonS']) OR isset($_GET['rayon'])) {
		$inc = "format_pdf_rayon.php";
	}elseif(isset($_GET['siswa'])){
		$inc = "format_pdf_siswa.php";
	}elseif(isset($_GET['alasan'])){
		$inc = "format_pdf_grafik.php";
	}

	include ("../../../assets/plugins/mpdf/mpdf.php");
	// $mpdf = new mPDF('win-1252','A4','','',15,10,16,15,10,10); //A4 Page in potrait
	$mpdf = new mPDF('win-1252','A4','','',1,1,1,1,1,1); //A4 Page in potrait
	$mpdf->setFooter('{PAGENO}'); //giving page number in footer
	$mpdf->useOnlyCoreFonts=true; //false is default
	$mpdf->setDisplayMode('fullpage');

	ob_start();
	include ($inc);
	$html=ob_get_contents();
	ob_end_clean();

	$mpdf->WriteHTML($html);
	$mpdf->Output($nama,'I');
?>