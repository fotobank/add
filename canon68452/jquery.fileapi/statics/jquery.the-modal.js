/**
 * The modall jQuery plugin
 *
 * @author Alexander Makarov <sam@rmcreative.ru>
 * @link https://github.com/samdark/the-modall
 * @version 1.0
 */
;(function($, window, document, undefined) {
	"use strict";
	/*jshint smarttabs:true*/

	var pluginNamespace = 'the-modall',
		// global defaults
    	defaults = {
			overlayClass: 'themodall-overlay',

			closeOnEsc: true,
			closeOnOverlayClick: true,

			onClose: null,
			onOpen: null,

			cloning: true
        };

	function lockContainer() {
		$('html,body').addClass('lock');
	}
	
	function unlockContainer() {
		$('html,body').removeClass('lock');
	}

	function init(els, options) {
		var modallOptions = options;

		if(els.length) {
			els.each(function(){
				$(this).data(pluginNamespace+'.options', modallOptions);
			});
		}
		else {
			$.extend(defaults, modallOptions);
		}

		return {
			open: function(options) {
				var el = els.get(0);
				var localOptions = $.extend({}, defaults, $(el).data(pluginNamespace+'.options'), options);

				// close modall if opened
				if($('.'+localOptions.overlayClass).length) {
					$.modall().close();
				}
				
				lockContainer();

				var overlay = $('<div/>').addClass(localOptions.overlayClass).prependTo('body');
				overlay.data(pluginNamespace+'.options', options);

				if(el) {
					if (!localOptions.cloning) {
						overlay.data(pluginNamespace+'.el', el);
						$(el).data(pluginNamespace+'.parent', $(el).parent());
						$(el).appendTo(overlay).show();
					} else {
						$(el).clone(true).appendTo(overlay).show();
					}
				}

				if(localOptions.closeOnEsc) {
					$(document).bind('keyup.'+pluginNamespace, function(e){
						if(e.keyCode === 27) {
							$.modall().close();
						}
					});
				}

				if(localOptions.closeOnOverlayClick) {
					overlay.children().on('click.' + pluginNamespace, function(e){
						e.stopPropagation();
					});
					$('.' + localOptions.overlayClass).on('click.' + pluginNamespace, function(e){
						$.modall().close();
					});
				}

				$(document).bind('touchmove.'+pluginNamespace,function(e){
					if(!$(e).parents('.' + localOptions.overlayClass)) {
						e.preventDefault();
					}
				});

				if(localOptions.onOpen) {
					localOptions.onOpen(overlay, localOptions);
				}
			},
			close: function() {
				var el = els.get(0);

				var localOptions = $.extend({}, defaults, options);
				var overlay = $('.' + localOptions.overlayClass);
				$.extend(localOptions, overlay.data(pluginNamespace+'.options'));

				if (!localOptions.cloning) {
					if (!el) {
						el = overlay.data(pluginNamespace+'.el');
					}
					$(el).appendTo($(el).data(pluginNamespace+'.parent'));
				}

				overlay.remove();
				unlockContainer();

				if(localOptions.closeOnEsc) {
					$(document).unbind('keyup.'+pluginNamespace);
				}

				if(localOptions.onClose) {
					localOptions.onClose(overlay, localOptions);
				}
			}
		};
	}

	$.modall = function(options){
		return init($(), options);
	};

	$.fn.modall = function(options) {
		return init(this, options);
	};


    $.modall.getAvailableWidth = function (width){
        return	Math.min($(window).width() - 100, width);
    };

    $.modall.getAvailableHeight = function (height){
        return	Math.min($(window).height() - 100, height);
    };

})(jQuery, window, document);
