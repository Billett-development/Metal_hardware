// Initialize popup as usual

define(
[
	"Vsourz_Imagegallery/js/jquery.magnific-popup.min"
],

function ($, Component) {
    'use strict';
	
jQuery(function($) {
		// Popup image
		$('.image-link').magnificPopup({ 
		  type: 'image'
		});
		
		// Gallery
		jQuery('.image-link.gallery-block').magnificPopup({
		  type: 'image',
		  gallery:{
			enabled:true,		
			preload: function(e){
				var interval,
	hasSize,
	onHasSize = function() {
		if(hasSize) return;

		// we ignore browsers that don't support naturalWidth
		var naturalWidth = img[0].naturalWidth;

		if(window.devicePixelRatio > 1 && naturalWidth > 0) {
			img.css('max-width', naturalWidth / window.devicePixelRatio);
		}

		clearInterval(interval);
		hasSize = true;
	},
	onLoaded = function() {
		onHasSize();
	},
	onError = function() {
		onHasSize();
	},
	checkSize = function() {
		if(img[0].naturalWidth > 0) {
			onHasSize();
		}
	},
	img = $('<img />')
		.on('load', onLoaded)
		.on('error', onError)
		// hd-image.jpg is optimized for the current pixel density
		.attr('src', 'hd-image.jpg')
		.appendTo(someContainer);

interval = setInterval(checkSize, 100);
checkSize();	
			}
			
		  }
		  
		});
		
		// Zoom popup
		$('.image-link.zoom').magnificPopup({ 
		  type: 'image',
		  mainClass: 'mfp-with-zoom', // this class is for CSS animation below
		  zoom: {
			enabled: true, // By default it's false, so don't forget to enable it
			duration: 300, // duration of the effect, in milliseconds
			easing: 'ease-in-out', // CSS transition easing function 
			opener: function(openerElement) {
			  return openerElement.is('img') ? openerElement : openerElement.find('img');
			}
		  }
		});
		
});		
				
});