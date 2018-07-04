<?php  
	@$semester = $_POST['smt'];
	@$tpel = $_POST['tp'];
	@$kd_rayon = $_POST['kode_rayon'];
?>
<form method="post">
	<div class="col-md-8">
		<div class="input-group">
			<div class="input-group-addon" id="pri">Semester</div>
			<select name="smt" class="form-control" required>
				<option value="<?php echo $semester; ?>"><?php echo $semester; ?></option>
				<option value="I">I</option>
				<option value="II">II</option>
				<option value="III">III</option>
				<option value="IV">IV</option>
				<option value="V">V</option>
				<option value="VI">VI</option>
			</select>

			<div class="input-group-addon" id="pri">Tahun Pelajaran</div>
			<select name="tp" class="form-control" required>
				<?php  
					for ($i=date("Y"); $i >=2013 ; $i--) {
						$b = $i+1;
						$cek_bulan = date("m");
						if ($cek_bulan <=7) {
							$tp = ($i-1)."-".$i;
						 }else{
						 	$tp = $i."-".$b;
						 } ?>
				<option value="<?php echo $tp ?>" <?php if($tp==@$tpel){echo "selected";} ?> ><?php echo $tp; ?></option>
				<?php } ?>
			</select>

			<div class="input-group-addon" id="pri">Rayon</div>
			<select name="kode_rayon" class="form-control" >
				<?php  
					$sql = mysql_query("SELECT * FROM tbl_rayon ORDER BY rayon ASC");
					while($rayon = mysql_fetch_array($sql)){?>
						<option value="<?php echo $rayon['kode_rayon']; ?>" <?php if($rayon['kode_rayon']==@$kd_rayon){echo "selected";} ?>><?php echo $rayon['rayon']; ?></option>
				<?php } ?>
			</select>
			<div class="input-group-btn">
				<input type="submit" name="tampil" class="btn btn-primary" value="Tampil">
			</div>
		</div>
	</div>
