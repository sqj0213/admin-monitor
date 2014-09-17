var openedid; var openedid_ft; varflag=0,sflag=0;

function clickHandler()
{
	alert('asdf');
	var targetid,srcelement,targetelement,srcelement1,targetid1;
	var strbuf;
	srcelement=window.event.srcElement;
	if(srcelement.className=='white12'&&srcelement.id!='')
	{
		targetid=srcelement.id+'d';
		targetelement=document.all(targetid);
        targetid1=srcelement.id+'1';
		srcelement1=document.all(targetid1);
		if( targetelement != null )
		if (targetelement.style.display=='none')
		{
			targetelement.style.display='';
			strbuf=srcelement.src;
			if(strbuf.indexOf('plus.gif')>-1)
			{
				//srcelement.src='cssimg/tree_minus.gif';
				//srcelement1.src='cssimg/info_query1.gif';
				srcelement.src=srcelement.src.replace(/tree_plus.gif/gi, "tree_minus.gif");
				//srcelement1.src='cssimg/info_query1.gif';
				srcelement1.src=srcelement1.src.replace( /info_query.gif/gi, "info_query1.gif" );
			}
			else
			{
				//srcelement.src='cssimg/tree_minusl.gif';
				//srcelement1.src='cssimg/info_query.gif';
				srcelement.src=srcelement.src.replace(/tree_plus1.gif/gi, "tree_minus1.gif");

				//srcelement1.src='cssimg/info_query1.gif';
				srcelement1.src=srcelement1.src.replace( /info_query1.gif/gi, "info_query.gif" );
			}
		}
		else
		{
			targetelement.style.display='none';
			strbuf=srcelement.src;
			if(strbuf.indexOf('minus.gif')>-1)
			{
				srcelement.src=srcelement.src.replace(/tree_minus.gif/gi, "tree_plus.gif");
				srcelement1.src=srcelement1.src.replace( /info_query1.gif/gi, "info_query.gif" );
			}
			else
			{
				srcelement.src=srcelement.src.replace(/tree_minus.gif/gi, "tree_plus1.gif");
				srcelement1.src=srcelement1.src.replace( /info_query.gif/gi, "info_query1.gif" );
			}
		}
	}
}
document.onclick = clickHandler;

<!-- Web Site: http://www.painting-effects.co.uk -->
<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->
<!-- Begin
var menuskin = 'skin1'; // skin0, or skin1
var display_url = 0; // Show URLs in status bar?
function showmenuie5()
{
	//���瀛�������杩����椤剁骇������//-->
	document.getElementsByTagName('a1').url='menuopt.php?menuflag=menu_add_sub&menuID='+event.srcElement.id;
	document.getElementsByTagName('a2').url='menuopt.php?menuflag=menu_add&menuID='+event.srcElement.id;
	document.getElementsByTagName('a3').url='menuopt.php?menuflag=menu_upd&menuID='+event.srcElement.id;
	document.getElementsByTagName('a4').url='menuopt.php?menuflag=menu_del_save&menuID='+event.srcElement.id;
	//���瀛�������杩����椤剁骇������//-->
//	document.all('a1').url='adddatason.asp?id=';
//	document.all('a2').url='updatedata.asp?id=';
//	document.all('a3').url='deletetree.asp?id1=0';
//	document.all('a4').url='adddata.asp?id=0';

	var rightedge = document.body.clientWidth+event.clientX;
	var bottomedge = document.body.clientHeight+event.clientY;
	if (rightedge <ie5menu.offsetWidth)
		ie5menu.style.left = document.body.scrollLeft + event.clientX -ie5menu.offsetWidth;
	else
		ie5menu.style.left = document.body.scrollLeft + event.clientX;
	if (bottomedge <ie5menu.offsetHeight)
		ie5menu.style.top = document.body.scrollTop + event.clientY -ie5menu.offsetHeight;
	else
		ie5menu.style.top = document.body.scrollTop + event.clientY;
	ie5menu.style.visibility = 'visible';
	return false;
}
function hidemenuie5() {
	ie5menu.style.visibility = 'hidden';
}
function highlightie5() {
	if (event.srcElement.className == 'menuitems') {
		event.srcElement.style.backgroundColor = 'highlight';
		event.srcElement.style.color = 'white';
		if (display_url)
			window.status = event.srcElement.url;
	}
}
function lowlightie5() {
	if (event.srcElement.className == 'menuitems') {
		event.srcElement.style.backgroundColor = '';
		event.srcElement.style.color = 'black';
		window.status = '';
	}
}
function jumptoie5() {
	if (event.srcElement.className == 'menuitems') {
	if (event.srcElement.getAttribute('target') != null)
		window.open(event.srcElement.url, event.srcElement.getAttribute('target'));
	else
		{
			if(event.srcElement.id!='a4')
				window.open(event.srcElement.url,'newwin','');
			else
				window.location=event.srcElement.url;
		}
	}
}
// End -->
alert('asdf');
function Click()
{

	window.event.returnValue = false;
}

