$(document).ready( function () {

    $('.quote-post').click( function () {
        var editor = CKEDITOR.instances.editor.document.getBody().getHtml();
        var post_id = $(this).attr('data-post');
        var post = $('#'+ post_id).html();
        var quote = "[quote=" + post_id + "]" + post + "[/quote]";
        CKEDITOR.instances.editor.insertHtml(editor + quote);
    });

});