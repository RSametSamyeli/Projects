<?php session_start();
include 'ayar.php';
date_default_timezone_set('Europe/Istanbul');

function sendsms($msg, $telno)
{
    $header = 'Graptik';
    $msg = html_entity_decode($msg, ENT_COMPAT, "UTF-8");
    $msg = rawurlencode($msg);
    $msg = str_replace("%0A", '\n', $msg);
    $header = html_entity_decode($header, ENT_COMPAT, "UTF-8");
    $header = rawurlencode($header);
    $username = "2426061052";
    $pass = "mert3407";
    $startdate = date('d.m.Y H:i');
    $startdate = str_replace('.', '', $startdate);
    $startdate = str_replace(':', '', $startdate);
    $startdate = str_replace(' ', '', $startdate);
    $stopdate = date('d.m.Y H:i', strtotime('+1 day'));
    $stopdate = str_replace('.', '', $stopdate);
    $stopdate = str_replace(':', '', $stopdate);
    $stopdate = str_replace(' ', '', $stopdate);
    $url = "http://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=$telno&message=$msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
    //echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


if (isset($_POST['kategori'])) {
    $katid = $_POST['kategori'];
    $listele = $db->query("select * from servis where kategori_id='$katid' order by adi asc");
    if ($listele->rowCount()) {
        foreach ($listele as $liste) {
            echo "<option name=" . $liste['fiyati'] . " id=" . $liste['id'] . ">" . $liste['adi'] . " ——— " . $liste['fiyati'] . "₺</option>";
            ?>
            <script>
                $("option").click(function () {
                    $("input[type=text]").val("");

                });
            </script>
            <?
        }
    }
}

if (isset($_POST['aciklama'])) {
    $katid = $_POST['aciklama'];
    $listele = $db->query("select * from servis where id='$katid'");
    if ($listele->rowCount()) {
        foreach ($listele as $liste) {
            echo trim($liste['aciklama']);

        }
    }
}
if (isset($_POST['login']) && isset($_POST['kad'])) {
    $kad = trim($_POST['kad']);
    $sif = $_POST['sif'];
    $giris = $db->query("select * from uye where mail='$kad' and sifre='$sif'");
    if ($giris->rowCount()) {
        $giris = $giris->fetch(PDO::FETCH_ASSOC);
        if ($giris['onay'] == 1) {
            echo 1;
            $_SESSION['mail'] = $giris['mail'];
            $_SESSION['uye_id'] = $giris['id'];
            $_SESSION['tel'] = $giris['telefon'];
            $_SESSION['adsad'] = $giris['adsad'];
        } else {
            echo 2;
        }
    } else {
        echo 0;
    }
}


if (isset($_POST['servis']) && isset($_POST['kat'])) {
    $kat = $_POST['kat'];
    $servis = $_POST['servis'];
    $serid = $_POST['serid'];
    $link = $_POST['link'];
    $adet = $_POST['adet'];
    $tarih = date("Y-m-d H:i:s");
    $uye = $_SESSION['uye_id'];
    $fiyat = $db->query("select * from servis where id='$serid'")->fetch(PDO::FETCH_ASSOC);
    $min = $fiyat['mini'];
    $max = $fiyat['maks'];
    $tur=$fiyat['marketid'];
    if ($kat == 4 or $kat == 5) {
        $gf = $fiyat['orj'];
        $odeme = $fiyat['fiyati'];
        $sor = $db->query("select * from uye where id='$uye'")->fetch(PDO::FETCH_ASSOC);
         if (floatval($sor['bakiye']) >= floatval($odeme)) {
            //işlem giriş
            $sure = $fiyat['sure'];
            $bitis = date("Y-m-d H:i:s");
            $bitis = strtotime($sure . "day", strtotime($bitis));
            $bitis = date("Y-m-d H:i:s", $bitis);
            $siparis = $db->prepare("insert into islemler (tanim,kat_id,uye_id,servis_id,miktar,tarih,link,fiyat,gf,takip,durum,baslangic) values (?,?,?,?,?,?,?,?,?,?,?,?)");
            $siparis->execute(array($servis, $kat, $uye, $serid, 1, $tarih, $link, $odeme, $gf,"-","-","-"));
            $oto = $db->prepare("insert into oto (uye_id,tarih,bitis,kat_id,servis_id,link) values (?,?,?,?,?,?)");
            $oto->execute(array($uye, $tarih, $bitis, $kat, $serid, $link));
            //bakiye düşürme
            $bakiye = $db->prepare("update uye set bakiye=bakiye-'$odeme' where id='$uye'");
            $bakiye->execute();
            echo 1;
        } else {
            echo 0;
        }
    }else if ($kat==18){
        $gf = $fiyat['orj'];
        $odeme = $fiyat['fiyati'];
        $sor = $db->query("select * from uye where id='$uye'")->fetch(PDO::FETCH_ASSOC);
          if (floatval($sor['bakiye']) >= floatval($odeme)) {
            $sure = 30;
            $bitis = date("Y-m-d H:i:s");
            $bitis = strtotime($sure . "day", strtotime($bitis));
            $bitis = date("Y-m-d H:i:s", $bitis);
            $siparis = $db->prepare("insert into islemler (tanim,kat_id,uye_id,servis_id,miktar,tarih,link,fiyat,gf,takip,durum,baslangic) values (?,?,?,?,?,?,?,?,?,?,?,?)");
            $siparis->execute(array($servis, $kat, $uye, $serid, 1, $tarih, $link, $odeme, $gf,"-","-","-"));
            $paket = $db->prepare("insert into paket (kad,tur,bitis,uye_id,say) values (?,?,?,?,?)");
            $paket->execute(array($link,$tur,$bitis,$uye,0));
            //bakiye düşürme
            $bakiye = $db->prepare("update uye set bakiye=bakiye-'$odeme' where id='$uye'");
            $bakiye->execute();
            echo 1;
        }else {
            echo 0;
        }
    } else if($kat==27){
        $gf = $fiyat['orj'];
        $odeme = $fiyat['fiyati'];
        $sor = $db->query("select * from uye where id='$uye'")->fetch(PDO::FETCH_ASSOC);
	
        if (floatval($sor['bakiye']) >= floatval($odeme)) {
            $sure = 30;
            $siparis = $db->prepare("insert into islemler (tanim,kat_id,uye_id,servis_id,miktar,tarih,link,fiyat,gf,takip,durum,baslangic) values (?,?,?,?,?,?,?,?,?,?,?,?)");
            $siparis->execute(array($servis, $kat, $uye, $serid, 1, $tarih, $link, $odeme, $gf,"-",3,"-"));
            $sonid=$db->lastInsertId();
            $paket = $db->prepare("insert into tik (uye_id,kad,durum,tarih,uye,siparis,fiyati,s_id) values (?,?,?,?,?,?,?,?)");
            $paket->execute(array($uye,$link,0,$tarih,$_SESSION['adsad'],$servis,$odeme,$sonid));
            //bakiye düşürme
            $bakiye = $db->prepare("update uye set bakiye=bakiye-'$odeme' where id='$uye'");
            $bakiye->execute();
            echo 1;
			
        }else {
            echo 0;
        }
    }else {
        if ($adet < $min || $adet > $max) {
            echo 2;
        } else {
            $gf = $adet * $fiyat['orj'] / 1000;
            $odeme = $adet * $fiyat['fiyati'] / 1000;
            //Bakiye Sorgu
            $sor = $db->query("select * from uye where id='$uye'")->fetch(PDO::FETCH_ASSOC);
           if (floatval($sor['bakiye']) >= floatval($odeme)) {
                //işlem giriş

//------------------------------------------------Satın Alma
                $marketid = $db->query("select * from servis where id=$serid");
                if ($marketid->rowCount()) {
                    $marketid = $marketid->fetch(PDO::FETCH_ASSOC);
                    $api = new Api();
                    $services = $api->services();
                    $order = $api->order(array('service' => $marketid['marketid'], 'link' => $link, 'quantity' => $adet));
                    if (isset($order->error)) {
                        echo 5;
                    } else {
                        $status = $api->status($order->order);
                        $durum = $status->status;
                        $baslangic = $status->start_count;
//                    echo "$durum - $baslangic ";
                        $balance = $api->balance();
//                    print_r($status);
//                    print_r($order);
//                    print_r($order);
                        $takip = $order->order;
                        $siparis = $db->prepare("insert into islemler (tanim,kat_id,uye_id,servis_id,miktar,tarih,link,fiyat,gf,takip,durum,baslangic) values (?,?,?,?,?,?,?,?,?,?,?,?)");
                        $siparis->execute(array($servis, $kat, $uye, $serid, $adet, $tarih, $link, $odeme, $gf, $takip,"-","-"));
                        //bakiye düşürme
                        $bakiye = $db->prepare("update uye set bakiye=bakiye-'$odeme' where id='$uye'");
                        $bakiye->execute();
                        echo 1;
                    }
                }
            } else {
                echo 0;
            }
        }
    }
}
if (isset($_POST['onceki'])) {
//    echo "asd";
    $suan = $_POST['onceki'];
    $islemler = $db->query("select * from islemler where uye_id='{$_SESSION['uye_id']}' order by id desc limit $suan,10 ");
    if ($islemler->rowCount()) {
        $i = 0;
        foreach ($islemler as $getir) {
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

            echo "<ul id=\"islemgel\">
                                  <li>" . $getir['id'] . "</li>
                                  <li>" . $getir['tarih'] . "</li>
                                  <li>" . $getir['tanim'] . "</li>
                                  <li>" . $getir['miktar'] . "</li>
                                  <li>" . $getir['fiyat'] . "₺</li>
                                  <li>" . $getir['link'] . "</li>
                                  <li>" . $durum . "</li>
                                  </ul>";
        }
//                         echo $i;
    }

}
if (isset($_POST['sonraki'])) {
//    echo "asd";
    $suan = $_POST['sonraki'];
    $islemler = $db->query("select * from islemler where uye_id='{$_SESSION['uye_id']}' order by id desc limit $suan,10 ");
    if ($islemler->rowCount()) {
        $i = 0;
        foreach ($islemler as $getir) {
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

            echo "<ul id=\"islemgel\">
                                  <li>" . $getir['id'] . "</li>
                                  <li>" . $getir['tarih'] . "</li>
                                  <li>" . $getir['tanim'] . "</li>
                                  <li>" . $getir['miktar'] . "</li>
                                  <li>" . $getir['fiyat'] . "₺</li>
                                  <li>" . $getir['link'] . "</li>
                                  <li>" . $durum . "</li>
                                  </ul>";
        }
//                         echo $i;
    }
}


if (isset($_POST['banka'])) {
    $banka = trim(strip_tags($_POST['banka']));
    $gonderen = trim(strip_tags($_POST['gonderen']));
    $miktar = trim(strip_tags($_POST['miktar']));
    $ekler = trim(strip_tags($_POST['ekler']));
    $uye_id = $_SESSION['uye_id'];
    $tarih = date("Y-m-d H:i:s");
    $odemebildir = $db->prepare("insert into odemebildirimi (uye_id,miktar,banka,tarih,ekler) values(?,?,?,?,?)");
    $odemebildir->execute(array($uye_id, $miktar, $banka, $tarih, $ekler));
    if ($odemebildir) {


        #--------------------------SMS---------------------------#
        $mesaj = "$banka odeme bildirimi; uye id: $uye_id , miktar: $miktar TL \n";
        if (sendsms($mesaj, "5355142180")) {
            echo 1;
        }

        #--------------------------SMS---------------------------#
    } else {
        echo 0;
    }
}


if (isset($_POST['mesajkonu'])) {
    $konu = trim(strip_tags($_POST['mesajkonu']));
    $icerik = trim(strip_tags($_POST['mesajicerik']));
    $tarih = date("Y-m-d H:i:s");
    $uye_id = $_SESSION['uye_id'];
    $mesajgir = $db->prepare("insert into iletisim(uye_id,konu,mesaj,tarih) values(?,?,?,?)");
    $mesajgir->execute(array($uye_id, $konu, $icerik, $tarih));
    if ($mesajgir) {
        echo 1;
    } else {
        echo 0;
    }
}


if (isset($_POST['ad']) && isset($_POST['kad']) && isset($_POST['sif']) && isset($_POST['tel'])) {
    $ad = $_POST['ad'];
    $kad = $_POST['kad'];
    $sif = $_POST['sif'];
    $tel = $_POST['tel'];
    $tel = str_replace(array(" ", "(", ")", "-"), array("", "", "", ""), $tel);
    $onaykodu = rand(1000, 9999);
    $telkont = strlen($tel);
    $tel = ltrim($tel, 0);
    $varmi = $db->query("select * from uye where mail='$kad'");
    $telvarmi = $db->query("select * from uye where telefon='$tel'");
    if ($telvarmi->rowCount() && $varmi->rowCount()) {
        echo 4;
    } else if ($telvarmi->rowCount()) {
        echo 3;
    } else if ($varmi->rowCount()) {
        echo 2;
    } else {
        $kaydol = $db->prepare("insert into uye (adsad,mail,sifre,telefon,onay,onay_kodu,bakiye) values(?,?,?,?,?,?,?)");
        $kaydol->execute(array($ad, $kad, $sif, $tel, 0, $onaykodu,0));
        if ($kaydol) {
            if (sendsms("Onay Kodunuz: {$onaykodu} \n\n", $tel)) {
                echo 1;
            }
        } else {
            echo 0;
        }
    }
}

if (isset($_POST['onaykodu']) && isset($_POST['onaytelefon'])) {
    $telefon = $_POST['onaytelefon'];
    $telefon = str_replace(array(" ", "(", ")", "-"), array("", "", "", ""), $telefon);
    $telefon = ltrim($telefon, 0);
    $kod = $_POST['onaykodu'];
//        echo $telefon;
//        echo $kod;
    $onayla = $db->query("select * from uye where telefon='$telefon' and onay_kodu='$kod'");
    if ($onayla->rowCount()) {
        $islem = $db->prepare("update uye set onay='1' where telefon='$telefon'");
        $islem->execute();
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['onaykodu']) && isset($_POST['mail'])) {
    $mail = $_POST['mail'];
    $kod = $_POST['onaykodu'];
//        echo $telefon;
//        echo $kod;
    $onayla = $db->query("select * from uye where mail='$mail' and onay_kodu='$kod'");
    if ($onayla->rowCount()) {
        $islem = $db->prepare("update uye set onay='1' where mail='$mail'");
        $islem->execute();
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['tekrar'])) {
    $telefon = $_POST['telefon'];
    $telefon = str_replace(array(" ", "(", ")", "-"), array("", "", "", ""), $telefon);
    $telefon = ltrim($telefon, 0);
    $mail = $_POST['mail'];
    $yenikod = rand(1000, 9999);
    $tekrar = $db->prepare("update uye set telefon='$telefon', onay_kodu='$yenikod' where mail='$mail'");
    if ($tekrar->execute()) {
//    $instance = new SitemioSMS("7304040565", "2WH9TvtG");
//    $gonder2 = $instance->Submit("GRAPTIK", "Onay Kodunuz: {$yenikod} \n\n", array("$telefon"));
//    echo 1;
        if (sendsms("Onay Kodunuz: {$yenikod} \n\n", $telefon)) {
            echo 1;
        }
    }
}

if (isset($_POST['giristekraronay'])) {
    $tel = str_replace(array(" ", "(", ")", "-"), array("", "", "", ""), $_POST['tekrartel']);
    $mail = $_POST['mail'];
    $yenikod = rand(1000, 9999);
    $tel = ltrim($tel, 0);
    $telgun = $db->prepare("update uye set telefon='$tel', onay_kodu='$yenikod' where mail='$mail'");
    if ($telgun->execute()) {
//     $instance = new SitemioSMS("7304040565", "2WH9TvtG");
//     $gonder2 = $instance->Submit("GRAPTIK", "Onay Kodunuz: {$yenikod}", array("$tel"));
        if (sendsms("Onay Kodunuz: {$yenikod} \n\n", $tel)) {
            echo 1;
        }
    }

}
function GetIP()
{
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode(',', $ip);
            $ip = trim($tmp[0]);
        }
    } else {
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}

