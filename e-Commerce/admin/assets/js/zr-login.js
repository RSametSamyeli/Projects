$(document).ready(function() {
    $container = $("#form_login");
    var i = $(".login-error");
    $container.validate({
        rules: {
            username: {
                required: !0
            },
            password: {
                required: !0
            }
        },
        highlight: function(i) {
            $(i).closest(".input-group").addClass("validate-has-error")
        },
        unhighlight: function(i) {
            $(i).closest(".input-group").removeClass("validate-has-error")
        },
        submitHandler: function() {
            $(".login-ajax").show(), i.addClass("hide"), $(".btn-login").text("Bekleyiniz..."), $.ajax({
                url: "data/login.php",
                method: "POST",
                dataType: "json",
                data: {
                    username: $("input#username").val(),
                    password: $("input#password").val()
                },
                success: function(e) {
                    {
                        var a = e.giris_durumu;
                        e.giris_par
                    }
                    if ("gecersiz" == a) $(".login-ajax").hide(), i.removeClass("hide"), $("p.hata2").html(e.giris_par), $(".btn-login").text("Giriş Yap");
                    else if ("gecerli" == a) {
                        $(".login-ajax").hide();
                        var r;
                        e.yonlendir && e.yonlendir.length && (r = e.yonlendir), window.location.href = r
                    }
                }
            })
        }
    })
});