<?php
//clase para tipo_documento
/**
 * Clase usada para administrar los tipos de documentos cuando se ingresa la información de los proyectos
 *
 */
class c_tipoDocumento
{
  var $tipdoc_codigo;
  var $tipdoc_nombre;
  
  var $con;//conexión a base de datos

  //constructor
  function c_tipoDocumento($conBd)
  {
	  $this->tipdoc_codigo=0;
	  $this->tipdoc_nombre="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=1;
	if($ncampos==count($dato))
	{
      //$this->tipdoc_codigo=$dato[0];
	  $this->tipdoc_nombre=$dato[0];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_tipo_documento <br>";
  	echo "tipdoc_codigo: ".$this->tipdoc_codigo."<br>";
	echo "tipdoc_nombre: ".$this->tipdoc_nombre."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(tipdoc_codigo) cuantos from tipo_documento where tipdoc_nombre='$this->tipdoc_nombre'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre)
  {
  	$sql="select tipdoc_codigo from tipo_documento where tipdoc_nombre='$nombre' ";
  	$rs=&$this->con->Execute($sql);
  	if($rs->EOF)
  	{
  	  $res=0;	
  	}
  	else
  	{
  	  $res=$rs->fields[0];	
  	}
  	return ($res);
  } 
  
  //funciones con base de datos
  function add()
  {
    $insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into tipo_documento"
			." (tipdoc_nombre)"
			." values ("
			."'$this->tipdoc_nombre')";
	  $rs = &$this->con->Execute($sql);
	}  
	  //echo "<br>$sql <br>";
	  //$this->mostrar_dato();	
	$res=$this->buscar($this->tipdoc_nombre);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from tipo_documento "
			."where tipdoc_codigo=$id ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	//buscar si existe el nuevo nombre
	$existe=$this->buscar($this->tipdoc_nombre);
	if(!$existe)
	{	
  	  $sql="UPDATE tipo_documento"
			." set tipdoc_nombre='$this->tipdoc_nombre' "
			." WHERE tipdoc_codigo=$id";
  //	echo "<br>$sql <br>";
  //	$this->mostrar_dato();		
	  $rs = &$this->con->Execute($sql);
	  $res=1;
	}
	else 
	  $res=1;
	return ($res);    	
  }    

  function info($id)
  {
    $sql="select tipdoc_codigo,tipdoc_nombre from tipo_documento  "
		."where tipdoc_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->tipdoc_codigo=$rs->fields[0];
	  $this->tipdoc_nombre=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>