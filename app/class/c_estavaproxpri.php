<?php
//clase para estavaproxpri
/**
 * Clase usada para administrar todos los estados que se generan al cambiar los datos de priorización del proyecto
 *
 */
include_once("class/c_priorizacionProyecto.php");
class c_estavaproxpri
{
  var $datpro_id;
  var $estavapro_codigo;
  
  var $estavaproxpri_fecha;
  
  var $usu_audit;
  var $usu_faudit;

  var $separador;
  
  var $fcorta;
  
  var $con;

  
  //constructor
  function c_estavaproxpri($conBd,$usuario)
  {
  	  $this->datpro_id=0;
	  $this->estavapro_codigo="";
	  $this->estavaproxpri_fecha="";
	    
	  $this->usu_faudit=date("Y-m-d");
	  $this->usu_audit=$usuario;
	  
	  $this->con=&$conBd;
	  
	  $this->separador=":";
	  
	  $this->fcorta="%Y-%m-%d";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=2;
	if($ncampos==count($dato))
	{
	  //$this->datpro_id=$dato[0];
	  $this->estavapro_codigo=$dato[0];
	  $this->estavaproxpri_fecha=$dato[1];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_estavaproxpri <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "estavapro_codigo:".$this->estavapro_codigo."<br>";	
	echo "estavaproxpri_fecha:".$this->estavaproxpri_fecha."<br>";
	echo "usu_audit:".$this->usu_audit."<br>";
	echo "usu_faudit:".$this->usu_faudit."<br>";
	echo "<hr>";
  }  
    
  function cad2id($valor)
  {
  	list($this->datpro_id,$this->estavapro_codigo)=explode($this->separador,$valor);
  	return(1);
  }
  
  function id2cad($datpro,$estava)
  {
  	$cad=$datpro.$this->separador.$estava;
  	return($cad);
  }
  
  function validar()
  {
  	$sql="select datpro_id,estavapro_codigo from estavaproxpri "
  		."where datpro_id=$this->datpro_id and estavapro_codigo='$this->estavapro_codigo' ";
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $datpro=$rs->fields[0];
	  $estava=$rs->fields[1];
	  $res=$this->id2cad($datpro,$estava);
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
	  $sql="insert into estavaproxpri"
			." (datpro_id,estavapro_codigo,usu_audit,usu_faudit,"
			."estavaproxpri_fecha)"
			." values ("
			."$this->datpro_id,'$this->estavapro_codigo','$this->usu_audit','$this->usu_faudit',"
			."'$this->estavaproxpri_fecha')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del estavaproxpries insertado, datpro_id
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
 	$aux=new c_estavaproxpri($this->con,"udenor");
 	$aux->info($id);
  	$this->cad2id($id);
  	$sql="delete from estavaproxpri "
		."where datpro_id=$this->datpro_id and estavapro_codigo='$this->estavapro_codigo' ";
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
	$aux=new c_estavaproxpri($this->con,$this->usu_audit);
	$res=$aux->info($id);
	
	
  	if($res!=0)
  	{
	  $this->cad2id($id);
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE estavaproxpri "
		  ."set "
		  ."estavaproxpri_fecha='$this->estavaproxpri_fecha',"
		  ."usu_audit='$this->usu_audit',"
		  ."usu_faudit='$this->usu_faudit' "
		  ."WHERE datpro_id=$this->datpro_id and estavapro_codigo='$this->estavapro_codigo' ";
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
  	else 
  	  return ($id);
  }

  function info($id)
  {
  	//$this->con->debug=true;
  	$this->cad2id($id);
  	
  	$sql="select datpro_id,estavapro_codigo,date_format(estavaproxpri_fecha,'$this->fcorta'),usu_audit,usu_faudit "
  		."from estavaproxpri "
  		."where datpro_id=$this->datpro_id and estavapro_codigo='$this->estavapro_codigo' ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->datpro_id=$rs->fields[0];
  	  $this->estavapro_codigo=$rs->fields[1];
  	  $this->estavaproxpri_fecha=$rs->fields[2];
  	  $this->usu_audit=$rs->fields[3];
  	  $this->usu_faudit=$rs->fields[4];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
}
?>