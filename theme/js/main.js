!function(t){function e(){var e,i,n={height:a.innerHeight,width:a.innerWidth};return n.height||(e=r.compatMode,(e||!t.support.boxModel)&&(i="CSS1Compat"===e?f:r.body,n={height:i.clientHeight,width:i.clientWidth})),n}function i(){return{top:a.pageYOffset||f.scrollTop||r.body.scrollTop,left:a.pageXOffset||f.scrollLeft||r.body.scrollLeft}}function n(){var n,l=t(),r=0;if(t.each(d,function(t,e){var i=e.data.selector,n=e.$element;l=l.add(i?n.find(i):n)}),n=l.length)for(o=o||e(),h=h||i();n>r;r++)if(t.contains(f,l[r])){var a,c,p,s=t(l[r]),u={height:s.height(),width:s.width()},g=s.offset(),v=s.data("inview");if(!h||!o)return;g.top+u.height>h.top&&g.top<h.top+o.height&&g.left+u.width>h.left&&g.left<h.left+o.width?(a=h.left>g.left?"right":h.left+o.width<g.left+u.width?"left":"both",c=h.top>g.top?"bottom":h.top+o.height<g.top+u.height?"top":"both",p=a+"-"+c,v&&v===p||s.data("inview",p).trigger("inview",[!0,a,c])):v&&s.data("inview",!1).trigger("inview",[!1])}}var o,h,l,d={},r=document,a=window,f=r.documentElement,c=t.expando;t.event.special.inview={add:function(e){d[e.guid+"-"+this[c]]={data:e,$element:t(this)},l||t.isEmptyObject(d)||(l=setInterval(n,250))},remove:function(e){try{delete d[e.guid+"-"+this[c]]}catch(i){}t.isEmptyObject(d)&&(clearInterval(l),l=null)}},t(a).bind("scroll resize scrollstop",function(){o=h=null}),!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){h=null})}(jQuery); 
var clock = {
	weekDays : ["SUN","MON","TUE","WED","THU","FRI","SAT"],
	monthNames : ["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"],
	serverDate : {}, // server date obj
	localDate : {}, // local date obj
	dateOffset: {}, // offset ammount
	nowDate : {}, // adjusted date
	dateString : {}, // formated
	el : {}, // element to update
	timeout : {}, // timeout handle
	init : function (date,id,interval) {
		this.calculateOffset(date);
		this.el = document.getElementById(id);
		this.updateClock(interval);
	},
	calculateOffset : function (serverDate) {
		this.serverDate = new Date(serverDate);
		this.localDate = new Date();
		this.dateOffset = this.serverDate - this.localDate;
	},
	updateClock : function (interval) {
		this.nowDate = new Date();
		this.nowDate.setTime(this.nowDate.getTime() + this.dateOffset);
		this.dateFormat(this.nowDate);
		this.el.innerHTML = this.dateString;
		var me = this; this.timeout = setTimeout(function(){me.updateClock(interval)},interval);
	},
	stopClock : function () {
		clearTimeout(this.timeout);
	},
	dateFormat : function (dateObj) {
		this.dateString = '<span>' + this.digit(dateObj.getHours()) + ':' + this.digit(dateObj.getMinutes()) + ':' + this.digit(dateObj.getSeconds()) + '</span>';
		this.dateString += ' ';
		this.dateString += this.monthNames[dateObj.getMonth()] + ' ';
		this.dateString += this.digit(dateObj.getDate()) + ', ';
		this.dateString += dateObj.getFullYear();
	},
	digit : function (str) {
		str = String(str);
		str = str.length == 1 ? "0" + str : str;
		return str;
	}
};
	function createPlayer(jqe, video, options) {
        var ifr = $('iframe', jqe);
        if (ifr.length === 0) {
            ifr = $('<iframe scrolling="no">');
            ifr.addClass('player');
        }
        var src = 'http://www.youtube.com/embed/' + video.id;
        if (options.playopts) {
            src += '?';
            for (var k in options.playopts) {
                src+= k + '=' + options.playopts[k] + '&';
            }  
            src += '_a=b';
        }
        ifr.attr('src', src);
        jqe.append(ifr);  
    }
    
    function createCarousel(jqe, videos, options) {
        var car = $('div.carousel', jqe);
        if (car.length === 0) {
            car = $('<div>');
            car.addClass('carousel').addClass('scrollThis');
            jqe.append(car);
            
        }
        $.each(videos, function(i,video) {
            options.thumbnail(car, video, options); 
        });
    }
    
    function createThumbnail(jqe, video, options) {
        var imgurl = video.thumbnails[0].url;
        var img = $('img[src="' + imgurl + '"]');
        if (img.length !== 0) return;
        img = $('<img>');    
        img.addClass('thumbnail');
        jqe.append(img);
        img.attr('src', imgurl);
        img.attr('title', video.title);
        img.click(function() {
            options.player(options.maindiv, video, $.extend(true,{},options,{playopts:{autoplay:1}}));
        });
    }
    
	var defoptions = {
        autoplay: false,
        user: null,
        carousel: createCarousel,
        player: createPlayer,
        thumbnail: createThumbnail,
        loaded: function() {},
        playopts: {
            autoplay: 0,
            egm: 1,
            autohide: 1,
            fs: 1,
            showinfo: 0
        }
    }; 
    
