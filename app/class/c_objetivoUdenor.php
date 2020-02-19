<?php
//clase para objetivo_udenor
/**
 * Clase usada para administrar los objetivos que persigue UDENOR con respecto a los proyectos
 *
 */
class c_objetivoUdenor
{
  var $objude_codigo;
  var $objude_descripcion;
  
  var $con;//conexión a base de datos
  var $msg;

  //constructor
  function c_objetivoUdenor($conBd)
  {
	  $this->objude_codigo=0;
	  $this->objude_descripcion="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=1;
	if($ncampos==count($dato))
	{
      //$this->objude_codigo=$dato[0];
	  $this->objude_descripcion=$dato[0];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_objetivoUdenor <br>";
  	echo "objude_codigo: ".$this->objude_codigo."<br>";
	echo "objude_descripcion: ".$this->objude_descripcion."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(objude_codigo) cuantos from objetivo_udenor where objude_descripcion='$this->objude_descripcion'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre)
  {
  	$sql="select objude_codigo from objetivo_udenor where objude_descripcion='$nombre' ";
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
	  $sql="insert into objetivo_udenor"
			." (objude_descripcion)"
			." values ("
			."'$this->objude_descripcion')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	$this->msg="";
	  }
	  else
	  {
	  	$this->msg="Error al crear dato";
	  }
	}
	else 
	{
	  $this->msg="Dato ya existe";
	}
	  //echo "<br>$sql <br>";
	  //$this->mostrar_dato();	
	$res=$this->buscar($this->objude_descripcion);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from objetivo_udenor "
			."where objude_codigo=$id ";
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
	$existe=$this->buscar($this->objude_descripcion);
	if(!$existe)
	{	
  	  $sql="UPDATE objetivo_udenor"
			." set objude_descripcion='$this->objude_descripcion' "
			." WHERE objude_codigo=$id";
  //	echo "<br>$sql <br>";
  //	$this->mostrar_dato();		
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	$this->msg="";
	  }
	  else
	  {
	  	$this->msg="Error al actualizar datos";
	  }
	  $res=1;
	}
	else
	{ 
	  $res=1;
	  if($existe!=$id)
	    $this->msg="Dato ya existe";
	}  
	return ($res);    	
  }    

  function info($id)
  {
    $sql="select objude_codigo,objude_descripcion from objetivo_udenor  "
		."where objude_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->objude_codigo=$rs->fields[0];
	  $this->objude_descripcion=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>