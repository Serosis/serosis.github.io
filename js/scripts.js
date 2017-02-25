$(document).ready(function(){
	$('.swipebox').swipebox();
});
(function($) {
	"use strict"; // Start of use strict

	// jQuery for page scrolling feature - requires jQuery Easing plugin
	$('a.page-scroll').bind('click', function(event) {
		var $anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: ($($anchor.attr('href')).offset().top - 0)
		}, 1250, 'easeInOutExpo');
		event.preventDefault();
	});

	// Highlight the top nav as scrolling occurs
	$('body').scrollspy({
		target: '.navbar-fixed-top',
		offset: 0
	})

	// Closes the Responsive Menu on Menu Item Click
	$('.navbar-collapse ul li a').click(function() {
		$('.navbar-toggle:visible').click();
	});
})(jQuery); // End of use strict
$(function(){
	var audio;
	var playlist;
	var tracks;
	var current;
	var len;
	var link;
	var par;

	init();
	function init(){
		current = 0;
		audio = $('#player');
		playlist = $('#playlist');
		tracks = playlist.find('#tracks');
		len = tracks.length - 1;
		audio[0].volume = '.50';
		playlist.find('a').click(function(e){
			e.preventDefault();
			link = $(this);
			current = link.parent().index();
			run(link, audio[0]);
		});
		audio[0].addEventListener('ended',function(){
			current++;
			if(current == len){
				current = 0;
				link = playlist.find('a')[0];
			} else {
				link = playlist.find('a')[current];
			}
			run($(link),audio[0]);
		});
	}
	function run(link, player){
		player.src = link.attr('href');
		par = link.parent();
		//par.addClass('active').siblings().removeClass('active');
		audio[0].load();
		audio[0].play();
	}
});