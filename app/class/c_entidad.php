<?php
//clase para entidad
/**
 * Clase usada para administrar las entidades
 *
 */
class c_entidad
{
  var $ent_codigo;
  var $ent_nombre;
  
  var $con;//conexión a base de datos
  var $msg;

  //constructor
  function c_entidad($conBd)
  {
	  $this->ent_codigo=0;
	  $this->ent_nombre="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=1;
	if($ncampos==count($dato))
	{
      //$this->ent_codigo=$dato[0];
	  $this->ent_nombre=$dato[0];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_entidad <br>";
  	echo "ent_codigo: ".$this->ent_codigo."<br>";
	echo "ent_nombre: ".$this->ent_nombre."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(ent_codigo) cuantos from entidad where ent_nombre='$this->ent_nombre'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre)
  {
  	$sql="select ent_codigo from entidad where ent_nombre='$nombre' ";
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
  /**
   * Añadir una nueva entidad
   *
   * @return unknown
   */
  function add()
  {
    $insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into entidad"
			." (ent_nombre)"
			." values ("
			."'$this->ent_nombre')";
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
	$res=$this->buscar($this->ent_nombre);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from entidad "
			."where ent_codigo=$id ";
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
	$existe=$this->buscar($this->ent_nombre);
	if(!$existe)
	{	
  	  $sql="UPDATE entidad"
			." set ent_nombre='$this->ent_nombre' "
			." WHERE ent_codigo=$id";
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
    $sql="select ent_codigo,ent_nombre from entidad  "
		."where ent_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->ent_codigo=$rs->fields[0];
	  $this->ent_nombre=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>