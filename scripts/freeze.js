/**
 * Created by Mayank on 02-09-2017.
 */


function freezeAllContent(view_name) {
    document.getElementById(view_name).style.webkitFilter = "blur(12px)";
}

function defreezeAllContent(view_name) {
    document.getElementById(view_name).style.webkitFilter = "blur(0px)";
}