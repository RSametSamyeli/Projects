"use strict"

/*===================================================================================*/
/*	OWL CAROUSEL
/*===================================================================================*/
$(document).ready(function(){
    var dragging = true;
    var owlElementID = "#owl-main";

    function fadeInReset() {
        if (!dragging) {
            jQuery(owlElementID + " .caption .fadeIn-1, " + owlElementID + " .caption .fadeIn-2, " + owlElementID + " .caption .fadeIn-3").stop().delay(800).animate({ opacity: 0 }, { duration: 400, easing: "easeInCubic" });
        }
        else {
            jQuery(owlElementID + " .caption .fadeIn-1, " + owlElementID + " .caption .fadeIn-2, " + owlElementID + " .caption .fadeIn-3").css({ opacity: 0 });
        }
    }

    function fadeInDownReset() {
        if (!dragging) {
            jQuery(owlElementID + " .caption .fadeInDown-1, " + owlElementID + " .caption .fadeInDown-2, " + owlElementID + " .caption .fadeInDown-3").stop().delay(800).animate({ opacity: 0, top: "-15px" }, { duration: 400, easing: "easeInCubic" });
        }
        else {
            jQuery(owlElementID + " .caption .fadeInDown-1, " + owlElementID + " .caption .fadeInDown-2, " + owlElementID + " .caption .fadeInDown-3").css({ opacity: 0, top: "-15px" });
        }
    }

    function fadeInUpReset() {
        if (!dragging) {
            jQuery(owlElementID + " .caption .fadeInUp-1, " + owlElementID + " .caption .fadeInUp-2, " + owlElementID + " .caption .fadeInUp-3").stop().delay(800).animate({ opacity: 0, top: "15px" }, { duration: 400, easing: "easeInCubic" });
        }
        else {
            $(owlElementID + " .caption .fadeInUp-1, " + owlElementID + " .caption .fadeInUp-2, " + owlElementID + " .caption .fadeInUp-3").css({ opacity: 0, top: "15px" });
        }
    }

    function fadeInLeftReset() {
        if (!dragging) {
            jQuery(owlElementID + " .caption .fadeInLeft-1, " + owlElementID + " .caption .fadeInLeft-2, " + owlElementID + " .caption .fadeInLeft-3").stop().delay(800).animate({ opacity: 0, left: "15px" }, { duration: 400, easing: "easeInCubic" });
        }
        else {
            jQuery(owlElementID + " .caption .fadeInLeft-1, " + owlElementID + " .caption .fadeInLeft-2, " + owlElementID + " .caption .fadeInLeft-3").css({ opacity: 0, left: "15px" });
        }
    }

    function fadeInRightReset() {
        if (!dragging) {
            jQuery(owlElementID + " .caption .fadeInRight-1, " + owlElementID + " .caption .fadeInRight-2, " + owlElementID + " .caption .fadeInRight-3").stop().delay(800).animate({ opacity: 0, left: "-15px" }, { duration: 400, easing: "easeInCubic" });
        }
        else {
            jQuery(owlElementID + " .caption .fadeInRight-1, " + owlElementID + " .caption .fadeInRight-2, " + owlElementID + " .caption .fadeInRight-3").css({ opacity: 0, left: "-15px" });
        }
    }

    function fadeIn() {
        jQuery(owlElementID + " .active .caption .fadeIn-1").stop().delay(500).animate({ opacity: 1 }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeIn-2").stop().delay(700).animate({ opacity: 1 }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeIn-3").stop().delay(1000).animate({ opacity: 1 }, { duration: 800, easing: "easeOutCubic" });
    }

    function fadeInDown() {
        jQuery(owlElementID + " .active .caption .fadeInDown-1").stop().delay(500).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeInDown-2").stop().delay(700).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeInDown-3").stop().delay(1000).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
    }

    function fadeInUp() {
        jQuery(owlElementID + " .active .caption .fadeInUp-1").stop().delay(500).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeInUp-2").stop().delay(700).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeInUp-3").stop().delay(1000).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
    }

    function fadeInLeft() {
        jQuery(owlElementID + " .active .caption .fadeInLeft-1").stop().delay(500).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeInLeft-2").stop().delay(700).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeInLeft-3").stop().delay(1000).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
    }

    function fadeInRight() {
        jQuery(owlElementID + " .active .caption .fadeInRight-1").stop().delay(500).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeInRight-2").stop().delay(700).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
        jQuery(owlElementID + " .active .caption .fadeInRight-3").stop().delay(1000).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
    }

    jQuery(owlElementID).owlCarousel({

        autoPlay: 5000,
        stopOnHover: true,
        navigation: true,
        pagination: true,
        singleItem: true,
        addClassActive: true,
        transitionStyle: "fade",
        navigationText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"],

        afterInit: function() {
            fadeIn();
            fadeInDown();
            fadeInUp();
            fadeInLeft();
            fadeInRight();
        },

        afterMove: function() {
            fadeIn();
            fadeInDown();
            fadeInUp();
            fadeInLeft();
            fadeInRight();
        },

        afterUpdate: function() {
            fadeIn();
            fadeInDown();
            fadeInUp();
            fadeInLeft();
            fadeInRight();
        },

        startDragging: function() {
            dragging = true;
        },

        afterAction: function() {
            fadeInReset();
            fadeInDownReset();
            fadeInUpReset();
            fadeInLeftReset();
            fadeInRightReset();
            dragging = false;
        }

    });

