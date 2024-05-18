
document.addEventListener("DOMContentLoaded", function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function fetchNotifications() {
        $.ajax({
            url: '/notifications',
            method: 'GET',
            success: function (response) {
                const personalNotifs = response.personal_notifications;
                const productNotifs = response.product_notifications;

                const totalNotifs = personalNotifs.length + productNotifs.length;
                if (totalNotifs > 0) {
                    $('#notifCount').text(totalNotifs);
                    $('#nb_notif').text('Vous avez ' + totalNotifs + ' nouvelles notifications');
                }

                renderNotifications(personalNotifs, '#notifications');
                renderNotifications(productNotifs, '#notifications');
            },
            error: function (error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    function renderNotifications(notifications, container) {
        notifications.forEach(notif => {
            $(container).append(`
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="notification-item ">
                    <i class="bi bi-exclamation-circle text-warning"></i>
                    <div>
                    <p>${notif.message}</p>
                    </div>

                    <i class="bi bi-x-lg text-danger delete-notif" data-id="${notif.id}"></i>
                </li> 
            `);
        });

        $('.delete-notif').on('click', function () {
            const notifId = $(this).data('id');
            $.ajax({
                url: 'notifications/' + notifId,
                method: 'DELETE',
                success: function () {
                    $(`i[data-id="${notifId}"]`).closest('li').remove();
                    updateNotifCount();
                },
                error: function (error) {
                    console.error('Error deleting notification:', error);
                }
            });
        });
    }

    function updateNotifCount() {
        const personalCount = $('#personal-notifications ul li').length;
        const productCount = $('#product-notifications ul li').length;
        const totalNotifs = personalCount + productCount;
        if (totalNotifs > 0) {
            $('#notifCount').text(totalNotifs);
            $('#nb_notif').text('Vous avez ' + totalNotifs + ' nouvelles notifications');
        } else {
            $('#notifCount').text('');
            $('#nb_notif').text('Vous avez 0 nouvelles notifications');
        }
    }

    fetchNotifications();
});
