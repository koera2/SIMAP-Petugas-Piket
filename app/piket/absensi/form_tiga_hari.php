<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">Daftar Siswa Yang Tidak Masuk Lebih dari 3 Hari Berturut-turut</div>
		<div class="panel-body">
			<table id="absensi1" class="table table-bordered table-hover table-striped">
                <thead>
                	<tr>
                		<th width="6%"><center>No.</center></th>
                		<th><center>Nis</center></th>
                		<th><center>Nama</center></th>
                		<th><center>Rombel</center></th>
                		<th><center>Rayon</center></th>
                		<th><center>Detail</center></th>
                	</tr>
                </thead>
                <tbody>
                	<?php  
                		$no = 0;
                		$table = "tbl_absensi_siswa";
                		$today = date("Y-m-d");
                		$ambil_3 = date("d")-2;
                		if ($ambil_3 < 10) {
	                		$tgl_3 = date("Y-m")."-0".$ambil_3;
                		}else{
	                		$tgl_3 = date("Y-m")."-".$ambil_3;
                		}
                		$where = "WHERE hadir != '1' AND tgl_absen BETWEEN '$tgl_3' AND '$today' ";
                		$data = $aksi->tampil_sum("COUNT(nis) as jumlah, nis,nama,rombel,kode_rayon",$table,$where," GROUP BY nis ORDER BY nis ASC,tgl_absen DESC");
                		if (empty($data)) { ?>
                			<tr><td></td><td></td><td></td><td align="center">Data Tidak Ada</td><td></td><td></td></tr>
            		<?php }else{
                			foreach ($data as $r) {
                				$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
                				if ($r['jumlah'] >=3) {
	                				$no++;
            				?>
            				<tr>
		             			<td align="center"><?php echo $no;$cek ?>.</td>
		             			<td align="center"><?php echo $r['nis']; ?></td>
		             			<td><?php echo $r['nama']; ?></td>
		             			<td align="center"><?php echo $r['rombel']; ?></td>
		             			<td align="center"><?php echo $rayon['rayon']; ?></td>
                                <td align="center">
                                        <a href="#" data-toggle="modal" data-target="#<?php echo $r['nis']; ?>">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;DETAIL
                                        </a> 
                                        <div class="modal fade" id="<?php echo $r['nis']; ?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" id="pri">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Detail Tidak Hadir  : <?php echo $r['nama']; ?></h4>
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
                                                                        $whr = "WHERE nis = '$r[nis]' AND tgl_absen BETWEEN '$tgl_3' AND '$today'";
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
		             			<!-- <td align="center">
	             				<?php  
	             					if ($r['izin']=="1") {
	             						echo "Izin";
	             					}elseif ($r['alpa']=="1") {
	             						echo "<span class='text-danger'><b>Alpa</b></span>";
	             					}elseif ($r['sakit']=="1") {
	             						echo "Sakit";
	             					}elseif ($r['tugas']=="1") {
	             						echo "Tugas";
	             					}
		             			?>
		             			</td> -->
		             		</tr>
        			<?php } } } ?>
                </tbody>
            </table>
		</div>
	</div>
</div>