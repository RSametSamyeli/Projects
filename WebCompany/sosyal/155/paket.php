<?php session_start();
if (isset($_SESSION['yonetim'])) {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <div class="pekle">
            <label for="kad">Kullanıcı Adı Giriniz</label>
            <input type="kad" name="kad">
            <select>
            <?php
            $cek = $db->query("select * from kesfet_paket order by id asc");
            if ($cek->rowCount()) {
                foreach ($cek as $c) {
                    ?>
                        <option id="<?php echo $c['id']?>"><?php echo $c['adi']?></option>
                    <?php
                }
            }
            ?>
            </select>
            <a href="#" name="pkaydet">Ekle</a>
        </div>
        <div class="paketler">
            <h1>Kullanıcılar</h1>
            <hr>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#6495ed">
                    <td>Kullanıcı Adı</td>
                    <td>Kalan Gün</td>
                    <td>Paket</td>
                    <td>Üye mi?</td>
                    <td>Say</td>
                    <td>Sil</td>
                </tr>
                <?php
                $tarih = date("Y-m-d H:i:s");
                $cek = $db->query("select * from paket where bitis>='$tarih'");
                if ($cek->rowCount()) {
                    foreach ($cek as $ce) {

                        ?>

                        <tr>
                            <td><?php echo $ce['kad']; ?></td>
                            <td><?php
                                $suan = strtotime(date("Y-m-d"));
                                $bitis = strtotime($ce['bitis']);
                                if ($bitis < $suan) {
                                    $son = "Bitti";
                                    echo $son;
                                } else {
                                    $son = ($bitis - $suan) / 86400;
                                    echo round($son) . " Gün";
                                }
                                ?></td>
                            <td>Paket <?php echo $ce['tur']; ?></td>
                            <td><?php echo $ce['uye_id']; ?></td>
                            <td><?php echo $ce['say']; ?></td>
                            <td><a href="#" id="<?php echo $ce['id']; ?>" name="psil">Sil</a></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>

            <div class="pakets">
                <h1>Paket Ürünler</h1>
                <div class="pa">
                    <?php
                    $cek = $db->query("select * from kesfet_paket order by id asc");
                    if ($cek->rowCount()) {
                        foreach ($cek as $ce) {
                            ?>
                            <h4><?php echo $ce['adi'] ?></h4>
                            <?php
                            $be = $db->query("select * from kesfet_ic where paket_id='{$ce['id']}'");
                            if ($be->rowCount()) {
                                ?>
                                <table cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>Servis Adı</td>
                                    <td>Türü</td>
                                    <td>Market İD</td>
                                    <td>Geliş Fiyatı</td>
                                    <td>Miktar</td>
                                    <td>Böl</td>
                                    <td>Dakika</td>
                                    <td>Sil</td>
                                </tr>
                                <?php
                                foreach ($be as $b) {
                                    ?>

                                    <tr>
                                        <td><?php echo $b['adi'] ?></td>
                                        <td><?php echo $b['tur'] ?></td>
                                        <td><?php echo $b['marketid'] ?></td>
                                        <td><?php echo $b['fiyati'] ?></td>
                                        <td><?php echo $b['miktar'] ?></td>
                                        <td><?php echo $b['bol'] ?></td>
                                        <td><?php echo $b['dakika'] ?></td>
                                        <td><span name="psil" id="<?php echo $b['id'] ?>">Sil</span></td>
                                    </tr>

                                    <?
                                }
                            }
                            ?>
                            </table>
                            <a href="#eklep" id="icek" name="<?php echo $ce['id']; ?>">Ekle</a>
                            <?
                        }
                    }
                    ?>
                </div>
                <script>
                    $("span[name=psil]").click(function () {
                        var id = $(this).attr("id");
                        $.ajax({
                            type: "post",
                            url: "ajax.php",
                            data: {
                                "psil": 1,
                                "id": id
                            }, success: function (cevap) {
                                if (cevap.trim() == 1) {
                                    alert("Silindi");
                                    window.location.reload();
                                }
                            }
                        })
                    })
                </script>
                <div class="eklep" id="eklep">
                    <h4>Pakete içerik ekle</h4>
                    <input type="text" name="marketid" placeholder="Market İD">
                    <input type="text" name="paketadi" placeholder="Adı">
                    <input type="text" name="gelf" placeholder="Geliş Fiyatı">
                    <input type="text" name="tur" placeholder="Türü (beğeni/kaydet=1, video=2)">
                    <input type="text" name="miktar" placeholder="Miktar">
                    <input type="text" name="bol" placeholder="Kısmi Gönder">
                    <input type="text" name="dakika" placeholder="Kaç dakikada bir çalışacak?">
                    <a href="#" name="ekle">Ekle</a>
                </div>
            </div>
            <script>
                var paket = 1;
                $("a#icek").click(function (a) {
                    paket = $(this).attr("name");
                    $(".eklep").show();

                });
                $("a[name=ekle]").click(function (a) {
                    a.preventDefault();
                    var adi = $("input[name=paketadi]").val();
                    var gelf = $("input[name=gelf]").val();
                    var marketid = $("input[name=marketid]").val();
                    var tur = $("input[name=tur]").val();
                    var miktar = $("input[name=miktar]").val();
                    var bol = $("input[name=bol]").val();
                    var dakika = $("input[name=dakika]").val();
                    $.ajax({
                        type: "post",
                        url: "ajax.php",
                        data: {
                            "paketek": 1,
                            "paketid": paket,
                            "paketadi": adi,
                            "marketid": marketid,
                            "gelf": gelf,
                            "tur": tur,
                            "bol": bol,
                            "dakika": dakika,
                            "miktar": miktar
                        }, success: function (cevap) {
                            if (cevap.trim() == 1) {
                                window.location.reload();
                            }
                        }
                    })

                });
            </script>
        </div>
    </div>
    </body>
    <script>
        $("a[name=pkaydet]").click(function () {
            var kad = $("input[name=kad]");
            var tur = $(".pekle option:selected").attr("id");
            $.ajax({
                type: "post",
                url: "ajax.php",
                data: {
                    "paketekle": 1,
                    "kad": kad.val(),
                    "tur": tur
                }, success: function (cevap) {
                    window.location.reload();
                }
            })
        });
        $("a[name=psil]").click(function () {
            var id = $(this).attr("id");
            $.ajax({
                type: "post",
                url: "ajax.php",
                data: {
                    "paketsil": 1,
                    "id": id
                }, success: function (cevap) {
                    window.location.reload();
                }
            })
        });
    </script>

    <?php require_once 'footer.php';
} else {
    header("location:giris.php");
} ?>