<?php session_start();
if (isset($_SESSION['yonetim'])) {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <table class="tik" cellpadding="0" cellspacing="0" border="0">
            <tr class="tabbas">
                <td>Sipariş Tarihi</td>
                <td>Üye - Üye İD</td>
                <td>Link / Kullanıcı Adı</td>
                <td>Sipariş Tanımı</td>
                <td>Fiyatı</td>
                <td align="center">Durumu</td>
            </tr>

       <?php
       $cek=$db->query("select * from tik where durum=0");
       if($cek->rowCount()){
           foreach($cek as $ce){
               ?>
               <tr>
                   <td><?php echo $ce['tarih']?></td>
                   <td><?php echo $ce['uye_id']." - ".$ce['uye']?></td>
                   <td><?php echo $ce['kad']?></td>
                   <td><?php echo $ce['siparis']?></td>
                   <td><?php echo $ce['fiyati']?></td>
                   <td align="center"><a href="#" id="<?php echo $ce['id']?>" name="tamamla">Tamamla</a></td>
               </tr>
               <?php
           }
       }
       ?>

        </table>
    </div>
    <script>
        $("a[name=tamamla]").click(function (a) {
            a.preventDefault();
            var id=$(this).attr("id");
            if (confirm('Bu işlemi tamamlamak istiyor musunuz?')) {
                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{
                        "istam":1,
                        "id":id
                    },success:function (cevap) {
                        window.location.reload();
                    }
                })
            }
        })
    </script>
    </body>
    <?php require_once 'footer.php';
} else {
    header("location:giris.php");
} ?>