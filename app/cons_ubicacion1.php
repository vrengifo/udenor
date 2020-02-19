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
	<form action="cons_ubicacion.php" method="post" name="form1">
	<?php
		$principal="cons_ubicacion.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;		
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">		
	<table border="0">
	<tr>
	  <td colspan="3">Proyectos por Ubicación</td>
	</tr>
	<tr>
	  <td>	
	    <table>
	      <tr>	    
            <td>Provincia: </td>
		    <td>			  
			  <select name="provincia" onChange="submit();">
			    <option value="0" 
			  <?php
			    if(!isset($provincia))
				{
				  echo " selected";
				  $pro_selected="0"; 
				}
				if($provincia=="0")
				{
				  echo " selected";
				  $pro_selected="0";
				}
			  ?>
			    >Todos(as)</option>
              <?php
		  	$sql="select pro_codigo,pro_nombre,pro_foto "
				."from provincia "
				."order by pro_nombre";
			$rs = &$conn->Execute($sql);
			while(!$rs->EOF)
			{
			  $valor=$rs->fields[0];
			  $texto=$rs->fields[1];
			  $imagen=$rs->fields[2];
			  
	         ?>
				<option value="<?=$valor?>" 
			<?php
				if($valor==$provincia)
				{  
				  echo " selected";
				  $pro_selected=$provincia;
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
            <td>Cantón: </td>
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
          <input type="button" name="cerrar" value="Cerrar" onClick="window.close();">
        </p>
        <p>
          <input type="button" name="atras" value="Atrás" onClick="self.location='cons_ubicacion.php';">
        </p>
        <p>
          <a href="#" onclick="print();"><img src="images/360/print.gif" border="0" alt="Imprimir"></a>
        </p>
        </td>
        <td>
          <?
            include_once("class/c_provincia.php");
            $objprov=new c_provincia($conn);
            if((!isset($provincia))||($provincia=="0"))
            {
              $sqlpar="select par_imgecu from parametro";
              $rspar=&$conn->Execute($sqlpar);
              $imag=$rspar->fields[0];
            }
            else 
            {
              $objprov->info($provincia);
              $imag=$objprov->pro_foto;	
            }
          ?>
          <!--<img align="middle" src="<?=$imag?>" border="0">-->
          
        </td>
	  </tr>
	  
	</table>

	<br><br>	

<?php	        
      if(isset($procesar))
	  {  
		//buscar x provincia,canton y parroquia
		
	  	$sql="select distinct u.datpro_id,p.pro_nombre,c.can_nombre,par.par_nombre "
	  		."from dp_ubicacion u,provincia p,canton c,parroquia par "
	  		."where p.pro_codigo=u.pro_codigo and c.can_codigo=u.can_codigo and par.par_codigo=u.par_codigo ";
	  	if($provincia=="0")//todas	
	  	  $sql.=" ";
	  	if(($provincia!="0")&&($canton=="0"))//todas	
	  	  $sql.="and u.pro_codigo=$provincia ";
	  	if(($provincia!="0")&&($canton!="0")&&($parroquia=="0"))//todas	
	  	  $sql.="and u.pro_codigo=$provincia and u.can_codigo=$canton ";    
	  	if(($provincia!="0")&&($canton!="0")&&($parroquia!="0"))//todas	
	  	  $sql.="and u.pro_codigo=$provincia and u.can_codigo=$canton and u.par_codigo=$parroquia ";
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
			  <font color="#FFFFFF">Proyecto por Ubicación&nbsp;</font>
			</SPAN>
		  </td>
		</tr>
	  </table>
	  <table WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
	    <TR>
		  <TD>
		    <TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
		      <TR BGCOLOR="#CCCCCC">                   
                  <td nowrap class='table_hd'>Provincia</td>
                  <td nowrap class='table_hd'>Cantón</td>
                  <td nowrap class='table_hd'>Parroquia</td>
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
		    $vpro=$rs->fields[1];
		    $vcan=$rs->fields[2];
		    $vpar=$rs->fields[3];
		    
		    $obj->info($vdatpro);
		    
		    
		    
?>
                
                <TR valign=top bgcolor='#ffffff'>                   
                  <TD valign=top nowrap> 
                    <?=$vpro?>
                  </TD>
                  <TD valign=top nowrap> 
                    <?=$vcan?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?=$vpar?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?
                      
                      $ccom->info($obj->com_codigo);
                      
                      echo ($ccom->com_descripcion);
                    ?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?=$obj->datpro_codigo?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?=$obj->datpro_nombre?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?
                      //estado proyecto
                      $cestpro->info($obj->est_codigo);
                      echo ($cestpro->est_nombre);
                    ?>
                  </TD>
                  <TD valign=top nowrap align=right> 
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
