<?php
//clase para beneficiosocial
/**
 * Clase usada para registrar los valores de beneficio social en la priorización
 *
 */
include_once("class/c_priorizacionProyecto.php");
class c_beneficioSocial
{
  var $datpro_id;
  var $ben_directos;
  var $ben_totalparroquias;

  var $separador;
  
  var $con;

  
  //constructor
  function c_beneficioSocial($conBd)
  {
  	  include_once("class/c_datoProyecto.php");
  	  
  	  $this->datpro_id=0;
	  $this->ben_directos="0";	  
	  $this->ben_totalparroquias="0";
	  
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
	  $this->ben_directos=$dato[1];
	  $this->ben_totalparroquias=$dato[2];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_beneficioSocial <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "ben_directos:".$this->ben_directos."<br>";	
	echo "ben_totalparroquias:".$this->ben_totalparroquias."<br>";
	echo "<hr>";
  }  
    
  function validar()
  {
  	$sql="select datpro_id from beneficiosocial "
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
    //$this->con->debug=true;
  	//recuperar el total de las parroquias
  	$cdpro=new c_datoProyecto($this->con);
  	$this->ben_totalparroquias=$cdpro->totalbeneficiarios($this->datpro_id);
    
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
	  $sql="insert into beneficiosocial"
			." (ben_directos,ben_totalparroquias,datpro_id)"
			." values ("
			."'$this->ben_directos','$this->ben_totalparroquias',$this->datpro_id)";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del beneficiosociales insertado, datpro_id
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
 	$aux=new c_beneficioSocial($this->con);
 	$aux->info($id);
  	
  	$sql="delete from beneficiosocial "
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
	$aux=new c_beneficioSocial($this->con);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE beneficiosocial "
		  ."set "
		  ."ben_directos='$this->ben_directos',"
		  ."ben_totalparroquias='$this->ben_totalparroquias' "
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

  /**
   * Enter description here...
   *
   * @param unknown_type $id
   * @return unknown
   */
  function info($id)
  {
  	$sql="select ben_directos,ben_totalparroquias "
  		."from beneficiosocial "
  		."where datpro_id=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->datpro_id=$id;
  	  $this->ben_directos=$rs->fields[0];
  	  $this->ben_totalparroquias=$rs->fields[1];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function porcentaje($id)
  {
  	$this->info($id);
  	$res=$this->ben_directos*100/$this->ben_totalparroquias;
  	return($res);
  }
  
}
?>