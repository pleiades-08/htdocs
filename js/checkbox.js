$(document).ready(function () {

    //for check active accounts
    $('#checkAllActive').on('change', function () {
        $('.userCheckbox').prop('checked', this.checked);
    });


    $(document).on('change', '.userCheckbox', function () {
        const allChecked = $('.userCheckbox').length === $('.userCheckbox:checked').length;
        $('#checkAllActive').prop('checked', allChecked);
    });
    

    //for check inactive accounts
    $('#checkAllInactive').on('change', function () {
        $('.userCheckbox1').prop('checked', this.checked);
    });


    $(document).on('change', '.userCheckbox1', function () {
        const allChecked = $('.userCheckbox1').length === $('.userCheckbox1:checked').length;
        $('#checkAllInactive').prop('checked', allChecked);
    });

});