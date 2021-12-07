<?php session_start(); if(isset($_SESSION['yonetim'])){require_once '../ayar.php'; require_once 'header.php';?>
    <body><?php require_once'left.php';?>
    <div class="orta">

        <div class="uyeoto">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td >Üye İD</td>
                    <td>Kullanıcı adı</td>
                    <td>Son Fotoğraf</td>
                    <td>Başlangıç</td>
                    <td>Bitiş</td>
                    <td>Sil</td>
                </tr>
                <?php
                $tarih=date("Y-m-d H:i:s");
                $cek=$db->query("select * from oto where bitis>='$tarih'");
                if($cek->rowCount()){
                    foreach($cek as $gel){
                        ?>
                        <tr>
                            <td><?php echo $gel['uye_id']?></td>
                            <td><a href="<?php echo $gel['link']?>" target="_blank"><?php echo $gel['link']?></a></td>
                            <td><a href="https://www.instagram.com/p/<?php echo $gel['son']?>" target="_blank"><?php echo $gel['son']?></a></td>
                            <td><?php echo $gel['tarih']?></td>
                            <td><?php echo $gel['bitis']?></td>
                            <td><a href="#" id="<?php echo $gel['id']?>" name="sil">SİL</a></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
            <script>
                $("a[name=sil]").click(function (aaa) {
                    aaa.preventDefault();
                    var id=$(this).attr("id");
                   if(confirm('Silmeyi onaylıyor musunuz?')){
                       $.ajax({
                           type:"post",
                           url:"ajax.php",
                           data:{
                               "uyeotosil":1,
                               "id":id
                           },success:function (cevap) {
                               if(cevap.trim()==1){
                                   alert("Silinme işlemi başarılı, sayfayı yenileyiniz...");
                               }else {
                                   alert("Bir hata oluştu!\n "+cevap);
                               }
                           }
                       })
                   }
                })
            </script>
        </div>
    </div>
    </body>

    <?php require_once 'footer.php'; }else {header("location:giris.php");}?>