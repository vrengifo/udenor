<?php
//clase para beneficioeconomico
/**
 * Clase usada para registrar los valores económicos del proyecto en la priorización
 *
 */
include_once("class/c_priorizacionProyecto.php");
class c_beneficioEconomico
{
  var $datpro_id;
  var $beneco_tmr;
  var $beneco_tir;
  var $beneco_van;
  var $beneco_gastosadmin;  

  var $separador;
  
  var $con;

  
  //constructor
  function c_beneficioEconomico($conBd)
  {
  	  $this->datpro_id=0;
	  $this->beneco_tmr="0";	  
	  $this->beneco_van="0";
	  $this->beneco_tir="0";
	  $this->beneco_gastosadmin="0";
	  
	  $this->con=&$conBd;
	  
	  $this->separador=".";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=4;
	if($ncampos==count($dato))
	{
	  //$this->datpro_id=$dato[0];
	  $this->beneco_tmr=$dato[0];
	  $this->beneco_tir=$dato[1];
	  $this->beneco_van=$dato[2];      
      $this->beneco_gastosadmin=$dato[3];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_beneficioEconomico <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "beneco_tmr:".$this->beneco_tmr."<br>";	
	echo "beneco_tir:".$this->beneco_tir."<br>";
	echo "beneco_van:".$this->beneco_van."<br>";
	echo "beneco_gastosadmin:".$this->beneco_gastosadmin."<br>";
	echo "<hr>";
  }  
    
  function validar()
  {
  	$sql="select datpro_id from beneficioeconomico "
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
	  $sql="insert into beneficioeconomico"
			." (beneco_tmr,beneco_tir,beneco_van,beneco_gastosadmin,"
			."datpro_id)"
			." values ("
			."'$this->beneco_tmr','$this->beneco_tir','$this->beneco_van','$this->beneco_gastosadmin',"
			."$this->datpro_id)";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del beneficioeconomicoes insertado, datpro_id
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
 	$aux=new c_beneficioEconomico($this->con);
 	$aux->info($id);
  	
  	$sql="delete from beneficioeconomico "
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
	$aux=new c_beneficioEconomico($this->con);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE beneficioeconomico "
		  ."set "
		  ."beneco_tmr='$this->beneco_tmr',"
		  ."beneco_tir='$this->beneco_tir',"
		  ."beneco_van='$this->beneco_van',"
		  ."beneco_gastosadmin='$this->beneco_gastosadmin' "
		  ."WHERE datpro_id=$id";
//	echo "<br>$sql <br>";
//	$this->mostrar_dato();		
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
  }

  function info($id)
  {
  	$sql="select beneco_tmr,beneco_tir,beneco_van,beneco_gastosadmin "
  		."from beneficioeconomico "
  		."where datpro_id=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->datpro_id=$id;
  	  $this->beneco_tmr=$rs->fields[0];
  	  $this->beneco_tir=$rs->fields[1];
  	  $this->beneco_van=$rs->fields[2];
  	  $this->beneco_gastosadmin=$rs->fields[3];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function tir($id)
  {
  	$this->info($id);
  	$res=$this->beneco_tir-$this->beneco_tmr;
  	return($res);
  }
  
  function van($id)
  {
  	$this->info($id);
  	$res=$this->beneco_van;
  	return($res);
  }
  
  function ga($id)
  {
  	$this->info($id);
  	$res=$this->beneco_gastosadmin;
  	return($res);
  }
  
}
?>