<?php  
	if (isset($_POST['tampil'])) {
		$_SESSION['rombel'] = $_POST['kode_rombel'];
		$_SESSION['tanggal'] = $_POST['tanggal'];
	}

?>
<form method="post">
	<div class="col-md-8">
		<div class="input-group">
			<div class="input-group-addon" id="pri">Tanggal</div>
			<input type="date" name="tanggal" class="form-control" required value="<?php if(isset($_POST['tampil']) || !empty($_SESSION['tanggal'])){echo $_SESSION['tanggal'];}else{echo date("Y-m-d");} ?>">

			<div class="input-group-addon" id="pri">Rombel</div>
			<select name="kode_rombel" class="form-control" >
				<?php  
					$sql = mysql_query("SELECT * FROM tbl_rombel WHERE tahun_pelajaran = '$_SESSION[tp]' ORDER BY rombel ASC");
					while($c = mysql_fetch_array($sql)){?>
						<option value="<?php echo $c['kode_rombel'] ?>" <?php if($c['kode_rombel']==@$_SESSION['rombel']){echo "selected";} ?>><?php echo $c['rombel']; ?></option>
				<?php } ?>
			</select>
			<div class="input-group-btn">
				<input type="submit" name="tampil" class="btn btn-primary" value="Absen">
			</div>
		</div>
	</div>
<br><br><br>

<?php 
	@$tanggal = $_SESSION['tanggal'];
	@$kd_rombel = $_SESSION['rombel']; 
	$rmbl = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$kd_rombel'");
	$cek_rombel = $aksi->cekdata("tbl_absensi_siswa WHERE rombel = '$rmbl[rombel]' AND tgl_absen = '$tanggal'");

	if (!empty($_SESSION['rombel'])) { 
		if ($cek_rombel > 0 ) {
			unset($_SESSION['rombel']);
			unset($_SESSION['tanggal']);
			$aksi->pesan("Rombel ".$rmbl['rombel']." sudah absen !!!");
		}else{ 
		?>
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Absensi Rombel <?php echo @$rmbl['rombel']; ?> Tanggal <?php $aksi->format_tanggal($tanggal); ?></div>
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
				                		$table = "tbl_siswa";
				                		$where = "WHERE kode_rombel = '$kd_rombel'";
				                		$data = $aksi->tampil($table,$where,"ORDER BY nis ASC");
				                		if (empty($data)) {
				                			$aksi->no_record(11);
				                		}else{
					                		foreach ($data as $r) { 
					                			$no++;
					                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
					                			?>
					                			<tr>
							            			<td><center><?php echo $no; ?>.</center></td>
							            			<td><?php echo $r['nis']; ?></td>
							            			<td><?php echo $r['nama']; ?></td>
							            			<td>
							            				<?php  
							            					if ($r['jk']=="L") {
							            						echo "Laki-laki";
							            					}else{
							            						echo "Perempuan";
							            					}
							            				?>
								             		</td>
							            			<td><?php echo $rayon['rayon']; ?></td>
							            			<td align="center"><input type="radio" checked="checked" name="ket<?php echo $r['nis'] ?>" value="hadir"/><br>Hadir</td>
													<td align="center"><input type="radio" onchange="" name="ket<?php echo $r['nis'] ?>" value="sakit"/><br>Sakit</td>
													<td align="center"><input type="radio" name="ket<?php echo $r['nis'] ?>" value="izin"/><br>Izin</td>
													<td align="center"><input type="radio" name="ket<?php echo $r['nis'] ?>" value="alpa"/><br>Alpa</td>
													<td align="center"><input type="radio" name="ket<?php echo $r['nis'] ?>" value="tugas"/><br>Tugas</td>
													<td align="center"><input type="text" class="form-control" name="catatan<?php echo $r['nis']; ?>"></td>
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

							            			$tahun = substr(@$_POST['tanggal'], 0,4);
													$bulan = substr(@$_POST['tanggal'], 5,2);
													$masuk = $r['tahun_masuk'];
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
														'nis'=>$r['nis'],    
														'nama'=>$r['nama'], 
														'rombel'=>$rmbl['rombel'],    
														'kode_rayon'=>$r['kode_rayon'],    
														'tgl_absen'=>@$_POST['tanggal'],
														'hadir'=>@$hadir,
														'alpa'=>@$alpa,
														'izin'=>@$izin,
														'sakit'=>@$sakit,
														'tugas'=>@$tugas,
														'catatan'=>@$_POST['catatan'.$r['nis']],
													);

													if (isset($_POST['simpan'])) {
														$aksi->simpan("tbl_absensi_siswa",$field);
														unset($_SESSION['rombel']);
														unset($_SESSION['tanggal']);
														$aksi->alert("Data berhasil Disimpan","?menu=absensi_form&input");
													}
						            		}  
						            	}
						            ?>
				                </tbody>
				                <tfoot>
				                	<tr>
				                		<td colspan="10">&nbsp;</td>
				                		<td><input type="submit" name="simpan" class="btn btn-primary btn-lg btn-block" value="SIMPAN" <?php if (empty($data)){echo "disabled"; } ?>></td>
				                	</tr>
				                </tfoot>
				            </table>
						</div>
					</div>
				</div>
			</div>
<?php } }else{
	unset($_SESSION['rombel']);
	unset($_SESSION['tanggal']);
} ?>
</form>

