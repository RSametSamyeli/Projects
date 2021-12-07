<?php  if(!defined("SABIT") ){ exit; }

		function tab_mix(){
			global $def;
			global $ayar;
			global $lang;
			for( $i=1;$i<4;$i++ ){
				   if( ($def["tabsira".$i] =="tabvideo") && ($def["tabvideoon"]=="aktif") ){
					echo '<li><a href="#'.$def["tabsira".$i].'" role="tab" data-toggle="tab"><i class="fa fa-video-camera"></i> '.$lang["yardimci"]["urun_videosu"].'</a></li>';
				}else if( ($def["tabsira".$i]=="tabextra") && ($def["tabextraon"]=="aktif") ){
					echo '<li><a href="#'.$def["tabsira".$i].'" role="tab" data-toggle="tab"><i class="fa fa-newspaper-o"></i> '.$lang["yardimci"]["urun_ozellikleri"].'</a></li>';
				}else if( ($def["tabsira".$i]=="tabform") && ($def["tabformon"]=="aktif") ){
					 echo '<li><a href="#'.$def["tabsira".$i].'" role="tab" data-toggle="tab"><i class="fa fa-chain-broken"></i> '.$lang["yardimci"]["urun_formu"].'</a></li>';
				}
			}
	}
?>
<div class="cihaniriboy-urun-tabs">
	<!--Nav tabs -->
		<ul class="nav nav-tabs urun-tabs-ul cihaniriboy-urun-tab" role="tablist">
		   <?php 
			tab_mix();
		  ?>
		</ul>
	<!--Tab panes -->
		<div class="tab-content cihaniriboy-urun-tab-content">
		<!-- Video -->
		 <div class="tab-pane" id="<?php echo $def['tabsira1']; ?>">
				<?php if($def["tabsira1"] == "tabvideo"){ ?>
				<div class="urun-video">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo substr(stristr($bul['video'],"v="),2);?>?rel=0" allowfullscreen=""></iframe>
					</div>
				</div>
				<?php }elseif($def["tabsira1"] == "tabextra"){ ?>
				<div class="urun-video">
					<div class="u-ozellikler">
						<?php 
							$table = $unx_tabextra[$set['lang']['active']];
							echo html_entity_decode($table);
						?>
					</div>
				</div>
				<?php }else{ 
					include("include/modules/urunler/yardimci/urunformu.php");
				 } ?>
		  </div>
			<!-- #Video -->
		<!--Urun Oellikleri -->
		<div class="tab-pane" id="<?php echo $def['tabsira2']; ?>">
				<?php if($def["tabsira2"] == "tabvideo"){ ?>
				<div class="urun-video">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo substr(stristr($bul['video'],"v="),2);?>?rel=0" allowfullscreen=""></iframe>
					</div>
				</div>
				
				<?php } elseif($def["tabsira2"] == "tabextra"){ ?>
				<div class="urun-video">
					<div class="cihaniriboy-u-ozellikler">
						<?php 
							$table = $unx_tabextra[$set['lang']['active']];
							echo html_entity_decode($table);
						?>
					</div>
				</div>
				<?php }else{ 
					include("include/modules/urunler/yardimci/urunformu.php");
				 } ?>
		  </div>
		<!--#Urun özellikleri -->
			<!-- Formu-->
		  <div class="tab-pane" id="<?php echo $def['tabsira3']; ?>">
			<?php if($def["tabsira3"] == "tabvideo"){ ?>
				<div class="urun-video">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo substr(stristr($bul['video'],"v="),2);?>?rel=0" allowfullscreen=""></iframe>
					</div>
				</div>
				<?php }  elseif($def["tabsira3"] == "tabextra"){ ?>
				<div class="urun-video">
					<div class="u-ozellikler">
						<?php 
							$table = $unx_tabextra[$_SESSION["dil"]];
							echo html_entity_decode($table);
						?>
					</div>
				</div>
				<?php }else{ 
					include("include/modules/urunler/yardimci/urunformu.php");
				 } ?>
		  </div>
			<!-- #Formu-->
		</div>
</div>