// ---------- Hesap Güncelleme

if(isset($_POST['sifsifirla'])) {
    $maill = $_POST['mail'];
    $bul = $db->query("select * from uye where mail='$maill'");
    if ($bul->rowCount()) {
        $baglanti = "";
        for ($i = 0; $i < 5; $i++) {
            $baglanti .= chr(rand(65, 90));
            $baglanti .= chr(rand(97, 122));
        }
        $tarih = date("Y-m-d H:i:s");
        $ip_adresi = GetIP();
        $sifirla = $db->prepare("insert into sifresifirla (mail,ip,baglanti,durum,tarih) values(?,?,?,?,?)");
        $sifirla->execute(array($maill, $ip_adresi, $baglanti, 0, $tarih));
		$to=$maill;
	$from = "Graptik <hesap@graptik.biz>";
    $subject = "Şifre Sıfırlama";
     $message = "Hesabınız için şifre sıfırlama talebinde bulundunuz, şifre sıfırlamak için aşağıdaki bağlantıyı kullanabilirsiniz. <br> <a href='http://graptik.biz/sifirla?codex=$baglanti'>ŞİFRE SIFIRLA</a> <br>
          Eğer şifre sıfırlama talebinde bulunmadıysanız bu e postayı önemsemeyiniz...";
	$headers = 'Content-type: text/html; charset=utf-8'."\r\n";
    $headers.= "From:" . $from;
	$bak=mail($to,$subject,$message,$headers);
    if($bak){
		
		echo 1;
	}
    } else {
        echo 0;
    }
}

