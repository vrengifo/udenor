<?php
//clase para moneda
/**
 * Clase usada para administrar las monedas con las que trabaja el sistema haciendo como base de cálculo el dolar
 *
 */
class c_moneda
{
  var $mon_codigo;
  var $mon_nombre;
  var $mon2dolar;
  
  var $con;//conexión a base de datos
  
  var $msg;

  //constructor
  function c_moneda($conBd)
  {
	  $this->mon_codigo="";
	  $this->mon_nombre="";
	  $this->mon2dolar=1;	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=3;
	if($ncampos==count($dato))
	{
      $this->mon_codigo=$dato[0];
	  $this->mon_nombre=$dato[1];
	  $this->mon2dolar=$dato[2];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_moneda <br>";
  	echo "mon_codigo: ".$this->mon_codigo."<br>";
	echo "mon_nombre: ".$this->mon_nombre."<br>";	
	echo "mon2dolar: ".$this->mon2dolar."<br>";
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(mon_codigo) cuantos from moneda where mon_codigo='$this->mon_codigo' ";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }    
  
  //funciones con base de datos
  function add()
  {
    $insertado=$this->validar();//busca q no existe el código
    $existeNombre=$this->buscarxNombre($this->mon_nombre);
	if((!$insertado)&&(!$existeNombre))
	{
	  $sql="insert into moneda"
			." (mon_codigo,mon_nombre,mon2dolar)"
			." values ("
			."'$this->mon_codigo','$this->mon_nombre','$this->mon2dolar')";
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
	  if($insertado)
	    $this->msg="Código ya existe";
	  else 
	  {
	  	if($existeNombre)
	  	  $this->msg="Nombre ya existe";
	  }  
	}	  
	  //echo "<br>$sql <br>";
	  //$this->mostrar_dato();	
	return  ($this->mon_codigo);		
  }
  
  function del($id)
  {
 	if($id!=$this->dolar())
 	{
  	  $sql="delete from moneda "
			."where mon_codigo='$id' ";
	  //echo "<hr>$sql<hr>";		
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	    return $id;
	  else
	    return 0;
 	}
 	else
 	  return (0);
  }
  
  function buscarxNombre($nombre)
  {
  	$sql="select mon_codigo from moneda "
		."where mon_nombre='$nombre' ";
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
	$existeNombre=$this->buscarxNombre($this->mon_nombre);
	$oaux=new c_moneda($this->con);
	$existe=$oaux->info($id);
	
	if($existe)
	{	
  	  $sql="UPDATE moneda"
	  	  ." set mon2dolar='$this->mon2dolar' ";
	  if(!$existeNombre)
	    $sql.=",mon_nombre='$this->mon_nombre' ";
	  else
	  {
	  	if($existe!=$existeNombre)
	  	  $this->msg="Nombre ya existe";
	  }	  
	  $sql.=" WHERE mon_codigo='$id'";
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
	  $this->msg="Dato no existe y no se va a actualizar";
	}
	return ($res);    	
  }    

  function recuperar_dato($id)
  {
    $sql="select mon_codigo,mon_nombre,mon2dolar from moneda  "
		."where mon_codigo='$id'";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->mon_codigo=$rs->fields[0];
	  $this->mon_nombre=$rs->fields[1];
	  $this->mon2dolar=$rs->fields[2];
	  $res=$id;
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
  
  function dolar()
  {
  	return ("$");
  } 
}
?>
