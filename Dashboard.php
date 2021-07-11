<?php
header('X-Frame-Options: DENY');
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/api/SessionManager.php";
//SessionManager::killExistingSession();
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://s3-ap-northeast-1.amazonaws.com/veratech-pixels/favicon.ico" rel="shortcut icon"
          type="image/x-icon"/>
</head>
<title>Veratech</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700" rel="stylesheet">
<link rel="stylesheet" href="/CrawlerBoard/css/veratech_dash_dark.css?ver=1.0">
<link rel="stylesheet" href="/CrawlerBoard/css/veratech_table.css?ver=1.0">
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/handsontable@4.0.0/dist/handsontable.full.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/handsontable@4.0.0/dist/handsontable.full.min.css" rel="stylesheet"
      media="screen">
<div id="all_visible_content">
    <div style="margin:2% 3%;">
        <h2 class="center">Goa High Court Dashboard(Bombay)</h2>
        <h6 id="script_id" class="center" style="color: var(--veratech_off_white);">IPR/PORTAL1</h6>
        <button class="button_secondary" onclick="refreshContent();" style="float: right; margin: 0px 10px;">REFRESH
        </button>
        <button class="button_secondary" onclick="beginCrawling();" style="margin: 0px 10px;">
            BEGIN CRAWL
        </button>
        <br/>
        <br/>
        <div class="s-padded"
             style="background-color: var(--veratech_faded_med_black); max-height: 100%; max-width: 100%; height: 100%;">
            <div style="padding: 2% 7% 7%;">
                <h4 id="running_status" class="center" style="color: var(--veratech_pure_green);">RUNNING</h4>
                <br/>
                <div class="spacing_third"><h1 id="success_count" class="center"
                                               style="color: var(--veratech_off_white);">0</h1><h6
                            class="center">Success</h6></div>
                <div class="spacing_third"><h1 id="pending_count" class="center"
                                               style="color: var(--veratech_off_white);">0</h1><h6
                            class="center">Pending</h6></div>
                <div class="spacing_third"><h1 id="failed_count" class="center"
                                               style="color: var(--veratech_off_white);">0</h1><h6
                            class="center">Failed</h6></div>
            </div>
            <div class="center">
                <button class="button_secondary" onclick="getSystemLogs();" style="margin: 0px 10px;">
                    SYSTEM LOGS
                </button>
                <button class="button_secondary" onclick="getErrorLogs();" style="margin: 0px 10px;">
                    ERROR LOGS
                </button>
            </div>
            <h5>OUTPUT</h5>
            <textarea id="response_logs" style="height: 100px;"></textarea>
            <div class="center"
                 style="background-color: var(--veratech_ultra_faded_white); height: 1px; width: 90%; margin-top: 60px;"></div>
            <div id="settings_update_module" class="center">
                <h5>SETTINGS</h5>
                <button class="button_primary" onclick="updateSettings();">UPDATE</button>
                <br/>
                <br/>
                <div id="settings"></div>
            </div>
            <br/>
            <div class="center"
                 style="background-color: var(--veratech_ultra_faded_white); height: 1px; width: 90%;"></div>
            <div id="queue_updation_module" class="center">
                <h5>ADD TO QUEUE</h5>
                <button class="button_primary" onclick="addToQueue();">ADD</button>
                <br/>
                <br/>
                <div id="queue_add"></div>
            </div>
        </div>
    </div>
</div>
​
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/pages/login.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/pages/alert.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/pages/loader.php";
?>
<script src="scripts/dashboard.js"></script>
</body>
</html>