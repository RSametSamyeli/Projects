<?php
$title="Haberler"; 
include 'header.php'; 

?>   
<div role="main" class="main">
	<section class="page-header mb-0">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 text-md-left">
					<h1 class="font-weight-bold">Blog</h1>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumb justify-content-md-end">
						<li><a href="index.php">Anasayfa</a></li>
						<li class="active">Blog</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container">
			<div class="row justify-content-center">



				<?php

                $sayfada = 4; // sayfada gösterilecek içerik miktarını belirtiyoruz.


                $sorgu=$db->prepare("select * from icerik");
                $sorgu->execute();
                $toplam_icerik=$sorgu->rowCount();

                $toplam_sayfa = ceil($toplam_icerik / $sayfada);

                  // eğer sayfa girilmemişse 1 varsayalım.
                $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

                // eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
                if($sayfa < 1) $sayfa = 1; 

                // toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
                if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

                $limit = ($sayfa - 1) * $sayfada;

                $iceriksor=$db->prepare("select * from icerik order by icerik_zaman DESC limit $limit,$sayfada");
                $iceriksor->execute();

                while($icerikcek=$iceriksor->fetch(PDO::FETCH_ASSOC)) { ?>

                <div class="col-sm-6 order-<?php echo $icerikcek['icerik_id']; ?> p-sm-0 mb-4">
                	<a href="haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?>">
                		<div class="image-frame hover-effect-2 h-100">
                			<div class="image-frame-wrapper min-height-285 h-100">

                				<img src="<?php echo $icerikcek['icerik_resimyol']; ?>" class="image-frame-background">
                			</div>
                		</div>
                	</a>
                </div>
              <div class="col-sm-6 order-<?php echo $icerikcek['icerik_id']; ?> p-sm-0 mb-4">
                	<div class="card bg-light-5 border-0 justify-content-center h-100">
                		<div class="card-body card-body-flex-0 p-5">
                			<span class="d-block top-sub-title text-color-primary mb-2"><?php echo $icerikcek['icerik_zaman']; ?></span>
                			<h2 class="text-color-dark font-weight-semibold line-height-3 text-4 mb-1">
                				<a href="haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?>" class="link-color-dark d-block"><?php echo $icerikcek['icerik_ad']; ?></a>
                			</h2>
                			<p><?php echo substr($icerikcek['icerik_detay'],0,300); ?>...</p>
                			
                			<a href="haber-<?=seo($icerikcek["icerik_ad"]).'-'.$icerikcek["icerik_id"]?>"><button type="button" class="btn btn-rounded btn-success mb-2">Devamını Oku</button></a>  
                		</div>
                	</div>
                </div>

                <?php } ?>


            </div>
            <hr class="mt-5 mb-4">
            <div class="row align-items-center justify-content-between">
            	<div class="col-auto mb-3 mb-sm-0">
            		<span>Yan Taraftan Sayfa Seçebilirsiniz</span>
            	</div>
            	<div class="col-auto">
            		<nav aria-label="Page navigation example">
            			<ul class="pagination mb-0">
                <?php

                $s=0;

                while ($s < $toplam_sayfa) {

                    $s++; ?>

                    <?php 

                    if ($s==$sayfa) {?>
                    <li class="page-item active">
                        <a href="?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                    </li>

                    <?php } else {?>

                    <li class="page-item">
                        <a href="?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                    </li>
                    <?php   }

                            }

                            ?>
                </ul>
            		</nav>
            	</div>
            </div>
        </div>
    </section>

</div>

				<?php require_once 'footer.php'; ?>