(function($) {
    $.showModal =  function(header,body) {		
		$("#myModal .modal-title").html(header);
		$("#myModal .modal-body").html(body);		
		$("#myModal").modal("show");	
		return $("#myModal");
    }
	$.updateLive = function (target,value) {
		var tr = $('#'+target);
		tr.toggle("highlight").html(value).toggle("highlight");
	}
	$.parseJSONData = function (data) {
		if (data.link) {
				var win = window.open(data.link, '_blank');
				win.focus();
			}
		if (data.msg != '') $.showModal('Alert',data.msg);
		if (data.data) {
			$.each(data.data,function(e,i) {          
				if ($('#'+e)) {
					if ($('#'+e).html() != i)
						$.updateLive(e,i);
				}
			});
		}	
		if (data.callback) window[data.callback](data);
		if (data.do) {
			switch(data.do) {
				case 'logout':
					window.setTimeout(function() {   window.location = '/logout';  }, 2000);
				break;	
				case 'refresh':
					window.setTimeout(function() {   location.reload();  }, 2000);
				break;					
			}
		}
	}
	$.preloadImages = function() {
	  for (var i = 0; i < arguments.length; i++) {
		$("<img />").attr("src", arguments[i]);
	  }
	}
	$.onePageAfterLoad = function(anchor) {
		var t = $('[data-anchor='+anchor+']');

		if (t.data('trigger')) {		
		var type = t.data('trigger-type');
		var tr = t.data('trigger');
			switch(type) {
				case 'click':
				$('[data-anchor='+anchor+'] '+tr).trigger(type);
				
				break;
				case 'ajax':
					if (t.html() == '') {
						t.html('Loading...');
						url = tr.split('-');
						$.get('/widgets/'+url[1]+'/'+url[0], function(data) {
							t.html(data);
							$('[data-toggle=tooltip]').tooltip(); 						
						});
				   }
				break;
			}			
		}
	}
	
	
	$.initStuff = function() {
		$("table.crossed").undelegate('td','mouseover mouseleave',function(e){});
		$("table.crossed").delegate('td','mouseover mouseleave', function(e) {
			var parent = $(this).parent().parent().parent();
			if (e.type == 'mouseover') {
			  $(this).parent().addClass("bg-trans2");
			   parent.children("colgroup").eq($(this).index()).addClass("bg-trans2");
			}
			else {
			  $(this).parent().removeClass("bg-trans2");
			  parent.children("colgroup").eq($(this).index()).removeClass("bg-trans2");
			}
		});
		 $('[data-toggle=tooltip]').tooltip({
			 html:true,
			 delay: { "show": 100, "hide": 100 },
			 container: 'body'
			}); 
			$("[data-toggle=popover]").popover({
				html:true,
				
				
			}).click(function(f) {
			f.preventDefault();
			if ($(this).data("easein") != undefined) {
				$(this).next().removeClass($(this).data("easein")).addClass("animated " + $(this).data("easein"));
			} else {
				$(this).next().addClass("animated fadeIn");
			}
		});
		
		$(".filter .btn-group label").unbind('click');
		$(".filter .btn-group label").click(function () {
			var t = $(this);
			var tr = t.data('target');	
			if (t.hasClass('active')) {
			   t.children('.fa').removeClass('fa-check-square-o').addClass('fa-square-o');
			   $('div [data-filter='+tr+']').hide();
			} else {
				t.children('.fa').removeClass('fa-square-o').addClass('fa-check-square-o');
				$('div [data-filter='+tr+']').show();
			}    
		});
		
		/*$('#likebox').bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
			  if (isInView) {
				// element is now visible in the viewport
				if (visiblePartY == 'top') {
				  // top part of element is visible
				} else if (visiblePartY == 'bottom') {
				  // bottom part of element is visible
				} else {
				  console.log('whole part of element is visible'
				}
			  } else {
				// element has gone out of viewport
			  }
		});*/
		/* inVIEW TRIGGERS */
		$('#likebox').bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
			  if (isInView) {
				(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=705434352807057&version=v2.0";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				$('#likebox').unbind('inview');
				
			} 
		});
		$('.twitter-timeline').bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
			  if (isInView) {
				!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platformform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
				$('.twitter-timeline').unbind('inview');
						
			} 
		});
		$('#ytBox').bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
			  if (isInView) {
				  $.getScript( "https://apis.google.com/js/platform.js", function( data, textStatus, jqxhr ) {
					$('#ytBox').unbind('inview');
				    
				});
							
			} 
		});
		
	}



	/* popover loads
	$('*[data-poload]').bind('hover',function() {
		var e=$(this);
		e.unbind('hover');
		$.get(e.data('poload'),function(d) {
			e.popover({
				content: d,
				placement: 'top'}).popover('show');
		});
	});
 */
 



	$('img').each(function() {
		if ($(this).data('src'))
			$(this).attr('src',$(this).data('src'));
	});
	$(document).scroll(function(e){
		var scrollTop = $(document).scrollTop();
		if(scrollTop > 0){			
			$('body:not(.fixed) .navbar').removeClass('navbar-static-top').addClass('navbar-fixed-top');
			$('body:not(.fixed) ').removeClass('static-top').addClass('fixed-top');
		} else {
			$('body:not(.fixed) .navbar').removeClass('navbar-fixed-top').addClass('navbar-static-top');
			$('body:not(.fixed) ').removeClass('fixed-top').addClass('static-top');
		}
		
	});

	var anchors = [];
	if ($('.onePage .section')) {
		var sec = $('.section');
		sec.each(function() {
		 var t = $(this);
		 //var id = t.data('id'), icon = t.data('icon');
		 //var tr = $('#menu');
		// var out = '<li data-menuanchor="'+id+'"><a href="#'+id+'"><i class="fa fa-'+icon+'"></i> <span>'+id+'</span></a></li>';
		 anchors.push(t.data('id'));
		// tr.append(out);
		});
		
		if (anchors.length >0) {
		$('#fullpage').fullpage({				
				anchors: anchors,
				menu: '#menu',		
				'verticalCentered': false,
				'normalScrollElements': '.scrollThis',
				'slidesNavigation': true,
				'slidesNavPosition': 'bottom',
				afterLoad: function(anchorLink, index){
					if(index == '1'){		
						$('body:not(.fixed) .navbar').removeClass('navbar-fixed-top').addClass('navbar-static-top');
						$('body:not(.fixed) ').removeClass('fixed-top').addClass('static-top');
					} else {
						$('body:not(.fixed) .navbar').removeClass('navbar-static-top').addClass('navbar-fixed-top');
						$('body:not(.fixed) ').removeClass('static-top').addClass('fixed-top');					
					}
					$.onePageAfterLoad(anchorLink);				
				},
				afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex) {
				
					if (slideAnchor == 'Youtube') {
						/*
						if ($('#player').html() == '') {
							$('#player').youTubeChannel({user:'CoreDekaron'});
							$('#player').addClass('loaded')
						}*/
					}
					$.onePageAfterLoad(slideAnchor);	
				
				
				}
			});
		}
	}
	/* forum slimscroll */
	if ($('.scrollThis')) {
		$('.scrollThis').slimScroll({
			'color': '#fff',
			'size': '6px',
			'height': 'auto',
			'alwaysVisible': true
		});
	}
	/* register */
	if ($("#registerForm")) $('#registerForm').bootstrapValidator();
	/* login */
	if ($('#loginForm')) 
		$('#loginForm').bootstrapValidator({
			excluded: [],
		});



	$('.modalpop').each(function(e,i) {
		var t = $(this);
		var header = t.html();
		var text = $(t.data('target')).html();
		t.click(function() { 
			$.showModal(header,text);
		});
	});
	
	$('.ajax').live('click',function () {
	  var btn = $(this);
	  var d = {};
	  var arr = [ 'info','id','action','sid','cid','callback' ];  
	  
	  btn.button('loading');
	  $.each(btn.data(),function(i,e) {    
		if ($.inArray(i,arr) > 0) {        
		  d[i] = e;		
		}
	  });
	  btn.button('loading');
	  $.getJSON('/api/', d).done(function( data ) {
			btn.button('reset');
			//$.parseJSON(data);
			$.parseJSONData(data);
			
	  });
	});
	$('.getFrom').live('click',function(){
		var t = $(this);
		var theQ = $({});
		$.showModal(t.html(),$('#'+t.data('action')).html());    
			$('#myModal form').bootstrapValidator({      
				excluded: [],			
				submitHandler: function(validator, form, submitButton) {
					$('#myModal .modal-body').html('Sending data to server');	
					$.getJSON('/api/?'+form.serialize(), {
						sid: t.data('sid'),
						action: t.data('action'),
						id: t.data('id'),                           
					}).done(function( data ) {                                    
						$.parseJSONData(data);			            
					});
				}
			}); 
	});

	if (!$('body').hasClass('fixedFooter')) {
		$(document).mousemove(function(e){
		  var vertical = e.pageY;
		  var pageY = $( window ).height() / 2 ; 
		  if (!$('footer').hasClass('fixed')) {
			  if(vertical >= pageY) {  			
				$('footer').css("bottom","0").addClass("animated fadeInLeft").fadeIn();
				$('footer .margin-negative button').addClass('animated slideInDown');
			  } else {			 
				$('footer').delay(3000).css("bottom","-270px").delay(3000).removeClass("animated fadeInLeft");
			  }
		  }
		}); 
		
		
	}
	/* lazy loading features */
	
	
	
	/* lazy loading tabs */
	$('.tab-ajax a[data-toggle="tab"]').click(function(e) {
        var t = $(this);
        var tr = t.attr('href').substr(1);
        tab = $('#' + tr );
        if (tab.html() == '') {
			tab.html('Loading...');
            url = tr.split('-');
            $.ajax({
				type: 'GET',
				url: '/widgets/'+url[1]+'/'+url[0],
				data: { },
				beforeSend:function(){
					//do 
				},
				success:function(data){
					tab.html(data);
					$.initStuff();
					$('[data-action=REFRESH]').click(function() {
						tab.html('');
						t.trigger('click');
					});
				}
			});
       }
	});
	
})(jQuery);

$.initStuff();
