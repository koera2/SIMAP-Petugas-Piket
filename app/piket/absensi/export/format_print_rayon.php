<?php  
	include '../../../config/koneksi.php';
	include '../../../library/fungsi.php';
	session_start();
	date_default_timezone_set("Asia/Jakarta");
	$aksi = new oop();

	if (empty($_SESSION['nip'])) {
		$aksi->redirect("../../../index.php");
	}

	$kesiswaan = $aksi->caridata("tbl_pegawai WHERE hak_akses = 'kesiswaan'");
	$kd_rayon = $_GET['kd_rayon'];
	$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$kd_rayon'");
	$judul = "LAPORAN ABSENSI SISWA SMK WIKRAMA KOTA BOGOR RAYON ".strtoupper($rayon['rayon']);
	$table = "tbl_absensi_siswa";

	if (isset($_GET['rayonM'])) {
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];

		$where = "WHERE kode_rayon = '$kd_rayon' AND MONTH(tgl_absen)='$bulan' AND YEAR(tgl_absen)='$tahun'";
		$where_detail = "AND MONTH(tgl_absen)='$bulan' AND YEAR(tgl_absen)='$tahun'";

		$sum = "nis,nama,kode_rayon,rombel,SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY nis ASC");

	}elseif (isset($_GET['rayon'])) {
		$where = "WHERE kode_rayon = '$kd_rayon'";
		$where_detail = "";

		$sum = "nis,nama,kode_rayon,rombel,SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY nis ASC");

	}elseif (isset($_GET['rayonP'])) {
		$dari = $_GET['dari'];
		$sampai = $_GET['sampai'];

		$where = "WHERE kode_rayon = '$kd_rayon' AND tgl_absen BETWEEN '$dari' AND '$sampai'";
		$where_detail = "AND tgl_absen BETWEEN '$dari' AND '$sampai'";
		$sum = "nis,nama,kode_rayon,rombel,SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY nis ASC");
	}elseif (isset($_GET['rayonS'])) {
		$semester = $_GET['semester'];
		$tpel = $_GET['tp'];

		$where = "WHERE kode_rayon = '$kd_rayon' AND semester='$semester' AND tahun_pelajaran = '$tpel'";
		$where_detail = "AND semester='$semester' AND tahun_pelajaran = '$tpel'";
		$sum = "nis,nama,kode_rayon,rombel,SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY nis ASC");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Laporan</title>
	<link rel="icon" href="../../../assets/images/defaultimage.png">
	<style type="text/css">
		html,body{
			margin:0;
			padding:0;
			height:100%;
			font-family: Arial;
		}
		#wrapper{
			/*background-color: gray;*/
			min-height:100%;
			position:relative;
		}
		#header{
			/*background-color: red;*/
			padding-top: 20px;
			padding-left:20px;
			/*padding:5px;*/
			height:100px;
		}
		#judul{
			text-align: center;
			font:12px Arial;
			font-weight: bolder;
		}
		#isi{
			/*background-color: green;*/
			padding-bottom:200px;
			padding-left:30px;
			margin-right:10px;
			font:12px Arial;
		}
		#footer{
			/*background-color: yellow;*/
			position:absolute;
			bottom:1px;
			padding-right: 100px;
			padding-left: 20px;
			width:100%;
			font-weight: bold;
		  	color:black;
		  	font:13px Arial;
		  }
	</style>
