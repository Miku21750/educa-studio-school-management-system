$(document).ready(function () {
    $('#noticeModal').on('show.bs.modal', function (event) {
        $.ajax({
            type: "GET",
            url: "/getMessageDetails",
            data: "data",
            dataType: "dataType",
            success: function (response) {
                
            }
        });
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

      })
});