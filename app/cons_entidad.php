<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		/*
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion);
		*/
		$vf_act=date("Y-m-d");
		///todo  el html como se quiera
	?>

<SCRIPT LANGUAGE="JavaScript">
function valida() {

}
</script>

	
	<br>
	<form action="cons_entidad.php" method="post" name="form1">
	<?php
		$principal="cons_entidad.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;		
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">		
	<table border="0">
	<tr>
	  <td colspan="3">Proyectos por Tipo de Entidad y Entidad</td>
	</tr>
	<tr>
	  <td>	
	    <table>
	      <tr>	    
            <td>Tipo Entidad: </td>
		    <td>			  
			  <select name="tipo">
			    <option value="0" 
			  <?php
			    if(!isset($tipo))
				{
				  echo " selected";
				}
				if($tipo=="0")
				{
				  echo " selected";
				}
			  ?>
			    >Todos(as)</option>
              <?php
		  	$sql="select tipent_codigo,tipent_nombre "
				."from tipo_entidad "
				."order by tipent_orden";
			$rs = &$conn->Execute($sql);
			while(!$rs->EOF)
			{
			  $valor=$rs->fields[0];
			  $texto=$rs->fields[1];
	         ?>
				<option value="<?=$valor?>" 
			<?php
				if($valor==$tipo)
				{  
				  echo " selected";
				}  
			?>
			> 
                        <?=$texto?>
                        </option>
                        <?php
			  $rs->MoveNext();
			}					  
	  ?>
                      </select>
			</td>
	      </tr>
	      <tr>	    
            <td>Entidad: </td>
		    <td>			  
			  <select name="entidad">
			    <option value="0" 
			  <?php
			    if(!isset($entidad))
				{
				  echo " selected";
				}
				if($entidad=="0")
				{
				  echo " selected";
				}
			  ?>
			    >Todos(as)</option>
              <?php
		  	$sql="select ent_codigo,ent_nombre "
				."from entidad "
				."order by ent_nombre";
			$rs = &$conn->Execute($sql);
			while(!$rs->EOF)
			{
			  $valor=$rs->fields[0];
			  $texto=$rs->fields[1];
	         ?>
				<option value="<?=$valor?>" 
			<?php
				if($valor==$entidad)
				{  
				  echo " selected";
				}  
			?>
			> 
                        <?=$texto?>
                        </option>
                        <?php
			  $rs->MoveNext();
			}					  
	  ?>
                      </select>
			</td>
	      </tr>
	      
	  	  <!--
	      <tr>	    
            <td>Cant�n: </td>
		    <td>			  
			  <select name="canton" onChange="submit();">
			    <?
			      if(!isset($provincia))
			      {
			    ?>
			    <option value="0" <?php
				  if ((!isset($canton))||($provincia=="0"))
				  {
				    echo " selected";
				    $can_selected="0";
				  }	
				?>>Todos(as)</option>
				<?
			      }
			      else 
			      {
			    ?>
			    	<option value="0" 
			    <?php
				  	if ($canton=="0")
				  	{
				    	echo " selected";
				    	$can_selected="0";
				  	}	
				?>>Todos(as)</option>  	
			    
                <?php	
			    		$sql="select can_codigo,can_nombre "
				    		."from canton "			  	
			    			."where pro_codigo=$provincia "
							."order by pro_codigo,can_nombre";
			    		$rs = &$conn->Execute($sql);
			    		while(!$rs->EOF)
			   			{
			      			$valor=$rs->fields[0];
			      			$texto=$rs->fields[1];
	         	?>
						<option value="<?=$valor?>" 
				<?php
							if($valor==$canton)
							{
				  				echo " selected";
				  				$can_selected=$valor;
							}
				?>
						><?=$texto?></option>
                <?php
			    			$rs->MoveNext();
			  			}
			      }
	  			?>
                      </select>
			</td>
	      </tr>
	      -->
	  	  <!--		
	      <tr>	    
            <td>Parroquia: </td>
		    <td>			  
			  <select name="parroquia">
			   <?
			     if((!isset($canton))||(!isset($provincia))||($canton=="0"))
			     {
			   ?> 
			      <option value="0" <?php
				  if ($parroquia=="0")
				  {
				    echo " selected";
				  }	
				?>>Todos(as)</option>
			  <?
			     }
			     else 
			     {
			  ?>
			    <option value="0" <?php
				  if ($parroquia=="0")
				  {
				    echo " selected";
				  }	
				?>>Todos(as)</option>
			  <?   	
			  ?>	
              <?php	
			    	$sql="select par_codigo,par_nombre "
				    ."from parroquia "			  	
			    	." where can_codigo=$canton "
					."order by can_codigo,par_nombre";
			    	$rs = &$conn->Execute($sql);
			    	while(!$rs->EOF)
			   		{
			      		$valor=$rs->fields[0];
			      		$texto=$rs->fields[1];
	         ?>
					<option value="<?=$valor?>" 
			<?php
				if($valor==$parroquia)
				  echo " selected";
			?>
					><?=$texto?></option>
            <?php
			    		$rs->MoveNext();
			  		}
				}					  
	  ?>
                      </select>
			</td>
	      </tr>
	      -->
	      <!--
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
	      -->	  	  	
	    </table>
	    </td>
	    <td align="center">
	    <p>
          <input type="submit" name="procesar" value="Procesar">
        </p>
        <p>
          <input type="button" name="cerrar" value="Cerrar" onClick="window.close();">
        </p>
        <p>
          <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
        </p>
        </td>
	  </tr>
	  
	</table>

	<br><br>	

