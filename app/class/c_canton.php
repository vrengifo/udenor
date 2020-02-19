<?php
//clase para canton
/**
 * Clase usada para administrar cantones
 *
 */
class c_canton
{
  var $can_codigo;
  var $can_nombre;
  var $can_foto;
  
  var $pro_codigo;
  
  var $con;//conexión a base de datos
  
  var $msg;

  //constructor
  function c_canton($conBd)
  {
	  $this->can_codigo=0;
	  $this->can_nombre="";
	  $this->can_foto="";

	  $this->pro_codigo=0;
	    
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=3;
	if($ncampos==count($dato))
	{
      $this->pro_codigo=$dato[0];
	  $this->can_nombre=$dato[1];
	  $this->can_foto=$dato[2];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_canton <br>";
  	echo "can_codigo: ".$this->can_codigo."<br>";
  	echo "pro_codigo: ".$this->pro_codigo."<br>";
	echo "can_nombre: ".$this->can_nombre."<br>";
	echo "can_foto: ".$this->can_foto."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(can_codigo) cuantos "
  		."from canton "
  		."where can_nombre='$this->can_nombre' and pro_codigo=$this->pro_codigo ";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre,$pro)
  {
  	$sql="select can_codigo from canton where can_nombre='$nombre' and pro_codigo=$pro ";
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
	  $sql="insert into canton"
			." (pro_codigo,can_nombre,can_foto)"
			." values ("
			."$this->pro_codigo,'$this->can_nombre','$this->can_foto')";
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
	$res=$this->buscar($this->can_nombre,$this->pro_codigo);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from canton "
			."where can_codigo=$id ";
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
  	//buscar si existe el nuevo nombre
	$aux=new c_canton($this->con);
	$existe=$aux->info($id);
	
	$existeNombre=$this->buscar($this->can_nombre,$this->pro_codigo);
	
	if($existe)
	{	
  	  $sql="UPDATE canton"
		." set can_foto='$this->can_foto' ";
	  if(!$existeNombre)
	    $sql.=",can_nombre='$this->can_nombre' ";
	  else
	  {
	    if($existe!=$existeNombre)
	  	  $this->msg="Nombre ya existe";  
	  }
	  $sql.=" WHERE can_codigo=$id";
	  $rs = &$this->con->Execute($sql);
	  if(!$rs)
	  {
	  	$this->msg="Error al actualizar datos";
	  }
	  $res=$id;
	}
	else
	{ 
	  $this->msg="Dato no existe y no se va a actualizar";
	  $res=$id;
	} 
	return ($res);    	
  }

  function info($id)
  {
    $sql="select can_codigo,can_nombre,can_foto,pro_codigo "
     	."from canton  "
		."where can_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->can_codigo=$rs->fields[0];
	  $this->can_nombre=$rs->fields[1];
	  $this->can_foto=$rs->fields[2];
	  $this->pro_codigo=$rs->fields[3];
	  $res=$id;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>