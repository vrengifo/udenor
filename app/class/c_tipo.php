<?php
//clase para tipo
/**
 * Clase usada para administrar los tipos de subcomponentes del sistema
 *
 */
class c_tipo
{
  var $tip_codigo;
  var $tip_descripcion;
  var $tip_desde;
  var $tip_hasta;
  var $tip_actual;
  
  var $pro_codigo;
  var $com_codigo;
  
  var $separador;
  
  var $con;//conexión a base de datos
  var $pro;//para objeto c_proyecto
  
  var $msg;

  //constructor
  function c_tipo($conBd)
  {
	include_once("class/c_proyecto.php");  
  	$this->pro=new c_proyecto($conBd);
  	
  	  $this->tip_codigo="";
	  $this->tip_descripcion="";	  
	  
	  $this->tip_desde=1;
	  $this->tip_hasta=9999;
	  $this->tip_actual=1;
	  
	  $this->pro_codigo="";
	  $this->com_codigo;
      $this->con=&$conBd;
      
      $this->separador=":";
  }  

  //funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $aux=new c_proyecto($this->con);
    
  	$ncampos=6;
	if($ncampos==count($dato))
	{
      $aux->cad2id($dato[0]);
      $this->com_codigo=$aux->com_codigo;
      $this->pro_codigo=$aux->pro_codigo;
      
	  $this->tip_codigo=$dato[1];
	  $this->tip_descripcion=$dato[2];
	  $this->tip_desde=$dato[3];
	  $this->tip_hasta=$dato[4];
	  $this->tip_actual=$dato[5];      
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_tipo <br>";
  	echo "com_codigo: ".$this->com_codigo."<br>";
	echo "pro_codigo: ".$this->pro_codigo."<br>";
	echo "tip_codigo: ".$this->tip_codigo."<br>";
	echo "tip_descripcion: ".$this->tip_descripcion."<br>";	
	echo "tip_desde: ".$this->tip_desde."<br>";
	echo "tip_hasta: ".$this->tip_hasta."<br>";
	echo "tip_actual: ".$this->tip_actual."<br>";
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select count(tip_codigo) cuantos from tipo "
  		."where tip_codigo='$this->tip_codigo' and pro_codigo='$this->pro_codigo' "
  		."and com_codigo='$this->com_codigo' ";
	$rs = &$this->con->Execute($sql);	
	$cuantos=$rs->fields[0];
	return ($cuantos);
  }    
  
  function cad2id($valor)
  {
  	list($this->com_codigo,$this->pro_codigo,$this->tip_codigo)=explode($this->separador,$valor);
  	return(1);
  }
  
  function id2cad($comid,$proid,$tipid)
  {
  	$cad=$comid.$this->separador.$proid.$this->separador.$tipid;
  	return($cad);
  }  
  
  //funciones con base de datos
  function add()
  {
    $insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into tipo"
			." (com_codigo,pro_codigo,tip_codigo,tip_descripcion,"
			."tip_desde,tip_hasta,tip_actual)"
			." values ("
			."'$this->com_codigo','$this->pro_codigo','$this->tip_codigo','$this->tip_descripcion',"
			."'$this->tip_desde','$this->tip_hasta','$this->tip_actual')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	$res=$this->id2cad($this->com_codigo,$this->pro_codigo,$this->tip_codigo);
	  	$this->msg="";
	  }
	  else
	  {
	  	$res=0;
	  	$this->msg="Error al crear dato";
	  }
	}
	else
	{
	  $res=0;	
	  $this->msg="Dato ya existe";
	}
	  //echo "<br>$sql <br>";
	  //$this->mostrar_dato();	
	  
	return  ($res);		
		
  }
  
  function del($id)
  {
 	$this->cad2id($id);
  	
  	$sql="delete from tipo "
		."where tip_codigo='$this->tip_codigo' and pro_codigo='$this->pro_codigo' and com_codigo='$this->com_codigo' ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$this->cad2id($id);
  	//buscar si existe el nuevo nombre
	$existe=$this->validar();
	if($existe)
	{	
  	  $sql="UPDATE tipo"
		  ." set tip_descripcion='$this->tip_descripcion',"
		  ."tip_desde='$this->tip_desde',tip_hasta='$this->tip_hasta',tip_actual='$this->tip_actual' "
		  ." WHERE tip_codigo='$this->tip_codigo' and pro_codigo='$this->pro_codigo' and com_codigo='$this->com_codigo' ";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    $res=($id);
	  }
	  else
	  {
	  	$res=$id;
	  	$this->msg="Error al actualizar datos";
	  }
	}
	else 
	{
	  $res=($id);
	  $this->msg="Dato no existe y no se va a actualizar";
	}
	return ($res);    	
  }    

  function info($id)
  {
    $this->cad2id($id);
  	$sql="select tip_codigo,tip_descripcion,pro_codigo,com_codigo,"
  		."tip_desde,tip_hasta,tip_actual "
  		." from tipo  "
		."where tip_codigo='$this->tip_codigo' and pro_codigo='$this->pro_codigo' and com_codigo='$this->com_codigo' ";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->tip_codigo=$rs->fields[0];
	  $this->tip_descripcion=$rs->fields[1];
	  $this->pro_codigo=$rs->fields[2];
	  $this->com_codigo=$rs->fields[3];
	  $this->tip_desde=$rs->fields[4];
	  $this->tip_hasta=$rs->fields[5];
	  $this->tip_actual=$rs->fields[6];
	  
	  $res=$id;
	}
	else
	  $res=0;
	return ($res);	
  }
  
  function actual($id)
  {
  	//$this->cad2id($id);
  	
  	$valor=$this->info($id);
  	if($valor==0)
  	  $res=0;
  	 else
  	  $res=$this->tip_actual; 
  	
  	return($res);
  }
  
  function proximo($id)
  {
  	$valor=$this->info($id);
  	//$actual=$this->actual($id);
  	$proximo=$this->tip_actual+1;
  	$sql="update tipo set tip_actual=$proximo "
  		."where com_codigo='$this->com_codigo' "
  		."and pro_codigo='$this->pro_codigo' "
  		."and tip_codigo='$this->tip_codigo' ";
  	$rs=&$this->con->Execute($sql);	
  	return ($proximo);
  }
  
  function actualconceros($id)
  {
  	$this->info($id);
  	$lenhasta=strlen($this->tip_hasta);
  	$conceros=$this->completarceros($this->actual($id),$lenhasta);
  	return($conceros);
  }
  
  function nuevoCodigoProyecto($id)
  {
  	$this->info($id);
  	$cad=$this->com_codigo.$this->separador.$this->pro_codigo.$this->separador.$this->tip_codigo.$this->separador.$this->tip_actual;
  	return($cad);
  }
  
  function nuevoCodigoProyectoConCeros($id)
  {
  	$this->info($id);
  	$cad=$this->com_codigo.$this->separador.$this->pro_codigo.$this->separador.$this->tip_codigo.$this->separador.$this->completarceros($this->tip_actual,strlen($this->tip_hasta));
  	return($cad);
  }
  
  function completarceros($valor,$ceros)
  {
  	$lenvalor=strlen($valor);
  	$cero="0";
  	
  	if($ceros>$lenvalor)
  	{
  	  $cad="";
  	  for($i=0;$i<($ceros-$lenvalor);$i++)
  	  {
  	  	$cad.=$cero;
  	  }
  	  $res=$cad.$valor;
  	}
  	else
  	  $res=$valor;
  	return ($res);  
  }
  
}
?>