if (jQuery(owlElementID).hasClass("owl-one-item")) {
    jQuery(owlElementID + ".owl-one-item").data('owlCarousel').destroy();
}

jQuery(owlElementID + ".owl-one-item").owlCarousel({
    singleItem: true,
    navigation: false,
    pagination: false
});




jQuery('.home-owl-carousel').each(function(){

    var owl = $(this);
    var  itemPerLine = owl.data('item');
    if(!itemPerLine){
        itemPerLine = 4;
    }
    owl.owlCarousel({
        items : itemPerLine,
        itemsTablet:[768,2],
        navigation : true,
        pagination : false,

        navigationText: ["", ""]
    });
});

jQuery('.home-owl-carousel1').each(function(){

    var owl = $(this);
    var  itemPerLine = owl.data('item');
    if(!itemPerLine){
        itemPerLine = 6;
    }
    owl.owlCarousel({
        items : itemPerLine,
        itemsTablet:[768,2],
        navigation : true,
        pagination : false,

        navigationText: ["", ""]
    });
});

jQuery('.homepage-owl-carousel').each(function(){

    var owl = $(this);
    var  itemPerLine = owl.data('item');
    if(!itemPerLine){
        itemPerLine = 4;
    }
    owl.owlCarousel({
        items : itemPerLine,
        itemsTablet:[768,2],
        itemsDesktop : [1199,2],
        navigation : true,
        pagination : false,

        navigationText: ["", ""]
    });
});

jQuery(".blog-slider").owlCarousel({
    items : 2,
    itemsDesktopSmall :[979,2],
    itemsDesktop : [1199,2],
    navigation : true,
    slideSpeed : 300,
    pagination: false,
    navigationText: ["", ""]
});

jQuery(".best-seller").owlCarousel({
    items : 3,
    navigation : true,
    itemsDesktopSmall :[979,2],
    itemsDesktop : [1199,2],
    slideSpeed : 300,
    pagination: false,
    paginationSpeed : 400,
    navigationText: ["", ""]
});

jQuery(".sidebar-carousel").owlCarousel({
    items : 1,
    itemsTablet:[768,2],
    itemsDesktopSmall :[979,2],
    itemsDesktop : [1199,1],
    navigation : true,
    slideSpeed : 300,
    pagination: false,
    paginationSpeed : 400,
    navigationText: ["", ""]
});

jQuery(".brand-slider").owlCarousel({
    items : 6,
    navigation : true,
    slideSpeed : 300,
    pagination: false,
    paginationSpeed : 400,
    navigationText: ["", ""]
});    
jQuery("#advertisement").owlCarousel({
    items : 1,
    itemsDesktopSmall :[979,2],
    itemsDesktop : [1199,1],
    navigation : true,
    slideSpeed : 300,
    pagination: true,
    paginationSpeed : 400,
    navigationText: ["", ""]
});    



});

