<?php if(isset($_GET['codex'])){ include 'ayar.php'; date_default_timezone_set('Europe/Istanbul');
    $veri=$_GET['codex'];
    $bak=$db->query("select * from sifresifirla where baglanti='$veri' and durum='0'");
    if($bak->rowCount()){
        $bak=$bak->fetch(PDO::FETCH_ASSOC);
        $saati=$bak['tarih'];
        $saati=strtotime($saati);
        $saati=$saati+60*30;
        $suan=date("Y-m-d H:i:s");
        $suan=strtotime($suan);
        if($saati>=$suan){
            ?>
<html>
<head>
    <title>Graptik - Şifre Sıfırla</title>
    <meta name="robots" content="noindex,nofollow">
    <script src="stil/jquery.js"></script>
    <meta charset="utf8">
</head>
<style>
    body {
        margin:0;
        padding:0;
        font-size:100%;
        background:#ddd;
        font-family: Arial, sans-serif;
        color:#555;
    }
    .ortala {
        width:20%;
        margin:50px auto;
    }
    .kutu {
        width:90%;
        padding:5%;
        background:#eee;
        box-shadow: 0 0 3px #999;
        height:auto;
        float:left;
    }
    .kutu input{
        width:100%;
        padding:3% 2%;
        float:left;
        border:1px solid #ddd;
        margin-top:10px;
    }
    .kutu label {
        float:left;
        width:100%;
        margin-top:20px;
    }
    .kutu a {
        float:left;
        width:100%;
        padding:10px 0;
        text-align: center;
        text-decoration:none;
        color:#fff;
        font-weight: bold;
        background:#3b9c55;
        margin-top:15px;

    }
    .kutu span {
        display:none;
        color:red;
        font-size:80%;

    }
    .tamam{
        float:left;
        text-align: center;
        width:100%;
        color:green !important;
        margin-top:10px;
    }
    @media only screen and (max-width: 479px){
        .ortala {
            width:96%;
            float:left;
            margin:2%;
        }

    }

</style>
<body>
<div class="ortala">
    <div class="kutu">
        <label for="yenisif">Yeni Şifreniz <span id="1">* Bu alan boş bırakılamaz!</span></label>
        <input type="password" min="8" id="<?php echo $veri ?>"name="yenisif">
        <label for="yenisif2">Yeni Şifreniz Tekrar <span  id="2">* Şifreler uyuşmuyor!</span></label>
        <input type="password" name="yenisif2">
        <a href="#" id="yenile">Şifreyi Güncelle</a>
        <span id="3" class="tamam">Şifreniz Güncellendi, Yönlendiriliyorsunuz...</span>
    </div>
    <script>
        var sifre=$("input[name=yenisif]");
        var codex=$("input[name=yenisif]").attr('id');
        var sifre2=$("input[name=yenisif2]");
        var span1=$("#1");
        var span2=$("#2");
        var span3=$("#3");
        $("#yenile").click(function (sifirla) {
            sifirla.preventDefault();
            if(sifre.val()==""){
                span1.show();
            }else if (sifre2.val()==""){
                span2.show();
            }else{
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{"sifreyenileme":1,"yenisifre":sifre.val(),"codex":codex},
                    success:function (cevap) {
                     span3.show();
                     setTimeout(function () {
                         window.location.href="/";
                     },3000)
                    }
                })
            }
        })
    </script>
</div>
</body>
</html>
        <?php
        }else  {header("location:/");}
    } else {header("location:/");}
}else{ header("location:/");}


?>