<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion);

		$vf_act=date("Y-m-d");
		///todo  el html como se quiera
?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {

}
</script>

	
	<form action="aauditoria3.php" method="post" name="form1">
	<?php
		$principal="aauditoria3.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;		
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">		
	<table border="0">
	<!--
	<tr>
	  <td colspan="3">Proyectos por Fecha de Ingreso</td>
	</tr>
	-->
	<tr>
	  <td>	
	    <table>
	      <tr>	    
            <td>Usuario: </td>
		     <td>
		       <input type="text" name="usuario" value="<?=$usuario?>" >
			 </td>
	      </tr>
	      <tr>	    
            <td>Desde: </td>
		     <td>
			 <?
			   $auxdesde=date("Y")."-01-01";
			 ?> 
		     <input type="text" name="fdesde" value="<?php if(!isset($fdesde)) echo"$auxdesde"; else echo "$fdesde"; ?>" >
              <a href="javascript:show_calendar('form1.fdesde');" 
					  onmouseover="window.status='Date Picker';return true;" 
					   onmouseout="window.status='';return true;"> <img src="images/360/big_calendar.gif" width=24 height=24 border=0> 
              </a>
			 </td>
	      </tr>
	      <tr>	    
            <td>Hasta: </td>
		     <td>
		     <?
		       $auxhasta=date("Y-m-d");
		     ?>
			  <input type="text" name="fhasta" value="<?php if(!isset($fhasta)) echo"$auxhasta"; else echo "$fhasta"; ?>" >
              <a href="javascript:show_calendar('form1.fhasta');" 
					  onmouseover="window.status='Date Picker';return true;" 
					   onmouseout="window.status='';return true;"> <img src="images/360/big_calendar.gif" width=24 height=24 border=0> 
              </a>
			 </td>
	      </tr>
	      	  	  	
	    </table>
	    </td>
	    <td align="center">
	    <p>
          <input type="submit" name="procesar" value="Procesar">
        </p>
        <!--
        <p>
          <input type="button" name="cerrar" value="Cerrar" onClick="window.close();">
        </p>
        -->
        <p>
          <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
        </p>
        </td>
	  </tr>
	  
	</table>

	<br>

<?php	        
      if(isset($procesar))
	  {  
		//buscar x provincia,canton y parroquia
		if(strlen($fdesde)==0)
		  $fdesde=$auxdesde;
		if(strlen($fhasta)==0)
		  $fhasta=$auxhasta;
		    
	  	$sql="select p.usu_audit,p.usu_faudit,p.datpro_codigo,p.datpro_id "
			."from priorizacion_proyecto p "
			."where date_format(p.usu_faudit,'%Y-%m-%d')>='$fdesde' and date_format(p.usu_faudit,'%Y-%m-%d')<='$fhasta' ";
		if(strlen($usuario)>0)
		  $sql.="and p.usu_audit like '$usuario%' ";	
		$sql.="order by p.usu_audit";
		  
		$rs=&$conn->Execute($sql);
						
	echo "<br>";
?>

<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
  <TR>
    <TD>
	  <table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
		<tr>
		  <td nowrap>
		    <SPAN class="title" STYLE="cursor:default;">
			  <img src="images/360/yearview.gif" border=0 align=absmiddle HSPACE=2>
			  <font color="#FFFFFF">Priorización de Proyectos &nbsp;(Desde: <?=$fdesde?> Hasta: <?=$fhasta?>)</font>
			</SPAN>
		  </td>
		</tr>
	  </table>
	  <table WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
	    <TR>
		  <TD>
		    <TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
		      <TR BGCOLOR="#CCCCCC">                   
                  <td nowrap class='table_hd'>Usuario</td>
                  <td nowrap class='table_hd'>Fecha - Hora</td>
                  <td nowrap class='table_hd'>Código</td>
                  <td nowrap class='table_hd'>Ver Proyecto</td>
                </tr>
                <?php
        
        while(!$rs->EOF)
		{
		    $vuser=$rs->fields[0];
		    $vfecha=$rs->fields[1];
		    $vcodpro=$rs->fields[2];
		    $vId=$rs->fields[3];
?>
                
                <TR valign=top bgcolor='#ffffff'>                   
                  <TD valign=top nowrap align=left> 
                    <?=$vuser?>
                  </TD>
                  <TD valign=top nowrap align=left> 
                    <?=$vfecha?>
                  </TD>
                  <TD valign=top nowrap align=left> 
                    <?=$vcodpro?>
                  </TD>
                  <TD valign=top nowrap align=left> 
                    <?
                      //Ver proyecto
                      $parurl="idp=".$vId;
                    ?>
                    
                    <a href="#" onclick="fOpenWindow('verproyecto.php?<?=$parurl?>','Ver','450','550')">Ver Proyecto</a>
                  </TD>
                </TR>
                
                <?php
			$rs->MoveNext();
		}// fin del while 
?>
              </TABLE>
		</TABLE>  
	  </TABLE>
<?php
					
	  }//fin del isset procesar
?>
		<input type="hidden" name="cextra" value="<?=$cextra?>">
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
