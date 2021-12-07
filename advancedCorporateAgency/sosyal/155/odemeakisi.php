<?php session_start();
if ($_SESSION['yonetim'] != "") {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <div class="sec ode">
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
                    data: {"odetarih": 1, "tarih1": tarih1.val(), "tarih2": tarih2.val()},
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
                                '</td><td align="center">'
                                + json[i].aciklama +
                                '</td><td align="center">'
                                + json[i].fiyat +
                                '</td></tr>');
                        }
                    }
                });
            });
        </script>
        <div class="ara">
            <h1>ÜYE ÖDEMELERİ</h1>
            <input type="text" id="islemara" placeholder="ÜYE İD GİRİNİZ">
            <span></span>
        </div>

        <script>
            $("#islemara").keyup(function () {
                var islemid = $(this).val();
                $.ajax({
                    type: "post",
                    url: "ajax.php",
                    data: {
                        "uyeodeme": 1,
                        "odemeara": islemid
                    }, success: function (cevap) {
                        $(".ara span").html(cevap);
                    }
                })
            })
        </script>

        <div class="tumis"><h1>ÖDEME AKIŞI (Son 100)</h1>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center">İD</td>
                    <td align="center">TARİH</td>
                    <td align="center">ÜYE</td>
                    <td align="center">YÖNTEM</td>
                    <td align="center">MİKTAR</td>
                </tr>
                <div class="gelenler">
                    <?php
                    $islem = $db->query("select * from odeak order by id desc limit 100");
                    if ($islem->rowCount()) {
                        $api = new Api();
                        foreach ($islem as $is) {
                            ?>
                            <tr>
                                <td align="center"><?php echo $is['id']; ?></td>
                                <td align="center"><?php echo $is['tarih']; ?></td>
                                <td align="center"><?php echo $is['uye']; ?></td>
                                <td align="center"><?php echo $is['yontem']; ?></td>
                                <td align="center"><?php echo $is['miktar']; ?></td>

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