<table width="100%" border="0" cellspacing="0" cellpadding="0" height="435" background="images/leftbg.jpg">
<tr>
<td align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="10"></td>
</tr>    
</table>      
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="leftsub">
<tr>
<td width="93%" height="25">��<a href="search_gongchang.php"><? if($_SESSION['kind'] == 2){ echo '���������б�';}else{ echo '������ѯ';}?></a></td>
</tr>
<?	if($_SESSION['flag']>95){ ?>
<tr>
<td height="25">��<a href="gongchang_city.php" >���������в鿴����</a></td>
</tr>
<tr>
<td height="25">��<a href="gongchang_pinpai.php" >��Ʒ�Ʋ鿴����</a></td>
</tr>
<tr>
<td height="25">��<a href="gongchang_chanpin.php" >����Ʒ�鿴����</a></td>
</tr>
<?	}
if($_SESSION['flag']>90){ ?>
<tr>
<td height="25">��<a href="search_pinpai.php">Ʒ�Ʋ�ѯ</a></td>
</tr>
<?	}?>
</table>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>