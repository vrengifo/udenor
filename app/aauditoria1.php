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
	<form action="aauditoria1.php" method="post" name="form1">
	<?php
		$principal="aauditoria1.php";
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
        <p>
          <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
        </p>
        </td>
	  </tr>
	  
	</table>
	
<?php	
  if(isset($procesar))
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