<?php 
include 'ayar.php';
function veri($url)
{ //İnsta Son Foto Fonksiyon
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)");
    $gelen = curl_exec($curl);
    curl_close($curl);
    return $gelen;
}
function linkkontrol($kontrol)
{
    $linkpar = str_replace(
        array('/', 'https', 'www.', 'instagram.com', '/', ':')
        , array('', '', '', '', '', '', ''), $kontrol);
    return trim($linkpar);
}
$suan=date("Y-m-d H:i:s");
$cek = $db->query("select * from paket where bitis>'$suan'");
if ($cek->rowCount()) {
    foreach ($cek as $gelen) {
        echo $gelen['kad']."--";
        $link = $gelen['kad'];
        $link = "https://www.instagram.com/" . linkkontrol($link) . "/";
		echo $link."--";
        $insta = veri($link);
        $kes = explode('window._sharedData = ', $insta);
        $ayir = explode(';</script>', $kes[1]);
        $array = json_decode($ayir[0], true);
        $kisim = $array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'][0]['node'];
        $code = $kisim['shortcode'];
		echo $code."--";
        $videomu = $kisim['is_video'];
		echo $videomu."--";
        $photo = "https://www.instagram.com/p/".$code."/";
		echo $photo."--";
        if ($code != $gelen['son'] and isset($code)) {
            echo "GİTTİ<BR>";
            $pa = $db->query("select * from kesfet_ic where paket_id='{$gelen['tur']}' and tur='1'");
            if ($pa->rowCount()) {
                $api = new Api();
                $services = $api->services();
                foreach ($pa as $p) {
                    if ($p['bol'] != 0) {
                      $bol = $p['miktar'] / $p['bol'];
                      $order = $api->order(array('service' => $p['marketid'], 'link' => $photo, 'quantity' => $bol, 'runs' => $p['bol'], 'interval' => $p['dakika']));
					  $status = $api->status($order->order);
					   //print_r($status);

                    } else {
                       $order = $api->order(array('service' => $p['marketid'], 'link' => $photo, 'quantity' => $p['miktar']));
					         $status = $api->status($order->order);
                    }
                }
            }
            if ($videomu) {
                echo "VİDEO GİTTİ<br>";
                $va = $db->query("select * from kesfet_ic where paket_id='{$gelen['tur']}' and tur='2'");
                if ($va->rowCount()) {
                    $api = new Api();
                    $services = $api->services();
                    foreach ($va as $v) {
                        if ($v['bol'] != 0) {
                            $bol = $v['miktar'] / $v['bol'];
                            $order = $api->order(array('service' => $v['marketid'], 'link' => $photo, 'quantity' => $bol, 'runs' => $v['bol'], 'interval' => $v['dakika']));
                            $status = $api->status($order->order);
                        } else {
                            $order = $api->order(array('service' => $v['marketid'], 'link' => $photo, 'quantity' => $v['miktar']));
                            $status = $api->status($order->order);
                        }
                    }
                }
            }else {
                echo "VİDEO DEĞİL<br>";
            }
            $sonfoto = $db->prepare("update paket set son='$code', say=say+1 where id='{$gelen['id']}'");
            $aa=$sonfoto->execute();
            echo "SON GÜNCELLENDİ<br>";
        
		sleep(7);
		}else {
            echo " - NO <br>";
				sleep(7);
        }
    }
}
?>