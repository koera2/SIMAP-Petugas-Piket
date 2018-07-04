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
			$total = $aksi->sumdata("COUNT(jenis_izin) as izin","tbl_izin_siswa WHERE nis = '$nis'");
			$cek = $aksi->cekdata("tbl_siswa WHERE nis = '$nis'");
			if ($cek == 0) {
				$aksi->alert("Nis Tersebut Tidak Terdaftar !!!","?menu=izin_laporan&siswa");
			}

			$link_print = "piket/izin/export/format_print_siswa.php?nis=".$nis;
			$link_pdf = "piket/izin/export/format_pdf.php?siswa&nis=".$nis;
			$link_excel = "piket/izin/export/format_excel.php?siswa&nis=".$nis;
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Laporan Izin <?php echo $siswa['nama']; ?> &nbsp;-&nbsp;Total Izin =  <?php echo $total['izin']; ?></div>
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
		                		<th><center>Jumlah Izin</center></th>
		                		<th><center>Bulan</center></th>
		                		<th><center>Semester</center></th>
		                	</tr>
		                </thead>
		                 <tbody>
		                	<?php  
		                		$no =0;
		                		$table = "tbl_izin_siswa";
		                		$where = "WHERE nis = '$nis'";
		                		$sum = "nis,nama,rombel,kode_rayon,semester,MONTH(tgl_izin) as bulan,YEAR(tgl_izin) as tahun,COUNT(jenis_izin) as count_izin";
		                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY bulan,semester ORDER BY tahun ASC, semester ASC, bulan ASC");
		                		if (empty($data)) {?>
		                			<tr><td></td><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td><td></td><td></td></tr>
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
				             			<td align="center">
				             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['bulan'].$r['semester']; ?>">
								           		<?php echo $r['count_izin']; ?>
				             				</a>
				             				<div class="modal fade" id="<?php echo $r['nis'].$r['bulan'].$r['semester'];?>">
				             					<div class="modal-dialog modal-lg modal-primary">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Daftar Riwayat Izin : <?php echo $r['nama']." Bulan ";$aksi->bulan($r['bulan']);echo " Semester ".$r['semester']; ?></h4>
														</div>

															<table class="table table-bordered table-striped table-hover">
																<thead>
																	<tr>
													                    <th width="5%" align="center">No.</th>
													                    <th width="15%">Tanggal</th>
													                    <th width="15%">Waktu</th>
													                    <th>Keperluan</th>
													                    <th width="20%"><center>Petugas</center></th>
													                </tr>
																</thead>
																<tbody>
																	<?php  
																		$no_detail = 0;
																		$where_detail = "WHERE nis = '$r[nis]' AND  MONTH(tgl_izin)='$r[bulan]' AND YEAR(tgl_izin)='$r[tahun]' AND semester = '$r[semester]'";
																		$details = $aksi->tampil($table,$where_detail,"ORDER BY tgl_izin ASC");
																		if (empty($details)) {
																			$aksi->no_record(5);
																		}else{
																			foreach ($details as $detail) {
																					$no_detail++;
																					$petugas = $aksi->caridata("tbl_pegawai WHERE nip = '$detail[id_pegawai]'");
																				?>
																					<tr>
																						<td align="center"><?php echo $no_detail; ?>.</td>
																						<td><?php $aksi->format_tanggal($detail['tgl_izin']); ?></td>
																						<td align="center"><?php echo substr($detail['waktu'],11,9); ?></td>
																						<td><?php echo $detail['jenis_izin']." | ".$detail['keperluan']; ?></td>
																						<td><center><?php echo $petugas['nama']; ?></center></td>
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
				             		</tr>

	                		<?php  } }   ?>
		                </tbody>
		             </table>
				</div>
			</div>
		</div>
<?php } ?>	