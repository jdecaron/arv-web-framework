<div style="padding-right:27px;background-color:white;width:653px;margin-bottom:80px;">

<div style="margin-top:35px;margin-left:22px;font-size:18px;color:#547da1;">What is the ARV framework?</div>
<div style="margin-left:33px;">The ARV web framework is a client and server side tool that simplifies the coding technique to load asynchronous content into web pages. In the most simple case, a programmer would have to insert only one line of code inside the HTML anchor tags. 
<br><br>
<div style="margin-left:14px;">Code example : <em><span style="color:#54a15f">&lt;a</span> <span style="color:#a19454">&lt;?php</span>=siteTools::generateAnchorAttributes(<span style="color:#547da1">array</span>(<span style="color:#a1545c">'attributes'</span> =&gt; <span style="color:#547da1">array</span>(<span style="color:#a1545c">'href'</span> =&gt; <span style="color:#a1545c">'page=click&urlvar=value'</span>))<span style="color:#a19454">?&gt;</span><span style="color:#54a15f">&gt;</span>Click<span style="color:#54a15f">&lt;/a&gt;</span></em></div>
<br>
The main goal of the ARV framework is to increase the navigation speed for any heavy content website that has a lot of graphical elements, the framework does that while remaining compatible with other JavaScript frameworks as well as an MVC architecture on the server side.
</div>

<div style="margin-top:35px;margin-left:22px;font-size:18px;color:#547da1;">What are the main features of the framework?</div>
<div style="margin-left:33px;">
<div style="margin-left:2px;list-style-type:square;">
<li>Even if the user has JavaScript turned off, the system will continue to link and render all the requests exactly as they are meant to.</li>
<br>
<li>Everything is transparent to the user, nothing is different about any browsing behaviours the user is used to, which include browser history (back and forward), URL sharing and page refreshing.
</li>
<br>
<li>Surfing is faster, which leads to a greater number of clicks during a time restrained browsing session.</li>
<br>
<li>The latest feature is that it is very easy and fast to work with the ARV framework. So easy that a web developer can use it even if they only knows markup langueges like HTML.</li>
</div>
</div>
<div style="margin-top:35px;margin-left:22px;font-size:18px;color:#547da1;">How does the system work?</div>
<div style="margin-left:33px;">he system works with a list of templates that are defined on the server side. With these templates, the system renders the pages and render their structures as XML. Later, these XML structures are used by the client side script as references. And during a browsing sessions, the system will check for the differences between the loaded page and the requested page. Then the script will load the content that is not loaded in the page.<br><br>When JavaScript is deactivated the requests are made to a server side script where this script render the full pages based on their template.</div>
<div style="margin-top:35px;margin-left:22px;font-size:18px;color:#547da1;">Watch the screencast.</div>
<div style="margin-left:33px;">The screencast showcases the basic steps of creating a new page with the framework. It's a 7MB H264 MOV file that can be downloaded here : (<a href="http://paralines.net/nouveau/screencast.mp4" style="color:#547da1;font-weight:bold;">screencast.mp4</a>).</div>
</div>
