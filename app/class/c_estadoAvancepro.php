<?php
//clase para estado_avancepro
/**
 * Clase usada para administrar los estados de avance del proyecto desde el punto de vista técnico
 *
 */
class c_estadoAvancepro
{
  var $estavapro_codigo;
  var $estavapro_descripcion;
  
  var $con;//conexión a base de datos
  var $msg;

  //constructor
  function c_estadoAvancepro($conBd)
  {
	  $this->estavapro_codigo="";
	  $this->estavapro_descripcion="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=2;
	if($ncampos==count($dato))
	{
      $this->estavapro_codigo=$dato[0];
	  $this->estavapro_descripcion=$dato[1];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_estadoAvancepro <br>";
  	echo "estavapro_codigo: ".$this->estavapro_codigo."<br>";
	echo "estavapro_descripcion: ".$this->estavapro_descripcion."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(estavapro_codigo) cuantos from estado_avancepro where estavapro_codigo='$this->estavapro_codigo'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }    
  
  //funciones con base de datos
  function add()
  {
    $insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into estado_avancepro"
			." (estavapro_codigo,estavapro_descripcion)"
			." values ("
			."'$this->estavapro_codigo','$this->estavapro_descripcion')";
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
	return  ($this->estavapro_codigo);		
  }
  
  function del($id)
  {
 	$sql="delete from estado_avancepro "
			."where estavapro_codigo='$id' ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function buscarxNombre($nombre)
  {
  	$sql="select estavapro_codigo from estado_avancepro "
		."where estavapro_descripcion='$nombre' ";
	$rs=&$this->con->Execute($sql);
	if($rs->EOF)
	  $res=0;
	else  
	  $res=$rs->fields[0];
	return($res);    
  }
  
  function update($id)
  {
	//buscar si existe el nuevo nombre
	$existeNombre=$this->buscarxNombre($this->estavapro_descripcion);
	
	if(!$existeNombre)
	{	
  	  $sql="UPDATE estado_avancepro"
			." set estavapro_descripcion='$this->estavapro_descripcion' "
			." WHERE estavapro_codigo='$id'";
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
	  if($existeNombre!=$id)
	    $this->msg="Dato ya existe";
	}  
	return ($res);    	
  }    

  function recuperar_dato($id)
  {
    $sql="select estavapro_codigo,estavapro_descripcion from estado_avancepro  "
		."where estavapro_codigo='$id'";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->estavapro_codigo=$rs->fields[0];
	  $this->estavapro_descripcion=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

  function info($id)
  {
    $res=$this->recuperar_dato($id);
    return($res);
  } 
}
?>