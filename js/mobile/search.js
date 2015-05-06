/* 
 * use for search 
 * define some global constant
 * 
 * and open the template in the editor. 
 * *
 */

var form = $('#hotel_search');
 
$.widget("custom.catAutocomplete", $.ui.autocomplete, {
    _renderMenu: function(ul, items) {
        var that = this, 
            currentCategory = "";
        $.each(items, function(index, item) {
            if (item.category != currentCategory) {
                ul.append("<li class='ui-autocomplete-category'>" + item.category + " </li>");
                currentCategory = item.category;
            }
            that._renderItemData(ul, item);
        });
    }
}); 

$("body").on("click", ".mapPin", function() {
	    setUserLocation('main');
    });

var searchPosition = "";
function setUserLocation(callback) {
    /*
    form = $("#searchForm");
	if(searchPosition == "middle") {
		form = $("#searchFormMiddle");
	} else if (searchPosition == "mainmiddle") {
		form = $("#searchFormMainMiddle");
	}
	form.find('.search_load').css('display', 'inline-block');
	*/
	searchPosition = callback;
    if (navigator.geolocation) {
    	navigator.geolocation.getCurrentPosition(showPosition);	
    } else {    	
		CommonAlertFunction('Geolocation is not supported by this browser.');
    }
}
function showPosition(position) {
        form.find("#latitude").val(position.coords.latitude);
	form.find("#longitude").val(position.coords.longitude);
        form.find("#search_keyword").val("My current position");
        form.find("#search_id").val("");
	form.find("#search_type").val("4");
        
	/*form = $("#searchForm");
	if(searchPosition == "middle") {
		form = $("#searchFormMiddle");
	} else if (searchPosition == "mainmiddle") {
		form = $("#searchFormMainMiddle");
	}
	
	form.find("#latitude").val(position.coords.latitude);
	form.find("#longitude").val(position.coords.longitude);
	//form.find("#latitude").val(48.8567);
	//form.find("#longitude").val(2.3508);
	
	setUserLocationCookie(position.coords.latitude, position.coords.longitude);
	//codeAddressFromLatLng(position.coords.latitude, position.coords.longitude);
	
	form.find("#search_name").val("USER_GEO_LOC");
	form.find("#search_id").val("");
	form.find("#search_type").val("");
	form.find(".searchbar").val("Ma position actuelle");
	form.find('.search_load').css('display', 'none');
	//submitSearchForm();
	$('.searchBoxCont .demoi').addClass('active');
            */
}
 
