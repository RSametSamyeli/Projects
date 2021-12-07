
function drag(sira,onceki){
    $(".image-holder").find('.element'+sira+':first').draggable({
        containment: ".slider-preview",
        scroll: false,
        cursor: "move",
        drag: function(event, ui) {
            var pos_x = ui.position.left;
            var pos_y = ui.position.top;
            pos_x = parseInt(pos_x);
            pos_y = parseInt(pos_y);
            $('.layer-settings .datax:eq('+onceki+')').val(pos_x);
            $('.layer-settings .datay:eq('+onceki+')').val(pos_y);
        }
    });
}
function textchange(){
    $('body').on('keyup','.layer-settings .text',function(){
        var text = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings textarea.text');
        $(".image-holder .secici-katman:eq("+index+")").html(text);
        $('.secili-text:eq('+index+')').text(text);
    });
}
function fontsize(){
    $('body').on('change','.layer-settings .fontsize',function(){
        var size = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings select.fontsize');
        var Btn = $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons');
        if(Btn.length){
            $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons').css({"font-size":size+'px'});
        }else{
            $(".image-holder .secici-katman:eq("+index+")").css({"font-size":size+'px'});
        }
    });
}
function fontcolor2(){
    $('body').on('blur','.fontcolor',function(){
        var fontColor = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.fontcolor');
        var Btn = $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons');
        if(Btn.length){
            $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons').css({"color":fontColor});
        }else{
            $(".image-holder .secici-katman:eq("+index+")").css({"color":fontColor});
        }
    });
}
function fontfamily(){
    $('body').on('change','.layer-settings .fontfamily',function(){
        var family = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings select.fontfamily');

        var Btn = $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons');
        if(Btn.length){
            $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons').css({"font-family":family});
        }else{
            $(".image-holder .secici-katman:eq("+index+")").css({"font-family":family});
        }
    });
}
function bgcolor(){
    $('.backgroundcolor').blur(function(){
        var bgColor = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.backgroundcolor');
        var Btn = $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons');
        if(Btn.length){
            $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons').css({"background":bgColor});
        }else{
            $(".image-holder .secici-katman:eq("+index+")").css({"background":bgColor});
        }
    });
}
function fontweight(){
    $('body').on('change','.layer-settings .fontweight',function(){
        var weight = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings select.fontweight');
        var Btn = $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons');
        if(Btn.length){
            $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons').css({"font-weight":weight});
        }else{
            $(".image-holder .secici-katman:eq("+index+")").css({"font-weight":weight});
        }
    });
}
function lineheight(){
    $('body').on('change','.layer-settings .lineheight',function(){
        var line = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings select.lineheight');
        $(".image-holder .secici-katman:eq("+index+")").css({"line-height":line+'px'});
    });
}
function padding(){
    $('body').on('keyup','.layer-settings .paddingwidth',function(){
        var paddingwidth = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.paddingwidth');
        var Btn = $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons');
        if(Btn.length){
            $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons').css({"padding-left":paddingwidth+'px',"padding-right":paddingwidth+'px'});
        }else{
            $(".image-holder .secici-katman:eq("+index+")").css({"padding-left":paddingwidth+'px',"padding-right":paddingwidth+'px'});
        }
    });
    $('body').on('keyup','.layer-settings .paddingheight',function(){
        var paddingheight = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.paddingheight');
        var Btn = $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons');
        if(Btn.length){
            $(".image-holder .secici-katman:eq("+index+")").find('.zr-custom-buttons').css({"padding-top":paddingheight+'px',"padding-bottom":paddingheight+'px'});
        }else{
            $(".image-holder .secici-katman:eq("+index+")").css({"padding-top":paddingheight+'px',"padding-bottom":paddingheight+'px'});
        }
    });
}
function decoration(){
    $('body').on('change','.layer-settings .decoration',function(){
        var decoration = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings select.decoration');
        $(".image-holder .secici-katman:eq("+index+")").css({"text-decoration":decoration});
    });
}
function border(){
    $('body').on('change','.layer-settings .borderwidth',function(){
        var borderwidth = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings select.borderwidth');
        $(".image-holder .secici-katman:eq("+index+")").css({"border-width":borderwidth+'px'});
    });
    $('body').on('change','.layer-settings .borderstyle',function(){
        var borderstyle = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings select.borderstyle');
        $(".image-holder .secici-katman:eq("+index+")").css({"border-style":borderstyle});
    });
    $('.bordercolor').blur(function(){
        var bordercolor = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.bordercolor');
        $(".image-holder .secici-katman:eq("+index+")").css({"border-color":bordercolor});
    });
}
function borderradius(){
    $('body').on('keyup','.layer-settings .bordertopleftradius',function(){
        var bordertopleftradius = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.bordertopleftradius');
        $(".image-holder .secici-katman:eq("+index+")").css({"border-top-left-radius":bordertopleftradius+'px'});
    });
    $('body').on('keyup','.layer-settings .bordertoprightradius',function(){
        var bordertoprightradius = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.bordertoprightradius');
        $(".image-holder .secici-katman:eq("+index+")").css({"border-top-right-radius":bordertoprightradius+'px'});
    });
    $('body').on('keyup','.layer-settings .borderbottomleftradius',function(){
        var borderbottomleftradius = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.borderbottomleftradius');
        $(".image-holder .secici-katman:eq("+index+")").css({"border-bottom-left-radius":borderbottomleftradius+'px'});
    });
    $('body').on('keyup','.layer-settings .borderbottomrightradius',function(){
        var borderbottomrightradius = $(this).val();
        var index = $(this).index('.zr-accordion-full .layer-settings input.borderbottomrightradius');
        $(".image-holder .secici-katman:eq("+index+")").css({"border-bottom-right-radius":borderbottomrightradius+'px'});
    });
}
function shadow(){
    $('body').on('keyup','.layer-settings .shadow4',function(){
        var shadow4 = $(this).val();
        var shadow3 = $(this).prev().val();
        var shadow2 = $(this).prev().prev().val();
        var shadow1 = $(this).prev().prev().prev().val();
        console.log(shadow1);
        var index = $(this).index('.zr-accordion-full .layer-settings input.shadow4');
        $(".image-holder .secici-katman:eq("+index+")").css({"textShadow": ""+shadow4+" "+shadow3+"px "+shadow2+"px "+shadow1+"px"});
    });
}
function buttons(){
    $('body').on('click','.layer-settings .slider-button',function(e){
        e.preventDefault();
        var btn = $(this).parent().html();
        var btnText = $(this).text();
        var index = $(this).parents('.tp-simpleresponsive').index('.zr-accordion-full .layer-settings .tp-simpleresponsive');
        $(".image-holder .secici-katman:eq("+index+")").html(btn);
        $('.layer-settings .text:eq('+index+')').val(btn);
        $('.secili-katmanlar li a:eq('+index+')').text(btn);
    });
}


