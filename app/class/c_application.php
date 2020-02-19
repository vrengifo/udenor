<?php
//clase para application o modules
/**
 * Clase usada para el manejo de módulos o aplicaciones 
 *
 */
class c_application
{
  var $id_aplicacion;
  var $nombre_aplicacion;
  var $file_aplicacion;
  var $imagen_aplicacion;
  var $orden_aplicacion;
  
  var $msg;
  
  var $con;

  
  //constructor
  function c_application($conBd)
  {
	  $this->id_aplicacion=0;
	  $this->nombre_aplicacion="";	  
	  $this->file_aplicacion="";
	  $this->imagen_aplicacion="";
	  $this->orden_aplicacion=0;
	  
	  $this->con=&$conBd;
  }  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=4;
	if($ncampos==count($dato))
	{
	  $this->nombre_aplicacion=$dato[0];      
      $this->file_aplicacion=$dato[1];
      $this->imagen_aplicacion=$dato[2];
      $this->orden_aplicacion=$dato[3];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_application <br>";
  	echo "id_aplicacion:".$this->id_aplicacion."<br>";
	echo "nombre_aplicacion:".$this->nombre_aplicacion."<br>";	
	echo "file_aplicacion:".$this->file_aplicacion."<br>";
	echo "imagen_aplicacion:".$this->imagen_aplicacion."<br>";
	echo "orden_aplicacion:".$this->orden_aplicacion."<br>";
	echo "<hr>";
  }  
  
  function validar()
  {
  	//$sql="select count(id_aplicacion) cuantos from aplicacion where nombre_aplicacion='$this->nombre_aplicacion'";
  	$sql="select id_aplicacion from aplicacion where nombre_aplicacion='$this->nombre_aplicacion'";
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
	  $sql="insert into aplicacion"
			." (nombre_aplicacion,file_aplicacion,imagen_aplicacion,orden_aplicacion)"
			." values ("
			."'$this->nombre_aplicacion','$this->file_aplicacion','$this->imagen_aplicacion',$this->orden_aplicacion)";
	  $rs = &$this->con->Execute($sql);
	  
	  if($rs)
	  {
	    $id_aplicacion=$this->validar();
	    $this->msg="";
	  }
	}  
	else  
	{
	  $id_aplicacion=$insertado;
	  $this->msg="Dato ya existe";
	}		
	return($id_aplicacion);		
  }
  
  function del($id)
  {
 	$sql="delete from aplicacion "
		."where id_aplicacion=$id ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {	
	$oaux=new c_application($this->con);
	$existe=$oaux->info($id);
	
	$oaux1=new c_application($this->con);
	$oaux1->nombre_aplicacion=$this->nombre_aplicacion;
	$existeNombre=$oaux1->validar();
	
	if($existe)
	{
  	  $sql="UPDATE aplicacion "
		."set "
		."file_aplicacion='$this->file_aplicacion',";
	  if(!$existeNombre)
		$sql.="nombre_aplicacion='$this->nombre_aplicacion',";
	  else 
	    $this->msg="Nombre ya existe";	
		
	  $sql.="imagen_aplicacion='$this->imagen_aplicacion',orden_aplicacion=$this->orden_aplicacion "
		."WHERE id_aplicacion=$id";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    return $id;
	  }
	  else
	  {
	    $this->msg="Error al actualizar";
	    return 0;	
	  }
	}
	else 
	{
	  $this->msg="Dato no existe y no se va a actualizar";
	  return ($id);	
	}
  }

  function info($id)
  {
  	$sql="select nombre_aplicacion,file_aplicacion,imagen_aplicacion,orden_aplicacion "
  		."from aplicacion "
  		."where id_aplicacion=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->id_aplicacion=$id;
  	  $this->nombre_aplicacion=$rs->fields[0];
  	  $this->file_aplicacion=$rs->fields[1];
  	  $this->imagen_aplicacion=$rs->fields[2];
  	  $this->orden_aplicacion=$rs->fields[3];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  } 
       
}
?>