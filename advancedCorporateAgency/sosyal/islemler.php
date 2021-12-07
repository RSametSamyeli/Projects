<?php session_start(); if(isset($_SESSION["mail"])){ include 'header.php'; include 'left.php'; $i=0;?>

    </div>
    <div class="orta">
        <div class="ic">
<!--            <div class="bil">-->
<!--                <h1 class="bilgilen">Bilgilendirme    <span>x</span></h1>-->
<!--                <div class="bilgi">-->
<!--                    --><?php
//                    $bilgi=$db->query("select * from bilgi");
//                    if($bilgi->rowCount()){
//                        foreach($bilgi as $bilgiler){
//                            echo "<p><b>".$bilgiler['baslik'].":</b> ".$bilgiler['bilgi']."</p>";
//                        }
//                    }
//                    ?>
<!--                </div>-->
            <h1><i class="fas fa-list-ul"></i> Satın Alma Geçmişi</h1>
            <div class="islemler">
                <ul id="islembas">
                    <li>İD</li>
                    <li>Tarih</li>
                    <li>Adı</li>
                    <li>Miktar</li>
                    <li>Ücret</li>
                    <li>Link</li>
                    <li>Durum</li>
                </ul>
        <div class="onson" style="display:contents">
                    <?php  
                     $islemler=$db->query("select * from islemler where uye_id='{$_SESSION['uye_id']}' order by id desc limit 10");
                     if($islemler->rowCount()){

                         foreach($islemler as $getir){
                             $i++;
                             $durum=$getir['durum'];
                             if($durum==1){
                                 $durum="Tamamlandı";
                             }else if($durum==2){
                                 $durum="Sırada";
                             }else if($durum==3){
                                 $durum="İşleme Alındı";
                             }else if($durum==4){
                                 $durum="İptal Edildi";
                             }

                             echo"<ul id=\"islemgel\">
                                  <li>".$getir['id']."</li>
                                  <li>".$getir['tarih']."</li>
                                  <li>".$getir['tanim']."</li>
                                  <li>".$getir['miktar']."</li>
                                  <li>".$getir['fiyat']."₺</li>
                                  <li><p>".$getir['link']."</p></li>
                                  <li>".$durum."</li>
                                  </ul>";
                         }
//                         echo $i;
                     }else {
                     echo "<p style='padding:10px;'>Hiç işlem satın almamışsınız...</p>";
                     ?>

                     <?php
                     }
                    ?>


</div>
            </div>
            <?php if($i>9){ ?> <span id="onceki">Önceki</span> <?php } ?>
            <span id="sonraki" style="display:none;float:right">Sonraki</span>
            <script>

                var onceki=10;
                $('#onceki').click(function () {
                    $("#sonraki").show();
                    $.ajax({
                        type:"post",
                        url:"ajax.php",
                        data:{"onceki":onceki},
                        success:function (cevap) {
                            if(cevap.trim()!=""){
                           $(".onson").html(cevap);
                           onceki+=10;
                            }else {
                                $('#onceki').hide();
                            }



                        }
                    });
                });

                $('#sonraki').click(function () {
                    onceki-=20;
                    $.ajax({
                        type:"post",
                        url:"ajax.php",
                        data:{"sonraki":onceki},
                        success:function (cevap) {
                            $(".onson").html(cevap);
                            onceki+=10;
                            $("#onceki").show();
                            // alert(onceki);
                                if(onceki==10){
                                    $('#sonraki').hide();
                                }


                        }
                    });
                });

            </script>
        </div>
    </div>
    <?php include 'footer.php'; }else {header("location:/");}?>

