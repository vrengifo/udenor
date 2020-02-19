<?php
//clase para beneficio_ambiental
/**
 * Clase usada para administrar los beneficios ambientales que se usaran para registrar los valores requeridos en la priorización
 *
 */
class c_beneficioAmbiental
{
  var $benamb_id;
  var $benamb_descripcion;
  
  var $con;//conexión a base de datos
  var $msg;

  //constructor
  function c_beneficioAmbiental($conBd)
  {
	  $this->benamb_id=0;
	  $this->benamb_descripcion="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=1;
	if($ncampos==count($dato))
	{
      //$this->benamb_id=$dato[0];
	  $this->benamb_descripcion=$dato[0];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_beneficioAmbiental <br>";
  	echo "benamb_id: ".$this->benamb_id."<br>";
	echo "benamb_descripcion: ".$this->benamb_descripcion."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(benamb_id) cuantos from beneficio_ambiental where benamb_descripcion='$this->benamb_descripcion'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre)
  {
  	$sql="select benamb_id from beneficio_ambiental where benamb_descripcion='$nombre' ";
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
	  $sql="insert into beneficio_ambiental"
			." (benamb_descripcion)"
			." values ("
			."'$this->benamb_descripcion')";
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
	$res=$this->buscar($this->benamb_descripcion);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from beneficio_ambiental "
			."where benamb_id=$id ";
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
	$existe=$this->buscar($this->benamb_descripcion);
	if(!$existe)
	{	
  	  $sql="UPDATE beneficio_ambiental"
			." set benamb_descripcion='$this->benamb_descripcion' "
			." WHERE benamb_id=$id";
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
	  $res=1;
	return ($res);    	
  }    

  function info($id)
  {
    $sql="select benamb_id,benamb_descripcion from beneficio_ambiental  "
		."where benamb_id=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->benamb_id=$rs->fields[0];
	  $this->benamb_descripcion=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>