$(function() {
	 function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
    $(".searchBoxcity").change(function(){
       cTerm = $(this).val();
       form.find("#search_id").val(''); 
       form.find("#search_type").val('');
       form.find("#longitude").val('');
       form.find("#latitude").val('');
       form.find("#page").val(0);
       form.find("#search_keyword").val(cTerm);
    });
    $( ".searchBoxcity" )
    .bind("click",function(){        
       $(window).scrollTop($(this).offset().top );
    })
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {        
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .catAutocomplete({
        source: function( request, response ) {
          $.getJSON("/mobile/search/listHotelSearch", {
            term: extractLast( request.term )
          }, response );
        },
        search: function() {
          // custom minLength 
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {    
          //$( "#chk_dt" ).focus();
          if(window.filterdata !== 1){
              if(ui.item !== 'undefind'){                   
                window.location = ui.item.url;
                }
            }
            else{
              if(ui.item.category == 'Hotel' ){
                  window.location = ui.item.url;
              }else{
            	  form.find("#search_id").val(ui.item.id);
            	  form.find("#page").val(0);
                  
            	  form.find("#search_keyword").val(ui.item.lavel);
                  if(ui.item.category === 'State'){
                	  form.find("#search_type").val('3'); 
                  }
                  if(ui.item.category === 'City'){
                	  form.find("#search_type").val('2'); 
                  }
              }  
          }
        }
      });  
    
       
//    $(".step1.resultCont .showHideBtn").on('click',function(){
//    	customSearchWookmark();
//    	
//    });    
});
  
$(document).on('click',".searchReasult .resultCont .showHideBtn",function(){    
	if($(".step2").hasClass('resultPart')){
    	customSearchWookmark();
            
        Searchpage_height();
	}
    $(".step1").toggleClass("fullsize");
});  

var searchInner = {
    
    el : {
        febHotel : $(".fevimg")
        
    },
    init: function () { 
        searchInner.bindUIActions();
    },
    bindUIActions: function () {        
        $(document).on('click', searchInner.el.febHotel.selector, searchInner.actions.makeFavorite);
        
    },
    actions: {
        makeFavorite : function(){                
                var userstatus = $(this).attr('uid');
                var hid = $(this).attr('hid') ;
                var pData = {hid:hid,userId:userstatus}; //Array postdata
    
                if(userstatus){
                    $.ajax({
                        url:"/search/makefavorite",
                        type:'POST',
                        context: this,
                        data: pData,
                        datatype: 'json',
                        beforeSend: function(){
                            $(".fullpgloader").show();
                            //$(".searchReasult").hide();
                        },
                        success: function(datares){
                            var jsonRes = JSON.parse(datares);
                            $(".fullpgloader").hide();
                            //$(".searchReasult").show();
                            if(jsonRes.error){
                                $(this).addClass('fail');
                            }else{
                                $(this).attr('src','/images/mobile/feveritSel2-active.png');                                
                            }
                        }
                    });
                }else{
                    alert('please login to make favorite.');
                }
        },
    }
};
//change image fav hotel


 
$(document).ready(function () {
	
	$(window).resize(function(){
    	Searchpage_height();
        resizeIntermediate();
	});
    searchInner.init();
    var resultcount = $('#resCont').val();
    
    //Search Results Scroll Bar
   Searchpage_height();
    
    if(resultcount == 0){
      $(".actclass").height((window.innerHeight)-83).css('background-color', "#ffffff");  
      $(window).resize(function(){
      $(".actclass").height((window.innerHeight)-83).css('background-color', "#ffffff");
      });  
      
      $('.footer').addClass('stickFooter');
      $('.location').addClass('stickFooterLocation');
   }
   
    resizeIntermediate();
    
    var $wrapper = $('.searchReasult .slides');
    $wrapper.each(function() {
        $(this).find('div').sort(function (a, b) {
            return +a.getAttribute('sort') - +b.getAttribute('sort');
        })
        .appendTo(this);
    });
    
    
    //Update Form Date
    //Updated in dayuse.js
    
    //Update Form Arival Time
    /*$( "#arrival_time_select" ).selectmenu({
    	select: function( event, ui ) {
            if($(this).val()=='ARRIVAL TIME')
                form.find("#arrival_time").val('');
            else
    		form.find("#arrival_time").val($(this).val());
    	}
    });*/
    
    
    //Update Form Stay Duration
    $( "#stay_duration_select" ).selectmenu({
    	select: function( event, ui ) {
    		form.find("#stay_duration").val($(this).val());
    	}
    });
    
    //Update Form Budget
    $( "#budget_select" ).selectmenu({
    	select: function( event, ui ) {
    		form.find("#budget").val($(this).val());
    	}
    });
    
    //Update Form Star Rating
    $( "#rating_select" ).selectmenu({
    	select: function( event, ui ) {
    		form.find("#rating").val($(this).val());
    	}
    });
    
    //Update Form Equipment
    $( "#amenities_select" ).selectmenu({
    	select: function( event, ui ) {
    		form.find("#equipment").val($(this).val());
    	}
    });
    
    //Update Form Themes
    $('.checkboxItem').on('click', function() {
    	var amenitiesString = "";
    	$('.chk_pref_item').each(function () {
    		var checkBox = $(this).find(".checkboxItemCustom");
    		if(checkBox.is(":checked")) {
    			amenitiesString = amenitiesString+checkBox.val()+",";
    		}
    	});
    	form.find("#theme").val(amenitiesString);
	});
    
    //Update Form District
    $( "#district_select" ).selectmenu({
    	select: function( event, ui ) {
    		form.find("#district").val($(this).val());
    	}
    });
    
    //Order Form
    
    //Submit Form
    $('#search_button').on('click', function() {
    	form.submit();
    });
    
});

$(window).bind("load", function() {

	$(".fullpgloader").hide();
	$("#head_opt").show();
	$(".searchReasult").css('visibility', 'visible');

});

var ignoreScroll = false;
$("#infinite_scroll").scroll(function(e){    
    if (element_in_scroll("#infinite_scroll > ul > li:last")) {
        //$("#infinite_scroll").unbind('scroll');       
        if (ignoreScroll) return;
        var noresult = parseInt($('#noresult').val());
        var processCont = parseInt($('#processCont').val());
        //check for no more result.
        if(noresult !== 1 && processCont == 0){
        $('div#loadmoreajaxloader').show();
        var url      = window.location.href;        
        var getdata = url.split("?");
        var offset_page = parseInt($('#offset_page').val()) + parseInt($('#per_page').val());
        $.ajax({
        url: "/search/index?"+getdata[1]+"&offset_page="+offset_page, 
         beforeSend: function(){
             $('#processCont').val('1');
             ignoreScroll = true;
        },
        success: function(html)
        {
            //console.log('success');
            if(html)
            { 
                var currentPage = parseInt($('#offset_page').val()) + parseInt($('#per_page').val());
                $('#offset_page').val(currentPage);
                $(".ajaxloaddata").append(html);
                $('div#loadmoreajaxloader').hide();
                if($(".step2").hasClass('resultPart')){
                            setTimeout(function () {
                                // Do ssetomething after 5 seconds
                                customSearchWookmark();
                            }, 100);
                  
                    //add code
                    Searchpage_height();
                  }else{
                    $('.resultPart2 > ul > li').attr('style','');
                    /* $(".step2.resultPart2 ul li").each(function(){
                            var listviewName = $(this).find('.textPart').width();
                            $(this).find('.hotelName').width( listviewName - 144 );
                        });*/
                  }
                $('.imageSlide').flexslider({
		controlNav: false,
		slideshow: false,
		selector: '.slides > .slide-group'
                });
                $('#processCont').val('0');               
               ignoreScroll = false;
            }else
            {
                //set status no more result.
                $('#noresult').val(1);
                $('div#loadmoreajaxloader').html('<center></center>');
                ignoreScroll = true;
            }
        }
        });
        } 

        };
});

function setArrTime(e){
    //console.log(e);
    if(e=='ARRIVAL TIME')
        form.find("#arrival_time").val('');
    else
        form.find("#arrival_time").val(e);
}
function unsetSearchForm()
{
    form.find("#stay_duration").val(''); 
    form.find("#budget").val('');
    form.find("#rating").val('');
    form.find("#equipment").val('');
    form.find("#theme").val('');
    form.find("#district").val('');
    $('form#hotel_search').submit();
}

function resetSearchForm()
{
    form.find("#search_keyword").val(''); 
    form.find("#search_id").val(''); 
    form.find("#search_type").val('');
    form.find("#longitude").val('');
    form.find("#latitude").val('');
    form.find("#date").val('');
    form.find("#arrival_time").val('');
    form.find("#order").val('');    
    form.find("#page").val(0);
    form.find("#stay_duration").val(''); 
    form.find("#budget").val('');
    form.find("#rating").val('');
    form.find("#equipment").val('');
    form.find("#theme").val('');
    form.find("#district").val('');
    window.location.href = "../";
    //$('form#hotel_search').submit();
}
function setSearchVal(nm,id,va,fld){ 	
	//create the element
	var checkboxId = nm+id;
	
	if($("#"+checkboxId).is(':checked')) { 
		form.find("#"+fld).val(va);
	}
	else
		form.find("#"+fld).val('');
}

function setThemeVal(nm,id){
	var checkboxId = '';
	var amenitiesString = '';
	form.find("#theme").val(amenitiesString);
	for(var n=1;n<=nm;n++)
	{
		var checkboxId = id+n;
		if($("#"+checkboxId).is(':checked')) { 
			amenitiesString = amenitiesString+$("#"+checkboxId).val()+",";
		}
	}
	form.find("#theme").val(amenitiesString);
}

function setEquipVal(nm,id){
	var checkboxId = '';
	var amenitiesString = '';
	form.find("#equipment").val(amenitiesString);
	for(var n=1;n<=nm;n++)
	{
		var checkboxId = id+n;
		if($("#"+checkboxId).is(':checked')) { 
			amenitiesString = amenitiesString+$("#"+checkboxId).val()+",";
		}
	}
	form.find("#equipment").val(amenitiesString);
}

function setRatingVal(nm,id){
	var checkboxId = '';
	var amenitiesString = '';
	form.find("#rating").val(amenitiesString);
	for(var n=1;n<=nm;n++)
	{
		var checkboxId = id+n;
		if($("#"+checkboxId).is(':checked')) { 
			amenitiesString = amenitiesString+$("#"+checkboxId).val()+",";
		}
	}
	form.find("#rating").val(amenitiesString);
}


function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function element_in_scroll(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
 
    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();
 
    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

function Searchpage_height(){
    var headerHeight = $('.wrapper.header').outerHeight();   
    var searchbarHeight = $('.searchReasult .topPart').outerHeight();
    var searchcalHeight = (headerHeight + searchbarHeight) + 12;    
    $('.step2').height((window.innerHeight)-(searchcalHeight)).css('overflow','auto').css('overflow-x','hidden');
    
}
function customSearchWookmark(){
    $('.resultPart > ul > li').wookmark({
        // Prepare layout options.
        autoResize: false, // This will auto-update the layout when the browser window is resized.
        container: $('.resultPart > ul'), // Optional, used for some extra CSS styling
        offset: 10, // Optional, the distance between grid items
        outerOffset: 0, // Optional, the distance to the containers border
        itemWidth: 312 // Optional, the width of a grid item
    });
}
function resizeIntermediate(){
     // for intermediate page right grid starts here
    if($(".resultCont").hasClass('intermediate'))
    {
      var w = $( window ).width();
      var newwidth = (((Math.floor((w - 350) / 322 ))*322)+46)
      $('.searchReasult .resultCont.intermediate .result .resultPart').width( newwidth - 20 );
      setTimeout(function(){ var handler = $('.resultCont.intermediate .resultPart > ul > li');
      if(handler.length > 0){
          handler.wookmark({
              // Prepare layout options.
              autoResize: false, // This will auto-update the layout when the browser window is resized.
              container: $('.resultPart > ul'), // Optional, used for some extra CSS styling
              offset: 10, // Optional, the distance between grid items
              outerOffset: 0, // Optional, the distance to the containers border
              itemWidth: 312 // Optional, the width of a grid item
          });
      } }, 100);
      
        $('.imageSlide').flexslider({
          controlNav: false,
          slideshow: false,
          selector: '.slides > .slide-group'
        });
    }
    // for intermediate page right grid stop here
}