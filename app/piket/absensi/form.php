<div class="content-wrapper">
	<section class="content-header">
		<h1>
	        Absensi Siswa
        <small>Form Absensi</small>
      	</h1>
	    <ol class="breadcrumb">
	        <li><a href="?menu=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Absensi Siswa</li>
	    	<li class="active">Form Absensi</li>
	    </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		            	<li <?php if(isset($_GET['input'])){echo "class=active";} 
			    //         	unset($_SESSION['rombel']);
							// unset($_SESSION['tanggal']);
		            	?>>
		            		<a href="?menu=absensi_form&input">Absensi Siswa</a>
		            	</li>
		            	<li <?php if(isset($_GET['riwayat'])){echo "class=active";} ?>>
		            		<a href="?menu=absensi_form&riwayat">Riwayat Absensi Siswa</a>
		            	</li>
			            <li <?php if(isset($_GET['ubah'])){echo "class=active";} ?>>
			            	<a href="?menu=absensi_form&ubah">Ubah Absensi Siswa</a>
			            </li>
			            <li <?php if(isset($_GET['belum_absen'])){echo "class=active";}
			            ?>>
			            	<a href="?menu=absensi_form&belum_absen">Rombel Belum Absensi</a>
			            </li>
			            <li <?php if(isset($_GET['tidak_masuk'])){echo "class=active";} ?>>
			            	<a href="?menu=absensi_form&tidak_masuk">Siswa Tidak Masuk Hari Ini</a>
			            </li>
			            <li <?php if(isset($_GET['tiga_hari'])){echo "class=active";} ?>>
			            	<a href="?menu=absensi_form&tiga_hari">Siswa Tidak Masuk 3 Hari Berturut-turut</a>
			            </li>
		            </ul>

		            <section class="tab-content">
		            	<div class="active tab-pane">
			            	<div class="row">
			            		<?php
			            			if (isset($_GET['input'])) {
		            			  		include 'form_input.php';
		            			  	}elseif (isset($_GET['riwayat'])) {
		            			  		include 'form_riwayat.php';
		            			  	}elseif (isset($_GET['ubah'])) {
		            			  		include 'form_ubah.php';
		            			  	}elseif (isset($_GET['belum_absen'])) {
		            			  		include 'form_belum_absen.php';
		            			  	}elseif (isset($_GET['tidak_masuk'])) {
		            			  		include 'form_tidak_masuk.php';
		            			  	}elseif (isset($_GET['tiga_hari'])) {
		            			  		include 'form_tiga_hari.php';
		            			  	}else{
		            			  		$aksi->redirect("?menu=absensi_form&input");
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