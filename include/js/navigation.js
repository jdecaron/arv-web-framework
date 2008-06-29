function userLinkClick(url, type){

    dhtmlHistory.add(url, 1);

    // Process the URL with the AJAX
    // page loading system.
    if(type == 'ajax'){
        var url_array = url.split('&')

        // Start the loading indacator for
        // the users.
        loadUrlInElementId('http://192.168.1.102/find-spots.com/include/tpl/test/page2.php', 'a0_b1');

        var template_xml = xmlDOM(template.template0());
        var template1_xml = xmlDOM(template.template1());
        // Retrieve all the URLs of a template and put them in
        // an associative array.
        window.actualUrlList_array = Array();
        processTemplateStructure(template_xml.firstChild.firstChild, 'actual');
        window.nextUrlList_array = [];
        processTemplateStructure(template1_xml.firstChild.firstChild, 'next');
        loadBlocks();
    }
}

function loadBlocks(){
    urlsToLoad = [];
    for(var i=0;i<window.nextUrlList_array.length;i++){
        if(window.actualUrlList_array[window.nextUrlList_array[i][1]] != null && isNaN(window.nextUrlList_array[i][1])){
            // Get the content of the blocks which
            // they are already loaded in the page and
            // save it in the array which will be used
            // to show the next page.
            window.nextUrlList_array[i][1] = document.getElementById(window.actualUrlList_array[window.nextUrlList_array[i][1]]).innerHTML;
        }else{
            // Set a list of URLs to load asynchronously.
            // The first cell is the index to know in which
            // cell of the next URL list the content has 
            // to be placed in.
            urlsToLoad[urlsToLoad.length] = [i, window.nextUrlList_array[i][1]];
        }
    }
alert(window.nextUrlList_array);
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

function processTemplateStructure(childs_xml, action){
    // Process the nodes "childs" of this node.
    for(var i=0;i<childs_xml.childNodes.length;i++){
        for(var j=0;j<childs_xml.childNodes[i].childNodes.length;j++){
            if(childs_xml.childNodes[i].childNodes[j].nodeName == 'childs'){
                processTemplateStructure(childs_xml.childNodes[i].childNodes[j], action);
            }

            if(childs_xml.childNodes[i].childNodes[j].nodeName == 'load' && action == 'actual'){
                window.actualUrlList_array[childs_xml.childNodes[i].childNodes[j].firstChild.nodeValue] = childs_xml.childNodes[i].nodeName;
            }
            if(childs_xml.childNodes[i].childNodes[j].nodeName == 'load' && action == 'next'){
                window.nextUrlList_array[window.nextUrlList_array.length] = [childs_xml.childNodes[i].nodeName, childs_xml.childNodes[i].childNodes[j].firstChild.nodeValue];
            }
        }
    }
}
