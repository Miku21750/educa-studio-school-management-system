$(document).ready(function () {
    $('#editButton').click(function (e) { 
        e.preventDefault();
        console.log($('#showDataDetailAccountSetting').html())
        $('#showDataDetailAccountSetting').hide();
    });
});