window.tableConfigs = {
    couponsTable: {
        DT_RowIndex: { searchable: false, orderable: false },
        name: {},
        code: {},
        discount_display: { searchable: false, orderable: false },
        apply_type_display: { searchable: false, orderable: false },
        validity_display: { searchable: false, orderable: false },
        status_toggle: { searchable: false, orderable: false },
        action: { searchable: false, orderable: false }
    }
};

$(document).ready(function () {
    $('table[data-route]').each(function () {
        const tableId = $(this).attr('id');
        const ajaxUrl = $(this).data('route');
        const config = window.tableConfigs?.[tableId] || {};

        const table = DataTableBuilder.init(tableId, ajaxUrl, config, function (d) {
            d.status = $('#filterStatus').val();
            d.apply_type = $('#filterApplyType').val();
        });

        $('#filterStatus, #filterApplyType').on('change', function () {
            table.ajax.reload();
        });

    });
});

//js
$(document).on('change', '.coupon-status-toggle', function () {

    let checkbox = $(this);
    let url = checkbox.data('url');
    let oldState = !checkbox.prop('checked');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if (window.toastr) {
                toastr.success(res.message || 'Status updated');
            }
        },
        error: function (xhr) {

            // revert toggle
            checkbox.prop('checked', oldState);

            if (xhr.status === 403) {
                let msg = xhr.responseJSON?.message 
                    || 'You do not have permission to change coupon status.';

                window.toastr ? toastr.error(msg) : alert(msg);
            } else {
                window.toastr
                    ? toastr.error('Something went wrong. Please try again.')
                    : alert('Something went wrong.');
            }
        }
    });
});
