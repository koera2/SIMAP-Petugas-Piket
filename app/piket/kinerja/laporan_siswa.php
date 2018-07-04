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
			$total = $aksi->sumdata("SUM(skor_r) as sum_r, SUM(skor_p) as sum_p","tbl_kinerja_siswa WHERE nis = '$nis'");
			$cek = $aksi->cekdata("tbl_siswa WHERE nis = '$nis'");
			if ($cek == 0) {
				$aksi->alert("Nis Tersebut Tidak Terdaftar !!!","?menu=kinerja_laporan&siswa");
			}

			$link_print = "piket/kinerja/export/format_print_siswa.php?nis=".$nis;
			$link_pdf = "piket/kinerja/export/format_pdf.php?siswa&nis=".$nis;
			$link_excel = "piket/kinerja/export/format_excel.php?siswa&nis=".$nis;
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Laporan Kinerja <?php echo $siswa['nama']; ?> &nbsp;-&nbsp;Total Punishment = <?php echo $total['sum_p']." -  Total Reward = ".$total['sum_r']; ?></div>
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
					<table id="example1" class="table table-bordered table-hover table-striped">
		                <thead>
		                	<tr>
		                		<th>No.</th>
		                		<th>Nis</th>
		                		<th>Nama</th>
		                		<th>JK</th>
		                		<th>Rombel</th>
		                		<th>Rayon</th>
		                		<th><center>Skor <br>Reward</center></th>
		                		<th><center>Skor <br>Punishment</center></th>
		                		<th><center>Bulan</center></th>
		                		<th><center>Semester</center></th>
		                		<th><center>Cetak</center></th>
		                	</tr>
		                </thead>
		                 <tbody>
		                	<?php  
		                		$no =0;
		                		$table = "tbl_kinerja_siswa";
		                		$where = "WHERE nis = '$nis'";
		                		$sum = "nis,nama,rombel,kode_rayon,semester,MONTH(tgl_kejadian) as bulan,YEAR(tgl_kejadian) as tahun,SUM(skor_p) As skor_punishment,SUM(skor_r) As skor_reward";
		                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY bulan,semester ORDER BY tahun ASC, semester ASC, bulan ASC");
		                		if (empty($data)) {?>
		                			<tr><td></td><td></td><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td><td></td><td></td><td></td></tr>
		                		<?php }else{
			                		foreach ($data as $r) {
		                			$no++;
		                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$siswa[kode_rayon]'");
			                		$link_detail = "piket/kinerja/export/format_print_detail.php?siswaM&nis=".$r['nis']."&bulan=".$r['bulan']."&tahun=".$r['tahun'];

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
				             			<td align="center">
				             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['bulan'].$r['semester']; ?>REWARD">
								           		<?php echo $r['skor_reward']; ?>
				             				</a>
				             				<div class="modal fade" id="<?php echo $r['nis'].$r['bulan'].$r['semester'];?>REWARD">
				             					<div class="modal-dialog modal-lg modal-primary">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Daftar Riwayat Reward : <?php echo $r['nama']." Bulan ";$aksi->bulan($r['bulan']);echo " Semester ".$r['semester']; ?></h4>
														</div>

															<table class="table table-bordered table-striped table-hover">
																<thead>
																	<tr>
													                    <th><center>No.</center></th>
													                    <th>Tanggal</th>
													                    <th>Nama Kinerja</th>
													                    <th>Saksi</th>
													                    <th><center>Skor</center></th>
													                </tr>
																</thead>
																<tbody>
																	<?php  
																		$no_detail_r = 0;
																		$where_detail_r = "WHERE nis = '$r[nis]' AND kelompok_kinerja = 'REWARD' AND MONTH(tgl_kejadian)='$r[bulan]' AND semester = '$r[semester]'";
																		$details_r = $aksi->tampil($table,$where_detail_r,"ORDER BY tgl_kejadian ASC");
																		if (empty($details_r)) {
																			$aksi->no_record(5);
																		}else{
																			foreach ($details_r as $detail_r) {
																				$no_detail_r++;
																				$detail_kinerja_r = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$detail_r[kode_kinerja]'");
																			?>
																				<tr>
																					<td><center><?php echo $no_detail_r; ?>.</center></td>
																					<td><?php $aksi->format_tanggal($detail_r['tgl_kejadian']); ?></td>
																					<td><?php echo $detail_r['kode_kinerja']." | ".$detail_kinerja_r['nama_kinerja']; ?></td>
																					<td><?php echo $detail_r['saksi']; ?></td>
																					<td><center><?php echo $detail_r['skor_r']; ?></center></td>
																				</tr>

																	<?php } } ?>
																</tbody>
															</table>

														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
														</div>
													</div>
												</div>
				             				</div>
				             			</td>
				             			<td align="center">
				             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['bulan'].$r['semester']; ?>PUNISHMENT">
								           		<?php echo $r['skor_punishment']; ?>
				             				</a>
				             				<div class="modal fade" id="<?php echo $r['nis'].$r['bulan'].$r['semester'];?>PUNISHMENT">
				             					<div class="modal-dialog modal-lg modal-primary">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Daftar Riwayat Punishment : <?php echo $r['nama']." Bulan ";$aksi->bulan($r['bulan']);echo " Semester ".$r['semester']; ?></h4>
														</div>

															<table class="table table-bordered table-striped table-hover">
																<thead>
																	<tr>
													                    <th><center>No.</center></th>
													                    <th>Tanggal</th>
													                    <th>Nama Kinerja</th>
													                    <th>Saksi</th>
													                    <th><center>Skor</center></th>
													                </tr>
																</thead>
																<tbody>
																	<?php  
																		$no_detail_p = 0;
																		$where_detail_p = "WHERE nis = '$r[nis]' AND kelompok_kinerja = 'PUNISHMENT' AND MONTH(tgl_kejadian)='$r[bulan]' AND semester = '$r[semester]'";
																		$details_p = $aksi->tampil($table,$where_detail_p,"ORDER BY tgl_kejadian ASC");
																		if (empty($details_p)) {
																			$aksi->no_record(5);
																		}else{
																			foreach ($details_p as $detail_p) {
																				$no_detail_p++;
																				$detail_kinerja_p = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$detail_p[kode_kinerja]'");
																			?>
																				<tr>
																					<td><center><?php echo $no_detail_p; ?>.</center></td>
																					<td><?php $aksi->format_tanggal($detail_p['tgl_kejadian']); ?></td>
																					<td><?php echo $detail_p['kode_kinerja']." | ".$detail_kinerja_p['nama_kinerja']; ?></td>
																					<td><?php echo $detail_p['saksi']; ?></td>
																					<td><center><?php echo $detail_p['skor_p']; ?></center></td>
																				</tr>
																	<?php } } ?>
																</tbody>
															</table>

														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
														</div>
													</div>
												</div>
				             				</div>
				             			</td>
				             			<td align="center"><?php $aksi->bulan($r['bulan']);echo " ",$r['tahun']; ?></td>
				             			<td align="center"><?php echo $r['semester']; ?></td>
				             			<td align="center"><a href="<?php echo $link_detail; ?>" target="_blank">Detail</a></td>
				             		</tr>

	                		<?php  } }   ?>
		                </tbody>
		             </table>
				</div>
			</div>
		</div>
<?php } ?>	