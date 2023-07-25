$(function ($) {
    "use strict";


    jQuery(document).ready(function () {


        function children(v){
            $('.children_qty').html(v);
        }
        function adult(v){
            $('.adultqty').html(v);
        }
        let adultqty = 0;
        let childrenqty = 0;
        let extra_price = 0.00;
        $(document).on('click','.qtyplus',function(){
            adultqty += 1;
            adult(adultqty)
        })
        $(document).on('click','.qtymins',function(){
            if(adultqty > 1){
                adultqty -= 1;
            }
            adult(adultqty)
        })
        $(document).on('click','.children_qtyplus',function(){
            childrenqty += 1;
            children(childrenqty)
        })
        $(document).on('click','.children_qtymins',function(){
            if(childrenqty > 1){
                childrenqty -= 1;
            }
            children(childrenqty)
        })


        let dateStart = '';
        let dateEnd = '';
        let countDate = 0;
        let rooms;
        let values;
        let per_night_cost;
        let facilities = [];

        $(document).on('click','#check_avalibabity',function(){

            let date    = $('.date_range').val();
            date        = date.split("-");
            dateStart   = date[0];
            dateEnd     = date[1];
            countDate   = showDays(dateStart,dateEnd) + 1;
        

            if(!countDate){
                $.notify('please select date');
            }else{
                $.ajax({
                    type: "GET",
                    url: $('#hotel_search_ajax').val(),
                    data : {'hotel_id' : $('#hotel_id_ajax').val() , 'night' : countDate , 'start_date' : dateStart , 'end_date' : dateEnd,'adult':adultqty , 'children' :childrenqty },
                    success: function(data)
                    {
                        $('#room_view_search').html(data);
                    }
                });
            }

        })

        // DAYS COUNT FUNCTION
        function showDays(dateStart,secondDate){
                var startDay            = new Date(dateStart);
                var endDay              = new Date(secondDate);
                var millisecondsPerDay  = 1000 * 60 * 60 * 24;
                var millisBetween       = startDay.getTime() - endDay.getTime();
                var days                = millisBetween / millisecondsPerDay;
                return Math.abs(Math.floor(days));
            }


        $(document).on('click','.extra_prices',function(){
            
            if ($(this).is(":checked")) {

                facilities.push($(this).val());
                extra_price += parseFloat($(this).attr('data-href'));

           }else{

                facilities.splice( $.inArray($(this).val(), facilities), 1 );
                extra_price -= parseFloat($(this).attr('data-href'));
           }

           getTotalPrice();
           
        })

        $(document).on('change','.per_night_cost',function(){
            let currency = $('#showCurrency').val();
       
         per_night_cost = parseFloat($(this).data('target'));
        
        rooms = $(".per_night_cost").map(function() {
                    if($(this).val()){
                        return parseInt($(this).data('href'));
                    }
                }).get();

        values = $(".per_night_cost").map(function() {
            
                if($(this).val()){
                    return parseFloat($(this).val());
                }

                }).get();

        let total_room = 0;

                $.each(values,function() {
                    total_room += parseFloat(this, 10);
                });
            
                if ($(this).val()) {
                $(this).parent().find('.price_date_wise').html(countDate + ' night ' + $(this).val() + ' room price '+currency+' ' + (per_night_cost * countDate * $(this).val()).toFixed(2));
                } else {
                    $(this).parent().find('.price_date_wise').html('');
                }

                $('.total_room').text(total_room);
                getTotalPrice();
                
        })

        function getTotalPrice()
        {
            let total = 0;

            $(".per_night_cost").each(function() {
                var current_value   = parseFloat($(this).val());
                var cost            = parseFloat($(this).data('target'));
                
                if(current_value) {
                    let night_price_amount =  cost * parseFloat(countDate) * current_value;
                    total +=  night_price_amount;
                }

            });

            if(total + extra_price == 0){
                total == 0.00  
            } else {
                var service_fee = parseFloat($('.service_fee').data('href'));
                total = total + extra_price + service_fee;
            }

            booking();

            $('.total_price').html(total.toFixed(2));
            $('.facilities_price').html(extra_price.toFixed(2));
        } 

    $(document).on('click','.book_button',function(){

        if(!countDate || rooms == ''){
                    $('.book_button').hide();
                    $.notify('you not any room select');
                    return true;
                }

        let formData = new FormData();
      
            formData.append('night', countDate);
            formData.append('start_date', dateStart);
            formData.append('end_date', dateEnd);
            formData.append('room_id', rooms);
            formData.append('room_qty', values);
            formData.append('hotel_id', $('#hotel_id_ajax').val());
            formData.append('adult', adultqty);
            formData.append('children', childrenqty);
            formData.append('facilities', facilities);
       
        $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });
        
        $.ajax({
                   type: "POST",
                   url: mainurl + '/hotel/room/book',
                   data: formData,
                   processData: false,
                   contentType:false,
                   success: function(data)
                    {
                        if(data.login){
                            window.location.href = data.login;
                        }
                        if(data.error){
                            $.notify(data.error);
                        }
                        if(data.success){
                            window.location.href = data.success;
                        }
                        
                    }
                });
            })

            function booking (){
                if(!countDate || rooms == ''){
                    $('.book_button').hide();
                }else{
                    $('.book_button').show();
                }
            }

            if(!countDate || rooms == ''){
                    $('.book_button').hide();
                }else{
                    $('.book_button').show();
                }

    });
});