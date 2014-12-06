
<script>
	function NGOCTRAN() {
		var SELF = this,
			$progressbar = $( "#progressbar" );
		SELF.uuid = '<?php echo $this->session->userdata('uuid'); ?>';
		SELF.user_id = '<?php echo $this->session->userdata('id'); ?>';
		SELF.pusher_connection_socket_id = null;
		SELF.pusher = null;
		SELF.invokeNotificationPanel = function() {
			notification_panel = new NotificationFx({
				wrapper : document.body,
				message : '<p>Your preferences have been saved successfully. See all your settings in your <a href="#">profile overview</a>.</p>',
				layout : 'growl',
				effect : 'genie',
				type : 'notice', // notice, warning or error
				onClose : function() {
				}
			});
			notification_panel.show();
		}
		//channel initalize
	<?php if ($this->session->userdata('id')) { ?>
		SELF.pusher = new Pusher('54120ecb88a7a7dc598b', { authEndpoint: '<?php echo base_url("/index.php/user/login/pusher_authentication"); ?>' });
		SELF.pusher.connection.bind('connected', function() {
			SELF.pusher_connection_socket_id = SELF.pusher.connection.socket_id;
		});
		SELF.channel_ids = [];
		 
		<?php if ($this->session->userdata('channels')) { 
			foreach ($this->session->userdata('channels') as $c) {
				echo('SELF.channel_ids.push("' . $c['channel_id'] . '");');
			}
		?>

	<?php foreach ($this->session->userdata('channels') as $c) {
			echo('var channel_name_' . $c["channel_id"] .' = "' . NEW_REVIEW_NOTIFCATION_CHANNEL . $c["channel_id"]. '";');
			echo('var channel_'. $c["channel_id"] . '= SELF.pusher.subscribe(channel_name_' . $c["channel_id"] . ');');
			echo('var event_name = "' . NEW_REVIEW_NOTIFCATION_EVENT . '";');
			echo('channel_'. $c["channel_id"] . '.bind(event_name, function(data) {
					  console.log("An event was triggered with message: " + data.message);
					  SELF.invokeNotificationPanel();
				});');
	} ?>
	
	<?php 	} ?>
	<?php } ?>
	
		SELF.setupProgressingBar = function(){
			$progressbar.progressbar();
			$progressbar.css('display', 'none');
		},
		SELF.setupRating = function(){
			$('#review_score .star').rating();
		},
		<?php if($this->router->fetch_class() == 'restaurant') {?>
		SELF.reviewSubmit = function() {
			$('form[name="review_form"]').submit(function(event){
				var postData = $(this).serializeArray();
				var socketObj = {name: 'socket_id', value: SELF.pusher_connection_socket_id};
				postData.push(socketObj);
				console.log(postData);
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
							$.get('<?php echo base_url("/index.php/restaurant/show_restaurant/" . $restaurant->id); ?>', function(html){
									new_html = $(html).find('.comments').html();
									//$('.comments').html('');
									alertify.success("Success notification");
									$('#comments-listing').html(new_html);
									$('#comments-listing .star').rating(); 
									SELF.reviewSubmit();
									SELF.pusher.connection.bind('connected', function() {
										socketId = SELF.pusher.connection.socket_id;
										$.ajax({
											    url: '<?php base_url("index.php/user/notify/notify_new_review");?>',
											    type: "POST",
											    data: {
											      user_id: SELF.user_id,
											      restaurant_id: '<?php echo $restaurant->id; ?>',
											      socket_id: socketId
											    }
										});
									});
							});
						}						
					}
				});
				return false; //disable refresh
			});
		}
		<?php };?>
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
		SELF.setupNotification = function() {
			var today = new Date();
			var items = generateItems(today);
			refreshNotifications(items, today);
			function refreshNotifications(items, today) {
				  items = items || [];
				  today = today || newDate();
				  
				  var cssTransitionEnd = getTransitionEnd();
				  var container = $('body');
				  
				  items.forEach(function(item) {
				    item.isExpired = item.date < today;
				    
				    item.isToday = (item.date.getFullYear() === today.getFullYear()) &&
				      (item.date.getMonth() === today.getMonth()) &&
				      (item.date.getDate() === today.getDate());    
				    
				    item.formattedDate = function() {
				      if (this.isToday) {
				        return timeToString(this.date);
				      } else {
				        return this.date.getFullYear() + '-' +
				          strpad(this.date.getMonth() + 1) + '-' +
				          strpad(this.date.getDate());
				      }
				    };
				  });
				  
				  items.sort(function(a, b) {
				    if (a.isExpired === b.isExpired) {
				      return a.date - b.date;
				    } else {
				      return (b.isExpired ? 0 : 1) - (a.isExpired ? 0 : 1);
				    }
				  });
				    
				  var template = 
				      '<div class="notifications js-notifications">' +
				        '<h3>Notifications</h3>' +
				        '<ul class="notifications-list">' +
				          '<li class="item no-data">You don\'t have notifications</li>' +
				          '{{#items}}' +
				            '<li class="item js-item {{#isExpired}}expired{{/isExpired}}" data-id="{{id}}">' +
				              '<div class="details">' +
				                '<span class="title">{{title}}</span>' +
				                '<span class="date">{{formattedDate}}</span>' +
				              '</div>' +
				              '<button type="button" class="button-default button-dismiss js-dismiss">×</button>' +
				            '</li>' +
				          '{{/items}}' +
				        '</ul>' +
				        '<a href="#" class="show-all">Show all notifications</a>' +
				      '</div>';
				  container
				    .append(Mustache.render(template, { items: items }))
				    .find('.js-count').attr('data-count', items.length).html(items.length).end()
				    .on('click', '.js-show-notifications', function(event) {
				      $(event.currentTarget).closest('.js-show-notifications').toggleClass('active').blur();
				      if ($('.show-notifications').hasClass('active')) {
					      $('.notifications').addClass('notifications-active');
				      } else {
				    	  $('.notifications').removeClass('notifications-active');
				      }
				      return true;
				    })
				    .on('click', '.js-dismiss', function(event) {
				      var item = $(event.currentTarget).parents('.js-item');
				      
				      var removeItem = function() {
				        item[0].removeEventListener(cssTransitionEnd, removeItem, false);
				        item.remove();
				        
				        /* update notifications' counter */
				        var countElement = container.find('.js-count');
				        var prevCount = +countElement.attr('data-count');
				        var newCount = prevCount - 1;
				        countElement
				          .attr('data-count', newCount)
				          .html(newCount);
				        
				        if(newCount === 0) {
				          countElement.remove();
				          container.find('.js-notifications').addClass('empty');
				        }
				      };
				      
				      item[0].addEventListener(cssTransitionEnd, removeItem, false);
				      item.addClass('dismissed');
				      return true;
				    });
				}

				function generateItems(today) {
				  today = today || newDate();
				  return [
				    { id: 1, title: 'Meeting with Ben\'s agent.', date: randomDate() },
				    { id: 2, title: 'Papers review with Tonny.', date: randomDate(addMinutes(today, -60), addMinutes(today, 60)) },
				    { id: 3, title: 'Annual party at Eric\'s house.', date: randomDate() },
				    { id: 4, title: 'Last day to pay off auto credit.', date: randomDate() },
				    { id: 5, title: 'Call and schedule another meeting with Amanda.', date: randomDate(addMinutes(today, -360), addMinutes(today, 360)) },
				    { id: 6, title: 'Don\'t forget to send in financial reports.', date: randomDate() }
				  ];
				}

				function randomDate(start, end) {
				  start = start || (new Date(2014, 0, 1));
				  end = end || (new Date(2015, 0, 1));
				  return new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
				}

				function addMinutes(date, minutes) {
				  return new Date(date.getTime() + minutes * 60000);
				}

				function timeToString(date) {
				  if (date) {
				    var hh = date.getHours();
				    var mm = date.getMinutes();
				    var ap = hh >= 12 ? 'PM' : 'AM';

				    hh = (hh >= 12) ? (hh - 12) : hh;
				    hh = (hh === 0) ? 12 : hh;

				    return (hh < 10 ? '0' : '') + hh.toString() + ':' +
				      (mm < 10 ? '0' : '') + mm.toString() + ' ' + ap;
				  }
				  return null;
				}

				function strpad(num) {
				  if (parseInt(num) < 10) {
				    return '0' + parseInt(num);
				  } else {
				    return parseInt(num);
				  }
				}

				function getTransitionEnd() {
				  var supportedStyles = window.document.createElement('fake').style;
				  var properties = {
				    'webkitTransition': { 'end': 'webkitTransitionEnd' },
				    'oTransition': { 'end': 'oTransitionEnd' },
				    'msTransition': { 'end': 'msTransitionEnd' },
				    'transition': { 'end': 'transitionend' }
				  };
				  
				  var match = null;
				  Object.getOwnPropertyNames(properties).forEach(function(name) {
				    if (!match && name in supportedStyles) {
				      match = name;
				      return;
				    }
				  });
				  
				  return (properties[match] || {}).end;
				}
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
	$(function () {
		ngoctran.setupNotification();
	});
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