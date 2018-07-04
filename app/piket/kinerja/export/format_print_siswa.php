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
	$kinerja = $aksi->sumdata("SUM(skor_p) as total_punishment,SUM(skor_r) as total_reward","tbl_kinerja_siswa WHERE nis = '$nis'"); 
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

	$judul = "LAPORAN KINERJA SISWA SMK WIKRAMA KOTA BOGOR";
	$table = "tbl_kinerja_siswa";
	$where = "WHERE nis = '$nis'";
	$sum = "kelompok_kinerja,kode_kinerja,skor_r,skor_p,tgl_kejadian,saksi,tahun_pelajaran,semester,MONTH(tgl_kejadian) as bulan,YEAR(tgl_kejadian) as tahun";
	$data = $aksi->tampil_sum($sum,$table,$where,"ORDER BY tahun ASC, semester ASC, bulan ASC, tgl_kejadian ASC");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Laporan Kinerja </title>
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
			margin-bottom: 110px;
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
			<h2 style="margin-bottom: 10px;margin-top: 10px;"><strong><?php echo $judul; ?></strong></h2>
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
					<td>Jumlah Skor Punishment</td>
					<td>:</td>
					<td><?php echo $kinerja['total_punishment']; ?></td>
				</tr>
				<tr>
					<td>Jumlah Skor Reward</td>
					<td>:</td>
					<td><?php echo $kinerja['total_reward']; ?></td>
				</tr>
			</table>
		</div>
		<!-- end bagian biodata siswa dan jumlah -->
		
		<!-- bagian isi laporan -->
		<div id="isi">
			<br>
			<h3 style="margin-bottom: 5px;">REWARD</h3>
			<table width="100%" border="1" cellspacing="0" cellpadding="3" >
				<thead style="background-color: #eee">
			    	<tr>
			        	<th width="4%"><center>No.</center></th>
			    		<th width="15%"><center>Tanggal Kejadian</center></th>
			    		<th><center>Nama Kinerja</center></th>
			    		<th width="18%"><center>Saksi</center></th>
			    		<th><center>Skor</center></th>
			    	</tr>
			    </thead>
			    <tbody>
			    	<?php  
			    		$no = 0;	
			    		if (empty($data)) {
			    			$aksi->no_record(5);
			    		}else{
			    			foreach ($data as $r) {
			    				if ($r['kelompok_kinerja']=="REWARD") {
				    				$no++;
				    				$poin = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$r[kode_kinerja]'"); 
		    				?>
		    				<tr>
				    			<td align="center"><?php echo $no;?>.</td>
				    			<td align="center"><?php $aksi->format_tanggal($r['tgl_kejadian']); ?></td>
				    			<td style="padding-left: 5px;"><?php echo "<b>".$r['kode_kinerja']."</b> | ".$poin['nama_kinerja'];?></td>
				    			<td align="center"><?php echo $r['saksi'];?></td>
				    			<td align="center"> <strong> <?php echo $r['skor_r']; ?> </strong> </td>
				    		</tr>
				    				
	    			<?php } } }?>
			    </tbody>
			     <tfoot style="background-color: #eee">
			    	<tr>
			    		<td align="right" colspan="4"><b>Total :</b></td>
			    		<td align="center"><b><?php echo $kinerja['total_reward']; ?></b></td>
			    	</tr>
			    </tfoot>
			</table>
			<h3 style="margin-bottom: 5px;">PUNISHMENT</h3>
			<table width="100%" border="1" cellspacing="0" cellpadding="3" >
				<thead style="background-color: #eee">
			    	<tr>
			        	<th width="4%"><center>No.</center></th>
			    		<th width="15%"><center>Tanggal Kejadian</center></th>
			    		<th><center>Nama Kinerja</center></th>
			    		<th width="18%"><center>Saksi</center></th>
			    		<th><center>Skor</center></th>
			    	</tr>
			    </thead>
			    <tbody>
			    	<?php  
			    		$no = 0;	
			    		if (empty($data)) {
			    			$aksi->no_record(5);
			    		}else{
			    			foreach ($data as $r) {
			    				if ($r['kelompok_kinerja']=="PUNISHMENT") {
			    				$no++;
			    				$poin = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$r[kode_kinerja]'"); 
		    				?>
		    				<tr>
				    			<td align="center"><?php echo $no;?>.</td>
				    			<td align="center"><?php $aksi->format_tanggal($r['tgl_kejadian']); ?></td>
				    			<td style="padding-left: 5px;"><?php echo "<b>".$r['kode_kinerja']."</b> | ".$poin['nama_kinerja'];?></td>
				    			<td align="center"><?php echo $r['saksi'];?></td>
				    			<td align="center"> <strong> <?php echo $r['skor_p']; ?> </strong> </td>
				    		</tr>
				    				
	    			<?php } }  }?>
			    </tbody>
			    <tfoot style="background-color: #eee">
			    	<tr>
			    		<td align="right" colspan="4"><b>Total :</b></td>
			    		<td align="center"><b><?php echo $kinerja['total_punishment']; ?></b></td>
			    	</tr>
			    </tfoot>
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