<?php  
	if (!isset($_GET['menu'])) {
		header("location:hal_utama.php?menu=profil");
	}
	$r = $aksi->caridata("tbl_pegawai WHERE nip = '$_SESSION[nip]'");
	if ($r['status_kepegawaian']=="GTY") {
		$status = "Guru Tetap Yayasan";
	}elseif($r['status_kepegawaian']=="GTT") {
		$status = "Gutu Tidak Tetap";
	}elseif($r['status_kepegawaian']=="STY") {
		$status = "Staf Tetap Yayasan";
	}elseif($r['status_kepegawaian']=="STT") {
		$status = "Staf Tidak Tetap";
	}

	$table = "tbl_pegawai";
	$tempat = "assets/images";
	$upload = $aksi->upload($tempat);

	$field = array(
		'nama'=>@$_POST['nama'],
		'password'=>@$_POST['password'],
		'jk'=>@$_POST['jk'],
		'no_telepon'=>@$_POST['no_telepon'],
		'email'=>@$_POST['email'],
		'alamat'=>@$_POST['alamat'],
		'foto'=>$upload,
	);
	$field1 = array(
		'nama'=>@$_POST['nama'],
		'password'=>@$_POST['password'],
		'jk'=>@$_POST['jk'],
		'no_telepon'=>@$_POST['no_telepon'],
		'email'=>@$_POST['email'],
		'alamat'=>@$_POST['alamat'],
	);
	if (isset($_POST['simpan'])) {
		if (empty($_FILES['foto']['name'])) {
			$aksi->update($table,$field1,"nip = '$_SESSION[nip]'");
			$aksi->alert("Data Berhasil diubah","?menu=profil");
			$_SESSION['nama']=@$_POST['nama'];
		}else{
			$aksi->update($table,$field,"nip = '$_SESSION[nip]'");
			$aksi->alert("Data Berhasil diubah","?menu=profil");
			$_SESSION['nama']=@$_POST['nama'];
			$_SESSION['foto']=$upload;
		}
	}
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
	        Profil
        <small><?php echo $_SESSION['nama']; ?></small>
      	</h1>
	    <ol class="breadcrumb">
	        <li><a href="?menu=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
	    	<li class="active">Profil User</li>
	    </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-4">
					<div class="box box-primary">
			            <div class="box-body box-profile">
			              <img class="profile-user-img img-responsive img-circle" src="assets/images/<?php echo $_SESSION['foto'] ?>" alt="User profile picture">

			              <h3 class="profile-username text-center"><?php echo $_SESSION['nama']; ?></h3>

			              <p class="text-muted text-center"><?php echo $_SESSION['nip']; ?></p>
			              <hr>

			              <strong><i class="fa fa-male margin-r-5"></i> Hak Akses</strong>
			              <p class="text-muted"><?php echo $_SESSION['hak_akses']; ?></p>
			              <hr>
			              <strong><i class="fa fa-random margin-r-5"></i> Status Kepegawaian</strong>
			              <p class="text-muted"><?php echo $status; ?></p>
			              <hr>
			              <strong><i class="fa fa-phone margin-r-5"></i> No.Telepon</strong>
			              <p class="text-muted"><?php echo $r['no_telepon']; ?></p>
			              <hr>
			               <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
			              <p class="text-muted"><?php echo $r['alamat']; ?></p>
			              <hr>
			              <form method="post">
				              <button type="submit" name="ubah" class="btn btn-primary btn-lg btn-block">UBAH</button>
			              </form>
			            </div>
			        </div>
				</div>
				<?php  
					if (!isset($_POST['ubah'])) {
						$read = "readonly";
						$dis = "disabled='disabled'";
						$a = "disabled";
					}else{
						$read = "";
						$dis = "";
						$a = "";
					}
				?>
				<div class="col-md-8">
					<div class="box box-primary">
						<div class="box-body">
							<div class="col-md-12">
								<center><h3 class="text-muted">UBAH PROFIL ANDA</h3></center>
								<hr>
								<form method="post" class="form-horizontal" enctype="multipart/form-data">
									<div class="form-group">
								        <label  class="col-sm-2 control-label">NIP</label>
								        <div class="col-sm-9">
								          <input type="text" class="form-control" name="nip" placeholder="Masukan NIP Anda...." required value="<?php echo @$r['nip']; ?>" readonly>
								        </div>
								    </div>
								    <div class="form-group">
								        <label  class="col-sm-2 control-label">Password</label>
								        <div class="col-sm-9">
								          <input type="password" id="password" minlength="8" maxlength="50" class="form-control" name="password" placeholder="Masukan password Anda...." required value="<?php echo @$r['password']; ?>" <?php echo @$read; ?>>
								        </div>
								    </div>
								    <div class="form-group">
								        <label  class="col-sm-2 control-label">Nama</label>
								        <div class="col-sm-9">
								          <input type="text" class="form-control" name="nama" placeholder="Masukan Nama Anda...." minlength="5" maxlength="100" required value="<?php echo @$r['nama']; ?>" <?php echo @$read; ?>>
								        </div>
								    </div>
								    <div class="form-group">
								        <label  class="col-sm-2 control-label">Jenis Kelamin</label>
								        <div class="col-sm-9">
								        	<select class="form-control" name="jk" required <?php echo @$dis; ?>>
								        		<option value="L" <?php if(@$r['jk']=="L"){echo "selected";} ?>>Laki-laki</option>
								        		<option value="P" <?php if(@$r['jk']=="P"){echo "selected";} ?>>Perempuan</option>
								        	</select>
								        </div>
								    </div>
								    <div class="form-group">
								        <label  class="col-sm-2 control-label">No.Telepon</label>
								        <div class="col-sm-9">
								          <input type="text" class="form-control" minlength="9" maxlength="15" name="no_telepon" placeholder="Masukan No.Telepon Anda...." required value="<?php echo @$r['no_telepon']; ?>" <?php echo @$read; ?> onkeypress="return event.charCode >= 48 && event.charCode <=57">
								        </div>
								    </div>
								    <div class="form-group">
								        <label  class="col-sm-2 control-label">Email</label>
								        <div class="col-sm-9">
								          <input type="email" class="form-control" name="email" minlength="10" maxlength="50" placeholder="Masukan Email Anda...." required value="<?php echo @$r['email']; ?>" <?php echo @$read; ?>>
								        </div>
								    </div>
								    <div class="form-group">
								        <label  class="col-sm-2 control-label">Alamat</label>
								        <div class="col-sm-9">
								        	<textarea placeholder="Masukan Alamat Anda" rows="4" class="form-control" required name="alamat" <?php echo @$read; ?>><?php echo @$r['alamat']; ?></textarea>
								        </div>
								    </div>
								     <div class="form-group">
								        <label  class="col-sm-2 control-label">Status Kepegawaian</label>
								        <div class="col-sm-9">
								          <input type="text" class="form-control" name="status" readonly placeholder="Masukan Status Anda...." required value="<?php echo @$status; ?>">
								        </div>
								    </div>     
								    <div class="form-group">
								        <label  class="col-sm-2 control-label">Hak Akses</label>
								        <div class="col-sm-9">
								          <input type="text" class="form-control" name="akses" readonly placeholder="Masukan Akses Anda...." required value="<?php echo @$r['hak_akses']; ?>">
								        </div>
								    </div>     
								    <div class="form-group">
								        <label  class="col-sm-2 control-label">Foto</label>
								        <div class="col-sm-9">
								          <input type="file" class="form-control" name="foto" placeholder="Buka Folder" <?php echo @$read; ?>>
								        </div>
								    </div>
								     <div class="form-group">
								        <label  class="col-sm-2 control-label">&nbsp;</label>
								        <div class="col-sm-9">
								          <input type="submit" class="btn btn-lg btn-success" name="simpan" value="SIMPAN PERUBAHAN" <?php echo @$dis; ?>>
								          <a href="?menu=profil" class="btn btn-lg btn-danger <?php echo @$a ?>">BATAL</a>
								        </div>
								    </div>
								</form>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</section>
</div>