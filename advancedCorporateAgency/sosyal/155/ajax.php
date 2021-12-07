<?php session_start();
include_once '../ayar.php';

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

if (isset($_POST['kad']) && isset($_POST['sif'])) {
    $kad = trim($_POST['kad']);
    $sif = $_POST['sif'];
    $giris = $db->query("select * from yonetim where kad='$kad' and sif='$sif'");
    if ($giris->rowCount()) {
        echo 1;
        foreach ($giris as $data) {
            $_SESSION['yonetim'] = $data['kad'];
        }
    } else {
        echo 0;
    }
}


if (isset($_POST['katduz'])) {
    $katduz = $_POST['katduz'];
    $kat = $db->query("select * from kategori where id=$katduz");
    $kat = $kat->fetch(PDO::FETCH_ASSOC);
    echo "<input type='text' name='katduzid' value='{$kat['id']}' disabled>";
    echo "<input type='text' name='katduzis' value='{$kat['adi']}'>";
}


if (isset($_POST['katid'])) {
    $katid = $_POST['katid'];
    $katis = $_POST['katis'];
    $gun = $db->prepare("update kategori set adi='$katis' where id=$katid");
    $gun->execute();
}


if (isset($_POST['serduz'])) {
    $serid = $_POST['serduz'];
    $cek = $db->query("select * from servis where id=$serid")->fetch(PDO::FETCH_ASSOC);
    echo "<label for='servisadi'>Servis Adı</label>";
    echo "<input type='text' value='{$cek['adi']}' id='{$cek['id']}' name='servisadi'>";
    echo "<label for='fiyati'>Fiyatı</label>";
    echo "<input type='text' value='{$cek['fiyati']}' name='fiyati'>";
    if ($cek['kategori_id'] == 4 || $cek['kategori_id'] == 5) {
        echo "<label for='sure'>Süresi (Oto islemler için yoksa boş)</label>";
        echo "<input type='text' value='{$cek['sure']}' name='sure'>";
        echo "<label for='miktar'>Miktar (Oto-Beğeni)</label>";
        echo "<input type='text' value='{$cek['miktar']}' name='miktar'>";
    }
    echo "<label for='marketid'>Market İD</label>";
    echo "<input type='text' value='{$cek['marketid']}' name='marketid'>";

    echo "<label for='orj'>Orjinal Fiyat</label>";
    echo "<input type='text' value='{$cek['orj']}' name='orj'>";
    if ($cek['kategori_id'] != 4 && $cek['kategori_id'] != 5) {
        echo "<label for='min'>Minimum Satın Alma</label>";
        echo "<input type='text' value='{$cek['mini']}' name='min'>";
        echo "<label for='max'>Maksimum Satın Alma</label>";
        echo "<input type='text' value='{$cek['maks']}' name='max'>";
    }
    echo "<label for='aciklama'>Açıklama</label>";
    echo "<textarea rows='15' name='aciklama'>{$cek['aciklama']}</textarea>";
}
if (isset($_POST['servisguncelle'])) {
    $servisadi = $_POST['seradi'];
    $serid = $_POST['serid'];
    $fiyati = $_POST['fiyati'];
    $orj = $_POST['orj'];
    isset($_POST['sure']) ? $sure = $_POST['sure'] : $sure = "";
    isset($_POST['otomiktar']) ? $miktar = $_POST['otomiktar'] : $miktar = "";
    $marketid = $_POST['marketid'];
    if (isset($_POST['min']) || isset($_POST['max'])) {
        $min = $_POST['min'];
        $max = $_POST['max'];
    } else {
        $min = "";
        $max = "";
    }
    $aciklama = $_POST['aciklama'];
    $guncelle = $db->prepare("update servis set adi=?, fiyati=?,aciklama=?,sure=?,marketid=?,maks=?,mini=?,miktar=?,orj=? where id=?");
    $guncelle->execute(array($servisadi, $fiyati, $aciklama, $sure, $marketid, $max, $min, $miktar, $orj, $serid));
    if ($guncelle) echo "Güncellendi";
}

