<?php
//clase para objxpri
/**
 * Clase usada para almacenar los objetivos de UDENOR que cumple un proyecto al ingresar datos en su priorización
 *
 */
include_once("class/c_priorizacionProyecto.php");
class c_objxpri
{
  var $objude_codigo;
  var $datpro_id;

  var $separador;
  
  var $con;

  
  //constructor
  function c_objxpri($conBd)
  {
  	  $this->objude_codigo=0;
	  $this->datpro_id=0;
	    
	  $this->con=&$conBd;
	  
	  $this->separador=".";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=2;
	if($ncampos==count($dato))
	{
	  $this->datpro_id=$dato[0];
	  $this->objude_codigo=$dato[1];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_objxpri <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "objude_codigo:".$this->objude_codigo."<br>";
	echo "<hr>";
  }  
    
  function cad2id($valor)
  {
  	list($this->datpro_id,$this->objude_codigo)=explode($this->separador,$valor);
  	return(1);
  }
  
  function id2cad($dat,$via)
  {
  	$cad=$dat.$this->separador.$via;
  	return($cad);
  }
  
  function validar()
  {
  	$sql="select datpro_id,objude_codigo from objxpri "
  		."where datpro_id=$this->datpro_id and objude_codigo=$this->objude_codigo";
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $dat=$rs->fields[0];
	  $via=$rs->fields[1];
	  
	  $res=$this->id2cad($dat,$via);
	}
	else
	  $res=0; 
	return ($res);
  }

  function crearoactualizar()
  {
    $existe=$this->validar();  
    if($existe)
    {
      $res=$this->update($existe);
    }
    else
    {
      $res=$this->add();	
    }
    return ($res);
  } 
  
  //funciones con base de datos
  function add()
  {
  	$insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into objxpri"
			." (objude_codigo,datpro_id)"
			." values ("
			."$this->objude_codigo,$this->datpro_id)";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del objxpries insertado, objude_codigo
	    $nid=$this->validar();
	    $oaux=new c_priorizacionProyecto($this->con,"udenor");
	    $oaux->actFechaAudit($this->datpro_id);
	  }
	  else
	    $nid=0;
	}
	else
	  $nid=0;  
	  
	return($nid);
  }
  
  function del($id)
  {
 	$aux=new c_objxpri($this->con);
 	$aux->info($id);
  	
  	$this->cad2id($id); 	
  	$sql="delete from objxpri "
		."where objude_codigo=$this->objude_codigo and datpro_id=$this->datpro_id ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_priorizacionProyecto($this->con,"udenor");
	  $oaux->actFechaAudit($aux->datpro_id);
	  return ($id);
	}  
	else
	  return 0;  		
  }
  
  function delall($datpro)
  {
  	$sql="delete from objxpri where datpro_id=$datpro ";
  	$rs=&$this->con->Execute($sql);
  	$oaux=new c_priorizacionProyecto($this->con,"udenor");
	$oaux->actFechaAudit($datpro);
  }
  
  
  function update($id)
  {
	$aux=new c_objxpri($this->con);
	$res=$aux->info($id);
	
	if($res!=0)
  	{
	  $this->cad2id($id);
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE objxpri "
		  ."set "
		  ."datpro_id='$this->datpro_id',"
		  ."WHERE objude_codigo=$this->objude_codigo ";
	  /*
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    return $id;
	  }	  
	  else
	    return 0;	
	  */
	  $oaux=new c_priorizacionProyecto($this->con,"udenor");
	  $oaux->actFechaAudit($aux->datpro_id);
	    
	  return ($id);
  	}
  	else 
  	  return ($id);
  }

  function info($id)
  {
  	$this->cad2id($id);
  	
  	$sql="select objude_codigo,datpro_id "
  		."from objxpri "
  		."where objude_codigo=$this->objude_codigo and datpro_id=$this->datpro_id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->objude_codigo=$rs->fields[0];
  	  $this->datpro_id=$rs->fields[1];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function cuantos($datpro)
  {
  	$sql="select count(datpro_id) from objxpri where datpro_id=$datpro ";
  	$rs=&$this->con->Execute($sql);
  	$res=$rs->fields[0];
  	return($res);
  }
  
}
?>