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
	$izin_keluar = $aksi->sumdata("COUNT(keperluan) as total_keluar","tbl_izin_siswa WHERE nis = '$nis' AND jenis_izin = 'IZIN KELUAR'"); 
	$izin_malam = $aksi->sumdata("COUNT(keperluan) as total_malam","tbl_izin_siswa WHERE nis = '$nis' AND jenis_izin = 'PULANG MALAM'"); 
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

	$judul = "LAPORAN IZIN SISWA SMK WIKRAMA KOTA BOGOR";
	$table = "tbl_izin_siswa";
	$where = "WHERE nis = '$nis'";
	$sum = "jenis_izin,keperluan,tgl_izin,id_pegawai,waktu,tahun_pelajaran,semester,MONTH(tgl_izin) as bulan,YEAR(tgl_izin) as tahun";
	$data = $aksi->tampil_sum($sum,$table,$where,"ORDER BY tahun ASC, semester ASC, bulan ASC, tgl_izin ASC");

	$nama = "Laporan Izin ".$nis." - ".$siswa['nama'].".pdf";
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $nama; ?></title>
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
			text-align: center;
			font-weight: bolder;
		}

		#biodata{
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
			/*padding-bottom: 5px;*/
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
					<!-- <td><img src="../../../assets/images/logowk.png" alt="Logo" width="90px" height="90px"></td>
					<td></td> -->
					<td colspan="6" align="left">
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
			<h2 style="margin-bottom: 10px;margin-top: 10px;"><strong><?php echo $judul; ?></strong></h2>
		</div>
		<!-- end bagian judul laporan -->
		<div id="judul">&nbsp;&nbsp;&nbsp;</div>
		<!-- bagian biodata siswa dan jumlah -->
		<div id="biodata">
			<table cellspacing="0" cellpadding="3" align="left">
				<tr>
					<td></td>
					<td>NIS</td>
					<td align="left">:&nbsp;<?php echo  $siswa['nis']; ?></td>
					<td></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;Tahun Pelajaran</td>
					<td align="left">:&nbsp;<?php echo $_SESSION['tp']; ?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Nama</td>
					<td>:&nbsp;<?php echo  $siswa['nama']; ?></td>
					<td></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;Semester</td>
					<td align="left">:&nbsp;<?php echo $semester; ?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Rombel</td>
					<td>:&nbsp;<?php echo $rombel['rombel']; ?></td>
					<td></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;Jumlah Izin Keluar</td>
					<td align="left">:&nbsp;<?php echo $izin_keluar['total_keluar']; ?></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Rayon</td>
					<td>:&nbsp;<?php echo $rayon['rayon']; ?></td>
					<td></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;Jumlah Izin Pulang Malam</td>
					<td align="left">:&nbsp;<?php echo $izin_malam['total_malam']; ?></td>
					<td></td>
				</tr>
				
			</table>
		</div>
		<!-- end bagian biodata siswa dan jumlah -->
		<div id="judul">&nbsp;&nbsp;&nbsp;</div>
		<!-- bagian isi laporan -->
		<div id="isi">
			<table width="100%" border="1" cellspacing="0" cellpadding="3" >
				<thead>
			    	<tr>
			        	<th width="4%"><center>No.</center></th>
			    		<th width="15%"><center>Tanggal</center></th>
			    		<th width="15%"><center>Waktu</center></th>
                		<th width="4%"><center>Semester</center></th>
			    		<th><center>Keperluan</center></th>
			    		<th width="18%"><center>Petugas</center></th>
			    	</tr>
			    </thead>
			    <tbody>
			    	<?php  
			    		$no = 0;	
			    		if (empty($data)) {
			    			$aksi->no_record(9);
			    		}else{
			    			foreach ($data as $r) {
			    				$no++;
			    				$petugas = $aksi->caridata("tbl_pegawai WHERE nip = '$r[id_pegawai]'");
		    				?>
		    				<tr>
				    			<td align="center"><?php echo $no;?>.</td>
				    			<td align="center"><?php $aksi->format_tanggal($r['tgl_izin']); ?></td>
				    			<td align="center"><?php echo substr($r['waktu'],11,9); ?></td>
				    			<td align="center"><?php echo $r['semester'];?></td>
				    			<td style="padding-left: 5px;"><?php echo "<b>".$r['jenis_izin']."</b> | ".$r['keperluan'];?></td>
				    			<td align="center"><?php echo $petugas['nama'];?></td>
				    		</tr>
				    		
	    			<?php } } ?>
			    </tbody>
			</table>
		</div>
		<!-- end bagian isi laporan -->

		<!-- bagian tanda tangan -->
		<div id="footer">
			<!-- tanda tangan kiri -->
			<!-- <table align="left" style="margin-left: 10px;margin-top: 150px;">
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
			</table> -->
			<!-- end tanda tangan kiri -->

			<!-- tanda tangan kanan -->
			<!-- <table align="right" style="margin-right: 40px;">
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
			</table> -->
			<!-- end tanda tangan kanan -->
		</div>
		<!-- end bagian tanda tangan -->
	</div>
</body>
</html>