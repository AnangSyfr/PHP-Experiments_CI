<?php
$site = $this->konfigurasi_model->listing();
?>
<!-- footer -->
<div class="footer">	
<div class="container">
<div class="footer-grids">
	<div class="col-md-3 footer-grid">
		<h3 class="title">Produk</h3>
		<ul>
        
		<?php 
		$footer_produk	= $this->site_model->nav_produk();
		foreach($footer_produk as $foprod) {
		?>
			<li><a href="<?php echo base_url('produk/kategori/'.$foprod->slug_kategori_produk) ?>"><?php echo $foprod->nama_kategori_produk ?></a></li>
		<?php } ?>
        
		</ul>
	</div>
	<div class="col-md-3 footer-grid">
		<h3 class="title">Berita</h3>
		 <ul>
         	<?php
			$footer_berita	= $this->site_model->nav_berita();
			foreach($footer_berita as $fober) {
			?>
			<li><a href="<?php echo base_url('berita/kategori/'.$fober->slug_berita) ?>"><?php echo $fober->nama_berita ?></a></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-3 footer-grid">
		<h3 class="title">Profil</h3>
		<ul>
        <?php
		$footer_profil	= $this->site_model->nav_profil();
		foreach($footer_profil as $foprof) { 
		?>
			<li><a href="<?php echo base_url('berita/read/'.$foprof->slug_berita) ?>">
			<?php echo $foprof->nama_berita ?></a></li>
		<?php } ?>
		</ul>
	</div>
	<div class="col-md-3 footer-grid contact-grid">
			<h3 class="title">Contact us</h3>
			<ul>
				<li><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span><?php echo $site['namaweb']?>.</li>							
				<li class="adrs"><?php echo nl2br ($site['alamat'])?></li>
				<li><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span><?php echo $site['telepon']?></li>
				<li><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span><a href="mailto:<?php echo $site['email']?>"><?php echo $site['email']?></a></li>
			</ul>
	</div>
	<div class="clearfix"> </div>
</div>
</div>
</div>
<div class="copy">
<div class="container">
<div class="copy-left">
	<p>Copyright © 2015 <?php echo $site['namaweb']?>. All rights reserved | Design by <a href="<?php echo $site['website']?>"><?php echo $site['namaweb']?></a></p>
</div>
<div class="social-icons">
	<ul>
		<li><a href="<?php echo $site['facebook']?>" class="fb"></a></li>
		<li><a href="<?php echo $site['twitter']?>"></a></li>
        <li><a href="<?php echo $site['instagram']?>" class="ig"></a></li>
	</ul>	
</div>
<div class="clearfix"> </div>
</div>
</div>
<!--//footer-->
<!--smooth-scrolling-of-move-up-->
<script type="text/javascript">
$(document).ready(function() {
/*
var defaults = {
	containerID: 'toTop', // fading element id
	containerHoverID: 'toTopHover', // fading element hover id
	scrollSpeed: 1200,
	easingType: 'linear' 
};
*/

$().UItoTop({ easingType: 'easeOutQuart' });

});
</script>
<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!--//smooth-scrolling-of-move-up-->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url() ?>assets/front/js/bootstrap.js"></script>
</body>
</html>