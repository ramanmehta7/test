$(document).ready(function () {
    var container = document.getElementById('queue_add');
    headings = ['case_number', 'case_year', 'case_type'];
    hot_content = new Handsontable(container, {
        startRows: 1,
        startCols: headings.length,
        stretchH: 'all',
        height: 400,
        autoWrapRow: true,
        manualRowResize: true,
        manualRowMove: true,
        manualColumnMove: true,
        rowHeaders: true,
        manualColumnResize: true,
        colHeaders: headings,
        contextMenu: ['row_above', 'row_below', 'remove_row', 'undo', 'redo'],
        licenseKey: 'non-commercial-and-evaluation'
    });
    showLoginModal();
});
function refreshContent() {
    showLoader();
    checkIfRunning();
    getOverview();
    getSettings();
    dismissLoader();
}
function getTableDataAsJson(hot) {
    let tableData = hot.getData();
    let headings = hot.getColHeader();
    let script_id = document.getElementById('script_id').innerHTML;
    json = {};
    data = [];
    for (let i = 0; i < tableData.length; i++) {
        if (isRowEmpty(tableData[i])) continue;
        let currentRow = tableData[i];
        var associativeRow = {};
        for (let j = 0; j < currentRow.length; j++) {
            key = headings[j];
            value = currentRow[j];
            associativeRow[key] = value;
        }
        data.push(associativeRow);
    }
    json['data'] = data;
    json['fields'] = headings;
    json['script_id'] = script_id;
    return json;
}
function removeEmptyElementsFromArray(array) {
    return array.filter(function (el) {
        return el != null;
    });
}
function isRowEmpty(row) {
    return removeEmptyElementsFromArray(row).length === 0;
}
function isTableEmpty(table) {
    for (let i = 0; i < table.length; i++) {
        if (!isRowEmpty(table[i])) return false;
    }
    return true;
}
function addToQueue() {
    showLoader();
    tableDataJson = getTableDataAsJson(hot_content);
    tableDataJson = JSON.stringify(tableDataJson);
    let uri = window.location.protocol + "//" + window.location.hostname + "/CrawlerBoard/addtoqueue";
    $.ajax({
        url: uri,
        data: {json: tableDataJson},
        type: 'POST',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.responseText);
            dismissLoader();
        },
        success: function (data, textStatus, request) {
            document.getElementById('response_logs').value = data;
            refreshContent();
            dismissLoader();
        }
    });
}
function updateSettings() {
    showLoader();
    tableDataJson = getTableDataAsJson(hot_settings);
    tableDataJson = JSON.stringify(tableDataJson);
    let uri = window.location.protocol + "//" + window.location.hostname + "/CrawlerBoard/updatesettings";
    $.ajax({
        url: uri,
        data: {json: tableDataJson},
        type: 'POST',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.responseText);
            dismissLoader();
        },
        success: function (data, textStatus, request) {
            document.getElementById('response_logs').value = data;
            refreshContent();
            dismissLoader();
        }
    });
}
function getOverview() {
    showLoader();
    let uri = window.location.protocol + "//" + window.location.hostname + "/CrawlerBoard/overview";
    $.ajax({
        url: uri,
        data: {},
        type: 'POST',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.responseText);
            dismissLoader();
        },
        success: function (data, textStatus, request) {
            handleOverviewResponse(data);
            dismissLoader();
        }
    });
}
function beginCrawling() {
    showLoader();
    let uri = window.location.protocol + "//" + window.location.hostname + "/CrawlerBoard/begincrawl";
    $.ajax({
        url: uri,
        data: {},
        type: 'POST',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.responseText);
            dismissLoader();
        },
        success: function (data, textStatus, request) {
            refreshContent();
            dismissLoader();
        }
    });
}
function getSettings() {
    showLoader();
    let uri = window.location.protocol + "//" + window.location.hostname + "/CrawlerBoard/getsettings";
    $.ajax({
        url: uri,
        data: {},
        type: 'POST',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.responseText);
            dismissLoader();
        },
        success: function (data, textStatus, request) {
            handleSettingsResponse(data);
            dismissLoader();
        }
    });
}
function checkIfRunning() {
    showLoader();
    let uri = window.location.protocol + "//" + window.location.hostname + "/CrawlerBoard/isrunning";
    $.ajax({
        url: uri,
        data: {},
        type: 'POST',
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest.status);
            console.log(XMLHttpRequest.responseText);
            dismissLoader();
        },
        success: function (data, textStatus, request) {
            if (data != null && data !== '') {
                document.getElementById("running_status").innerText = data;
                if(data === 'STOPPED') {
                    document.getElementById('running_status').style.color = 'var(--veratech_faded_red)';
                } else {
                    document.getElementById('running_status').style.color = 'var(--veratech_pure_green)';
                }
            }
            dismissLoader();
        }
    });
}
function getSystemLogs() {
    let uri = window.location.protocol + "//" + window.location.hostname + "/CrawlerBoard/getoutputlogs";
    window.open(uri, '_blank');
}
function getErrorLogs() {
    let uri = window.location.protocol + "//" + window.location.hostname + "/CrawlerBoard/geterrorlogs";
    window.open(uri, '_blank');
}
function handleOverviewResponse(responseJson) {
    if (responseJson === '') return;
    let response = JSON.parse(responseJson);
    document.getElementById('success_count').innerHTML = response['SUCCESS'];
    document.getElementById('pending_count').innerHTML = response['PENDING'];
    document.getElementById('failed_count').innerHTML = response['FAILED'];
}
function handleSettingsResponse(responseJson) {
    if (responseJson === '') return;
    let response = JSON.parse(responseJson);
    let headings = response['fields'];
    let responseData = response['data'];
    let tableData = [];
    for (let i = 0; i < responseData.length; i++) {
        let row = [];
        for (let j = 0; j < headings.length; j++) {
            row[j] = responseData[i][headings[j]];
        }
        tableData[i] = row;
    }
    var container = document.getElementById('settings');
    hot_settings = new Handsontable(container, {
        data: tableData,
        startRows: 1,
        startCols: headings.length,
        stretchH: 'all',
        height: 200,
        autoWrapRow: true,
        manualRowResize: true,
        manualRowMove: true,
        manualColumnMove: true,
        rowHeaders: true,
        manualColumnResize: true,
        colHeaders: headings,
        contextMenu: ['row_above', 'row_below', 'remove_row', 'undo', 'redo'],
        licenseKey: 'non-commercial-and-evaluation'
    });
}
function handleUserLoginSuccess(data) {
    var json = JSON.parse(data);
    auth_token = json['auth_token'];
    status = json['status'];
    //TODO check status
    onLoginModalClose();
    refreshContent();
}