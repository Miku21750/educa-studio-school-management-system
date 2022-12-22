$('.item_bayar').click(function (e) { 
    e.preventDefault();
    var id_finance = $('.item_bayar').attr('data-idFinance');
    $.ajax({
        type: "GET",
        url: "/api/get-midtrans",
        data: {
            id: id_finance
        },
        dataType: "JSON",
        success: function (response) {
            
        }
    });
});