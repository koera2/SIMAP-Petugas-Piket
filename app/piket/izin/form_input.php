<?php  
  @$id = $_GET['id'];
  if (isset($_GET['edit'])) {
    $edit = $aksi->edit("tbl_izin_siswa","id_izin = '$id'");
    $nis = $edit['nis'];

    $re = "readonly";
  }else{
    if (isset($_POST['nis'])) {
      $nis = $_POST['nis'];
    }

    $re="";
  }


    @$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$nis'");
    @$rombel = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$siswa[kode_rombel]'");
    @$kinerja = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$kode_kinerja'");
?>
<div class="col-md-12">
	<div class="col-md-2"></div>
	<div class="col-md-8">
  	<form method="post" class="form-horizontal">
      <div class="form-group">
        <label  class="col-sm-2 control-label">NIS</label>
        <div class="col-sm-4">
          <input type="text" name="nis" class="form-control" required maxlength="8" minlength="8" value="<?php if(@$_GET['id']==""){echo @$siswa['nis'];}else{ echo @$edit['nis']; } ?>" placeholder="Masukan NIS siswa..." list="list_nis" onkeypress="return event.charCode >= 48 && event.charCode <=57" onchange="submit()" <?php echo @$re; ?>>
          &nbsp;<span style="color: blue;font-size: 10px;">[ TEKAN TAB ]</span>
          <datalist id="list_nis">
            <?php  
              $sql = mysql_query("SELECT * FROM tbl_siswa");
              while($a = mysql_fetch_array($sql)){ ?>
                <option value="<?php echo $a['nis']; ?>"><?php echo $a['nama']; ?></option>
            <?php } ?>
          </datalist>
        </div>
      </div>

      <div class="form-group">
        <label  class="col-sm-2 control-label">Nama</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?php echo $siswa['nama'] ?>" readonly required>
        </div>
      </div>    

      <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Rombel</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="rombel" value="<?php echo $rombel['rombel'] ?>" placeholder="Rombel" readonly required>
        </div>
      </div>

      <div class="form-group">
        <label for="inputExperience" class="col-sm-2 control-label">Rayon</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="rayon" placeholder="Rayon" value="<?php echo $siswa['kode_rayon'] ?>" readonly required>
        </div>
      </div>

       <div class="form-group">
        <label  class="col-sm-2 control-label">Tanggal</label>
        <div class="col-sm-9">
          <input type="date" class="form-control" name="tgl_izin" placeholder="Tanggal" value="<?php if(@$_GET['id']==""){echo date("Y-m-d");}else{echo @$edit['tgl_izin'];} ?>" required>
        </div>
      </div>
      <div class="form-group">
        <label  class="col-sm-2 control-label">Penanggung Jawab</label>
        <div class="col-sm-9">
            <input type="text" name="pj"  class="form-control" autocomplete="off" required list="saksi" placeholder="Pilih Penanggung Jawab..." value="<?php echo @$edit['pj_izin'] ?>">
              <datalist id="saksi">
                <?php  
                  $sql = mysql_query("SELECT * FROM tbl_pegawai");
                  while ($r = mysql_fetch_array($sql)) {?>
                    <option value="<?php echo $r['nama'] ?>"><?php echo $r['nip']."-".$r['nama']; ?></option>
                <?php } ?>
              </datalist>
        </div>
      </div>

      <div class="form-group">
        <label for="inputSkills" class="col-sm-2 control-label">Jenis Izin</label>

        <div class="col-sm-9">
          <select name="jenis_izin"  class="form-control" required>
            <option value="" selected disabled>PILIH JENIS IZIN</option>
            <option value="IZIN KELUAR" <?php if(@$edit['jenis_izin']=="IZIN KELUAR"){echo "selected";} ?>>IZIN KELUAR</option>
            <option value="PULANG MALAM" <?php if(@$edit['jenis_izin']=="PULANG MALAM"){echo "selected";} ?>>PULANG MALAM</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="inputSkills" class="col-sm-2 control-label">Keperluan</label>

        <div class="col-sm-9">
          <textarea name="keperluan" class="form-control" required rows="3" placeholder="Masukan Keperluan Siswa Izin"><?php echo @$edit['keperluan']; ?></textarea>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <?php if (@$_GET['id']=="") { ?>
                <input type="submit" name="simpan" class="btn btn-lg btn-primary col-md-4" value="Simpan">
                <a href="?menu=izin_form&input" style="margin-left: 10px;" class="btn btn-danger btn-lg col-md-3" onclick="return alert('Yakin akan reset data ?');">Reset</a>
          <?php }else{ ?>
                <input type="submit" name="ubah" class="btn btn-lg btn-success col-md-4" value="Ubah">
                <a href="?menu=izin_form&daftar" style="margin-left: 10px;" class="btn btn-danger btn-lg col-md-3">Batal</a>
          <?php } ?>
           
        </div>
      </div>
    </form>
    <br> <br> <br> 
  </div>
</div>
<?php  
  $table = "tbl_izin_siswa";
  $where = "id_izin = '$id'";
  $redirect = "?menu=izin_form&input";
  $redirect1 = "?menu=izin_form&daftar";

  $tahun = substr(@$_POST['tgl_izin'], 0,4);
  $bulan = substr(@$_POST['tgl_izin'], 5,2);
  $masuk = $siswa['tahun_masuk'];
  $selisih = $tahun-$masuk;
//logika menentukan semester
  if ($selisih == "0" ) {
      $semester = "I";
  }elseif ($selisih=="1" && $bulan < 8) {
      $semester = "II";
  }elseif ($selisih=="1" && $bulan > 7) {
      $semester = "III";
  }elseif ($selisih=="2" && $bulan < 8) {
      $semester = "IV";
  }elseif ($selisih=="2" && $bulan > 7) {
      $semester = "V";
  }elseif ($selisih=="3" && $bulan < 8) {
      $semester = "VI";
  }else{
      $semester = "";
  }
//end logika menentukan semester 

  $field = array(
    'tahun_pelajaran'=>$_SESSION['tp'],
    'semester'=>$semester,
    'jenis_izin'=>@$_POST['jenis_izin'],    
    'tgl_izin'=>@$_POST['tgl_izin'],    
    'keperluan'=>@$_POST['keperluan'],    
    'nis'=>@$_POST['nis'],    
    'nama'=>@$_POST['nama'],    
    'rombel'=>@$_POST['rombel'],    
    'kode_rayon'=>@$_POST['rayon'],    
    'id_pegawai'=>$_SESSION['nip'],
    'pj_izin'=>@$_POST['pj'],
  );

  $field1 = array(
    'jenis_izin'=>@$_POST['jenis_izin'],    
    'tgl_izin'=>@$_POST['tgl_izin'],    
    'keperluan'=>@$_POST['keperluan'],    
    'semester'=>$semester,
    'user_update'=>$_SESSION['nip'],
  );

  if (isset($_POST['simpan'])) {
    $aksi->simpan($table,$field);
    $aksi->alert("Data Berhasil Disimpan",$redirect);
  }

  if (isset($_POST['ubah'])) {
    $aksi->update($table,$field1,$where);
    $aksi->alert("Data Berhasil Diubah",$redirect1);
  }

?>