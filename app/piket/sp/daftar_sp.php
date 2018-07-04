<?php 
	$table = "tbl_sp";
	$alamat = "?menu=surat_peringatan&daftar";
	@$where = "nis = '$_GET[nis]' AND ";

	@$kinerja = $aksi->sumdata("nis,kelompok_kinerja,SUM(skor_p) as besar_skor","tbl_kinerja_siswa WHERE nis = '$_GET[nis]' AND kelompok_kinerja = 'PUNISHMENT'");
	@$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$_GET[nis]'");
	@$rombel = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$siswa[kode_rombel]'");
	@$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$siswa[kode_rayon]'");

	$jumlah_skor = $kinerja['besar_skor'];

	if (isset($_GET['simpan'])) {
		if ($_GET['sp']==1) {
			$field = array(
				'nis'=>$siswa['nis'],
				'nama'=>$siswa['nama'],
				'rombel'=>$rombel['rombel'],
				'rayon'=>$rayon['rayon'],
				'jumlah_skor'=>$kinerja['besar_skor'],
				'sp_ke'=>1,
				'proses_kesiswaan'=>1,
				'proses_pembimbing'=>0,
				'status'=>0,
			);
			$aksi->simpan($table,$field);
			$aksi->alert("Berhasil diproses!!!",$alamat);
		}

		if ($_GET['sp']==2) {
			$field = array(
				'nis'=>$siswa['nis'],
				'nama'=>$siswa['nama'],
				'rombel'=>$rombel['rombel'],
				'rayon'=>$rayon['rayon'],
				'jumlah_skor'=>$kinerja['besar_skor'],
				'sp_ke'=>2,
				'proses_kesiswaan'=>1,
				'proses_pembimbing'=>0,
				'status'=>0,
			);
			$aksi->simpan($table,$field);
			$aksi->alert("Berhasil diproses!!!",$alamat);
		}

		if ($_GET['sp']==3) {
			$field = array(
				'nis'=>$siswa['nis'],
				'nama'=>$siswa['nama'],
				'rombel'=>$rombel['rombel'],
				'rayon'=>$rayon['rayon'],
				'jumlah_skor'=>$kinerja['besar_skor'],
				'sp_ke'=>3,
				'proses_kesiswaan'=>1,
				'proses_pembimbing'=>0,
				'status'=>0,
			);
			$aksi->simpan($table,$field);
			$aksi->alert("Berhasil diproses!!!",$alamat);
		}
	}

	if (isset($_GET['proses'])) {
		$field_proses = array('proses_kesiswaan'=>1,'jumlah_skor'=>$jumlah_skor,);
		if ($_GET['sp']==1) {
			$aksi->update($table,$field_proses,$where."sp_ke = '1'");
			$aksi->alert("Berhasil diproses!!!",$alamat);
		}

		if ($_GET['sp']==2) {
			$aksi->update($table,$field_proses,$where."sp_ke = '2'");
			$aksi->alert("Berhasil diproses!!!",$alamat);
		}

		if ($_GET['sp']==3) {
			$aksi->update($table,$field_proses,$where."sp_ke = '3'");
			$aksi->alert("Berhasil diproses!!!",$alamat);
		}
	}