if (isset($_POST['sifreyenileme'])) {
    $codex = $_POST['codex'];
    $yenisifre = $_POST['yenisifre'];
    $bak = $db->query("select * from sifresifirla where durum=0 and baglanti='$codex'");
    if ($bak->rowCount()) {
        $bak = $bak->fetch(PDO::FETCH_ASSOC);
        $mail = $bak['mail'];
        $yenile = $db->prepare("update uye set sifre='$yenisifre' where mail='$mail'");
        $yenile->execute();
        $oldur = $db->prepare("update sifresifirla set durum='1' where mail='$mail' and baglanti='$codex'");
        $oldur->execute();

    }
}


if (isset($_POST['sifreguncelle'])) {
    $eski = $_POST['eskisifre'];
    $yeni = $_POST['yenisifre'];

    $bak = $db->query("select * from uye where sifre='$eski' and mail='{$_SESSION['mail']}'");
    if ($bak->rowCount()) {
        $yenile = $db->prepare("update uye set sifre='$yeni' where mail='{$_SESSION['mail']}'");
        $yenile->execute();
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['uyeguncelle'])) {
    $ad = trim(strip_tags($_POST['uyead']));
    $posta = trim(strip_tags($_POST['uyeposta']));
    $telefon = str_replace(array(" ", "(", ")", "-"), array("", "", "", ""), $_POST['uyetel']);
    $telkontrol = $db->query("select * from uye where id='{$_SESSION['uye_id']}'");
    $telkontrol = $telkontrol->fetch(PDO::FETCH_ASSOC);
    if ($telefon != $telkontrol['telefon']) {
        $onay = 0;
    } else {
        $onay = 1;
    }
    $guncelle = $db->prepare("update uye set adsad=?,mail=?,telefon=?,onay=? where id=?");
    $tamam = $guncelle->execute(array($ad, $posta, $telefon, $onay, $_SESSION['uye_id']));
    if ($tamam) {
        echo 1;
    } else {
        echo 0;
    }
}

?>




