<?php 

include 'header.php';

//Belirli veriyi seçme işlemi
$kullanicisor=$db->prepare("SELECT * FROM kullanici order by kullanici_zaman desc");
$kullanicisor->execute(array());

?>




<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Kullanıcı Ayarları</h4>

<div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <div class="d-flex align-items-center justify-content-start">
              <i class="icon ion-ios-information alert-icon tx-24 mg-t-5 mg-xs-t-0"></i>
              <span><strong>Kullanıcı Hakkında!</strong><br> Sıralamada 1 numaranın gözükmemesinin sebebi yönetim paneli kullanıcısını da saydığı içindir.</span>
            </div><!-- d-flex -->
          </div>

    <p class="mg-b-0">

      <?php
      if ($_GET['sil']=='ok') {?> 

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

      <?php } elseif ($_GET['sil']=='no')  {?>

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
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="thead-colored thead-purple">
        <tr class="headings">

          <th>S.No</th>
          <th>Ad Soyad</th>
          <th>Telefon</th>
          <th>Mail Adresi</th>
          <th>Kayıt Tarihi</th>

          <th></th>
          <th></th>
        </tr>
      </thead>

      <?php 

      while ($kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC)) { $say++

      ?>
      <tr>
         <td width="20"><?php echo $say ?></td>
        <td><strong><?php echo $kullanicicek['kullanici_adsoyad']; ?></strong></td>
        <td><?php echo $kullanicicek['kullanici_gsm'] ?></td>
        <td><?php echo $kullanicicek['kullanici_mail'] ?></td>

         <?php 

         $zaman=explode(" ",$kullanicicek['kullanici_zaman']); ?> 

         <td><?php echo $zaman[0] ?></td>


        <td><center><a href="kullanici-duzenle.php?kullanici_id=<?php echo $kullanicicek['kullanici_id'];  ?>"><button class="btn btn-primary bd-1 btn-sm">Düzenle</button></a></center></td>
        <td><center><a href="../netting/islem.php?kullanici_id=<?php echo $kullanicicek['kullanici_id'] ?>&kullanicisil=ok"><button class="btn btn-danger btn-sm">Sil</button></a></center></td>

      </tr>

      <?php  } ?>


    </tbody>
  </table>

</div>

</div>

<!--Burada Bitecek-->



</div>
</div>


<?php include 'footer.php'; ?>