<?php
//clase para dp_entidades
/**
 * Clase usada para registrar los valores de entidades que apoyan al proyecto cuando se ingresan los datos del proyecto
 *
 */
include_once("class/c_datoProyecto.php");
class c_dpEntidades
{
  var $tipent_codigo;
  var $ent_codigo;
  
  var $datpro_id;

  var $separador;
  
  var $con;

  
  //constructor
  function c_dpEntidades($conBd)
  {
  	  $this->tipent_codigo=0;
	  $this->ent_codigo="";
	  $this->datpro_id="";
	    
	  $this->con=&$conBd;
	  
	  $this->separador=":";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=2;
	if($ncampos==count($dato))
	{
	  //$this->datpro_id=$dato[0];
	  $this->tipent_codigo=$dato[0];
	  $this->ent_codigo=$dato[1];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_dpEntidades <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "tipent_codigo:".$this->tipent_codigo."<br>";
	echo "ent_codigo:".$this->ent_codigo."<br>";	
	echo "<hr>";
  }  
    
  function cad2id($valor)
  {
  	list($this->datpro_id,$this->tipent_codigo,$this->ent_codigo)=explode($this->separador,$valor);
  	return(1);
  }
  
  function id2cad($dat,$tent,$ent)
  {
  	$cad=$dat.$this->separador.$tent.$this->separador.$ent;
  	return($cad);
  }
  
  function validar()
  {
  	$sql="select datpro_id,tipent_codigo,ent_codigo from dp_entidades "
  		."where datpro_id=$this->datpro_id and tipent_codigo='$this->tipent_codigo' and ent_codigo=$this->ent_codigo ";
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $dat=$rs->fields[0];
	  $tent=$rs->fields[1];
	  $ent=$rs->fields[2];
	  
	  $res=$this->id2cad($dat,$tent,$ent);
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
  	//$this->con->debug=true;
  	$insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into dp_entidades"
			." (tipent_codigo,ent_codigo,datpro_id)"
			." values ("
			."'$this->tipent_codigo',$this->ent_codigo,$this->datpro_id)";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del dp_entidadeses insertado, tipent_codigo
	    $nid=$this->validar();
	    $oaux=new c_datoProyecto($this->con);
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
 	$aux=new c_dpEntidades($this->con);
 	$aux->info($id);
  	
  	$this->cad2id($id);
  	$sql="delete from dp_entidades "
		."where tipent_codigo='$this->tipent_codigo' and ent_codigo=$this->ent_codigo and datpro_id=$this->datpro_id ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_datoProyecto($this->con);
	  $oaux->actFechaAudit($aux->datpro_id);
	  return($id);
	}  
	else
	  return 0;  		
  }
  
  function delxdatpro($datpro)
  {
  	$sql="delete from dp_entidades "
		."where datpro_id=$datpro ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_datoProyecto($this->con);
	  $oaux->actFechaAudit($datpro);
	  return ($datpro);
	}
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$aux=new c_dpEntidades($this->con);
	$res=$aux->info($id);
	
	if($res!=0)
  	{
	  $this->cad2id($id);
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE dp_entidades "
		  ."set "
		  ."datpro_id='$this->datpro_id',"
		  ."borrar='$this->borrar' "
		  ."WHERE tipent_codigo=$this->tipent_codigo and ent_codigo=$this->ent_codigo ";
	  /*
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    return $id;
	  }	  
	  else
	    return 0;	
	  */  
	  $oaux=new c_datoProyecto($this->con);
	  $oaux->actFechaAudit($aux->datpro_id);
	  return ($id);
  	}
  	else 
  	  return ($id);
  }

  function info($id)
  {
  	$this->cad2id($id);
  	
  	$sql="select tipent_codigo,ent_codigo,datpro_id "
  		."from dp_entidades "
  		."where tipent_codigo='$this->tipent_codigo' and ent_codigo=$this->ent_codigo "
  		."and datpro_id=$this->datpro_id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->tipent_codigo=$rs->fields[0];
  	  $this->ent_codigo=$rs->fields[1];
  	  $this->datpro_id=$rs->fields[2];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
}
?>