?>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="glyphicon glyphicon-th-list"></div>
			&nbsp;DAFTAR SURAT PERINGATAN 1
		</div>
		<div class="panel-body">
			<div class="table-responsive" style="max-height: 300px;" >
				<table id="example1" class="table table-bordered table-hover table-striped">
	                <thead>
	                	<tr>
	                		<th width="4%">No.</th>
	                		<th>Nis</th>
	                		<th>Nama</th>
	                		<th>Rombel</th>
	                		<th>Rayon</th>
	                		<th>Skor</th>
	                		<th>Status</th>
	                		<th>Rincian</th>
	                		<th>Aksi</th>
	                	</tr>
	                </thead>
	                <tbody>
	                	<?php  
	                		$no =0;
	                		$table = "tbl_kinerja_siswa";
	                		$where = "WHERE kelompok_kinerja = 'PUNISHMENT'";
	                		$sum = "nis,nama,rombel,kode_rayon,kelompok_kinerja,SUM(skor_p) as besar_skor";
	                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY besar_skor");
	                		foreach ($data as $r) {
	                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
	                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
								$rombel = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$siswa[kode_rombel]'");
	                			
	                			// if($r['besar_skor'] >= 500 && $r['besar_skor'] < 750){
	                			// if($r['besar_skor'] >= 750){
	                			if($r['besar_skor'] >= 250 && $r['besar_skor'] < 500){
		                			$no++;

		                			$data_sp = $aksi->caridata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '1'");
		                			if (empty($data_sp)) {
			                			$status = "Mohon Untuk diproses";
			                			$link = "<a href='?menu=surat_peringatan&daftar&simpan&sp=1&nis=$r[nis]'>PROSES</a>";
		                			}else{
			                			$cek1 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '1'");
			                			$cek2 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '1' AND proses_kesiswaan = '1'");
			                			$cek3 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '1' AND proses_pembimbing = '1'");
			                			$cek4 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '1' AND proses_kesiswaan = '1' AND proses_pembimbing = '1'");
			                			$cek5 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '1' AND proses_kesiswaan = '1' AND proses_pembimbing = '1' AND status = '1'");

			                			if ($cek5 > 0) {
			                				$status = "Sudah diproses dengan no ".$data_sp['no_surat'];
			                				$link = "<a href='piket/sp/cetak.php?sp=1&nis=$r[nis]' target='_blank'>Cetak Ulang</a>";
			                			}elseif ($cek4 > 0) {
			                				$status = "Segera dicetak";
			                				$link = "<a href='?menu=surat_peringatan&proses&sp=1&nis=$r[nis]'>Tindak Lanjut</a>";
			                			}elseif ($cek3 == 0 AND  $cek2 > 0) {
			                				$status = "Menunggu Persetujuan Pembimbing Siswa";
			                				$link = "<a href='?menu=surat_peringatan&proses&sp=1&nis=$r[nis]'>Tindak Lanjut</a>";
			                			}elseif ($cek3 > 0) {
			                				$status = "Mohon Untuk diproses";
			                				$link = "<a href='?menu=surat_peringatan&daftar&proses&sp=1&nis=$r[nis]'>PROSES</a>";
			                			}elseif ($cek1 == 0 || $cek2 == 0) {
			                				$status = "Mohon Untuk diproses";
			                				$link = "<a href='?menu=surat_peringatan&daftar&proses&sp=1&nis=$r[nis]'>PROSES</a>";
			                			}
			                			
		                			}
	            				?>
	                		 	<tr>
			             			<td align="center"><?php echo $no; ?>.</td>
			             			<td><?php echo $r['nis']; ?></td>
			             			<td><?php echo $r['nama']; ?></td>
			             			<td><?php echo $rombel['rombel']; ?></td>
			             			<td><?php echo $rayon['rayon']; ?></td>
			             			<td align="center"><?php echo $r['besar_skor']; ?></td>
			             			<td><b><?php echo $status; ?></b></td>
			             			<td align="center">
				             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['kelompok_kinerja']; ?>" >
								           		RINCIAN
				             				</a>
				             				<div class="modal fade" id="<?php echo $r['nis'].$r['kelompok_kinerja']; ?>">
				             					<div class="modal-dialog modal-lg modal-primary">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Daftar Riwayat Punishment : <?php echo $r['nama']; ?></h4>
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
																		$no_detail = 0;
																		$where_detail = "WHERE nis = '$r[nis]' AND kelompok_kinerja = 'PUNISHMENT'";
																		$details = $aksi->tampil($table,$where_detail,"ORDER BY tgl_kejadian ASC");
																		foreach ($details as $detail) {
																			$no_detail++;
																			$detail_kinerja = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$detail[kode_kinerja]'");
																		?>
																			<tr>
																				<td><center><?php echo $no_detail; ?>.</center></td>
																				<td><?php $aksi->format_tanggal($detail['tgl_kejadian']); ?></td>
																				<td><?php echo $detail['kode_kinerja']." | ".$detail_kinerja['nama_kinerja']; ?></td>
																				<td><?php echo $detail['saksi']; ?></td>
																				<td><center><?php echo $detail['skor_p']; ?></center></td>
																			</tr>

																	<?php } ?>
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
			             				<?php echo $link; ?>
			             			</td>
			             		</tr>
		             		<?php } } ?>
	             	</tbody>
	            </table>
			</div>
		</div>
	</div>
