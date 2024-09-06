$(document).ready(function() {
    $('.status-option').on('click', function(e) {
        e.preventDefault();
        var leaveId = $(this).data('id');
        var newStatus = $(this).data('status');
        var button = $(this).closest('.dropdown').find('button');

        $.ajax({
            url: 'update_leave_status.php',
            method: 'POST',
            data: { id: leaveId, status: newStatus },
            success: function(response) {
                if (response === 'success') {
                    if (newStatus === 'Approved') {
                        button.replaceWith("<button class='btn btn-success' disabled>Approved</button>");
                    } else if (newStatus === 'Declined') {
                        button.replaceWith("<button class='btn btn-danger' disabled>Declined</button>");
                    }
                } else {
                    alert('Failed to update status. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
});