<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		if($enventana==0)
		{		  
		  buildmenu($username);
		  buildsubmenu($id_aplicacion,$id_subaplicacion);		 
		}  
		///todo  el html como se quiera
	?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {

}
</script>
	
	<br>
	<form action="usmo_upd1.php" method="post" name="form1">
	<?php				
		//mostrar el usuario seleccionado, solo los datos
		include_once("class/c_user.php");
		$obj=new c_user($conn);
		$obj->info($id);
		
		$campo=array(
						array("etiqueta"=>"* C�digo Usuario","nombre"=>"clp0","tipo_campo"=>"text","sql"=>"","valor"=>$obj->usu_codigo),
						array("etiqueta"=>"* Nombre","nombre"=>"clp2","tipo_campo"=>"text","sql"=>"","valor"=>$obj->usu_nombre)
					);

		$campo_hidden=array(
							array("nombre"=>"id_aplicacion","valor"=>$id_aplicacion),
					  		array("nombre"=>"id_subaplicacion","valor"=>$id_subaplicacion),
							array("nombre"=>"id","valor"=>$id),
							array("nombre"=>"principal","valor"=>"usmo_upd.php")
							);
		//construye el html para los campos relacionados
		build_show($conn,'false',"M�dulos x Usuario","images/360/taskwrite.gif","50%",'true'
		,$campo,$campo_hidden,$idp);			
	?>
	<hr width="100%" align="center" size="2">
	
<input name="Apply" type="submit" id="Apply"  value="Aplicar">
<input type="button" name="back" value="Cerrar" onClick="<?php
if($enventana==1)
{
  echo "window.close();";
}
else
{
  echo "self.location='user_modu.php?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."'";
}
?>">
<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
<br>			
			
	<TABLE WIDTH="50%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
	<TR><TD>
			<table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
			<tr>
				<td nowrap><SPAN class="title" STYLE="cursor:default;">
					<img src="images/360/yearview.gif" border=0 align=absmiddle HSPACE=2><font color="#FFFFFF">
					M�dulos por Usuario <?=$id?>&nbsp;</font></SPAN>
				</td>
			</TR>
			</TABLE>
			<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
			<TR><TD>
				<TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
					<TR BGCOLOR="#CCCCCC">						
                      <td nowrap class='table_hd'>&nbsp;</td>						
                      
                    <td nowrap class='table_hd'>M�dulo</td>
					</TR>
					<?php
						$sql="select id_aplicacion,nombre_aplicacion from aplicacion order by nombre_aplicacion";
						$rs = &$conn->Execute($sql);
						$cont=0;
						while(!$rs->EOF)
						{
		  					$core_id=$rs->fields[0];
							$core_des=$rs->fields[1];
					?>
					<TR valign=top bgcolor='#ffffff'>
						<TD valign=top nowrap> <input type='checkbox' name='chc[<?=$cont?>]' value='<?=$core_id?>' 
						<?php
						  $sql_si="select id_aplicacion from usuario_aplicacion "
						  		."where usu_codigo='$id' and id_aplicacion=$core_id";
						  $rs1 = &$conn->Execute($sql_si);
						  if(!$rs1->EOF)
						    echo " checked";
						?>
						>&nbsp;</TD>
						<TD valign=top nowrap><?=$core_des?>&nbsp;</TD>						
					</TR>
					<?php
							$cont=$cont+1;
							$rs->MoveNext();
						}
					?>					
				</TABLE>
				</TD></TR>
			</TABLE>				
			<TR><TD>
				<input type='hidden' name='total' value='<?=$cont?>'>
				<input type="hidden" name="cextra" value="id_aplicacion|id_subaplicacion|principal|idp">	
				</td>
        		</tr>
				</table>      

		</table> 	
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>