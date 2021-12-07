  <?php 
  if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

  	exit("Bu sayfaya erişim yasak");

  }

  ?>

  
  <!-- SLIDER BASLANGIC // REVOLUTION SLIDER KULLANILDI -->
  <div class="slider-container slider-container-height-550 rev_slider_wrapper">
    <div id="revolutionSlider" class="slider rev_slider" data-version="5.4.7" data-plugin-revolution-slider data-plugin-options="{'delay': 9000, 'gridwidth': [1140,960,720,540], 'gridheight': [550,550,550,550], 'responsiveLevels': [4096,1200,992,576], 'parallax': { 'type': 'mouse', 'origo': 'slidercenter', 'speed': 2000, 'levels': [2,3,4,5,6,7,12,16,10,50], 'disable_onmobile': 'on' }, 'navigation' : {'arrows': { 'enable': true, 'hide_under': 767, 'style': 'slider-arrows-style-1' }, 'bullets': {'enable': true, 'style': 'bullets-style-1', 'h_align': 'center', 'v_align': 'bottom', 'space': 7, 'v_offset': 25, 'h_offset': 0}}}">


      <ul>
        <?php 

        $slidersor=$db->prepare("select * from slider where slider_durum=? order by slider_sira limit 25");
        $slidersor->execute(array(1));

        while($slidercek=$slidersor->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <li data-transition="fade">
            
            <!--SLIDER RESMI-->
            <img src="<?php echo $slidercek['slider_resimyol']; ?>" 
            alt=""
            data-bgposition="center center" 
            data-bgfit="cover" 
            data-bgrepeat="no-repeat"
            class="rev-slidebg">
            <!--SLIDER RESMI SON-->

            <h1 class="tp-caption text-color-light font-primary font-weight-bold letter-spacing-0 rs-parallaxlevel-1"
            data-x="center"
            data-y="center" data-voffset="['-70','-70','-50','-40']"
            data-start="1000"
            data-fontsize="['65','65','45','30']"
            data-lineheight="['65','65','50','35']"
            data-transform_in="y:[100%];s:500;"
            data-transform_out="y:[100%];s:500;"
            data-mask_in="x:0px;y:0px;"><?php echo $slidercek['slider_ad']; ?></h1>

            <div class="tp-caption text-color-light font-primary font-weight-bold rs-parallaxlevel-2"
            data-x="center"
            data-y="center"
            data-start="1400"
            data-fontsize="['65','65','45','30']"
            data-lineheight="['65','65','50','35']"
            data-transform_in="y:[100%];s:500;"
            data-transform_out="y:[100%];s:500;"
            data-mask_in="x:0px;y:0px;"><?php echo $slidercek['slider_aciklama']; ?></div>

            <div class="tp-caption border border-left-0 border-bottom-0 border-right-0 border-light rs-parallaxlevel-1"
            data-x="center"
            data-y="center" data-voffset="['70','70','70','55']"
            data-start="1800"
            data-width="['850','850','600','400']"
            data-transform_in="opacity:0;s:300;"
            data-transform_idle="opacity:0.4;s:300;"
            data-transform_out="opacity:0;s:300;"></div>

            <div class="tp-caption text-color-light font-primary font-weight-light rs-parallaxlevel-2"
            data-x="center"
            data-y="center" data-voffset="['120','120','120','100']"
            data-start="2100"
            data-fontsize="['30','30','30','27']"
            data-lineheight="['35','35','35','32']"
            data-transform_in="y:[100%];s:500;"
            data-transform_out="y:[100%];s:500;"
            data-mask_in="x:0px;y:0px;"><?php echo $ayarcek['ayar_slogan']; ?></div>

          </li>
 <?php } ?>
        </ul>
       
      </div>
    </div>