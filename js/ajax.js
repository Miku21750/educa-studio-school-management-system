$(document).ready(function () {
    $('#userBoxAllAccount > img').click(function (e) { 
        e.preventDefault();
        $('#userBoxAllAccount').html();
        $.ajax({
            type: "POST",
            url: "/account-delete-data",
            data:{
                id:
            },
            dataType: "JSON",
            success: function (response) {
                console.log(response)
            }
        });
    });
});