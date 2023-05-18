jQuery(document).ready(function($) {
    $("#Absolut").click(function () {
        alert("Okej kom in då.")
    })
})

// // When the document is ready
// jQuery(document).ready(function($) {
//     // Attach a click event handler to all checkboxes with the class "my-checkbox"
//     $('.my-checkbox').on('click', function() {
//         // Get the value of the clicked checkbox
//         var controlValue = $(this).is(':checked') ? 1 : 0;
//         console.log(controlValue);

//         // Get the ID of the corresponding question
//         var questionId = $(this).data('question-id');
//         console.log(questionId);

//         // Send an AJAX request to save the answer
//         $.ajax({
//             url: ajaxurl, // The WordPress AJAX URL
//             type: 'POST',
//             datatype: 'json',
//             data:
//             {
//                 action: 'save_answer',
//                 question_id: questionId,
//                 control_value: controlValue,
//                 message: "Hello, world!"
//             },
//             success: function(response) {
//                 // Display the success message
//                 alert(response);
//             },
//             error: function(xhr, status, error) {
//                 // Display the error message
//                 alert(xhr, status, error);
//             }
//         });
//     });
// });

jQuery(document).ready(function ($) {
    // Attach a click event handler to all checkboxes with class "my-checkbox"
    $('.my-checkbox').on('click', function () {
        var controlValue = $(this).is(':checked') ? 1 : 0;
        var questionId = $(this).data('question-id');

        var postData = {
            action: 'save_answer',
            control_value: controlValue,
            question_id: questionId,
            security: js_file_vars.nonce
        };
        console.log(postData);

        $.ajax({
            url: js_file_vars.ajax_url,
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function (response) {
                // Handle success response here
                console.log(JSON.parse(response));
            },
            error: function (xhr, status, error) {
                // Handle error response here
                console.log(status)
                console.log(error)
            }
        });

    });
});


