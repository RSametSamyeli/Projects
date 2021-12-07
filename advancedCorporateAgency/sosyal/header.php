<?php if($_SESSION['mail']!=""){include 'ayar.php'; ?>
<html>
<head>
    <title>Graptik - Türkiye'nin En Kaliteli Sosyal Medya Marketi!</title>
    <link rel="stylesheet" type="text/css" href="stil/stil.css"/>
    <script src="stil/jquery.js" type="text/javascript"></script>
    <script src="stil/telefon.js    " type="text/javascript"></script>
    <link href="stil/fa/css/fontawesome-all.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="İnstagram, Youtube, Twitter, Facebook aktif satışlar burada, en uygun sosyal medya hizmetleri!">
    <meta name="keywords" content="instagram takipçi,instagram beğeni,instagram oto beğeni,instagram izlenme,facebook beğeni,facebook takipçi,youtube izlenme,youtube abone,twitter retweet,twitter takipçi">
    <meta name="author" content="Graptik">
    <link rel="icon" href="resimler/ikon.png" type="image/x-icon"/>
    <meta name="robots" content="noindex,nofollow">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<div class="respon">
    <span>&#9776; Menü</span>
</div>
<?php }else {
    header("location:/");
}?>