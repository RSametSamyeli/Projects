<?php 

include 'header.php';


?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Referans Ayarları</h4>
    <p class="mg-b-0">Bu bölümü istediğiniz gibi İş Ortağı, Portfolyo veya Referans olarak kullanabilirsiniz.</p>



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
form-group row row row row row row
col-md-10 / col-md-10 
-->


<div>
  <div align="right" class="col-md-12">
    <a href="referans-ekle.php"><button  class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Ekle</button></a>
  </div><br>
  <div class="table-responsive">
<table class="table table-striped">
      <thead class="thead-colored thead-purple">
        <tr class="headings">

          <th width="160" class="column-title">Referans Resim </th>
          <th class="column-title ">Referans Ad </th>
          <th class="column-title text-center">Referans Link </th>
          <th width="80" class="column-title"></th>
          <th width="80" class="column-title"></th>


        </tr>
      </thead>

      <tbody>

        <?php



                $sayfada = 10; // sayfada gösterilecek içerik miktarını belirtiyoruz.


                $sorgu=$db->prepare("select * from referans");
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


                if(isset($_POST['arama'])) {

                  $aranan=$_POST['aranan'];

                  $referanssor=$db->prepare("select * from referans where referans_ad LIKE '%$aranan%' order by referans_id DESC limit $limit,$sayfada");
                  $referanssor->execute();
                  $say=$referanssor->rowCount();


                } else {


                 $referanssor=$db->prepare("select * from referans order by referans_id DESC limit $limit,$sayfada");
                 $referanssor->execute();
                 $say=$referanssor->rowCount();


               }



               while($referanscek=$referanssor->fetch(PDO::FETCH_ASSOC)) {
                ?>


                <tr>

                  <td><img width="150" height="100" src="../../<?php echo $referanscek['referans_resimyol']; ?>"></td>
                  <td ><?php echo $referanscek['referans_ad']; ?></td>
                  <td class="text-center"><?php echo $referanscek['referans_link']; ?></td>

                  <td class="text-center"><a href="referans-duzenle.php?referans_id=<?php echo $referanscek['referans_id']; ?>"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>

                  <td class="text-center"><a href="../netting/islem.php?referanssil=ok&referans_id=<?php echo $referanscek['referans_id']; ?>&referans_resimyol=<?php echo $referanscek['referans_resimyol']; ?>"><button style="width:80px;" class="btn btn-danger btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

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

                    <a href="referans.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

                  </li>

                  <?php } else {?>


                  <li>

                    <a href="referans.php?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>

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