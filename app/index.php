<html>
<head><title>.::UDENOR - Login::.</title>
<STYLE>
td { font-family: Tahoma, Verdana, Arial, sans-serif; }
body { font-family: Tahoma, Verdana, Arial, sans-serif; }
</STYLE>
</head>
<body link=#0000ff vlink=#0000ff bgcolor=#ffffff background="images/360/bgBasic.gif" topmargin=0 marginheight=0>
<table width=100% border=0 cellspacing=1 cellpadding=0 bgcolor=#224466>
 <tr height=1 bgcolor=#94ACC8>
  <td BGCOLOR="#FFFFFF" WIDTH="1%"><img src="images/logo.gif" border=0></td>
  <td align=right valign=middle nowrap></td>
 </tr>
</table>
<table width=100% border=0 cellspacing=0 cellpadding=0>
 <tr>
  <td width="100%" background="images/360/mb_top.gif" height=7><img src="images/360/spacer.gif" height=7></td>
  <td width=7 ><img src="images/360/mb_topright.gif"></td>
  
 </tr>
 <tr>
  <td bgcolor="#dddddd" align="center" width="70%">
<p><font size=+1>
<?php 
	extract($_REQUEST);
	if (!empty($reason)){
		echo "Error";
	}
?>
</font></p>
<table BORDER=0>
  <form method="post" action="login.php">
  <tr>
	<td nowrap>Usuario</td>
	<td><input type=text name=username></td>
  </tr>
  <tr>
    <td nowrap>Clave </td>
    <td><input type=password name=password></td>
  </tr>
  <tr>
    <td></td>
    <td><input type=submit name=Submit value="Entrar"></td>
  </tr>
  </form>
</table>
<p ALIGN=left></p>
 </td>
  <td background="images/360/mb_right2.gif" width=7 height=14 valign=top bgcolor="#224466"><img src="images/360/mb_right1.gif"></td>
  <td width="1%" valign=top><table width=100% border=0 cellspacing=0 cellpadding=0 bgcolor="#224466"></table></td>
 </tr>
 <tr>
  <td background="images/360/mb_bottom.gif" height=7><img src="images/360/spacer.gif" height=7></td>
  <td><img src="images/360/mb_bottomright.gif"></td>
  <td><img src="images/360/spacer.gif"></td>
 </tr>
</table>
<br>
<p STYLE="font-size:10px;">
Version: 1.0 
</P>
<p>
  <font size="-1">
    UDENOR
  </font>
</p>
<p><font size=-1>Copyright (C) 2005 UDENOR Todos los derechos reservados (autor: MTLB).</font></p>
</body>
</html>