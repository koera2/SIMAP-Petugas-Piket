<?php  
	@$semester = $_POST['smt'];
	@$tpel = $_POST['tp'];
	@$kd_rombel = $_POST['rombel'];
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

			<div class="input-group-addon" id="pri">Rombel</div>
			<select name="rombel" class="form-control" required >
				<?php  
					$sql = mysql_query("SELECT * FROM tbl_rombel WHERE tahun_pelajaran = '$_SESSION[tp]' ORDER BY rombel ASC");
					while($rombel = mysql_fetch_array($sql)){?>
						<option value="<?php echo $rombel['rombel'] ?>" <?php if($rombel['rombel']==@$kd_rombel){echo "selected";} ?>><?php echo $rombel['rombel']; ?></option>
				<?php } ?>
			</select>
			<div class="input-group-btn">
				<input type="submit" name="tampil" class="btn btn-primary" value="Tampil">
			</div>
		</div>
	</div>
</form>
<br> <br> <br>
<?php  
	if (isset($_POST['tampil'])) { 
			$link_print = "piket/izin/export/format_print_rombel.php?rombelS&rombel=".$kd_rombel."&semester=".$semester."&tp=".$tpel;
			$link_pdf = "piket/izin/export/format_pdf.php?rombelS&rombel=".$kd_rombel."&semester=".$semester."&tp=".$tpel;
			$link_excel = "piket/izin/export/format_excel.php?rombelS&rombel=".$kd_rombel."&semester=".$semester."&tp=".$tpel;
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Laporan Izin Siswa Rombel <?php echo $kd_rombel; ?> Semester <?php echo $semester." Tahun Pelajaran ".$tpel; ?></div>
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
			                	<th width="10">No.</th>
		                		<th>Nis</th>
		                		<th>Nama</th>
		                		<th>JK</th>
		                		<th>Rayon</th>
		                		<th><center>Jumlah Izin</center></th>
		                	</tr>
		                </thead>
		                <tbody>
		                	<?php  
		                		$no =0;
		                		$table = "tbl_izin_siswa";
		                		$where = "WHERE rombel = '$kd_rombel' AND semester='$semester' AND tahun_pelajaran = '$tpel'";
		                		$sum = "nis,nama,rombel,kode_rayon,COUNT(jenis_izin) as jumlah_izin";
		                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY nis ASC");
		                		if (empty($data)) {?>
		                			<tr><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td></tr>
		                		<?php }else{	
			                		foreach ($data as $r) {
			                			$no++;
			                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
			                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
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
					             			<td><?php echo $rayon['rayon']; ?></td>
					             			<td align="center">
					             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'] ?>">
									           		<?php echo $r['jumlah_izin']; ?>
					             				</a>
					             				<div class="modal fade" id="<?php echo $r['nis'];?>">
					             					<div class="modal-dialog modal-lg modal-primary">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																<h4 class="modal-title">Daftar Riwayat Izin : <?php echo $r['nama']." Semester ".$semester." Tahun Pelajaran ".$tpel; ?></h4>
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
																			$where_detail = "WHERE nis = '$r[nis]' AND semester='$semester' AND tahun_pelajaran = '$tpel'";
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
					             		</tr>

	                		<?php  } } ?>
		                </tbody>
		            </table>
			</div>
		</div>
<?php } ?>