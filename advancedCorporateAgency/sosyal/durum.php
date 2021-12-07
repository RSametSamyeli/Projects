<?php include 'ayar.php';
echo $gecmis=date("Y-m-d H-i-s",strtotime("-3 week"));
$bak=$db->query("select * from islemler where durum!=1 and durum!=4 and takip!='' and tarih>='$gecmis'");
if($bak->rowCount()){
    foreach($bak as $gel){
        $api = new Api();
        if($gel["takip"]!=""){
            $status = $api->status($gel['takip']);
            $durum=$status->status;
            echo "<pre>";
//            print_r($status);
            $baslama=$status->start_count;
            $bas=$db->query("update islemler set baslangic='$baslama' where id='{$gel['id']}'");
            if($durum=="Completed"){//Tamamlandı
                $guncelle=$db->query("update islemler set durum=1 where id={$gel['id']}");
            }else if($durum=="Pending"){//Sırada
                $guncelle=$db->query("update islemler set durum=2 where id={$gel['id']}");
            }else if($durum=="In progress" || $durum=="Processing"){//İşleme alındı
                $guncelle=$db->query("update islemler set durum=3 where id={$gel['id']}");
            }else if($durum=="Canceled"){//İptal Edildi
                $guncelle=$db->query("update islemler set durum=4 where id={$gel['id']}");
                // Buraya geri ödeme sistemi eklenecek
            }
        }
    }
}

?>