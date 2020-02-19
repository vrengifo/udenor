<?php
//clase para opcion
/**
 * Clase usada para administrar opciones
 *
 */
class c_opcion
{
  var $opc_id;
  var $opc_nombre;
  var $opc_puntaje;
  var $opc_regla;
  
  var $ite_id;
  
  var $con;//conexión a base de datos
  
  var $msg;

  //constructor
  function c_opcion($conBd)
  {
	  $this->opc_id=0;
	  $this->opc_nombre="";
	  $this->opc_puntaje="";
	  $this->opc_regla="";

	  $this->ite_id=0;
	    
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=4;
	if($ncampos==count($dato))
	{
      $this->ite_id=$dato[0];
	  $this->opc_nombre=$dato[1];
	  $this->opc_regla=$dato[2];
	  $this->opc_puntaje=$dato[3];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_opcion <br>";
  	echo "opc_id: ".$this->opc_id."<br>";
  	echo "ite_id: ".$this->ite_id."<br>";
	echo "opc_nombre: ".$this->opc_nombre."<br>";
	echo "opc_puntaje: ".$this->opc_puntaje."<br>";	
	echo "opc_regla: ".$this->opc_regla."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select opc_id cuantos "
  		."from opcion "
  		."where ite_id=$this->ite_id and opc_regla='$this->opc_regla' ";
	$rs = &$this->con->Execute($sql);
	if($rs->EOF)
	{
	  $res=0;	
	}
	else
	{
	  $res=$rs->fields[0];
	}
	return($res);
  }

  function buscarNombre($nombre,$ite)
  {
  	$sql="select opc_id from opcion where opc_nombre='$nombre' and ite_id=$ite ";
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
  
  function buscarRegla($regla,$ite)
  {
  	$sql="select opc_id from opcion where opc_regla='$regla' and ite_id=$ite ";
  	$rs=&$this->con->Execute($sql);
  	if($rs->EOF)
  	{
  	  $res=0;
  	}
  	else
  	{
  	  $res=$rs->fields[0];	
  	}
  	return($res);
  } 
  
  //funciones con base de datos
  function add()
  {
    $insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into opcion"
			." (ite_id,opc_nombre,opc_puntaje,opc_regla)"
			." values ("
			."$this->ite_id,'$this->opc_nombre','$this->opc_puntaje','$this->opc_regla')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	$this->msg="";
	  	$res=$this->validar();
	  }
	  else
	  {
	  	$this->msg="Error al crear dato";
	  	$res=0;
	  }
	}
	else
	{
	  $this->msg="Dato ya existe";
	  $res=$insertado;
	} 
	return($res);		
  }
  
  function del($id)
  {
 	$sql="delete from opcion "
		."where opc_id=$id ";
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
	$aux=new c_opcion($this->con);
	$existe=$aux->info($id);
	
	$existeNombre=$this->buscarNombre($this->opc_nombre,$this->ite_id);
	$existeRegla=$this->buscarRegla($this->opc_regla,$this->ite_id);
	
	if($existe)
	{	
  	  $sql="UPDATE opcion"
		." set opc_puntaje='$this->opc_puntaje' ";
	  if(!$existeNombre)
	    $sql.=",opc_nombre='$this->opc_nombre' ";
	  else
	  {
	    if($existe!=$existeNombre)
	  	  $this->msg="Nombre ya existe";  
	  }
	  if(!$existeRegla)
	    $sql.=",opc_regla='$this->opc_regla' ";
	  else
	  {
	    if($existe!=$existeRegla)
	  	  $this->msg="Regla ya existe";  
	  }
	  $sql.=" WHERE opc_id=$id";
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
	return($res);    	
  }

  function info($id)
  {
    $sql="select opc_id,opc_nombre,opc_puntaje,ite_id,opc_regla "
     	."from opcion  "
		."where opc_id=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->opc_id=$rs->fields[0];
	  $this->opc_nombre=$rs->fields[1];
	  $this->opc_puntaje=$rs->fields[2];
	  $this->ite_id=$rs->fields[3];
	  $this->opc_regla=$rs->fields[4];
	  $res=$id;
	}
	else
	  $res=0;
	return ($res);
  }

}
?>