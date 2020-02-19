<?php
//clase para proyecto
/**
 * Clase usada para administrar los subcomponentes de un componente de proyectos, usado en la clasificación o segmentación de los proyectos
 *
 */
class c_proyecto
{
  var $pro_codigo;
  var $pro_descripcion;
  var $com_codigo;
  
  var $separador;
  var $msg;
  
  var $con;//conexión a base de datos

  //constructor
  function c_proyecto($conBd)
  {
	  $this->pro_codigo="";
	  $this->pro_descripcion="";	  
	  $this->com_codigo="";
      $this->con=&$conBd;
      
      $this->separador=":";
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=3;
	if($ncampos==count($dato))
	{
      $this->com_codigo=$dato[0];
	  $this->pro_codigo=$dato[1];
	  $this->pro_descripcion=$dato[2];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_proyecto <br>";
  	echo "com_codigo: ".$this->com_codigo."<br>";
	echo "pro_codigo: ".$this->pro_codigo."<br>";
	echo "pro_descripcion: ".$this->pro_descripcion."<br>";	
    echo "<hr>";
  }

  function cad2id($valor)
  {
  	list($this->com_codigo,$this->pro_codigo)=explode($this->separador,$valor);
  	return(1);
  }
  
  function id2cad($comid,$proid)
  {
  	$cad=$comid.$this->separador.$proid;
  	return($cad);
  }
  
  function validar()
  {
  	$sql="select pro_codigo from proyecto "
  		."where pro_codigo='$this->pro_codigo' and com_codigo='$this->com_codigo' ";
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
	  $sql="insert into proyecto"
			." (pro_codigo,pro_descripcion,com_codigo)"
			." values ("
			."'$this->pro_codigo','$this->pro_descripcion','$this->com_codigo')";
	  $rs = &$this->con->Execute($sql);
	  
	  if($rs)
	  {
	    $this->msg="";
	  	$res=$this->id2cad($this->com_codigo,$this->pro_codigo);	
	  }
	  else
	  {
	  	$res=0;
	  	$this->msg="Error al crear dato";
	  }
	}
	else
	{ 
	  $res=$insertado;
	  $this->msg="Dato ya existe";
	}  
	return  ($res);		
  }
  
  function del($id)
  {
 	$this->cad2id($id);
  	$sql="delete from proyecto "
			."where pro_codigo='$this->pro_codigo' and com_codigo='$this->com_codigo' ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return ($id);
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$this->msg="";
  	
  	$oaux=new c_proyecto($this->con);
	$existe=$oaux->info($id);
  	if($existe)
  	{
  	  $this->cad2id($id);
  	  //buscar si existe el nuevo nombre
	  $sql_nombre="select count(pro_codigo) from proyecto "
			."where pro_descripcion='$this->pro_descripcion' ";
	  $rs_nombre=&$this->con->Execute($sql_nombre);
	  if($rs_nombre->fields[0]==0)
	  {	
  	    $sql="UPDATE proyecto"
			." set pro_descripcion='$this->pro_descripcion' "
			." WHERE pro_codigo='$this->pro_codigo' and com_codigo='$this->com_codigo' ";
	    $rs = &$this->con->Execute($sql);
	    $res=$id;
	  }
	  else
	  {
	    $res=$id;
	    $this->msg="Dato ya existe";
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
    
  	$this->cad2id($id);
    //$this->mostrar_dato();
  	$sql="select pro_codigo,pro_descripcion,com_codigo from proyecto  "
		."where pro_codigo='$this->pro_codigo' and com_codigo='$this->com_codigo' ";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->pro_codigo=$rs->fields[0];
	  $this->pro_descripcion=$rs->fields[1];
	  $this->com_codigo=$rs->fields[2];
	  $res=$id;
	}
	else
	  $res=0;
	return ($res);	
  }
}
?>
