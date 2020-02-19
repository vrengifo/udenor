<?php
//clase para empleado
/**
 * Clase usada para administrar los empleados
 *
 */
class c_empleado
{
  var $emp_codigo;
  var $emp_nombre;
  
  var $con;//conexión a base de datos

  //constructor
  function c_empleado($conBd)
  {
	  $this->emp_codigo=0;
	  $this->emp_nombre="";	  
      $this->con=&$conBd;
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=1;
	if($ncampos==count($dato))
	{
      //$this->emp_codigo=$dato[0];
	  $this->emp_nombre=$dato[0];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_empleado <br>";
  	echo "emp_codigo: ".$this->emp_codigo."<br>";
	echo "emp_nombre: ".$this->emp_nombre."<br>";	
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(emp_codigo) cuantos from empleado where emp_nombre='$this->emp_nombre'";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }

  function buscar($empNombre)
  {
  	$sql="select emp_codigo from empleado where emp_nombre='$empNombre' ";
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
	  $sql="insert into empleado"
			." (emp_nombre)"
			." values ("
			."'$this->emp_nombre')";
	  $rs = &$this->con->Execute($sql);
	}  
	  //echo "<br>$sql <br>";
	  //$this->mostrar_dato();	
	$res=$this->buscar($this->emp_nombre);  
	return  ($res);		
  }
  
  function del($id)
  {
 	$sql="delete from empleado "
			."where emp_codigo=$id ";
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
	$existe=$this->buscar($this->emp_nombre);
	if(!$existe)
	{	
  	  $sql="UPDATE empleado"
			." set emp_nombre='$this->emp_nombre' "
			." WHERE emp_codigo=$id";
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
    $sql="select emp_codigo,emp_nombre from empleado  "
		."where emp_codigo=$id";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->emp_codigo=$rs->fields[0];
	  $this->emp_nombre=$rs->fields[1];
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

}
?>