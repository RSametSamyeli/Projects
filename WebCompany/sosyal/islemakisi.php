<?php session_start();
if ($_SESSION['yonetim'] != "") {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <div class="sec">
            <h1>Tarih aralığı</h1>
            <input type="date" name="tarih1" value="<?php echo date("Y-m-"); ?>01"><input name="tarih2" type="date"
                                                                                          value="<?php echo date("Y-m-d", (strtotime(date("Y-m-d"))) + 86400) ?>">
            <a href="#" id="getir">Getir</a>
        </div>
        <script>
            $("#getir").click(function () {
                $('.tumis table tr:not(:first-child)').remove();
                var tarih1 = $("input[name=tarih1]");
                var tarih2 = $("input[name=tarih2]");
                //alert(tarih1.val());
                //alert(tarih2.val());
                var toplamfiyat = 0;
                var gider = 0;
                $.ajax({
                    type: "post",
                    url: "ajax.php",
                    data: {"tarih": 1, "tarih1": tarih1.val(), "tarih2": tarih2.val()},
                    success: function (cevap) {
                        // alert(cevap);
                        var json = cevap;
                        for (var i = 0; i < json.length; ++i) {
                            $('.tumis table').append(
                                '<tr><td align="center">'
                                + json[i].id +
                                '</td><td align="center">'
                                + json[i].tarih +
                                '</td><td align="center">'
                                + json[i].uye_id +
                                '</td><td>'
                                + json[i].aciklama +
                                '</td><td align="center">'
                                + json[i].fiyat +
                                '</td><td align="left"><a href="' + json[i].link + '"target="_blank">' + json[i].link + '</a></td><td align="center">'
                                + json[i].miktar +
                                '</td><td>'
                                + json[i].baslangic +
                                '</td><td>'
                                + json[i].durum +
                                '</td><td align="center">'
                                + json[i].gf + '</td></tr>');
                            toplamfiyat += parseFloat(json[i].fiyat);
                            if (json[i].gf != "") {
                                gider += parseFloat(json[i].gf);
                            }
                            //alert(gider);
                            // alert(toplamfiyat);

                        }
                        $("#toplamfiyat").html(Math.round(toplamfiyat) + " ₺");
                        $("#gider").html(Math.round(gider) + " $");
                        $("#toplamislem").html(json.length + " Adet");

                    }
                });
            });
        </script>
        <div class="sec">
            <h1>Aylık İstatistikler</h1>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <?php
                    $toplam = 0;
                    $gider = 0;
                    $isler = 0;
                    $tar = date("Y-m-1 00:00:00");
                    $isyuku = $db->query("select * from islemler where tarih>'$tar'");
                    if ($isyuku->rowCount()) {
                        foreach ($isyuku as $iss) {
                            $toplam += $iss['fiyat'];
                            $gider += $iss['gf'];
                            $isler++;
                        }
                    }
                    ?>
                    <td>Bu ay toplam harcama</td>
                    <td id="toplamfiyat"><?php echo round($toplam, 2) ?> ₺</td>
                </tr>
                <tr>
                    <td>Toplam İşlem Alımı</td>
                    <td id="toplamislem"><?php echo $isler; ?> Adet</td>
                </tr>
                <tr>
                    <td>Gider</td>
                    <td id="gider"><?php echo round($gider, 2); ?> $</td>
                </tr>
            </table>
        </div>

        <div class="ara">
            <h1>İşlem Ara</h1>
            <input type="text" id="islemara" placeholder="İşlem İD giriniz.">
            <span></span>
        </div>

        <script>
            $("#islemara").keyup(function () {
                var islemid = $(this).val();
                $.ajax({
                    type: "post",
                    url: "ajax.php",
                    data: {
                        "islemara": 1,
                        "islemid": islemid
                    }, success:function (cevap) {
                       $(".ara span").html(cevap);
                    }
            })
            })
        </script>

        <div class="tumis">  <h1>İşlem Akışı (Son 100)</h1>

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
//                            if($is["takip"]!=""){
////                            $status = $api->status($is['takip']);
////                            $durum=$status->status;
////                            $baslama=$status->start_count;
////                            }else {
////                                $durum="";
////                                $baslama="";
//                            }
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
            </table>
        </div>

    </div>

    </body>
    <?php require_once 'footer.php';
} else {
    header("location:giris.php");
} ?>