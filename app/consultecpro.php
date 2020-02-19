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
			Consultas</font></SPAN>
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
				    Por Ubicación - Proyecto
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Ubicación de los proyectos</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_indicador.php<?=$param_destino?><?=$resto?>','PorIndicador','450','550')">
				    Por Ubicación - Indicadores
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Ubicación de los indicadores cantonales</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_tcalifica.php<?=$param_destino?><?=$resto?>','PorCalificación','450','550')">
				    Por Calificación
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Calificación obtenida</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_tobjetivo.php<?=$param_destino?><?=$resto?>','PorObjetivo','450','550')">
				    Por Objetivos Udenor
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Objetivos Udenor</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_tcompo.php<?=$param_destino?><?=$resto?>','PorClasificación','450','550')">
				    Por Clasificación
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Componente, Subcomponente y Tipo</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_tmonto.php<?=$param_destino?><?=$resto?>','PorMonto','450','550')">
				    Por Monto
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Monto del proyecto</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_tambiental.php<?=$param_destino?><?=$resto?>','PorAmbiental','450','550')">
				    Por Impacto Ambiental
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Impacto Ambiental</td>
                </tr>
                <tr> 
                  <td width="33%" nowrap class='table_hd'>
				    <a href="#" onClick="fOpenWindow('cons_tbeneficiario.php<?=$param_destino?><?=$resto?>','PorBeneficiarios','450','550')">
				    Por Beneficiarios
					</a> 
                  </td>
                  <td width="67%" nowrap class='table_hd'>Consulta por Beneficiarios del Proyecto</td>
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
