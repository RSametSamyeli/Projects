<?php session_start();
if (isset($_SESSION['yonetim'])) {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <h1>Paket Ürünler</h1>
        <div class="pakets">
            <div class="pa">
                <h4>Paket 1</h4>
                    <p>[820][BEĞENİ][750 ADET] </p>
                    <p>[764][BEĞENİ][50 ADET]</p>
                    <p>[888][BEĞENİ][50 ADET]</p>
                    <p>[836][KAYDET][20 ADET]</p>
                    <p>[765][VİDEO][300 ADET]</p>
                    <p>[794][VİDEO][300 ADET]</p>
                    <p>[861][VİDEO][300 ADET]</p>
                    <p>[860][VİDEO][300 ADET]</p>
					<b>B: 0,032 V: 0,09 BV: 0,122</b>
            </div>
            <div class="pa">
                <h4>Paket 2</h4>
                <p>[820][BEĞENİ][1500 ADET] </p>
                <p>[764][BEĞENİ][100 ADET]</p>
                <p>[888][BEĞENİ][100 ADET]</p>
                <p>[836][KAYDET][100 ADET]</p>
                <p>[765][VİDEO][500 ADET]</p>
                <p>[794][VİDEO][500 ADET]</p>
                <p>[861][VİDEO][500 ADET]</p>
                <p>[860][VİDEO][500 ADET]</p>
				<b>B: 0,033 V: 0,15 BV: 0,183</b>
            </div>
            <div class="pa">
                <h4>Paket 3</h4>
                <p>[820][BEĞENİ][2500 ADET] </p>
                <p>[764][BEĞENİ][150 ADET]</p>
                <p>[888][BEĞENİ][150 ADET]</p>
                <p>[836][KAYDET][300 ADET]</p>
                <p>[765][VİDEO][1000 ADET]</p>
                <p>[794][VİDEO][1000 ADET]</p>
                <p>[861][VİDEO][1000 ADET]</p>
                <p>[860][VİDEO][500 ADET]</p>
				<b>B: 0,1345 V: 0,25 BV: 0,3845</b>
            </div>
        </div>
        <div class="pekle">
            <label for="kad">Kullanıcı Adı Giriniz</label>
            <input type="kad" name="kad">
            <select>
                <option id="1">Paket 1</option>
                <option id="2">Paket 2</option>
                <option id="3">Paket 3</option>
            </select>
            <a href="#" name="pkaydet">Ekle</a>
        </div>
        <div class="paketler">
            <h1>Kullanıcılar</h1>
            <hr>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                <tr  bgcolor="#6495ed">
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
                            <td><?php echo $ce['kad'];?></td>
                            <td><?php
                                $suan = strtotime(date("Y-m-d"));
                                $bitis = strtotime($ce['bitis']);
                                if($bitis<$suan){
                                    $son="Bitti";
                                    echo $son;
                                }else {
                                    $son = ($bitis - $suan) / 86400;
                                    echo round($son) . " Gün";
                                }
                                ?></td>
                            <td>Paket <?php echo $ce['tur'];?></td>
                            <td><?php echo $ce['uye_id'];?></td>
                            <td><?php echo $ce['say'];?></td>
                            <td><a href="#" id="<?php echo $ce['id']; ?>" name="psil">Sil</a></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
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