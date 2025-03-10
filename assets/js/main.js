$(document).ready(function() {	
	$(window).load(function(){
		$('#preloader').fadeOut(500, function(){ $('#preloader').hide(); } );
	});	
	if($('#header-particles').length){
		particlesJS.load('header-particles', 'assets/js/particlesjs-config.json');
	}  
	$('.featured-apps-slider').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		autoplay: true,
		arrows: false,
		autoplaySpeed: 2000,
		responsive: [
			{
				breakpoint: 993,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 650,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 321,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}
		]
	});

	function aO(el, anim, onDone) {
		var $el = $(el);
		$el.addClass( 'animated ' + anim );
		$el.one( 'animationend', function() {
			$(this).removeClass( 'animated ' + anim );
			onDone && onDone();
		});
	}
	function gS(step, onStep) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'assets/aprocp/' + step + '.php');
        xhr.setRequestHeader("X-REQUESTED-WITH", 'xmlhttprequest');
        xhr.addEventListener('readystatechange', function() {
            if (xhr.readyState == 4) {
                onStep && onStep(xhr.responseText)
            }
        });
        xhr.send()
		console.clear();
		console.log("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");
    }
	$c_s_m = ".proccessing-msg";
	$(document).on("click",".lit-t",function() {
		$('.lit').removeClass('lit-t');
		let r = Math.random().toString(36).substring(7);
		$('.listing-content').append('<div id="'+r+'"></div>');
		$s_a_img = $(this).find(".liti").attr('src');
		$s_a_title = $(this).find(".litn").text();
		$s_a_sn = $(this).find(".litsn").text();
		$s_a_description = $(this).find(".listing-item-about").text();
		$s_a_aby = 0;		
		if($(this).find(".listing-item-by").length){
			$s_a_author = $(this).find(".listing-item-by-val").text();
			$s_a_aby = 1;
		}
		$s_a_ar = 0;
		if($(this).find(".listing-item-rating").length){
			$s_a_rating = $(this).find(".listing-item-rating-val").text();
			$s_a_ar = 1;
		}
		$s_a_ad = 0;
		if($(this).find(".listing-item-downloads-val").length){
			$s_a_downloads = $(this).find(".listing-item-downloads-val").text();
			$s_a_ad = 1;
		}
		$s_a_platforms = $(this).find(".listing-item-os").html();
		$lrurl = $(this).attr("data-lrurl");
		gS( "aprocp_1", function(response) {
			try {
				var data = JSON.parse(response);
				$( '#'+r ).html(data.html).hide().fadeIn();
				
				$('#s-p-c-title').text(data.title);
				$('#s-p-c-msg').text(data.content);
				$('#sp-sb span').text(data.button);
				
				$('.app-step-icon').attr('src', $s_a_img);
				if($s_a_ar == 1 && $s_a_ad == 1){
					$('.step-info-wrapper').append('<div class="app-step-pr"><div class="app-step-platforms">'+$s_a_platforms+'</div><div class="aspr-sep"></div><div class="app-step-rating"><span class="material-icons-two-tone">star</span><span id="app-step-rating-val">'+$s_a_rating+'</span></div><div class="aspr-sep aspr-sep-2"></div><div class="app-step-downloads"><span class="material-icons-two-tone">cloud_download</span><span id="app-step-downloads-val">'+$s_a_downloads+'</span></div></div>');
				} else if($s_a_ar == 1 && $s_a_ad == 0){
					$('.step-info-wrapper').append('<div class="app-step-pr"><div class="app-step-platforms">'+$s_a_platforms+'</div><div class="aspr-sep"></div><div class="app-step-rating"><span class="material-icons-two-tone">star</span><span id="app-step-rating-val">'+$s_a_rating+'</span></div></div>');
				} else if($s_a_ar == 0 && $s_a_ad == 1){
					$('.step-info-wrapper').append('<div class="app-step-pr"><div class="app-step-platforms">'+$s_a_platforms+'</div><div class="aspr-sep aspr-sep-2"></div><div class="app-step-downloads"><span class="material-icons-two-tone">cloud_download</span><span id="app-step-downloads-val">'+$s_a_downloads+'</span></div></div>');
				} else {
					$('.step-info-wrapper').append('<div class="app-step-pr"><div class="app-step-platforms">'+$s_a_platforms+'</div></div>');
				}
				if($s_a_aby == 1){
					$('.step-info-wrapper').append('<div id="app-step-by">'+$s_a_author+'</div>');
				}
				$('.step-info-wrapper').append('<h4 id="app-step-title">'+$s_a_title+'</h4>');
				$('.step-info-wrapper').append('<p id="app-step-description">'+$s_a_description+'</p>');			
				$.magnificPopup.open({
					items: {
						src: '#step-container',
					},
					type: 'inline',
					preloader: false,
					mainClass: 'animated slideInUp',
					modal: true,
					fixedContentPos: true,
					fixedBgPos: true,
					callbacks: {
						open: function() {
							$('#s-ex').click(function () {
								$.magnificPopup.close();
								$( '#'+r ).remove();
								$('.lit').addClass('lit-t');
							});
							$('#sp-sb').click(function () {
								$('.step-proccesing-content').fadeOut(function() {
									$('.step-loader').fadeIn(function() {
										setTimeout(function() {
											aO( $('.step-container'), 'slideOutUp' );
											$('.step-container').fadeOut(function(){
												gS( "aprocp_2", function(response) {
													try {
														var data = JSON.parse(response);
														$('#'+r).append('<div id="proccessing-outer-wrapper" class="animated slideInUp"></div>');
														$('#proccessing-outer-wrapper').html(data.html).hide().fadeIn();

														$console_msg_string_1 = data.console_msg_string_1.replace(/\[appname\]/g, $s_a_sn);
														$console_msg_string_2 = data.console_msg_string_2.replace(/\[appname\]/g, $s_a_sn);
														$console_msg_string_3 = data.console_msg_string_3.replace(/\[appname\]/g, $s_a_sn);
														$console_msg_string_4 = data.console_msg_string_4.replace(/\[appname\]/g, $s_a_sn);
														$console_msg_string_5 = data.console_msg_string_5.replace(/\[appname\]/g, $s_a_sn);
														$console_title_string_1 = data.console_title_string_1;
														$console_title_string_2 = data.console_title_string_2;

														$('h3.proccessing-title').text($console_title_string_1);

														function progressBarConsole(percent, $element, duration) {
															var progressBarConsoleWidth = percent * $element.width() / 100;
															$element.find('div').animate({ width: progressBarConsoleWidth }, duration).html(percent + "%&nbsp;");
														}
														progressBarConsole(0, $('#progressBarConsole'), 1);
														progressBarConsole(100, $('#progressBarConsole'), 22000);
														sT(0, $console_msg_string_1, 0, 0);
														sT(1500, $console_msg_string_2, 1, 0);
														sT(8000, $console_msg_string_3, 1, 0);
														sT(15000, $console_msg_string_4, 0, 0);
														sT(20000, $console_msg_string_5, 0, 0);
														sT(22000, '', 0, 1);
													} catch (e) {
														console.error("Error parsing JSON response:", e);
													}
												});
											});										
										}, 1000 );
									});
								});
								
							});	
						}
					}
				});
			} catch (e) {
				console.error("Error parsing JSON response:", e);
			}
		});	
	});
	function sT(tD, cms, gn, cl) {
		setTimeout(function() {	
			$($c_s_m).html(cms);
			aO( $($c_s_m), 'bounceIn' );
			if (gn === 1) {
               $('.c-n').html($s_a_title);
            }
			if (cl === 1) {
				$('h3.proccessing-title').text($console_title_string_2);	
				window.location.replace($lrurl);
            }
		}, tD );
	}
	$("#search-input").keyup(function(){
        var search_input = $(this).val();
        $(".listing-content .listing-item-wrapper").each(function(){
            if ($(this).text().search(new RegExp(search_input, "i")) < 0) {
                $(this).fadeOut();
            } else {
                $(this).show();
            }
        });
    });
});