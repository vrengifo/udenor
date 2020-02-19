<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion);
		///todo  el html como se quiera
        $vf_act=date("Y-m-d");
	?>
	
	<br>
	<?php
		$principal="consulingpro.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;		
	?>
	
<TABLE WIDTH="50%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
  <TR><TD>
	<table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
	<tr>
		<td nowrap><SPAN class="title" STYLE="cursor:default;">
			<img src="images/360/big_myoptions.gif" border=0 align=absmiddle HSPACE=2><font color="#FFFFFF">
			Consultas - Ingreso datos Proyectos</font></SPAN>
		</td>
	</TR>
	</TABLE>
  <TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
	<TR>
 	<TD>
	<TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_ubicacion.php<?=$param_destino?><?=$resto?>','PorUbicacion','450','550')">
				    Por Ubicación
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Ubicación de los proyectos</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_fingreso.php<?=$param_destino?><?=$resto?>','Consulta','450','550')">
				    Por Fecha de Ingreso
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Fecha de Ingreso de los proyectos</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_clasifica.php<?=$param_destino?><?=$resto?>','Consulta','450','550')">
				    Por Clasificación
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Clasificación de los proyectos (Componente, Subcomponente y Tipo de Proyecto)</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_tramite.php<?=$param_destino?><?=$resto?>','Consulta','450','550')">
				    Por Estado de Trámite
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Estado de Trámite de los proyectos</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_desarrollo.php<?=$param_destino?><?=$resto?>','Consulta','450','550')">
				    Por Estado de Desarrollo
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Estado de Desarrollo de los proyectos</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_entidad.php<?=$param_destino?><?=$resto?>','Consulta','450','550')">
				    Por Tipo de Entidad y Entidad
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Tipo de Entidad (Solicitante, Financista ...) y Entidad de los proyectos</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_codigo.php<?=$param_destino?><?=$resto?>','Consulta','450','550')">
				    Por Código de Proyecto
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Código del proyecto</td>
                </tr>
              </TABLE>
	  </TABLE>
	</TABLE>
	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
<SCRIPT LANGUAGE="JavaScript">
function valida() 
{

}
</script>
</body>
</html>
