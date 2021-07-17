"use strict";

window.addEventListener('openModal', event => {
    $('.modal').modal('show')
});
window.addEventListener('closeModal', event => {
    $('.modal').modal('hide')
});
window.setTimeout(function () {
    $(".alert").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}, 2000);
window.addEventListener('success-nofitfy', event => {
    swal(event.detail.ntitle, event.detail.nmessage, "success");
    // iziToast.success({
    //     title: event.detail.ntitle,
    //     message: event.detail.nmessage,
    //     position: 'topRight'
    // });
})
window.addEventListener('confirm-delete', event => {
    swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                livewire.emit('delete', event.detail.item)

            } else {
                swal("Your imaginary file is safe!");
            }
        });
});
