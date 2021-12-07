var contentLastMarginLeft = 0;
var responlast = $(".sol").width() + 3;
$(function (respon) {
    var durum = 1;
    var sol = $(".sol");
    $(".respon").click(function () {

        if (durum == 1) {
            sol.slideDown();
            durum = 0;
        }
        else if (durum == 0) {
            sol.slideUp();
            durum = 1;
        }
    });
});

$("#al").click(function (al) {

    al.preventDefault();
    $("#al").hide();
    $("#ver").show();
    var islemsec = $("select.kat option:selected").attr('id');
    var kategori = $(".kat option:selected").attr('id');
    var servis = $("#servisler option:selected").val();
    var link = $("input[name=link]").val();
    var adet = $("input[name=adet]").val();
    var serid = $("#servisler option:selected").attr('id');
    if (link == "") {
        $("input[name=link]").css("border-color", "#f4756d");
    } else {
        setTimeout(function () {
            $("#al").show();
            $("#ver").hide();
        }, 300);
        if (kategori == 4 || kategori == 5 || kategori == 18 || kategori == 27 ) {
            $.ajax({
                type: "post",
                url: "ajax.php",
                data: {
                    "kat": kategori,
                    "servis": servis,
                    "link": link,
                    "adet": adet,
                    "serid": serid
                },
                success: function (cevap) {
                     alert(cevap);
					 cevap=cevap.trim();
                    if (cevap == 1) {
                        swal({
                            title: "Tamamdır Patron!",
                            text: "Satın alma Başarılı",
                            icon: "success",
                            button: "Tamam",
                        });
                    }
                    if (cevap == 0) {
                        swal({
                            title: "Upss...",
                            text: "Sanırım paran bitmiş :(",
                            icon: "warning",
                            button: "Tamam",
                        });
                    }
                }
            });
        }
        else {
            if (adet == "") {
                $("input[name=adet]").css("border-color", "#f4756d");
            } else {
                $.ajax({
                    type: "post",
                    url: "ajax.php",
                    data: {
                        "kat": kategori,
                        "servis": servis,
                        "link": link,
                        "adet": adet,
                        "serid": serid
                    },
                    success: function (cevap) {
                        cevap = cevap.trim();
                        //alert(cevap);
                        if (cevap == 1) {
                            swal({
                                title: "Tamamdır Patron!",
                                text: "Satın alma Başarılı",
                                icon: "success",
                                button: "Tamam",
                            });
                            // $(".islemsonuc").css({"background": "#71af94"});
                            // $(".islemsonuc").text("Satın Alma Başarılı!");
                            // $(".islemsonuc").slideDown();
                            // setTimeout(function () {
                            //     $(".islemsonuc").slideUp();
                            // }, 5000);
                        }
                        else if (cevap == 2) {
                            // $(".islemsonuc").css({"background": "#afa95b"});
                            // $(".islemsonuc").text("Lütfen Maksimum ve Minimum Değerleri Kontrol Ediniz...");
                            // $(".islemsonuc").slideDown();
                            // setTimeout(function () {
                            //     $(".islemsonuc").slideUp();
                            // }, 5000);

                            swal({
                                title: "Hata",
                                text: "Lütfen minimum ve maksimum satın alma değerlerini kontrol ediniz...",
                                icon: "warning",
                                button: "Tamam",
                            });


                        }
                        else if (cevap == 0) {
                            // $(".islemsonuc").css({"background": "#f4907e"});
                            // $(".islemsonuc").text("Bakiye Yetersiz!");
                            // $(".islemsonuc").slideDown();
                            // setTimeout(function () {
                            //     $(".islemsonuc").slideUp();
                            // }, 5000);
                            swal({
                                title: "Upss...",
                                text: "Sanırım paran bitmiş :(",
                                icon: "warning",
                                button: "Tamam",
                            });
                        } else if (cevap == 5) {
                            // $(".islemsonuc").css({"background": "#f4907e"});
                            // $(".islemsonuc").text("Bakiye Yetersiz!");
                            // $(".islemsonuc").slideDown();
                            // setTimeout(function () {
                            //     $(".islemsonuc").slideUp();
                            // }, 5000);
                            swal({
                                title: "Bir Hata Oluştu",
                                text: "Bir hata oluştu, servis açıklamalarını dikkatlice okuyunuz, eğer sorunun sizle alakalı olmadığını düşünüyorsanız iletişime geçerek konuyu bildirmeyi unutmayınız...",
                                icon: "error",
                                button: "Tamam",
                            });
                        }
                    }

                });
            }
        }

    }

});
$("option").click(function () {
    $("input[type=text]").val("");

});
if ($(".kat select").attr('id') == 4 || $(".kat select").attr('id') == 5 || $(".kat select").attr('id') == 18 || $(".kat select").attr('id') == 27 ) {
    $("input[name='adet']").hide();
    var fiyat = $("select#servisler option:selected").attr("name");
    $("input[name='fiyat']").val(fiyat + " ₺");
}
$("input[name=adet]").keyup(function () {
    var adet = $("input[name=adet]").val();
    var fiyat = $("select#servisler option:selected").attr("name");
    // alert(adet);
    // alert(hesap);
    $("input[name='fiyat']").val(fiyat * adet / 1000 + " ₺");
});

$("select#servisler").change(function () {
    var aciklama = $("select#servisler option:selected").attr("id");
    $("input[name=link]").val("");
    $("input[name=adet]").val("");
    $("input[name=fiyat]").val("");
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"aciklama": aciklama},
        success: function (cevap) {
            cevap = cevap.trim();
            if (cevap == "") {
                $("#aciklama").slideUp();
            } else {
                $("#aciklama").slideDown();
                $("#aciklama").html(cevap.trim());
            }
        }
    });
});

$(".kat").change(function () {
    if ($("select.kat option:selected").attr('id') == 4 || $("select.kat option:selected").attr('id') == 5 || $("select.kat option:selected").attr('id') == 18 || $("select.kat option:selected").attr('id') == 27) {
        $("input[name=adet]").hide();
        $("input[name=fiyat]").hide();
    } else {
        $("input[name=adet]").show();
        $("input[name=fiyat]").show();
    }
    var a = $("select.kat option:selected").attr('id');
    // alert (a);
    $.ajax({
        type: "post",
        url: "ajax.php",
        data: {"kategori": a},
        success: function (cevap) {
            $("select#servisler").html(cevap);
            var acik = $("select#servisler option:first").attr('id');
            $.ajax({
                type: "post",
                url: "ajax.php",
                data: {"aciklama": acik},
                success: function (cevap) {
                    cevap = cevap.trim();
                    if (cevap == "") {
                        $("#aciklama").slideUp();
                    } else {
                        $("#aciklama").slideDown();
                        $("#aciklama").html(cevap.trim());
                    }
                }
            });
        }
    });
});
