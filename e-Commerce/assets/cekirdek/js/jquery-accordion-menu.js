
/*
Item name: jQuery Accordion Menu
Author: http://codecanyon.net/user/marcoarib
License: http://codecanyon.net/licenses
*/

;(function ( $, window, document, undefined ) {

	var pluginName = "jqueryAccordionMenu";
	var defaults = {
			speed: 300,
			showDelay: 0,
			hideDelay: 0,
			singleOpen: true,
			clickEffect: true
		};

	function Plugin ( element, options ) {
		this.element = element;
		this.settings = $.extend( {}, defaults, options );
		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	};
	
	$.extend(Plugin.prototype, {
		
		init: function () {
			this.openSubmenu();
			this.submenuIndicators();
			if(this.settings.clickEffect){
				this.addClickEffect();
			}
		},
		
		openSubmenu: function () {
			var opts = this.settings; //to differ from local variable "this"
			$(this.element).children("ul").find("li").bind("click touchstart", function(e){
				e.stopPropagation(); 
				e.preventDefault();
				if($(this).children(".submenu").length > 0){
					if($(this).children(".submenu").css("display") == "none"){
						$(this).children(".submenu").delay(opts.showDelay).slideDown(opts.speed);
						$(this).children(".submenu").siblings("a").addClass("submenu-indicator-minus");
						if(opts.singleOpen){
							$(this).siblings().children(".submenu").slideUp(opts.speed);
							$(this).siblings().children(".submenu").siblings("a").removeClass("submenu-indicator-minus");
						}
						return false;
					}
					else{
						$(this).children(".submenu").delay(opts.hideDelay).slideUp(opts.speed);
					}
					if($(this).children(".submenu").siblings("a").hasClass("submenu-indicator-minus")){
						$(this).children(".submenu").siblings("a").removeClass("submenu-indicator-minus");
					}
				}
				window.location.href = $(this).children("a").attr("href");
			});
		},
		
		submenuIndicators: function () {
			if($(this.element).find(".submenu").length > 0){
				$(this.element).find(".submenu").siblings("a").append("<span class='submenu-indicator'>+</span>");
			}
		},
		
		addClickEffect: function () {
			var ink, d, x, y;
			$(this.element).find("a").bind("click touchstart", function(e){
				
				$(".ink").remove();
				
				if($(this).children(".ink").length === 0){
					$(this).prepend("<span class='ink'></span>");
				}
				
				ink = $(this).find(".ink");
				ink.removeClass("animate-ink");
				
				if(!ink.height() && !ink.width()){
					d = Math.max($(this).outerWidth(), $(this).outerHeight());
					ink.css({height: d, width: d});
				}
				
				x = e.pageX - $(this).offset().left - ink.width()/2;
				y = e.pageY - $(this).offset().top - ink.height()/2;
	  
				ink.css({top: y+'px', left: x+'px'}).addClass("animate-ink");
			});
		}
		
	});

	$.fn[ pluginName ] = function ( options ) {
		this.each(function() {
			if ( !$.data( this, "plugin_" + pluginName ) ) {
				$.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
			}
		});
		return this;
	};
	
})( jQuery, window, document );
