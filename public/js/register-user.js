$(document).ready(function() {
    $(document).on("submit", "#registerUserForm", function(e) {
        e.preventDefault();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/userManagement",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "System Admin saved successfully."
                    }).then(() => {
                        window.location.href = "/main/userManagement";
                    });
                } else if (response == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Warning!",
                        text: "Please try again."
                    }); 
                } else if (response == 2) {
                    Swal.fire({
                        icon: "error",
                        title: "Warning!",
                        text: "An error occurred while saving your data."
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Server Error!",
                    text: "Something went wrong. Please try again later."
                });
            }
        });
    });
});

// $(document).ready(function() {
//     $(document).on('submit', '#loginForm', function(event){
//         event.preventDefault();
//         jQuery.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             url: '/login',
//             method: 'POST',
//             data: $(this).serialize(),
//                 success: function(response) {
//                     if(response == 1){
//                         Swal.fire({
//                             icon: "success",
//                             title: "Logging in!",
//                             text: "You will be redirected to another page.",
//                             showConfirmButton: false,
//                             timer: 3000,
//                         }).then(function(){
//                             window.location = "/main/";
//                         });
//                     }else if(response = 0){
//                         var errorMessages = Object.values(response.message).join('<br>');
//                         Swal.fire({
//                             icon: 'error',
//                             title: 'Login validation failed!',
//                             text: "Please check all fields.",
//                         });
//                     }else if(response == 401){
//                         Swal.fire({
//                             icon: 'error',
//                             title: 'Login failed!',
//                             text: 'Invalid username or password!',
//                             showConfirmButton: false,
//                             timer: 3000,
//                         });
//                     }else if(response == 404){
//                         Swal.fire({
//                             icon: 'error',
//                             title: 'Login failed!',
//                             text: 'Invalid username or password!',
//                             showConfirmButton: false,
//                             timer: 3000,
//                         });
//                     }else{
//                         Swal.fire({
//                             icon: 'error',
//                             title: 'Something went wrong!',
//                             text: 'Please try again later!',
//                             showConfirmButton: false,
//                             timer: 3000,
//                         });
//                     }
//                 },
//                 error: function(xhr) {
//                     console.log(xhr.responseJSON);
//                 }

//         });
//     });
// });