if (isset($_POST['sersil'])) {
    $sersil = $_POST['sersil'];
    $sil = $db->prepare("delete from servis where id=$sersil");
    $sil->execute();
}
if (isset($_POST['katsil'])) {
    $katsil = $_POST['katsil'];
    $sil = $db->prepare("delete from kategori where id=$katsil");
    $sil2 = $db->prepare("delete from servis where kategori_id=$katsil");
    $sil->execute();
    $sil2->execute();
}
if (isset($_POST['servisekle'])) {
    $katid = $_POST['opti'];
    $servisadi = $_POST['serad'];
    $fiyati = $_POST['fiyati'];
    $orj = $_POST['orj'];
    $sure = $_POST['sure'];

    $marketid = $_POST['marketid'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    isset($_POST['otomiktar']) ? $miktar = $_POST['otomiktar'] : $miktar = "";
    if ($katid == 4 or $katid == 5) {
        $aciklama = $_POST['aciklama'];
    } else {
        $aciklama = $_POST['aciklama'];
    }
    $serekle = $db->prepare("insert into servis (kategori_id,adi,fiyati,aciklama,sure,marketid,maks,mini,miktar,orj)values(?,?,?,?,?,?,?,?,?,?)");
    $serekle->execute(array($katid, $servisadi, $fiyati, $aciklama, $sure, $marketid, $max, $min, $miktar, $orj));
    print_r($serekle->errorInfo());
    echo $sure;
}
if (isset($_POST['bakiyeid'])) {
    $bakiyeid = $_POST['bakiyeid'];
    $uyecek = $db->query("select * from uye where id='$bakiyeid' or (adsad like '%$bakiyeid%' or mail like '%$bakiyeid%' or telefon like '%$bakiyeid%')");
    if ($uyecek->rowCount()) {
        $uyecek = $uyecek->fetch(PDO::FETCH_ASSOC);
        echo "<input type=\"text\" name=\"id\" value='{$uyecek['id']}'disabled>
            <input type=\"text\" name=\"adsad\" value='{$uyecek['adsad']}'disabled>
            <input type=\"text\" name=\"mail\" value='{$uyecek['mail']}' disabled>
            <input type=\"text\" name=\"tel\" value='{$uyecek['telefon']}' disabled>
                        <input type=\"text\" name=\"bakiye\" id='eklenecek' placeholder=\"Eklenecek Tutar\">";
    } else {
        echo "<p style=' float:left; width:100%;margin-top:10px;'>Üye Bulunamadı</p>";
    }
}

//if (isset($_POST['bakiyeekle']) && $_SESSION['yonetim']=="root") {
//    $bakiyeid = $_POST['bakid'];
//    $ektut = $_POST['bakiye'];
//    $ekle = $db->prepare("update uye set bakiye=bakiye+'$ektut' where id=$bakiyeid");
//
//    if ($ekle->execute()) {
//        echo 1;
//    } else {
//        echo 0;
//    }
//    $tarih = date("Y-m-d H:i:s");
//    $kayit = $db->prepare("insert into odeak (tarih,uye,yontem,miktar) values (?,?,?,?)");
//    $kayit->execute(array($tarih, $bakiyeid, "HAVALE/EFT", $ektut));
//}

if (isset($_POST['bakiyecikar'])) {
    $bakiyeid = $_POST['bakid'];
    $ektut = $_POST['bakiye'];
    $ekle = $db->prepare("update uye set bakiye=bakiye-'$ektut' where id=$bakiyeid");
    if ($ekle->execute()) {
        echo 1;
    } else {
        echo 0;
    }

}
if (isset($_POST['katadi'])) {
    $yenikat = trim($_POST['katadi']);
    $katekle = $db->prepare("insert into kategori (adi) values (?)");
    if ($katekle->execute(array($yenikat))) {
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['uyeara'])) {
    if ($_POST['uyeara'] != null) {
        $sorgu = $_POST['sorgu'];
        $uyeara = $db->query("select * from uye where id='$sorgu' or(adsad like '%$sorgu%' or telefon like '%$sorgu%' or mail like '%$sorgu%')");
        if ($uyeara->rowcount()) {

            ?>
            <h1>Arama sonuçları</h1>
            <ul>
                <a>
                    <li>İD</li>
                    <li>ADI</li>
                    <li>MAİL</li>
                    <li>TELEFON</li>
                    <li>BAKİYE</li>
                </a>
            </ul>
            <?php foreach ($uyeara as $gelenuye) { ?>
                <ul>
                    <a href="uye.php?uyeid=<?php echo $gelenuye['id']; ?>">
                        <li><?php echo $gelenuye['id']; ?></li>
                        <li><?php echo $gelenuye['adsad']; ?></li>
                        <li><?php echo $gelenuye['mail']; ?></li>
                        <li><?php echo $gelenuye['telefon']; ?></li>
                        <li><?php echo $gelenuye['bakiye']; ?></li>
                    </a>
                </ul>
            <?php } ?>
            </table>

        <?php }
    } else {
        echo "<p>Sonuç yok!</p>";
    }

}

if (isset($_POST['adminoto'])) {
    $post = $_POST;
//    print_r($post);
    $kad = $post['kullaniciadi'];
    $gun = $post['gun'];
    $miktar = $post['miktari'];
    $sinir = $post['sinir'];
    $servis = $post['servisi'];
    $e_tarih = date("Y-m-d H:i:s");
    $masraf = str_replace(array("$"), array(""), $post['masraf']);
    $alinan = $post['alinan'];
    $bitis = date("Y-m-d", strtotime("+$gun day", strtotime(date("Y-m-d"))));
    $gir = $db->prepare("insert into adminotolar (kad,bitis,miktar,sinir,servis,alinan,masraf,e_tarih) values('$kad','$bitis','$miktar','$sinir','$servis','$alinan','$masraf','$e_tarih')");
    $sonuc = $gir->execute();
    exit();
}
if (isset($_POST['tarih'])) {
    $api = new Api();
    $tarih1 = $_POST['tarih1'];
    $tarih2 = $_POST['tarih2'];
    if ($tarih1 != $tarih2) {
        $cek = $db->query("select * from islemler where tarih BETWEEN '$tarih1' AND '$tarih2' order by id desc");
    } else {
        $tarih1 = $tarih1 . " 00:00:00";
        //echo $tarih1;
        $tarih2 = $tarih2 . " 23:59:59";
        $cek = $db->query("SELECT * FROM islemler WHERE (tarih>='$tarih1' and tarih<='$tarih2')");
    }
    if ($cek->rowCount()) {
        $data = array();
        $i = 0;
        foreach ($cek as $geldi) {
            $baslangic = $geldi['baslangic'];
            $durum = $geldi['durum'];
            if ($durum == 1) {
                $durum = "Tamamlandı";
            } else if ($durum == 2) {
                $durum = "Sırada";
            } else if ($durum == 3) {
                $durum = "İşleme Alındı";
            } else if ($durum == 4) {
                $durum = "İptal Edildi";
            }

            $data[$i]['id'] = $geldi['id'];
            $data[$i]['tarih'] = $geldi['tarih'];
            $data[$i]['uye_id'] = $geldi['uye_id'];
            $data[$i]['aciklama'] = $geldi['tanim'];
            $data[$i]['fiyat'] = $geldi['fiyat'];
            $data[$i]['link'] = $geldi['link'];
            $data[$i]['miktar'] = $geldi['miktar'];
            $data[$i]['durum'] = $durum;
            $data[$i]['baslangic'] = $baslangic;
            $data[$i]['gf'] = $geldi['gf'];
            $i++;
        }
        header("Content-Type: application/json");
        echo json_encode($data);
        exit();
    }
}
if (isset($_POST['odetarih'])) {
    $api = new Api();
    $tarih1 = $_POST['tarih1'];
    $tarih2 = $_POST['tarih2'];
    if ($tarih1 != $tarih2) {
        $cek = $db->query("select * from odeak where tarih BETWEEN '$tarih1' AND '$tarih2' order by id desc");
    } else {
        $tarih1 = $tarih1 . " 00:00:00";
        //echo $tarih1;
        $tarih2 = $tarih2 . " 23:59:59";
        $cek = $db->query("SELECT * FROM islemler WHERE (tarih>='$tarih1' and tarih<='$tarih2')");
    }
    if ($cek->rowCount()) {
        $data = array();
        $i = 0;
        foreach ($cek as $geldi) {
            $data[$i]['id'] = $geldi['id'];
            $data[$i]['tarih'] = $geldi['tarih'];
            $data[$i]['uye_id'] = $geldi['uye'];
            $data[$i]['aciklama'] = $geldi['yontem'];
            $data[$i]['fiyat'] = $geldi['miktar'];
            $i++;
        }
        header("Content-Type: application/json");
        echo json_encode($data);
        exit();
    }
}

if (isset($_POST['otoadmintarih'])) {
    $tarih1 = $_POST['tarih1'];
    $tarih2 = $_POST['tarih2'];
    $cek = $db->query("select * from adminotolar inner join adminoto on adminoto.id=adminotolar.servis where (e_tarih>='$tarih1' and e_tarih<='$tarih2')");
    if ($cek->rowCount()) {
        $data = array();
        $i = 0;
        foreach ($cek as $geldi) {
            $data[$i]['id'] = $geldi['0'];
            $data[$i]['adi'] = $geldi['adi'];
            $data[$i]['kad'] = $geldi['kad'];
            $data[$i]['miktar'] = $geldi['miktar'];
            $data[$i]['sinir'] = $geldi['sinir'];
            $suan = strtotime(date("Y-m-d"));
            $bitis = strtotime($geldi['bitis']);
            if ($bitis < $suan) {
                $son = "Bitti";
            } else {
                $son = ($bitis - $suan) / 86400;
            }
            $data[$i]['son'] = $son;
            $data[$i]['masraf'] = $geldi['masraf'];
            $data[$i]['alinan'] = $geldi['alinan'];
            $i++;
        }
        header("Content-Type: application/json");
        echo json_encode($data);
        exit();
    }
}
if (isset($_POST['otoduz'])) {
    $post = $_POST;
    $id = $post['duzid'];
    $cek = $db->query("select * from adminotolar where id='$id'");
    $cek = $cek->fetch(PDO::FETCH_ASSOC);
    $suan = strtotime(date("Y-m-d"));
    $bitis = strtotime($cek['bitis']);
    $son = ($bitis - $suan) / 86400;
    if ($bitis < $suan) {
        $son = "Bitti";
    } else {
        $son = ($bitis - $suan) / 86400;
    }

    $sonuc = array(
        'id' => $cek['id'],
        'kad' => $cek['kad'],
        'gun' => $son,
        'miktar' => $cek['miktar'],
        'sinir' => $cek['sinir']
    );
    header("Content-Type:application/json");
    echo json_encode($sonuc);
    exit();
}

if (isset($_POST['otoduzenle'])) {
    $post = $_POST;
    $id = $post['id'];
    $kad = $post['kad'];
    $gun = $post['gun'];
    $bitis = date("Y-m-d", strtotime("+$gun day", strtotime(date("Y-m-d"))));
    $miktar = $post['mik'];
    $sinir = $post['islem'];
    $guncelle = $db->prepare("update adminotolar set kad=?,bitis=?,miktar=?,sinir=? where id=?");
    $tamamla = $guncelle->execute(array($kad, $bitis, $miktar, $sinir, $id));
    if ($tamamla) echo 1;

}

if (isset($_POST['otosil'])) {
    $id = $_POST['id'];
    $sil = $db->prepare("delete from adminotolar where id='$id'");
    $islem = $sil->execute();
    echo $islem;
    exit();
}
if (isset($_POST['toplusms'])) {
    $mesaj = $_POST['mesaj'];
    $cek = $db->query("select * from uye");
    $gels = "";
    $bekle = 0;
    if ($cek->rowCount()) {
        foreach ($cek as $tel) {
            $gels = $gels . $tel['telefon'] . ",";
            $bekle++;
            if ($bekle >= 50) {
                $gels = rtrim($gels, ",");
                #--------------------------SMS---------------------------#
                if (sendsms($mesaj, $gels)) {
                    echo 1;
                }
                #--------------------------SMS---------------------------#
                $gels = "";
                $bekle = 0;
            }
        }
        echo 1;
    }
}


if (isset($_POST['icerikduzenle'])) {
    $id = $_POST['icerikid'];
    $sec = $db->query("select * from icerik where id=$id");
    $sec = $sec->fetch(PDO::FETCH_ASSOC);
    $sonuc = array(
        "baslik" => $sec['baslik'],
        "icerik" => $sec['icerik'],
        "aciklama" => $sec['aciklama'],
        "etiket" => $sec['etiket'],
        "link" => $sec['seo'],
        "kategori" => $sec['kategori'],
        "resim" => $sec['resim']
    );

    header("Content-Type:application/json");
    echo json_encode($sonuc);

}

if (isset($_POST['icerikguncelle'])) {
    $baslik = trim($_POST['baslik']);
    $icerik = trim($_POST['icerik']);
    $aciklama = trim($_POST['aciklama']);
    $etiket = trim($_POST['etiket']);
    $link = trim($_POST['link']);
    $kategori = trim($_POST['kategori']);
    $resim = trim($_POST['resim']);
    $gir = $db->prepare("update icerik set baslik=?,icerik=?,aciklama=?,etiket=?,seo=?,kategori=?,resim=? where id=?");
    $tamam = $gir->execute(array($baslik, $icerik, $aciklama, $etiket, $link, $kategori, $resim, $_POST['id']));
    echo $tamam ? 1 : 0;

}

if (isset($_POST['icerikekle'])) {
    $baslik = trim($_POST['baslik']);
    $icerik = trim($_POST['icerik']);
    $aciklama = trim($_POST['aciklama']);
    $etiket = trim($_POST['etiket']);
    $link = trim($_POST['link']);
    $kategori = trim($_POST['kategori']);
    $resim = trim($_POST['resim']);
    $gir = $db->prepare("insert into icerik (baslik,icerik,aciklama,etiket,seo,kategori,resim) values(?,?,?,?,?,?,?)");
    $tamam = $gir->execute(array($baslik, $icerik, $aciklama, $etiket, $link, $kategori, $resim));
    echo $tamam ? 1 : 0;

}

if (isset($_POST['paketekle'])) {
    $bitis = date("Y-m-d H:i:s", strtotime("+30 day", strtotime(date("Y-m-d H:i:s"))));
    $kad = $_POST['kad'];
    $tur = $_POST['tur'];
    $gir = $db->prepare("insert into paket (kad,tur,bitis,say) values(?,?,?,?)");
    $gir->execute(array($kad, $tur, $bitis, 0));
}


if (isset($_POST['paketsil'])) {
    $sil = $_POST['id'];
    $s = $db->prepare("delete from paket where id='$sil'");
    $s->execute();
}


if (isset($_POST['uyesil'])) {
    $sil = $_POST['uyeid'];
    $silincek = $db->prepare("delete from uye where id='$sil'");
    $a = $silincek->execute();
    if ($a) {
        echo 1;
    }
}

if (isset($_POST['islemara'])) {
    $islemid = $_POST['islemid'];
    $sor = $db->query("select * from islemler where id='$islemid'");
    if ($sor->rowCount()) {
        $sor = $sor->fetch(PDO::FETCH_ASSOC);
        $baslama = $sor['baslangic'];
        $durum = $sor['durum'];
        if ($durum == 1) {
            $durum = "Tamamlandı";
        } else if ($durum == 2) {
            $durum = "Sırada";
        } else if ($durum == 3) {
            $durum = "İşleme Alındı";
        } else if ($durum == 4) {
            $durum = "İptal Edildi";
        }
        ?>
        <table class="arama" width="100%">
            <tr>
                <td align="center">İD</td>
                <td align="center">TARİH</td>
                <td align="center">ÜYE</td>
                <td>İŞLEM</td>
                <td align="center">FİYAT</td>
                <td align="left">Link</td>
                <td align="center">MİKTAR</td>
                <td align="center">Başlangıç</td>
                <td align="center">DURUM</td>
                <td align="center">GF</td>
            </tr>
            <tr>
                <td align="center"><?php echo $sor['id']; ?></td>
                <td align="center"><?php echo $sor['tarih']; ?></td>
                <td align="center"><?php echo $sor['uye_id']; ?></td>
                <td><?php echo $sor['tanim']; ?></td>
                <td align="center"><?php echo $sor['fiyat']; ?></td>
                <td align="left"><a href="<?php echo $sor['link']; ?>"
                                    target="_blank"><?php echo $sor['link']; ?></a></td>
                <td align="center"><?php echo $sor['miktar']; ?></td>
                <td align="center"><?php echo $baslama ?></td>
                <td align="center"><?php echo $durum ?></td>
                <td align="center"><?php echo $sor['gf']; ?></td>
            </tr>
        </table>

    <?php } else {
        echo "<p>Böyle bir işlem yok.</p>";
    }
}


if (isset($_POST['uyeodeme'])) {
    $islemid = $_POST['odemeara'];
    $sor = $db->query("select * from odeak where uye='$islemid'");
    if ($sor->rowCount()) {
        ?>
        <table class="arama" width="100%">
            <tr>
                <td align="center">İD</td>
                <td align="center">TARİH</td>
                <td align="center">ÜYE ID</td>
                <td align="center">YÖNTEM</td>
                <td align="center">MİKTAR</td>

            </tr>
            <?php
            foreach ($sor as $gel) {
                ?>

                <tr>
                    <td align="center"><?php echo $gel['id']; ?></td>
                    <td align="center"><?php echo $gel['tarih']; ?></td>
                    <td align="center"><?php echo $gel['uye']; ?></td>
                    <td align="center"><?php echo $gel['yontem']; ?></td>
                    <td align="center"><?php echo $gel['miktar']; ?></td>

                </tr>


            <?php } ?>
        </table>
    <?php } else {
        echo "<p>Böyle bir işlem yok.</p>";
    }
}

if (isset($_POST['uyeotosil'])) {
    $id = $_POST['id'];
    $sil = $db->prepare("delete from oto where id='$id'");
    $a = $sil->execute();
    if ($a) {
        echo 1;
    }
}

if (isset($_POST['duysil'])) {
    $sil = $db->prepare("delete from duyuru where id='{$_POST['id']}'");
    $sildi = $sil->execute();
    if ($sildi) {
        echo 1;
    }
}

if (isset($_POST['duyek'])) {
    $baslik = $_POST['duybas'];
    $icerik = $_POST['duyic'];
    $tarih = date("Y-m-d H:i:s");
    $ek = $db->prepare("insert into duyuru (baslik,icerik,tarih) values(?,?,?)");
    $ekle = $ek->execute(array($baslik, $icerik, $tarih));
    if ($ekle) {
        echo 1;
    }
}
if (isset($_POST['adminotoduz'])) {
    $id = $_POST['id'];
    $cek = $db->query("select * from adminoto where id='$id'");
    if ($cek->rowCount()) {
        foreach ($cek as $gel) {
            ?>
            <input type="text" name="seradi" value="<?php echo $gel['adi']; ?>" placeholder="Servis Adı">
            <input type="text" name="serfiyat" value="<?php echo $gel['fiyati']; ?>" placeholder="Geliş fiyatı">
            <input type="text" name="marketid" value="<?php echo $gel['marketid']; ?>" placeholder="Market ID">
            <a href="#" id="serkay" name="<?php echo $gel['id']; ?>">Servisi Kaydet</a>
            <script>
                $("#serkay").click(function (a) {
                    a.preventDefault();
                    var id = $(this).attr("name");
                    var seradi = $("input[name=seradi]").val();
                    var serfiyat = $("input[name=serfiyat]").val();
                    var marketid = $("input[name=marketid]").val();
                    //alert(seradi);
                    $.ajax({
                        type: "post",
                        url: "ajax.php",
                        data: {
                            "adserduz": 1,
                            "id": id,
                            "seradi": seradi,
                            "serfiyat": serfiyat,
                            "marketid": marketid
                        }, success: function (cevap) {
                            //alert(cevap);
                        }
                    })
                });
            </script>
            <?php
        }
    }
}
if (isset($_POST['adserduz'])) {
    $id = $_POST['id'];
    $seradi = $_POST['seradi'];
    $serfiyat = $_POST['serfiyat'];
    $marketid = $_POST['marketid'];
    $up = $db->prepare("update adminoto set adi=?, fiyati=?,marketid=? where id='$id'");
    $set = $up->execute(array($seradi, $serfiyat, $marketid));
    if ($set) {
        echo 1;
    }

}

if (isset($_POST['paketek'])) {
    $adi = $_POST['paketadi'];
    $pakid = $_POST['paketid'];
    $market = $_POST['marketid'];
    $gelf = $_POST['gelf'];
    $tur = $_POST['tur'];
    $miktar = $_POST['miktar'];
    $bol = $_POST['bol'];
    $dk = $_POST['dakika'];
    $gir = $db->prepare("insert into kesfet_ic (paket_id,adi,tur,marketid,fiyati,miktar,bol,dakika) values(?,?,?,?,?,?,?,?)");
    $gir = $gir->execute(array($pakid, $adi, $tur, $market, $gelf, $miktar, $bol, $dk));
    print_r($gir);
}

if (isset($_POST['psil'])) {
    $id = $_POST['id'];
    $sil = $db->prepare("delete from kesfet_ic where id='$id'");
    $tam = $sil->execute();
    if ($tam) {
        echo 1;
    }
}
if (isset($_POST['istam'])) {
    $id = $_POST['id'];
    $gun = $db->prepare("update tik set durum=1 where id='$id'");
    $gun->execute();
    $cek = $db->query("select * from tik where id='$id'");
    $cek = $cek->fetch(PDO::FETCH_ASSOC);
    $up = $db->prepare("update islemler set durum=1 where id='{$cek['s_id']}'");
    $up->execute();
}

if (isset($_POST['iptal'])) {
    ?>
    <div class="tabss"><a href="#" name="islemak">İşlem Akışı (Son 100)</a> <a  style="background:#ddd;" href="#" name="iptalak">İptal Edilenler</a></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
        <tr>
            <td align="center">İD</td>
            <td align="center">TARİH</td>
            <td align="center">ÜYE</td>
            <td>İŞLEM</td>
            <td align="center">FİYAT</td>
            <td align="left">Link</td>
            <td align="center">MİKTAR</td>
            <td align="center">Başlangıç</td>
            <td align="center">DURUM</td>
            <td align="center">GF</td>
        </tr>
        <div class="gelenler">
            <?php
            $islem = $db->query("select * from islemler where durum=4 order by id desc ");
            if ($islem->rowCount()) {
                $api = new Api();
                foreach ($islem as $is) {
                    $baslama = $is['baslangic'];
                    $durum = $is['durum'];
                    if ($durum == 1) {
                        $durum = "Tamamlandı";
                    } else if ($durum == 2) {
                        $durum = "Sırada";
                    } else if ($durum == 3) {
                        $durum = "İşleme Alındı";
                    } else if ($durum == 4) {
                        $durum = "İptal Edildi";
                    }
                    ?>
                    <tr>
                        <td align="center"><?php echo $is['id']; ?></td>
                        <td align="center"><?php echo $is['tarih']; ?></td>
                        <td align="center"><?php echo $is['uye_id']; ?></td>
                        <td><?php echo $is['tanim']; ?></td>
                        <td align="center"><?php echo $is['fiyat']; ?></td>
                        <td align="left"><a href="<?php echo $is['link']; ?>"
                                            target="_blank"><?php echo $is['link']; ?></a></td>
                        <td align="center"><?php echo $is['miktar']; ?></td>
                        <td align="center"><?php echo $baslama ?></td>
                        <td align="center"><?php echo $durum ?></td>
                        <td align="center"><?php echo $is['gf']; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </div>
        <script>
            $("a[name=islemak]").click(function () {
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{"islemak":1},success:function (cevap) {
                        $(".tumis").html(cevap);
                    }
                })
            });
            $("a[name=iptalak]").click(function () {
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{"iptal":1},success:function (cevap) {
                        $(".tumis").html(cevap);
                    }
                })
            });

        </script>
    </table>
    <?php
}
if (isset($_POST['islemak'])) {
    ?>
    <div class="tabss"><a style="background:#ddd;" href="#" name="islemak">İşlem Akışı (Son 100)</a> <a href="#" name="iptalak">İptal Edilenler</a></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
        <tr>
            <td align="center">İD</td>
            <td align="center">TARİH</td>
            <td align="center">ÜYE</td>
            <td>İŞLEM</td>
            <td align="center">FİYAT</td>
            <td align="left">Link</td>
            <td align="center">MİKTAR</td>
            <td align="center">Başlangıç</td>
            <td align="center">DURUM</td>
            <td align="center">GF</td>
        </tr>
        <div class="gelenler">
            <?php
            $islem = $db->query("select * from islemler order by id desc limit 100");
            if ($islem->rowCount()) {
                $api = new Api();
                foreach ($islem as $is) {
                    $baslama = $is['baslangic'];
                    $durum = $is['durum'];
                    if ($durum == 1) {
                        $durum = "Tamamlandı";
                    } else if ($durum == 2) {
                        $durum = "Sırada";
                    } else if ($durum == 3) {
                        $durum = "İşleme Alındı";
                    } else if ($durum == 4) {
                        $durum = "İptal Edildi";
                    }
                    ?>
                    <tr>
                        <td align="center"><?php echo $is['id']; ?></td>
                        <td align="center"><?php echo $is['tarih']; ?></td>
                        <td align="center"><?php echo $is['uye_id']; ?></td>
                        <td><?php echo $is['tanim']; ?></td>
                        <td align="center"><?php echo $is['fiyat']; ?></td>
                        <td align="left"><a href="<?php echo $is['link']; ?>"
                                            target="_blank"><?php echo $is['link']; ?></a></td>
                        <td align="center"><?php echo $is['miktar']; ?></td>
                        <td align="center"><?php echo $baslama ?></td>
                        <td align="center"><?php echo $durum ?></td>
                        <td align="center"><?php echo $is['gf']; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </div>
        <script>
            $("a[name=islemak]").click(function () {
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{"islemak":1},success:function (cevap) {
                        $(".tumis").html(cevap);
                    }
                })
            });
            $("a[name=iptalak]").click(function () {
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{"iptal":1},success:function (cevap) {
                        $(".tumis").html(cevap);
                    }
                })
            });

        </script>
    </table>
    <?php
}
?>
