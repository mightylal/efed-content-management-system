$(document).ready( function () {

    $('input[name="checkall"]').click( function () {
        if (this.checked) {
            var check = true;
        } else {
            var check = false;
        }
        $('input[name="id[]"]').each( function () {
            $(this).prop('checked', check);
        });
    });

});