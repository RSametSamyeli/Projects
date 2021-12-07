<?php session_start();
if (isset($_SESSION["mail"])) {
    include 'header.php';
    include 'left.php'; ?>
    <div class="orta">
        <div class="ic dar">
            <h1><i class="far fa-credit-card"></i> Kredi Kartı / Banka Kartı İle Yükle</h1>
            <div class="kredikarti">
                <div class="kart">
                    <form action="odeme" method="post" id="odee" onsubmit="return false">
                        <label for="tutar">Yüklemek istediğiniz tutar
                            <span> *Minimum: 20TL (sadece rakam giriniz...)</span></label>
                        <input name="tutar" type="number">
                        <button name="ode" type="submit">İlerle</button>
                    </form>
                </div>
                <p>Ödeme yapmak istediğiniz miktarı giriniz.</p>
                <p>Kredi kartı, banka kartı, sanal kart ile ödeme yapabilirsiniz.</p>
                <p>Minimum ödeme miktarı 20₺'dir.</p>
                <p>Ödemeleriniz anlık olarak bakiyenize eklenir.</p>
            </div>
			<script>
			$("input[name=tutar]").keydown(function(){
				var a=$(this);
				if(a.val()!=""){
				$("form#odee").removeAttr("onsubmit");
				}
			});
			</script>

    </div>
    </div>


    <script>
        $("#odemebildir").click(function (odeme) {
            odeme.preventDefault();
            var banka=$(".odeme select option:selected").val();
            var gonderen=$("input[name=gonderenad]").val();
            var miktar=$("input[name=miktar]").val();
            var ekler=$("input[name=ekler]").val();

            if(!$("input[name=gonderenad]").val() || !$("input[name=miktar]").val() ){
                alert("Lütfen tüm alanları kontrol ediniz...");
            }else {
                // alert(gonderen+" "+miktar);
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{
                        "banka":banka,
                        "gonderen":gonderen,
                        "miktar":miktar,
                        "ekler":ekler
                    },
                    success:function (cevap) {
                        // alert(cevap);
                        if(cevap.trim()==1){
                            $(".odeme #tamam").slideDown();
                            setTimeout(function () {
                                $(".odeme #tamam").slideUp()
                            }, 3000);
                        }
                    }
                });
            }

        });
        $("input[name=miktar]").keydown(function(e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    </script>
    <?php include 'footer.php';
} else {
    header("location:".$sitelink."");
} ?>

