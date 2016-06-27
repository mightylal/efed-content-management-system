$(document).ready(function() {

    $('#type').change(function() {
        var type = $(this).val();
        var typeSplit = type.split('v');
        var typeCount = typeSplit.length - 1;
        var content = "";
        var wrestlerOptions = $('#wrestlerOptions').html();
        if (typeSplit == "10" || typeSplit == "20" || typeSplit == "30") {
            content = "<select class='form-control' name='wrestler[]' size='" + typeSplit + "' multiple>" + wrestlerOptions + "</select>";
        } else if (typeSplit == "0") {
            content = "Wrestlers are not selected for angles.";
        } else {
            for (var i = 0; i <= typeCount; i++) {
                content += "<div class='row'>";
                var valueCount = typeSplit[i];
                switch (valueCount) {
                    case "2":
                        var start = "<div class='col-md-6'>";
                        var end = "</div>";
                        break;
                    case "3":
                        var start = "<div class='col-md-4'>";
                        var end = "</div>";
                        break;
                    case "4":
                        var start = "<div class='col-md-3'>";
                        var end = "</div>";
                        break;
                    case "5":
                        var start = "<div class='col-md-2'>";
                        var end = "</div>";
                        break;
                    default:
                        var start = "<div class='col-md-12'>";
                        var end = "</div>";
                }
                for (var x = 0; x < valueCount; x++) {
                    content += start + "<select class='form-control' name='wrestler[]'>" + wrestlerOptions + "</select>" + end;
                }
                if (valueCount == 5) {
                    content += "<div class='col-md-2'>&nbsp;</div>";
                }
                content += "</div>";
                if (i != typeCount) {
                    content += "<p class='help-block'>VS.</p>";
                }
            }
        }
        $('#wrestlers-container').html(content);
    });

});