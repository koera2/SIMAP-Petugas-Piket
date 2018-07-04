<?php  

  @$id = $_GET['id'];
  if (isset($_GET['edit'])) {
    $edit = $aksi->edit("tbl_kinerja_siswa","id_kinerja = '$id'");

    if (isset($_POST['kelompok_kinerja'])) {
      $nis = $edit['nis'];
      $kelompok = $_POST['kelompok_kinerja'];
      $cari_kode = "SELECT * FROM tbl_poin_kinerja WHERE kelompok_kinerja = '$kelompok'";
    }else{
      $nis = $edit['nis'];
      $kelompok = $edit['kelompok_kinerja'];
      $cari_kode = "SELECT * FROM tbl_poin_kinerja WHERE kelompok_kinerja = '$kelompok'";
    }

    if (isset($_POST['kode_kinerja'])) {
      $kode_kinerja = $_POST['kode_kinerja'];
    }else{
       $kode_kinerja = $edit['kode_kinerja'];
    }

    $re = "readonly";
  }else{
    if (isset($_POST['nis'])) {
      $nis = $_POST['nis'];
    }

    if (isset($_POST['kelompok_kinerja'])) {
      $kelompok = $_POST['kelompok_kinerja'];
      $cari_kode = "SELECT * FROM tbl_poin_kinerja WHERE kelompok_kinerja = '$kelompok'";
    }

    if (isset($_POST['kode_kinerja'])) {
      $kode_kinerja = $_POST['kode_kinerja'];
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
        <div class="col-sm-10">
          <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?php echo $siswa['nama'] ?>" readonly required>
        </div>
      </div>      
      <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Rombel</label>

        <div class="col-sm-10">
          <input type="text" class="form-control" name="rombel" value="<?php echo $rombel['rombel'] ?>" placeholder="Rombel" readonly required>
        </div>
      </div>
      <div class="form-group">
        <label for="inputExperience" class="col-sm-2 control-label">Rayon</label>

        <div class="col-sm-10">
          <input type="text" class="form-control" name="rayon" placeholder="Rayon" value="<?php echo $siswa['kode_rayon'] ?>" readonly required>
        </div>
      </div>
      <div class="form-group">
        <label for="inputSkills" class="col-sm-2 control-label">Kelompok</label>

        <div class="col-sm-10">
        	<select name="kelompok_kinerja"  class="form-control" onchange="submit()">
        		<option value="" selected disabled>PILIH KELOMPOK</option>
        		<option value="PUNISHMENT" <?php if(@$kelompok=="PUNISHMENT"){echo "selected";} ?>>PUNISHMENT</option>
        		<option value="REWARD" <?php if(@$kelompok=="REWARD"){echo "selected";} ?>>REWARD</option>
        	</select>
          &nbsp;<span style="color: blue;font-size: 10px;">[ TEKAN TAB ]</span>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-2 control-label">Kinerja</label>
        <div class="col-sm-10">
          <select class="form-control" name="kode_kinerja" onchange="submit()" required>
            <option value="" selected disabled>PILIH KINERJA</option>
            <?php  
              $kodes = mysql_query($cari_kode);
              while ($kode = mysql_fetch_array($kodes)) { ?>
                <option value="<?php echo $kode['kode_kinerja']; ?>" <?php if(@$kode_kinerja==$kode['kode_kinerja']){echo "selected";} ?>><?php echo $kode['kode_kinerja']." - ".$kode['nama_kinerja']; ?></option>
            <?php } ?>
          </select>
          &nbsp;<span style="color: blue;font-size: 10px;">[ TEKAN TAB ]</span>
        </div>
      </div>

          <?php  
              @$cek = $aksi->cekdata("tbl_kinerja_siswa WHERE nis = '$siswa[nis]' AND kode_kinerja = '$kode_kinerja'");
              if (empty($cek)) {
                $skor = $kinerja['skor1'];
              }elseif ($cek == 1) {
                $skor = $kinerja['skor2'];
              }else{
                $skor = $kinerja['skor3'];
              }
           
            if (!empty($kinerja['kode_kinerja'])) {  ?>
                 <div class="form-group">
                  <label class="col-sm-2 control-label">Tejadi Pada</label>
                  <div class="col-sm-10">
                  <div id='uraian'>
                      <div class="alert" id="pri" role="alert">
                        Ini adalah Kinerja ke - <?php echo @$cek+1; ?> <strong><?php echo $siswa['nama']; ?></strong> Melakukan poin <strong> <?php echo $kinerja['kode_kinerja']; ?> (<?php echo $kinerja['nama_kinerja']; ?>)</strong>
                      </div>
                      <?php 
                        if ($kinerja['kelompok_kinerja']=="PUNISHMENT") { ?>
                            <div class="alert" id="pri" role="alert">
                                  <h4><?php echo "Skor 1 : +".$kinerja['skor1'].",  Skor 2 : +".$kinerja['skor2'].",  Skor > 3 : +".$kinerja['skor3']; ?></h4>
                            </div>
                       <?php } ?>
                    </div>
                  </div>
              </div> 
          <?php } ?>

      <div class="form-group">
      	<div class="col-sm-offset-2 col-sm-10">
      		<table class="table table-bordered table-striped">
      			<thead>
      				<tr>
          				<th>Tanggal Kejadian</th>
          				<th>Skor</th>
          				<th>Saksi</th>
      				</tr>
      			</thead>
      			<tbody>
      				<tr>
          				<td>
          					<input type="date" class="form-control" name="tgl_kejadian" required value="<?php if(@$_GET['id']==""){echo date("Y-m-d");}else{echo @$edit['tgl_kejadian'];} ?>">
          				</td>
          				<td><center><?php echo $skor; ?></center></td>
          				<td>
          					<input type="text" name="saksi"  class="form-control" autocomplete="off" required list="saksi" placeholder="Pilih Saksi..." value="<?php echo @$edit['saksi'] ?>">
                    <datalist id="saksi">
                      <option value="GDN">GDN</option>
                      <option value="pramuka">Pramuka</option>
                      <?php  
                        $sql = mysql_query("SELECT * FROM tbl_pegawai");
                        while ($r = mysql_fetch_array($sql)) {?>
                          <option value="<?php echo $r['nama'] ?>"><?php echo $r['nip']."-".$r['nama']; ?></option>
                      <?php } ?>
                    </datalist>
          				</td>
          			</tr>
      			</tbody>			                  			
      		</table>
      	</div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <?php if (@$_GET['id']=="") { ?>
                <input type="submit" name="simpan" class="btn btn-lg btn-primary col-md-4" value="Simpan">
                <a href="?menu=kinerja_form&input" style="margin-left: 10px;" class="btn btn-danger btn-lg col-md-3" onclick="return alert('Yakin akan reset data ?');">Reset</a>
          <?php }else{ ?>
                <input type="submit" name="ubah" class="btn btn-lg btn-success col-md-4" value="Ubah">
                <a href="?menu=kinerja_form&daftar" style="margin-left: 10px;" class="btn btn-danger btn-lg col-md-3">Batal</a>
          <?php } ?>
           
        </div>
      </div>
      <br> <br> <br>
    </form>
	</div>
</div>

<?php  
  $table = "tbl_kinerja_siswa";
  $where = "id_kinerja = '$id'";
  $redirect = "?menu=kinerja_form&input";
  $redirect1 = "?menu=kinerja_form&daftar";

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

  if (@$_POST['kelompok_kinerja']=="PUNISHMENT") {
    $skor_r = 0;
    $skor_p = $skor;
  }else{
    $skor_r = $skor;
    $skor_p = 0;
  }

  $field = array(
    'tahun_pelajaran'=>$_SESSION['tp'],
    'semester'=>$semester,
    'nis'=>@$_POST['nis'],    
    'nama'=>@$_POST['nama'],    
    'rombel'=>@$_POST['rombel'],    
    'kode_rayon'=>@$_POST['rayon'],    
    'kelompok_kinerja'=>@$_POST['kelompok_kinerja'],    
    'kode_kinerja'=>@$_POST['kode_kinerja'],    
    'skor_p'=>$skor_p,    
    'skor_r'=>$skor_r,    
    'tgl_kejadian'=>@$_POST['tgl_kejadian'],    
    'saksi'=>@$_POST['saksi'],    
  );

  $field1 = array(
    'kelompok_kinerja'=>@$_POST['kelompok_kinerja'],    
    'kode_kinerja'=>@$_POST['kode_kinerja'],    
    'skor_p'=>$skor_p,    
    'skor_r'=>$skor_r,    
    'tgl_kejadian'=>@$_POST['tgl_kejadian'],    
    'saksi'=>@$_POST['saksi'],    
  );

  if (isset($_POST['simpan'])) {
    $aksi->simpan($table,$field,$redirect);
    $aksi->alert("Data Berhasil Disimpan",$redirect);
  }

  if (isset($_POST['ubah'])) {
    $aksi->update($table,$field1,$where);
    $aksi->alert("Data Berhasil Diubah",$redirect1);
  }
 
?>