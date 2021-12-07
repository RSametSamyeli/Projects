<?php session_start();
include '../ayar.php';
?>

<html>
<head>
    <title>Yönetim Paneli</title>
    <link href="../stil/fa/css/fontawesome-all.css" rel="stylesheet">
    <script src="../stil/jquery.js" type="text/javascript"></script>
</head>
<style>
    body {
        margin:0;
        padding:0;
        background:#ddd;
        color: #6e6e6e;
    }
    * {font-family: Arial,sans-serif}
    .login-box {
        width:300px;
        height:440px;
        background:#fff;
        border-radius:10px;
        box-shadow:0 0 3px #919191;
        margin:100px auto;
        padding:50px;
    }
    .ic {
        float:left;
        width:100%;
    }
    .ic img {
        float:left;
        width:100%;
    }
    .ic label {
        float:left;
        margin-top:50px;
    }
    .ic input {
        border:none;
        border-bottom:1px solid #ddd;
        width:100%;
        padding:10px;
        margin-top:10px;
        float:left;
    }

    .ic a {
        margin-top:30px;
        color:#5f9fdd;
        float:left;
        width:100%;
        text-align: center;
        transition:all 0.3s;
    }
    .ic a:hover {
        opacity: 0.3;
    }
    #sonuc{
        float:left;
        width:100%;
        text-align: center;
    }


#girdi {
    float:left;
    width:100%;
    margin-top:10px;
    background: #2ac022;
    color:#fff;
    padding:10px 0;
    text-align: center;
    display:none;
}
a#giris{
    float:left;
    width:100%;
    text-align: center;
    text-decoration:none;
    display:block;
    padding:10px 0;
    background: #3a5471;
    color: #eee;
    border-radius:3px;
    box-shadow:0 0 3px #ddd;
}
    .ic h1 {
        width:100%;
        text-align: center;
        color:#3a5471;
        text-shadow: 0 0 1px #2f2f2f;
        font-size:250%;
    }
</style>
<body>

<div class="login-box">
    <form method="post" action="#">
    <div class="ic">
        <h1>Yönetim Paneli</h1>
        <label><i class="fas fa-user"></i> Kullanıcı Adı</label>
        <input type="text" name="kad" id="kad" placeholder="">
        <label><i class="fas fa-key"></i> Şifre</label>
        <input name="sif"  id="sif" type="password">
        <a href="#" name="giris" id="giris">Giriş Yap</a>
        <span id="girdi"></span>
    </form>
    </div>

<script>
    $("a#giris").click(function(giris){
        var kad=$("#kad").val();
        var sif=$("#sif").val();
        $.ajax({
            type:"post",
            url:"ajax.php",
            data:{"kad":kad,"sif":sif},
            success:function (giris) {
                //alert(giris);
                if(giris==1){
                        window.location.href="index.php";      
                }
                else{
                    $("#girdi").slideDown();
                    $("#girdi").html("Hatalı Giriş");
                    $("#girdi").css("background","#f44840");
                }
            }
        });
    });
</script>
</div>
</body>
</html>
