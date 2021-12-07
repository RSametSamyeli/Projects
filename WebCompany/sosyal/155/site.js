$("#katduz").click(function () {
    var katid = $("input[name=katduzid]").val();
    var katis = $("input[name=katduzis]").val();
    // alert(katis);
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"katid": katid, "katis": katis},
        success: function (cevap) {
            // alert(cevap);
            window.location.href = "kategoriler.php";
        }
    })
});
$("a[name=duzenle]").click(function () {
    var katduz = $(this).attr('id');
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"katduz": katduz},
        success: function (cevap) {
            // alert(cevap);
            $(".katekle").slideUp();
            setTimeout(function () {
                $(".katduzenle").slideDown();
            }, 500);
            $("#inputs").html(cevap);
        }
    })
});

$("a[name=serduzenle]").click(function (a) {
	a.preventDefault();
    var serduz = $(this).attr('id');
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"serduz": serduz},
        success: function (cevap) {
            // alert(cevap);
            $(".tabs").slideUp();
            $(".serduzinput").html(cevap);
            setTimeout(function () {
                $(".serduz").slideDown();
            }, 500);

        }
    })
});
$("a[name=sersil]").click(function (a) {
		a.preventDefault();
    var sersil = $(this).attr('id');
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"sersil": sersil},
        success: function () {
            alert("Silindi!");
            window.location.reload();
        }
    })
});
$("a[name=katsil]").click(function () {
    var katsil = $(this).attr('id');
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"katsil": katsil},
        success: function () {
            alert("Silindi!");
            window.location.reload();
        }
    })
});
$("#serduzkaydet").click(function () {
    var seradi = $("input[name=servisadi]").val();
    var fiyati = $("input[name=fiyati]").val();
    var sure = $("input[name=sure]").val();
    var marketid = $("input[name=marketid]").val();
    var min = $("input[name=min]").val();
    var max = $("input[name=max]").val();
    var aciklama = $("textarea[name=aciklama]").val();
    var serid = $("input[name=servisadi]").attr('id');
    var miktar = $("input[name=miktar]").val();
    var orj = $("input[name=orj]").val();
    // alert(serid);
    // alert (seradi+fiyati+sure+marketid+min+max+aciklama);
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {
            "servisguncelle": 1,
            "serid": serid,
            "seradi": seradi,
            "fiyati": fiyati,
            "sure": sure,
            "marketid": marketid,
            "min": min,
            "max": max,
            "aciklama": aciklama,
            "otomiktar": miktar,
            "orj": orj
        },
        success: function (cevap) {
            //alert(cevap);
            setTimeout(function () {
                $(".serduz").slideUp();

            }, 500);
            window.location.reload();
        }
    });

});


$("#servisekle").click(function () {
    var katid = $(".servisekle select option:selected").attr('id');
    var seradi = $("input[name=servisbaslik]").val();
    var fiyati = $("input[name=fiyati]").val();
    var sure = $("input[name=sure]").val();
    var marketid = $("input[name=marketid]").val();
    var min = $("input[name=min]").val();
    var max = $("input[name=max]").val();
    var aciklama = $("textarea[name=aciklama]").val();
    var miktar = $("input[name=miktar]").val();
    var orj = $("input[name=orj]").val();
    // alert(katid);
    // alert (seradi+fiyati+sure+marketid+min+max+aciklama);
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {
            "servisekle": 1,
            "opti": katid,
            "serad": seradi,
            "fiyati": fiyati,
            "sure": sure,
            "marketid": marketid,
            "min": min,
            "max": max,
            "aciklama": aciklama,
            "otomiktar": miktar,
            "orj": orj
        },
        success: function (cevap) {
             // alert(cevap);
            alert("Servis Eklendi!")
            //window.location.reload();
            //$(".servisekle input").val("");
            //$(".servisekle textarea").val("");
        }
    });

});

$(".servisekle select").change(function () {
    if ($(".servisekle select option:selected").attr('id') == 4 || $(".servisekle select option:selected").attr('id') == 5) {
        $(".servisekle input").removeAttr("disabled");
        $(".servisekle input[name=min]").attr("disabled", true);
        $(".servisekle input[name=max]").attr("disabled", true);
        // $(".servisekle input").removeAttr("disabled");
    }else if($(".servisekle select option:selected").attr('id') == 18){
        $(".servisekle input").removeAttr("disabled");
        $(".servisekle input[name=min]").attr("disabled", true);
        $(".servisekle input[name=max]").attr("disabled", true);
        $(".servisekle input[name=miktar]").attr("disabled", true);
        $(".servisekle input[name=sure]").attr("disabled", true);
    } else {
        $("input[name=sure]").attr("disabled", true);
        $("input[name=miktar]").attr("disabled", true);
        $(".servisekle input[name=min]").removeAttr("disabled");
        $(".servisekle input[name=max]").removeAttr("disabled");
    }
});

$(".bakiye input").keyup(function () {
    var bakiyeid = $(this).val();
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"bakiyeid": bakiyeid},
        success: function (cevap) {
            $(".inputs").html(cevap);

        }

    })

});

