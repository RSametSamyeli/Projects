<?php session_start();
if ($_SESSION['yonetim'] != "") {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <div class="kategoriler servis">
            <div class="serduz">
                <h1>Servis Düzenle</h1>
                <div class="serduzinput">
                </div>
                <a href="#" id="serduzkaydet">Kaydet</a>
            </div>
            <div class="yeni">
                <div class="tablo tabs">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="tabbas">
                            <td width="25%">Adı</td>
                            <td align="center" style="text-align: center" width="100px">Fiyatı</td>
                            <td width="20%">Açıklama</td>
                            <td align="center" width="50px">Süre</td>
                            <td align="center" width="100px">Market İD</td>
                            <td align="center" width="50px">Min</td>
                            <td align="center" width="50px">Max</td>
                            <td align="center" width="50px">Miktar</td>
                            <td align="center" width="50px">Orjinal</td>
                            <td align="center" width="50px">Düzenle</td>
                            <td align="center" width="50px">Sil</td>
                        </tr>
                        <?php
                        $katsor = $db->query("select * from kategori order by adi desc");
                        if ($katsor->rowCount()) {
                            foreach ($katsor as $kat) {
                                ?>
                                <tr>
                                    <td style='background: #eee ' colspan="11"><?php echo $kat['adi'] ?></td>
                                </tr>
                                <?php
                                $servis = $db->query("select * from servis where kategori_id='{$kat['id']}' order by adi asc");
                                if ($servis->rowCount()) {
                                    foreach ($servis as $gelen) {
                                        ?>
                                        <tr>
                                            <td><?php echo $gelen['adi']; ?></td>
                                            <td align="center"><?php echo $gelen['fiyati']; ?></td>
                                            <td><?php echo nl2br($gelen['aciklama']); ?></td>
                                            <td align="center"><?php echo $gelen['sure']; ?></td>
                                            <td align="center"><?php echo $gelen['marketid']; ?></td>
                                            <td align="center"><?php echo $gelen['mini']; ?></td>
                                            <td align="center"><?php echo $gelen['maks']; ?></td>
                                            <td align="center"><?php echo $gelen['miktar']; ?></td>
                                            <td align="center"><?php echo $gelen['orj']; ?></td>
                                            <td><a href="#" name="serduzenle"
                                                   id="<?php echo $gelen['id']; ?>">Düzenle</a></td>
                                            <td><a href="#" name="sersil" id="<?php echo $gelen['id']; ?>">Sil</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>


        </div>
    </div>
    </body>
    <?php require_once 'footer.php';
} else {
    header("location:giris.php");
} ?>