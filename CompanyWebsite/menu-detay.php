<?php 
ob_start();
session_start();
require_once 'panel/netting/baglan.php';
require_once 'panel/app/ponki.php';

$menusor=$db->prepare("SELECT * from menu where menu_id=:menu_id");
$menusor->execute(array(
    'menu_id' => $_GET['menu_id']
));

$a=$menucek['menu_ad'];

$menucek=$menusor->fetch(PDO::FETCH_ASSOC);

$title=$menucek['menu_ad'];

$ozet=substr($menucek['menu_detay'], 2,280);

$anahtar=$menucek['menu_keyword'];


include 'header.php'; 



?>
<div role="main" class="main">
	<section class="page-header mb-0">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 text-md-left">
					<h1 class="font-weight-bold"><?php echo $menucek['menu_ad']; ?></h1>
				</div>
				<div class="col-md-6">
					<ul class="breadcrumb justify-content-md-end">
						<li><a href="index.php">Anasayfa</a></li>
						<li class="active"><?php echo $menucek['menu_ad']; ?></li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-lg-12 order-1 mb-5 mb-md-0 mt-5">
				<article class="blog-post mb-4">

					<p><?php echo $menucek['menu_detay']; ?></p>


						<footer class="blog-post-footer border border-left-0 border-right-0 py-4 mt-5">
							<div class="row justify-content-between align-items-center">
								<div class="col-12 col-sm-auto mb-3 mb-sm-0 mb-md-3 mb-lg-0">
									<ul class="list-inline mb-0">
                            <?php 

                            $etiketler=explode(', ',$menucek['menu_keyword']); 



                            foreach ($etiketler as $etiketbas) {?>
										<li class="list-inline-item"><a href="#" class="badge badge-light badge-sm badge-pill px-3 py-2"><?php echo $etiketbas; ?></a></li>
										<?php }         
										?>
									</ul>
								</div>
							</div>
						</footer>
					</article>
				</div>
			</div>
		</div>

	</div>


	<?php require_once 'footer.php'; ?>