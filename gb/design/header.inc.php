<?
require_once (__DIR__.'/../../inc/head.php');

if($razdel == '/gb/index.php') { $loadTwig('.twig', $renderData); }
?>
<link href="../../css/gb.css" rel="stylesheet" type="text/css" />
<script language=JavaScript>
  function clickIE4()
  {
	 if (event.button==2)
	 {
		return false;
	 }
  }
  function clickNS4(e)
  {
	 if (document.layers||document.getElementById&&!document.all)
	 {
		if (e.which==2||e.which==3)
		{
		  return false;
		}
	 }
  }
  if (document.layers)
  {
	 document.captureEvents(Event.MOUSEDOWN);
	 document.onmousedown=clickNS4;
  }
  else if (document.all && !document.getElementById)
  {
	 document.onmousedown=clickIE4;
  }
  document.oncontextmenu=new Function("return false");
</script>

<script language=JavaScript type="text/javascript">
  function smile(str){
	 obj = document.Sad_Raven_Guestbook.mess;
	 obj.focus();
	 obj.value =	obj.value + str;
  }
  function openBrWindow(theURL,winName,features){
	 window.open(theURL,winName,features);
  }
  function inserttags(st_t, en_t){
	 obj = document.Sad_Raven_Guestbook.mess;
	 obj2 = document.Sad_Raven_Guestbook;
	 if ((document.selection)) {
		obj.focus();
		obj2.document.selection.createRange().text = st_t+obj2.document.selection.createRange().text+en_t;
	 }
	 else
	 {
		obj.focus();
		obj.value += st_t+en_t;
	 }
  }
</script>

<!--Голова конец-->
