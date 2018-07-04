<div class="col-md-12">
    <?php 
        if (@$_GET['nis']=="") { ?>
        	<div class="panel panel-default">
        		<div class="panel-heading">Daftar Siswa Yang Tidak Masuk Hari Ini</div>
        		<div class="panel-body">
        			<table id="absensi1" class="table table-bordered table-hover table-striped">
                        <thead>
                        	<tr>
                        		<th width="6%"><center>No.</center></th>
                        		<th><center>Nis</center></th>
                        		<th><center>Nama</center></th>
                        		<th><center>Rombel</center></th>
                        		<th><center>Rayon</center></th>
                        		<th><center>Ket</center></th>
                        		<th><center>Catatan</center></th>
                                <th><center>Aksi</center></th>
                        	</tr>
                        </thead>
                        <tbody>
                        	<?php  
                        		$no = 0;
                        		$table = "tbl_absensi_siswa";
                        		$today = date("Y-m-d");
                        		$where = "WHERE hadir != '1' AND tgl_absen = '$today'";
                        		$data = $aksi->tampil($table,$where,"ORDER BY nis ASC");
                        		if (empty($data)) { ?>
                        			<tr><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td><td></td><td></td></tr>
                    		<?php }else{
                        			foreach ($data as $r) {
                        				$no++;
                        				$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
                    				?>
                    				<tr>
        		             			<td align="center"><?php echo $no; ?>.</td>
        		             			<td align="center"><?php echo $r['nis']; ?></td>
        		             			<td><?php echo $r['nama']; ?></td>
        		             			<td align="center"><?php echo $r['rombel']; ?></td>
        		             			<td align="center"><?php echo $rayon['rayon']; ?></td>
        		             			<td align="center">
        	             				<?php  
        	             					if ($r['izin']=="1") {
        	             						echo "<span class='label label-success'><b>Izin</b></span>";
        	             					}elseif ($r['alpa']=="1") {
        	             						echo "<span class='label label-danger'><b>Alpa</b></span>";
        	             					}elseif ($r['sakit']=="1") {
        	             						echo "<span class='label label-warning'><b>Sakit</b></span>";
        	             					}elseif ($r['tugas']=="1") {
        	             						echo "<span class='label label-info'><b>Tugas</b></span>";
        	             					}
        		             			?>
        		             			</td>
        		             			<td align="center"><?php if($r['catatan']==""){ echo "-";}else{echo $r['catatan'];} ?></td>
                                        <td align="center"><a href="?menu=absensi_form&tidak_masuk&nis=<?php echo $r['nis']; ?>&tanggal=<?php echo date("Y-m-d"); ?>" class="btn btn-xs btn-primary">UBAH</a></td>
        		             		</tr>
                			<?php } } ?>
                        </tbody>
                    </table>
        		</div>
        	</div>
        <?php }else{ 
                $siswa = $aksi->caridata("tbl_siswa WHERE nis = '$_GET[nis]'");
                $today = date("Y-m-d");
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    UBAH ABSENSI - <?php echo $siswa['nama']." Tanggal ";$aksi->format_tanggal($today); ?>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <td width="4%" rowspan="2" align="center" style="padding-top: 30px;"><label>No.</label></td>
                                        <td rowspan="2" align="center" style="padding-top: 30px;"><label>Nis</label></td>
                                        <td rowspan="2" align="center" style="padding-top: 30px;"><label>Nama</label></td>
                                        <td rowspan="2" align="center" style="padding-top: 30px;"><label>JK</label></td>
                                        <td rowspan="2" align="center" style="padding-top: 30px;"><label>Rayon</label></td>
                                        <td colspan="5" align="center"><label>Keterangan</label></td>
                                        <td rowspan="2" align="center" style="padding-top: 30px;"><label>Catatan</label></td>
                                    </tr>
                                    <tr>
                                        <td align="center"><label>Hadir</label></td>
                                        <td align="center"><label>Sakit</label></td>
                                        <td align="center"><label>Izin</label></td>
                                        <td align="center"><label>Alpa</label></td>
                                        <td align="center"><label>Tugas</label></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $r = $aksi->caridata("tbl_absensi_siswa WHERE nis = '$_GET[nis]' AND tgl_absen = '$today'"); 
                                        if ($r['hadir'] == 1) {
                                            $hadir_cek = "checked";
                                            $sakit_cek = "";
                                            $izin_cek  = "";
                                            $alpa_cek  = "";
                                            $tugas_cek = "";
                                          }
                                          if ($r['sakit'] == 1) {
                                            $hadir_cek = "";
                                            $sakit_cek = "checked";
                                            $izin_cek  = "";
                                            $alpa_cek  = "";
                                            $tugas_cek = "";
                                          }
                                          if ($r['izin'] == 1) {
                                            $hadir_cek = "";
                                            $sakit_cek = "";
                                            $izin_cek  = "checked";
                                            $alpa_cek  = "";
                                            $tugas_cek = "";
                                          }
                                          if ($r['alpa'] == 1) {
                                            $hadir_cek = "";
                                            $sakit_cek = "";
                                            $izin_cek  = "";
                                            $alpa_cek  = "checked";
                                            $tugas_cek = "";
                                          }
                                           if ($r['tugas'] == 1) {
                                            $hadir_cek = "";
                                            $sakit_cek = "";
                                            $izin_cek  = "";
                                            $alpa_cek  = "";
                                            $tugas_cek = "checked";
                                          } 
                                        $rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
                                    ?>
                                    <tr>
                                        <td><center>1.</center></td>
                                        <td><?php echo $r['nis']; ?></td>
                                        <td><?php echo $r['nama']; ?></td>
                                        <td>
                                            <?php  
                                                if ($siswa['jk']=="L") {
                                                    echo "Laki-laki";
                                                }else{
                                                    echo "Perempuan";
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $rayon['rayon']; ?></td>
                                        <td align="center"><input type="radio" name="ket<?php echo $r['nis'] ?>" value="hadir" <?php echo $hadir_cek; ?>><br>Hadir</td>
                                        <td align="center"><input type="radio" name="ket<?php echo $r['nis'] ?>" value="sakit" <?php echo $sakit_cek; ?>><br>Sakit</td>
                                        <td align="center"><input type="radio" name="ket<?php echo $r['nis'] ?>" value="izin" <?php echo $izin_cek; ?>><br>Izin</td>
                                        <td align="center"><input type="radio" name="ket<?php echo $r['nis'] ?>" value="alpa" <?php echo  $alpa_cek; ?>><br>Alpa</td>
                                        <td align="center"><input type="radio" name="ket<?php echo $r['nis'] ?>" value="tugas"<?php  echo $tugas_cek; ?>><br>Tugas</td>
                                        <td align="center"><input type="text" value="<?php echo $r['catatan']; ?>" class="form-control" name="catatan<?php echo $r['nis']; ?>"></td>
                                    </tr>
                                    <?php  
                                        if(@$_POST['ket'.$r['nis']]=="hadir") {
                                            $hadir = "1";
                                            $alpa = "0";
                                            $izin = "0";
                                            $sakit = "0";
                                            $tugas = "0";
                                        }elseif(@$_POST['ket'.$r['nis']]=="alpa") {
                                            $hadir = "0";
                                            $alpa = "1";
                                            $izin = "0";
                                            $sakit = "0";
                                            $tugas = "0";
                                        }elseif(@$_POST['ket'.$r['nis']]=="izin") {
                                            $hadir = "0";
                                            $alpa = "0";
                                            $izin = "1";
                                            $sakit = "0";
                                            $tugas = "0";
                                        }elseif(@$_POST['ket'.$r['nis']]=="sakit") {
                                            $hadir = "0";
                                            $alpa = "0";
                                            $izin = "0";
                                            $sakit = "1";
                                            $tugas = "0";
                                        }elseif(@$_POST['ket'.$r['nis']]=="tugas") {
                                            $hadir = "0";
                                            $alpa = "0";
                                            $izin = "0";
                                            $sakit = "0";
                                            $tugas = "1";
                                        }

                                        $field = array(
                                            'hadir'=>@$hadir,
                                            'alpa'=>@$alpa,
                                            'izin'=>@$izin,
                                            'sakit'=>@$sakit,
                                            'tugas'=>@$tugas,
                                            'catatan'=>@$_POST['catatan'.$r['nis']],
                                        );

                                        if (isset($_POST['ubah'])) {
                                            $aksi->update("tbl_absensi_siswa",$field,"nis = '$r[nis]' AND tgl_absen = '$today'");
                                            unset($_SESSION['rombel_ubah']);
                                            unset($_SESSION['tanggal_ubah']);
                                            $aksi->alert("Data berhasil Diubah","?menu=absensi_form&tidak_masuk");
                                        }

                                        if (isset($_POST['batal'])) {
                                            unset($_SESSION['rombel_ubah']);
                                            unset($_SESSION['tanggal_ubah']);
                                            $aksi->redirect("hal_utama.php?menu=absensi_form&tidak_masuk");
                                        }
                                    ?>
                                </tbody>
                                 <tfoot>
                                    <tr>
                                        <td colspan="10">&nbsp;</td>
                                        <td>
                                            <input type="submit" name="ubah" class="btn btn-success btn-lg btn-block" value="UBAH">
                                            <input type="submit" name="batal" class="btn btn-danger btn-lg btn-block" value="BATAL">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
</div>