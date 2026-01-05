//Universal Delete js

document.addEventListener("click", function (e) {

    let btn = e.target.closest(".delete-record");
    if (!btn) return;

    let route = btn.dataset.route;

    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {

        if (result.value) {
         // Submit form for delete
            Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Your Record has been deleted.',
            customClass: {
              confirmButton: 'btn btn-success waves-effect waves-light'
            }
          });
           
            let form = document.getElementById("global-delete-form");
            form.action = route;
            form.submit();
        }

    });

});