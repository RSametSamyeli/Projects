<?php session_start();
if (isset($_SESSION["mail"])){
    include 'header.php';
    include 'left.php'; ?>
    <div class="orta">
        <div class="ic">
            <div class="satinal">
                <h1 style="margin-bottom:10px;"><i class="fas fa-shopping-cart"></i> Yeni İşlem Satın Al</h1>
				   <span class="islemsonuc"></span>
                <div class="sec">
                    <select class="kat">
                        <?php
                        $kat = $db->query("select * from kategori order by adi desc");
                        if ($kat->rowCount()) {
                            foreach ($kat as $kategori) {
                                echo "<option id='{$kategori['id']}'>" . $kategori['adi'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <select id="servisler"></select>
                    <div class="inputs">
                        <textarea style="overflow:hidden;resize:none;" readonly rows="10" id="aciklama"></textarea>
                        <input type="text" name="link" placeholder="Link">
                        <input type="text" name="adet" placeholder="Adet" pattern="[0-9]+">
                        <input type="text" name="fiyat" placeholder="0.00 ₺" disabled>
                        <a href="#" id="al" name="al">Satın Al</a>
                        <img id="ver" src="resimler/load.gif">
                     
                    </div>
                </div>
            </div>
            <div class="duyur">
                <h1><i class="fas fa-bullhorn"></i> Duyurular</h1>
                <div class="duyuric">
                    <?php
                    $cek=$db->query("select * from duyuru order by id desc limit 10");
                    if($cek->rowCount()){
                        foreach($cek as $geldi){
                            $tar=strtotime($geldi['tarih']);
                            $tar=date("d-m-Y",$tar);
                            ?>
                    <span>
                        <h2><?php echo $geldi['baslik']; ?></h2>
                        <p><?php echo $geldi['icerik']; ?></p>
                        <span id="tarih"><?php echo $tar; ?></span>
                    </span>
                    <?php
                        }
                    }
                    ?>


                 </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var ilk = $("select.kat option:first").attr('id');
            $.ajax({
                type: "post",
                url: "ajax.php",
                data: {"kategori": ilk},
                success: function (cevap) {
                    $("select#servisler").html(cevap);
                    var acik = $("select#servisler option:first").attr('id');
                    $.ajax({
                        type: "post",
                        url: "ajax.php",
                        data: {"aciklama": acik},
                        success: function (cevap) {
                            cevap = cevap.trim();
                            if (cevap == "") {
                                $("#aciklama").slideUp();
                            } else {
                                $("#aciklama").slideDown();
                                $("#aciklama").html(cevap.trim());
                            }
                        }
                    });
                }
            });

        });
    </script>
	<a href="https://api.whatsapp.com/send?phone=902423265810" target="_blank" class="whatsapp">
    <img src="wp.png">
    <h3>WhatsApp İletişim</h3>
</a>
    <?php include 'footer.php';
} else { include 'ayar.php';
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title>Graptik - Türkiye'nin En Kaliteli Sosyal Medya Marketi!</title>

    <meta name="description" content="İnstagram, Youtube, Twitter, Facebook aktif satışlar burada, en uygun sosyal medya hizmetleri!">
    <meta name="keywords"content="instagram takipçi,instagram beğeni,instagram oto beğeni,instagram izlenme,facebook beğeni,facebook takipçi,youtube izlenme,youtube abone,twitter retweet,twitter takipçi">


    <meta property="og:title" content="Graptik - Türkiye'nin En Kaliteli Sosyal Medya Marketi!" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://graptik.biz/" />
    <meta property="og:image" content="resimler/sosyal.png" />
    <meta property="og:site_name" content="Graptik" />
    <meta property="og:description" content="İnstagram, Youtube, Twitter, Facebook aktif satışlar burada, en uygun sosyal medya hizmetleri!" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@Graptikbiz" />
    <meta name="twitter:domain" content="<?php echo $sitelink; ?>" />
    <meta name="twitter:title" content="Graptik - Türkiye'nin En Kaliteli Sosyal Medya Marketi!" />
    <meta name="twitter:description" content="İnstagram, Youtube, Twitter, Facebook aktif satışlar burada, en uygun sosyal medya hizmetleri!" />
    <meta name="twitter:image" content="resimler/sosyal.png" />
    <meta name="content-language" content="tr" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link href="https://fonts.googleapis.com/css?family=Lobster&amp;subset=cyrillic,cyrillic-ext,latin-ext,vietnamese" rel="stylesheet">
	<link href="<?php echo $sitelink; ?>stil/fa/css/fontawesome-all.css" rel="stylesheet">
    <link href="<?php echo $sitelink; ?>stil/giris.css" rel="stylesheet">
    <script src="<?php echo $sitelink; ?>stil/jquery.js" type="text/javascript"></script>
    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="icon" href="<?php echo $sitelink; ?>resimler/ikon.png" type="image/x-icon"/>

</head>
<body>

<div class="giris-ust">
    <a id="logo" href="<?php echo $sitelink; ?>"><img src="resimler/logo_3.png"></a>
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
<div class="giris-orta">
    <div class="giris">
        <div class="slogan">
            <h1>Türkiye'nin En Büyük <b>Sosyal Medya Pazarına</b> Hoşgeldin!</h1>
            <p>Burada harika fırsatlar seni bekliyor, Facebook, Twitter, İnstagram ve Youtube platformları için
                sunduğumuz Takipçi, Beğeni, İzlenme, Görüntüleme, Abone, Sayfa Beğenisi, Dislike, Otomatik Beğeni,
                Otomatik İzlenme hizmetleri ile isterseniz kişisel kullanımlarla sosyal medya hesaplarınızın imajını
                değiştirebilir, isterseniz de bayimiz olarak kendi müşterilerinize satışlar
                gerçekleştirebilirsiniz. </p>
            <img src="resimler/a.png">
        </div>
        <div class="login-box">
            <div class="ic">
                <form method="post" action="#">
                    <div class="login">
                        <p id="g">Giriş Yap</p>
                        <label><i class="fas fa-user"></i> E-Posta</label>
                        <input type="text" name="kad" id="kad" placeholder="">
                        <label><i class="fas fa-key"></i> Şifre</label>
                        <input name="sif" id="sif" type="password">
                        <a href="#" type="submit" name="giris" id="giris">Giriş Yap</a>
                        <p><a href="kaydol">Bayi Ol</a></p>
                        <a class="but" href=""> Şifremi unuttum</a>
                    </div>
                    <div class="sifirla">
                        <label><i class="fas fa-user"></i> E-Posta <span
                                    id="mailbos">*Bu alan boş bırakılamaz</span></label>
                        <input type="text" name="mail" id="mail" placeholder="Mail adresinizi giriniz">
                        <a href="#" name="sifirla" id="sifirla">Şifre Sıfırla</a>
                    </div>
                </form>
                <div class="onay">
                    <label>Telefonunuza Gelen Onay Kodunu Giriniz</label>
                    <input type="text" name="onaykod" id="onaykod" placeholder="Onay Kodunuz">
                    <a href="#" style="width:50%; float:left;" name="onayla" id="onayla">Onayla</a>
                    <a href="#" style="width:50%; float:right;" name="tekrar" id="tekrar">Tekrar Gönder</a>
                </div>
                <div class="tekrar">
                    <input type="tel"  maxlength="11" name="tekrartel" id="tekrartel" placeholder="(555)-555-55-55">
                    <a href="#" name="tekrargonder" id="tekrargonder">Gönder</a>
                </div>
                <span id="girdi"></span>
            </div>
        </div>
    </div>
</div>

<div class="hizmetler" id="hizmetler">
    <div class="hizmet">
        <h2><i class="fab fa-instagram"></i> İnstagram Hizmetleri</h2>
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
    <div class="hizmet">
        <h2><i class="fab fa-youtube"></i> Youtube Hizmetleri</h2>
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
    <div class="hizmet">
        <h2><i class="fab fa-twitter"></i> Twitter Hizmetleri</h2>
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
    <div class="hizmet">
        <h2><i class="fab fa-Facebook"></i> Facebook Hizmetleri</h2>
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
<h2 id="mus">Bizi müşterilerimize sorun :)</h2>
<div class="yorumlar">

    <div class="musbox">
        <p>İnstagram sayfamda reklam yapıyorum, hal böyle olunca sürekli olarak İnstagram Beğeni ve Takipçi satın almam
            gerekiyor, Graptik bu zamana kadar bu konuda <b>beni hiç üzmedi</b> diyebilirim. En ufak bir sorunda dahi anında yardımcı
            olmaları, beni sürekli olarak satın almaya teşfik ediyor :) Teşekkürler Graptik!</p>
        <span><i class="far fa-comment-alt"></i> Buse E.</span>
    </div>
    <div class="musbox">
        <p>Müşterilerime aktif olarak sosyal medya hizmetleri (genel olarak oto beğeni ve oto izlenme) sağlamaktayım.
            Bunun yanı sıra talebe göre Twitter ve Facebook satışları da gerçekleştiriyorum. Graptik, sosyal medya
            konusunda uygun ve ucuz çözümler sunarak, <b>para kazanmama olanak</b> sağlıyor. Eğer sosyal medya üzerinden
            para kazanmak istiyorsanız, bayi olmayı kesinlikle denemelisiniz. .</p>
        <span><i class="far fa-comment-alt"></i> Emre Karadağ</span>
    </div>
    <div class="musbox">
        <p>Kurmuş olduğumuz web sitenin sosyal medya hesapları için sürekli olarak buradayım. Sosyal medya hizmetleri
            sağlayanlar arasında en sağlamı Graptik desem yeridir sanırım. Gerek <b>kurumsal olmaları, gerek hızlı</b> çözüm
            üretmeleri olsun çok ilgilisiniz gerçekten. Eğer aklınızda bir soru işareti varsa, ben kefilim; Graptik.biz
            sosyal medya hizmetleri konusunda 1 numara.</p>
        <span><i class="far fa-comment-alt"></i> Ahmet Parlak</span>
    </div>

    <div class="musbox">
        <p>Giyim / Ayakkabı sektöründe İnstagram üzerinde satışlar gerçekleştirmekteyim. İnstagram'da, daha çok
            kullanıcıya erişmek için beğeni ve video görüntüleme satın almak çok etkili bir çözüm, bu sayede keşfet ve
            önerilenler kısmında daha çok geri dönüşüm sağlayabiliyorsunuz. Bu zamana kadar farklı firmalarla
            çalıştığım, <b>ödediğim binlerce TL paraya acıyorum</b>. Keşke daha önce Graptik ekibiyle tanışsaydım... </p>
        <span><i class="far fa-comment-alt"></i> Uğur Elmacı</span>
    </div>
