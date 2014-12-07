$(document).ready(function() {
	// Adds title attributes and classnames to list items	 
	$("ul li a:contains('Dashboard')").addClass("dashboard").attr('title', 'Dashboard');
	$("ul li a:contains('Pages')").addClass("pages").attr('title', 'Pages');
	$("ul li a:contains('Media')").addClass("media").attr('title', 'Media');
	$("ul li a:contains('History')").addClass("history").attr('title', 'History');
	$("ul li a:contains('Messages')").addClass("messages").attr('title', 'Messages');
	$("ul li a:contains('Settings')").addClass("settings").attr('title', 'Settings');
	
	
	$("nav").height($(document).height());
	
	// Add class to last list item of submenu	
	$("ul.submenu li:last-child").addClass("last");
	
	
	// Append Plus icon on thumbnail hover
	$(".gallery a").hover(function(){
		$(this).append("<span style='display:none'>&oplus;</span>").find("span").fadeIn(500);
	}, function(){
		$(this).find("span").fadeOut(500);
	});
	
	//  Tmeline load
	i=200;
	$(".tl-post").each(function(){
		$(this).delay(i).animate({"opacity" : 1});
		i=i+200;
	});
	
	// Table sorter
	$("#myTable").tablesorter();
	$("tr:not(.table-head):odd").addClass("odd");
	
	// Equal height divs - www.broken-links.com
	var highestCol = Math.max($('.widget-container > .widget').height(),$('.widget-container > .widget').height());
	$('.widget-container > .widget').height(highestCol);
		
	// Setttings dropdown menu	
	$("header span").hover(function(){
		$(this).find("ul").stop("true", "true").slideDown(500);
	}, function(){
		$(this).find("ul").stop("true", "true").slideUp(500);
	});
	
	// Notification/inbox dropdown menu
	$(".dropdown:has(ul)").hover(function(){
		$(this).find("ul").stop("true", "true").slideDown(500);
	}, function(){
		$(this).find("ul").stop("true", "true").slideUp(500);
	});	
	
	// Hide alert
	$(".close").click(function(){
		$(this).parent().parent().fadeOut(500);
		$(".content").delay(300).animate({"marginTop" : 0});
	});
	
	// Navigation accordion menu
	$(window).bind("load resize", function(){
		if ($("nav").width() > 100) {
			$("nav ul li:has(ul)").hover(function(){
				$(this).find("ul.submenu").stop("true", "true").slideDown(500);
			}, function(){
				$(this).find("ul.submenu").stop("true", "true").delay(100).slideUp(500);
			});
		} else {
			$("nav ul li ul").empty();
		}
	});
	
	// Mobile navigation
	
	$(".ico-font").toggle(function(){
		$("nav").animate({"left" : 0}, 20);
		$("section.content").animate({ marginLeft: 215, marginRight: -215}, 20);
		$("section.alert").animate({ marginLeft: 215}, 20);
	}, function(){
		$("nav").animate({"left" : "-215px"});
		$("section.content").animate({ marginLeft: 0, marginRight: 0}, 400);
		$("section.alert").animate({ marginLeft: 0, marginRight: 0}, 400);
		return false;
	});
	
	// iPhone style checkbox
	$('header aside span input[type=checkbox]').checkbox();
	
	$('.settings-dd li input').each(function(){
	    $(this).next('span').andSelf().wrapAll('<div class="checkbox-wrap"/>');
	});
	
	// Clear input fields on focus
	$('input').each(function() {
		var default_value = this.value;
		$(this).focus(function(){
		   if(this.value == default_value) {
		           this.value = '';
		   }
		});
		$(this).blur(function(){
		   if(this.value == '') {
		           this.value = default_value;
		   }
		});
	});
	
	tinymce.init({
		selector: "textarea.post",
		theme: "modern",
		plugins: [
			"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"save table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker"
		],
		external_plugins: {
			//"moxiemanager": "/moxiemanager-php/plugin.js"
		},
		content_css: "css/development.css",
		add_unload_trigger: false,
		autosave_ask_before_unload: false,

		toolbar1: "save newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
		toolbar2: "cut copy paste pastetext | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media help code | insertdatetime preview | forecolor backcolor",
		toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft | insertfile insertimage",
		menubar: false,
		toolbar_items_size: 'small',

		style_formats: [
			{title: 'Bold text', inline: 'b'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		],

		templates: [
			{title: 'My template 1', description: 'Some fancy template 1', content: 'My html'},
			{title: 'My template 2', description: 'Some fancy template 2', url: 'development.html'}
		],

        spellchecker_callback: function(method, data, success) {
			if (method == "spellcheck") {
				var words = data.match(this.getWordCharPattern());
				var suggestions = {};

				for (var i = 0; i < words.length; i++) {
					suggestions[words[i]] = ["First", "second"];
				}

				success({words: suggestions, dictionary: true});
			}

			if (method == "addToDictionary") {
				success();
			}
		}
	});
	
	// Sticky sidebar
	
	$(window).bind("load resize", function(){
	if ( $(window).width() > 768) {
	    var aboveHeight = $('.testing').outerHeight();
	
	    $(window).scroll(function(){
			if ($(window).scrollTop() > aboveHeight){
	            $('nav').addClass('fixed').css('top','0').next()
	
	            } else {
	
	            $('nav').removeClass('fixed').css('top','0')
	        }
	    });
	 }
	 });
    
    	
});