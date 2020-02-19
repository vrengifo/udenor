<?php
//clase para contrapartida
/**
 * Clase usada para registrar los valores de contrapartida en la priorización
 *
 */
include_once("class/c_priorizacionProyecto.php");
class c_contrapartida
{
  var $datpro_id;
  var $contra_beneficiarios;
  var $contra_proponente;

  var $separador;
  
  var $con;

  
  //constructor
  function c_contrapartida($conBd)
  {
  	  $this->datpro_id=0;
	  $this->contra_beneficiarios="0";	  
	  $this->contra_proponente="0";
	  
	  $this->con=&$conBd;
	  
	  $this->separador=".";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=3;
	if($ncampos==count($dato))
	{
	  $this->datpro_id=$dato[0];
	  $this->contra_beneficiarios=$dato[1];
	  $this->contra_proponente=$dato[2];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_contrapartida <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "contra_beneficiarios:".$this->contra_beneficiarios."<br>";	
	echo "contra_proponente:".$this->contra_proponente."<br>";
	echo "<hr>";
  }  
    
  function validar()
  {
  	$sql="select datpro_id from contrapartida "
  		."where datpro_id=$this->datpro_id ";
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	  $res=$rs->fields[0];
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
	  $sql="insert into contrapartida"
			." (contra_beneficiarios,contra_proponente,datpro_id)"
			." values ("
			."'$this->contra_beneficiarios','$this->contra_proponente',$this->datpro_id)";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del contrapartidaes insertado, datpro_id
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
 	$aux=new c_contrapartida($this->con);
 	$aux->info($id);
  	
  	$sql="delete from contrapartida "
		."where datpro_id=$id ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_priorizacionProyecto($this->con,"udenor");
	  $oaux->actFechaAudit($aux->datpro_id);
	  return($id);
	}
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$aux=new c_contrapartida($this->con);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE contrapartida "
		  ."set "
		  ."contra_beneficiarios='$this->contra_beneficiarios',"
		  ."contra_proponente='$this->contra_proponente',"
		  ."WHERE datpro_id=$id";
//	echo "<br>$sql <br>";
//	$this->mostrar_dato();		
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_priorizacionProyecto($this->con,"udenor");
	  $oaux->actFechaAudit($aux->datpro_id);
	  return $id;
	}	  
	else
	  return 0;	
  	}
  }

  function info($id)
  {
  	$sql="select contra_beneficiarios,contra_proponente "
  		."from contrapartida "
  		."where datpro_id=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->datpro_id=$id;
  	  $this->contra_beneficiarios=$rs->fields[0];
  	  $this->contra_proponente=$rs->fields[1];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function sumatoria($id)
  {
    $this->info($id);
    $res=$this->contra_beneficiarios+$this->contra_proponente;
    return($res);
  }
  
}
?>