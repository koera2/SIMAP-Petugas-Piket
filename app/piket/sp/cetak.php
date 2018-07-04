<?php  
	include '../../config/koneksi.php';
	include '../../library/fungsi.php';
	date_default_timezone_set("Asia/Jakarta");
	session_start();
	$aksi = new oop();
	if (empty($_SESSION['nip'])) {
		$aksi->redirect("../../index.php");
	}
	$nis = $_GET['nis'];
	$sp_ke = $_GET['sp'];

	$data_sp= $aksi->caridata("tbl_sp WHERE nis = '$nis' AND sp_ke = '$sp_ke'");
	if (empty($data_sp)) {
		$aksi->alert("Data Tidak Valid","../../hal_utama.php?menu=surat_peringatan&daftar");
	}else{
		$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$nis'");
		$guru = $aksi->caridata("tbl_pegawai WHERE hak_akses = 'kepala sekolah'");
		$rombel = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$siswa[kode_rombel]'");
		$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$siswa[kode_rayon]'");

		if ($sp_ke==1) {
			$ket ="satu";
			$pembuka = "Berdasarkan butir kesepahaman antara Peserta Didik dan SMK Wikrama Bogor, Peserta Didik yang tertera di bawah ini :";
		}elseif($sp_ke==2){
			$ket ="dua";
			$pembuka = "Menindaklanjuti Surat Peringatan Pertama, Peserta Didik yang tertera dibawah ini :";
		}elseif($sp_ke==3){
			$ket ="tiga";
			$pembuka = "Menindaklanjuti Surat Peringatan Kedua, Peserta Didik yang tertera dibawah ini :";
		}

	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Print Surat Peingatan <?php echo $siswa['nama']; ?></title>
	<link rel="icon" href="../../assets/images/defaultimage.png">
</head>
<body style="font-family: arial; font-size: 25px; overflow-x: hidden;" onload="window.print()">
	<div style="width: 100%; height: 1123px;margin-top: 5.9cm;">
		<div style="margin-left: 66%; width: 24%; margin-top: 2%;">
					<t>Kepada : </t><br>
					<t>Orang tua peserta didik</t><br>
					<t style="font-weight: bolder;"><?php echo $siswa['nama']; ?></t><br>
					<t>di <br><span style="margin-left: 50px;">Tempat</span></t>
				</div><br><br>
			<div style="width: 100%; text-align: center;">
				<b><u style=" font-size: 22px;"><t style="font-weight: bolder;">S U R A T&nbsp; P E R I N G A T A N&nbsp; <?php echo $sp_ke; ?></t></u></b><br>
				<t>No. <?php echo $data_sp['no_surat']; ?></t>
			</div>
			<br>
			<!-- pembuka -->
			<div style="margin-left: 10%; ">
				<t><?php echo $pembuka; ?></t>
			</div>
			<!-- end pembuka -->
			<br>
			<div style="margin-left: 10%;">
				<table style="">
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><?php echo $data_sp['nama']; ?></td>

					</tr>
					<tr>
						<td>NIS</td>
						<td>:</td>
						<td><?php echo $data_sp['nis']; ?></td>
					</tr>
					<tr>
						<td>Rombel</td>
						<td>:</td>
						<td><?php echo $data_sp['rombel']; ?></td>
					</tr>
					<tr>
						<td>Rayon</td>
						<td>:</td>
						<td><?php echo $data_sp['rayon']; ?></td>
					</tr>
					<tr>
						<td>Kompetensi Keahlian</td>
						<td>:</td>
						<td><?php echo $data_sp['jurusan']; ?></td>
					</tr>
					<tr>
						<td>Skor Pelanggaran</td>
						<td>:</td>
						<td><?php echo $data_sp['jumlah_skor']; ?></td>
					</tr>
				</table>
				<div style="width: 88%;">
					<p style="text-align: justify;">Telah melakukan pelanggaran yang patut mendapatkan Surat Peringatan <?php echo $sp_ke." (".$ket.")"; ?>. Pihak orang tua diminta lebih memperhatikan perkembangan Peserta Didik tersebut demi terciptanya suasana belajar yang kondusif.</p>
					<p>Surat Peringatan ini disampaikan untuk dijadikan perhatian.</p>
				</div><br><br><br>
				<div style="margin-left: 62%; width: 100%;">
					<t>Bogor, <?php $aksi->format_tanggal(date('Y-m-d')); ?></t><br>
					<t style="font-weight: bolder;">Kepala SMK Wikrama</t><br><br><br><br><br><br>
					<t style="font-weight: bolder;"><?php echo $guru['nama']; ?>.</t>
				</div><br><br><br><br>
				<div style="margin-left: 2%; width: 630px;margin-top: -10px;">
					<t style="font-weight: bolder;">Tembusan : </t><br>
					<t>1. Wali Kelas</t><br>
					<t>2. Arsip</t>
				</div>
			</div>
		</div>
</body>
</html>