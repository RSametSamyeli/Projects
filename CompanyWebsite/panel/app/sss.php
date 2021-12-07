<?php 
include 'header.php';

?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Sık Sorulan Sorular İşlemleri</h4>
    <p class="mg-b-0">Bu bölüm de sık sorulan sorularınızı ekleyebilir, düzenleyebilir veya silebilirsiniz.</p>



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



  </div>

  <div class="br-pagebody">
    <div class="br-section-wrapper">



<!--Buraya Yapıştırılacak
form-group row row row row row row row row row
col-md-10 / col-md-10 
-->


<div>
  <div align="right" class="col-md-12">
  <a href="sss-ekle.php"><button  class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Ekle</button></a>
  </div><br>
  <div class="table-responsive">
<table class="table table-striped">
      <thead class="thead-colored thead-purple">
        <tr class="headings">

          <th  width="700" class="column-title ">Sık Sorulan Başlık </th>

          <th></th>
          <th></th>



        </tr>
      </thead>

      <tbody>

        <?php

                     $sayfada = 25; // sayfada gösterilecek içerik miktarını belirtiyoruz.


                     $sorgu=$db->prepare("select * from sss");
                     $sorgu->execute();
                     $toplam_sss=$sorgu->rowCount();

                     $toplam_sayfa = ceil($toplam_sss / $sayfada);

                  // eğer sayfa girilmemişse 1 varsayalım.
                     $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;

          // eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
                     if($sayfa < 1) $sayfa = 1; 

        // toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
                     if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa; 

                     $limit = ($sayfa - 1) * $sayfada;



                     if(isset($_POST['arama'])) {

                      $aranan=$_POST['aranan'];

                      $ssssor=$db->prepare("select * from sss where sss_ad LIKE ? order by sss_id ASC limit $limit,$sayfada");
                      $ssssor->execute(array("%$aranan%"));
                      $say=$ssssor->rowCount();


                    } else {


                     $ssssor=$db->prepare("select * from sss order by sss_id DESC limit $limit,$sayfada");
                     $ssssor->execute();
                     $say=$ssssor->rowCount();


                   }



                   while($ssscek=$ssssor->fetch(PDO::FETCH_ASSOC)) {
                    ?>


                    <tr>

                      <td ><?php echo $ssscek['sss_ad']; ?></td>


                      <td width="20"  class="text-center"><a href="sss-duzenle.php?sss_id=<?php echo $ssscek['sss_id']; ?>"><button  class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>

                      <td width="20" class="text-center"><a href="../netting/islem.php?ssssil=ok&sss_id=<?php echo $ssscek['sss_id']; ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

                    </tr>

                    <?php } ?>

                  </tbody>
                </table>

                <div align="right" class="col-md-12">
                  <ul class="pagination">

                    <?php

                    $s=0;

                    while ($s < $toplam_sayfa) {

                      $s++; ?>

                      <?php 

                      if ($s==$sayfa) {?>

                      <li class="active">

                        <a href="sss.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

                      </li>

                      <?php } else {?>


                      <li>

                        <a href="sss.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

                      </li>

                      <?php   }

                    }

                    ?>

                  </ul>
                </div>
              </div>

            </div>


            <!--Burada Bitecek-->




          </div>
        </div>



        <?php include 'footer.php'; ?>