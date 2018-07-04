<?php  
	include '../../../config/koneksi.php';
	include '../../../library/fungsi.php';
    date_default_timezone_set("Asia/Jakarta");
	session_start();
	$aksi = new oop();
    if (empty($_SESSION['nip'])) {
		$aksi->redirect("../../../index.php");
	}

	$nis = $_GET['nis'];
	$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$nis'");
	$total_hadir = $aksi->cekdata("tbl_absensi_siswa WHERE hadir = '1' AND nis = '$nis'");
	$total_tdk_hadir = $aksi->cekdata("tbl_absensi_siswa WHERE hadir != '1' AND nis = '$nis'");
	$total = $aksi->sumdata("SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas","tbl_absensi_siswa WHERE nis = '$nis'");

	$kesiswaan = $aksi->caridata("tbl_pegawai WHERE hak_akses = 'kesiswaan'");
	$rombel = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$siswa[kode_rombel]'");
	$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$siswa[kode_rayon]'");

	$tahun = date("Y");
	$masuk = $siswa['tahun_masuk'];
	$selisih = $tahun-$masuk;
	//logika menentukan semester
	if ($selisih == "0" ) {
	  $semester = "I";
	}elseif ($selisih=="1" && date("m") < 8) {
	  $semester = "II";
	}elseif ($selisih=="1" && date("m") > 7) {
	  $semester = "III";
	}elseif ($selisih=="2" && date("m") < 8) {
	  $semester = "IV";
	}elseif ($selisih=="2" && date("m") > 7) {
	  $semester = "V";
	}elseif ($selisih=="3" && date("m") < 8) {
	  $semester = "VI";
	}else{
	  $semester = "";
	}
	//end logika menentukan semester 

	$judul = "LAPORAN ABSENSI SISWA SMK WIKRAMA KOTA BOGOR";
	$table = "tbl_absensi_siswa";
	$where = "WHERE nis = '$nis'";
	$sum = "nis,nama,rombel,kode_rayon,semester,MONTH(tgl_absen) as bulan,YEAR(tgl_absen) as tahun,SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
	$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY bulan,semester ORDER BY tahun ASC, semester ASC, bulan ASC");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Laporan Izin Siswa</title>
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
			font:12px Arial;
			font-weight: bolder;
		}

		#biodata{
			/*background-color: rgba(12,45,12,0.7);*/
			margin-top: 10px;
			margin-bottom: 110px;
			margin-left:30px;
			width: 80%;
			font-family: 'Arial', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma,  sans-serif;"

		}
		#tes{
			/*background-color: rgba(12,45,12,0.7);*/
			margin-top: 10px;
			margin-bottom: 5px;
			margin-left:30px;
			width: 80%;
			font-family: 'Arial', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma,  sans-serif;"

		}
		#isi{
			/*background-color: green;*/
			padding-bottom:150px;
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
<body onload="window.print()" >
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
			<center><h2 style="margin-bottom: 10px;margin-top: 10px;"><strong><?php echo $judul; ?></strong></h2></center>
		</div>
		<!-- end bagian judul laporan -->

		<!-- bagian biodata siswa dan jumlah -->
		<div id="biodata">
			<table cellspacing="0" cellpadding="3" align="left">
				<tr>
					<td>NIS</td>
					<td>:</td>
					<td><?php echo  $siswa['nis']; ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?php echo  $siswa['nama']; ?></td>
				</tr>
				<tr>
					<td>Rombel</td>
					<td>:</td>
					<td><?php echo $rombel['rombel']; ?></td>
				</tr>
				<tr>
					<td>Rayon</td>
					<td>:</td>
					<td><?php echo $rayon['rayon']; ?></td>
				</tr>
			</table>
			<table cellspacing="0" cellpadding="3" align="right">
				<tr>
					<td>Tahun Pelajaran</td>
					<td>:</td>
					<td ><?php echo $_SESSION['tp']; ?></td>
				</tr>
				<tr>
					<td>Semester</td>
					<td>:</td>
					<td><?php echo $semester; ?></td>
				</tr>
				<tr>
					<td>Total Hadir</td>
					<td>:</td>
					<td><?php echo $total_hadir; ?></td>
				</tr>
				<tr>
					<td>Total Tidak Hadir</td>
					<td>:</td>
					<td><?php echo $total_tdk_hadir; ?></td>
				</tr>
			</table>
		</div>
		<div id="tes">
			<table cellspacing="0" cellpadding="3" align="center">
				<tr>
					<td>Hadir : <?php echo $total['jumlah_hadir']; ?>, Sakit : <?php echo $total['jumlah_sakit']; ?>, Izin : <?php echo $total['jumlah_izin']; ?>, Alpa : <?php echo $total['jumlah_alpa']; ?>, Tugas : <?php echo $total['jumlah_tugas']; ?></td>
				</tr>
			</table>
		</div>
		<!-- end bagian biodata siswa dan jumlah -->
		
		<!-- bagian isi laporan -->
		<div id="isi">
			<table width="100%" border="1" cellspacing="0" cellpadding="3" >
				<thead>
			    	<tr>
			        	<th><center>No.</center></th>
	            		<th><center>Bulan</center></th>
	            		<th><center>Semester</center></th>
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
			    			$aksi->no_record(8);
			    		}else{
			    			foreach ($data as $r) {
			    				$no++;
		    				?>
		    				<tr style="background-color: #d9edf7">
				    			<td align="center">&nbsp;</td>
		             			<td align="center"><?php $aksi->bulan($r['bulan']);echo " ".$r['tahun']; ?></td>
		             			<td align="center"><?php echo $r['semester']; ?></td>
				    			<td align="center"><?php echo $r['jumlah_hadir']; ?></td>
		             			<td align="center"><?php echo $r['jumlah_sakit']; ?></td>
		             			<td align="center"><?php echo $r['jumlah_izin']; ?></td>
		             			<td align="center"><?php echo $r['jumlah_alpa']; ?></td>
		             			<td align="center"><?php echo $r['jumlah_tugas']; ?></td>
				    		</tr>
				    		<!-- <tr style="background-color: #d9edf7">
				    			<td align="center">No.</td>
				    			<td align="center">Tanggal</td>
				    			<td colspan="3" align="center">Keterangan</td>
				    			<td colspan="3" align="center">Catatan</td>
				    		</tr> -->

				    		<?php  
				    			$no_detail =0;
				    			$tbl = "tbl_absensi_siswa";
								$whr = "WHERE hadir !='1' AND nis = '$r[nis]' AND MONTH(tgl_absen)='$r[bulan]' AND YEAR(tgl_absen)='$r[tahun]' AND semester = '$r[semester]'";
								$data_detail = $aksi->tampil($tbl,$whr,"ORDER BY tgl_absen ASC");
								if (!empty($data_detail)) {
									foreach ($data_detail as $detail) {
											$no_detail++;
			            				?>
			            				<tr>
					             			<td align="center"><?php echo $no_detail; ?>.</td>
					             			<td align="center"><b>Tanggal : <?php $aksi->format_tanggal($detail['tgl_absen']); ?></b></td>
					             			<td align="center" colspan="3">
				             				<?php  
				             					if ($detail['izin']=="1") {
				             						echo "<b>Keterangan : Izin</b>";
				             					}elseif ($detail['alpa']=="1") {
				             						echo "<b>Keterangan : Alpa</b>";
				             					}elseif ($detail['sakit']=="1") {
				             						echo "<b>Keterangan : Sakit</b>";
				             					}elseif ($detail['tugas']=="1") {
				             						echo "<b>Keterangan : Tugas</b>";
				             					}
					             			?>
					             			</td>
					             			<td align="center" colspan="3"><b><?php if($detail['catatan']==""){ echo "-";}else{echo "Karena : ".$detail['catatan'];;} ?></b></td>
					             		</tr>
		             		<?php } } ?>
				    		
				    		
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