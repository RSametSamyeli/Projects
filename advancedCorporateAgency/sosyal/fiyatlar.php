<!DOCTYPE html>
<?php     include "ayar.php"; ?>
<html>
<head>

    <title>Graptik - Sosyal Medya Market Fiyatları</title>
    <link href="<?php echo $sitelink;?>stil/fa/css/fontawesome-all.css" rel="stylesheet">
    <link href="<?php echo $sitelink;?>stil/giris.css" rel="stylesheet">
    <script src="<?php echo $sitelink;?>stil/jquery.js" type="text/javascript"></script>
    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="İnstagram takipçi, beğeni, otobeğeni, fiyatları Youtube izlenme - abone fiyatları, facebook takipçi, sayfa beğenisi fiyatları, twitter takipçi, retweet, favori fiyatları">
    <meta name="keywords" content="instagram takipçi fiyatları,instagram beğeni fiyatları,instagram oto beğeni fiyatları,instagram izlenme fiyatları,facebook beğeni fiyatları,facebook takipçi fiyatları,youtube izlenme fiyatları,youtube abone fiyatları,twitter retweet,twitter takipçi">
    <meta name="author" content="Graptik">
    <link rel="icon" href="<?php echo $sitelink;?>resimler/ikon.png" type="image/x-icon"/>
    <meta property="og:title" content="Hizmetlerimiz - Graptik"/>
    <meta property="og:image" content="<?php echo $sitelink; ?>resimler/sosyal.png">
    <meta property="og:description" content="Aradığın sosyal medya hizmeti burada! En uygun fiyat garantisiyle kurumsal sosyal medya çözümleri için tıkla!">
    <meta property="og:site_name" content="Graptik">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta charset="utf8">
    <meta name="content-language" content="tr" />
</head>
<body>
<div class="giris-ust">
    <a id="logo" href="<?php echo $sitelink;?>"><img src="resimler/logo_3.png"></a>
    <ul>
        <li><a href="<?php echo $sitelink;?>">Anasayfa</a></li>
        <li><a href="<?php echo $sitelink;?>hizmetler">Hizmetlerimiz</a></li>
        <li><a href="<?php echo $sitelink;?>fiyatlar">Fiyatlar</a></li>
        <li><a href="<?php echo $sitelink;?>kaydol">Kaydol</a></li>
    </ul>
    <div class="resmenu">
        <span>Menü &#9776; </span>
    </div>
</div>

<div class="orta">
<div class="fiyatlar">
    <table cellpadding="0" cellspacing="0">
    <tr class="bas">
        <td align="center">İD</td>
        <td>ADI</td>
        <td align="center">1000 ADET FİYATI</td>
        <td align="center">MİN</td>
        <td align="center">MAX</td>
        <td>AÇIKLAMA</td>
    </tr>
    <?php

    $kat=$db->query("select * from kategori");
    if($kat->rowCount()){
        foreach($kat as $kategori){
            ?>
            <tr>
                <td style="background:#e5e5e5; font-weight:bold; color:#666;padding:10px 10px;" colspan="6"><?php echo $kategori['adi']?></td>
            </tr>
            <?php
            $cek=$db->query("select * from servis where kategori_id='{$kategori['id']}'");
            if($cek->rowCount()){
                foreach ($cek as $gelen){
                    ?>
                    <tr>
                        <td align="center"><?php echo $gelen['id'];?></td>
                        <td><?php echo $gelen['adi'];?></td>
                        <td align="center"><?php echo $gelen['fiyati'];?> ₺</td>
                        <td align="center"><?php echo $gelen['mini'];?></td>
                        <td align="center"><?php echo $gelen['maks'];?></td>
                        <td width="30%"><?php echo nl2br($gelen['aciklama']);?></td>
                    </tr>
                    <?php
                }
            }
        }
    }
            ?>
    </table>
</div>
</div>
<?php include'footerout.php'; ?>