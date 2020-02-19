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
	<form action="cons_indicador.php" method="post" name="form1">
	<?php
		$principal="cons_indicador.php";
		$param_destino="?id_aplicacion=".$id_aplicacion."&id_subaplicacion=".$id_subaplicacion."&principal=".$principal;		
	?>
	<input type="hidden" name="principal" value="<?=$principal?>">
	<input type="hidden" name="id_aplicacion" value="<?=$id_aplicacion?>">
	<input type="hidden" name="id_subaplicacion" value="<?=$id_subaplicacion?>">		
	<table border="1">
	<tr>
	  <td colspan="3">Proyectos por Ubicación - Indicadores</td>
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
          <input type="submit" name="procesar" value="Procesar" onclick="cambiar_action(form1,'cons_indicador1.php');">
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


		<input type="hidden" name="cextra" value="<?=$cextra?>">
	</form>	
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