</div>
	<a href="https://api.whatsapp.com/send?phone=902423265810" target="_blank" class="whatsapp">
    <img src="wp.png">
    <h3>WhatsApp İletişim</h3>
</a>
<?php include 'footerout.php'; ?>

<script>
    $("a#giris").click(function (giris) {
        giris.preventDefault();
        var kad = $("#kad").val();
        var sif = $("#sif").val();
        $.ajax({
            type: "post",
            url: "ajax.php",
            data: {
                "login": 1,
                "kad": kad,
                "sif": sif
            },
            success: function (giris) {
				giris = giris.trim();
                // alert(giris);
                if (giris == 1) {
                    window.location.reload();
                }
                if (giris == 2) {
                    $("form").slideUp();
                    setTimeout(function () {
                        $('.onay').slideDown();
                    }, 500);

                    $("#onayla").click(function (onayla) {
                        onayla.preventDefault();
                        var onaykodu = $("#onaykod").val();
                        $.ajax({
                            type: "post",
                            url: "ajax.php",
                            data: {"onaykodu": onaykodu, "mail": kad},
                            success: function (cevap) {
                                cevap = cevap.trim();
                                if (cevap == 0) {
                                    $("#girdi").slideDown();
                                    $("#girdi").html("Onay kodu yanlış!");
                                    setTimeout(function () {
                                        $('#girdi').slideUp();
                                    }, 1500);
                                } else {
                                    $("#girdi").slideDown();
                                    $("#girdi").html("Onaylandı, yönlendiriliyorsunuz...");
                                    setTimeout(function () {
                                        $('#girdi').slideUp();
                                        window.location.reload();
                                    }, 1500);
                                }

                            }
                        });
                    });

                    $("#tekrar").click(function (tekrar) {
                        tekrar.preventDefault();
                        $(".onay").slideUp();
                        setTimeout(function () {
                            $('.tekrar').slideDown();
                        }, 500);
                        $("#tekrargonder").click(function () {
                            var tekrartel = $("#tekrartel").val();
                            $.ajax({

                                type: "post",
                                url: "ajax.php",
                                data: {
                                    "giristekraronay": 1,
                                    "tekrartel": tekrartel,
                                    "mail": kad
                                },
                                success: function (cevap) {
                                    cevap = cevap.trim();
                                    // alert(cevap);
                                    if (cevap == 1) {
                                        $("#girdi").slideDown();
                                        $("#girdi").html("Onay kodu Gönderildi");
                                        setTimeout(function () {
                                            $('.tekrar').slideUp();
                                            $('#girdi').slideUp();
                                            $(".onay").slideDown();
                                        }, 1500);
                                    }
                                }

                            })
                        });
                    });

                }
                if (giris == 0) {
                    $("#girdi").slideDown();
                    $("#girdi").html("Hatalı Giriş");
                    $("#girdi").css("background", "#f44840");
                    setTimeout(function () {
                        $('#girdi').slideUp();
                    }, 1500);
                }
            }
        });
    });
    $("a.but").click(function (yenile) {
        yenile.preventDefault();
        var yenile = $(".sifirla");
        var login = $(".login");
        yenile.show();
        login.slideUp();
    });
    $("#sifirla").click(function (sifirla) {
        sifirla.preventDefault();
        var mail = $("input[name=mail]");
        if (mail.val() == "") {
            $(".sifirla label span").show();
        } else {
            $.ajax({
                type: "post",
                url: "ajax.php",
                data: {"sifsifirla":1, "mail": mail.val()},
                success: function (cevap) {
                     cevap = cevap.trim();
                   // alert(cevap);
                    if (cevap == 0) {
                        alert("Bu mail sistemde kayıtlı değil!");
                    }
                    if (cevap == 1) {
                        $("#girdi").show();
                        $("#girdi").text("Şifre sıfırlama bağlantısı gönderildi.");
                        setTimeout(function () {
                            $(".sifirla").slideUp();
                            $("#girdi").hide();
                            $(".login").slideDown();

                        }, 2000)
                    }
                }
            })
        }
    });
    
</script>
<script src="stil/telefon.js"></script>
<?php

} ?>

