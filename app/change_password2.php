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
		include("class/c_user.php");
		$cemp=new c_user($conn);
		$cemp->recuperar_dato($username);
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
	<?php
	  if($res==1)
	  {
	    $msg="La clave fue cambiada satisfactoriamente!!!";
	  }
	  else
	  {
	    $msg="La clave no fue cambiada!!! <br>Posible error: Claves diferentes!!!";
	  }
	?>
	<tr>
		<td nowrap><SPAN class="title" STYLE="cursor:default;">
			<img src="images/360/personwrite.gif" border=0 align=absmiddle HSPACE=2><font color="#FFFFFF">
			<?=$msg?></font></SPAN>
		</td>
	</TR>
	</TABLE>
	<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside"><TR><TD><TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
                <TR BGCOLOR="#CCCCCC"> 
                  <td width="22%" nowrap class='table_hd'>Usuario:</td>
                  <td width="78%" nowrap class='table_hd'> 
                    <?=$cemp->usu_nombre?>
                  </td>
                </tr>
              </TABLE>
</TABLE>
</TABLE>


  <input type="button" name="Cancel" value="OK" onClick="window.close();">
		<br>			
	</form>	
	
	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {

}
</script>
</body>
</html>	
<?php

?>