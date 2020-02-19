<?php
//clase para tipo_usuario
/**
 * Clase usada para administrar los tipos de usuarios del sistema
 *
 */
class c_tipousuario
{
  var $tipusu_codigo;
  var $tipusu_nombre;
  var $msg;
  
  var $con;//conexión a base de datos

  //constructor
  function c_tipousuario($conBd)
  {
	  $this->tipusu_codigo="";
	  $this->tipusu_nombre="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=2;
	if($ncampos==count($dato))
	{
      $this->tipusu_codigo=$dato[0];
	  $this->tipusu_nombre=$dato[1];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_tipousuario <br>";
  	echo "tipusu_codigo: ".$this->tipusu_codigo."<br>";
	echo "tipusu_nombre: ".$this->tipusu_nombre."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select tipusu_codigo from tipo_usuario where tipusu_codigo='$this->tipusu_codigo'";
	$rs = &$this->con->Execute($sql);	
	if($rs->EOF)
	  $cuantos=0;
	else  
	  $cuantos=$rs->fields[0];
	return ($cuantos);
  }    
  
  function buscarxNombre($nombre)
  {
  	$sql="select tipusu_codigo from tipo_usuario where tipusu_nombre='$nombre'";
	$rs = &$this->con->Execute($sql);	
	if($rs->EOF)
	  $cuantos=0;
	else  
	  $cuantos=$rs->fields[0];
	return ($cuantos);
  }
  
  //funciones con base de datos
  function add()
  {
    $insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into tipo_usuario"
			." (tipusu_codigo,tipusu_nombre)"
			." values ("
			."'$this->tipusu_codigo','$this->tipusu_nombre')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	$id=$this->tipusu_codigo;
	  	$this->msg="";
	  }
	  else
	  {
	  	$id=0;
	  	$this->msg="Error al crear dato";
	  }
	}
	else
	{
      $id=$insertado;
      $this->msg="Dato ya existe";
	} 
	return($id);		
  }
  
  function del($id)
  {
 	$sql="delete from tipo_usuario "
			."where tipusu_codigo='$id' ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$oaux=new c_tipousuario($this->con);
	$oaux1=new c_tipousuario($this->con);
	
	$existe=$oaux->info($id);
	$existeNombre=$oaux1->buscarxNombre($this->tipusu_nombre);
  	
	if($existe)
	{
	  if(!$existeNombre)
	  {
	  	$sql="UPDATE tipo_usuario"
			." set tipusu_nombre='$this->tipusu_nombre' "
			." WHERE tipusu_codigo='$id'";
	    $rs = &$this->con->Execute($sql);
	    if($rs)
	    {
	      $res=$id;
	    }
	    else
	    {
	      $res=0;
	      $this->msg="Error al actualizar dato";	
	    }
	  }
	  else
	  {
	  	$res=$id;
	  	$this->msg="Dato ya existe";
	  }
	}
	else
	{
	  $res=$id;
	  $this->msg="Dato no existe y no se va a actualizar";	
	}
	return ($res);    	
  }    

  function recuperar_dato($id)
  {
    $sql="select tipusu_codigo,tipusu_nombre from tipo_usuario  "
		."where tipusu_codigo='$id'";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->tipusu_codigo=$rs->fields[0];
	  $this->tipusu_nombre=$rs->fields[1];
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
