"use strict";

window.addEventListener('openInputModal', event => {
    $('#inputModal').modal('show')
});
window.addEventListener('closeInputModal', event => {
    $('#inputModal').modal('hide')
});
window.addEventListener('openModal', event => {
    $('#' + event.detail.modal).modal('show')
});
window.addEventListener('closeModal', event => {
    $('#' + event.detail.modal).modal('hide')
});
window.setTimeout(function () {
    $(".alert").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 2000);
window.addEventListener('success-nofitfy', event => {
    swal(event.detail.ntitle, event.detail.nmessage, "success");
});
window.addEventListener('success-izi', event => {
    iziToast.success({
        title: event.detail.ntitle,
        message: event.detail.nmessage,
        position: 'topRight'
    });
});


window.addEventListener('confirm-delete', event => {

    let swal_config = {
        title: "Are you sure?",
        text: "Data will be moved to trash tab. If you wish, you can restore or permanently delete later!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }
    if (event.detail.for == 'force') {
        swal_config = {
            title: "Are you sure?",
            text: "Data will be deleted from our database. Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        };
    }
    swal(swal_config)
        .then((willDelete) => {
            if (willDelete) {
                if (event.detail.mode === 'multiple') {
                    livewire.emit('deleteSelected')
                    $('select').val('');
                } else {
                    livewire.emit('delete')
                }


            } else {
                swal("You cancel the action, your data is save!");
            }
        });

});
