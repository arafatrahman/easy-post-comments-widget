jQuery(document).ready(function ($) {
    $('#commentform').on('submit', function (e) {
        e.preventDefault();

        let formData = {
            action: 'submit_comment',
            nonce: customCommentsAjax.nonce,
            post_id: $('#comment_post_ID').val(),
            comment: $('#comment').val(),
            author: $('#author').val(),
            email: $('#email').val(),
        };

        $.post(customCommentsAjax.ajaxUrl, formData, function (response) {
            if (response.success) {
                alert(response.data.message);
                location.reload(); // Reload to show the new comment
            } else {
                alert(response.data.message);
            }
        });
    });
});
