<?php session_start(); ?>
<head>
    <meta name="robots" content="nofollow,noindex">
</head>
<?php include 'ayar.php';
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

?>
<style>
    body {
        margin: 0;
        padding: 0;
        color: #555;
        background: #eee;
    }

    table td {
        color: #eeeeee;
        padding: 10px 10px;
        border-bottom: 1px solid #ccc;
    }
</style>
<?php if (isset($_SESSION['yonetim'])){ ?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr style="color:#eee;background:#222; font-weight: bold">
        <td>Link</td>
        <td>Code</td>
        <td>Miktar</td>
        <td>İD</td>
        <td>Tip</td>
    </tr>
    <?php
    }
    //$bekle=rand(0,1);
    $bekle = 0;
    $tarih = date("Y-m-d");
    // ----------------------------------------------- OTO BEĞENİ -------------------------------------------------------------
    $oto = $db->query("select * from oto inner join servis on oto.servis_id=servis.id where kat_id='4' and (bitis>='$tarih')");
    if ($oto->rowCount()) {
        foreach ($oto as $gelen) {
            $link = $gelen['link'];
            $link = "https://www.instagram.com/" . linkkontrol($link) . "/";
            $insta = veri($link);
            $kes = explode('window._sharedData = ', $insta);
            $ayir = explode(';</script>', $kes[1]);
            $array = json_decode($ayir[0], true);
            $kisim = $array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'][0]['node'];
            $code = $kisim['shortcode'];
            $videomu = $kisim['is_video'];
            if ($code != $gelen['son'] && $code != "") {
                if (isset($_SESSION['yonetim'])) {
                    ?>
                    <tr bgcolor="#3a5471">
                        <td><?php echo $link ?></td>
                        <td><?php echo $code ?></td>
                        <td><?php echo $gelen['miktar'] ?></td>
                        <td><?php echo $gelen['marketid'] ?></td>
                        <td><?php echo $videomu; ?></td>
                    </tr>
                    <?php
                }
                $photo = "https://www.instagram.com/p/" . $code . "/";
                $api = new Api();
                $services = $api->services();
                $gelmik = $gelen['miktar'];
                if ($gelmik >= 100 && $gelmik <= 200) {
                    $bol = 2;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else if ($gelmik > 200 && $gelmik <= 300) {
                    $bol = 4;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else if ($gelmik > 300 && $gelmik <= 400) {
                    $bol = 6;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else if ($gelmik > 400 && $gelmik <= 500) {
                    $bol = 8;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else if ($gelmik > 500 && $gelmik <= 600) {
                    $bol = 10;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else if ($gelmik > 600 && $gelmik <= 700) {
                    $bol = 14;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else if ($gelmik > 700 && $gelmik <= 800) {
                    $bol = 16;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else if ($gelmik > 800 && $gelmik <= 999) {
                    $bol = 18;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else if ($gelmik >= 1000) {
                    $bol = 20;
                    $miktar = $gelmik / $bol;
                    $miktar = round($miktar);
                } else {
                    $miktar = $gelmik;
                }
                if ($gelen['miktar'] < 100) {
                    $order = $api->order(array('service' => $gelen['marketid'], 'link' => $photo, 'quantity' => $gelen['miktar']));
                } else {
                    $order = $api->order(array('service' => $gelen['marketid'], 'link' => $photo, 'quantity' => $miktar, 'runs' => $bol, 'interval' => 7));
                }
                $status = $api->status($order->order);
                $sonfoto = $db->prepare("update oto set son='$code' where id='$gelen[0]'");
                $sonfoto->execute();

            } else {
                sleep($bekle);
                if (isset($_SESSION['yonetim'])) {
                    ?>
                    <tr bgcolor="#55141a">
                        <td><?php echo $link ?></td>
                        <td><?php echo $code ?></td>
                        <td><?php echo $gelen['miktar'] ?></td>
                        <td><?php echo $gelen['marketid'] ?></td>
                        <td><?php echo $videomu; ?></td>
                    </tr>
                    <?php
                }
            }
        }
    }
    // ----------------------------------------------- OTO VİDEO -------------------------------------------------------------
    $oto = $db->query("select * from oto inner join servis on oto.servis_id=servis.id where kat_id='5' and (bitis>='$tarih')");
    if ($oto->rowCount()) {
        foreach ($oto as $gelen) {
            $link = $gelen['link'];
            $link = "https://www.instagram.com/" . linkkontrol($link) . "/";
            $insta = veri($link);
            $kes = explode('window._sharedData = ', $insta);
            $ayir = explode(';</script>', $kes[1]);
            $array = json_decode($ayir[0], true);
            $kisim = $array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'][0]['node'];
            $code = $kisim['shortcode'];
            $videomu = $kisim['is_video'];

            if ($code != $gelen['son'] && $code != "" && $videomu == 1) {
                if (isset($_SESSION['yonetim'])) {
                    ?>
                    <tr bgcolor="#3a5471">
                        <td><?php echo $link ?></td>
                        <td><?php echo $code ?></td>
                        <td><?php echo $gelen['miktar'] ?></td>
                        <td><?php echo $gelen['marketid'] ?></td>
                        <td><?php echo $videomu; ?></td>
                    </tr>

                    <?php
                }
                $photo = "https://www.instagram.com/p/" . $code . "/";
                $api = new Api();
                $services = $api->services();
                $order = $api->order(array('service' => $gelen['marketid'], 'link' => $photo, 'quantity' => $gelen['miktar']));
                $status = $api->status($order->order);
                $sonfoto = $db->prepare("update oto set son='$code' where id='$gelen[0]'");
                $sonfoto->execute();

            } else {
                sleep($bekle);
                if (isset($_SESSION['yonetim'])) {
                    ?>
                    <tr bgcolor="#55141a">
                        <td><?php echo $link ?></td>
                        <td><?php echo $code ?></td>
                        <td><?php echo $gelen['miktar'] ?></td>
                        <td><?php echo $gelen['marketid'] ?></td>
                        <td><?php echo $videomu; ?></td>
                    </tr>
                    <?php
                }
            }
        }
    }
    // ----------------------------------------------- OTO BEĞENİ ADMİN -------------------------------------------------------------
    $oto = $db->query("select * from adminotolar inner join adminoto on adminotolar.servis=adminoto.id where bitis>='$tarih'");
    if ($oto->rowCount()) {
        foreach ($oto as $gelen) {
            $link = $gelen['kad'];
            $link = "https://www.instagram.com/" . linkkontrol($link) . "/";
            $insta = veri($link);
            $kes = explode('window._sharedData = ', $insta);
            $ayir = explode(';</script>', $kes[1]);
            $array = json_decode($ayir[0], true);
            $kisim = $array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'][0]['node'];
            $code = $kisim['shortcode'];
            $videomu = $kisim['is_video'];
            if ($gelen['servis'] == 2 or $gelen['servis'] == 1 or $gelen['servis'] == 4) {
                if ($code != $gelen['son'] && $code != "") {
                    if (isset($_SESSION['yonetim'])) {
                        ?>
                        <tr style="background:#008722;">
                            <td><?php echo $link ?></td>
                            <td><?php echo $code ?></td>
                            <td><?php echo $gelen['miktar'] ?></td>
                            <td><?php echo $gelen['marketid'] ?></td>
                            <td>Fotoğraf Gidecek</td>
                        </tr>
                        <?php
                    }
                    $photo = "https://www.instagram.com/p/" . $code . "/";
                    $sonfoto = $db->prepare("update adminotolar set son='$code',sinir=sinir-1  where id='$gelen[0]'");
                    $sonfoto->execute();
                    $api = new Api();
                    $services = $api->services();
                    $gelmik = $gelen['miktar'];
                    if ($gelmik >= 100 && $gelmik <= 200) {
                        $bol = 2;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else if ($gelmik > 200 && $gelmik <= 300) {
                        $bol = 4;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else if ($gelmik > 300 && $gelmik <= 400) {
                        $bol = 6;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else if ($gelmik > 400 && $gelmik <= 500) {
                        $bol = 8;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else if ($gelmik > 500 && $gelmik <= 600) {
                        $bol = 10;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else if ($gelmik > 600 && $gelmik <= 700) {
                        $bol = 14;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else if ($gelmik > 700 && $gelmik <= 800) {
                        $bol = 16;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else if ($gelmik > 800 && $gelmik <= 999) {
                        $bol = 18;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else if ($gelmik >= 1000) {
                        $bol = 20;
                        $miktar = $gelmik / $bol;
                        $miktar = round($miktar);
                    } else {
                        $miktar = $gelmik;
                    }
                    if ($gelen['miktar'] < 100) {
                        $order = $api->order(array('service' => $gelen['marketid'], 'link' => $photo, 'quantity' => $gelen['miktar']));
                    } else {
                        $order = $api->order(array('service' => $gelen['marketid'], 'link' => $photo, 'quantity' => $miktar, 'runs' => $bol, 'interval' => 7));
                    }
                    $status = $api->status($order->order);
                } else {
                    sleep($bekle);
                    if (isset($_SESSION['yonetim'])) {
                        ?>
                        <tr style="background:#f56a44;">
                            <td><?php echo $link ?></td>
                            <td><?php echo $code ?></td>
                            <td><?php echo $gelen['miktar'] ?></td>
                            <td><?php echo $gelen['marketid'] ?></td>
                            <td>Fotoğraf Gitmiş</td>
                        </tr>
                        <?php
                    }
                }
            } else {
                if ($videomu == 1) {
                    if ($code != $gelen['son'] && $code != "") {
                        if (isset($_SESSION['yonetim'])) {
                            ?>
                            <tr style="background:#008722;">
                                <td><?php echo $link ?></td>
                                <td><?php echo $code ?></td>
                                <td><?php echo $gelen['miktar'] ?></td>
                                <td><?php echo $gelen['marketid'] ?></td>
                                <td>Video gidecek</td>
                            </tr>
                            <?php
                        }
                        $photo = "https://www.instagram.com/p/" . $code . "/";
                        $sonfoto = $db->prepare("update adminotolar set son='$code',sinir=sinir-1 where id='$gelen[0]'");
                        $sonfoto->execute();
                        $api = new Api();
                        $services = $api->services();
                        $order = $api->order(array('service' => $gelen['marketid'], 'link' => $photo, 'quantity' => $gelen['miktar']));
                        $status = $api->status($order->order);


                    } else {
                        sleep($bekle);
                        if (isset($_SESSION['yonetim'])) {
                            ?>
                            <tr style="background:#f56a44;">
                                <td><?php echo $link ?></td>
                                <td><?php echo $code ?></td>
                                <td><?php echo $gelen['miktar'] ?></td>
                                <td><?php echo $gelen['marketid'] ?></td>
                                <td>Video ama gitmiş</td>
                            </tr>
                            <?php
                        }
                    }
                } else {
                    sleep($bekle);
                    if (isset($_SESSION['yonetim'])) {
                        ?>
                        <tr style="background:#1c3773;">
                            <td><?php echo $link ?></td>
                            <td><?php echo $code ?></td>
                            <td><?php echo $gelen['miktar'] ?></td>
                            <td><?php echo $gelen['marketid'] ?></td>
                            <td>Video Değil</td>
                        </tr>
                        <?php
                    }
                }
            }
        }
    }
    ?>
</table>
<br>
<hr>

