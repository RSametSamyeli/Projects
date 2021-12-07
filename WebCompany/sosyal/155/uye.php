<?php session_start(); if($_SESSION['yonetim']!=""){require_once '../ayar.php'; require_once 'header.php';
    $uye_id=$_GET['uyeid'];
    ?>
    <body><?php require_once'left.php';?>
    <div class="orta">
        <h1>Üye İşlemleri</h1>
        <table class="uye" border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">İD</td>
            <td>ADI</td>
            <td align="center">MİKTAR</td>
            <td align="center">TARİH</td>
            <td align="center">KATEGORİ</td>
            <td>LİNK</td>
            <td align="center">ÖDENEN</td>
            <td align="center">Durum</td>
        </tr>
        <?php
        $bak=$db->query("select * from uye where id='$uye_id'");
        if($bak->rowCount()){
            $bak=$bak->fetch(PDO::FETCH_ASSOC);
            $islemler=$db->query("select * from islemler where uye_id='$uye_id' order by id desc");
            if($islemler->rowCount()){
                foreach($islemler as $islem){
					 $durum=$islem['durum'];
                            if($durum==1){
                                $durum="Tamamlandı";
                            }else if($durum==2){
                                $durum="Sırada";
                            }else if($durum==3){
                                $durum="İşleme Alındı";
                            }else if($durum==4){
                                $durum="İptal Edildi";
                            }
                    ?>
                    <tr>
                        <td align="center"><?php echo $islem['id'];?></td>
                        <td><?php echo $islem['tanim'];?></td>
                        <td  align="center"><?php echo $islem['miktar'];?></td>
                        <td align="center"><?php echo $islem['tarih'];?></td>
                        <td align="center"><?php
                            $kategori=$db->query("select * from kategori where id='{$islem['kat_id']}'");
                            $kategori=$kategori->fetch(PDO::FETCH_ASSOC);
                            echo $kategori['adi'];
                            ?></td>
                        <td><a target="_blank" href="<?php echo $islem['link'];?>"><?php echo $islem['link'];?></a></td>
                        <td align="center"><?php echo round($islem['fiyat'],2);?></td>
                        <td align="center"><?php echo $durum ?></td>
                    </tr>
                    <?php
                }
            }
        }else {
            echo "yok";
        }
        ?>
        </table>
    </div>
    </body>
    <?php require_once 'footer.php';}
 else {
    header("location:giris.php");
}?>