<html>

<head>
  <title>PhpFileAdmin</title>
  <link rel="stylesheet" href="<?=INDIR?>img/style.css" type="text/css">
</head>

<body>


<div class="main" align=right>
<?=ADM_REF?>
<a href="index.php?dir=<?=CDIR?>">��������</a>&nbsp;&nbsp;
<a href="logout.php">�����</a>

</div>
<div class="Header">PhpFileAdmin</div>
<form name="MainForm" action="index.php?dir=<?=CDIR?>" method="post">
<script language="javascript">


function apply_form(v)
{

   document.MainForm.act.value=v;


   document.MainForm.submit();
   return;

}


function new_dir()
{

    var s=prompt("������� ��� ����� ����������","");
    if ((s == null)|| (s == '')) return;
    document.MainForm.str.value=s;
    apply_form(5);
    return;
}

function chperms(how)
{

    var s=prompt("������� ����� ����� ��� ��������� �������� (� ������� 775)","");
    if ((s == null)|| (s == '')) return;
    document.MainForm.str.value=s;
    apply_form(how);
    return;
}

function rename()
{

    var s=prompt("������� ����� ���\n(��� ������� ����������� ������ ���� ���������� ������)","");
    if ((s == null)|| (s == '')) return;
    document.MainForm.str.value=s;
    apply_form(9);
    return;
}

function unzip()
{

apply_form(8);
return;

}

function zip()
{

    var s=prompt("������� ��� ������\n(���� ����� ������)","");
    if ((s == null)|| (s == '')) return;
    document.MainForm.str.value=s;
    apply_form(10);
    return;
}
</script>


<table width=100%>

<tr valign=top>



<td class="main" width=60%>
<!-- ����������  -->
<?=DIR_HISTORY?><br><br>
<!-- ///  -->
<table width=100% class="main">
<tr> <td><b>���</b></td> <td><b>������</b></td> <td><b>�����</b></td> </tr>
<!-- ������ ������  -->
<?=FILES_LIST?>
<!-- ///  -->
</table>
</td>
<td width=40%>
<table width=100%  class="main">   <tr valign=top> <td>
<input name="curdir" type="hidden" value="<?=CDIR?>">

<!-- �����������   -->
<a title="����������" href="javascript:apply_form(1)"><img src="<?=INDIR?>img/copy.gif" alt="����������">����������</a>&nbsp;<br>
<a title="�������� / �����������" href="javascript:apply_form(2)"><img src="<?=INDIR?>img/move.gif" alt="�������� / �����������">��������</a>&nbsp;<br>
<a title="��������" href="javascript:apply_form(3)"><img src="<?=INDIR?>img/paste.gif" alt="��������">��������</a>&nbsp;<br>
<a title="�������" href="javascript:apply_form(4)"><img src="<?=INDIR?>img/del.gif" alt="�������">�������</a>&nbsp;
</td>

<td>
<a title="����� �����" href="javascript:new_dir()"><img src="<?=INDIR?>img/new_fold.gif" alt="����� �����">����� �����</a>&nbsp;<br>
<a title="��������� ����" href="upload.php?dir=<?=CDIR?>"><img src="<?=INDIR?>img/upload.gif" alt="��������� ����">��������� ����</a>&nbsp;<br>
<a title="�����" href="javascript:chperms(6)"><img src="<?=INDIR?>img/chmod.gif" alt="�����">�����</a>&nbsp;<br>
<a title="�����" href="javascript:chperms(7)"><img src="<?=INDIR?>img/chmod.gif" alt="�����">����� (����������)</a>&nbsp;<br>
</td>

<td>
<a title="�������������" href="javascript:rename()"><img src="<?=INDIR?>img/rename.gif" alt="�������������">�������������</a>&nbsp;<br>
<a title="����������� ���� (�)" href="javascript:unzip()"><img src="<?=INDIR?>img/unzip.gif" alt="����������� ���� (�)">����������� ���� (�)</a>&nbsp;<br>
<a title="��������� ���� (�)" href="javascript:zip()"><img src="<?=INDIR?>img/zip.gif" alt="��������� ���� (�)">������������ (zip)</a>&nbsp;<br>
<a title="������� (HTTP)" href="http_download.php?dir=<?=CDIR?>"><img src="<?=INDIR?>img/http_dl.gif" alt="������� (HTTP)">������� (HTTP)</a>&nbsp;<br>
</td>
</table>
<input name="str" type="hidden" value="">
<input name="act" type="hidden" value="">


<br>
<hr width=100%>
<!-- ///   -->

<!-- �������������� �����   -->
<?=BUFF?>

<!-- /// -->
</td>
</tr>

</table>
</form>
<?php



?>

</body>

</html>