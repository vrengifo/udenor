<?php
//clase para estado_proyecto
/**
 * Clase usada para administrar los estados que tiene un proyecto el momento de ser ingresado al sistema
 *
 */
class c_estadoProyecto
{
  var $est_codigo;
  var $est_nombre;
  
  var $con;//conexión a base de datos

  //constructor
  function c_estadoProyecto($conBd)
  {
	  $this->est_codigo=0;
	  $this->est_nombre="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=1;
	if($ncampos==count($dato))
	{
      //$this->est_codigo=$dato[0];
	  $this->est_nombre=$dato[0];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_estadoProyecto <br>";
  	echo "est_codigo: ".$this->est_codigo."<br>";
	echo "est_nombre: ".$this->est_nombre."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(est_codigo) cuantos from estado_proyecto where est_nombre='$this->est_nombre'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($nombre)
  {
  	$sql="select est_codigo from estado_proyecto where est_nombre='$nombre' ";
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
	  $sql="insert into estado_proyecto"
			." (est_nombre)"
			." values ("
			."'$this->est_nombre')";
	  $rs = &$this->con->Execute($sql);
	}  
	  //echo "<br>$sql <br>";
	  //$this->mostrar_dato();	
	$res=$this->buscar($this->est_nombre);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from estado_proyecto "
			."where est_codigo=$id ";
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
	$existe=$this->buscar($this->est_nombre);
	if(!$existe)
	{	
  	  $sql="UPDATE estado_proyecto"
			." set est_nombre='$this->est_nombre' "
			." WHERE est_codigo=$id";
  //	echo "<br>$sql <br>";
  //	$this->mostrar_dato();		
	  $rs = &$this->con->Execute($sql);
	  $res=1;
	}
	else 
	  $res=1;
	return ($res);    	
  }    

  function info($id)
  {
    $sql="select est_codigo,est_nombre from estado_proyecto  "
		."where est_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->est_codigo=$rs->fields[0];
	  $this->est_nombre=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>