<?php	        
      if(isset($procesar))
	  {  
	  	
	  	$sql="select distinct dp.datpro_id,te.tipent_nombre,e.ent_nombre "
			."from dato_proyecto dp,tipo_entidad te,entidad e,dp_entidades dpe "
			."where te.tipent_codigo=dpe.tipent_codigo and e.ent_codigo=dpe.ent_codigo and dp.datpro_id=dpe.datpro_id ";
		if($tipo!="0")
		  $sql.="and dpe.tipent_codigo='$tipo' ";
		if($entidad!="0")
		  $sql.="and dpe.ent_codigo='$entidad' ";
		$sql.="order by dp.datpro_codigo ";  
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
			  <font color="#FFFFFF">Proyecto por Tipo Entidad y Entidad&nbsp;</font>
			</SPAN>
		  </td>
		</tr>
	  </table>
	  <table WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
	    <TR>
		  <TD>
		    <TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
		      <TR BGCOLOR="#CCCCCC">                   
		          <td nowrap class='table_hd'>Tipo Entidad</td>
                  <td nowrap class='table_hd'>Entidad</td>
                  <!--
                  <td nowrap class='table_hd'>Parroquia</td>
                  -->
                  <td nowrap class='table_hd'>Componente</td>
                  <td nowrap class='table_hd'>C�digo</td>
                  <td nowrap class='table_hd'>Nombre</td>
                  <td nowrap class='table_hd'>Estado Tr�mite</td>
                  <td nowrap class='table_hd'>Estado Desarrollo</td>
                  <td nowrap class='table_hd'>Monto</td>
                  <td nowrap class='table_hd'>Fecha Ingreso</td>
                  <td nowrap class='table_hd'>Ver Proyecto</td>
                </tr>
                <?php
		include_once("class/c_datoProyecto.php");
		$obj=new c_datoProyecto($conn,$session_username);
		
		include_once("class/c_ingresoProyecto.php");
		$oipro=new c_ingresoProyecto($conn,$session_username);
		
		include_once("class/c_componente.php");
        $ccom=new c_componente($conn);
        
        include_once("class/c_estadoProyecto.php");
        $cestpro=new c_estadoProyecto($conn);
        
        //include_once("class/c_dpdatoTecnico.php");
        $cdattec=new c_dpDatoTecnico($conn);
        
        /*
        include_once("class/c_provincia.php");
        $cprov=new c_provincia($conn);
        
        include_once("class/c_parroquia.php");
        $cparr=new c_parroquia($conn);
        
        include_once("class/c_canton.php");
        $ccan=new c_canton($conn);
        
        include_once("class/c_dpUbicacion.php");
        $cdpubi=new c_dpUbicacion($conn);
        */
        
        while(!$rs->EOF)
		{
		    $vdatpro=$rs->fields[0];
		    $vtipo=$rs->fields[1];
		    $ventidad=$rs->fields[2];
		    
		    $obj->info($vdatpro);
		    
		    
		    
?>
                
                <TR valign=top bgcolor='#ffffff'>                   
                
                  <TD valign=top nowrap> 
                    <?=$vtipo?>
                  </TD>
                  <TD valign=top nowrap> 
                    <?=$ventidad?>
                  </TD>
				<!--
                  <TD valign=top nowrap align=right> 
                    <?=$vpar?>
                  </TD>
                -->  
                  <TD valign=top nowrap align=left> 
                    <?
                      
                      $ccom->info($obj->com_codigo);
                      
                      echo ($ccom->com_descripcion);
                    ?>
                  </TD>
                  <TD valign=top nowrap align=left> 
                    <?=$obj->datpro_codigo?>
                  </TD>
                  <TD valign=top nowrap align=left> 
                    <?=$obj->datpro_nombre?>
                  </TD>
                  <TD valign=top nowrap align=left> 
                    <?
                      //estado proyecto
                      $cestpro->info($obj->est_codigo);
                      echo ($cestpro->est_nombre);
                    ?>
                  </TD>
                  <TD valign=top nowrap align=left> 
                    <?
                      $dattecId=$cdattec->buscarxdatpro($obj->datpro_id);
                      if($dattecId!=0)
                      {
                        $cdattec->info($dattecId);
                      	$sqlestdes="select estdes_nombre from estado_desarrollo where estdes_codigo=".$cdattec->estdes_codigo." ";
                        $rsestdes=&$conn->Execute($sqlestdes);
                        echo ($rsestdes->fields[0]);
                      }  
                    ?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?
                      //monto
                      echo($cdattec->dattec_monto);
                    ?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?
                      //fecha ingreso
                      $oipro->info($obj->ingpro_codigo);
                      echo($oipro->ingpro_fecha);
                    ?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?
                      //Ver proyecto
                      $parurl="idp=".$obj->datpro_id;
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
