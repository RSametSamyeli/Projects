<?php session_start();
if (isset($_SESSION["mail"])) {
    include 'header.php';
    include 'left.php'; ?>
    <?php
    $hesap = $db->query("select * from uye where mail='{$_SESSION['mail']}'");
    if ($hesap->rowCount()) {
        $hesap = $hesap->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <div class="orta">
        <div class="ic">
            <h1><i class="fas fa-user"></i> Hesap Bilgileri</h1>
            <div class="hesap-bilgi">
                <h1> Hesap Güncelle</h1>
                <label for="bakiye">Bakiye </label>
                <input type="text" name="bakiye" value="<?php echo round($hesap['bakiye'], 2) ?> ₺" disabled>

                <label for="hesap-adsad">Ad Soyad <span id="adsad">* Bu alan boş bırakılamaz!</span></label>
                <input type="text" name="hesap-adsad" value="<?php echo $hesap['adsad'] ?>">

                <label for="e-posta">E-Posta <span id="posta">* Bu alan boş bırakılamaz!</span></label>
                <input type="text" name="e-posta" value="<?php echo $hesap['mail'] ?>">

                <label for="telefon">Telefon (<i>Tekrar girişte onay gerekecektir...</i> <span id="telefon">* Bu alan boş bırakılamaz!</span>)</label>
                <input type="text" name="telefon" id="tel" value="<?php echo $hesap['telefon'] ?>">
                <a href="#" name="uyeguncelle">Bilgileri Güncelle</a>
                <span id="islem2"></span>

            </div>
            <script>
                $(function (tel) {
                    $("#tel").mask("(999) 999-9999");
                    $("#tel").on("blur", function () {
                        var last = $(this).val().substr($(this).val().indexOf("-") + 1);
                        if (last.length == 5) {
                            var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
                            var lastfour = last.substr(1, 4);
                            var first = $(this).val().substr(0, 9);
                            $(this).val(first + move + '-' + lastfour);
                        }
                    });
                });
                $("a[name=uyeguncelle]").click(function (guncelle) {
                    guncelle.preventDefault();
                    var adsad = $("input[name=hesap-adsad]");
                    var posta = $("input[name=e-posta]");
                    var telefon =$("input[name=telefon]");
                    var islem2 = $("span#islem2");
                    if (adsad.val() == "") {
                        $("span#adsad").show();
                    } else if (posta.val() == "") {
                        $("span#posta").show();
                    } else if (telefon.val() == "") {
                        $("span#telefon").show();
                    }
                    else {
                        $.ajax({
                            type: "post",
                            url: "ajax.php",
                            data: {
                                "uyeguncelle": 1,
                                "uyead": adsad.val(),
                                "uyeposta": posta.val(),
                                "uyetel": telefon.val()
                            }, success: function (cevap) {
                                cevap=cevap.trim();

                                if (cevap==1) {
                                    alert(cevap);
                                    islem2.show();
                                    islem2.text("Bilgileriniz güncellendi, lütfen tekrar giriş yapınız...");
                                    setTimeout(function () {
                                        window.location.href = "cikis";
                                    }, 3000);

                                } else {
                                    islem2.show();
                                    islem2.text("Bir hata oluştu, lütfen iletişime geçiniz....");
                                }
                            }
                        });
                    }
                });
            </script>
            <div class="hesap-bilgi">
                <h1> Şifre Güncelle</h1>
                <label for="eskisifre">Eski Şifreniz <span id="1">* Lütfen eski şifrenizi giriniz!</span></label>
                <input type="password" name="eskisifre">
                <label for="yenisifre1">Yeni Şifre <span id="2">* Lütfen yeni şifrenizi giriniz!</span></label>
                <input type="password" name="yenisifre1">
                <label for="yenisifre2">Yeni Şifre (Tekrar) <span id="3">* Lütfen yeni şifrenizi tekrar giriniz!</span>
                    <span id="4">* Şifreler uyuşmuyor!</span></label>
                <input type="password" name="yenisifre2">
                <a href="#" name="sifreguncelle">Şifre Güncelle</a>
                <span id="islem"></span>
            </div>
        </div>
        <script>

            $("a[name=sifreguncelle]").click(function (sifreguncelle) {
                sifreguncelle.preventDefault();
                var eski = $("input[name=eskisifre]");
                var yeni = $("input[name=yenisifre1]");
                var yeni2 = $("input[name=yenisifre2]");
                var islem = $("span#islem");
                if (eski.val() == "") {
                    $("span#1").show();
                } else if (yeni.val() == "") {
                    $("span#2").show();
                } else if (yeni.val() != yeni2.val()) {
                    $("span#4").show();
                } else if (yeni2.val() == "") {
                    $("span#3").show();
                } else {
                    $.ajax({
                        type: "post",
                        url: "ajax.php",
                        data: {
                            "sifreguncelle": 1,
                            "eskisifre": eski.val(),
                            "yenisifre": yeni.val()
                        },
                        success: function (cevap) {
                            cevap = cevap.trim();
                            // alert(cevap);
                            if (cevap == 1) {
                                islem.show();
                                islem.text("Şifreniz değiştirildi, lütfen tekrar giriş yapınız...");
                                setTimeout(function () {
                                    window.location.href = "cikis";
                                }, 3000);

                            } else if (cevap == 0) {
                                islem.show();
                                islem.text("Eski şifreniz yanlış...");
                            }
                            else {
                                islem.show();
                                islem.text("Bir hata oluştu, lütfen iletişime geçiniz....");
                            }
                        }
                    })

                }

            });
        </script>
    </div>
    <?php include 'footer.php';
} else {
    header("location:/");
} ?>

