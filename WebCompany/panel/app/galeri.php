<?php 

include 'header.php';

?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Galeri İşlemleri</h4>
    <p class="mg-b-0">Bu bölüm de çoklu resim yükleyebilir veya silebilirsiniz.</p>



    <p class="mg-b-0">

      <?php
      if ($_GET['durum']=='ok') {?> 

      <div class="alert alert-success alert-bordered pd-y-20 animated bounce" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="icon ion-ios-checkmark alert-icon tx-52 mg-r-20 tx-success"></i>
          <div class="mg-t-20 mg-sm-t-0">
            <h5 class="mg-b-2 tx-success">Başarılı!</h5>
            <p class="mg-b-0 tx-gray">İsteğiniz başarılı bir şekilde kayıt oldu.</p>
          </div>
        </div>
      </div>

      <?php } elseif ($_GET['durum']=='no')  {?>

      <div class="alert alert-danger alert-bordered pd-y-20 animated bounce" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="icon ion-ios-close alert-icon tx-52 tx-danger mg-r-20"></i>
          <div class="mg-t-20 mg-sm-t-0">
            <h5 class="mg-b-2 tx-danger">Hata!</h5>
            <p class="mg-b-0 tx-gray">Ne yazık ki, işleminiz yapılırken bir hata gerçekleşti ve kayıt edilmedi.</p>
          </div>
        </div>
      </div>

      <?php } ?>

    </p>

    <div style="display: inline-block;
    float: right;
    margin-top: -40px;"><form  action="../netting/islem.php" method="POST" enctype="multipart/form-data">
    <div align="right" class="col-md-12">
      <button type="submit" name="galerisil"  class="btn btn-danger "><i class="fa fa-trash" aria-hidden="true"></i> Seçilenleri Sil</button>
      <a class="btn btn-success" href="galeri-yukle.php"><i class="fa fa-plus" aria-hidden="true"></i> Galeri Yükle</a>
    </div>
  </div>
</div>

<div class="br-pagebody">
  <div class="br-section-wrapper">



<!--Buraya Yapıştırılacak
form-group row row row row row row
col-md-10 / col-md-10 
-->


<div> 

 <div>
  <?php

                $sayfada = 25; // sayfada gösterilecek içerik miktarını belirtiyoruz.


                $sorgu=$db->prepare("select * from galeri");
                $sorgu->execute();
                $toplam_galeri=$sorgu->rowCount();

                $toplam_sayfa = ceil($toplam_galeri / $sayfada);

                  // eğer sayfa girilmemişse 1 varsayalım.
                $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

          // eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
                if($sayfa < 1) $sayfa = 1; 

        // toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
                if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

                $limit = ($sayfa - 1) * $sayfada;

                $galerisor=$db->prepare("select * from galeri order by galeri_id DESC limit $limit,$sayfada");
                $galerisor->execute();

                while($galericek=$galerisor->fetch(PDO::FETCH_ASSOC)) { ?>



                <div class="col-md-55">
                 <label>
                  <div class="image view view-first" style="max-height: 117px;">
                    <img style="width: 100%; display: block;" src="../../<?php echo $galericek['galeri_resimyol']; ?>" alt="image" />
                    <div class="mask">
                      <p><?php echo $galericek['galeri_ad']; ?> <?php echo $galericek['galeri_id']; ?></p>
                      <div class="tools tools-bottom">

                        <!--<a href="#"><i class="fa fa-times"></i></a>-->

                      </div>

                    </div>

                  </div>

                  <?php  array("$galerisec"); ?>
                  

                  <input type="checkbox" name="galerisec[]"  value="<?php echo $galericek['galeri_id']; ?>" > Seç
                </label>
                

              </div>

              <?php } ?>

              <div align="right" class="col-md-12">
                <ul class="pagination">

                  <?php

                  $s=0;

                  while ($s < $toplam_sayfa) {

                    $s++; ?>

                    <?php 

                    if ($s==$sayfa) {?>

                    <li class="active">

                      <a href="galeri.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

                    </li>

                    <?php } else {?>


                    <li>

                      <a href="galeri.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

                    </li>

                    <?php   }

                  }

                  ?>

                </ul>
              </div>
            </form></div>

            <!--Burada Bitecek-->



          </div>
        </div>


        <?php include 'footer.php'; ?>