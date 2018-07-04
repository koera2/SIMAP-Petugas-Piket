<?php  
	if (!empty($_GET['nis'])) {
	    $nis = $_GET['nis'];
	    $sp_ke = $_GET['sp'];
		$table = "tbl_sp";
		$where = "nis = '$nis' AND sp_ke ='$sp_ke'";


	    @$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$nis'");
	    @$rombel = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$siswa[kode_rombel]'");
	    @$sp = $aksi->caridata("tbl_sp WHERE nis = '$nis' AND sp_ke='$sp_ke'");
	    if ($rombel['jurusan']=="RPL") {
		    $jurusan = "Rekayasa Perangkat Lunak";
	    }elseif ($rombel['jurusan']=="MMD") {
		    $jurusan = "Multimedia";
	    }elseif ($rombel['jurusan']=="TKJ") {
		    $jurusan = "Teknik Komputer dan Jaringan";
	    }elseif ($rombel['jurusan']=="APK") {
		    $jurusan = "Administrasi Perkantoran";
	    }elseif ($rombel['jurusan']=="PMN") {
		    $jurusan = "Pemasaran";
	    }elseif ($rombel['jurusan']=="BDP") {
		    $jurusan = "Bisnis Daring dan Pemasaran";
	    }elseif ($rombel['jurusan']=="OTKP") {
		    $jurusan = "Otomatisasi Tata Kelola Perkantoran";
	    }elseif ($rombel['jurusan']=="TBG") {
		    $jurusan = "Tata Boga";
	    }elseif ($rombel['jurusan']=="HTL") {
		    $jurusan = "Akomodasi Perhotelan";
	    }
	    $jenis_surat = "Surat Peringatan ".$sp_ke;
	    $no_surat = "422.2//SMK Wikrama/".date('m')."/".date('Y');

	    if (isset($_POST['cetak'])) {
	    	$field = array(
	    		'jurusan'=>$jurusan,
	    		'no_surat'=>$_POST['no_surat'],
	    		'status'=>1,
	    		'proses_pembimbing'=>1,
	    		'proses_kesiswaan'=>1,
	    		'tanggal_cetak'=>date("Y-m-d"),
	    	);
	    	$aksi->update($table,$field,$where);
	    	echo "<script>window.open('piket/sp/cetak.php?sp=$sp_ke&nis=$nis')</script>";
	    	$aksi->redirect("?menu=surat_peringatan&daftar");
	    }

?>
<div class="col-md-12">
	<div class="col-md-1"></div>
	<div class="col-md-8">
	  	<form method="post" class="form-horizontal">
	   		<div class="form-group">
		        <label  class="col-sm-3 control-label">NIS</label>
		        <div class="col-sm-4">
		          <input type="text" name="nis" class="form-control" readonly value="<?php echo $sp['nis'] ?>">
		        </div>
	    	</div>

		    <div class="form-group">
		        <label  class="col-sm-3 control-label">Nama</label>
		        <div class="col-sm-9">
		          <input type="text" class="form-control" name="nama"  value="<?php echo $sp['nama'] ?>" readonly required>
		        </div>
		    </div>    

		    <div class="form-group">
		        <label for="inputName" class="col-sm-3 control-label">Rombel</label>
		        <div class="col-sm-9">
		          <input type="text" class="form-control" name="rombel" value="<?php echo $sp['rombel'] ?>" readonly required>
		        </div>
		    </div>

		    <div class="form-group">
		        <label for="inputExperience" class="col-sm-3 control-label">Rayon</label>
		        <div class="col-sm-9">
		          <input type="text" class="form-control" name="rayon" value="<?php echo $sp['rayon'] ?>" readonly required>
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="col-sm-3 control-label">Kompetisi Keahlian</label>
		        <div class="col-sm-9">
		          <input type="text" class="form-control" name="jurusan"  value="<?php echo $jurusan; ?>" readonly required>
		        </div>
		    </div>

		    <div class="form-group">
		        <label  class="col-sm-3 control-label">Jenis Surat</label>
		        <div class="col-sm-9">
				    <input type="text" class="form-control" name="jenis" value="<?php echo $jenis_surat; ?>" readonly required>
		        </div>
		    </div>

		    <div class="form-group">
		        <label  class="col-sm-3 control-label">Total Skor</label>
		        <div class="col-sm-9">
				    <input type="text" class="form-control" name="skor"  value="<?php echo $sp['jumlah_skor'] ?>" readonly required>
		        </div>
		    </div>

		    <div class="form-group">
		        <label  class="col-sm-3 control-label">No.Surat</label>
		        <div class="col-sm-9">
				    <input type="text" class="form-control" autofocus name="no_surat" value="<?php echo $no_surat ?>"  required>
		        </div>
		    </div>

		    <div class="form-group">
		        <div class="col-sm-offset-3 col-sm-10">
		            <input type="submit" name="cetak" class="btn btn-lg btn-primary col-md-4" value="Cetak">
		            <a href="?menu=surat_peringatan&daftar" style="margin-left: 10px;" class="btn btn-lg btn-danger col-md-3">Batal</a>
		           
		        </div>
		   	</div>
	    </form>
    <br> <br> <br> 
  </div>
</div>
<?php }else{ ?>
<div class="col-md-12">
	<h4 class="text-info">Klik <b>Tindak Lanjut</b> pada daftar siswa yang terkena Surat Peringatan agar bisa memproses lebih lanjut</h4>
</div>
<?php } ?>