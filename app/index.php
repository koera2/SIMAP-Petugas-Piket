<?php  
	include 'config/koneksi.php';
	include 'library/fungsi.php';

	session_start();
	date_default_timezone_set("Asia/Jakarta");

	$aksi = new oop();

	$table = "tbl_pegawai";
	$alamat = "hal_utama.php?menu=dashboard";
	@$nip = mysql_real_escape_string($_POST['nip']);
	@$password = mysql_real_escape_string($_POST['password']);

	if (@$_SESSION['nip']!="") {
		$aksi->redirect($alamat);
	}

	if (isset($_POST['login'])) {
		$sql = mysql_query("SELECT * FROM $table WHERE nip = '$nip' AND password = '$password'");
		$data = mysql_fetch_array($sql);
		$cek = mysql_num_rows($sql);
		if ($cek > 0) {
			if ($data['hak_akses']=="piket" OR $data['hak_akses']=="kesiswaan") {
				$_SESSION['nip'] = $data['nip'];
				$_SESSION['nama'] = $data['nama'];
				$_SESSION['tp'] = $_POST['tp'];
				$_SESSION['foto'] = $data['foto'];
				$_SESSION['hak_akses'] = $data['hak_akses'];
				$aksi->alert("Login Berhasil, Selamat Datang ".$data['nama'], $alamat);
			}else{
				$aksi->pesan("Maaf Akses ".$data['hak_akses']." Tidak Bisa Mengakses Aplikasi ini !!!");
			}
		}else{
			$aksi->pesan("username atau password salah !!!");
		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PETUGAS PIKET | LOGIN</title>
	<link rel="shortcut icon" href="assets/images/defaultimage.png">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<br> <br> <br> <br> <br> <br>
<body style="background: url(assets/images/b.jpg);">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div style="padding-bottom: 50px;padding-top: 5px;">
								<img src="assets/images/logowk.png" width="90" height="90">
							</div>
							<div style="margin-top: -125px;margin-left: 110px;font-size: 110%">
								A P L I K A S I &nbsp;&nbsp;&nbsp;S I M A P &nbsp;&nbsp;&nbsp;
								P E T U G A S&nbsp;&nbsp;&nbsp; P I K E T
							</div>
							<div style="margin-left: 110px;margin-top: 2px;margin-bottom:10px; ; font-size: 200%">
								<strong>FORM LOGIN</strong>
							</div>
						</div>
						<div class="panel-body">
							<form method="post">
								<div class="col-md-12">
									<div class="form-group">
										<label>NIP</label>
										<div class="input-group" style="margin:0 2px;">
											<span class="input-group-addon"><div class="glyphicon glyphicon-user"></div></span>
											<input type="text" name="nip" class="form-control" placeholder="Masukan Nip Anda ..." maxlength="15" required value="" tabindex="0" autofocus autocomplete="off" list="nip">
											<datalist id="nip">
												<?php  
													$sql = mysql_query("SELECT * FROM $table WHERE hak_akses = 'piket' OR hak_akses = 'kesiswaan'");
													while ($r = mysql_fetch_array($sql)) { ?>
														<option value="<?php echo $r['nip'] ?>"><?php echo $r['nama']."-".$r['hak_akses']; ?></option>
													
													<?php } ?>
											</datalist>
										</div>
									</div>
									<div class="form-group">
										<label>PASSWORD</label>
										<div class="input-group col-md-12" style="margin:0 2px;">
											<div class="input-group-addon"><div class="glyphicon glyphicon-lock"></div></div>
											<input type="password" name="password" id="password" class="form-control" placeholder="Masukan password Anda ..."  tabindex="0" minlength="5" maxlength="50" required value="" autocomplete="off">
										</div>
									</div>
									<div class="form-group">
										<label>TAHUN PELAJARAN</label>
										<div class="input-group" style="margin:0 2px;">
											<span class="input-group-addon"><div class="glyphicon glyphicon-globe"></div></span>
											<select class="form-control" name="tp" required>
												<?php  
													for ($i=date("Y"); $i >=2013 ; $i--) {
														$b = $i+1;
														$cek_bulan = date("m");
														if ($cek_bulan <=7) {
															$tp = ($i-1)."-".$i;
														 }else{
														 	$tp = $i."-".$b;
														 } ?>
												<option value="<?php echo $tp ?>"><?php echo $tp; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<input type="submit" name="login" class="btn btn-login btn-lg btn-primary btn-block" value="LOGIN">
									</div>
								</div>
							</form>
						</div>
						<div class="panel-footer">
							<center>&copy;2018 - RPL XII-3</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/js/jquery-2.2.3.min.js"></script>
	<script src="assets/js/jquery-ui.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/show-password.js"></script>
	<script>
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
</body>
</html>