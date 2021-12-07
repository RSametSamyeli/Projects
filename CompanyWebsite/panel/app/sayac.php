<?php 

include 'header.php';

$sayacsor=$db->prepare("SELECT * FROM sayac order by sayac_sira ASC ");
$sayacsor->execute(array());
?>




<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Sayaç İşlemleri</h4>

<div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <div class="d-flex align-items-center justify-content-start">
              <i class="icon ion-ios-information alert-icon tx-24 mg-t-5 mg-xs-t-0"></i>
              <span><strong>Icon Hakkında!</strong><br> Icon eklemek veya değiştirmek için butonu tıklayıp yönlendirilen siteden istediğiniz icon'un sadece ismini yazarak işlem yapabilirsiniz.</span>
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

    <a href="sayac-ekle.php"><button  class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Ekle</button></a>
  </div><br>
  <div class="table-responsive">
<table class="table table-striped">
      <thead class="thead-colored thead-purple">
        <tr class="headings">

          <th class="column-title ">Sayac İsmi </th>
          <th class="column-title">Sayac Icon</th>
          <th class="column-title text-center">Sayac Sıra </th>
          <th class="column-title text-center">Sayac Durum </th>
          <th width="80" class="column-title"></th>
          <th width="80" class="column-title"></th>


        </tr>
      </thead>

      <tbody>

        <?php 



        while($sayaccek=$sayacsor->fetch(PDO::FETCH_ASSOC)) {

          $sayac_id=$sayaccek['sayac_id'];
          ?>



          <tr>

            <td ><?php echo $sayaccek['sayac_ad']; ?></td>

            <td ><?php echo $sayaccek['sayac_icon']; ?></td>

            <td class="text-center"><?php echo $sayaccek['sayac_sira']; ?></td>

            <td class="text-center"><?php 

              if ($sayaccek['sayac_durum']=="1") {

               echo "AKTİF";
             } else {

              echo "PASİF";
            }

            ?></td>

            <td class="text-center"><a href="sayac-duzenle.php?sayac_id=<?php echo $sayaccek['sayac_id']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>

            <td class="text-center"><a href="../netting/islem.php?sayacsil=ok&sayac_id=<?php echo $sayaccek['sayac_id']; ?>"><button class="btn btn-danger btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

          </tr>

          <?php 
          $altsayacsor=$db->prepare("select * from sayac where sayac_ust=:sayac_id order by sayac_sira");
          $altsayacsor->execute(array(
            'sayac_id' => $sayac_id
            ));

          while($altsayaccek=$altsayacsor->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <tr>

              <td ><b>----</b> &nbsp;&nbsp;<?php echo $altsayaccek['sayac_ad']; ?></td>

              <td class="text-center"><?php echo $altsayaccek['sayac_sira']; ?></td>

              <td class="text-center"><?php 

                if ($altsayaccek['sayac_durum']=="1") {

                 echo "AKTİF";

               } else {

                echo "PASİF";
              }

              ?></td>

              <td class="text-center"><a href="sayac-duzenle.php?sayac_id=<?php echo $altsayaccek['sayac_id']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>

              <td class="text-center"><a href="../netting/islem.php?sayacsil=ok&sayac_id=<?php echo $altsayaccek['sayac_id']; ?>"><button class="btn btn-danger btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

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