</div>
<br>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="glyphicon glyphicon-th-list"></div>
			&nbsp;DAFTAR SURAT PERINGATAN 2
		</div>
		<div class="panel-body">
			<div class="table-responsive" style="max-height: 300px;" >
				<table id="example1" class="table table-bordered table-hover table-striped">
	                <thead>
	                	<tr>
	                		<th width="4%">No.</th>
	                		<th>Nis</th>
	                		<th>Nama</th>
	                		<th>Rombel</th>
	                		<th>Rayon</th>
	                		<th>Skor</th>
	                		<th>Status</th>
	                		<th>Rincian</th>
	                		<th>Aksi</th>
	                	</tr>
	                </thead>
	                <tbody>
	                	<?php  
	                		$no =0;
	                		$table = "tbl_kinerja_siswa";
	                		$where = "WHERE kelompok_kinerja = 'PUNISHMENT'";
	                		$sum = "nis,nama,rombel,kode_rayon,kelompok_kinerja,SUM(skor_p) as besar_skor";
	                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY besar_skor");
	                		foreach ($data as $r) {
	                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
	                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
								$rombel = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$siswa[kode_rombel]'");
	                			
	                			if($r['besar_skor'] >= 500 && $r['besar_skor'] < 750){
		                			$no++;

		                			$data_sp = $aksi->caridata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '2'");
		                			if (empty($data_sp)) {
			                			$status = "Mohon Untuk diproses";
			                			$link = "<a href='?menu=surat_peringatan&daftar&simpan&sp=2&nis=$r[nis]'>PROSES</a>";
		                			}else{
			                			$cek1 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '2'");
			                			$cek2 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '2' AND proses_kesiswaan = '1'");
			                			$cek3 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '2' AND proses_pembimbing = '1'");
			                			$cek4 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '2' AND proses_kesiswaan = '1' AND proses_pembimbing = '1'");
			                			$cek5 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '2' AND proses_kesiswaan = '1' AND proses_pembimbing = '1' AND status = '1'");

			                			if ($cek5 > 0) {
			                				$status = "Sudah diproses dengan no ".$data_sp['no_surat'];
			                				$link = "<a href='piket/sp/cetak.php?sp=2&nis=$r[nis]' target='_blank'>Cetak Ulang</a>";
			                			}elseif ($cek4 > 0) {
			                				$status = "Segera dicetak";
			                				$link = "<a href='?menu=surat_peringatan&proses&sp=2&nis=$r[nis]'>Tindak Lanjut</a>";
			                			}elseif ($cek3 == 0 AND  $cek2 > 0) {
			                				$status = "Menunggu Persetujuan Pembimbing Siswa";
			                				$link = "<a href='?menu=surat_peringatan&proses&sp=2&nis=$r[nis]'>Tindak Lanjut</a>";
			                			}elseif ($cek3 > 0) {
			                				$status = "Mohon Untuk diproses";
			                				$link = "<a href='?menu=surat_peringatan&daftar&proses&sp=2&nis=$r[nis]'>PROSES</a>";
			                			}elseif ($cek1 == 0 || $cek2 == 0) {
			                				$status = "Mohon Untuk diproses";
			                				$link = "<a href='?menu=surat_peringatan&daftar&proses&sp=2&nis=$r[nis]'>PROSES</a>";
			                			}
			                			
		                			}
	            				?>
	                		 	<tr>
			             			<td align="center"><?php echo $no; ?>.</td>
			             			<td><?php echo $r['nis']; ?></td>
			             			<td><?php echo $r['nama']; ?></td>
			             			<td><?php echo $rombel['rombel']; ?></td>
			             			<td><?php echo $rayon['rayon']; ?></td>
			             			<td align="center"><?php echo $r['besar_skor']; ?></td>
			             			<td><b><?php echo $status; ?></b></td>
			             			<td align="center">
				             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['kelompok_kinerja']; ?>" >
								           		RINCIAN
				             				</a>
				             				<div class="modal fade" id="<?php echo $r['nis'].$r['kelompok_kinerja']; ?>">
				             					<div class="modal-dialog modal-lg modal-primary">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Daftar Riwayat Punishment : <?php echo $r['nama']; ?></h4>
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
																		$no_detail = 0;
																		$where_detail = "WHERE nis = '$r[nis]' AND kelompok_kinerja = 'PUNISHMENT'";
																		$details = $aksi->tampil($table,$where_detail,"ORDER BY tgl_kejadian ASC");
																		foreach ($details as $detail) {
																			$no_detail++;
																			$detail_kinerja = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$detail[kode_kinerja]'");
																		?>
																			<tr>
																				<td><center><?php echo $no_detail; ?>.</center></td>
																				<td><?php $aksi->format_tanggal($detail['tgl_kejadian']); ?></td>
																				<td><?php echo $detail['kode_kinerja']." | ".$detail_kinerja['nama_kinerja']; ?></td>
																				<td><?php echo $detail['saksi']; ?></td>
																				<td><center><?php echo $detail['skor_p']; ?></center></td>
																			</tr>

																	<?php } ?>
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
			             				<?php echo $link; ?>
			             			</td>
			             		</tr>
		             		<?php } } ?>
	             	</tbody>
	            </table>
			</div>
		</div>
	</div>