$(".bakiye a[name=bakiyeekle]").click(function () {
    var bakiyeekleid = $("input[name=id]").val();
    var bakiyeekle = $("input[name=bakiye]").val();
    if ($("input[name=bakiye]").val() != "") {
        $.ajax({
            type: "post",
            url: "ajax.php",
            data: {"bakiyeekle": 1, "bakid": bakiyeekleid, "bakiye": bakiyeekle},
            success: function (cevap) {
				//alert(cevap);
                if (cevap.trim() == 1) {
                    alert("Bakiye başarıyla eklendi");
                    window.location.href = "index.php";
                } else {
                    alert("Bakiye eklenirken bir hata oluştu!");
                }
            }
        });
    }
});
$(".bakiye a[name=bakiyecikar]").click(function () {
    var bakiyeekleid = $("input[name=id]").val();
    var bakiyeekle = $("input[name=bakiye]").val();
    if ($("input[name=bakiye]").val() != "") {
        $.ajax({
            type: "post",
            url: "ajax.php",
            data: {"bakiyecikar": 1, "bakid": bakiyeekleid, "bakiye": bakiyeekle},
            success: function (cevap) {
                if (cevap.trim() == 1) {
                    alert("Bakiye çıkarıldı");
                    window.location.href = "index.php";
                } else {
                    alert("Bakiye çıkarılırken bir hata oluştu!");
                }
            }
        });
    }
});


$("#katkaydet").click(function () {
    var katadi = $("input[name=yenikat]").val();
    if ($("input[name=yenikat]").val() != "") {
        $.ajax({
            type: "post",
            url: "ajax.php",
            data: {"katadi": katadi},
            success: function (cevap) {
                // alert(cevap);
                if (cevap.trim() == 1) {
                    alert("Kategori Oluşturuldu!");
                    window.location.href = "kategoriler.php";
                }
                else {
                    alert("Bir hata oluştu!");
                }
            }
        });
    } else {
        alert("Lütfen geçerli bir ad giriniz...");
    }
});

$("input[name=uyeara]").keyup(function () {
    var sorgu = $(this).val();
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"uyeara": 1, "sorgu": sorgu},
        success: function (cevap) {
            $(".gelenuye").html(cevap);

        }
    })
});


$(".icerik ul li a").click(function (l) {
    l.preventDefault();
    var id = $(this).attr("name");
    var duzenle = $(".icerikduzenle");
    var baslik=$(".icerikduzenle input[name=baslik]");
    var icerik=$("textarea#icduztext");
    var aciklama=$(".icerikduzenle input[name=aciklama]");
    var etiket=$(".icerikduzenle input[name=etiket]");
    var link=$(".icerikduzenle input[name=link]");
    var kategori=$(".icerikduzenle input[name=kategori]");
    var resim=$(".icerikduzenle input[name=resim]");
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {
            "icerikduzenle": 1,
            "icerikid": id
        }, success: function (cevap) {

            duzenle.show();
            baslik.val(cevap['baslik']);
            icerik.val(cevap['icerik']);
            aciklama.val(cevap['aciklama']);
            etiket.val(cevap['etiket']);
            link.val(cevap['link']);
            kategori.val(cevap['kategori']);
            resim.val(cevap['resim']);


            $("a#icerikkaydet").click(function () {

                $.ajax({
                    type:"post",
                    url:"ajax.php",
                    data:{
                        "icerikguncelle":1,
                        "baslik":baslik.val(),
                         "icerik":icerik.val(),
                        "aciklama":aciklama.val(),
                        "etiket":etiket.val(),
                        "link":link.val(),
                        "kategori":kategori.val(),
                        "resim":resim.val(),
                        "id":id
                    },success:function(cevap){
                        // alert(cevap);
                        if(cevap.trim()==1){
                            duzenle.slideUp();
                            window.location.reload();
                        }else {
                            alert("Bir hata oluştu"+cevap);
                        }
                    }

                })
            });

        }

    });
});


$("span#ekle").click(function () {
    $(".icerikekle").show();

});

$("a#icerikekle").click(function (a) {
    a.preventDefault();
    var baslik=$(".icerikekle input[name=baslik]");
    var icerik=$("#icektext");
    var aciklama=$(".icerikekle input[name=aciklama]");
    var etiket=$(".icerikekle input[name=etiket]");
    var link=$(".icerikekle input[name=link]");
    var kategori=$(".icerikekle input[name=kategori]");
    var resim=$(".icerikekle input[name=resim]");

    $.ajax({
        type:"post",
        url:"ajax.php",
        data:{
            "icerikekle":1,
            "baslik":baslik.val(),
            "icerik":icerik.val(),
            "aciklama":aciklama.val(),
            "etiket":etiket.val(),
            "link":link.val(),
            "kategori":kategori.val(),
            "resim":resim.val()
        },success:function (cevap) {
            if(cevap.trim()==1){
                $(".icerikekle").slideUp();
                window.location.reload();
            }else {
                alert("Bir hata oluştu"+cevap);
            }
        }
    })

});
