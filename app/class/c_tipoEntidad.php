<?php
//clase para tipo_entidad
/**
 * Clase usada para administrar los tipos de entidades
 *
 */
class c_tipoEntidad
{
  var $tipent_codigo;
  var $tipent_nombre;
  var $tipent_orden;
  
  var $con;//conexión a base de datos
  
  var $msg;

  //constructor
  function c_tipoEntidad($conBd)
  {
	  $this->tipent_codigo="";
	  $this->tipent_nombre="";
	  $this->tipent_orden=1;	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=3;
	if($ncampos==count($dato))
	{
      $this->tipent_codigo=$dato[0];
	  $this->tipent_nombre=$dato[1];
	  $this->tipent_orden=$dato[2];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_tipoEntidad <br>";
  	echo "tipent_codigo: ".$this->tipent_codigo."<br>";
	echo "tipent_nombre: ".$this->tipent_nombre."<br>";	
	echo "tipent_orden: ".$this->tipent_orden."<br>";
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(tipent_codigo) cuantos from tipo_entidad where tipent_codigo='$this->tipent_codigo'";
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
	  $sql="insert into tipo_entidad"
			." (tipent_codigo,tipent_nombre,tipent_orden)"
			." values ("
			."'$this->tipent_codigo','$this->tipent_nombre','$this->tipent_orden')";
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
	return  ($this->tipent_codigo);		
  }
  
  function del($id)
  {
 	$sql="delete from tipo_entidad "
			."where tipent_codigo='$id' ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function buscarxNombre($nombre)
  {
  	$sql="select tipent_codigo from tipo_entidad "
		."where tipent_nombre='$nombre' ";
	$rs=&$this->con->Execute($sql);
	if($rs->EOF)
	  $res=0;
	else
	  $res=$rs->fields[0];
	return($res);    
  }
  
  function update($id)
  {
	$this->msg="";
  	//buscar si existe el nuevo nombre
	$existeNombre=$this->buscarxNombre($this->tipent_nombre);
	$oaux=new c_tipoEntidad($this->con);
	$existe=$oaux->info($id);
	if($existe)
	{	
  	  $sql="UPDATE tipo_entidad"
	  	  ." set tipent_orden='$this->tipent_orden' ";
	  if(!$existeNombre)
	    $sql.=",tipent_nombre='$this->tipent_nombre' ";
	  else
	  {
	    if($existeNombre!=$id)
	  	  $this->msg="Nombre ya existe";  
	  }  
	  $sql.=" WHERE tipent_codigo='$id'";
	  $rs = &$this->con->Execute($sql);
	  if(!$rs)
	  {
	  	$this->msg="Error al actualizar datos";
	  }	  
	  $res=1;
	}
	else 
	{
	  $res=1;
	  $this->msg="Dato no existe y no se van a actualizar datos";
	}
	return ($res);    	
  }    

  function recuperar_dato($id)
  {
    $sql="select tipent_codigo,tipent_nombre,tipent_orden from tipo_entidad  "
		."where tipent_codigo='$id'";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->tipent_codigo=$rs->fields[0];
	  $this->tipent_nombre=$rs->fields[1];
	  $this->tipent_orden=$rs->fields[2];
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
