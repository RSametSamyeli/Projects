<?php 

include 'header.php';

//Belirli veriyi seçme işlemi
$kategorisor=$db->prepare("SELECT * FROM kategori order by kategori_sira ASC");
$kategorisor->execute();


?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Kategori Listeleme</h4>
    <p class="mg-b-0">Bu bölüm de istediğiniz gibi menü veya sayfa oluşturabilirsiniz.</p>



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
  <a href="kategori-ekle.php"><button  class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Ekle</button></a>
  </div><br>
  <div class="table-responsive">
<table class="table table-striped">
              <thead class="thead-colored thead-purple">
                <tr>
                  <th>S.No</th>
                  <th>Kategori Ad</th>
                  <th class="column-title text-center">Kategori Sira</th>
                  <th class="column-title text-center">Kategori Durum</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>

              <tbody>

                <?php 

                $say=0;

                while($kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC)) { $say++?>


                <tr>
                 <td width="20"><?php echo $say ?></td>
                 <td><?php echo $kategoricek['kategori_ad'] ?></td>
                 <td class="column-title text-center"><?php echo $kategoricek['kategori_sira'] ?></td>

                 <td><center><?php 

                  if ($kategoricek['kategori_durum']==1) {?>

                  <button class="btn btn-success btn-sm">Aktif</button>

                  <!--

                  success -> yeşil
                  warning -> turuncu
                  danger -> kırmızı
                  default -> beyaz
                  primary -> mavi buton

                  btn-sm -> ufak buton 

                -->

                <?php } else {?>

                <button class="btn btn-danger btn-sm">Pasif</button>


                <?php } ?>
              </center>


            </td>


            <td class="text-center"><center><a href="kategori-duzenle.php?kategori_id=<?php echo $kategoricek['kategori_id']; ?>"><button class="btn btn-primary btn-sm">Düzenle</button></a></center></td>
            <td class="text-center"><center><a href="../netting/islem.php?kategori_id=<?php echo $kategoricek['kategori_id']; ?>&kategorisil=ok"><button class="btn btn-danger btn-sm">Sil</button></a></center></td>
          </tr>



          <?php  }

          ?>


        </tbody>
      </table>
      </div>

    </div>

<!--Burada Bitecek-->



</div>
</div>


<?php include 'footer.php'; ?>