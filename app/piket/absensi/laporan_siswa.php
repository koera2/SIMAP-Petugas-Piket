<?php  
	@$nis = $_POST['nis'];
?>
<form method="post">
	<div class="col-md-4">
		<div class="input-group">
			<div class="input-group-addon" id="pri">Masukan NIS</div>
			<input type="text" name="nis" class="form-control" required value="<?php echo $nis; ?>" list="siswa" maxlength="8" minlength="8" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
			<datalist id="siswa">
				<?php  
					$sql = mysql_query("SELECT * FROM tbl_siswa");
					while($siswa = mysql_fetch_array($sql)){?>
						<option value="<?php echo $siswa['nis'] ?>"><?php echo $siswa['nama']; ?></option>
				<?php } ?>
			</datalist>
			<div class="input-group-btn">
				<input type="submit" name="tampil" class="btn btn-primary" value="Tampil">
			</div>
		</div>
	</div>
</form>
<br><br><br>
<?php  
	if (isset($_POST['tampil'])) { 
			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$nis'");
			$total = $aksi->sumdata("SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas","tbl_absensi_siswa WHERE nis = '$nis'");
			$cek = $aksi->cekdata("tbl_siswa WHERE nis = '$nis'");
			if ($cek == 0) {
				$aksi->alert("Nis Tersebut Tidak Terdaftar !!!","?menu=absensi_laporan&siswa");
			}

			$link_print = "piket/absensi/export/format_print_siswa.php?nis=".$nis;
			$link_pdf = "piket/absensi/export/format_pdf.php?siswa&nis=".$nis;
			$link_excel = "piket/absensi/export/format_excel.php?siswa&nis=".$nis;
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Laporan Absensi <?php echo $siswa['nama']; ?> &nbsp;-&nbsp;Total Hadir =  <?php echo $total['jumlah_hadir']; ?>&nbsp;-&nbsp;Total Sakit =  <?php echo $total['jumlah_sakit']; ?>&nbsp;-&nbsp;Total Izin =  <?php echo $total['jumlah_izin']; ?>&nbsp;-&nbsp;Total Alpa =  <?php echo $total['jumlah_alpa']; ?>&nbsp;-&nbsp;Total Tugas =  <?php echo $total['jumlah_tugas']; ?></div>
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
		                		<th>No.</th>
		                		<th>Nis</th>
		                		<th>Nama</th>
		                		<th>JK</th>
		                		<th>Rombel</th>
		                		<th>Rayon</th>
		                		<th class="active"><center>Hadir</center></th>
		                		<th class="warning"><center>Sakit</center></th>
		                		<th class="success"><center>Izin</center></th>
		                		<th class="danger"><center>Alpa</center></th>
		                		<th class="info"><center>Tugas</center></th>
		                		<th><center>Bulan</center></th>
		                		<th><center>Semester</center></th>
		                		<th><center>Aksi</center></th>
		                	</tr>
		                </thead>
		                 <tbody>
		                	<?php  
		                		$no =0;
		                		$table = "tbl_absensi_siswa";
		                		$where = "WHERE nis = '$nis'";
		                		$sum = "nis,nama,rombel,kode_rayon,semester,MONTH(tgl_absen) as bulan,YEAR(tgl_absen) as tahun,SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
		                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY bulan,semester ORDER BY tahun ASC, semester ASC, bulan ASC");
		                		if (empty($data)) {?>
		                			<tr><td></td><td></td><td></td><td></td><td></td><td></td><td align="center">Data Tidak Ada<td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		                		<?php }else{
			                		foreach ($data as $r) {
		                			$no++;
		                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$siswa[kode_rayon]'");
		                		 ?>
		                		 	<tr>
				             			<td><?php echo $no; ?>.</td>
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
				             			<td><?php echo $r['rombel']; ?></td>
				             			<td><?php echo $rayon['rayon']; ?></td>
				             			<td align="center" class="active"><?php echo $r['jumlah_hadir']; ?></td>
				             			<td align="center" class="warning"><?php echo $r['jumlah_sakit']; ?></td>
				             			<td align="center" class="success"><?php echo $r['jumlah_izin']; ?></td>
				             			<td align="center" class="danger"><?php echo $r['jumlah_alpa']; ?></td>
				             			<td align="center" class="info"><?php echo $r['jumlah_tugas']; ?></td>
				             			<td align="center"><?php $aksi->bulan($r['bulan']);echo " ".$r['tahun']; ?></td>
				             			<td align="center"><?php echo $r['semester']; ?></td>
				             			<td align="center">
				             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['bulan'].$r['semester']; ?>">
												<span class="glyphicon glyphicon-eye-open"></span>&nbsp;DETAIL
				             				</a>
				             				<div class="modal fade" id="<?php echo $r['nis'].$r['bulan'].$r['semester']; ?>">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header" id="pri">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h4 class="modal-title">Daftar Riwayat Absensi : <?php echo $r['nama']." Bulan ";$aksi->bulan($r['bulan']);echo " ".$r['tahun'];echo " Semester ".$r['semester']; ?></h4>
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
																		$whr = "WHERE nis = '$r[nis]' AND MONTH(tgl_absen)='$r[bulan]' AND YEAR(tgl_absen)='$r[tahun]' AND semester = '$r[semester]'";
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

	                		<?php  } }   ?>
		                </tbody>
		             </table>
				</div>
			</div>
		</div>
<?php } ?>	