<div class="content-wrapper">
	<section class="content-header">
		<h1>
	        Kinerja Siswa
        <small>Form Kinerja</small>
      	</h1>
	    <ol class="breadcrumb">
	        <li><a href="?menu=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Kinerja Siswa</li>
	    	<li class="active">Form Kinerja</li>
	    </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		            	<li <?php if(isset($_GET['daftar'])){echo "class=active";} ?>>
		            		<a href="?menu=kinerja_form&daftar">Daftar Kinerja Siswa</a>
		            	</li>
			            <li <?php if(isset($_GET['input'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_form&input">Input Kinerja Siswa</a>
			            </li>
			            <li <?php if(isset($_GET['peringatan'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_form&peringatan">Daftar Siswa Yang Sering Mendapatkan Peringatan</a>
			            </li>
			            <li <?php if(isset($_GET['penghargaan'])){echo "class=active";} ?>>
			            	<a href="?menu=kinerja_form&penghargaan">Daftar Siswa Yang Sering Mendapatkan Penghargaan</a>
			            </li>
		            </ul>

		            <section class="tab-content">
		            	<div class="active tab-pane">
			            	<div class="row">
			            		<?php
			            			if (isset($_GET['daftar'])) {
		            			  		include 'form_daftar.php';
		            			  	}elseif (isset($_GET['input'])) {
		            			  		include 'form_input.php';
		            			  	}elseif (isset($_GET['peringatan'])) {
		            			  		include 'form_peringatan.php';
		            			  	}elseif (isset($_GET['penghargaan'])) {
		            			  		include 'form_penghargaan.php';
		            			  	}else{
		            			  		$aksi->redirect("?menu=kinerja_form&daftar");
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