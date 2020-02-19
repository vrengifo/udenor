<?php
  include('includes/main.php'); 
  include('adodb/tohtml.inc.php'); 
  include('includes/header.php');
  //Script para subir los datos del archivo de Excel que contiene datos de Provincias, Cantones y Parroquias
  
  include_once("class/c_entidad.php");
  
  $cent=new c_entidad($conn);
  
  $fd=fopen("Archivos/entidad.csv", "r");
  
  $separador=";";

  $cont=0; 
  if($fd)
  {
    while (!feof($fd)) 
    {
        $buffer = fgets($fd, 4096);
	    list($nro,$nombre)=explode($separador,$buffer);
	    $nro=trim($nro);
	    $nombre=trim($nombre);

        $cent->ent_nombre=$nombre;
	    
	    $cent->add();
        
        
        $cad="nro=".$nro.":nombre:".$nombre;
	    //salida en web
	    echo ($cont.":".$cad."<br>");
        $cont++;
    }
    fclose ($fd);
  }
  else
  {
  	echo "File don't exists.";
  }
?>