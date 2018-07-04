<div class="content-wrapper">
	<section class="content-header">
		<h1>
	        Kinerja Siswa
        <small>Surat Peringatan</small>
      	</h1>
	    <ol class="breadcrumb">
	        <li><a href="?menu=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Kinerja Siswa</li>
	    	<li class="active">Surat Peringatan</li>
	    </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		            	<li <?php if(isset($_GET['daftar'])){echo "class=active";} ?>>
		            		<a href="?menu=surat_peringatan&daftar">Daftar Siswa Terkena Surat Peringatan</a>
		            	</li>
			            <li <?php if(isset($_GET['proses'])){echo "class=active";} ?>>
			            	<a href="?menu=surat_peringatan&proses">Proses Surat Peringatan</a>
			            </li>
		            </ul>

		            <section class="tab-content">
		            	<div class="active tab-pane">
			            	<div class="row">
			            		<?php
			            			if (isset($_GET['daftar'])) {
		            			  		include 'daftar_sp.php';
		            			  	}elseif (isset($_GET['proses'])) {
		            			  		include 'proses.php';
		            			  	}else{
		            			  		$aksi->redirect("?menu=surat_peringatan&daftar");
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