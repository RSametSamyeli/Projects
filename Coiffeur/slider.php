  <?php 
  if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

  	exit("Bu sayfaya erişim yasak");

  }

  ?>

  <div class="slider-container slider-container-height-720 rev_slider_wrapper">
  	<div id="revolutionSlider" class="slider rev_slider" data-version="5.4.7" data-plugin-revolution-slider data-plugin-options="{'delay': 9000, 'gridwidth': [1140,960,720,540], 'gridheight': [720,720,720,720], 'disableProgressBar': 'on', 'responsiveLevels': [4096,1200,992,576], 'navigation' : {'arrows': { 'enable': false, 'style': 'slider-arrows-style-1' }, 'bullets': {'enable': false, 'style': 'bullets-style-1', 'h_align': 'center', 'v_align': 'bottom', 'space': 7, 'v_offset': 35, 'h_offset': 0}}}">
  		<ul>

  			<?php 

  			$slidersor=$db->prepare("select * from slider where slider_durum=? order by slider_sira limit 25");
  			$slidersor->execute(array(1));

  			while($slidercek=$slidersor->fetch(PDO::FETCH_ASSOC)) {
  				?>
  				<li class="slide-overlay slide-overlay-level-3" data-transition="fade">
  					<img src="<?php echo $slidercek['slider_resimyol']; ?>"  
  					alt=""
  					data-bgposition="center center" 
  					data-bgfit="cover" 
  					data-bgrepeat="no-repeat" 
  					data-kenburns="on" 
  					data-duration="20000" 
  					data-ease="Linear.easeNone" 
  					data-scalestart="110" 
  					data-scaleend="100" 
  					data-offsetstart="250 100" 
  					class="rev-slidebg">

  					<h1 class="tp-caption text-color-light font-primary font-weight-bold"
  					data-x="center"
  					data-y="center" data-voffset="['10','10','10','30']"
  					data-start="1000"
  					data-fontsize="['65','65','65','50']"
  					data-transform_in="y:[-50%];opacity:0;s:500;"
  					data-transform_out="y:[-50%];opacity:0;s:500;"><?php echo $slidercek['slider_ad']; ?></h1>

  					<div class="tp-caption text-color-light font-primary font-weight-light"
  					data-x="center"
  					data-y="center" data-voffset="['80','80','80','100']"
  					data-start="1300"
  					data-fontsize="['37','37','37','30']"
  					data-transform_in="y:[-50%];opacity:0;s:500;"
  					data-transform_out="y:[-50%];opacity:0;s:500;"><?php echo $slidercek['slider_aciklama']; ?></div>


  				</li>
  				 <?php } ?>
  			</ul>
  		</div>
  	</div>