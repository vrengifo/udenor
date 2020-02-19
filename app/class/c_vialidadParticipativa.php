<?php
//clase para vialidad_participativa
/**
 * Clase usada para administrar la vialidad participativa de los proyectos en su fase de priorización
 *
 */
class c_vialidadParticipativa
{
  var $viapar_id;
  var $viapar_descripcion;
  
  var $con;//conexión a base de datos
  var $msg;

  //constructor
  function c_vialidadParticipativa($conBd)
  {
	  $this->viapar_id=0;
	  $this->viapar_descripcion="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=1;
	if($ncampos==count($dato))
	{
      //$this->viapar_id=$dato[0];
	  $this->viapar_descripcion=$dato[0];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_vialidadParticipativa <br>";
  	echo "viapar_id: ".$this->viapar_id."<br>";
	echo "viapar_descripcion: ".$this->viapar_descripcion."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(viapar_id) cuantos from vialidad_participativa where viapar_descripcion='$this->viapar_descripcion'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre)
  {
  	$sql="select viapar_id from vialidad_participativa where viapar_descripcion='$nombre' ";
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
	  $sql="insert into vialidad_participativa"
			." (viapar_descripcion)"
			." values ("
			."'$this->viapar_descripcion')";
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
	$res=$this->buscar($this->viapar_descripcion);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from vialidad_participativa "
			."where viapar_id=$id ";
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
	$existe=$this->buscar($this->viapar_descripcion);
	if(!$existe)
	{	
  	  $sql="UPDATE vialidad_participativa"
			." set viapar_descripcion='$this->viapar_descripcion' "
			." WHERE viapar_id=$id";
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
    $sql="select viapar_id,viapar_descripcion from vialidad_participativa  "
		."where viapar_id=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->viapar_id=$rs->fields[0];
	  $this->viapar_descripcion=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>