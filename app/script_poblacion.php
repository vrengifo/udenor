<?php
  include('includes/main.php'); 
  include('adodb/tohtml.inc.php'); 
  include('includes/header.php');
  //Script para subir los datos del archivo de Excel que contiene datos de Provincias, Cantones y Parroquias
  
  include_once("class/c_provincia.php");
  include_once("class/c_canton.php");
  include_once("class/c_parroquia.php");
  
  $cpro=new c_provincia($conn);
  $ccan=new c_canton($conn);
  $cpar=new c_parroquia($conn);
  
  $fd=fopen("Archivos/poblacion.csv", "r");
  
  $separador=",";
  $pathimages="images/mapas_sw/";
  $extimages=".jpg";

  $cont=0; 
  if($fd)
  {
    while (!feof($fd)) 
    {
      $buffer = fgets($fd, 4096);
      if($cont!=0)
      {
	    list($provincia,$canton,$parroquia,$pobparroquia)=explode($separador,$buffer);
	    $provincia=trim($provincia);
	    $canton=trim($canton);
	    $parroquia=trim($parroquia);
	    $pobparroquia=trim($pobparroquia);

        //programacion
        //provincia
        $idpro=$cpro->buscar($provincia);
        if(!$idpro)//no existe provincia
        {
          $cpro->pro_nombre=$provincia;
          $cpro->pro_foto=$pathimages."p".strtolower($provincia).$extimages;
          $idpro=$cpro->add();
        }
        //canton
        $idcan=$ccan->buscar($canton,$idpro);
        if(!$idcan)
        {
          $ccan->pro_codigo=$idpro;
          $ccan->can_nombre=$canton;
          $ccan->can_foto=$pathimages."c".strtolower($canton).$extimages;	
          $idcan=$ccan->add();
        }
        //parroquias
        $idpar=$cpar->buscar($parroquia,$idcan);
        if(!$idpar)
        {
          $cpar->can_codigo=$idcan;
          $cpar->par_nombre=$parroquia;
          $cpar->par_foto=$pathimages."pa".strtolower($parroquia).$extimages;	
          $cpar->par_poblacion=$pobparroquia;
          $idpar=$cpar->add();
        }
        
        
        $cad="idpro=".$idpro;
        $cad.="-idcan=".$idcan;
        $cad.="-idpar=".$idpar;
	    //salida en web
	    echo ($cont.":".$cad.":".$provincia.$separador.$canton.$separador.$parroquia.$separador.$pobparroquia."<br>");
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