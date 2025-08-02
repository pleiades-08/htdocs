function showAlert(type, message) {
    let icon;
    let label;

    switch (type) {
        case 'success':
            icon = 'check-circle-fill';
            label = 'Success';
            break;
        case 'info':
            icon = 'info-fill';
            label = 'Info';
            break;
        case 'warning':
            icon = 'exclamation-triangle-fill';
            label = 'Warning';
            break;
        case 'danger':
            icon = 'exclamation-triangle-fill';
            label = 'Error';
            break;
        default:
            icon = 'info-fill';
            label = 'Notice';
    }

    $('#alertContainer').html(`
        <div class="alert alert-${type} d-flex align-items-center alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="${label}:">
                <use xlink:href="#${icon}"/>
            </svg>
            <div>${message}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `);
}
