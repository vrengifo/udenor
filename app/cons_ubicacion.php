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
	<table border="1">
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
	    <td align="center"><p>
          <input type="submit" name="procesar" value="Procesar" onclick="cambiar_action(form1,'cons_ubicacion1.php');">
        </p>
        <p>
          <input type="button" name="cerrar" value="Cerrar" onClick="window.close();">
        </p></td>
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
          <img align="middle" src="<?=$imag?>" border="0">
          
        </td>
	  </tr>
	  
	</table>

	<br><br>	

<?php	        
      if(isset($procesar))
	  {  
		//buscar x provincia,canton y parroquia
		
	  	$sql="select distinct u.datpro_id,u.pro_codigo,u.can_codigo,u.par_codigo "
	  		."from dp_ubicacion u ";
	  	if($provincia=="0")//todas	
	  	  $sql.=" ";
	  	if(($provincia!="0")&&($canton=="0"))//todas	
	  	  $sql.="where u.pro_codigo=$provincia ";
	  	if(($provincia!="0")&&($canton!="0")&&($parroquia=="0"))//todas	
	  	  $sql.="where u.pro_codigo=$provincia and u.can_codigo=$canton ";    
	  	if(($provincia!="0")&&($canton!="0")&&($parroquia!="0"))//todas	
	  	  $sql.="where u.pro_codigo=$provincia and u.can_codigo=$canton and u.par_codigo=$parroquia ";
		$rs=&$conn->Execute($sql);
						
	echo "<br>";

		echo $sql."<br>";
?>

<TABLE WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="homebox">
  <TR>
    <TD>
	  <table width="100%" border=0 cellspacing=0 cellpadding=0 CLASS="titletable">
		<tr>
		  <td nowrap>
		    <SPAN class="title" STYLE="cursor:default;">
			  <img src="images/360/yearview.gif" border=0 align=absmiddle HSPACE=2>
			  <font color="#FFFFFF">Consulta Horas y Ciclos de Avión&nbsp;</font>
			</SPAN>
		  </td>
		</tr>
	  </table>
	  <table WIDTH="100%" CELLSPACING=0 CELLPADDING=0 CLASS="tableinside">
	    <TR>
		  <TD>
		    <TABLE WIDTH='100%' border=0 CELLPADDING=2 CELLSPACING=1 BGCOLOR='#CCCCCC'>
                <?php
		while(!$rs->EOF)
		{
		    $vair_id=$rs->fields[0];
		    $vair_name=$rs->fields[1];
		    $vair_sn=$rs->fields[2];
		    $vair_hour=$rs->fields[3];
		    $vair_cycles=$rs->fields[4];
		    $vair_date=$rs->fields[5];
?>
                <TR BGCOLOR="#CCCCCC">                   
                  <td nowrap class='table_hd'>Aircraft</td>
                  <td nowrap class='table_hd'>Aircraft SN</td>
                  <td nowrap class='table_hd'>Hours</td>
                  <td nowrap class='table_hd'>Cycles</td>
                  <td nowrap class='table_hd'>Date</td>
                </tr>
                <TR valign=top bgcolor='#ffffff'>                   
                  <TD valign=top nowrap> 
                    <?=$vair_name?>
                  </TD>
                  <TD valign=top nowrap> 
                    <?=$vair_sn?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?=$vair_hour?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?=$vair_cycles?>
                  </TD>
                  <TD valign=top nowrap> 
                    <?=$vair_date?>
                  </TD>
                </TR>
                <TR BGCOLOR="#CCCCCC">                   
                  <td nowrap class='table_hd'>Assembly (Desc)</td>
                  <td nowrap class='table_hd'>Assembly SN</td>
                  <td nowrap class='table_hd'>Hours</td>
                  <td nowrap class='table_hd'>Cycles</td>
                  <td nowrap class='table_hd'>Applicability</td>
                </tr>
                <?php
		$sql1="select ass.ass_id,ass.ass_description,ass.ass_sn,app.appl_code,"
			  ."ass.ass_hour_when_ins,ass.ass_cycle_when_ins,ass.ass_ac_hour_when_ins,ass.ass_ac_landing_when_ins "
			  ."from mai_ota_assembly ass,mai_ota_applicability app "
			  ."where ass.air_id=$vair_id "
			  ."and app.appl_id=ass.appl_id "
			  ."order by ass.ass_description ";		
		$rs1=&$conn->Execute($sql1);	  
		while(!$rs1->EOF)
		{
		    $vass_id=$rs1->fields[0];
		    $vass_description=$rs1->fields[1];
		    $vass_sn=$rs1->fields[2];
		    $vappl_code=$rs1->fields[3];
		    
		    $vass_hwi=$rs1->fields[4];
		    $vass_cwi=$rs1->fields[5];
		    $vac_hwi=$rs1->fields[6];
		    $vac_cwi=$rs1->fields[7];
		    
		    $horas_ass=$vair_hour-$vac_hwi+$vass_hwi;
		    $ciclos_ass=$vair_cycles-$vac_cwi+$vass_cwi;
		   
		    
?>
                <TR valign=top bgcolor='#ffffff'>                   
                  <TD valign=top nowrap> 
                    <?=$vass_description?>
                  </TD>
                  <TD valign=top nowrap> 
                    <?=$vass_sn?>
                  </TD>
                  <TD valign=top nowrap align=right> 
                    <?=$horas_ass?>
                  </TD>
                  <TD align=right valign=top nowrap>
                    <?=$ciclos_ass?>
                  </TD>
                  <TD align=right valign=top nowrap>
                    <?=$vappl_code?>
                  </TD>
                </TR>
                <?php
			$rs1->MoveNext();
		}
?>
                <TR valign=top bgcolor='#ffffff'> 
                  <TD colspan="5" align=right valign=top nowrap>&nbsp;</TD>
                </TR>
                <?php
			$rs->MoveNext();
		}// fin del while q recupera la info de los aviones
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
