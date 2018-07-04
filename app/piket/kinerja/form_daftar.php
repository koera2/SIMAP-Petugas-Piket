<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">Daftar Kinerja Siswa</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="example1" class="table table-bordered table-hover table-striped">
	                <thead>
	                	<tr>
	                		<th width="4%">No.</th>
	                		<th>Nis</th>
	                		<th>Nama</th>
	                		<th>JK</th>
	                		<th>Rombel</th>
	                		<th>Rayon</th>
	                		<th>Kelompok</th>
	                		<th>Kinerja</th>
	                		<th>Tanggal</th>
	                		<th>Skor</th>
	                		<th>Saksi</th>
	                		<th>Hapus</th>
	                		<th>Edit</th>
	                	</tr>
	                </thead>
	                <tbody>
	                	<?php  
	                		$table = "tbl_kinerja_siswa";
	                		$id = @$_GET['id'];
	                		$where = "id_kinerja = '$id'";
	                		$redirect = "?menu=kinerja_form&daftar";
	                		if (isset($_GET['hapus'])) {
	                			$aksi->hapus($table,$where);
	                			$aksi->alert("Data Berhasil Dihapus",$redirect);
	                		}

	                		$no = 0;
	                		$data = $aksi->tampil($table,"","ORDER BY id_kinerja DESC");
	                		if (!empty($data)) {
	                		foreach ($data as $r) { 
	                			$no++;
	                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
	                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
	                			?>
	                			<?php if($r['tgl_kejadian']==date("Y-m-d")){ 
	                				echo "<tr class='info'>";
	                			}else{
	                				echo "<tr>";
	                			}
                				?>
			            			<td><center><?php echo $no; ?>.</center></td>
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
			            			<td><?php echo $r['kelompok_kinerja']; ?></td>
			            			<td><?php echo $r['kode_kinerja']; ?></td>
			            			<td><?php $aksi->format_tanggal($r['tgl_kejadian']); ?></td>
			            			<td>
			            				<center>
			            				<?php  
			            					if ($r['kelompok_kinerja']=="REWARD") {
			            						echo $r['skor_r'];
			            					}else{
			            						echo $r['skor_p'];
			            					}
			            				?>
				            			</center>
			            			<td><?php echo $r['saksi']; ?></td>
			            			<td>
			            				<center>
			            					<a href="?menu=kinerja_form&daftar&hapus&id=<?php echo $r['id_kinerja']; ?>" onclick="return confirm('Apakah Anda yakin akan menghapus Kinerja ini ?')"  class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
			            				</center>
			            			</td>
			             			<td>
			             				<center>
			             					<a href="?menu=kinerja_form&input&edit&id=<?php echo $r['id_kinerja']; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
			             				</center>
			             			</td>
			            		</tr>
                		<?php } } ?>
	                </tbody>
	            </table>
			</div>
		</div>
	</div>
</div>