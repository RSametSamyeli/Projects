<?php session_start(); include 'ayar.php'; ?>

<html>
<head>
    <title>Kaydol - Graptik</title>
    <link href="stil/fa/css/fontawesome-all.css" rel="stylesheet">
    <script src="stil/jquery.js" type="text/javascript"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        background: #eee;
        color: #6e6e6e;
    }

    * {
        font-family: Arial, sans-serif
    }

    .login-box {
        width: 350px;
        background: #f5f5f5;
        border-radius: 3px;
        box-shadow: 0 0 5px #ccc;
        margin: 50px auto;
        color:#444;
        padding: 40px 40px 10px;
        display: flow-root;
        height: auto;
    }

    .ic {
        float: left;
        width: 100%;
    }

    .ic img {
        float: left;
        width: 70%;
        margin-left:15%;
    }

    .ic label {
        float: left;
        margin-top: 50px;
        font-weight:bold;
        color: #555;
    }

    .ic input {
        border: none;
        border-bottom: 1px solid #ddd;
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        float: left;
    }

    .ic a {
        margin-top: 30px;
        color: #5f9fdd;
        float: left;
        width: 100%;
        text-align: center;
        transition: all 0.3s;
    }

    .ic a:hover {
        opacity: 0.3;
    }

    #sonuc {
        float: left;
        width: 100%;
        text-align: center;
    }

    form {
        float: left;
    }

    #girdi, #girdi2 {
        float: left;
        width: 100%;
        margin-top: 10px;
        background: #2ac022;
        color: #fff;
        padding: 10px 0;
        text-align: center;
        display: none;
    }
    #girdi {
        margin-top:-5px;
    }

    a#kaydol {
        float: left;
        width: 100%;
        text-align: center;
        text-decoration: none;
        display: block;
        padding: 10px 0;
        background: #6bb1ff;
        color: #afe2ff;
        border-radius: 3px;
        box-shadow: 0 0 3px #ddd;
    }

    @media only screen and (max-width: 479px) {
        .login-box {
            float: left;
            position: relative;
            width: 80%;
            margin: 0;
            padding: 10% 10% 10%;
            min-height: 500px;
            border-radius: 0;
            background: #fff;
            box-shadow: 0 0 5px #ccc;
            display: flow-root;
            height: auto;
        }
    }

    .onay {
        display: none;
    }

    .tekrar {
        display: none;
    }
    .telacik p:first-child{
        margin-top:20px;
    }
    .telacik p {
        float:left;
        width:100%;
        color: #555;
        font-size:14px;
        margin:0;
        margin-top:5px;
        text-align: justify;
        padding:0;
    }
    .telacik{
        width:100%;
        float:left;
        margin-bottom:-10px;
    }
   .onay,.tekrar {
       padding:10px 0 20px;
       float:left;
       width:100%;
   }
</style>
<body>

