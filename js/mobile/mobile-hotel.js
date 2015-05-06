
var hotel = {

    el: {
        loadMoreHotel : $('#loadMoreHotel'),
        
    },

    init: function () { 
        hotel.bindUIActions();
    },
            
    bindUIActions: function () {
        console.log(hotel.el.loadMoreHotel);
        $(document).on('click', hotel.el.loadMoreHotel.selector, hotel.actions.loadMore);
    },
    actions: {
        loadMore : function() { 
            var offset_value = parseInt($("#lead_more_count").val());
            var limit = 3;
            $.ajax({
                type: "POST",
                url: "/mobile/site/loadmore",
                data: {'offset': offset_value,'limit':limit},
                dataType: "json",
                success: function (resutl) {
                    $("#homePageHotelList").append(resutl.responseText);
                    $("#lead_more_count").val(parseInt(offset_value+limit));
                },
                error: function (resutl) {
                    $("#homePageHotelList").append(resutl.responseText);
                    $("#lead_more_count").val(parseInt(offset_value+limit));
                }
            });
        },
    }
};


$(document).ready(function () { 
    hotel.init();
});