/*===================================================================================*/
/*  LAZY LOAD IMAGES USING ECHO
/*===================================================================================*/
$(document).ready(function(){
    echo.init({
        offset: 100,
        throttle: 250,
        unload: false
    });
});

/*===================================================================================*/
/*  RATING
/*===================================================================================*/

$(document).ready(function(){
    jQuery('.rating').rateit({max: 5, step: 1, value : 4, resetable : false , readonly : true});
});

/*===================================================================================*/
/* PRICE SLIDER
/*===================================================================================*/
$(document).ready(function(){

// Price Slider
if (jQuery('.price-slider').length > 0) {
    jQuery('.price-slider').slider({
        min: 100,
        max: 700,
        step: 10,
        value: [200, 500],
        handle: "square"

    });

}

});


/*===================================================================================*/
/* SINGLE PRODUCT GALLERY
/*===================================================================================*/
$(document).ready(function(){
    jQuery('#owl-single-product').owlCarousel({
        items:1,
        itemsTablet:[768,2],
        itemsDesktop : [1199,1]

    });

    jQuery('#owl-single-product-thumbnails').owlCarousel({
        items: 4,
        pagination: true,
        rewindNav: true,
        itemsTablet : [768, 4],
        itemsDesktop : [1199,3]
    });

    jQuery('#owl-single-product2-thumbnails').owlCarousel({
        items: 6,
        pagination: true,
        rewindNav: true,
        itemsTablet : [768, 4],
        itemsDesktop : [1199,3]
    });

    jQuery('.single-product-slider').owlCarousel({
        stopOnHover: true,
        rewindNav: true,
        singleItem: true,
        pagination: true
    });

  






/*===================================================================================*/
/*  WOW 
/*===================================================================================*/

$(document).ready(function(){
  //  new WOW().init();
	
	
	
	
	var gilk = $(".right_imgs a:first").find('img').attr('src');
	$('input.gresim').val(gilk);
	$(".right_imgs a img:first").addClass("zr-img-active");
	$(".right_imgs a").on("click",function(){
		$(".right_imgs a img").removeClass("zr-img-active");
		$(this).find("img").addClass("zr-img-active");
		
		var gresim = $(this).find('img').attr('src');
		$('input.gresim').val(gresim);
		var $deger = $(this).attr("data-src");
		var $strsp = $deger.replace("thumb","large");
		$(".resim-crop a img").removeAttr("src");
		$(".resim-crop a img").attr('src',$deger);
		$(".resim-crop a").removeAttr('href');
		$(".resim-crop a").attr('href',$strsp);
	});
	
	
	
	/* Urun Detay */
	
	if($('.cihaniriboy-urun-slider').length > 0) {
	  var sync1 = $("#cihaniriboy-slider-1");
	  var sync2 = $("#cihaniriboy-slider-2");
	 
	  sync1.owlCarousel({
		singleItem : true,
		slideSpeed : 1000,
		navigation: false,
		pagination:false,
		afterAction : syncPosition,
		responsiveRefreshRate : 200,
	  });
	  sync2.owlCarousel({
		items : 4,
		itemsDesktop      : [1199,4],
		itemsDesktopSmall     : [979,4],
		itemsTablet       : [768,3],
		itemsMobile       : [479,3],
		pagination:false,
		responsiveRefreshRate : 100,
		afterInit : function(el){
		  el.find(".owl-item").eq(0).addClass("synced");
		}
	  });
	 
	  function syncPosition(el){
		var current = this.currentItem;
		$("#cihaniriboy-slider-2")
		  .find(".owl-item")
		  .removeClass("synced")
		  .eq(current)
		  .addClass("synced")
		if($("#cihaniriboy-slider-2").data("owlCarousel") !== undefined){
		  center(current)
		}
	  }
	 
	  $("#cihaniriboy-slider-2").on("click", ".owl-item", function(e){
		e.preventDefault();
		var number = $(this).data("owlItem");
		sync1.trigger("owl.goTo",number);
	  });
	 
	  function center(number){
		var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
		var num = number;
		var found = false;
		for(var i in sync2visible){
		  if(num === sync2visible[i]){
			var found = true;
		  }
		}
	 
		if(found===false){
		  if(num>sync2visible[sync2visible.length-1]){
			sync2.trigger("owl.goTo", num - sync2visible.length+2)
		  }else{
			if(num - 1 === -1){
			  num = 0;
			}
			sync2.trigger("owl.goTo", num);
		  }
		} else if(num === sync2visible[sync2visible.length-1]){
		  sync2.trigger("owl.goTo", sync2visible[1])
		} else if(num === sync2visible[0]){
		  sync2.trigger("owl.goTo", num-1)
		}
		
	  }
		// Arrows
	  $("#cihaniriboy-urunslider-right").click(function(){
		sync2.trigger('owl.next');
	  });
	  $("#cihaniriboy-urunslider-left").click(function(){
		sync2.trigger('owl.prev');
	  });	 
	}
	
		/* Fancy */
	
	if($('.erkaofisimo-img-list').length > 0){
		$('.erkaofisimo-img-list').magnificPopup({
		  delegate: 'a.erkaofisimo-u-zoom', 
		  type: 'image',
		  gallery:{
			enabled:true
			}
		});
		$('.erkaofisimo-img-list2').magnificPopup({
		  delegate: 'a.erkaofisimo-u-zoom2', 
		  type: 'image',
		  gallery:{
			enabled:true
			}
		});
	}
	
	
	$("#mail-birak").click(function(){
		$(this).html('<i class="fa fa-spinner fa-spin"></i>');
	     var $datam = "maillist="+$('input[name="maillist"]').val();
			$.ajax({
				type:'POST',
				url: 'ajax/maillist.php',
				data : $datam
			}).done(function(e){
				if(e != "ok"){
					swal({
					  type: 'error',
					  title: ''+e+'',
					  confirmButtonColor: '#333',
					});
					$("#mail-birak").html('Kayıt Ol');
				}else{
					swal({
					  type: 'success',
					  title: 'E-Mail Adresiniz Başarılır Bir Şekilde Kaydedilmiştir.',
					  confirmButtonColor: '#333',
					}).then(
					   function () { window.location.href = '/'; },
					   function () { return false; });
				}
			}).fail(function(){
				alert("hata");
			})
	});
	
	$(".grid-4").click(function(){
		$(".change-grid").removeClass("col-lg-4 col-md-4 col-md-12 col-xs-12 col-xs-12  col-sm-4 grid-full").addClass("col-lg-3 col-md-3 col-sm-3");
		return false;
	});
	$(".grid-3").click(function(){
		$(".change-grid").removeClass("col-lg-3 col-md-3 col-md-12 col-xs-12 col-xs-12 col-sm-3 grid-full").addClass("col-lg-4 col-md-4 col-sm-4");
		return false;
	});
	$(".grid-5").click(function(){
		$(".change-grid").removeClass("col-lg-3 col-md-3 col-sm-3 col-lg-4 col-md-4 col-sm-4").addClass("col-md-12 col-xs-12 col-xs-12 grid-full");
		return false;
	});

	
	  /* Logout */
	$('a.log-out').click(function(){
		
		$.ajax({
			type:'POST',
			data : 'veri=cikis',
			url : 'ajax/uyelik.php',
			cache: false
		}).done(function(gelen){
			console.log(gelen);
			if(gelen == "done"){
				window.location.href = '/';
			}else{
				alert(gelen);
			}
		}).fail(function(){
			alert("Hata-4");
		});
		return false;
	});	

	
	
		/* Remove Sepet */
	$(document).on("click", ".remove-sepet a", function(ev)
	{
		var id = $(this).attr('id');
		
		$('.overlay-sepet').show();	
		$.ajax({
			type:'POST',
			url : 'ajax/uyelik.php',
			data : 'veri=sepetsil&id='+id,
		}).done(function(done){
			var split = done.split('|x|');
			if(split[0] == "done"){
				$('.overlay-sepet').hide();	
				$('#first-sepet-ul ul:first').html(split[1]);
				$('#sepetsayi').html(split[2]);	
				$('.sepet-page-right .basket-right ul:first').html(split[3]);
				//hesapla();
				$('.sepet-table .trsepet'+id).remove();
				if(split[2] == 0){
					location.reload();
				}
			}else{
				alert("Silme İşleminde Sorun Oluştu");
			}
			
		}).fail(function(){ alert("Bir hata oluştu"); });
		return false;
	});
	
	
	/* Whatsup*/
	  $('.whatsappsiparis').click(function(){
		   if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			var sText = $(this).attr('data-text');
			var sUrl  = $(this).attr('data-link');
			var sMsg  = encodeURIComponent(sText) + " - " + encodeURIComponent(sUrl);
			var whatsapp_url = "whatsapp://send?text=" + sMsg;
			window.location.href = whatsapp_url;
		 }else{
			alert("Whatsapp client not available.");
		  }
		  return false;
	  });
	  
	  		
		$('a.favorite').click(function(){ 
			var urunid = $(this).attr('data-urun-id');
				$.ajax({
					type  : 'POST',
					data  : 'veri=favorite&urunid='+urunid,
					url   : 'ajax/uyelik.php',
					cache : false,
					success : function(result){	
						if(result != 'done'){
							swal({
							  type: 'error',
							  title: ''+result+'',
							  confirmButtonColor: '#333',
							});
						}else{
							swal({
							  type: 'success',
							  title: 'Ürün Listenize Eklenmiştir.',
							  confirmButtonColor: '#333',
							});
						}
						
					}, error: function (xhr, desc, err) {
						console.log("Details: " + desc + "\nError:" + err);
					}
				});
			return false;
		});
		
		
	   /*  Benzer ürünler */
	   
	   var owl7 = $('#owl-benzer-urunler');
		owl7.owlCarousel({
			loop:false,
			margin:20,
			nav:false,
			dots:false,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:4
				},
				1000:{
					items:4
				}
			}
		});

	 $("#cihaniriboy-benzer-right").click(function(){
		owl7.trigger('next.owl.carousel');
	  });
	  $("#cihaniriboy-benzer-left").click(function(){
		owl7.trigger('prev.owl.carousel');
	  });
	  
	  
	  
   	  /* Sepete Ekle */	
	  $(document).on("click", ".sepet-ekle a.hemen-al", function(ev){
		 $('.urun-sepete-ekle a:first').click();
		 var sd = $(this).attr('rel');
			//window.location.href = sd;
			return false;
	   });
	   
	
	
	
	
	  /* Main Sepete Ekle */ 
	  
	    $(document).on("click", "a.s-sepeteekle", function(ev){
			var id      = $(this).attr('id');
			var adet    = 1;

			var fiyat   = $(this).parents('.product-extra-link:first').find('input.mainurunfiyat').val();
			//var superteklif  = $(".urun-container").find('input[name=superteklif]').val();
			var varyant = $(this).parents().find('.select-varyants');
			var varyantArr = new Array();
			var error = false;
		
				if(adet  == undefined || adet == "") {
					adet = 1;
				}
				
				$.ajax({
					type:'POST',
					url : AJAX_URL+'/ajax/uyelik.php',
					data : { 
					  id   : id,
					  adet : adet,
					  fiyat  : fiyat,
					  varyant : varyantArr,
					  veri :'sepetekle'	
					}
				}).done(function(done){		
					var split = done.split('|x|');
					if(split[0] == "done"){
						$('.overlay-sepet').hide();	
						$('#first-sepet-ul ul:first').html(split[1]);
						$('.mini-cart-number span.color').html(' Ürün Sayısı '+ split[2] +'');	
						$('#mysepet').modal('show'); 
					}else if (split[0] == 'nostok' ){
						swal({
						  type: 'error',
						  title: yetersizstok,
						  confirmButtonColor: '#333',
						});
					}else{
						alert("Sepete Eklerken Sorun Oluştu");
					}
				}).fail(function(){ alert("Bir hata oluştu"); });
			return false;
	   });
	
	  /* Sepete Ekle */ 
	  
	  

	    $(document).on("click", ".custom-sepete-ekle", function(ev){
			var id      = $(this).attr('id');
			var bastarih = '';
			var bittarih = '';
			var adet       = $(this).parents().find('input.adet').val();
			var fiyat      = $("#var-selects").find('input.urun-fiyat').val();
			var varyant    = $(this).parents().find('.select-varyants');
			var seceneksay = $(this).parents().find('.normalseceneksay');
			var siparistarih = $(this).parents().find('.siparistarih').val();
			var siparissaat  = $(this).parents().find('.siparissaat').val();
			
				if($(this).parents().find('.tarihler .bastarih').length >0 ){
					bastarih = $(this).parents().find('.tarihler .bastarih').val();
				}
				if($(this).parents().find('.tarihler .bittarih').length >0 ){
					bittarih = $(this).parents().find('.tarihler .bittarih').val();
				}
				
			var varyantArr = new Array();
			var secenekler = new Array();
			var seceneklerId = new Array();
			var error = false;

			if(varyant.length == 0){ 
				varyantArr;
			}else{
				var count_selected,count_disabled,count_item;
				for(var i= 0; i < varyant.length; i++ ){ 
					count_selected = 0;
					if( $("#var-selects .select-varyants:eq("+i+")").val() != "" ){ count_selected=1; }
					count_disabled 	= $("#var-selects .select-varyants").eq(i).find('option:disabled').length;
					count_item		= $("#var-selects .select-varyants").eq(i).find('option').length;
					var iddegr = $("#var-selects .select-varyants").eq(i).val();
					var name = $("#var-selects .select-varyants").eq(i).attr('rel');
					if( count_selected < 1 && count_disabled < count_item-1){
						swal({
						  type: 'error',
						  title: name + " Seçimi Yapınız",
						  confirmButtonColor: '#333',
						});
						error = true;
						break;
					}
					if(iddegr == undefined || iddegr == ""){
						iddegr = '';
					}
					varyantArr[i] = iddegr;
					
				};


			}
			
			/*  Seçenek */
			if(seceneksay.length == 0){ 
				secenekler;
				seceneklerId;
			}else{
				for(var i= 0; i < seceneksay.length; i++ ){ 
					if( $(".secenekzorunlu:eq("+i+")").val() == ""){ 
						var secenekbaslik = $(".secenekzorunlu:eq("+i+")").attr('data-baslik');
						//var secenekdeger  = $(".modulinput:eq("+i+")").eq(i).val();
						swal({
						  type: 'error',
						  title: secenekbaslik +  'Alanını Boş Bırakmayınız',
						  confirmButtonColor: '#333',
						});
						return false;
					}
					//secenekler[i] = secenekdeger;
				};
				
				var x = -1;
				
				$('.modulinput').each(function(e){
					x++;
					var secenekdeger = $(this).val();
					var secenekid    = $(this).attr('data-id');
					secenekler[x] 	 = secenekdeger;
					seceneklerId[x]  = secenekid;
 				});
				
				
			}
		
		
				
			
			if(error == false){
				if(adet  == undefined || adet == "") {
					adet = 1;
				}
				$.ajax({
					type:'POST',
					url : 'ajax/uyelik.php',
					data : { 
					  id   : id,
					  adet : adet,
					  fiyat  : fiyat,
					  varyant : varyantArr,
					  secenekler : secenekler,
					  seceneklerid : seceneklerId,
					  siparistarih : siparistarih,
					  siparissaat   : siparissaat,
					  bastarih     :bastarih,
					  bittarih     :bittarih,
					  veri :'sepetekle'	
					}
				}).done(function(done){		
					var split = done.split('|x|');
					
						if(split[0] == "done"){
							$('.overlay-sepet').hide();	
							$('#first-sepet-ul ul:first').html(split[1]);
							$('.sepetsayi').html(''+ split[2] +'');	
							$('#mysepet').modal('show'); 
						}else if (split[0] == 'empty' ){
							swal({
							  type: 'error',
							  title: secimyapiniz,
							  confirmButtonColor: '#333',
							});
						}else if (split[0] == 'nostok' ){
							swal({
							  type: 'error',
							  title: yetersizstok,
							  confirmButtonColor: '#333',
							});
						}else{
							alert("Sepete Eklerken Sorun Oluştu");
						}
				}).fail(function(){ alert("Bir hata oluştu"); });
			
			}
		return false;
	});
	
	/* Edit */

	
		
		
			// Timepicker
		if($.isFunction($.fn.timepicker))
		{
			$('.timepicker').timepicker({ 
				showSeconds :false
			});
			
		}
	
});


/*===================================================================================*/
/*  TOOLTIP 
/*===================================================================================*/
jQuery("[data-toggle='tooltip']").tooltip(); 




})