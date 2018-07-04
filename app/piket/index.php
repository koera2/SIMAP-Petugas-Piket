<?php  
	if (!isset($_GET['menu'])) {
		header("location:hal_utama.php?menu=dashboard");
	}
?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
	        Dashboard
	        <small>Menu utama</small>
      	</h1>
	    <ol class="breadcrumb">
	    	<li><a href="?menu=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Dashboard</li>
	    </ol>
	</section>

	<section class="content">
		<div class="row">
			<?php  
	        	$today = date("Y-m-d");
	        	$alpa = $aksi->sumdata("COUNT(nis) as day","tbl_absensi_siswa WHERE hadir != '1' AND tgl_absen = '$today'");
	        ?>
			<!-- tidak masuk -->
	        <div class="col-lg-3 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-aqua">
	            <div class="inner">
	              <h3><?php echo $alpa['day']; ?></h3>

	              <p>Siswa tidak masuk<br> hari ini</p>
	            </div>
	            <div class="icon">
	              <i class="ion ion-ios-information"></i>
	            </div>
	            <a href="?menu=absensi_form&tidak_masuk" class="small-box-footer">Lihat Detail &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	        <!-- end tidak masuk -->
	        <?php  
	        	$today = date("Y-m-d");
	        	$izin = $aksi->sumdata("COUNT(nis) as izin","tbl_izin_siswa WHERE tgl_izin = '$today'");
	        ?>
			<!-- izin -->
	        <div class="col-lg-3 col-xs-6">
	          <div class="small-box bg-green">
	            <div class="inner">
	              <h3><?php echo $izin['izin']; ?></h3>

	              <p>Siswa izin<br> hari ini</p>
	            </div>
	            <div class="icon">
	              <i class="ion ion-android-people"></i>
	            </div>
	            <a href="?menu=izin_form&daftar" class="small-box-footer">Lihat Detail &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
			<!-- end izin -->
			<?php  
				$sql = mysql_query("SELECT * FROM tbl_kinerja_siswa WHERE kelompok_kinerja = 'PUNISHMENT' AND skor_p >= 250");
				$cek = mysql_num_rows($sql);
			?>
			<!-- siswa bermasalah -->
	        <div class="col-lg-3 col-xs-6">
	         	<div class="small-box bg-yellow">
	            <div class="inner">
	              <h3><?php echo $cek;  ?></h3>
	              <p>Siswa Bermasalah<br>(Terkena Surat peringatan)</p>
	            </div>
	            <div class="icon">
	              <i class="ion ion-android-alert"></i>
	            </div>
	            <a href="?menu=kinerja_form&peringatan" class="small-box-footer">Lihat Detail &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
			<!-- end siswa bermasalah -->
			<?php  
				$today = date("Y-m-d");
				$ambil_3 = date("d")-2;
        		if ($ambil_3 < 10) {
            		$tgl_3 = date("Y-m")."-0".$ambil_3;
        		}else{
            		$tgl_3 = date("Y-m")."-".$ambil_3;
        		}
	        	$sq = mysql_query("SELECT  nis,COUNT(nis) as jumlah FROM tbl_absensi_siswa WHERE hadir != '1' AND tgl_absen BETWEEN '$tgl_3' AND '$today' GROUP BY nis");
        		$no_3=0;
	        	while ($t = mysql_fetch_array($sq)) {
	        		if ($t['jumlah']>=3) {
	        			$no_3++;
	        		}
	        	}
			?>
			<!-- tidak masuk 3 hari -->
	        <div class="col-lg-3 col-xs-6">
	          <div class="small-box bg-red">
	            <div class="inner">
	              <h3><?php echo $no_3; ?></h3>

	              <p>Siswa tidak masuk <br>3 hari Berturut-turut</p>
	            </div>
	            <div class="icon">
	              <i class="ion ion-android-alarm-clock"></i>
	            </div>
	            <a href="?menu=absensi_form&tiga_hari" class="small-box-footer">Lihat Detail &nbsp;<i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
			<!-- end tidak masuk 3 hari -->


		<!-- TABS  -->
	      	<div class="col-md-12">
	        	<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
			            <li class="active"><a href="#absensi" data-toggle="tab">Absensi Siswa</a></li>
			            <li ><a href="#izin" data-toggle="tab">Izin SIswa</a></li>
			            <li><a href="#kinerja" data-toggle="tab">Kinerja Siswa</a></li>
		            </ul>
		            <div class="tab-content">
		            	
					<!-- TAB ABSENSI  -->
			        	<div class="active tab-pane" id="absensi">
			              	<div class="row">
				              	<div class="col-md-12">
				                	<div class="col-md-6">
				                		<div class="panel panel-default">
											<div class="panel-heading">Daftar Siswa Yang Tidak Masuk Hari Ini</div>
											<div class="panel-body">
												<table id="absensi1" class="table table-bordered table-hover">
									                <thead>
									                	<tr>
									                		<th width="6%">No.</th>
									                		<th>Nis</th>
									                		<th>Nama</th>
									                		<th>Rombel</th>
									                		<th>Rayon</th>
									                		<th>Ket</th>
									                	</tr>
									                </thead>
									                <tbody>
									                	<?php  
									                		$no_ab_1 = 0;
									                		$table_ab_1 = "tbl_absensi_siswa";
									                		$today_ab_1 = date("Y-m-d");
									                		$where_ab_1 = "WHERE hadir != '1' AND tgl_absen = '$today_ab_1'";
									                		$data_ab_1 = $aksi->tampil($table_ab_1,$where_ab_1,"ORDER BY nis ASC");
									                		if (empty($data_ab_1)) { ?>
									                			<tr><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td></tr>
									            		<?php }else{
									                			foreach ($data_ab_1 as $r_ab_1) {
									                				$no_ab_1++;
									                				$rayon_ab_1 = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r_ab_1[kode_rayon]'");
									            				?>
									            				<tr>
											             			<td align="center"><?php echo $no_ab_1; ?>.</td>
											             			<td align="center"><?php echo $r_ab_1['nis']; ?></td>
											             			<td><?php echo $r_ab_1['nama']; ?></td>
											             			<td align="center"><?php echo $r_ab_1['rombel']; ?></td>
											             			<td align="center"><?php echo $rayon_ab_1['rayon']; ?></td>
											             			<td align="center"  data-toggle="tooltip" data-placement="bottom" title="<?php echo $r_ab_1['catatan'] ?>">
										             				<?php
											             				if ($r_ab_1['izin']=="1") {
										             						echo "<span class='label label-success'><b>Izin</b></span>";
										             					}elseif ($r_ab_1['alpa']=="1") {
										             						echo "<span class='label label-danger'><b>Alpa</b></span>";
										             					}elseif ($r_ab_1['sakit']=="1") {
										             						echo "<span class='label label-warning'><b>Sakit</b></span>";
										             					}elseif ($r_ab_1['tugas']=="1") {
										             						echo "<span class='label label-info'><b>Tugas</b></span>";
										             					}  
											             			?>
											             			</td>
											             		</tr>
									        			<?php } } ?>
									                </tbody>
									            </table>
											</div>
										</div>
				                	</div>

				                	<div class="col-md-6">
				                		<div class="panel panel-default">
											<div class="panel-heading">Daftar Siswa Yang Tidak Masuk Kemarin</div>
											<div class="panel-body">
												<table id="absensi2" class="table table-bordered table-hover">
									                <thead>
									                	<tr>
									                		<th width="6%">No.</th>
									                		<th>Nis</th>
									                		<th>Nama</th>
									                		<th>Rombel</th>
									                		<th>Rayon</th>
									                		<th>Ket</th>
									                	</tr>
									                </thead>
									                <tbody>
									                	<?php  
									                		$no_ab_1 = 0;
									                		$table_ab_1 = "tbl_absensi_siswa";
									                		$ambil_1 = date("d")-1;
									                		if ($ambil_1< 10) {
										                		$tgl_1 = date("Y-m")."-0".$ambil_1;
									                		}else{
										                		$tgl_1 = date("Y-m")."-".$ambil_1;
									                		}
									                		$where_ab_1 = "WHERE hadir != '1' AND tgl_absen = '$tgl_1'";
									                		$data_ab_1 = $aksi->tampil($table_ab_1,$where_ab_1,"ORDER BY nis ASC");
									                		if (empty($data_ab_1)) { ?>
									                			<tr><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td></tr>
									            		<?php }else{
									                			foreach ($data_ab_1 as $r_ab_1) {
									                				$no_ab_1++;
									                				$rayon_ab_1 = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r_ab_1[kode_rayon]'");
									            				?>
									            				<tr>
											             			<td align="center"><?php echo $no_ab_1; ?>.</td>
											             			<td align="center"><?php echo $r_ab_1['nis']; ?></td>
											             			<td><?php echo $r_ab_1['nama']; ?></td>
											             			<td align="center"><?php echo $r_ab_1['rombel']; ?></td>
											             			<td align="center"><?php echo $rayon_ab_1['rayon']; ?></td>
											             			<td align="center">
										             				<?php  
										             					if ($r_ab_1['izin']=="1") {
										             						echo "<span class='label label-success'><b>Izin</b></span>";
										             					}elseif ($r_ab_1['alpa']=="1") {
										             						echo "<span class='label label-danger'><b>Alpa</b></span>";
										             					}elseif ($r_ab_1['sakit']=="1") {
										             						echo "<span class='label label-warning'><b>Sakit</b></span>";
										             					}elseif ($r_ab_1['tugas']=="1") {
										             						echo "<span class='label label-info'><b>Tugas</b></span>";
										             					}
											             			?>
											             			</td>
											             		</tr>
									        			<?php } } ?>
									                </tbody>
									            </table>
											</div>
										</div>
				                	</div>
				                </div>
			                </div>
			            </div>
					<!-- END TAB ABSENSI -->

					<?php  
						$tbl_izin = "tbl_izin_siswa";
						$today_izin = date("Y-m-d");
					?>
					<!-- TAB IZIN  -->
			            <div class="tab-pane" id="izin">
			                <div class="row">
				              	<div class="col-md-12">
				                	<div class="col-md-6">
				                		<div class="panel panel-default">
				                			<div class="panel-heading">Daftar Siswa Yang Izin Keluar Hari Ini</div>
				                			<div class="panel-body">
				                				<table id="izin1" class="table table-bordered table-hover">
									                <thead>
									                	<tr>
									                		<th>No.</th>
									                		<th>Nis</th>
									                		<th>Nama</th>
									                		<th>Rombel</th>
									                		<th>Rayon</th>
									                		<th>Ket</th>
									                	</tr>
									                </thead>
									                <tbody>
									                	<?php  
									                		$no_izin = 0;
															$where_izin = "WHERE tgl_izin = '$today_izin' AND jenis_izin = 'IZIN KELUAR'";
									                		$data_izin = $aksi->tampil($tbl_izin,$where_izin,"ORDER BY nis ASC");
									                		if (empty($data_izin)) { ?>
									                			<tr><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td></tr>
								                		<?php }else{
									                			foreach ($data_izin as $r_izin) {
									                				$no_izin++;
										                			$rayon_izin = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r_izin[kode_rayon]'");
										                			?>
										                			<tr>
												            			<td><center><?php echo $no_izin; ?>.</center></td>
												            			<td><?php echo $r_izin['nis']; ?></td>
												            			<td><?php echo $r_izin['nama']; ?></td>
												            			
												            			<td><?php echo $r_izin['rombel']; ?></td>
												            			<td><?php echo $rayon_izin['rayon']; ?></td>
												            			<td><?php echo $r_izin['keperluan']; ?></td>
									                				</tr>
								                		<?php } } ?>
									                </tbody>
									            </table>
				                			</div>
				                		</div>
				                	</div>

				                	<div class="col-md-6">
				                		<div class="panel panel-default">
				                			<div class="panel-heading">Daftar Siswa Yang Izin Pulang Malam Hari Ini</div>
				                			<div class="panel-body">
				                				<table id="izin2" class="table table-bordered table-hover">
									                <thead>
									                	<tr>
									                		<th>No.</th>
									                		<th>Nis</th>
									                		<th>Nama</th>
									                		<th>Rombel</th>
									                		<th>Rayon</th>
									                		<th>Ket</th>
									                	</tr>
									                </thead>
									                <tbody>
									                	<?php  
									                		$no_izin = 0;
															$where_izin = "WHERE tgl_izin = '$today_izin' AND jenis_izin = 'PULANG MALAM'";
									                		$data_izin = $aksi->tampil($tbl_izin,$where_izin,"ORDER BY nis ASC");
									                		if (empty($data_izin)) { ?>
									                			<tr><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td></tr>
								                		<?php }else{
									                			foreach ($data_izin as $r_izin) {
									                				$no_izin++;
										                			$rayon_izin = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r_izin[kode_rayon]'");
										                			?>
										                			<tr>
												            			<td><center><?php echo $no_izin; ?>.</center></td>
												            			<td><?php echo $r_izin['nis']; ?></td>
												            			<td><?php echo $r_izin['nama']; ?></td>
												            			
												            			<td><?php echo $r_izin['rombel']; ?></td>
												            			<td><?php echo $rayon_izin['rayon']; ?></td>
												            			<td><?php echo $r_izin['keperluan']; ?></td>
									                				</tr>
								                		<?php } } ?>
									                </tbody>
									            </table>
				                			</div>
				                		</div>
				                	</div>
				                </div>
			                </div>
			            </div>
					<!-- END TAB IZIN -->

					<!-- TAB KINERJA -->
			            <div class="tab-pane" id="kinerja">
			                <div class="row">
				              	<div class="col-md-12">
				                	<div class="col-md-6">
				                		<div class="panel panel-default">
											<div class="panel-heading">Daftar Siswa Yang Sering Mendapatkan Penghargaan</div>
											<div class="panel-body">
												<div class="table-responsive">
													<table id="example" class="table table-bordered table-hover">
										                 <thead>
											                	<tr>
											                		<th width="4%">No.</th>
											                		<th>Nis</th>
											                		<th>Nama</th>
											                		<th>Rombel</th>
											                		<th>Rayon</th>
											                		<th><center>Jumlah Skor</center></th>
											                	</tr>
											                </thead>
											                <tbody>
											                	<?php  
											                		$no =0;
											                		$table = "tbl_kinerja_siswa";
											                		$where = "WHERE kelompok_kinerja = 'REWARD'";
											                		$sum = "nis,nama,rombel,kode_rayon,kelompok_kinerja,SUM(skor_r) as besar_skor";
											                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY besar_skor DESC LIMIT 0,100");
											                		if (!empty($data)) {
											                		foreach ($data as $r) {
											                			$no++;
											                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
											                		 ?>
											                		 	<tr>
													             			<td align="center"><?php echo $no; ?>.</td>
													             			<td><?php echo $r['nis']; ?></td>
													             			<td><?php echo $r['nama']; ?></td>
													             			<td><?php echo $r['rombel']; ?></td>
													             			<td><?php echo $r['kode_rayon']; ?></td>
													             			<td align="center">
													             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['kelompok_kinerja']; ?>" >
																	           		<?php echo $r['besar_skor']; ?>
													             				</a>
													             				<div class="modal fade" id="<?php echo $r['nis'].$r['kelompok_kinerja']; ?>">
													             					<div class="modal-dialog modal-lg modal-primary">
																						<div class="modal-content">
																							<div class="modal-header">
																								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																								<h4 class="modal-title">Daftar Riwayat Reward : <?php echo $r['nama']; ?></h4>
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
																											$where_detail = "WHERE nis = '$r[nis]' AND kelompok_kinerja = 'REWARD'";
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
																													<td><center><?php echo $detail['skor_r']; ?></center></td>
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
													             		</tr>

										                		<?php  } } ?>
											                </tbody>
										            </table>
												</div>
											</div>
										</div>
				                	</div>

				                	<div class="col-md-6">
				                		<div class="panel panel-default">
											<div class="panel-heading">Daftar Siswa Yang Sering Mendapatkan Peringatan</div>
											<div class="panel-body">
												<div class="table-responsive">
													<table id="example2" class="table table-bordered table-hover">
										                 <thead>
											                	<tr>
											                		<th width="4%">No.</th>
											                		<th>Nis</th>
											                		<th>Nama</th>
											                		<th>Rombel</th>
											                		<th>Rayon</th>
											                		<th><center>Jumlah Skor</center></th>
											                	</tr>
											                </thead>
											                <tbody>
											                	<?php  
											                		$no =0;
											                		$table = "tbl_kinerja_siswa";
											                		$where = "WHERE kelompok_kinerja = 'PUNISHMENT'";
											                		$sum = "nis,nama,rombel,kode_rayon,kelompok_kinerja,SUM(skor_p) as besar_skor";
											                		$data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY nis ORDER BY besar_skor DESC LIMIT 0,100");
											                		if (!empty($data)) {
											                		foreach ($data as $r) {
											                			$no++;
											                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
											                		 ?>
											                		 	<tr>
													             			<td align="center"><?php echo $no; ?>.</td>
													             			<td><?php echo $r['nis']; ?></td>
													             			<td><?php echo $r['nama']; ?></td>
													             			<td><?php echo $r['rombel']; ?></td>
													             			<td><?php echo $r['kode_rayon']; ?></td>
													             			<td align="center">
													             				<a href="#" data-toggle="modal" data-target="#<?php echo $r['nis'].$r['kelompok_kinerja']; ?>" >
																	           		<?php echo $r['besar_skor']; ?>
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
													             		</tr>

										                		<?php }} ?>
											                </tbody>
										            </table>
												</div>
											</div>
										</div>
				                	</div>
				                </div>
			                </div>
			            </div>
					<!-- END TAB KINERJA  -->

		            </div>
		        </div>
	        </div>
	    <!-- END TABS -->
	    </div>
	</section>
</div>
<!-- 
	<script type="text/javascript">
		$(document).ready(function(){
			$('.klik-reward').click(function(){
				var nis_r = $(this).data('nis_r');
				var kelompok_r = $(this).data('kelompok_r');
				var tbl_r = $(this).data('tblreward');
				$('#' + tbl_r).load('{{url('piket/kinerja/ajax/reward/')}}' + '/'+nis_r+'/'+kelompok_r);
			})
		})
		$(document).ready(function(){
			$('.klik-punishment').click(function(){
				var nis_p = $(this).data('nis_p');
				var kelompok_p = $(this).data('kelompok_p');
				var tbl_p = $(this).data('tblpunishment');
				$('#' + tbl_p).load('{{url('piket/kinerja/ajax/punishment/')}}' + '/'+nis_p+'/'+kelompok_p);
			})
		})
	</script>
@endsection -->
