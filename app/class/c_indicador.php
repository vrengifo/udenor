<?php
//clase para indicador
/**
 * Clase usada para administrar los indicadores que maneja el sistema
 *
 */
class c_indicador
{
  var $ind_codigo;
  var $ind_descripcion;
  
  var $con;//conexión a base de datos
  var $msg;

  //constructor
  function c_indicador($conBd)
  {
	  $this->ind_codigo="";
	  $this->ind_descripcion="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=2;
	if($ncampos==count($dato))
	{
      $this->ind_codigo=$dato[0];
	  $this->ind_descripcion=$dato[1];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_indicador <br>";
  	echo "ind_codigo: ".$this->ind_codigo."<br>";
	echo "ind_descripcion: ".$this->ind_descripcion."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(ind_codigo) cuantos from indicador where ind_codigo='$this->ind_codigo'";
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
	  $sql="insert into indicador"
			." (ind_codigo,ind_descripcion)"
			." values ("
			."'$this->ind_codigo','$this->ind_descripcion')";
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
	return($this->ind_codigo);		
  }
  
  function del($id)
  {
 	$sql="delete from indicador "
			."where ind_codigo='$id' ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function buscarxNombre($nombre)
  {
  	$sql="select ind_codigo from indicador "
		."where ind_descripcion='$nombre' ";
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
	$existeNombre=$this->buscarxNombre($this->ind_descripcion);
	if(!$existeNombre)
	{	
  	  $sql="UPDATE indicador"
			." set ind_descripcion='$this->ind_descripcion' "
			." WHERE ind_codigo='$id'";
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
    $sql="select ind_codigo,ind_descripcion from indicador  "
		."where ind_codigo='$id'";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->ind_codigo=$rs->fields[0];
	  $this->ind_descripcion=$rs->fields[1];
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
