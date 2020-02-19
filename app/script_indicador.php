<?php
  include('includes/main.php'); 
  include('adodb/tohtml.inc.php'); 
  include('includes/header.php');
  //Script para subir los datos del archivo de Excel que contiene datos de Provincias, Cantones y Parroquias
  
  include_once("class/c_provincia.php");
  include_once("class/c_canton.php");
  include_once("class/c_indicador.php");
  include_once("class/c_indicadorxcanton.php");
  
  $cpro=new c_provincia($conn);
  $ccan=new c_canton($conn);
  $cind=new c_indicador($conn);
  $cindxcan=new c_indicadorxcanton($conn);
  
  $fd=fopen("Archivos/indicador.csv", "r");
  
    
  
  $separador=",";

  $cont=0; 
  if($fd)
  {
    while (!feof($fd)) 
    {
      $buffer = fgets($fd, 4096);
      $buffer=trim($buffer);
      echo "archivo ->línea $cont <br>";
      $dato=explode($separador,$buffer);
      if($cont!=0)
      {
	    //recuperar info de provincia
      	$idpro=$cpro->buscar($dato[0]);
	    //recuperar info del canton
	    $idcan=$ccan->buscar($dato[1],$idpro);
	    if($idcan!=0)
	    {
      	  for($i=2;$i<count($dato);$i++)
	      {
      	    $cindxcan->can_codigo=$idcan;
      	    $cindxcan->ind_codigo=$ind[$i];
      	    $cindxcan->indxcan_valor=$dato[$i];
      	    
      	    $id_indxcan=$cindxcan->add();
      	    
      	    $cindxcan->mostrar_dato();
      	    
	      }
	    }
	    
      }
      else //si está en la 1ra línea
      {
      	echo $buffer."<br>";
      	//crear indicadores
      	
      	echo "Indicadores <br>";	
      	for($i=2;$i<count($dato);$i++)
      	{
      	  $cind->ind_codigo=$dato[$i];
      	  $cind->ind_descripcion=$dato[$i];
      	  $ind[$i]=$cind->add();
      	  echo $dato[$i].$separador;
      	}
      }
      $cont++;
    }
    fclose ($fd);
  }
  else
  {
  	echo "File don't exists.";
  }
?>