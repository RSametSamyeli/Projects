<?php 

include 'header.php';

$metinsor=$db->prepare("SELECT * FROM metin order by metin_sira ASC ");
$metinsor->execute(array());
?>





<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Slider Altı İşlemleri</h4>

<div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <div class="d-flex align-items-center justify-content-start">
              <i class="icon ion-ios-information alert-icon tx-24 mg-t-5 mg-xs-t-0"></i>
              <span><strong>Slider Altı Hakkında!</strong><br> Maksimum 3 tane olması önerilir</span>
            </div><!-- d-flex -->
          </div>



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

    <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank"><button  class="btn btn-warning "><i class="fa fa-circle" aria-hidden="true"></i> Icon Arşivi</button></a>

    <a href="metin-ekle.php"><button  class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Ekle</button></a>
  </div><br>
  <div class="table-responsive">
<table class="table table-striped">
      <thead class="thead-colored thead-purple">
        <tr class="headings">

                      <th class="column-title ">Metin İsmi </th>
                      <th class="column-title">Metin Icon</th>
                      <th class="column-title text-center">Metin Sıra </th>
                      <th class="column-title text-center">Metin Durum </th>
                      <th width="80" class="column-title"></th>
                      <th width="80" class="column-title"></th>


                    </tr>
                  </thead>

                  <tbody>

                    <?php 


                    
                    while($metincek=$metinsor->fetch(PDO::FETCH_ASSOC)) {

                      $metin_id=$metincek['metin_id'];
                      ?>



                      <tr>

                        <td ><?php echo $metincek['metin_ad']; ?></td>

                        <td ><?php echo $metincek['metin_icon']; ?></td>

                        <td class="text-center"><?php echo $metincek['metin_sira']; ?></td>

                        <td class="text-center"><?php 

                          if ($metincek['metin_durum']=="1") {

                           echo "AKTİF";
                         } else {

                          echo "PASİF";
                        }

                        ?></td>
                        
                        <td class="text-center"><a href="metin-duzenle.php?metin_id=<?php echo $metincek['metin_id']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>
                        
                        <td class="text-center"><a href="../netting/islem.php?metinsil=ok&metin_id=<?php echo $metincek['metin_id']; ?>"><button class="btn btn-danger btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

                      </tr>

                      <?php 
                      $altmetinsor=$db->prepare("select * from metin where metin_ust=:metin_id order by metin_sira");
                      $altmetinsor->execute(array(
                        'metin_id' => $metin_id
                        ));
                      
                      while($altmetincek=$altmetinsor->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                        <tr>

                          <td ><b>----</b> &nbsp;&nbsp;<?php echo $altmetincek['metin_ad']; ?></td>

                          <td class="text-center"><?php echo $altmetincek['metin_sira']; ?></td>

                          <td class="text-center"><?php 

                            if ($altmetincek['metin_durum']=="1") {

                             echo "AKTİF";

                           } else {

                            echo "PASİF";
                          }

                          ?></td>

                          <td class="text-center"><a href="metin-duzenle.php?metin_id=<?php echo $altmetincek['metin_id']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>

                          <td class="text-center"><a href="../netting/islem.php?metinsil=ok&metin_id=<?php echo $altmetincek['metin_id']; ?>"><button class="btn btn-danger btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

                        </tr>



                        <?php } } ?>

                      </tbody>
                    </table>
                  </div>

    </div>

    <!--Burada Bitecek-->



  </div>
</div>


<?php include 'footer.php'; ?>