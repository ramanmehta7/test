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
<link rel="stylesheet" href="/CrawlerBoard/css/veratech_dash_dark.css?ver=2.4">
<script src="/CrawlerBoard/scripts/freeze.js?ver=1.0"></script>
<script src="/CrawlerBoard/scripts/alert.js?ver=3.0"></script>

<body>
<div id="alert_modal" class="modal_background" style="display: none;">
    <div class="modal_dialog center">
        <h4 id="alert_modal_title" style="text-align: center">alert</h4>
        <p id="alert_modal_message" style="text-align: center">Our wires seem to have tangled.<br>We're on it!</p>
        <br>
        <br>
        <button id="alert_modal_button" class="button_primary"
                onclick="onAlertModalClose()" style="float: right;">got it
        </button>
        <button id="alert_modal_close" class="button_text"
                onclick="onAlertModalClose()" style="float: right;">close
        </button>
    </div>
</div>
</body>
