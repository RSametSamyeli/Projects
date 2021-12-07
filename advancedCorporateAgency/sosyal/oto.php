<?php session_start(); if(isset($_SESSION["mail"])){ include 'header.php'; include 'left.php';?>
<!--    <div class="bil">-->
<!--        <h1 class="bilgilen">Bilgilendirme    <span>x</span></h1>-->
<!--        <div class="bilgi">-->
<!--            --><?php
//            $bilgi=$db->query("select * from bilgi");
//            if($bilgi->rowCount()){
//                foreach($bilgi as $bilgiler){
//                    echo "<p><b>".$bilgiler['baslik'].":</b> ".$bilgiler['bilgi']."</p>";
//                }
//            }
//            ?>
<!--        </div>-->
<!--    </div>-->
    <div class="orta">
        <div class="ic">
            <h1><i class="fas fa-tachometer-alt"></i> Oto Hizmetlerim</h1>
            <div class="islemler">
                <ul id="islembas">
                    <li>Hizmet</li>
                    <li>Profil</li>
                    <li style='text-align: center'>İşlem Tarihi</li>
                    <li style='text-align: center'>Bitiş Tarihi</li>
                 
                </ul>

                    <?php
                    $oto=$db->query("select * from oto inner join servis on oto.servis_id=servis.id where uye_id='{$_SESSION['uye_id']}'");
                    if($oto->rowCount()){
                        foreach($oto as $otolar){
                            $tarih=new DateTime();
                            $gelentarih = new DateTime($otolar['bitis']);
                            $kalan=$tarih->diff($gelentarih);
                            $kalan=$kalan->format('%a');
//                            $de=date("Y-m-d H:i:s");
//                            $de=strtotime("3 day",strtotime($de));
//                            echo date('Y-m-d H:i:s' ,$de );
                            $almatarihi=strtotime($otolar['tarih']);
                            $bitis=strtotime($otolar['bitis']);
                            $almatarihi=date("d-m-Y",$almatarihi);
                            $bitis=date("d-m-Y",$bitis);
                            echo"<ul>
                            <li>".$otolar['adi']."</li>
                            <li>".$otolar['link']."</li>
                            <li style='text-align: center'>".$almatarihi."</li>
                            <li style='text-align: center'>".$bitis."</li>
                          ";
                        }
                    }else {echo "<p style='padding:10px;'>Hiç Oto Beğeniniz Yok!</p>";}

                    ?>


            </div>
        </div>
    </div>
    <?php include 'footer.php'; }else {header("location:/");}?>