</head>
<body onload="window.print()">
	<div id="wrapper">
		<!-- bagian header laporan -->
		<div id="header">
			<table>
				<tr>
					<td><img src="../../../assets/images/logowk.png" alt="Logo" width="90px" height="90px"></td>
					<td></td>
					<td>
						<h4 style="margin: 0;margin-left: 2px;"><strong>YAYASAN PRAWITAMA</strong></h4>
						<h1 style="margin: 0;margin-left: 2px;"><strong>SMK WIKRAMA BOGOR</strong> </h1>
						<h5 style="margin: 0;margin-left: 2px;">Jl. Raya Wangun Kel. Sindangsari Kec. Bogor Timur</h5>
						<h5 style="margin: 0;margin-left: 2px;">Telp/Fax.(0251) 8242411, email : prohumasi@smkwikrama.net, website : www.smkwikrama.net</h5>
					</td>
				</tr>
			</table>
		</div>
		<!-- end bagian header laporan -->
		<hr style="border: 2px solid black;">

		<!-- bagian judul laporan -->
		<div id="judul">
			<?php if (isset($_GET['rayonM'])) { ?>
				<h4 style="margin-bottom: 15px;margin-top: 15px;"><strong><?php echo  $judul." BULAN ";$aksi->bulan_kapital($bulan);echo " TAHUN ".$tahun; ?></strong></h4>
			<?php }elseif (isset($_GET['rayon'])) {?>
				<h4 style="margin-bottom: 15px;margin-top: 15px;"><strong><?php echo  $judul; ?></strong></h4>
			<?php }elseif (isset($_GET['rayonP'])) {?>
				<h4 style="margin-bottom: 15px;margin-top: 15px;"><strong><?php echo  $judul." PERIODE ";$aksi->tanggal_kapital($dari);echo "  -  ";$aksi->tanggal_kapital($sampai) ?></strong></h4>
			<?php }else{?>
				<h4 style="margin-bottom: 15px;margin-top: 15px;"><strong><?php echo  $judul." SEMESTER ".$semester." TAHUN PELAJARAN ".$tpel; ?></strong></h4>
			<?php } ?>
		</div>
		<!-- end bagian judul laporan -->
		
		<!-- bagian isi laporan -->
		<div id="isi">
			<table width="100%" border="1" cellspacing="0" cellpadding="3" >
				<thead>
			    	<tr>
			        	<th width="4%"><center>No.</center></th>
			    		<th width="15%"><center>NIS</center></th>
			    		<th><center>Nama</center></th>
			    		<th width="3%">JK</th>
			    		<th width="12%"><center>Rombel</center></th>
			    		<th><center>Hadir</center></th>
                		<th><center>Sakit</center></th>
                		<th><center>Izin</center></th>
                		<th><center>Alpa</center></th>
                		<th><center>Tugas</center></th>
			    	</tr>
			    </thead>
			    <tbody>
			    	<?php  
			    		$no = 0;
			    		if (empty($data)) {
			    			$aksi->no_record(10);
			    		}else{
			    			foreach ($data as $r) {
			    				$no++;
			    				$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");

			    				$sakit = $aksi->tampil("tbl_absensi_siswa","WHERE nis = '$r[nis]' AND sakit = '1' ".$where_detail,"");
			    				$izin = $aksi->tampil("tbl_absensi_siswa","WHERE nis = '$r[nis]' AND izin = '1' ".$where_detail,"");
			    				$alpa = $aksi->tampil("tbl_absensi_siswa","WHERE nis = '$r[nis]' AND alpa = '1' ".$where_detail,"");
			    				$tugas = $aksi->tampil("tbl_absensi_siswa","WHERE nis = '$r[nis]' AND tugas = '1' ".$where_detail,"");
	                		 ?>
	                		 	<tr>
			             			<td align="center"><?php echo $no; ?>.</td>
			             			<td align="center"><?php echo $r['nis']; ?></td>
			             			<td><?php echo $r['nama']; ?></td>
			             			<td align="center">
			             				<?php echo $siswa['jk']; ?>
			             				<!-- <?php 
			             					if ($siswa['jk']=="L") {
			             						echo "Laki-laki";
			             					}else{
			             						echo "Perempuan";
			             					}
			             				 ?> -->
			             			</td>
			             			<td align="center"><?php echo $r['rombel']; ?></td>
				    				<td align="center"><strong><?php echo $r['jumlah_hadir']; ?></strong></td>
					    			<td align="center">
					    				<strong><?php echo $r['jumlah_sakit']; ?></strong><br>
					    				<span style="color: blue;">
					    					<?php 
						    					if (!empty($sakit)) {
							    					foreach ($sakit as $s) {
							    						echo "(".$s['tgl_absen'].")<br>";
							    					}
						    					} 
						    				?>
						    			</span>
					    			</td>
					    			<td align="center">
					    				<strong><?php echo $r['jumlah_izin']; ?></strong><br>
					    				<span style="color: blue;">
						    				<?php 
						    					if (!empty($izin)) {
							    					foreach ($izin as $izn) {
							    						echo "(".$izn['tgl_absen'].")<br>";
							    					}
						    					} 
						    				?>
						    			</span>
					    			</td>
					    			<td align="center">
					    				<strong><?php echo $r['jumlah_alpa']; ?></strong><br>
					    				<span style="color: blue;">
						    				<?php 
						    					if (!empty($alpa)) {
							    					foreach ($alpa as $alp) {
							    						echo "(".$alp['tgl_absen'].")<br>";
							    					}
						    					} 
						    				?>
						    			</span>
					    			</td>
					    			<td align="center">
					    				<strong><?php echo $r['jumlah_tugas']; ?></strong><br>
					    				<span style="color: blue;">
						    				<?php 
						    					if (!empty($tugas)) {
							    					foreach ($tugas as $tgs) {
							    						echo "(".$tgs['tgl_absen'].")<br>";
							    					}
						    					} 
						    				?>
						    			</span>
					    			</td>
					    		</tr>
    			 <?php } } ?>
			    </tbody>
			</table>
		</div>
		<!-- end bagian isi laporan -->

		<!-- bagian tanda tangan -->
		<div id="footer">
			<!-- tanda tangan kiri -->
			<table align="left" style="margin-left: 10px;">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td align="left">Mengetahui</td>
				</tr>
				<tr>
					<td align="left">Wakasek Kesiswaan,</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td align="left"><?php echo $kesiswaan['nama']; ?></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
			<!-- end tanda tangan kiri -->

			<!-- tanda tangan kanan -->
			<table align="right" style="margin-right: 40px;">
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td align="left">Bogor, <?php $aksi->hari(date("N"));echo " ";$aksi->format_tanggal(date("Y-m-d")) ?></td>
				</tr>
				<tr>
					<td align="left">Petugas Piket,</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td align="left"><?php echo $_SESSION['nama']; ?></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			</table>
			<!-- end tanda tangan kanan -->
		</div>
		<!-- end bagian tanda tangan -->
	</div>
</body>
</html>