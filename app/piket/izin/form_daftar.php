<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">Daftar Izin Siswa</div>
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
	                		<th>Waktu Izin</th>
	                		<th>Tanggal</th>
	                		<th>Izin</th>
	                		<th>Keterangan</th>
	                		<th>PJ</th>
	                		<th>Hapus</th>
	                		<th>Edit</th>
	                	</tr>
	                </thead>
	                <tbody>
	                	<?php  
	                		$table = "tbl_izin_siswa";
	                		$id = @$_GET['id'];
	                		$where = "id_izin = '$id'";
	                		$redirect = "?menu=izin_form&daftar";
	                		if (isset($_GET['hapus'])) {
	                			$aksi->hapus($table,$where);
	                			$aksi->alert("Data Berhasil Dihapus",$redirect);
	                		}

	                		$no = 0;
	                		$data = $aksi->tampil($table,"","ORDER BY id_izin DESC");
	                		if (!empty($data)) { 
	                		foreach ($data as $r) { 
	                			$no++;
	                			$siswa = $aksi->caridata("tbl_siswa WHERE nis = '$r[nis]'");
	                			$rayon = $aksi->caridata("tbl_rayon WHERE kode_rayon = '$r[kode_rayon]'");
	                			?>
	                			<?php if($r['tgl_izin']==date("Y-m-d")){ 
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
			            			<td><?php echo substr($r['waktu'], 11,8); ?></td>
			            			<td><?php $aksi->format_tanggal($r['tgl_izin']); ?></td>
			            			<td><?php echo $r['jenis_izin']; ?></td>
			            			<td><?php echo $r['keperluan']; ?></td>
			            			<td><?php echo $r['pj_izin']; ?></td>
			            			<td>
			            				<center>
			            					<a href="?menu=izin_form&daftar&hapus&id=<?php echo $r['id_izin']; ?>" onclick="return confirm('Apakah Anda yakin akan menghapus Kinerja ini ?')"  class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>
			            				</center>
			            			</td>
			             			<td>
			             				<center>
			             					<a href="?menu=izin_form&input&edit&id=<?php echo $r['id_izin']; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
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