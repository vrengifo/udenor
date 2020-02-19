<?php
//clase para subapplication o submodules
/**
 * Clase usada para administrar los submódulos del sistema
 *
 */
class c_subapplication
{
  var $id_subaplicacion;
  var $id_aplicacion;
  var $nombre_subaplicacion;
  var $file_subaplicacion;
  var $imagen_subaplicacion;
  var $orden_subaplicacion;
  
  var $msg;
  
  var $con;

  
  //constructor
  function c_subapplication($conBd)
  {
	  $this->id_subaplicacion=0;
	  $this->id_aplicacion=0;
	  $this->nombre_subaplicacion="";	  
	  $this->file_subaplicacion="";
	  $this->imagen_subaplicacion="";
	  $this->orden_subaplicacion=0;
	  
	  $this->con=&$conBd;
  }  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=5;
	if($ncampos==count($dato))
	{
	  $this->id_aplicacion=$dato[0];
	  $this->nombre_subaplicacion=$dato[1];      
      $this->file_subaplicacion=$dato[2];
      $this->imagen_subaplicacion=$dato[3];
      $this->orden_subaplicacion=$dato[4];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_subapplication <br>";
  	echo "id_subaplicacion:".$this->id_subaplicacion."<br>";
	echo "id_aplicacion:".$this->id_aplicacion."<br>";	
	echo "nombre_subaplicacion:".$this->nombre_subaplicacion."<br>";	
	echo "file_subaplicacion:".$this->file_subaplicacion."<br>";
	echo "imagen_subaplicacion:".$this->imagen_subaplicacion."<br>";
	echo "<hr>";	
  }  
  
  function validar()
  {
  	$sql="select id_subaplicacion from subaplicacion where nombre_subaplicacion='$this->nombre_subaplicacion' "
		."and id_aplicacion=$this->id_aplicacion ";
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
	  $sql="insert into subaplicacion"
			." (id_aplicacion,nombre_subaplicacion,file_subaplicacion,imagen_subaplicacion,orden_subaplicacion)"
			." values ("
			."$this->id_aplicacion,'$this->nombre_subaplicacion','$this->file_subaplicacion','$this->imagen_subaplicacion',$this->orden_subaplicacion)";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	$id_subaplicacion=$this->validar();
	  	$this->msg="";
	  }
	  else
	  {
	  	$id_subaplicacion=0;
	  	$this->msg="Error al añadir datos";
	  }
	}
	else 
	{
	  $id_subaplicacion=$insertado;
	  $this->msg="Dato ya existe";
	} 
	return($id_subaplicacion);
  }
  
  function del($id)
  {
 	$sql="delete from subaplicacion "
			."where id_subaplicacion=$id ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$this->msg="";
		
  	$oaux=new c_subapplication($this->con);
	$oaux1=new c_subapplication($this->con);
	
	$existe=$oaux->info($id);
	
	$oaux1->id_aplicacion=$this->id_aplicacion;
	$oaux1->nombre_subaplicacion=$this->nombre_subaplicacion;
	$existeNombre=$oaux1->validar();
	
  	if($existe)
  	{
  	  $sql="UPDATE subaplicacion"
		." set id_aplicacion=$this->id_aplicacion,";
	  if(!$existeNombre)	
	    $sql.="nombre_subaplicacion='$this->nombre_subaplicacion',";
	  else
	    $this->msg="Nombre ya existe";
	  $sql.="file_subaplicacion='$this->file_subaplicacion',imagen_subaplicacion='$this->imagen_subaplicacion',"
		."orden_subaplicacion=$this->orden_subaplicacion "
		." WHERE id_subaplicacion=$id";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    return ($id);
	  }
	  else
	  {
	    $this->msg="Error al actualizar dato";
	  	return 0;	
	  }  
  	}
  	else
  	{
  	  $this->msg="Dato no existe y no se va a actualizar";
  	  return($id);	
  	}
  }    

  function info($id)
  {
  	$sql="select id_aplicacion,nombre_subaplicacion,file_subaplicacion,"
  		."imagen_subaplicacion,orden_subaplicacion "
  		."from subaplicacion "
  		."where id_subaplicacion=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $res=$id;
  	  $this->id_subaplicacion=$id;
  	  $this->id_aplicacion=$rs->fields[0];	
  	  $this->nombre_subaplicacion=$rs->fields[1];
  	  $this->file_subaplicacion=$rs->fields[2];
  	  $this->imagen_subaplicacion=$rs->fields[3];
  	  $this->orden_subaplicacion=$rs->fields[4];
  	}
  	else
  	  $res=0;	
  	  
  	return ($res);  
  } 
}
?>