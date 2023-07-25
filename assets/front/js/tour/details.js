$(function ($) {
    "use strict";


jQuery(document).ready(function () {

    let personQty = [];

    function children(v,rel){
        $('#'+rel).html(v);
        $('#'+rel).data('href',v);
    }
    
    
    $(document).on('click','.children_qtyplus',function(){
        let childrenqty = parseInt($('#' + $(this).attr('rel')).html());
        if ($(this).data('target') > childrenqty) {
            childrenqty += 1;
        }
        
        children(childrenqty,$(this).attr('rel'));
        getPerson();
        getTotalPrice();
    })


    $(document).on('click','.children_qtymins',function(){
        let childrenqty = parseInt($('#' + $(this).attr('rel')).html());
       
        if(childrenqty > $(this).data('href')){
            childrenqty -= 1;
        }
        children(childrenqty,$(this).attr('rel'));

        getPerson();
        getTotalPrice();

    })

    
    function getPerson(){
        personQty =	$(".children_qty").map(function(v) {
            return $(this).text();
        }).get();
        return personQty;
    }

    getPerson();
    
//  ----------------- Date ------------------//

    let facilities = [];
    let extra_price = 0.00;
   
    let startDate = '';
    let endDate = '';
    let duration = $('#tourDoration').val();
    duration = parseInt(duration) ;

    $(document).on('change','.date_check',function(){

        startDate    = new Date($(this).val());
        var newdate = new Date($(this).val());
        newdate.setDate(newdate.getDate() + (duration -1));
        var ndd = startDate.getDate();
        var nmm = startDate.getMonth() + 1;
        var ny = startDate.getFullYear();


        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();
        startDate = ndd + '/' + nmm + '/' + ny;
        endDate = dd + '/' + mm + '/' + y;
        dateshow(1);
        booking();
        getTotalPrice();
    });


//  ----------------- Date ------------------//


$(document).on('click','.tour_extra_prices',function(){

    if(endDate){
        if ($(this).is(":checked")) {
            facilities.push($(this).val());
            extra_price += parseFloat($(this).attr('data-href'));
        }else{
            facilities.splice( $.inArray($(this).val(), facilities), 1 );
            extra_price -= parseFloat($(this).attr('data-href'));
        }
        getTotalPrice();

    }else{
        $(this).attr("checked",false);
        $.notify('Please Select Your Booking Date');
    }
       
    })


    function getTotalPrice()
    {
        let total = 0;
        let person = 0;
        $('.children_qty').map(function(key,val){
                let qty = $(this).data('href');
                let price = $(this).data('target');
                let x = parseInt(qty) * parseFloat(price);
                $(this).attr('data-price',x);
                person += parseFloat($(this).attr('data-price')); 
        })


        
        let upprice = parseFloat($('#tourMainPrice').val()).toFixed(2);
        total += parseFloat(upprice) + parseFloat(person) + parseFloat(extra_price);
        $('.total_price').html(parseFloat(total).toFixed(2));
        dateshow(1);
    }

    function dateshow(e){
        if(e == 1){
            $('.date_show').removeClass('d-none');
            $('.start_date_show').html(startDate);
            $('.end_date_show').html(endDate);
        }else{
            $('.date_show').addClass('d-none');
            $('.start_date_show').html('')
            $('.end_date_show').html('')
        }
    }



    $(document).on('click','.book_button',function(){
        let formData = new FormData();

        if(!endDate){
            $('.book_button').attr('disabled',true);
        }else{
            $('.book_button').attr('disabled',false);
        }

        if (parseInt($('#tourMaxPeapule').val()) < parseInt(personQty[0]) + parseInt(personQty[1])) {
            $.notify(lang.maxsize + ' '+ parseInt($('#tourMaxPeapule').val()),'werning');
        } else {
            
            formData.append('night', duration);
            formData.append('start_date', startDate);
            formData.append('end_date', endDate);
            formData.append('tour_id', $('#tourId').val());
            formData.append('facilities', facilities);
            formData.append('person_type', personQty);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: mainurl + '/tour/book/store',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.login) {
                        window.location.href = data.login;
                    }
                    if (data.error) {
                        $.notify(data.error);
                    }
                    if (data.success) {
                        window.location.href = data.success;
                    }
                    
                }
            });
        }

        
    })

   
if(!endDate){
    $('.book_button').attr('disabled',true);
}else{
    $('.book_button').attr('disabled',false);
}

function booking (){
    if(!endDate){
    $('.book_button').attr('disabled',true);
    }else{
        $('.book_button').attr('disabled',false);
    }
}





});

});