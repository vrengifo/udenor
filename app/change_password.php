<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		//buildmenu($username);
		//buildsubmenu($id_aplicacion,$id_subaplicacion);
		///todo  el html como se quiera
	?>
	
	<br>
	<form action="change_password1.php" method="post" name="form1">
	<?php				
		//construye el html para los campos relacionados
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion;
	?>
				
<TABLE WIDTH="50%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
	<TR><TD>
	<table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
	<tr>
		<td nowrap><SPAN class="title" STYLE="cursor:default;">
			<img src="images/360/personwrite.gif" border=0 align=absmiddle HSPACE=2><font color="#FFFFFF">
			Cambiar Password:</font></SPAN>
		</td>
	</TR>
	</TABLE>
	<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside"><TR><TD><TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
                <TR BGCOLOR="#CCCCCC"> 
                  <td nowrap class='table_hd'>* Nuevo Password:</td>
                  <td nowrap class='table_hd'>
				    <input type="password" name="pass1" >
				  </td>
                </tr>
                <TR BGCOLOR="#CCCCCC"> 
                  <td nowrap class='table_hd'>* Redigite su nuevo password:</td>
                  <td nowrap class='table_hd'><input type="password" name="pass2" ></td>
                </tr>
              </TABLE>
</TABLE>
</TABLE>

<input type="submit" name="Add" value="Change" onClick="validate();return returnVal;">
<input type="button" name="Cancel" value="Cancel" onClick="window.close();">
<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
		<br>			
	</form>	
	
	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {

define('pass1', 'string', 'Nuevo Password');
define('pass2', 'string', 'Redigite su nuevo password');


}
</script>
</body>
</html>	

