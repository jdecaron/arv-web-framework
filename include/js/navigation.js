function userLinkClick(url, type){

    dhtmlHistory.add(url, 1);

    // Process the URL with the AJAX
    // page loading system.
    if(type == 'ajax'){
        url_array = url.split('&')

        // Start the loading indacator for
        // the users.
        loadUrlInElementId('http://192.168.1.102/find-spots.com/include/tpl/test/page2.php', 'a0_b1');
    }
}

// Array that store specific information which is related to that
// query (URL) and retrieve it later in the
// response function.
var requestedUrlToLoadIn_array = Array();
function loadUrlInElementId(url, elementId){
    requestedUrlToLoadIn_array[url] = elementId;
    xmlHttp('get', url, loadContentInElementId, null);
}

function loadContentInElementId(response, url){
    // Stop the loading indicator for the users.
    document.getElementById(requestedUrlToLoadIn_array[url]).innerHTML = response;
}
