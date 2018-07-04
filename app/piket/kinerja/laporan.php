
<div class="content-wrapper">
	<section class="content-header">
		<h1>
	        Kinerja Siswa
        <small>Laporan Kinerja</small>
      	</h1>
	    <ol class="breadcrumb">
	        <li><a href="?menu=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Kinerja Siswa</li>
	    	<li class="active">Laporan Kinerja</li>
	    </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		            	<li <?php if(isset($_GET['rombelM'])){echo "class=active";} ?>>
		            		<a href="?menu=kinerja_laporan&rombelM"><center>Per-Rombel<br>(Bulan)</center></a>
		            	</li>
			            <li <?php if(isset($_GET['rombelS'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_laporan&rombelS"><center>Per-Rombel<br>(Semester)</center></a>
			            </li>
			            <li <?php if(isset($_GET['rombelP'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_laporan&rombelP"><center>Per-Rombel<br>(Periode)</center></a>
			            </li>
			            <li <?php if(isset($_GET['rayon'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_laporan&rayon"><center>Per-Rayon<br>(Semuanya)</center></a>
			            </li>
			             <li <?php if(isset($_GET['rayonM'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_laporan&rayonM"><center>Per-Rayon<br>(Bulan)</center></a>
			            </li>
						<li <?php if(isset($_GET['rayonS'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_laporan&rayonS"><center>Per-Rayon<br>(Semester)</center></a>
			            </li>
			            <li <?php if(isset($_GET['rayonP'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_laporan&rayonP"><center>Per-Rayon<br>(Periode)</center></a>
			            </li>
			            <li <?php if(isset($_GET['siswa'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_laporan&siswa"><center>Laporan<br>Persiswa</center></a>
			            </li>			            
			            <li <?php if(isset($_GET['alasan'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_laporan&alasan"><center>Laporan Alasan<br>Melanggar</center></a>
			            </li>
		            </ul>

		            <section class="tab-content">
		            	<div class="active tab-pane">
			            	<div class="row">
			            		<?php
			            			if (isset($_GET['rombelM'])) {
		            			  		include 'laporan_rombelM.php';
		            			  	}elseif (isset($_GET['rombelS'])) {
		            			  		include 'laporan_rombelS.php';
		            			  	}elseif (isset($_GET['rombelP'])) {
		            			  		include 'laporan_rombelP.php';
		            			  	}elseif (isset($_GET['rayon'])) {
		            			  		include 'laporan_rayon.php';
		            			  	}elseif (isset($_GET['rayonM'])) {
		            			  		include 'laporan_rayonM.php';
		            			  	}elseif (isset($_GET['rayonS'])) {
		            			  		include 'laporan_rayonS.php';
		            			  	}elseif (isset($_GET['rayonP'])) {
		            			  		include 'laporan_rayonP.php';
		            			  	}elseif (isset($_GET['siswa'])) {
		            			  		include 'laporan_siswa.php';
		            			  	}elseif (isset($_GET['alasan'])) {
		            			  		include 'laporan_alasan.php';
		            			  	}else{
		            			  		$aksi->redirect("?menu=kinerja_laporan&rombelM");
		            			  	}
			            		?>
			              	</div>
			            </div>
		            </section>
		        </div>
			</div>
		</div>
	</section>
</div>