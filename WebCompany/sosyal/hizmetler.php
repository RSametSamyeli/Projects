<!DOCTYPE html>
<?php if (isset($_GET['q']) && $_GET['q'] != null){
include "ayar.php";
$sayfa = $_GET['q'];
$bak = $db->query("select * from icerik where seo='$sayfa'");
if ($bak->rowCount()){
$bak = $bak->fetch(PDO::FETCH_ASSOC);

?>
<html>
<head>

    <title><?php echo $bak['baslik']; ?> - Graptik</title>
    <meta name="description" content="<?php echo $bak['aciklama']; ?>"/>
    <meta name="keywords" content="<?php echo $bak['etiket']; ?>">
    <meta property="og:title" content="<?php echo $bak['baslik']; ?> - Graptik"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="<?php echo $sitelink; ?>"/>
    <meta property="og:image" content="resimler/sosyal.png"/>
    <meta property="og:site_name" content="Graptik"/>
    <meta property="og:description" content="<?php echo $bak['aciklama']; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@Graptikbiz"/>
    <meta name="twitter:domain" content="<?php echo $sitelink; ?>"/>
    <meta name="twitter:title" content="<?php echo $bak['baslik']; ?> - Graptik"/>
    <meta name="twitter:description" content="<?php echo $bak['aciklama']; ?>"/>
    <meta name="twitter:image" content="resimler/sosyal.png"/>

    <link rel="icon" href="<?php echo $sitelink; ?>resimler/ikon.png" type="image/x-icon"/>
    <link href="<?php echo $sitelink ?>stil/fa/css/fontawesome-all.css" rel="stylesheet">
    <link href="<?php echo $sitelink ?>stil/giris.css" rel="stylesheet">
    <script src="<?php echo $sitelink ?>stil/jquery.js" type="text/javascript"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="content-language" content="tr"/>
    <meta charset="utf-8">
    <base href="<?php echo $sitelink; ?>"/>

</head>
<body>
<div class="giris-ust">
    <a id="logo" href="<?php echo $sitelink ?>"><img src="resimler/logo_3.png"></a>
    <ul>
        <li><a href="<?php echo $sitelink; ?>">Anasayfa</a></li>
        <li><a href="<?php echo $sitelink; ?>hizmetler">Hizmetlerimiz</a></li>
        <li><a href="<?php echo $sitelink; ?>fiyatlar">Fiyatlar</a></li>
        <li><a href="<?php echo $sitelink; ?>kaydol">Kaydol</a></li>
    </ul>
    <div class="resmenu">
        <span>Menü &#9776; </span>
    </div>
</div>
<div class="orta">
    <div class="hiz">
        <div class="elem">
            <img src="resimler/<?php echo $bak['resim']; ?>" width="100%" alt="<?php echo $bak['aciklama']; ?>"
                 title="<?php echo $bak['baslik']; ?>">
            <span id="yol"><a href="<?php echo $sitelink; ?>">Anasayfa</a> <a> > </a> <a
                        href="<?php echo $sitelink; ?>hizmetler">Hizmetler</a> <a> > </a> <a><?php echo $bak['baslik']; ?></a></span>
            <h1><?php echo $bak['baslik']; ?></h1>
            <div class="yayin">
                <?php
                echo $bak['icerik'];

                ?>
            </div>
            <?php
            $kat = $db->query("select * from kategori where adi='{$bak['kategori']}'");
            if ($kat->rowCount()) {
            foreach ($kat

            as $kategori) {

            ?>
            <h2><?php echo $bak['kategori']; ?> Fiyatları</h2>
            <div class="hizmettab">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr class="bas">
                        <td>SERVİS ADI</td>
                        <td align="center"><?php if ($kategori['id'] == 4 or $kategori['id'] == 5) {
                                echo "1 Aylık";
                            } else {
                                echo "1000 ADET FİYATI";
                            } ?></td>
                    </tr>


                    <?php
                    $cek = $db->query("select * from servis where kategori_id='{$kategori['id']}'");
                    if ($cek->rowCount()) {
                        foreach ($cek as $gelen) {
                            ?>
                            <tr>
                                <td><?php echo $gelen['adi']; ?></td>
                                <td align="center"><?php echo $gelen['fiyati']; ?> ₺</td>

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
    </div>
</div>
</div>
<?php include 'footerout.php';
}
}else {
include 'ayar.php';
?>

<html>
<head>
    <meta charset="utf8">
    <title>Hizmetlerimiz - Graptik</title>


    <meta name="description"
          content="Aradığın sosyal medya hizmeti burada! En uygun fiyat garantisiyle kurumsal sosyal medya çözümleri için tıkla!">
    <meta name="keywords" content="sosyal medya hizmet,instagram,twitter,facebook,youtube">
    <meta name="author" content="Graptik">
    <link rel="icon" href="<?php echo $sitelink; ?>resimler/ikon.png" type="image/x-icon"/>
    <meta name="content-language" content="tr"/>

    <meta property="og:title" content="Hizmetlerimiz - Graptik"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://graptik.biz/"/>
    <meta property="og:image" content="<?php echo $sitelink; ?>resimler/sosyal.png"/>
    <meta property="og:site_name" content="Graptik"/>
    <meta property="og:description"
          content="Aradığın sosyal medya hizmeti burada! En uygun fiyat garantisiyle kurumsal sosyal medya çözümleri için tıkla!"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@Graptikbiz"/>
    <meta name="twitter:domain" content="https://graptik.biz/"/>
    <meta name="twitter:title" content="Hizmetlerimiz - Graptik"/>
    <meta name="twitter:description"
          content="Aradığın sosyal medya hizmeti burada! En uygun fiyat garantisiyle kurumsal sosyal medya çözümleri için tıkla!"/>
    <meta name="twitter:image" content="<?php echo $sitelink; ?>resimler/sosyal.png"/>


    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="<?php echo $sitelink; ?>stil/fa/css/fontawesome-all.css" rel="stylesheet">
    <link href="<?php echo $sitelink; ?>stil/giris.css" rel="stylesheet">
    <script src="<?php echo $sitelink; ?>stil/jquery.js" type="text/javascript"></script>

</head>
<body>
<div class="giris-ust">
    <a id="logo" href="<?php echo $sitelink; ?>"><img src="resimler/logo_3.png"></a>
    <ul>
        <li><a href="<?php echo $sitelink; ?>">Anasayfa</a></li>
        <li><a href="<?php echo $sitelink; ?>hizmetler">Hizmetlerimiz</a></li>
        <li><a href="<?php echo $sitelink; ?>fiyatlar">Fiyatlar</a></li>
        <li><a href="<?php echo $sitelink; ?>kaydol">Kaydol</a></li>
    </ul>
    <div class="resmenu">
        <span>Menü &#9776; </span>
    </div>
</div>

<div class="orta">
    <div class="hizmetres">

        <div class="ekler">
            <i class="fab fa-instagram" id="facebook"></i>
            <div class="ekleric">
                <h2>İnstagram Çözümleri</h2>
                <p>Türkiye'de sosyal medya platformları arasında İnstagram için bir çok sosyal hizmetin öncülüğünü
                    gerçekleştirdik. İnstagram takipçi, Oto beğeni, Oto izlenme gibi konularda özel yazılımlarımızı
                    geliştirerek müşterilerimize her geçen gün yeni teknolojiler ile İnstagram hizmetleri sunmaya devam
                    etmekteyiz.</p>
            </div>
            <div class="ekleralt">
                <?php
                $getir = $db->query("select * from icerik where baslik like '%instagram%'");
                if ($getir->rowCount()) {
                    foreach ($getir as $get) {
                        ?>
                        <a title="<?php echo $get['baslik'] ?>"
                           href="hizmetler/<?php echo $get['seo'] ?>.html"><?php echo $get['baslik'] ?></a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div class="ekler">
            <i class="fab fa-facebook-f" id="facebook"></i>
            <div class="ekleric">
                <h2>Facebook Çözümleri</h2>
                <p>Facebook, oldukça eski fakat bir o kadar da kullanıcı sayısı konusunda birinciliği bırakmayan bir
                    sosyal platform. Hal böyle olunca Graptik ekibi olarak Facebook beğeni, görüntüleme vb. hizmetler
                    hazırladık. Hizmet satın alarak gönderilerinizi öne çıkarmak, Facebook üzerindeki markanızı veya
                    kişisel hesabınızı yükseltmek, bu sayede daha çok geri dönüşüm kazanmak için bu servisleri
                    kullanabilirsiniz.</p>
            </div>
            <div class="ekleralt">
                <?php
                $getir = $db->query("select * from icerik where baslik like '%facebook%'");
                if ($getir->rowCount()) {
                    foreach ($getir as $get) {
                        ?>
                        <a title="<?php echo $get['baslik'] ?>"
                           href="hizmetler/<?php echo $get['seo'] ?>.html"><?php echo $get['baslik'] ?></a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div class="ekler">
            <i class="fab fa-twitter" id="facebook"></i>
            <div class="ekleric">
                <h2>Twitter Çözümleri</h2>
                <p>Twitter günümüzün vazgeçilmez sosyal medya aracı, çok kolay bir şekilde insanlara sesizini
                    duyurabiliyorsunuz. Fakat sesinizi duyurmak için sadece hesap oluşturmak yeterli değil, takipçi
                    sayınızın yüksek olması, gönderilerinizin beğenilmesi ve paylaşılması gerekiyor. Bu işlemleri
                    kolaylaştıracak Twitter hizmetleri sizler için hazır.</p>
            </div>
            <div class="ekleralt">
                <?php
                $getir = $db->query("select * from icerik where baslik like '%twitter%'");
                if ($getir->rowCount()) {
                    foreach ($getir as $get) {
                        ?>
                        <a title="<?php echo $get['baslik'] ?>"
                           href="hizmetler/<?php echo $get['seo'] ?>.html"><?php echo $get['baslik'] ?></a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div class="ekler">
            <i class="fab fa-youtube-square" id="facebook"></i>
            <div class="ekleric">
                <h2>Youtube Çözümleri</h2>
                <p>Son dönemin yükselen yıldızı Youtube üzerinde videolarınızın trende çıkması, önerilen videolarda
                    gözükmesi için izlenme, beğeni, abone servislerimiz sizler için hazır. Üstelik Youtube'da para
                    kazanmak için yeni gelen Youtube kuralı 1000 abone ve 4000 saat izlenme problemini de sunduğumuz
                    Youtube hizmetleri ile çözebilirsiniz.</p>
            </div>
            <div class="ekleralt">
                <?php
                $getir = $db->query("select * from icerik where baslik like '%youtube%'");
                if ($getir->rowCount()) {
                    foreach ($getir as $get) {
                        ?>
                        <a title="<?php echo $get['baslik'] ?>"
                           href="hizmetler/<?php echo $get['seo'] ?>.html"><?php echo $get['baslik'] ?></a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>


    </div>
</div>


<?php
include 'footerout.php';
}
?>