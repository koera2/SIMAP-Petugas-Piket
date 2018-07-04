<?php  
	@$tanggal = $_POST['tanggal'];
	@$today = date("Y-m-d");
?>
<form method="post">
	<div class="col-md-5">
		<div class="input-group">
			<div class="input-group-addon" id="pri">Tanggal</div>
			<input type="date" name="tanggal" class="form-control" value="<?php if(isset($_POST['tanggal'])){echo $tanggal;}else{echo $today;} ?>">

			<div class="input-group-btn">
				<input type="submit" name="tampil" class="btn btn-primary" value="Tampil">
				<a href="?menu=absensi_form&riwayat" class="btn btn-primary">Hari Ini</a>
			</div>
		</div>
	</div>
</form>
<br><br><br>
<div class="col-md-12">
	<div class="panel panel-default">
		<?php 
			if (isset($_POST['tampil'])) { 
					$where = "WHERE tgl_absen ='$tanggal'";
				?>
				<div class="panel-heading">Daftar Rombel Yang Sudah Absen Tanggal <?php $aksi->format_tanggal($tanggal); ?></div>
		<?php }else{ 
					$where = "WHERE tgl_absen = '$today'";
			?>
				<div class="panel-heading">Daftar Rombel Yang Sudah Absen Hari Ini - <?php $aksi->format_tanggal($today); ?></div>
		<?php } ?>
		<div class="panel-body">
			<table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                	<tr>
	                	<th><center>No.</center></th>
                		<th><center>Rombel</center></th>
                		<th><center>Jumlah Siswa</center></th>
                		<th><center>Tanggal</center></th>
                		<th><center>Aksi</center></th>
                	</tr>
                </thead>
                <tbody>
                	<?php  
                		$no = 0;
                		$data =$aksi->tampil("tbl_rombel","WHERE tahun_pelajaran = '$_SESSION[tp]'","ORDER BY rombel ASC"); 
                		if (empty($data)) {?>
                			<tr><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td></tr>
                		<?php }else{	
	                		foreach ($data as $r) {
	                			$absensi = $aksi->caridata("tbl_absensi_siswa ".$where." AND rombel = '$r[rombel]' GROUP BY tgl_absen");
	                			$cek = $aksi->cekdata("tbl_absensi_siswa ".$where." AND rombel = '$r[rombel]' GROUP BY tgl_absen");
	                			if ($cek > 0 ) {
		                			$no++;
                			?>
                				<tr>
                					<td align="center"><?php echo $no; ?>.</td>
                					<td align="center"><?php echo $r['rombel']; ?></td>
                					<td align="center"><?php echo $r['jumlah_siswa']; ?>&nbsp;Orang</td>
                					<td align="center">
                					<?php  
                						if (!isset($_POST['tampil'])) {
                							$aksi->format_tanggal($today);
                						}else{
                							$aksi->format_tanggal($tanggal);
                						}
                					?>
	                				</td>
	                				<td align="center">
										<a href="#" data-toggle="modal" data-target="#<?php echo $r['kode_rombel']; ?>">
											<span class="glyphicon glyphicon-eye-open"></span>&nbsp;DETAIL
										</a> 
										<div class="modal fade" id="<?php echo $r['kode_rombel']; ?>">
											<div class="modal-dialog modal-lg">
												<div class="modal-content">
													<div class="modal-header" id="pri">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														<h4 class="modal-title">Daftar Riwayat Absensi : <?php echo $absensi['rombel']." Tanggal ";$aksi->format_tanggal($absensi['tgl_absen']); ?></h4>
													</div>

													
														<div class="table-responsive">
															<table class="table table-striped table-bordered table-hover">
																<thead>
																	<th><center>No.</center></th>
																	<th><center>Nis</center></th>
																	<th><center>Nama</center></th>
																	<th><center>Rayon</center></th>
																	<th><center>Keterangan</center></th>
																	<th><center>Catatan</center></th>
																</thead>
																<tbody>
																	<?php  
																		$no_detail = 0;
																		$tbl = "tbl_absensi_siswa";
																		$whr = "WHERE tgl_absen = '$absensi[tgl_absen]' AND rombel = '$absensi[rombel]'";
																		$data_detail = $aksi->tampil($tbl,$whr,"ORDER BY nis ASC");
																		foreach ($data_detail as $detail) {
																			$no_detail++;
											                				$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$detail[kode_rayon]'");
											            				?>
											            				<tr>
													             			<td align="center"><?php echo $no_detail; ?>.</td>
													             			<td align="center"><?php echo $detail['nis']; ?></td>
													             			<td><?php echo $detail['nama']; ?></td>
													             			<td align="center"><?php echo $rayon['rayon']; ?></td>
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
            		<?php } } } ?>
                </tbody>
            </table>
		</div>
	</div>
</div>
