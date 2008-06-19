function createRequestObject(overrideMime) {
    var tmpXmlHttpObject;

    //depending on what the browser supports, use the right way to create the XMLHttpRequest object
    if (window.XMLHttpRequest) { // Mozilla, Safari,...
        tmpXmlHttpObject = new XMLHttpRequest();
        // Set type accordingly to anticipated content type
        if (tmpXmlHttpObject.overrideMimeType && overrideMime != '') {
            tmpXmlHttpObject.overrideMimeType(overrideMime);
        }else if (tmpXmlHttpObject.overrideMimeType){
            tmpXmlHttpObject.overrideMimeType('text/xml');
            //tmpXmlHttpObject.overrideMimeType('text/html');
        }
    } else if (window.ActiveXObject) { // IE
        try {
            tmpXmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                tmpXmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }
    if (!tmpXmlHttpObject) {
        alert('Cannot create AJAX connection. Please upgrade your browser.');
        return false;
    }

    return tmpXmlHttpObject;
}

// Extract all the data from a form
// and format it in an inline string
// for an AJAX send.
function extractFormData(formId){
    postData = '';
    form = document.getElementById(formId);
    for(i=0;i<form.length;i++){
        if(form.elements[i].name != ''){
            // Don't return value if the input is
            // an unchecked checkbox.
            if(form.elements[i].type != 'checkbox'){
                postData += form.elements[i].name + '=' + form.elements[i].value + '&';
            }else{
                if(form.elements[i].checked == true){
                    postData += form.elements[i].name + '=' + form.elements[i].value + '&';
                }
            }
        }
    }
    return postData;
}

function xmlDOM(str){
    // Code for IE.
    if (window.ActiveXObject)
    {
        var doc=new ActiveXObject("Microsoft.XMLDOM");
        doc.async="false";
        doc.loadXML(str);
    }
    // Code for the other browsers.
    else
    {
        var parser=new DOMParser();
        var doc=parser.parseFromString(str,"text/xml");
    }

    return doc
}

var xmlHttpReq = Array();
function xmlHttp(httpMethod, url, responseAction, formData){
    xmlHttpReq[url] = false;
    xmlHttpReq[url] = new createRequestObject();
    xmlHttpReq[url].open(httpMethod, url, true);
    xmlHttpReq[url].setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    if (responseAction != null) {
      xmlHttpReq[url].onreadystatechange = function() {
        if (xmlHttpReq[url].readyState == 4) {
            responseAction(xmlHttpReq[url].responseText, url);
        }
      }
    }
    xmlHttpReq[url].send(formData);
    return xmlHttpReq[url].responseText;
}
