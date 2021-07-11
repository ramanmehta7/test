/**
 * Created by Mayank on 02-09-2017.
 */
function onAlertModalClose() {
    defreezeAllContent("all_visible_content");
    $("#alert_modal").fadeOut(500);
}

function showAlertModal(title, message) {
    freezeAllContent("all_visible_content");
    $("#alert_modal").fadeIn(400);
    document.getElementById('alert_modal_title').innerHTML = title;
    document.getElementById('alert_modal_message').innerHTML = message;
}