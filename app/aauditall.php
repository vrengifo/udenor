<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php
  extract($_REQUEST);		
  require_once('includes/header.php');
  $username=$session_username;
		
  buildmenu($username);
  buildsubmenu($id_aplicacion,$id_subaplicacion);
  
  include_once("class/c_user.php");
  $ouser=new c_user($conn);
  $ouser->info($session_username);
?>
	<form action="aauditall.php" method="post" name="form1">
	<?php
		$principal="aauditall.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">	
	<!--<a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>-->
	
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
            <td>Opción: </td>
		     <td>
		       <select name="opcion">
		         <option value="1" <?php
		           if((isset($opcion))&&($opcion=="1"))
		             echo "selected";
		         ?>>Carpetas de Proyectos Ingresadas</option>
		         <option value="2" <?php
		           if((isset($opcion))&&($opcion=="2"))
		             echo "selected";
		         ?>>Ingreso de Proyectos</option>
		         <option value="3" <?php
		           if((isset($opcion))&&($opcion=="3"))
		             echo "selected";
		         ?>>Proyectos Priorizados</option>
		       </select>
			 </td>
	      </tr>
	      <tr>
	      <!--
	      <tr>	    
            <td>Usuario: </td>
		     <td>
		       <input type="text" name="usuario" value="<?=$usuario?>" >
			 </td>
	      </tr>
	      -->
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
        <p>
          <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
        </p>
        </td>
	  </tr>
	  
	</table>
	
<?php	
  if(isset($procesar))
  {	
    //opciones
  	if($opcion=="1")
  	{
  	$sql="select p.ingpro_usuario,date_format(p.ingpro_fecha,'%Y-%m-%d'),"
		."p.ingpro_nrodptotecnico,p.ingpro_nrorecepcion,p.ingpro_nrodocint,"
		."e.emp_nombre,p.ingpro_nroproyectos "
		."from ingreso_proyecto p, empleado e "
		."where e.emp_codigo=p.ingpro_empentrega ";
		if(isset($usuario))	
		  $sql.="and p.ingpro_usuario like '$usuario%' ";
		if(isset($fdesde))	
		  $sql.="and date_format(p.ingpro_fecha,'%Y-%m-%d')>='$fdesde' ";
		if(isset($fhasta))	
		  $sql.="and date_format(p.ingpro_fecha,'%Y-%m-%d')<='$fhasta%' ";    
		$sql.="order by p.ingpro_fecha ";
		//echo $sql."<br>";
		$recordSet = &$conn->Execute($sql);
        if (!$recordSet||$recordSet->EOF) 
			die(texterror('No Records found.'));
		else
		{
			//u.usu_codigo u1,u.usu_codigo u2,u.usu_nombre,u.usu_codigo u3
			$mainheaders=array("Usuario","Fecha Creación","Nro. Dpto. Técnico","Nro. Recepción","Nro. Doc. Interno","Empleado Entrega","Nro. Proyectos");
			build_table($recordSet,false,$mainheaders,'Carpetas de Proyectos','images/360/yearview.gif','50%',true);
			
			$cextra="id_aplicacion|id_subaplicacion|principal";
		}
  	}//fin opcion 1
  	if($opcion=="2")
  	{
  				//buscar x provincia,canton y parroquia
		if(strlen($fdesde)==0)
		  $fdesde=$auxdesde;
		if(strlen($fhasta)==0)
		  $fhasta=$auxhasta;

		/*   
	  	$sql="select i.ingpro_usuario,i.ingpro_fecha,d.datpro_codigo,d.datpro_id "
			."from ingreso_proyecto i,dato_proyecto d "
			."where i.ingpro_codigo=d.ingpro_codigo "
			."and date_format(i.ingpro_fecha,'%Y-%m-%d')>='$fdesde' and date_format(i.ingpro_fecha,'%Y-%m-%d')<='$fhasta' ";
		if(strlen($usuario)>0)
		  $sql.="and i.ingpro_usuario like '$usuario%' ";	
		$sql.="order by i.ingpro_fecha";
		*/
		$sql="select d.usu_audit,d.usu_faudit,d.datpro_codigo,d.datpro_id "
			."from dato_proyecto d "
			."where "
			."date_format(d.usu_faudit,'%Y-%m-%d')>='$fdesde' and date_format(d.usu_faudit,'%Y-%m-%d')<='$fhasta' ";
		if(strlen($usuario)>0)
		  $sql.="and d.usu_audit like '$usuario%' ";	
		$sql.="order by d.usu_faudit";  
		  
		$rs=&$conn->Execute($sql);
						
	echo "<br>";

		//echo $sql."<br>";
?>

<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
  <TR>
    <TD>
	  <table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
		<tr>
		  <td nowrap>
		    <SPAN class="title" STYLE="cursor:default;">
			  <img src="images/360/yearview.gif" border=0 align=absmiddle HSPACE=2>
			  <font color="#FFFFFF">Ingreso de Proyectos &nbsp;(Desde: <?=$fdesde?> Hasta: <?=$fhasta?>)</font>
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
  	}//fin opcion 2
  	if($opcion=="3")
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
  	}//fin opcion 3
  }	
?>
		<input type="hidden" name="cextra" value="<?=$cextra?>">
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>