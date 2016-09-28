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
<td height="29"><? echo $_SESSION['username'];?>，您好！<? if($_SESSION['kind']==2){ echo '您所属品牌为'.$_SESSION['pinpainame'];}else if($_SESSION['kind']==3){ echo '您所属品牌为'.$_SESSION['pinpainame'].',所属工厂为'.$_SESSION['gongchangname'];}?></td>
</tr>
</table></td>
<td>&nbsp;</td>
<td align="right"><table border="0" align="right" cellpadding="0" cellspacing="5">
<tr>
<td>
	<table width="70" border="0" cellspacing="0" cellpadding="0" class="nav02">
	<tr>
	<td width="20"><img src="images/icon05.gif" alt=""></td>
	<td width="50"><a href="home.php">主页</a></td>
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
	<td width="50"><a href="message.php">留言</a></td>
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
	<td width="80"><a href="index.php">电话脚本</a></td>
	</tr>
	</table>
</td>
<td>
	<table width="125" border="0" cellspacing="0" cellpadding="0" class="nav02">
	<tr>
	<td width="18"><img src="images/icon03.gif" alt=""></td>
	<td width="113"><a href="search.php">进入查询数据库</a></td>
	</tr>
	</table>
</td>
<?	}
if($_SESSION['kind']==1){ ?>
<td><table width="130" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon04.gif" alt=""></td>
<td><a href="case_search.php">个案管理与生成</a></td>
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
<td><a href="case_search.php">个案查询与阅读</a></td>
</tr>
</table></td>
<?	}
if($_SESSION['flag']>49){ ?>
<td><table width="120" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon05.gif" alt=""></td>
<td><a href="search_gongchang.php"><? if($_SESSION['flag'] == 50){ echo '下属工厂信息';}else{ echo '品牌/工厂查询';}?></a></td>
</tr>
</table></td>
<? }
if($_SESSION['flag']>95){ ?>
<td><table width="90" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon06.gif" alt=""></td>
<td><a href="adminuser.php">系统管理</a></td>
</tr>
</table></td>
<? }?>
<td><table width="90" border="0" cellspacing="0" cellpadding="0" class="nav02">
<tr>
<td width="18"><img src="images/icon07.gif" alt=""></td>
<td><a href="logout.php?action=logout">退出系统</a></td>
</tr>
</table></td>
</tr>
</table></td>
<td width="15">&nbsp;</td>
</tr>
</table></td>
</tr>
</table>