	/*== Loader == =*/
    $(window).load(function() {

        $(".zr-loading").fadeOut();
    });

	
				
	

		
				

	
		
	/*== Checkbox =*/
	function replaceCheckboxes()
	{
		var $ = jQuery;
		
		$(".checkbox-replace:not(.cb-replacement), .radio-replace:not(.cb-replacement)").each(function(i, el)
		{
			var $this = $(el),
				$input = $this.find('input:first'),
				$wrapper = $('<label class="cb-wrapper" />'),
				$checked = $('<div class="checked" />'),
				checked_class = 'checked',
				is_radio = $input.is('[type="radio"]'),
				$related,
				name = $input.attr('name');
			

			$this.addClass('cb-replacement');
		
			$input.wrap($wrapper);
			
			$wrapper = $input.parent();
			
			$wrapper.append($checked).next('label').on('click', function(ev)
			{	
				$wrapper.click();
			});
			
			$input.on('change', function(ev)
			{	
				if(is_radio)
				{
					$(".cb-replacement input[type=radio][name='"+name+"']:not(:checked)").closest('.cb-replacement').removeClass(checked_class);
				}
				
				if($input.is(':disabled'))
				{
					$wrapper.addClass('disabled');
				}
				
				$this[$input.is(':checked') ? 'addClass' : 'removeClass'](checked_class);
				
			}).trigger('change');
		});
	}
	/* Custom Color */
	function fontcolor(){
		$(".colorpicker").each(function(i, el)
		{
			var $this = $(el),
				opts = {
				},
				$n = $this.next(),
				$p = $this.prev(),

				$preview = $this.siblings('.input-group-addon').find('.color-preview');

			$this.colorpicker(opts);

			if($n.is('.input-group-addon') && $n.has('a'))
			{
				$n.on('click', function(ev)
				{
					ev.preventDefault();

					$this.colorpicker('show');
				});
			}

			if($p.is('.input-group-addon') && $p.has('a'))
			{
				$p.on('click', function(ev)
				{
					ev.preventDefault();

					$this.colorpicker('show');
				});
			}

			if($preview.length)
			{
				$this.on('changeColor', function(ev){

					$preview.css('background-color', ev.color.toHex());
				});

				if($this.val().length)
				{
					$preview.css('background-color', $this.val());
				}
			}
		});
	}


