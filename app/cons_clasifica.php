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
	<form action="cons_clasifica.php" method="post" name="form1">
	<?php
		$principal="cons_clasifica.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;		
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">		
	<table border="0">
	<tr>
	  <td colspan="3">Proyectos por Clasificación</td>
	</tr>
	<tr>
	  <td>	
	    <table>
	      <tr>	    
            <td>Componente: </td>
		    <td>			  
			  <select name="componente" onChange="submit();">
			    <option value="0" 
			  <?php
			    if(!isset($componente))
				{
				  echo " selected";
				  $com_selected="0"; 
				}
				if($componente=="0")
				{
				  echo " selected";
				  $com_selected="0";
				}
			  ?>
			    >Todos(as)</option>
              <?php
		  	$sql="select com_codigo,com_descripcion "
				."from componente "
				."order by com_codigo";
			$rs = &$conn->Execute($sql);
			while(!$rs->EOF)
			{
			  $valor=$rs->fields[0];
			  $texto=$rs->fields[1];
			  
	         ?>
				<option value="<?=$valor?>" 
			<?php
				if($valor==$componente)
				{  
				  echo " selected";
				  $com_selected=$componente;
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
            <td>Subcomponente: </td>
		    <td>			  
			  <select name="subcomponente" onChange="submit();">
			    <?
			      if(!isset($componente))
			      {
			    ?>
			    <option value="0" <?php
				  if ((!isset($subcomponente))||($componente=="0"))
				  {
				    echo " selected";
				    $sub_selected="0";
				  }	
				?>>Todos(as)</option>
				<?
			      }
			      else 
			      {
			    ?>
			    	<option value="0" 
			    <?php
				  	if ($subcomponente=="0")
				  	{
				    	echo " selected";
				    	$sub_selected="0";
				  	}	
				?>>Todos(as)</option>  	
			    
                <?php	
			    		$sql="select pro_codigo,pro_descripcion "
				    		."from proyecto "			  	
			    			."where com_codigo='$com_selected' "
							."order by pro_codigo";
			    		$rs = &$conn->Execute($sql);
			    		while(!$rs->EOF)
			   			{
			      			$valor=$rs->fields[0];
			      			$texto=$rs->fields[1];
	         	?>
						<option value="<?=$valor?>" 
				<?php
							if($valor==$subcomponente)
							{
				  				echo " selected";
				  				$sub_selected=$valor;
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
	      <tr>	    
            <td>Tipo Proyecto: </td>
		    <td>			  
			  <select name="tipo">
			   <?
			     if((!isset($subcomponente))||(!isset($componente))||($subcomponente=="0"))
			     {
			   ?> 
			      <option value="0" <?php
				  if ($tipo=="0")
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
				  if ($tipo=="0")
				  {
				    echo " selected";
				  }	
				?>>Todos(as)</option>
			  <?   	
			  ?>	
              <?php	
			    	$sql="select tip_codigo,tip_descripcion "
				    ."from tipo "			  	
			    	." where pro_codigo='$sub_selected' and com_codigo='$com_selected' "
					."order by tip_codigo";
			    	$rs = &$conn->Execute($sql);
			    	while(!$rs->EOF)
			   		{
			      		$valor=$rs->fields[0];
			      		$texto=$rs->fields[1];
	         ?>
					<option value="<?=$valor?>" 
			<?php
				if($valor==$tipo)
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
	      <!--
	      <tr>	    
            <td>Date: </td>
		     <td>
			  <input type="text" name="fecha" value="<?php if(!isset($fecha)) echo"$vf_act"; else echo "$fecha"; ?>" >
              <a href="javascript:show_calendar('form1.fecha');" 
					  onmouseover="window.status='Date Picker';return true;" 
					   onmouseout="window.status='';return true;"> <img src="images/360/big_calendar.gif" width=24 height=24 border=0> 
              </a>
			 </td>
	      </tr>
	      -->	  	  	
	    </table>
	    </td>
	    <td align="center">
	    <!--
	    <p>
          <input type="submit" name="procesar" value="Procesar">
        </p>
        -->
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
		//buscar x provincia,canton y parroquia
		
	  	$sql="select distinct dp.datpro_id "
	  		."from dato_proyecto dp ";
	  	if($componente=="0")//todas	
	  	  $sql.=" ";
	  	if(($componente!="0")&&($subcomponente=="0"))//todas	
	  	  $sql.="where dp.com_codigo='$componente' ";
	  	if(($componente!="0")&&($subcomponente!="0")&&($tipo=="0"))//todas	
	  	  $sql.="where dp.com_codigo='$componente' and dp.pro_codigo='$subcomponente' ";    
	  	if(($componente!="0")&&($subcomponente!="0")&&($tipo!="0"))//todas	
	  	  $sql.="where dp.com_codigo='$componente' and dp.pro_codigo='$subcomponente' and dp.tip_codigo='$tipo' ";
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
			  <font color="#FFFFFF">Proyecto por Clasificación&nbsp;</font>
			</SPAN>
		  </td>
		</tr>
	  </table>
	  <table WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
	    <TR>
		  <TD>
		    <TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
		      <TR BGCOLOR="#CCCCCC">                   
                  <td nowrap class='table_hd'>Componente</td>
                  <td nowrap class='table_hd'>Código</td>
                  <td nowrap class='table_hd'>Nombre</td>
                  <td nowrap class='table_hd'>Estado Trámite</td>
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
        
        while(!$rs->EOF)
		{
		    $vdatpro=$rs->fields[0];
		    
		    $obj->info($vdatpro);
?>
                
                <TR valign=top bgcolor='#ffffff'>                   
                  <TD valign=top nowrap> 
                    <?
                      
                      $ccom->info($obj->com_codigo);
                      
                      echo ($ccom->com_descripcion);
                    ?>
                  </TD>
                  <TD valign=top nowrap> 
                    <?=$obj->datpro_codigo?>
                  </TD>
                  <TD valign=top nowrap> 
                    <?=$obj->datpro_nombre?>
                  </TD>
                  <TD valign=top nowrap> 
                    <?
                      //estado proyecto
                      $cestpro->info($obj->est_codigo);
                      echo ($cestpro->est_nombre);
                    ?>
                  </TD>
                  <TD valign=top nowrap> 
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
                  <TD valign=top nowrap> 
                    <?
                      //fecha ingreso
                      $oipro->info($obj->ingpro_codigo);
                      echo($oipro->ingpro_fecha);
                    ?>
                  </TD>
                  <TD valign=top nowrap> 
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