</div>
<br>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="glyphicon glyphicon-th-list"></div>
			&nbsp;DAFTAR SURAT PERINGATAN 3
		</div>
		<div class="panel-body">
			<div class="table-responsive" style="max-height: 300px;" >
				<table id="example1" class="table table-bordered table-hover table-striped">
	                <thead>
	                	<tr>
	                		<th width="4%">No.</th>
	                		<th>Nis</th>
	                		<th>Nama</th>
	                		<th>Rombel</th>
	                		<th>Rayon</th>
	                		<th>Skor</th>
	                		<th>Status</th>
	                		<th>Rincian</th>
	                		<th>Aksi</th>
	                	</tr>
	                </thead>
	                <tbody>
	                	<?php  
	                		$no =0;
	                		$table = "tbl_kinerja_siswa";
	                		$where = "WHERE kelompok_kinerja = 'PUNISHMENT'";
	                		$sum = "nis,nama,rombel,kode_rayon,kelompok_kinerja,SUM(skor_p) as besar_skor";
	                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY besar_skor DESC");
	                		foreach ($data as $r) {
	                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
	                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
								$rombel = $aksi->caridata("tbl_rombel WHERE kode_rombel = '$siswa[kode_rombel]'");
	                			
	                			if($r['besar_skor'] >= 750){
		                			$no++;

		                			$data_sp = $aksi->caridata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '3'");
		                			if (empty($data_sp)) {
			                			$status = "Mohon Untuk diproses";
			                			$link = "<a href='?menu=surat_peringatan&daftar&simpan&sp=3&nis=$r[nis]'>PROSES</a>";
		                			}else{
			                			$cek1 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '3'");
			                			$cek2 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '3' AND proses_kesiswaan = '1'");
			                			$cek3 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '3' AND proses_pembimbing = '1'");
			                			$cek4 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '3' AND proses_kesiswaan = '1' AND proses_pembimbing = '1'");
			                			$cek5 = $aksi->cekdata("tbl_sp WHERE nis = '$r[nis]' AND sp_ke = '3' AND proses_kesiswaan = '1' AND proses_pembimbing = '1' AND status = '1'");

			                			if ($cek5 > 0) {
			                				$status = "Sudah diproses dengan no ".$data_sp['no_surat'];
			                				$link = "<a href='piket/sp/cetak.php?sp=3&nis=$r[nis]' target='_blank'>Cetak Ulang</a>";
			                			}elseif ($cek4 > 0) {
			                				$status = "Segera dicetak";
			                				$link = "<a href='?menu=surat_peringatan&proses&sp=3&nis=$r[nis]'>Tindak Lanjut</a>";
			                			}elseif ($cek3 == 0 AND  $cek2 > 0) {
			                				$status = "Menunggu Persetujuan Pembimbing Siswa";
			                				$link = "<a href='?menu=surat_peringatan&proses&sp=3&nis=$r[nis]'>Tindak Lanjut</a>";
			                			}elseif ($cek3 > 0) {
			                				$status = "Mohon Untuk diproses";
			                				$link = "<a href='?menu=surat_peringatan&daftar&proses&sp=3&nis=$r[nis]'>PROSES</a>";
			                			}elseif ($cek1 == 0 || $cek2 == 0) {
			                				$status = "Mohon Untuk diproses";
			                				$link = "<a href='?menu=surat_peringatan&daftar&proses&sp=3&nis=$r[nis]'>PROSES</a>";
			                			}
			                			
		                			}
	            				?>
	                		 	<tr>
			             			<td align="center"><?php echo $no; ?>.</td>
			             			<td><?php echo $r['nis']; ?></td>
			             			<td><?php echo $r['nama']; ?></td>
			             			<td><?php echo $rombel['rombel']; ?></td>
			             			<td><?php echo $rayon['rayon']; ?></td>
			             			<td align="center"><?php echo $r['besar_skor']; ?></td>
			             			<td><b><?php echo $status; ?></b></td>
			             			<td align="center">
				             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['kelompok_kinerja']; ?>" >
								           		RINCIAN
				             				</a>
				             				<div class="modal fade" id="<?php echo $r['nis'].$r['kelompok_kinerja']; ?>">
				             					<div class="modal-dialog modal-lg modal-primary">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															<h4 class="modal-title">Daftar Riwayat Punishment : <?php echo $r['nama']; ?></h4>
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
																		$no_detail = 0;
																		$where_detail = "WHERE nis = '$r[nis]' AND kelompok_kinerja = 'PUNISHMENT'";
																		$details = $aksi->tampil($table,$where_detail,"ORDER BY tgl_kejadian ASC");
																		foreach ($details as $detail) {
																			$no_detail++;
																			$detail_kinerja = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$detail[kode_kinerja]'");
																		?>
																			<tr>
																				<td><center><?php echo $no_detail; ?>.</center></td>
																				<td><?php $aksi->format_tanggal($detail['tgl_kejadian']); ?></td>
																				<td><?php echo $detail['kode_kinerja']." | ".$detail_kinerja['nama_kinerja']; ?></td>
																				<td><?php echo $detail['saksi']; ?></td>
																				<td><center><?php echo $detail['skor_p']; ?></center></td>
																			</tr>

																	<?php } ?>
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
			             				<?php echo $link; ?>
			             			</td>
			             		</tr>
		             		<?php } } ?>
	             	</tbody>
	            </table>
			</div>
		</div>
	</div>
</div>
<br>

