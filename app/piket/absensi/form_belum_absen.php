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
				<a href="?menu=absensi_form&belum_absen" class="btn btn-primary">Hari Ini</a>
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
				<div class="panel-heading">Daftar Rombel Yang Belum Absen Tanggal <?php $aksi->format_tanggal($tanggal); ?></div>
		<?php }else{ 
					$where = "WHERE tgl_absen = '$today'";
			?>
				<div class="panel-heading">Daftar Rombel Yang Belum Absen Hari Ini - <?php $aksi->format_tanggal($today); ?></div>
		<?php } ?>
		<div class="panel-body">
			<table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                	<tr>
	                	<th><center>No.</center></th>
                		<th><center>Rombel</center></th>
                		<th><center>Jumlah Siswa</center></th>
                		<th><center>Tanggal</center></th>
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
	                			if ($cek <= 0 ) {
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
                				</tr>
            		<?php } } } ?>
                </tbody>
            </table>
		</div>
	</div>
</div>