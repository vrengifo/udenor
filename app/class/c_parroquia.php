<?php
//clase para parroquia
/**
 * Clase usada para administrar las parroquias
 *
 */
class c_parroquia
{
  var $par_codigo;
  var $par_nombre;
  var $par_foto;
  var $par_poblacion;
  
  var $can_codigo;
  
  var $msg;
  
  var $con;//conexión a base de datos

  //constructor
  function c_parroquia($conBd)
  {
	  $this->par_codigo=0;
	  $this->par_nombre="";
	  $this->par_foto="";
	  $this->par_poblacion=0;

	  $this->can_codigo=0;
	    
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=4;
	if($ncampos==count($dato))
	{
      $this->can_codigo=$dato[0];
	  $this->par_nombre=$dato[1];
	  $this->par_foto=$dato[2];
	  $this->par_poblacion=$dato[3];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_parroquia <br>";
  	echo "par_codigo: ".$this->par_codigo."<br>";
  	echo "can_codigo: ".$this->can_codigo."<br>";
	echo "par_nombre: ".$this->par_nombre."<br>";
	echo "par_foto: ".$this->par_foto."<br>";	
	echo "par_poblacion: ".$this->par_poblacion."<br>";
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(par_codigo) cuantos "
  		."from parroquia "
  		."where par_nombre='$this->par_nombre' and can_codigo=$this->can_codigo ";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre,$pro)
  {
  	$sql="select par_codigo from parroquia where par_nombre='$nombre' and can_codigo=$pro ";
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
	  $sql="insert into parroquia"
			." (can_codigo,par_nombre,par_foto,par_poblacion)"
			." values ("
			."$this->can_codigo,'$this->par_nombre','$this->par_foto','$this->par_poblacion')";
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
	$res=$this->buscar($this->par_nombre,$this->can_codigo);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from parroquia "
			."where par_codigo=$id ";
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
	$aux=new c_parroquia($this->con);
	$existe=$aux->info($id);
	if($existe)
	{	
  	  $sql="UPDATE parroquia"
			." set par_nombre='$this->par_nombre',par_foto='$this->par_foto',par_poblacion='$this->par_poblacion' "
			." WHERE par_codigo=$id";
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
	  $sql="UPDATE parroquia"
			." set par_foto='$this->par_foto',par_poblacion='$this->par_poblacion' "
			." WHERE par_codigo=$id";
	  $rs = &$this->con->Execute($sql);
	  $res=1;
	} 
	return ($res);    	
  }    

  function info($id)
  {
    $sql="select par_codigo,par_nombre,par_foto,can_codigo,par_poblacion "
     	."from parroquia  "
		."where par_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->par_codigo=$rs->fields[0];
	  $this->par_nombre=$rs->fields[1];
	  $this->par_foto=$rs->fields[2];
	  $this->can_codigo=$rs->fields[3];
	  $this->par_poblacion=$rs->fields[4];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>