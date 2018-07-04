<?php  
	if (isset($_POST['tampil'])) {
		$_SESSION['rombel_ubah'] = $_POST['kode_rombel'];
		$_SESSION['tanggal_ubah'] = $_POST['tanggal'];
	}


	// echo @$_SESSION['rombel_ubah']."<br>";
	// echo @$_SESSION['tanggal_ubah'];

?>
<form method="post">
	<div class="col-md-8">
		<div class="input-group">
			<div class="input-group-addon" id="pri">Tanggal</div>
			<input type="date" name="tanggal" class="form-control" required value="<?php if(isset($_POST['tampil']) || !empty($_SESSION['tanggal_ubah'])){echo $_SESSION['tanggal_ubah'];}else{echo date("Y-m-d");} ?>">

			<div class="input-group-addon" id="pri">Rombel</div>
			<select name="kode_rombel" class="form-control" >
				<?php  
					$sql = mysql_query("SELECT * FROM tbl_rombel WHERE tahun_pelajaran = '$_SESSION[tp]' ORDER BY rombel ASC");
					while($c = mysql_fetch_array($sql)){?>
						<option value="<?php echo $c['rombel'] ?>" <?php if($c['rombel']==@$_SESSION['rombel_ubah']){echo "selected";} ?>><?php echo $c['rombel']; ?></option>
				<?php } ?>
			</select>
			<div class="input-group-btn">
				<input type="submit" name="tampil" class="btn btn-primary" value="Tampil">
			</div>
		</div>
	</div>
<br><br><br>

<?php 
	@$tanggal = $_SESSION['tanggal_ubah'];
	@$kd_rombel = $_SESSION['rombel_ubah']; 
	$cek_rombel = $aksi->cekdata("tbl_absensi_siswa WHERE rombel = '$kd_rombel' AND tgl_absen = '$tanggal'");

	if (!empty($_SESSION['rombel_ubah'])) { 
		if ($cek_rombel == 0 ) {
			unset($_SESSION['rombel_ubah']);
			unset($_SESSION['tanggal_ubah']);
			$aksi->pesan("Rombel ".$kd_rombel." Belum absen !!!");
		}else{ 
		?>
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Ubah Absensi Rombel <?php echo @$_SESSION['rombel_ubah'] ?> Tanggal <?php $aksi->format_tanggal(@$_SESSION['tanggal_ubah']); ?></div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
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
				                		$no = 0;
				                		$table = "tbl_absensi_siswa";
				                		$where = "WHERE rombel = '$kd_rombel' AND tgl_absen = '$_SESSION[tanggal_ubah]'";
				                		$data = $aksi->tampil($table,$where,"ORDER BY nis ASC");
				                		if (empty($data)) {
				                			$aksi->no_record(11);
				                		}else{
					                		foreach ($data as $r) {
					                			$no++;
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
					                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
					                			?>
					                			<tr>
							            			<td><center><?php echo $no; ?>.</center></td>
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
														$aksi->update("tbl_absensi_siswa",$field,"nis = '$r[nis]' AND tgl_absen = '$_POST[tanggal]'");
														unset($_SESSION['rombel_ubah']);
														unset($_SESSION['tanggal_ubah']);
														$aksi->alert("Data berhasil Diubah","?menu=absensi_form&ubah");
													}

													if (isset($_POST['batal'])) {
														unset($_SESSION['rombel_ubah']);
														unset($_SESSION['tanggal_ubah']);
														$aksi->redirect("hal_utama.php?menu=absensi_form&ubah");
													}
						            		}  
						            	}
						            ?>
				                </tbody>
				                <tfoot>
				                	<tr>
				                		<td colspan="10">&nbsp;</td>
				                		<td>
				                			<input type="submit" name="ubah" class="btn btn-success btn-lg btn-block" value="UBAH" <?php if (empty($data)){echo "disabled"; } ?>>
				                			<input type="submit" name="batal" class="btn btn-danger btn-lg btn-block" value="BATAL" onclick="return confirm('Yakin akan membatalkan perubahan yang ada ?')" <?php if (empty($data)){echo "disabled"; } ?>>
				                		</td>
				                	</tr>
				                </tfoot>
				            </table>
						</div>
					</div>
				</div>
			</div>
<?php } }else{
	unset($_SESSION['rombel_ubah']);
	unset($_SESSION['tanggal_ubah']);
} ?>
</form>

