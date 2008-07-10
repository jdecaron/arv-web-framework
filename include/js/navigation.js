function userLinkClick(url, type){

    dhtmlHistory.add(url, 1);

    // Process the URL with the AJAX
    // page loading system.
    if(type == 'ajax'){
        var url_array = url.split('&')

        // Start the loading indacator for
        // the users.
        //loadUrlInElementId('http://192.168.1.102/find-spots.com/include/tpl/test/page2.php', 'a0_b1');

        template_xml = xmlDOM(template.template0());
        template1_xml = xmlDOM(template.template1());
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
    window.urlsToLoad_array = [];
    for(var i=0;i<window.nextUrlList_array.length;i++){
        if(window.actualUrlList_array[window.nextUrlList_array[i][1]] != null && isNaN(window.nextUrlList_array[i][1])){
            // Get the content of the blocks which
            // they are already loaded in the page and
            // save it in the array which will be used
            // to show in next page.
            window.nextUrlList_array[i][1] = document.getElementById(window.actualUrlList_array[window.nextUrlList_array[i][1]]).innerHTML;
        }else{
            // Set a list of URLs in an array. And start
            // the loading asynchronously with an AJAX request.
            // The array contains the URL to load and the index
            // position in the other array (nextUrlList_array).
            window.urlsToLoad_array[window.urlsToLoad_array.length] = [i, window.nextUrlList_array[i][1]];
            xmlHttp('get', window.nextUrlList_array[i][1], loadUrlInArray, null);
        }
    }
}

function loadUrlInArray(response, url){
    for(var i=0;i<window.urlsToLoad_array.length;i++){
        if(window.urlsToLoad_array[i][1] == url){
            // Delete that URL from the array
            // because he just got loaded.
            window.nextUrlList_array[window.urlsToLoad_array[i][0]][1] = response;
            window.urlsToLoad_array.splice(i,1);
        }
    }

    // All the blocks has been loaded and it's now
    // time to change the content displayed to the user.
    if(window.urlsToLoad_array.length == 0){
        //alert(window.nextUrlList_array);
        compare2Structures(template_xml.firstChild.firstChild, template1_xml.firstChild.firstChild);
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

function processTemplateStructure(childs_xml, action){
    // Process the nodes "childs" of this node.
    for(var i=0;i<childs_xml.childNodes.length;i++){
        for(var j=0;j<childs_xml.childNodes[i].childNodes.length;j++){
            if(childs_xml.childNodes[i].childNodes[j].nodeName == 'childs'){
                processTemplateStructure(childs_xml.childNodes[i].childNodes[j], action);
            }

            if(childs_xml.childNodes[i].childNodes[j].nodeName == 'load' && action == 'actual'){
                window.actualUrlList_array[childs_xml.childNodes[i].childNodes[j].firstChild.nodeValue] = childs_xml.childNodes[i].nodeName;
            }else if(childs_xml.childNodes[i].childNodes[j].nodeName == 'load' && action == 'next'){
                window.nextUrlList_array[window.nextUrlList_array.length] = [childs_xml.childNodes[i].nodeName, childs_xml.childNodes[i].childNodes[j].firstChild.nodeValue];
            }
        }
    }
}

function compare2Structures(actual_xml, next_xml){
    // Delete the HTML elements that are not in
    // the new template.
    if(actual_xml.childNodes.length > next_xml.childNodes.length){
        // Get the actual name tag and replace the last
        // part with the blocks numbers to delete.
        nameTags_array = next_xml.childNodes[0].nodeName.split('_');

        // Delete the blocks.
        for(var k=0;k<(actual_xml.childNodes.length-next_xml.childNodes.length);k++){
            //Element.remove($('a0_b2'));
            nameTags_array[nameTags_array.length-1] = (nameTags_array[nameTags_array.length-1].substr(0,1)) + (actual_xml.childNodes.length-(actual_xml.childNodes.length-next_xml.childNodes.length)+k);
            Element.remove($(nameTags_array.join('_')));
        }
    }


    // Process the nodes "childs" of this node.
    for(var i=0;i<next_xml.childNodes.length;i++){

        for(var j=0;j<next_xml.childNodes[i].childNodes.length;j++){
           /* // Si ya de quoi et ya rien dans le vieux. Alors load la structure. */
           /* // Sinon, envoie les enfants a la fonction recursive. */
                
                // Verify if the actual structure has childs
                // at that stage of the loading of the new structure.
                // This is done with a "Try" to avoid errors and
                // crash the process.
                actualChildsNodeStatus = Try.these(
                        function() {return next_xml.childNodes[i].childNodes[j].nodeName == 'childs';}
                        );

                if(next_xml.childNodes[i].childNodes[j].nodeName == 'childs' && actualChildsNodeStatus){
                    // Load the blocks that are different from
                    // the current structure and the new one.
                    compare2Structures(actual_xml.childNodes[i].childNodes[j], next_xml.childNodes[i].childNodes[j]);
                }else{
                    // Load that branch now.
                }

           /* // Si la valeur de load n'est pas numerique et qu'elle n'egale pas alors le contenu dans le block est charge. */
            /*if(next_xml.childNodes[i].childNodes[j].nodeName == 'load' && action == 'actual'){
                window.actualUrlList_array[next_xml.childNodes[i].childNodes[j].firstChild.nodeValue] = next_xml.childNodes[i].nodeName;
            }*/
        }
    }
}
