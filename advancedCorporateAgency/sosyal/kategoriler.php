<?php session_start(); if(isset($_SESSION['yonetim'])){require_once '../ayar.php'; require_once 'header.php';?>
    <body><?php require_once'left.php';?>
    <div class="orta">
        <div class="kategoriler kategori">
            <div class="yeni">
                <div class="katduzenle">
                    <h1>Kategori Düzenle</h1>
                    <div id="inputs"></div>
                    <a href="#" id="katduz">Güncelle</a>
                </div>
                <div class="katekle">
                    <h1>Yeni Kategori Ekle</h1>
                    <input type="text" name="yenikat" placeholder="Kategori Adı (Youtube, İnstagram, Google vb...)">
                    <a href="#" id="katkaydet">Ekle</a>
                </div>
            </div>
            <div class="yeni">
                <div class="tablo">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="tabbas" >
                            <td>Kategori İD</td>
                            <td>Kategori Adı</td>
                            <td width="10%">Düzenle</td>
                            <td width="5%">Sil</td>
                        </tr>
                        <?php
                        $kat=$db->query("select * from kategori order by id desc");
                        if($kat->rowCount()){
                            foreach($kat as $kate){
                                ?>
                                <tr>
                                    <td><?php echo $kate['id'];?></td>
                                    <td><?php echo $kate['adi'];?></td>
                                    <td width="10%"><a href="#" name="duzenle" id="<?php echo $kate['id'];?>">Düzenle</a></td>
                                    <td width="5%"><a href="#" name="katsil" id="<?php echo $kate['id'];?>">Sil</a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>
    </body>
    <script>
        // $(document).ready(function () {
        //     var id=$("select option:selected").attr('id');
        //     $.ajax({
        //         type:"post"
        //         url:"ajax.php",
        //         data:{"servis":id},
        //         success:function (cevap) {
        //             alert(cevap);
        //         }
        //     })
        // });
    </script>
<?php require_once 'footer.php'; }else {header("location:giris.php");}?>