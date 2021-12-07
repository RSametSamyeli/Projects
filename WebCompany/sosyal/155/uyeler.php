<?php session_start();
if ($_SESSION['yonetim'] != "") {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <div class="sec uyetop">

    <form method="post" action="export.php">
     <input type="submit" name="export" class="btn btn-success" value="Export" />
    </form>

            <h1>Üye İstatistikleri</h1>
            <table>
                <tr>
                    <td>Toplam Üye Sayısı</td>
                    <td>Yüklenen Toplam Para</td>
                </tr>
                <?php
                $toplamuye=0;
                $toplampara=0;
                $ce=$db->query("select * from uye where id!='652' and id!='716'");
                if($ce->rowCount()){
                    foreach($ce as $be){
                       $toplamuye+=1;
                       $toplampara+=$be['bakiye'];

                    }
                }
                ?>
                <tr>
                    <td><?php echo $toplamuye;?></td>
                    <td><?php echo round($toplampara,2);?> ₺</td>

                </tr>
            </table>
        </div>
        <div class="uyeara">
            <input type="text" name="uyeara" placeholder="Ara (Ad / Soyad / Mail / Telefon / İD)">
        </div>
        <div class="gelenuye"></div>
        <div clasS="uyeler">
            <div class="yenitable">
                <ul>
                    <a>
                        <li>İD</li>
                        <li>Adı Soyad</li>
                        <li>E-Posta</li>
                        <li>Telefon Numarası</li>
                        <li style="text-align:center;">Onay</li>
                        <li style="text-align:center;">Bakiye Bilgisi</li>
                        <li style="text-align:center;">Satın Aldıkları</li>
                        <li style="text-align:center;">İşlem</li>
                    </a>
                </ul>
                <?php
                $son = $db->query("select * from uye order by id desc ");
                if ($son->rowCount()) {
                    foreach ($son as $uye) {
                        ?>
                        <ul>
                            <a href="uye.php?uyeid=<?php echo $uye['id']; ?>">
                                <li><?php echo $uye['id'] ?></li>
                                <li><?php echo $uye['adsad'] ?></li>
                                <li><?php echo $uye['mail'] ?></li>
                                <li><?php echo $uye['telefon'] ?></li>
                                <li style="text-align:center;"><?php echo $uye['onay'] ?></li>
                                <li style="text-align:center;"><?php echo round($uye['bakiye'], 2); ?> ₺</li>
                                <li style="text-align:center;"><?php
                                    $islembak = $db->query("select count(*) as say from islemler where uye_id='{$uye['id']}'");
                                    $islembak = $islembak->fetch(PDO::FETCH_ASSOC);
                                    echo $islembak['say'];
                                    ?>
                                </li>
                                <li style="text-align: center;"><a href="#" name="uyesil" id="<?php echo $uye['id'] ?>">SİL</a></li>
                            </a>
                        </ul>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    </body>
    <script>
        $("a[name=uyesil]").click(function (uyesil) {
            uyesil.preventDefault();
            var uyeid=$(this).attr("id");
            if (confirm('İD: '+uyeid+' üye silinecek, onaylıyor musunuz?')) {
               $.ajax({
                   type:"post",
                   url:"ajax.php",
                   data:{
                       "uyesil":1,
                       "uyeid":uyeid
                   },success:function (cevap) {
                       if(cevap.trim()==1){
                           alert("Üye silindi");
                           window.location.reload();
                       }else{
                           alert("Üye silinirken bir hata oluştu...")
                       }
                   }
               })
            }
        })
    </script>
    <?php require_once 'footer.php';
} else {
    header("location:giris.php");
} ?>