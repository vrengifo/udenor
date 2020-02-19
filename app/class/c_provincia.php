<?php
//clase para provincia
/**
 * Clase usada para administrar las provincias
 *
 */
class c_provincia
{
  var $pro_codigo;
  var $pro_nombre;
  var $pro_foto;
  
  var $msg;
  
  var $con;//conexión a base de datos

  //constructor
  function c_provincia($conBd)
  {
	  $this->pro_codigo=0;
	  $this->pro_nombre="";
	  $this->pro_foto="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=2;
	if($ncampos==count($dato))
	{
      //$this->pro_codigo=$dato[0];
	  $this->pro_nombre=$dato[0];
	  $this->pro_foto=$dato[1];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_provincia <br>";
  	echo "pro_codigo: ".$this->pro_codigo."<br>";
	echo "pro_nombre: ".$this->pro_nombre."<br>";
	echo "pro_foto: ".$this->pro_foto."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(pro_codigo) cuantos from provincia where pro_nombre='$this->pro_nombre'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre)
  {
  	$sql="select pro_codigo from provincia where pro_nombre='$nombre' ";
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
	  $sql="insert into provincia"
			." (pro_nombre,pro_foto)"
			." values ("
			."'$this->pro_nombre','$this->pro_foto')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	$this->msg="";
	  }
	  else
	  {
	  	$res=0;
	  	$this->msg="Error al crear dato";
	  }
	}
	else
	{
      $this->msg="Dato ya existe";
	} 
	$res=$this->buscar($this->pro_nombre);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from provincia "
			."where pro_codigo=$id ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$this->msg="";
	
  	$aux=new c_provincia($this->con);
	$existe=$aux->info($id);
	
	$existeNombre=$this->buscar($this->pro_nombre);
  	
  	//buscar si existe el nuevo nombre
	if($existe)
	{	
  	  $sql="UPDATE provincia"
		." set pro_foto='$this->pro_foto' ";
	  if(!$existeNombre)
	    $sql.=",pro_nombre='$this->pro_nombre' ";
	  else
	  {
	  	if($existe!=$existeNombre)
	  	  $this->msg="Nombre ya existe";
	  }  
	  $sql.=" WHERE pro_codigo=$id";
	  $rs = &$this->con->Execute($sql);
	  if(!$rs)
	  {
	  	$this->msg="Error al actualizar datos";
	  }
	  $res=$id;
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
    $sql="select pro_codigo,pro_nombre,pro_foto "
     	."from provincia  "
		."where pro_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->pro_codigo=$rs->fields[0];
	  $this->pro_nombre=$rs->fields[1];
	  $this->pro_foto=$rs->fields[2];
	  $res=$id;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>