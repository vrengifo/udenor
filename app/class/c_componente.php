<?php
//clase para componente
/**
 * Clase usada para administrar componentes
 *
 */
class c_componente
{
  var $com_codigo;
  var $com_descripcion;
  
  var $msg;
  
  var $con;//conexión a base de datos

  //constructor
  function c_componente($conBd)
  {
	  $this->com_codigo="";
	  $this->com_descripcion="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=2;
	if($ncampos==count($dato))
	{
      $this->com_codigo=$dato[0];
	  $this->com_descripcion=$dato[1];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_componente <br>";
  	echo "com_codigo: ".$this->com_codigo."<br>";
	echo "com_descripcion: ".$this->com_descripcion."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select com_codigo from componente where com_codigo='$this->com_codigo'";
	$rs = &$this->con->Execute($sql);	
	if($rs->EOF)
	  $cuantos=0;
	else  
	  $cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscarxNombre($nombre)
  {
  	$sql="select com_codigo from componente where com_descripcion='$nombre'";
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
    $existeNombre=$this->buscarxNombre($this->com_descripcion);	
	if((!$insertado)&&(!$existeNombre))
	{
	  $sql="insert into componente"
			." (com_codigo,com_descripcion)"
			." values ("
			."'$this->com_codigo','$this->com_descripcion')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    $this->msg="";
	    $res=$this->com_codigo;	
	  }
	  else
	  {
	  	$res=0;
	  	$this->msg="Error al crear dato";
	  }
	}
	else
	{
	  //echo("insertado: $insertado == existeNombre: $existeNombre ");
	  $res=$insertado;
	  if($insertado)
	  {
	  	$this->msg="Dato ya existe";
	  }
	  if($existeNombre)
	  {
	  	$this->msg="Nombre ya existe";
	  }  
	}
	return($res);		
  }
  
  function del($id)
  {
 	$sql="delete from componente "
			."where com_codigo='$id' ";
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
	
  	$oaux=new c_componente($this->con);
	$oaux1=new c_componente($this->con);
  	
  	$existe=$oaux->info($id);
	$existeNombre=$oaux1->buscarxNombre($this->com_descripcion);
	
	if($existe)
	{
	  if(!$existeNombre)
	  {
	  	$sql="UPDATE componente"
			." set com_descripcion='$this->com_descripcion' "
			." WHERE com_codigo='$id'";
	    $rs = &$this->con->Execute($sql);
	    if($rs)
	    {
	      $res=$id;
	    }
	    else
	    {
	      $this->msg="Error al actualizar datos";
	      $res=$id;
	    }
	  }
	  else
	  {
	  	if($existe!=$existeNombre)
	  	  $this->msg="Dato ya existe";
	    $res=$id;
	  }	
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
    $sql="select com_codigo,com_descripcion from componente  "
		."where com_codigo='$id'";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->com_codigo=$rs->fields[0];
	  $this->com_descripcion=$rs->fields[1];
	  $res=$id;
	}
	else
	  $res=0;
	return ($res);	
  }
}
?>
