<script>
	function NGOCTRAN() {
		var SELF = this,
			$progressbar = $( "#progressbar" );
		SELF.uuid = '<?php echo $this->session->userdata('uuid'); ?>';
		SELF.pusher = new Pusher('54120ecb88a7a7dc598b');
		
		SELF.channel = SELF.pusher.subscribe(SELF.uuid);
		
		SELF.setupProgressingBar = function(){
			$progressbar.progressbar();
			$progressbar.css('display', 'none');
		},
		SELF.setupRating = function(){
			$('#review_score .star').rating();
		},
		SELF.reviewSubmit = function() {
			$('form[name="review_form"]').submit(function(event){
				var postData = $(this).serializeArray();
				var formUrl = $(this).attr("action");
				$.ajax({
					type: 'POST',
					url: formUrl,
					dataType: 'json',
					data: postData,
					success: function(data, xhr){
						if (data['status'] != 'true') {
							$.each(data['error'], function(index){
								$('#review_'+index + ' .error').remove();
								$('#review_'+index)
									.append('<small class="error">'+data['error'][index]+'</small>');
							});
						} else {
							$.get('<?php echo base_url("/index.php/restaurant/show_restaurant/308"); ?>', function(html){
									new_html = $(html).find('.comments').html();
									//$('.comments').html('');
									$('#comments-listing').html(new_html);
									$('#comments-listing .star').rating(); 
									ngoctran.reviewSubmit();
							});
						}
					}
				});
				return false; //disable refresh
			});
		}
		SELF.indicateProgressing = function(percentComplete) {
			console.log(percentComplete);
			if (percentComplete > 0 && percentComplete < 100) {
				$progressbar.css('display', 'block');
				$progressbar.progressbar( "option", "value", percentComplete );
			} else {
				$progressbar.css('display', 'none');
			}
			
		},
		SELF.preloader = function () {
			jQuery("#status").fadeOut();
			
			jQuery("#preloader").delay(1000).fadeOut("slow");
		},
		SELF.setupFoundation = function (){
			$(document).foundation();		
		},
		SELF.setupWow = function(){
			new WOW().init();
		}
		SELF.setupDatepicker = function() {
			$( "#dob" ).datepicker({
				dateFormat: "dd-mm-yy"
			});
		},
		SELF.setupDropzone = function() {
			$(".user-photos").dropzone({ url: "/file/post" });			
		},
		SELF.setupAutocomplete = function(){
			$('#s_keyword').autocomplete({
				serviceUrl: '<?php echo base_url("index.php/user/search/search_suggestion") ?>',
			});
		},
		SELF.setupMap = function() {
			$('#map_canvas').gmap3({
				map:{
					options: {
						scrollwheel: false,
						zoom: 5
					}
				}
			});
		},
		SELF.setupSearch = function(){
			$('#s_keyword').keypress(function(e){
				if (e.keyCode == 13 && !e.shiftKey) {
					e.preventDefault();
					SELF.doAjaxSearch();
				}
			});
			$('#search_map_btn').click(SELF.doAjaxSearch);
		},
		SELF.mapCenter = function () {
		    // define where the center of the map lies...
		    this.center_lng = 0.00;
		    this.center_lat = 0.00;
		     
		    // these are just used to calc the center of the map...
		    this.max_lng = 0.00;
		    this.min_lng = 0.00;
		    this.max_lat = 0.00;
		    this.min_lat = 0.00;		     

		    this.adjustCenterCoords = function(lat, lng) {
		        if (lat == undefined || lng == undefined)
		            return false;
	            
		        // first time through, set them all to the first lat/lng pair
		        if (this.max_lng == 0.00 && this.max_lat == 0.00) {
		            this.max_lng = lng;
		            this.min_lng = lng;
		            this.max_lat = lat;
		            this.min_lat = lat;
		            this.center_lng = lng;
		            this.center_lat = lat;
		            
		        } else {
		            this.max_lng = Math.max(lng, this.max_lng);
		            this.min_lng = Math.min(lng, this.min_lng);
		            this.max_lat = Math.max(lat, this.max_lat);
		            this.min_lat = Math.min(lat, this.min_lat);
		            this.center_lng = (this.min_lng + this.max_lng) / 2.;
		            this.center_lat = (this.min_lat + this.max_lat) / 2.;
		        }
		    }
		},
		SELF.doAjaxSearch = function(){
			$.ajax({
				type: 'POST',
				url: '<?php base_url()?>index.php/user/search/search_res',
				dataType: 'json',
				data: {
					ihf_event: 'search_res_in_map',
					s_postcode: $('#s_postcode').val(),
					s_country: $('#s_country').val(),
					s_keyword: $('#s_keyword').val()
				},
				success: function(data, xhr){
					if (data !== null && data !== undefined) {
						var jsonArr = [];
						var mapCenterData = new SELF.mapCenter();
						//console.log(mapCenterData.adjustCenterCoords(1,2));
						for(i = 0; i < data.length; i++) {
							//find center of markers
							mapCenterData.adjustCenterCoords(data[i]['latlong']);
							if (typeof(data[i]['photoRef']) !== 'undefined') {
								photo_ref = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&key=AIzaSyDnFgyjhnO9aeD29mvPtgL8tGnt5z90SZA&photoreference='+data[i]['photoRef'];	
							} else {
								photo_ref = '<?php base_url()?>index.php/static/frontend/img/WB07T46L6.png';
							}
							//construct info
							var str = '<div class="infobox-wrapper">'
									+ '<div>'
									+ '<div class="infobox-inner">'
									+ '<a href="<?php base_url()?>index.php/restaurant/display">'
									+ '<div class="infobox-image">'
									+ '<img src="'+photo_ref+'">'
									+ '<div>'
									+ '<span class="infobox-price">' + data[i]['tel'] + '</span>'
									+ '</div>'
									+ '</div>'
									+ '</a>'
									+ '<div class="infobox-description">'
									+ '<div class="infobox-title">'
									+ '<a href="<?php base_url()?>index.php/restaurant/display">' + data[i]['name'] +'</a>'
									+ '</div>'
									+ '<div class="infobox-location">' + data[i]['address'] + '</div>'
									+ '</div>'
									+ '</div>'
									+ '</div>'
									+ '</div>';
							
							//push into array
							jsonArr.push({
								latLng: data[i]['latlong'],
								data:  str
							});
						}

						$('#map_canvas').gmap3({
							map:{
								options:{
					              center:[mapCenterData.center_lat, mapCenterData.center_lng],
					              //zoom: 12,
					              scrollwheel: false
					            }
					        }
				        });
						$.each(jsonArr, function(key, val) {
							//console.log(val);
							$('#map_canvas').gmap3({
								marker: {
									options: {
										icon: '<?php base_url()?>static/frontend/img/restaurant.png',
									},
									latLng: val.latLng,
									events: {
										click: function(marker, event, context){
											$(this).gmap3({
												overlay: {
													latLng: val.latLng,
													options:{
														content: val.data,
														offset:{
													        y:-300,
													        x:-100
													    }
													}
												}
											});
										},
										mouseout: function(){
							                //$(this).gmap3({action:'clear', name:'overlay'});
							                var infowindow = $(this).gmap3({get:{name:"overlay"}});
							                if (infowindow){
							                	infowindow.hide();
							                }
							            }
									}
								}
							});
						});
					} else {
						///do something
					}
				}
			});
		},
		SELF.setupScaleSlider = function() {
	        var _SlideshowTransitions = [
	        //Fade in L
	            {$Duration: 1200, x: 0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade out R
	            , { $Duration: 1200, x: -0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade in R
	            , { $Duration: 1200, x: -0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade out L
	            , { $Duration: 1200, x: 0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

	        //Fade in T
	            , { $Duration: 1200, y: 0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	        //Fade out B
	            , { $Duration: 1200, y: -0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	        //Fade in B
	            , { $Duration: 1200, y: -0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade out T
	            , { $Duration: 1200, y: 0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

	        //Fade in LR
	            , { $Duration: 1200, x: 0.3, $Cols: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	        //Fade out LR
	            , { $Duration: 1200, x: 0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	        //Fade in TB
	            , { $Duration: 1200, y: 0.3, $Rows: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade out TB
	            , { $Duration: 1200, y: 0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

	        //Fade in LR Chess
	            , { $Duration: 1200, y: 0.3, $Cols: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	        //Fade out LR Chess
	            , { $Duration: 1200, y: -0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade in TB Chess
	            , { $Duration: 1200, x: 0.3, $Rows: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	        //Fade out TB Chess
	            , { $Duration: 1200, x: -0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

	        //Fade in Corners
	            , { $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	        //Fade out Corners
	            , { $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $SlideOut: true, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }

	        //Fade Clip in H
	            , { $Duration: 1200, $Delay: 20, $Clip: 3, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade Clip out H
	            , { $Duration: 1200, $Delay: 20, $Clip: 3, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade Clip in V
	            , { $Duration: 1200, $Delay: 20, $Clip: 12, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	        //Fade Clip out V
	            , { $Duration: 1200, $Delay: 20, $Clip: 12, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	            ];

	        var options = {
	            $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
	            $AutoPlayInterval: 1500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
	            $PauseOnHover: 1,                                //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

	            $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
	            $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
	            $SlideDuration: 800,                                //Specifies default duration (swipe) for slide in milliseconds

	            $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
	                $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
	                $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
	                $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
	                $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
	            },

	            $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
	                $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
	                $ChanceToShow: 1                               //[Required] 0 Never, 1 Mouse Over, 2 Always
	            },

	            $ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
	                $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
	                $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

	                $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
	                $SpacingX: 8,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
	                $DisplayPieces: 10,                             //[Optional] Number of pieces to display, default value is 1
	                $ParkingPosition: 360                          //[Optional] The offset position to park thumbnail
	            }
	        };

	        var jssor_slider1 = new $JssorSlider$("slider_container", options);
	        function ScaleSlider() {
	            var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
	            if (parentWidth)
	                jssor_slider1.$ScaleWidth(Math.max(Math.min(parentWidth, 612), 350));
	            else
	                window.setTimeout(ScaleSlider, 30);
	        }
	        ScaleSlider();

	        $(window).bind("load", ScaleSlider);
	        $(window).bind("resize", ScaleSlider);
	        $(window).bind("orientationchange", ScaleSlider);
	        //responsive code end
		}
	}
	var ngoctran = new NGOCTRAN();
	$(document).ready(function(){
		//var ngoctran = new NGOCTRAN();
		ngoctran.setupFoundation();
		ngoctran.setupDatepicker();
		ngoctran.setupWow();
		ngoctran.setupDropzone();
		//ngoctran.setupScaleSlider();
		ngoctran.setupAutocomplete();
		ngoctran.setupMap();
		ngoctran.setupSearch();
		ngoctran.setupProgressingBar();
		
		//dynamically load js for restaurant pages
		<?php 
			if($this->router->fetch_class() == 'restaurant') {
				echo('ngoctran.reviewSubmit();');
				echo('ngoctran.setupRating();');
			}
		?>
	});
	$(window).load(function(){
		ngoctran.preloader();
	});
</script>