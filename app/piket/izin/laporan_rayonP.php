<?php  
	@$dari = $_POST['dari'];
	@$sampai = $_POST['sampai'];
	@$kd_rayon = $_POST['kode_rayon'];
?>
<form method="post">
	<div class="col-md-10">
		<div class="input-group">
			<div class="input-group-addon" id="pri">Dari Tanggal</div>
			<input type="date" name="dari" class="form-control" required value="<?php if(isset($_POST['dari'])){echo $dari; }else{ echo date("Y-m-d"); }?>">

			<div class="input-group-addon" id="pri">Sampai Tanggal</div>
			<input type="date" name="sampai" class="form-control" required value="<?php if(isset($_POST['sampai'])){echo $sampai; }else{ echo date("Y-m-d"); }?>"> 

			<div class="input-group-addon" id="pri">Rayon</div>
			<select name="kode_rayon" class="form-control" >
				<?php  
					$sql = mysql_query("SELECT * FROM tbl_rayon");
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
			$link_print = "piket/izin/export/format_print_rayon.php?rayonP&kd_rayon=".$kd_rayon."&dari=".$dari."&sampai=".$sampai;
			$link_pdf = "piket/izin/export/format_pdf.php?rayonP&kd_rayon=".$kd_rayon."&dari=".$dari."&sampai=".$sampai;
			$link_excel = "piket/izin/export/format_excel.php?rayonP&kd_rayon=".$kd_rayon."&dari=".$dari."&sampai=".$sampai;
		?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Laporan Izin Siswa Rayon <?php echo $ryn['rayon']; ?> Periode <?php $aksi->format_tanggal($dari);echo " - ";$aksi->format_tanggal($sampai); ?></div>
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
		                		<th>Rombel</th>
		                		<th><center>Jumlah Izin</center></th>
		                	</tr>
		                </thead>
		                <tbody>
		                	<?php  
		                		$no =0;
		                		$table = "tbl_izin_siswa";
		                		$where = "WHERE kode_rayon = '$kd_rayon' AND tgl_izin BETWEEN '$dari' AND '$sampai'";
		                		$sum = "nis,nama,rombel,kode_rayon,COUNT(jenis_izin) as jumlah_izin";
		                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY nis ASC");
		                		if (empty($data)) {?>
		                			<tr><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td></tr>
		                		<?php }else{	
			                		foreach ($data as $r) {
			                			$no++;
			                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
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
					             			<td align="center">
					             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'] ?>">
									           		<?php echo $r['jumlah_izin']; ?>
					             				</a>
					             				<div class="modal fade" id="<?php echo $r['nis'];?>">
					             					<div class="modal-dialog modal-lg modal-primary">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																<h4 class="modal-title">Daftar Riwayat Izin : <?php echo $r['nama']." Periode ";$aksi->format_tanggal($dari);echo " - ";$aksi->format_tanggal($sampai); ?></h4>
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
																			$where_detail = "WHERE nis = '$r[nis]' AND tgl_izin BETWEEN '$dari' AND '$sampai'";
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
		</div>
<?php } ?>