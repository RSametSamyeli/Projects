<?php session_start(); if($_SESSION['yonetim']!=""){ require_once '../ayar.php'; require_once 'header.php';?>
<body><?php require_once'left.php';?>
<div class="orta">
    <div class="kategoriler kategori">
        <h1>Yeni Servis Ekle</h1>
        <div class="servisekle">
            <select>
                <?php
                $servis=$db->query("select * from kategori order by adi asc");
                if($servis->rowCount()){
                    foreach ($servis as $ser){
                        ?>
                        <option id="<?php echo $ser['id'];?>"><?php echo $ser['adi'];?></option>
                        <?php
                    }
                }
                ?>
            </select>
            <input type="text" name="servisbaslik" placeholder="Servis Başlığı">
            <input type="text" name="fiyati" placeholder="Fiyatı">
            <input type="text" name="sure" placeholder="Süre(Orn:31 Gün)" disabled>
            <input type="text" name="marketid" placeholder="Market İD">
            <input type="text" name="min" placeholder="Minimum Satın Alma">
            <input type="text" name="max" placeholder="Maksimum Satın Alma">
            <input type="text" name="miktar" placeholder="Oto Miktar" disabled>
            <input type="text" name="orj" placeholder="Orjinal Fiyat" >
            <textarea id="aciklama" rows="20" name="aciklama" placeholder="Açıklama"></textarea>
            <a href="#" id="servisekle">Kaydet</a>

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
<?php require_once 'footer.php';}else {header("location:giris.php");}?>