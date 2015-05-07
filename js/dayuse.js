$(function() {
	var dateToday = new Date();
	$( "#ourSelection, #blogSection" ).tabs();
	$( ".language select, .courency select, .searchReasult .shortby select" ).selectmenu();
	$('.customeSelect').selectmenu();
	
	/*$( ".dateBox, .filter, .date" ).datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		dayNamesMin: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
		minDate: dateToday,
		beforeShow: function(input, inst) {
	       $('#ui-datepicker-div').removeClass(function() {
	           return $('input').get(0).id; 
	       });
	       $('#ui-datepicker-div').addClass(this.id); 
	   }
	});*/
/* Date Picker code Starts Here*/
$( ".datepicker" ).datepicker({
	showOtherMonths: true,
	selectOtherMonths: true,
	dayNamesMin: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
	minDate: dateToday,
	onSelect: function(dateText, inst) {
		var date = $(this).val();	
		$(this).prev('#chk_dt').val(date);
		//For search form
		var form = $('#hotel_search');
		form.find("#date").val($(this).val());
                $(".dateRequired").hide();                
	}	
});
$('.dateBox, .date').on('click', function(){ 	
	$(this).next().css('display','block');
});

/*$('.flexslider .bannerBottom').on('click', function(){ 
	$(this).toggleClass('close');	
	$('.bannerWithBenifit .benifits').slideToggle();
});*/

$(document).click(function(e) { 
	var ele = $(e.target);
	//console.log(ele);	
	if (!ele.hasClass("datepicker")  && !ele.hasClass("showprice") && !ele.hasClass("dateBox") && !ele.hasClass("date") && !ele.parent('.ui-datepicker-next').children().hasClass("ui-icon") && !ele.parent('.ui-datepicker-prev').children().hasClass("ui-icon"))
		$(".datepicker").hide();

	$('.datepicker .ui-state-default').on('click', function(){ 					
		$(".datepicker").hide();
	});
});	

/* Date Picker code Ends Here*/



$(window).resize(function(e) {
	var w = $( window ).width();
	var rightlist = $('.step1.resultCont.gridviewResult').width();
	$('.searchReasult .mapCont').width(w - rightlist);

	$('.flexslider.topBanner').width($( window ).width());
	$('.topBanner').flexslider({
		animation: "slide",
		pauseOnHover: false,
		start: function(){        	
			$('.searchBoxWrap').css('top', 'auto').css('position','absolute');
			$('.bannerWithBenifit .searchBoxWrap').scrollToFixed();

    },
	});
});




$('.searchReasult .resultCont .showHideBtn').click(function(e) {
	$('.searchReasult .resultCont').toggleClass('expand');
	if( handler.length > 0){handler.wookmark();}
});

	//for custom checkbox code starts here
	$('.checkboxItemCustom').each(function(i){
		var $this = $(this);
		$this.parent().html('<a class="checkboxItem">'+this.outerHTML+'<div>'+$this.attr('label')+'</div></a>');
	});

	// On load get status of check boxes 				
	$('.CustomCheckbox span').each(function()
		{		var anchor = $(this).find('.checkboxItem');
		$checkbox = $(this).find('input:checkbox');
		$checkbox.prop('checked') ? anchor.addClass('active') : anchor.removeClass('active');
	});
	
	
	// indivisual click on checkbox 
	$('.checkboxItem').on('click', function(){       
		$checkbox = $(this).closest('span').find('input:checkbox');
		if ($checkbox.is(':checked'))
		{
			$(this).removeClass('active');
			$checkbox.prop('checked', false);
		}
		else{
			$(this).addClass('active');
			$checkbox.prop('checked', true);
		}        
	});

	// on selectallchecbox click on checkbox 
	$('.selectallCheckbox').on('click', function(){ 
		if ($(this).closest('span').find('input:checkbox').is(':checked'))
		{
			$(this).closest('.CustomCheckbox').find('span').each(function()
			{	
				var anchor = $(this).find('a');
				$checkbox = $(this).find('input:checkbox');
				anchor.addClass('active');
				$checkbox.prop('checked', true);
			});
		}
		
		else{
			$(this).closest('.CustomCheckbox').find('span').each(function()
			{	
				var anchor = $(this).find('a');
				$checkbox = $(this).find('input:checkbox');
				anchor.removeClass('active');
				$checkbox.prop('checked', false);
			});
		}
		
	});
//for custom checkbox code ends here
//for custom RadioButton code Starts here
$('.radioItemCustom').each(function(i){
	var $this = $(this);
	$this.parent().html('<a class="RadioButtonItem">'+this.outerHTML+'<div>'+$this.attr('label')+'</div></a>');
});
				// On load get status of Radiobutton				
				$('.CustomRadioButton span').each(function()
					{		var anchor = $(this).find('a.RadioButtonItem');
					$Radiobutton = $(this).find('input:radio');
					$Radiobutton.prop('checked') ? anchor.addClass('active') : anchor.removeClass('active');
				});
				
				
				// indivisual click on Radiobutton 
				$('.RadioButtonItem').on('click', function(){       
					$Radiobutton = $(this).closest('span').find('input:radio');
					if ($Radiobutton.is(':checked'))
					{}
				else{
					$(this).closest('.CustomRadioButton').find('span').each(function()
					{
						$(this).find('a').removeClass('active');							
						$(this).find('input:radio').prop('checked', false);
					});						
					$(this).addClass('active');
					$Radiobutton.prop('checked', true);
				}        
			});
//for custom RadioButton code Ends here
//Function closed here				
});


