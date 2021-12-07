<?php 

include 'header.php';

if(isset($_POST['arama'])) {

  $aranan=$_POST['aranan'];

  $menusor=$db->prepare("select * from menu where menu_ad LIKE '%$aranan%' order by menu_id ASC limit 25");
  $menusor->execute();
  $say=$menusor->rowCount();

  
} else {


  $menusor=$db->prepare("select * from menu where menu_ust=:menu_ust order by menu_sira ASC limit 25");
  $menusor->execute(array(
    'menu_ust' => 0
    ));
  $say=$menusor->rowCount();


}
?>



<div class="br-mainpanel">
  <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
    <h4 class="tx-gray-800 mg-b-5 mg-t-10 mg-sm-t-0">Menü İşlemleri</h4>
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
  <a href="menu-ekle.php"><button  class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Ekle</button></a>
  </div><br>
  <div class="table-responsive">
<table class="table table-striped">
      <thead class="thead-colored thead-purple">
        <tr class="headings">

          <th class="column-title ">Menü Ad </th>

          <th class="column-title text-center">Menü Sıra </th>
          <th class="column-title text-center">Menü Durum </th>
          <th width="80" class="column-title"></th>
          <th width="80" class="column-title"></th>


        </tr>
      </thead>

      <tbody>

        <?php 



        while($menucek=$menusor->fetch(PDO::FETCH_ASSOC)) {

          $menu_id=$menucek['menu_id'];
          ?>



          <tr>

            <td ><?php echo $menucek['menu_ad']; ?></td>

            <td class="text-center"><?php echo $menucek['menu_sira']; ?></td>

            <td class="text-center"><?php 

              if ($menucek['menu_durum']=="1") {

               echo "AKTİF";
             } else {

              echo "PASİF";
            }

            ?></td>

            <td class="text-center"><a href="menu-duzenle.php?menu_id=<?php echo $menucek['menu_id']; ?>"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>

            <td class="text-center"><a href="../netting/islem.php?menusil=ok&menu_id=<?php echo $menucek['menu_id']; ?>"><button class="btn btn-danger btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

          </tr>

          <?php 
          $altmenusor=$db->prepare("select * from menu where menu_ust=:menu_id order by menu_sira");
          $altmenusor->execute(array(
            'menu_id' => $menu_id
            ));

          while($altmenucek=$altmenusor->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <tr>

              <td ><b>----</b> &nbsp;&nbsp;<?php echo $altmenucek['menu_ad']; ?></td>

              <td class="text-center"><?php echo $altmenucek['menu_sira']; ?></td>

              <td class="text-center"><?php 

                if ($altmenucek['menu_durum']=="1") {

                 echo "AKTİF";

               } else {

                echo "PASİF";
              }

              ?></td>

              <td class="text-center"><a href="menu-duzenle.php?menu_id=<?php echo $altmenucek['menu_id']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</button></a></td>

              <td class="text-center"><a href="../netting/islem.php?menusil=ok&menu_id=<?php echo $altmenucek['menu_id']; ?>"><button class="btn btn-danger btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i> Sil</button></a></td>

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