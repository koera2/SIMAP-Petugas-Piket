<div class="content-wrapper">
	<section class="content-header">
		<h1>
	        Izin Siswa
        <small>Form Izin</small>
      	</h1>
	    <ol class="breadcrumb">
	        <li><a href="?menu=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Izin Siswa</li>
	    	<li class="active">Form Izin</li>
	    </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
		            	<li <?php if(isset($_GET['daftar'])){echo "class=active";} ?>>
		            		<a href="?menu=izin_form&daftar">Daftar Izin Siswa</a>
		            	</li>
			            <li <?php if(isset($_GET['input'])){echo "class=active";} ?>>
			            	<a href="?menu=izin_form&input">Input Izin Siswa</a>
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
		            			  	}else{
		            			  		$aksi->redirect("?menu=izin_form&daftar");
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