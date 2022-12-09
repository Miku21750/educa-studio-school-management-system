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
// .done(res=>{
//     Swal.close();
//         console.log(response);
//         Swal.fire({
//             icon: 'success',
//             title: 'Your message was sended',
//             showConfirmButton: false,
//             timer: 1500
//         })
//         .then((result)=>{
//             if(true){
                
//                 $('#titleMessageForm').focus();
//                 //$('html, body').animate({ scrollTop: $('#titleMessageForm').offset().top }, 'fast');
//             }
//           })
// })