$(function(){
    var random = 0;

    $('select.selectboxit3').selectBoxIt( {autoWidth: false });
    var totalSet = $('.zr-accordion-full > .layer-settings').length;


    $('.layer-settings').hide();
    $('.layer-settings:last-child').show();

    if(totalSet >= 1){
        random = totalSet;
    }else{
        random = 0;
    }
    var clone =  $('.zr-accordion-full-hide:first').html();

    fontsize();
    fontcolor2();
    fontfamily();
    bgcolor();
    textchange();
    fontweight();
    lineheight();
    padding();
    decoration();
    border();
    borderradius();
    shadow();
    buttons();

    /***
     *
     * Layer Ekle
     *
     * */

    $('body').on('click','.layer-ekle',function(){
        random++;
        var birgeri = random-1;
        // $('ul.secili-katmanlar li a').removeClass('secili-aktif');
        //$('ul.secili-katmanlar li a:last').addClass('secili-aktif');

        /****
         *
         * Default
         *
         *
         * ******/

        $('.zr-accordion-full').append(clone);
        $('.layer-settings').hide();
        $('.layer-settings:last-child').show();
        $('.layer-settings .text:eq('+birgeri+')').val('Başlık Deneme ' + random);
        $('.table-secililer > tbody').append(' <tr><td class="secili-text">Başlık Deneme '+random+'</td> <td> <button type="button" class="btn btn-sm btn-icon icon-left btn-info layer-sec element'+random+'"><i class="entypo-arrow-combo"></i>Layer Seç</button> <button type="button" class="btn btn-sm btn-icon btn-danger layer-sil"><i class="entypo-trash"></i>Layer Sil</button></td></tr>');
      // $('.secili-katmanlar').append('<li><a  class="zr-secili-katman'+random+'" href="javascript:void(0)">Başlık Deneme '+ random+'</a></li>');
        $('.image-holder').append('<div class="secici-katman element'+random+'" id="element'+random+'">Başlık Deneme '+ random+'</div>');
        $('select.selectboxit2').selectBoxIt( {autoWidth: false });



        /**** Ayarlar ****/
        drag(random,birgeri);
        textchange();
        fontsize();
        fontcolor();
        fontcolor2();
        fontfamily();
        bgcolor();
        fontweight();
        lineheight();
        padding();
        decoration();
        border();
        borderradius();
        shadow();
        buttons();

    });

    /****
     *
     * Katman Select
     *
     *
     * ***/

    $('body').on('click','button.layer-sec',function(){
        $('.table-secililer > tbody tr').removeClass('secili-aktif');
        $(this).parent().parent().addClass('secili-aktif');
        var index = $('.table-secililer  tbody tr button.layer-sec').index(this);
        $('.zr-accordion-full .layer-settings').hide();
        $('.zr-accordion-full .layer-settings:eq('+index+')').show();
    });

    /****
     *
     * Katman Delete
     *
     *
     ****/


    
     $('body').on('click','button.layer-sil',function(){
		 var index = $('.table-secililer tbody tr button.layer-sil').index(this);
		 $(this).parent().parent().remove();
         $('.zr-accordion-full:first .layer-settings:eq('+index+')').remove();
		 
         $('.zr-accordion-full .layer-settings').hide();
         $('.zr-accordion-full .layer-settings:last').show();
         $('.table-secililer > tbody tr').removeClass('secili-aktif');
         $('.table-secililer > tbody tr:last').addClass('secili-aktif');
         $('.secici-katman:eq('+index+')').remove();
    });

     /* $("#fileUpload").on('change', function () {
     if (typeof (FileReader) != "undefined") {
     var image_holder = $("#image-holder");
     image_holder.empty();

     var reader = new FileReader();
     reader.onload = function (e) {
     $("<img />", {
     "src": e.target.result,
     "class": "thumb-image"
     }).appendTo(image_holder);

     }
     image_holder.show();
     reader.readAsDataURL($(this)[0].files[0]);
     } else {
     alert("This browser does not support FileReader.");
     }
     });*/
});