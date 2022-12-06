$(document).ready(function () {        
    $('#message').click(function (e) { 
        e.preventDefault();
        var id = $(this).attr(data-idMessage);
        // console.log($id)
        $.ajax({
            type: "POST",
            url: "/readedMessage",
            data: {
                id_message : id
            },
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                $('.').addClass(className);
            }
        });
    });
});