$(function(){
	$(window).setBreakpoints({
			distinct: true, 
			breakpoints: [
				320,
				480,
				768,
				1024
			] 
		});
		
	
	/*== Sol Menu Nice Scroll =*/
	if ($.fn.niceScroll) {
			
      	$(".sidebar").niceScroll({
				cursorcolor: "#1FB5AD",
				cursorborder: "0px solid #fff",
				cursorborderradius: "0px",
				cursorwidth: "4px"
		 });
		 $(".sidebar").getNiceScroll().resize();
	     if ($('.sidebar-content').hasClass('zr-mobile-sidebar')) {
			$(".sidebar").getNiceScroll().hide();
		}
		if ($('.sidebar-content').hasClass('normal-sidebar')) {
			$(".sidebar").getNiceScroll().hide();
		}
		$(".sidebar").getNiceScroll().show();   
       
	   $(".nice-box-content").niceScroll({
			cursorcolor: "#333",
			cursorborder: "0px solid #fff",
			cursorborderradius: "0px",
			cursorwidth: "7px",
			autohidemode:false,
		 });  
		 
		 $(".nice-box-content").getNiceScroll().resize();		 
	}
	
	$mobile_collapse 	= $('.mobile-menu > a');
	$collapse 			= $('.collapse-menu > a');
	$sidebar   	 		= $(".sidebar-content");
	$content    		= $(".content");
	$zr_menu 		    = $("ul#zr-menum");
	$submenu	  		= $zr_menu.find('li:has(ul)');
	$submenu.each(function(i, el){ var $this = $(el); $this.addClass('arrow'); });	
	$('.sidebar-content  ul > li > a').on('click', function (e) {
		if ($(this).next().hasClass('sub-menu') == false) {
                return;
		}
		$(".sidebar").niceScroll({
				cursorcolor: "#1FB5AD",
				cursorborder: "0px solid #fff",
				cursorborderradius: "0px",
				cursorwidth: "4px"
		 });	
		  $(".sidebar").getNiceScroll().resize();
		 if ($('.sidebar-content').hasClass('zr-mobile-sidebar')) {
			$(".sidebar").getNiceScroll().hide();
		}
		if ($('.sidebar-content').hasClass('normal-sidebar')) {
			$(".sidebar").getNiceScroll().hide();
		}
		$(".sidebar").getNiceScroll().show();  
			
			var o = ($(this).offset());
           var diff = 45 - o.top;	
			if (diff > 0){
                $(".sidebar").scrollTo("-=" + Math.abs(diff), 500);
            }else{
                $(".sidebar").scrollTo("+=" + Math.abs(diff), 500);
			}
			
		
		var alt_span = $(this).find('span');
		 if(alt_span.length){
			  if(!$(this).find('span').hasClass('firstshow')){
					$('.sidebar-content li a').find('span').removeClass('firstshow');
					$(this).find('span').addClass('firstshow');
				}else{
					$('.sidebar-content li a').find('span').removeClass('firstshow');
				}
		 }
		
		  var parent = $(this).parent().parent();
          parent.children('li.open').children('.sub-menu').slideUp(500);
          parent.children('li.open').removeClass('open');
		  var sub = $(this).next();
		   if (sub.is(":visible")) {
				$('.arrow', $(this)).removeClass("open");
                $(this).parent().removeClass("open");
                sub.slideUp();
            } else {
                $('.arrow', $(this)).addClass("open");
                $(this).parent().addClass("open");
                sub.slideDown(500);
            }
		  
		 e.preventDefault();
	});
	
	/* Normal Collapse Menu İşlemler */ 
	
	$($collapse).click(function(){
		if($sidebar.hasClass('normal-sidebar')){
			$sidebar.removeClass('normal-sidebar');
			$content.removeClass('content-right');
			$('.sidebar').css({"overflow":"hidden"});
			$(".sidebar").getNiceScroll().show();
			$(".sidebar").getNiceScroll().resize();
		}else{
			$sidebar.addClass('normal-sidebar');
			$content.addClass('content-right');
			 $(".sidebar").getNiceScroll().hide();
			 $('.sidebar').css({"overflow":"inherit"});
		}
		return false;
	});
	
		/* Mobile Menu İşlemler */ 
	$($mobile_collapse).click(function(){
		if($zr_menu.hasClass('mobile_show_menu')){
			$zr_menu.removeClass('mobile_show_menu');
		}else{
		    $zr_menu.addClass('mobile_show_menu');
		}
		return false;	
	});

	
	$(window).bind('enterBreakpoint768',function() {
			$sidebar.addClass('normal-sidebar');
			$content.addClass('content-right');
		});	  
		$(window).bind('exitBreakpoint768',function() {
			$sidebar.removeClass('normal-sidebar');
			$content.removeClass('content-right');	
		});
		$(window).bind('enterBreakpoint480',function() {
			$sidebar.removeClass('normal-sidebar');	
			$content.removeClass('content-right');	

		});
		$(window).bind('enterBreakpoint320',function() {
			$sidebar.removeClass('normal-sidebar');
			$content.removeClass('content-right');	

		});
		$(window).bind('enterBreakpoint1024',function() {
			$sidebar.removeClass('normal-sidebar');
			$content.removeClass('content-right');
		});	
		$(window).bind('exitBreakpoint1024',function() {
			$sidebar.removeClass('normal-sidebar');
			$content.removeClass('content-right');
		});	
	
	/* Ön Yüz Collapse Ve Kapat*/
	$('.panel-heading .panel-options a').on("click", function () {
			var pl = $(this).attr("data-rel");
			if(pl == 'close'){
				$(this).parents('.panel').fadeOut();
				
			} else if (pl == 'collapse'){
				
				if ($(this).hasClass('panel-collapsed')) {
					$(this).parents('.panel').find('.panel-body').slideDown();
					$(this).removeClass('panel-collapsed');
				}else{
					$(this).parents('.panel').find('.panel-body').slideUp();
					$(this).addClass('panel-collapsed');
				}
			}
			return false;
	});
		
	// File Input
	if($.isFunction($.fn.fileinput))
	{	
		$('.fileinput').fileinput();
	
	}
	
	// Tagsinput
	if($.isFunction($.fn.tagsinput))
		{
			$(".tagsinput").tagsinput();
		}
		
	// SelectBoxIt Dropdown replacement
	if($.isFunction($.fn.selectBoxIt))
	{
		$('select.selectboxit').selectBoxIt( {autoWidth: false });
	}	
		
		
		///// Table 2 Ayarları
	$("#table-2 input[type=checkbox]").click(function(){
		if( $(this).is(':checked') ) {
			$(this).attr('checked', true);

		} else {
			$(this).attr('checked', false);
		}
	});

	var a; 

//// Click All On Table
$("#check-all-2").on("click",function(){
	if( $(this).is(':checked') ) {
			 a =$('input[type=checkbox]').prop('checked', true);
			 $(a).parent().parent().addClass('checked');
		} else {
			 a = $('input[type=checkbox]').prop('checked', false);
			 $(a).parent().parent().removeClass('checked');
		}
});

////// Search
	$(".s_ara").submit(function(e){
		e.preventDefault();
		var dtxx = $("input.fast_search").val();
		window.location.href="index.php?do=ara&s="+dtxx;
	});
	$(".s_ara2").submit(function(e){
		e.preventDefault();
		var dtxx = $("input.fast_search2").val();
		window.location.href="index.php?do=ara&s="+dtxx;
	});
	//// Cache Remove 
	$("a.removecache").click(function(){
		bootbox.confirm("Cacheyi Boşaltmak İstediğinize Eminmisiniz?", function(result) {
			if (result) {
				$.ajax({
					type:'POST',
					url : 'ajax/siteislem.php',
					data: 'veri=cachesil',
				}).done(function(gelen){
					if(gelen == '1'){
						window.location.reload();
					}
				}).fail(function(){ alert("Dosya Bulunamadı");});
			}
		});
	});
	// Tiny 

		tinymce.init({
			editor_selector: "mcEditor",
			editor_deselector : "mceNoEditor",
			fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
			theme: "modern",
			 mode : "textareas",
			skin: 'light',
			// mode : "exact",
			language : 'tr_TR',
			
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern textcolor responsivefilemanager"
			],
			
			toolbar1: "sizeselect | fontselect |  fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			toolbar2: "print preview media | forecolor backcolor | responsivefilemanager",
			image_advtab: true,
			//Open Manager Options
			external_filemanager_path:"/filemanager/",
			filemanager_title:"Responsive Filemanager", 
			external_plugins: { "filemanager" : "plugins/responsivefilemanager/plugin.min.js"} 
	});	

	// Checkbox 
	
	replaceCheckboxes();
	
	/*Spinner*/
			
			
	$(".input-spinner > button").on('click', function(ev)
			{
				ev.preventDefault();
				var $this = $(this);
				$input = $this.parents('.input-spinner').find('input');
				 min = 0;
				 max = 500;
				var $def = $(this).text();
					 val = $input.val();
					 if($def == "+"){
						val++;
					 }
					 if ($def == "-"){
						val--;
					 }
					if( ! val.toString().match(/^[0-9-\.]+$/))
					{
						val = 0;
					}
					$input.val( parseFloat(val)).trigger('keyup');
				
			});
		$(".input-spinner").keyup(function()
			{
				if(min != null && parseFloat($input.val()) < min)
				{
					$input.val(min);
				}
				else
				
				if(max != null && parseFloat($input.val()) > max)
				{
					$input.val(max);
				}
		});
	// Select 2
	if($.isFunction($.fn.select2))
		{	
		$(".select2").addClass('visible');
		$(".select2").select2( {
			 allowClear: true,
		});
	}
	// Multi-select
		if($.isFunction($.fn.multiSelect))
		{
			$(".multi-select").multiSelect();
		}
		

			


	if($.isFunction($.fn.niceScroll))
		{
			$(".select2-results").niceScroll({
				cursorcolor: '#d4d4d4',
				cursorborder: '1px solid #ccc',
				railpadding: {right: 3}
			});
		}
		
		// Colorpicker
		if($.isFunction($.fn.colorpicker))
		{
			$(".colorpicker").each(function(i, el)
			{
				var $this = $(el),
					opts = {
					},
					$n = $this.next(),
					$p = $this.prev(),
					
					$preview = $this.siblings('.input-group-addon').find('.color-preview');
				
				$this.colorpicker(opts);
				
				if($n.is('.input-group-addon') && $n.has('a'))
				{
					$n.on('click', function(ev)
					{
						ev.preventDefault();
						
						$this.colorpicker('show');
					});
				}
				
				if($p.is('.input-group-addon') && $p.has('a'))
				{
					$p.on('click', function(ev)
					{
						ev.preventDefault();
						
						$this.colorpicker('show');
					});
				}
				
				if($preview.length)
				{
					$this.on('changeColor', function(ev){
						
						$preview.css('background-color', ev.color.toHex());
					});
					
					if($this.val().length)
					{
						$preview.css('background-color', $this.val());
					}
				}
			});
		}
		
		// Date Picker 
		if($.isFunction($.fn.datepicker))
		{
			$('.datepicker').datepicker({
				format: 'dd/mm/yyyy',
				startDate: '-3d'
			});
			$('.datepicker6').datepicker({
				format: 'yyyy-mm-dd',
				startDate: '-3d'
			});
			$('.datepicker2').datepicker({
				format: 'yyyy-mm-dd',
				startDate: '-3d'
			});
			$('.datepicker3').datepicker({
				format: 'yyyy-mm-dd',
				changeYear:true,
                changeMonth: true,
                yearRange: '-100:+0',
			});
			$('.datepicker4').datepicker({
				format: 'yyyy-mm-dd',
				startDate: '-3d'
			});
		}
	
	// Wysiwyg Editor
	
	if($.isFunction($.fn.wysihtml5))
	{
		
		$(".wysihtml5").wysihtml5();
		
	}	
	
	   /* Manuel Collapse */

    $('body').on('click','.toggle',function(e) {
        var $this = $(this);
        if(!$this.hasClass('collapsed')){
            $this.addClass('collapsed');
        }else{
            $this.removeClass('collapsed');
        }
        $this.parent().parent().next().stop().slideToggle();
    });

    /* Font Color */

    fontcolor();
	
	/* Tool Tip */
	  //$('[data-toggle="tooltip"]').tooltip(); 
	  $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});
	  
	  
	  
	  	// Timepicker
		if($.isFunction($.fn.timepicker))
		{
			
			$('.timepicker').timepicker({ 
				showSeconds :false
			});
			
		}

		
});
