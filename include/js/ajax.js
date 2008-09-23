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
