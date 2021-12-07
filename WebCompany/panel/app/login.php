<!DOCTYPE html>
<html lang="tr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@sametsamyeli2">
    <meta name="twitter:creator" content="@sametsamyeli2">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Samyeli CMS">
    <meta name="twitter:description" content=" Samyeli Profesyonel Yönetim Sistemi">
    <meta name="twitter:image" content="http://bracketplus.themepixels.me/img/bracketplus-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://sametsamyeli.com">
    <meta property="og:title" content="Samyeli Profesyonel Yönetim Sistemi">
    <meta property="og:description" content="Tamamen Profesyonel Olarak Hazırlanmış Samyeli Yönetim Sistemi">

    <!-- Meta -->
    <meta name="description" content="Tamamen Profesyonel Olarak Hazırlanmış Samyeli Yönetim Sistemi">
    <meta name="author" content="Samet Samyeli">

    <title>Samyeli Yönetim Paneli Giriş Kapısı</title>

    <!-- vendor css -->
    <link href="../lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../lib/Ionicons/css/ionicons.css" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="../css/bracket.css">
  </head>

  <body>

    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">[</span> samyeli <span class="tx-normal">]</span></div>
        <div class="tx-center mg-b-60">Yönetim Paneli Ekranına Hoşgeldiniz Aşağıdan Giriş İşlemi Yapabilirsiniz</div>

                  <form action="../netting/islem.php" method="POST">
            <div>
              <input type="text" name="kullanici_ad" class="form-control" placeholder="Kullanıcı Adınız" required="" />
            </div>
            <div>
              <input type="password" name="kullanici_password" class="form-control" placeholder="Şifreniz" required="" />
            </div>
            <div><br>
            <button type="submit" class="btn btn-info btn-block" type="submit" name="loggin" > Giriş Yap</button>
              
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">

             <?php 

             if ($_GET['durum']=="no") {
             
             echo "Kullanıcı Bulunamadı...";

             } elseif ($_GET['durum']=="exit") {
             
             echo "Başarıyla Çıkış Yaptınız.";

             }

             ?>
               
              </p>

              <div class="clearfix"></div>
              <br />
            </div>
          </form><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="../lib/jquery/jquery.js"></script>
    <script src="../lib/popper.js/popper.js"></script>
    <script src="../lib/bootstrap/bootstrap.js"></script>

  </body>
</html>