</form>
<br><br><br>
<?php  
	if (isset($_POST['tampil'])) { 
			$ryn = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$kd_rayon'");
			$link_print = "piket/absensi/export/format_print_rayon.php?rayonS&kd_rayon=".$kd_rayon."&semester=".$semester."&tp=".$tpel;
			$link_pdf = "piket/absensi/export/format_pdf.php?rayonS&kd_rayon=".$kd_rayon."&semester=".$semester."&tp=".$tpel;
			$link_excel = "piket/absensi/export/format_excel.php?rayonS&kd_rayon=".$kd_rayon."&semester=".$semester."&tp=".$tpel;
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Laporan Absensi Siswa Rayon <?php echo $ryn['rayon']; ?> Semester <?php echo $semester." Tahun Pelajaran ".$tpel; ?></div>
				<div class="panel-body">
					<div class="col-md-12" style="margin-bottom:15px;">
						<div class="col-md-4 pull-right" >
							<div class="input-group">
								<div class="input-group-btn">
									<a href="<?php echo $link_print; ?>" target="_blank" class="btn btn-success"><div class="glyphicon glyphicon-print"></div>&nbsp;Cetak</a>
									<a href="<?php echo $link_pdf; ?>" target="_blank" class="btn btn-success"><div class="glyphicon glyphicon-floppy-save"></div>&nbsp;Simpan PDF</a>
									<a href="<?php echo $link_excel; ?>" target="_blank" class="btn btn-success"><div class="glyphicon glyphicon-floppy-save"></div>&nbsp;Simpan Excel</a>
								</div>
							</div>
						</div>			
					</div>
					<table id="example1" class="table table-bordered table-hover">
		                <thead>
		                	<tr>
			                	<th width="10"><center>No.</center></th>
		                		<th><center>Nis</center></th>
		                		<th><center>Nama</center></th>
		                		<th><center>JK</center></th>
		                		<th><center>Rombel</center></th>
		                		<th class="active"><center>Hadir</center></th>
		                		<th class="warning"><center>Sakit</center></th>
		                		<th class="success"><center>Izin</center></th>
		                		<th class="danger"><center>Alpa</center></th>
		                		<th class="info"><center>Tugas</center></th>
		                		<th><center>Aksi</center></th>
		                	</tr>
		                </thead>
		                <tbody>
		                	<?php  
		                		$no =0;
		                		$table = "tbl_absensi_siswa";
		                		$where = "WHERE kode_rayon = '$kd_rayon' AND semester='$semester' AND tahun_pelajaran='$tpel'";
		                		$sum = "nis,nama,kode_rayon,rombel,SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
		                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY nis ASC");
		                		if (empty($data)) {?>
		                			<tr><td></td><td></td><td></td><td></td><td></td><td align="center">Data Tidak Ada<td></td><td></td><td></td><td></td><td></td></tr>
		                		<?php }else{	
			                		foreach ($data as $r) {
			                			$no++;
			                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
			                		 ?>
			                		 	<tr>
					             			<td align="center"><?php echo $no; ?>.</td>
					             			<td align="center"><?php echo $r['nis']; ?></td>
					             			<td><?php echo $r['nama']; ?></td>
					             			<td align="center">
					             				<?php 
					             					if ($siswa['jk']=="L") {
					             						echo "Laki-laki";
					             					}else{
					             						echo "Perempuan";
					             					}
					             				 ?>
					             			</td>
					             			<td align="center"><?php echo $r['rombel']; ?></td>
					             			<td align="center" class="active"><?php echo $r['jumlah_hadir']; ?></td>
					             			<td align="center" class="warning"><?php echo $r['jumlah_sakit']; ?></td>
					             			<td align="center" class="success"><?php echo $r['jumlah_izin']; ?></td>
					             			<td align="center" class="danger"><?php echo $r['jumlah_alpa']; ?></td>
					             			<td align="center" class="info"><?php echo $r['jumlah_tugas']; ?></td>
					             			<td align="center">
										<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis']; ?>">
											<span class="glyphicon glyphicon-eye-open"></span>&nbsp;DETAIL
										</a> 
										<div class="modal fade" id="<?php echo $r['nis']; ?>">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header" id="pri">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h4 class="modal-title">Daftar Riwayat Absensi : <?php echo $r['nama']." Semester ".$semester." Tahun Pelajaran ".$tpel; ?></h4>
													</div>

													
														<div class="table-responsive">
															<table class="table table-striped table-bordered table-hover">
																<thead>
																	<th><center>No.</center></th>
																	<th><center>Tanggal</center></th>
																	<th><center>Keterangan</center></th>
																	<th><center>Catatan</center></th>
																</thead>
																<tbody>
																	<?php  
																		$no_detail = 0;
																		$tbl = "tbl_absensi_siswa";
																		$whr = "WHERE nis = '$r[nis]' AND semester='$semester' AND tahun_pelajaran='$tpel'";
																		$data_detail = $aksi->tampil($tbl,$whr,"ORDER BY tgl_absen ASC");
																		foreach ($data_detail as $detail) {
																			$no_detail++;
											            				?>
											            				<tr>
													             			<td align="center"><?php echo $no_detail; ?>.</td>
													             			<td align="center"><?php $aksi->format_tanggal($detail['tgl_absen']); ?></td>
													             			<td align="center">
												             				<?php  
												             					if ($detail['izin']=="1") {
												             						echo "<span class='label label-success'><b>Izin</b></span>";
												             					}elseif ($detail['hadir']=="1") {
												             						echo "<span class='label label-primary'><b>Hadir</b></span>";
												             					}elseif ($detail['alpa']=="1") {
												             						echo "<span class='label label-danger'><b>Alpa</b></span>";
												             					}elseif ($detail['sakit']=="1") {
												             						echo "<span class='label label-warning'><b>Sakit</b></span>";
												             					}elseif ($detail['tugas']=="1") {
												             						echo "<span class='label label-info'><b>Tugas</b></span>";
												             					}
													             			?>
													             			</td>
													             			<td align="center"><?php if($detail['catatan']==""){ echo "-";}else{echo $detail['catatan'];;} ?></td>
													             		</tr>
													             		<?php } ?>
																</tbody>
															</table>
														</div>
														
													<div class="modal-footer" id="pri">
														<button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
													</div>
												</div>
											</div>
										</div>
									</td>
					             		</tr>

	                		<?php  } } ?>
		                </tbody>
		            </table>
				</div>
			</div>
		</div>
	<?php } ?>