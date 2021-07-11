/**
 * Created by Mayank on 02-09-2017.
 */
$('document').ready(function(){
    $('#loginModal').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#log_in_button').click();//Trigger search button click event
        }
    });
});

window.onclick = function (event) {
    if (event.target == document.getElementById('loginModal')) {
    }
};

function onLoginModalClose() {
    defreezeAllContent('all_visible_content');
    $("#loginModal").fadeOut(500);
    document.getElementById("login_username").value = "";
    document.getElementById("login_pass").value = "";
}

function showLoginModal() {
    freezeAllContent('all_visible_content');
    $("#loginModal").fadeIn(400);
    document.getElementById("login_username").focus();
}

function onLoginClick() {
    userid = document.getElementById("login_username").value;
    password = document.getElementById("login_pass").value;
    password =  CryptoJS.SHA512(password);
    let uri = window.location.protocol +"//" + window.location.hostname + "/CrawlerBoard/login";
    $.ajax({
        url: uri,
        data: {id: encodeURI(userid), pass: encodeURI(password), src: encodeURI('WEB')},
        type: 'POST',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.responseText);
            showAlertModal('oops', "Seems like something went wrong.<br>Please check the username and password, or contact customer support at support@veratech.in.")
        },
        success: function (data, textStatus, request) {
            //convert this to table
            handleUserLoginSuccess(data);
        }
    });
}
