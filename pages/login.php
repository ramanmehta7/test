<?php
/**
 * Created by PhpStorm.
 * User: Mayank
 * Date: 25-Sep-18
 * Time: 5:14 PM
 */
?>

<!DOCTYPE html>
<html>
<title>Veratech</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700" rel="stylesheet">
<link rel="stylesheet" href="/CrawlerBoard/css/veratech_dash_dark.css?ver=1.0">
<script src="/CrawlerBoard/scripts/freeze.js?ver=1.0"></script>
<script src="/CrawlerBoard/scripts/login.js?ver=1.0"></script>
<script src="/CrawlerBoard/scripts/security/rollups/sha512.js?ver=1.0"></script>

<body>
<div id="loginModal" class="modal_background" style="display: none;">
    <div class="modal_dialog center">
        <h4 style="text-align: center">log in</h4>
        <input id="login_username" placeholder="Username" style="width: 66.666666%" type="text">
        <input id="login_pass" placeholder="Password" style="width: 66.666666%" type="password">
        <br>
        <br>
        <button id="log_in_button" class="button_primary"
                onclick="onLoginClick()" style="float: right;">log in
        </button>
    </div>
</div>
</body>
