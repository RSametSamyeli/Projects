<?php session_start();
if (isset($_SESSION['yonetim'])) {
    require_once '../ayar.php';
    require_once 'header.php'; ?>
    <body><?php require_once 'left.php'; ?>
    <div class="orta">
        <div class="hesap">
            <div class="sec">
                <h1>Tarih aralığı</h1>
                <input type="date" name="tarih1" value="<?php echo date("Y-m-"); ?>01"><input name="tarih2" type="date" value="<?php echo date("Y-m-d",(strtotime(date("Y-m-d")))+86400) ?>">
                <a href="#" id="getir">Getir</a>
            </div>
            <div class="sec">
                <h1>Hesap Kitap</h1>
            <table>
                <?php
                $say=$db->query("select * from adminotolar");
                $aktif=0;
                $pasif=0;
                $masraf=0;
                $topal=0;
                if($say->rowCount()) {
                    foreach ($say as $sayi) {
                        $masraf+=$sayi['masraf'];
                        $topal+=$sayi['alinan'];
                        $suan = strtotime(date("Y-m-d"));
                        $bitis = strtotime($sayi['bitis']);
                        if ($bitis < $suan) {
                            $pasif += 1;
                        } else {
                            $aktif += 1;
                        }
                    }
                }
                ?>
                <tr>
                    <td>Toplam Aktif Oto İşlem: </td>
                    <td id="aktif"><?php echo $aktif ?> Adet</td>
                </tr>
                <tr>
                    <td>Toplam Pasif Oto İşlem: </td>
                    <td id="pasif"><?php echo $pasif ?> Adet</td>
                </tr>
                <tr>
                    <td>Gider: </td>
                    <td id="gider"><?php echo $masraf ?> $</td>
                </tr>
                <tr>
                    <td>Toplam Alınan </td>
                    <td id="top"><?php echo $topal ?> ₺</td>
                </tr>
            </table>
            </div>
        </div>
        <a href="#" id="yeniekle">Yeni Ekle</a>
        <div class="servisliste">
            <h1>Yeni Ekle</h1>
            <select>
                <?php
                $sor = $db->query("select * from adminoto order by id desc");
                if ($sor->rowCount()) {
                    foreach ($sor as $sora) {
                        echo "<option id='{$sora['id']}' name='{$sora['fiyati']}'>{$sora['adi']}</option>";
                    }
                }
                ?>
            </select>
            <label for="kad">Kullanıcı Adı</label>
            <input type="text" name="kad">

            <label for="gun">Kaç Gün</label>
            <input type="text" name="gun">

            <label for="sinir">Toplam İşlem Hakkı <i>Örn:90</i></label>
            <input type="text" name="sinir">

            <label for="miktar">Miktar</label>
            <input type="text" name="miktar">

            <label for="maliyet">Maliyet</label>
            <input type="text" name="maliyet" disabled>

            <label for="alinan">Alınan Miktar</label>
            <input type="text" name="alinan">
            <a href="#" id="adminoto">Ekle</a>
        </div>
        <div class="otoduzenle">
            <h1>Düzenle</h1>
            <label for="duzkid">İD</label>
            <input type="text" name="duzkid" disabled>

            <label for="duzkad">Kullanıcı Adı</label>
            <input type="text" name="duzkad">

            <label for="duzkid">Miktar</label>
            <input type="text" name="duzmik">

            <label for="duzkid">İşlem Sayısı</label>
            <input type="text" name="duzkalan">

            <label for="duzkid">Kalan Gün</label>
            <input type="text" name="duzgun">

            <a href="#" name="otoduz">Kaydet</a>
        </div>
        <div class="otolar">
            <h1>Oto İşlemler</h1>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr style="background:#2f2f2f;color:#fff;">
                    <td align="center">İD</td>
                    <td>Servis Adı</td>
                    <td>Kullanıcı Adı</td>
                    <td align="center">Adet</td>
                    <td align="center">Kalan İşlem</td>
                    <td align="center">Kalan Gün</td>
                    <td align="center">Gider</td>
                    <td align="center">Alınan</td>
                    <td align="center">Düzenle</td>
                    <td align="center">Sil</td>
                </tr>
                <?php
                $cek = $db->query("select * from adminotolar inner join adminoto on adminoto.id=adminotolar.servis order by adminotolar.id desc ");
                if ($cek->rowCount()) {
                    foreach ($cek as $gelcek) {
//                        echo"<pre>";
//                        print_r($gelcek);
                        ?>
                        <tr>
                            <td align="center" width="10px">
                                <?php echo $gelcek['0'] ?>
                            </td>
                            <td align="" width="350px">
                                <?php echo $gelcek['adi'] ?>
                            </td>
                            <td>
                                <?php echo $gelcek['kad'] ?>
                            </td>
                            <td align="center">
                                <?php echo $gelcek['miktar'] ?>
                            </td>
                            <td align="center">
                                <?php echo $gelcek['sinir'] ?>
                            </td>
                            <td align="center">
                                <?php
                                $suan = strtotime(date("Y-m-d"));
                                $bitis = strtotime($gelcek['bitis']);
                                if($bitis<$suan){
                                    $son="Bitti";
                                    echo $son;
                                }else {
                                $son = ($bitis - $suan) / 86400;
                                echo $son . " Gün";
                                }
                                ?>
                            </td>
                            <td align="center">
                                <?php echo $gelcek['masraf'] ?> $
                            </td>
                            <td align="center">
                                <?php echo $gelcek['alinan'] ?> ₺
                            </td>

                            <td align="center">
                                <a href="#" id="duzenle" name="<?php echo $gelcek['0'] ?>">Düzenle</a>
                            </td>
                            <td align="center">
                                <a href="#" id="sil" name="<?php echo $gelcek['0'] ?>">Sil</a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
            <script>


                $(".servisliste select").change(function () {
                    $("input").val("");
                });
                $("#yeniekle").click(function () {
                    $(".servisliste").slideDown();
                });
                $("input").change(function () {
                    var miktar = $("input[name=miktar]").val();
                    var gun = $("input[name=gun]").val();
                    var sinir = $("input[name=sinir]").val();
                    var fiyat = $(".servisliste select option:selected").attr("name");
                    // alert(fiyat);
                    var sonuc = (miktar * sinir) * fiyat / 1000;
                    $("input[name=maliyet]").val(sonuc.toFixed(2) + " $");
                });
                $("#adminoto").click(function () {
                    var kad, gun, sinir, miktar, servis,alinan,masraf;
                    kad = $("input[name=kad]").val();
                    gun = $("input[name=gun]").val();
                    sinir = $("input[name=sinir]").val();
                    miktar = $("input[name=miktar]").val();
                    servis = $(".servisliste select option:selected").attr("id");
                    alinan =$("input[name=alinan]").val();
                    masraf =$("input[name=maliyet]").val();
                    // alert(masraf);
                    $.ajax({
                        type: "post",
                        url: "ajax.php",
                        data: {
                            "adminoto": 1,
                            "kullaniciadi": kad,
                            "gun": gun,
                            "miktari": miktar,
                            "servisi": servis,
                            "sinir": sinir,
                            "alinan":alinan,
                            "masraf":masraf
                        },
                        success: function (cevap2) {
                            //alert(cevap2);
                            window.location.reload();
                        }
                    })
                });
                $(document).on("click","a#sil",function (b) {
                    b.preventDefault();
                   var id=$(this).attr("name");
                   // alert(id);
                   $.ajax({
                       type:"post",
                       url:"ajax.php",
                       data:{"otosil":1,"id":id},
                       success:function (cevap) {
                           window.location.reload();
                       }
                   })
                });
                $(document).on('click','a#duzenle',function (a) {
                    // alert();
                    a.preventDefault();
                    $(".otoduzenle").slideDown();
                    var id=$(this).attr('name');
                    $.ajax({
                        type:"post",
                        url:"ajax.php",
                        data:{
                            "otoduz":1,
                            "duzid":id
                        },
                        dataType:"json",
                        success:function (cevap) {
                            $("input[name=duzkid]").val(id);
                            $("input[name=duzkad]").val(cevap['kad']);
                            $("input[name=duzmik]").val(cevap['miktar']);
                            $("input[name=duzkalan]").val(cevap['sinir']);
                            $("input[name=duzgun]").val(cevap['gun']);

                        }
                    })
                });
                $(document).on("click","a[name=otoduz]",function () {
                    var id=$("input[name=duzkid]").val();
                    var kad=$("input[name=duzkad]").val();
                    var mik=$("input[name=duzmik]").val();
                    var islem=$("input[name=duzkalan]").val();
                    var gun=$("input[name=duzgun]").val();
                    $.ajax({
                        type:"post",
                        url:"ajax.php",
                        data:{
                            "otoduzenle":1,
                            "id":id,
                            "kad":kad,
                            "mik":mik,
                            "islem":islem,
                            "gun":gun
                        },success:function (cevap) {
                            // alert(cevap);
                            window.location.reload();
                        }
                    })
                });
                $("#getir").click(function () {
                    $('.otolar table tr:not(:first-child)').remove();
                    var tarih1,tarih2;
                    tarih1=$("input[name=tarih1]").val();
                    tarih2=$("input[name=tarih2").val();
                    $.ajax({
                        type:"post",
                        url:"ajax.php",
                        data:{
                            "otoadmintarih":1,
                            "tarih1":tarih1,
                            "tarih2":tarih2
                        },success:function (cevap) {
                            var json = cevap;
                            // alert(JSON.stringify(cevap));
                            // alert(json.length);

                            var data='';
                            var i=0;
                            var gider=0;
                            var top=0;
                            var aktif=0;
                            var pasif=0;

                            $.each(json,function () {
                                data+='<tr>';
                                data+='<td align="center" width="10px">'+json[i].id+'</td>';
                                data+='<td align="" width="350px">'+json[i].adi+'</td>';
                                data+='<td>'+json[i].kad+'</td>';
                                data+='<td align="center">'+json[i].miktar+'</td>';
                                data+='<td align="center">'+json[i].sinir+'</td>';
                                data+='<td align="center">'+json[i].son+'</td>';
                                data+='<td align="center">'+json[i].masraf+' $</td>';
                                data+='<td align="center">'+json[i].alinan+' ₺</td>';
                                data+='<td align="center"><a href="#" id="duzenle" name="'+json[i].id+'">Düzenle</a></td>';
                                data+='<td align="center"><a href="#" id="sil" name="'+json[i].id+'">Sil</a></td>';
                                data+='</tr>';
                                gider+=parseFloat(json[i].masraf);
                                top+=parseFloat(json[i].alinan);
                                if(json[i].son=="Bitti"){
                                    pasif+=1;
                                }else {
                                    aktif+=1;
                                }
                                i++;
                            });
                            $('.otolar table').append(data);
                            $('#gider').text(gider+" $");
                            $('#top').text(top+" ₺");
                            $('#aktif').text(aktif+" Adet");
                            $('#pasif').text(pasif+" Adet");
                        }
                    });
                })
            </script>
        </div>
    </div>
    </body>
    <?php require_once 'footer.php';
} else {
    header("location:giris.php");
} ?>