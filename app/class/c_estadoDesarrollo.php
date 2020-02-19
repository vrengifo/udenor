<?php
//clase para estado_desarrollo
/**
 * Clase usada para administrar los estados por los que puede pasar un proyecto cuando se ingresan sus datos
 *
 */
class c_estadoDesarrollo
{
  var $estdes_codigo;
  var $estdes_nombre;
  
  var $msg;
  
  var $con;//conexión a base de datos

  //constructor
  function c_estadoDesarrollo($conBd)
  {
	  $this->estdes_codigo=0;
	  $this->estdes_nombre="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=1;
	if($ncampos==count($dato))
	{
      //$this->estdes_codigo=$dato[0];
	  $this->estdes_nombre=$dato[0];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_estadoDesarrollo <br>";
  	echo "estdes_codigo: ".$this->estdes_codigo."<br>";
	echo "estdes_nombre: ".$this->estdes_nombre."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(estdes_codigo) cuantos from estado_desarrollo where estdes_nombre='$this->estdes_nombre'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre)
  {
  	$sql="select estdes_codigo from estado_desarrollo where estdes_nombre='$nombre' ";
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
	  $sql="insert into estado_desarrollo"
			." (estdes_nombre)"
			." values ("
			."'$this->estdes_nombre')";
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
	$res=$this->buscar($this->estdes_nombre);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from estado_desarrollo "
			."where estdes_codigo=$id ";
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
	$existe=$this->buscar($this->estdes_nombre);
	if(!$existe)
	{	
  	  $sql="UPDATE estado_desarrollo"
			." set estdes_nombre='$this->estdes_nombre' "
			." WHERE estdes_codigo=$id";
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
	  $res=$id;
	  $this->msg="Dato no existe y no se va a actualizar";
	}
	return ($res);    	
  }    

  function info($id)
  {
    $sql="select estdes_codigo,estdes_nombre from estado_desarrollo  "
		."where estdes_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->estdes_codigo=$rs->fields[0];
	  $this->estdes_nombre=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>