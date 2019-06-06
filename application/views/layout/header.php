<?php
$site = $this->konfigurasi_model->listing();
?>
<!--header-->
<div class="logo">
  <div class="container">
	  <div class="logo-info">
		  <a href="<?php echo base_url() ?>">
			  <h1><?php echo $site['namaweb'] ?></h1>	
			  
		  </a>
	  </div>
  </div>	
</div>
<!--//header-->		