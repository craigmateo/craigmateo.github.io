function SubmitFormData() {

    $("#results").empty();
    var course = $("#course").val();
    var lang = $("#language").val();
    var loc = $("#location").val();

    $.post("../admin/submit.php", { course: course, language: lang, location: loc},
    function(data) {
        //console.log(data);
        $('#results').html(data);
    });
}

$( document ).ready(function() {
    SubmitFormData();
});