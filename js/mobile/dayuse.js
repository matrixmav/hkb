$(function() {
	var dateToday = new Date();
	var w = $( window ).width();
	var fontValue = (11 / 320 )*w;
	$('body').css('font-size',fontValue);
	$(window).resize(function(e) {
        var w1 = $( window ).width();
		var fontValue1 =(11 / 320 )*w1;
		$('body').css('font-size',fontValue1);
    });
	//$('.customeSelect').selectmenu();
	$('.customselect2').change(function(){
		$(this).prev().html($(this).find('option:selected').text());
	});
	

	$( "#accordion" ).accordion({
		heightStyle: "content"
	});
	$( ".moreDetails, .moreInfo" ).accordion({
		heightStyle: "content",
		collapsible: true,
		active: false
	});
	$( "#tabs" ).tabs();
	$( ".textBox.date").datepicker({
		minDate: dateToday,
		onSelect: function(dateText, inst) {
			var date = $(this).val();	
			$(this).prev('#chk_dt').val(date);
			//For search form
			var form = $('#hotel_search');
			form.find("#date").val($(this).val());
		}
	});
	
	$('#srch_datepicker').datepicker({
		minDate: dateToday,
		onSelect: function(dateText, inst) {
			var date = $(this).val();	
			$(this).prev('#chk_dt').val(date);
			//For search form
			var form = $('#hotel_search');
			form.find("#date").val($(this).val());
			$('form#hotel_search').submit();
		}
	});
	$('.mobSearch.date').click(function() {
		    $('#srch_datepicker').datepicker("show");
	});

	$('header .menu').click(function(e) {
        $('header ul.menuList').slideToggle(500);
    });
});

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



//for custom checkbox code starts here
$ (function()
{
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
});

//for custom checkbox code ends here

//for custom RadioButton code Starts here
$ (function(){
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
});
$(document).ready(function(e) {
    $('.imageSlide').flexslider({
		controlNav: false,
		slideshow: false,
		selector: '.slides > .slide-group'
	});	
	
	$('.customselect2.selected').each(function(){
		$(this).prev().html($(this).find('option:selected').text());
	});


});


$(window).load(function(){
	$('.mobFullpgloader').hide();
	$('body').removeClass("fullLoad");

	$('.hotelDetialFlexslider').flexslider({
	//animation: 'slide',  
	controlNav: false,
	controlsContainer: ".flex-container",
	start: function(slider) {
		$('.slides li img').click(function(event){
			event.preventDefault();
			slider.flexAnimate(slider.getTarget("next"));
		});
	}
});

});

$(document).on( 'touchstart', function(e){ 
 console.log('Event Fired');
 var ele = $(e.target);
 console.log(ele); 
 if (!ele.hasClass("datepicker") && !ele.hasClass("dateBox") && !ele.hasClass("date") && !ele.parent('.ui-datepicker-next').children().hasClass("ui-icon") && !ele.hasClass('ui-state-default') && !ele.parent('.ui-datepicker-prev').children().hasClass("ui-icon"))
 	$(".ui-datepicker").hide();

 $('.datepicker .ui-state-default').on('click', function(){      
 	$(".ui-datepicker").hide();
 });

});