// Window on load Starts here		
$(window).load(function() {
	$('.flexslider.topBanner').width($( window ).width());
	$('.topBanner').flexslider({
		animation: "slide",
		pauseOnHover: false,
		start: function(){        	
			$('.searchBoxWrap').css('top', 'auto').css('position','absolute');
			$('.bannerWithBenifit .searchBoxWrap').scrollToFixed();

    },
	});
	$('.homeBenefitsSlider').flexslider({
		animation: "slide",
		slideshow: false,
		directionNav: false	
	});
	$('.midBannerCont, .articleBannerCont').flexslider({
		animation: "slide"	
	});
	$('.imageSlide').flexslider({
		controlNav: false,
		slideshow: false,
		selector: '.slides > .slide-group'
	});
	$('.imageSlide .slides>div>img').on('click', function(){		
        $(this).closest(".imageSlide").find('.flex-next').click();
    }); 

	/*if($('.bannerWithBenifit .searchBox').offset() != undefined){
		var offset = $('.bannerWithBenifit .searchBox').offset();
		console.log(offset);
		$(window).scroll(function() {
			var scrollTop = $(window).scrollTop();
			if (scrollTop >= offset.top){
				$('.bannerWithBenifit .searchBox').addClass('fixed');
			} else{
				$('.bannerWithBenifit .searchBox').removeClass('fixed');
			}
		});
		var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
		if(iOS){
			document.addEventListener("scroll", Scroll, false);
			function Scroll() {
				var scrollTop = window.pageYOffset;
				if (scrollTop >= offset.top){
					$('.bannerWithBenifit .searchBox').addClass('fixed');
				} else{
					$('.bannerWithBenifit .searchBox').removeClass('fixed');
				}
			}
		}
	};*/
	

	if($('.searchReasult').offset() != undefined){
		var offset2 = $('.searchReasult').offset();
		$(window).scroll(function() {
			var scrollTop = $(window).scrollTop();
			if (scrollTop >= offset2.top){
				$('.searchReasult .mapCont').css('top', scrollTop - offset2.top);
				$('.searchReasult .resultCont .showHideBtn').css('top', scrollTop - offset2.top);
			} else{
				$('.searchReasult .mapCont').css('top', 0);
				$('.searchReasult .resultCont .showHideBtn').css('top', 0);
			}
		});
		var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
		if(iOS){
			document.addEventListener("scroll", Scroll, false);
			function Scroll() {
				var scrollTop = window.pageYOffset;
				if (scrollTop >= offset2.top){
					$('.searchReasult .mapCont').css('top', scrollTop - offset2.top);
					$('.searchReasult .resultCont .showHideBtn').css('top', scrollTop - offset2.top);
				} else{
					$('.searchReasult .mapCont').css('top', 0);
					$('.searchReasult .resultCont .showHideBtn').css('top', 0);
				}
			}
		}
	};
	
	$('.SearchOptionBox .multiselect li ul li a').click(function(e) {
		$(this).toggleClass('selected');
	});
	$('.SearchOptionBox .multiselect > li').click(function(e) {
		$(this).parent().siblings('.multiselect').find('ul').slideUp();
		$('select').selectmenu('close');
		$(this).find('ul').slideDown(500);
		$('html').one('mousedown', function(){
			$('.SearchOptionBox .multiselect li ul').slideUp();
		});
	});
	$(".SearchOptionBox .multiselect > li").bind('mousedown', function(evt){
		evt.stopPropagation();
	});
	$(".hotelPicMap .route .details").customScrollbar();
	
	
	
});
// Window on load Ends here	


// Document on Ready Starts here	
$(document).ready(function()
{
	$("#showcase").awShowcase(
	{
		content_width:			723,
		content_height:			472,
		fit_to_parent:			false,
		auto:					false,
		interval:				3000,
		continuous:				false,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		40,
		tooltip_icon_height:	25,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:					true,
		buttons:				false,
		btn_numbers:			false,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			true,
		transition:				'hslide', /* hslide/vslide/fade */
		transition_delay:		300,
		transition_speed:		500,
		show_caption:			'onhover', /* onload/onhover/show */
		thumbnails:				true,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'horizontal', /* vertical/horizontal */
		thumbnails_slidex:		1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			false, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
	});
$('.SearchOptionBox a.showHideBtn').click(function(e) {
	$('.SearchOptionBox').toggleClass('close');
	$('.SearchOptionBox .container').slideToggle(500);
});
/* Using custom settings for fancybox*/
$(".inlineFancybox").fancybox({
	'hideOnContentClick': true,
			/*helpers   : { 
			   *overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox 
			}*/
		});

/* Apply fancybox to multiple items */
$("a.group").fancybox({
	'transitionIn'	:	'elastic',
	'transitionOut'	:	'elastic',
	'speedIn'		:	600, 
	'speedOut'		:	200, 
	'overlayShow'	:	false
});

	//$(".book").colorbox();
	$('.bannerWithBenifit .searchBoxWrap').scrollToFixed();
});
// Document on Ready Ends here

$('body').bind('mousewheel', function(e) {
    $('#arrival_time_select').selectmenu('close');
    $('#stay_duration_select').selectmenu('close');
});