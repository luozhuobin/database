<table width="100%" border="0" cellspacing="0" cellpadding="0" class="footer">
<tr>
<td width="12" height="23">&nbsp;</td>
<td width="440">Inno Community Development Organisation&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;系统版本V1.0</td>
<td align="right">&nbsp;</td>
<td width="404" align="right"><?
	$rs2 = mysql_query("select addtime from question_answer order by addtime desc limit 0,1");
	$row2 = mysql_fetch_array($rs2);
?>	问题数据库更新时间：<? echo date('Y-m-d',$row2['addtime']);?>&nbsp;&nbsp;&nbsp;&nbsp;<?
	$tiaoshu = 0;
	
	$rs2 = mysql_query("select count(questionid) from question_answer");
	$row2 = mysql_fetch_row($rs2);
	$tiaoshu = $row2[0];
	
	$rs2 = mysql_query("select count(gongchangid) from gongchang");
	$row2 = mysql_fetch_row($rs2);
	$tiaoshu = $tiaoshu + $row2[0];

	$rs2 = mysql_query("select count(phoneid) from phone");
	$row2 = mysql_fetch_row($rs2);
	$tiaoshu = $tiaoshu + $row2[0];

	$rs2 = mysql_query("select count(cityid) from city");
	$row2 = mysql_fetch_row($rs2);
	$tiaoshu = $tiaoshu + $row2[0];
	
	$rs2 = mysql_query("select count(caseid) from case_table");
	$row2 = mysql_fetch_row($rs2);
	$tiaoshu = $tiaoshu + $row2[0];

	mysql_close($conn);
?>数据总条数：<? echo $tiaoshu;?></td>
<td width="11">&nbsp;</td>
</tr>
</table>