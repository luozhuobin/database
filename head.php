<table width="100%" height="119" border="0" cellpadding="0" cellspacing="0" background="images/bgtop.jpg">
<tr>
<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="10"></td>
<td><img src="images/logo.jpg"  alt="" width="317" height="90"></td>
<td align="right"><img src="images/datalogo.jpg" alt="" width="204" height="90"></td>
<td width="10"></td>
</tr>
</table></td>
</tr>
<tr>
<td height="29"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="15" height="28">&nbsp;</td>
<td><table border="0" cellspacing="0" cellpadding="0" class="nav01">
<tr>
<td width="18" align="center" valign="middle"><img src="images/icon01.jpg" alt="" width="13" height="15"></td>
<td height="29"><? echo $_SESSION['username'];?>�����ã�<? if($_SESSION['kind']==2){ echo '������Ʒ��Ϊ'.$_SESSION['pinpainame'];}else if($_SESSION['kind']==3){ echo '������Ʒ��Ϊ'.$_SESSION['pinpainame'].',��������Ϊ'.$_SESSION['gongchangname'];}?></td>
</tr>
</table></td>
<td>&nbsp;</td>
<td align="right"><table border="0" align="right" cellpadding="0" cellspacing="5">
<tr>
<td>
	<table width="70" border="0" cellspacing="0" cellpadding="0" class="nav02">
	<tr>
	<td width="20"><img src="images/icon05.gif" alt=""></td>
	<td width="50"><a href="home.php">��ҳ</a></td>
	</tr>
	</table>
</td>
<?
if($_SESSION['flag'] <> 91)
{
?>
<td>
	<table width="70" border="0" cellspacing="0" cellpadding="0" class="nav02">
	<tr>
	<td width="20"><img src="images/icon05.gif" alt=""></td>
	<td width="50"><a href="message.php">����</a></td>
	</tr>
	</table>
</td>
<? 
}
if($_SESSION['flag']>90){ ?>
<td>
	<table width="100" border="0" cellspacing="0" cellpadding="0" class="nav02">
	<tr>
	<td width="20"><img src="images/icon02.gif" alt=""></td>
	<td width="80"><a href="index.php">�绰�ű�</a></td>
	</tr>
	</table>
</td>
<td>
	<table width="125" border="0" cellspacing="0" cellpadding="0" class="nav02">
	<tr>
	<td width="18"><img src="images/icon03.gif" alt=""></td>
	<td width="113"><a href="search.php">�����ѯ���ݿ�</a></td>
	</tr>
	</table>
</td>
<?	}
if($_SESSION['kind']==1){ ?>
<td><table width="130" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon04.gif" alt=""></td>
<td><a href="case_search.php">��������������</a></td>
</tr>
</table></td>
<?
}
else
{
?>
<td><table width="130" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon04.gif" alt=""></td>
<td><a href="case_search.php">������ѯ���Ķ�</a></td>
</tr>
</table></td>
<?	}
if($_SESSION['flag']>49){ ?>
<td><table width="120" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon05.gif" alt=""></td>
<td><a href="search_gongchang.php"><? if($_SESSION['flag'] == 50){ echo '����������Ϣ';}else{ echo 'Ʒ��/������ѯ';}?></a></td>
</tr>
</table></td>
<? }
if($_SESSION['flag']>95){ ?>
<td><table width="90" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon06.gif" alt=""></td>
<td><a href="adminuser.php">ϵͳ����</a></td>
</tr>
</table></td>
<? }?>
<td><table width="90" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon07.gif" alt=""></td>
<td><a href="logout.php?action=logout">�˳�ϵͳ</a></td>
</tr>
</table></td>
</tr>
</table></td>
<td width="15">&nbsp;</td>
</tr>
</table></td>
</tr>
</table>