<div class="login-box">
    <div class="ic">
        <img src="resimler/logo_3.png" width="200">
        <form method="post">
            <label><i class="fas fa-user"></i> Ad Soyad</label>
            <input type="text" name="ad" id="ad" placeholder="">

            <label><i class="fas fa-envelope-open"></i></i> E-Posta</label>
            <input type="text" name="kad" id="kad" placeholder="">

            <label><i class="fas fa-key"></i> Şifre</label>
            <input name="sif" id="sif" type="password">

            <label><i class="fas fa-phone-square"></i> Telefon </label>
            <input name="tel" maxlength="11" id="tel" type="tel" placeholder="(555)-555-55-55">
            <div class="telacik">
            <p>✔ Telefonunuza onay kodu gönderilecektir.</p>
            <p>✔ Başında 0 olmadan telefon numaranızı giriniz.</p>
            </div>
            <a href="#" name="kaydol" id="kaydol">Kaydol</a>
            <p><a href="<?php echo $sitelink; ?>">Giriş Yap</a></p>

        </form>

        <div class="onay">
            <label>Telefonunuza Gelen Onay Kodunu Giriniz</label>
            <input type="text" name="onaykod" id="onaykod" placeholder="Onay Kodunuz">
            <a href="#" name="onayla" id="onayla">Onayla</a>

        </div>
        <div class="tekrar">
            <label>Tekrar Gönder</label>
            <input type="tel" maxlength="11" name="tekrar" id="tekrar"  placeholder="(555)-555-55-55">
            <a href="#" name="tekrargonder" id="tekrargonder">Gönder</a>

        </div>
        <span id="girdi"></span>
        <span id="girdi2"></span>
    </div>
    <script>

        function validateEmail(email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if (!emailReg.test(email)) {
                return 0;
            } else {
                return 1;
            }
        }

        var onaytekrar = 0;
        $("#kaydol").click(function (kaydol) {
            kaydol.preventDefault();
            if ($("#ad").val() != "" && $("#kad").val() != "" && $("#sif").val() != "" && $("#tel").val() != "") {
                var ad, kad, sif, tel;
                ad = $("#ad").val();
                kad = $("#kad").val();
                sif = $("#sif").val();
                tel = $("#tel").val();
                if (validateEmail(kad) == 1) {
                    // alert (1);

                    $.ajax({
                        type: "post",
                        url: "ajax.php",
                        data: {
                            "ad": ad,
                            "kad": kad.toLowerCase(),
                            "sif": sif,
                            "tel": tel
                        },
                        success: function (cevap) {
                            cevap = cevap.trim();
                            // alert(tel);
                            // alert(cevap);
                            if (cevap == 1) {
                                $(".ic form").slideUp();
                                $('input[name=onaykod]').attr('id', tel);
                                setTimeout(function () {
                                    $("div.onay").slideDown();
                                }, 500);

                                $("#onayla").click(function (onayla) {
                                    onayla.preventDefault();
                                    var onaykodu = $("input[name=onaykod]").val();
                                    var onaytelefon = $('input[name=onaykod]').attr('id');
                                    // alert(onaykodu);
                                    $.ajax({
                                        type: "post",
                                        url: "ajax.php",
                                        data: {"onaykodu": onaykodu, "onaytelefon": onaytelefon},
                                        success: function (cevap) {
                                            cevap = cevap.trim();
                                            // alert(cevap);
                                            if (cevap == 1) {
                                                $("#girdi").text("Hesabınız onaylandı! Yönlendiriliyorsunuz...");
                                                $("#girdi").slideDown();
                                                setTimeout(function () {
                                                    $("#girdi").slideUp();
                                                    window.location.href = "/";
                                                }, 5000);
                                            }
                                            if (cevap == 0) {
                                                $("#girdi").text("Lütfen kodu kontrol ediniz!");
                                                $("#girdi").slideDown();
                                                setTimeout(function () {
                                                    $("#girdi").slideUp();
                                                }, 2000);
                                                onaytekrar++;
                                                if (onaytekrar >= 3) {
                                                    onaytekrar=0;
                                                    $("div.onay").slideUp();
                                                    $("#girdi").text("Lütfen telefon numaranızı kontrol ediniz!");
                                                    $("#girdi").slideDown();
                                                    setTimeout(function () {
                                                        $("#girdi").slideUp();
                                                    }, 2000);
                                                    setTimeout(function () {
                                                        $(".tekrar").slideDown();
                                                    }, 2000);

                                                    $("#tekrar").val(tel);
                                                    $("#tekrargonder").click(function (tekrargonder) {
                                                        tekrargonder.preventDefault();
                                                        var tekrartel = $("#tekrar").val();
                                                        $.ajax({
                                                            type: "post",
                                                            url: "ajax.php",
                                                            data: {
                                                                "tekrar": 1,
                                                                "telefon": tekrartel,
                                                                "mail": kad
                                                            },
                                                            success: function (cevap) {
                                                                $(".tekrar").slideUp();
                                                                setTimeout(function () {
                                                                    $("div.onay").slideDown();
                                                                }, 500);
                                                                $("#girdi").css("background", "#c0bd1f");
                                                                $("#girdi").text("Yeni kod gönderildi!");
                                                                $("#girdi").slideDown();
                                                                setTimeout(function () {
                                                                    $("#girdi").slideUp();
                                                                }, 2000);
                                                            }
                                                        })
                                                    })
                                                }
                                            }
                                        }
                                    });
                                });

                            }
                            if (cevap == 2) {
                                $("#girdi").css("background", "#c0bd1f");
                                $("#girdi").text("Bu mail adresi zaten kayıtlı!");
                                $("#girdi").slideDown();
                                setTimeout(function () {
                                    $("#girdi").slideUp();
                                }, 2000);
                            }
                            if (cevap == 3) {
                                $("#girdi").css("background", "#c0bd1f");
                                $("#girdi").text("Bu telefon zaten kayıtlı!");
                                $("#girdi").slideDown();
                                setTimeout(function () {
                                    $("#girdi").slideUp();
                                }, 2000);
                            }
                            if (cevap == 4) {
                                // alert(2314);
                                $("#girdi").css("background", "#c0bd1f");
                                $("#girdi").text("Bu mail adresi zaten kayıtlı!");
                                $("#girdi").slideDown();
                                setTimeout(function () {
                                    $("#girdi").slideUp();
                                }, 2000);
                                $("#girdi2").css("background", "#c0bd1f");
                                $("#girdi2").text("Bu telefon zaten kayıtlı!");
                                $("#girdi2").slideDown();
                                setTimeout(function () {
                                    $("#girdi2").slideUp();
                                }, 2000);


                            }
                        }
                    });

                } else {
                    $("#girdi").css("background", "#f44840");
                    $("#girdi").text("Mail adresini kontrol ediniz...");
                    $("#girdi").slideDown();
                    setTimeout(function () {
                        $("#girdi").slideUp();
                    }, 3000);
                }
            } else {
                $("#girdi").css("background", "#f44840");
                $("#girdi").text("Lütfen tüm alanları kontrol ediniz...");
                $("#girdi").slideDown();
                setTimeout(function () {
                    $("#girdi").slideUp();
                }, 2000);
            }
        });
        //
        // $(function () {
        //     $("#tel").mask("(999) 999-9999");
        //     $("#tel").on("blur", function () {
        //         var last = $(this).val().substr($(this).val().indexOf("-") + 1);
        //         if (last.length == 5) {
        //             var move = $(this).val().substr($(this).val().indexOf("-") + 1, 1);
        //             var lastfour = last.substr(1, 4);
        //             var first = $(this).val().substr(0, 9);
        //             $(this).val(first + move + '-' + lastfour);
        //         }
        //     });
        // });

        // $("#tel").numara();


    </script>
</div>
</body>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118453103-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-118453103-1');
</script>

<script src="stil/telefon.js"></script>
</html>
