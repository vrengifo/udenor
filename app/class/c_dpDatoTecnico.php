<?php
//clase para dp_datotecnico
/**
 * Clase usada para registrar los valores de los datos técnicos al ingresar el proyecto
 *
 */
include_once("class/c_datoProyecto.php");
class c_dpDatoTecnico
{
  var $dattec_codigo;
  var $datpro_id;
  var $estdes_codigo;
  var $dattec_finicio;
  var $dattec_ffinal;  
  var $dattec_duracion;
  var $dattec_beneficiario;
  
  var $dattec_monto;
  var $mon_codigo;
  
  var $con;
  
  var $fcorta;

  
  //constructor
  function c_dpDatoTecnico($conBd)
  {
  	  include_once("class/c_moneda.php");
  	  include_once("class/c_dattecxent.php");
  	  
  	  $this->dattec_codigo=0;
	  $this->datpro_id=0;	  
	  $this->dattec_finicio="";
	  $this->estdes_codigo=0;
	  $this->dattec_ffinal="";
	  
	  $this->dattec_duracion="";
	  $this->dattec_beneficiario=0;
	  
	  $this->dattec_monto="0";
	  $this->mon_codigo="";
	  
	  $this->con=&$conBd;
	  
	  $this->fcorta="%Y-%m-%d";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=6;
	if($ncampos==count($dato))
	{
	  //$this->datpro_id=$dato[0];
	  $this->estdes_codigo=$dato[0];
	  $this->dattec_finicio=$dato[1];      
      $this->dattec_ffinal=$dato[2];
      $this->dattec_duracion=$dato[3];
      $this->dattec_beneficiario=$dato[4];
      
      //$this->dattec_monto=$dato[5];
      $this->mon_codigo=$dato[5];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_dpDatoTecnico <br>";
  	echo "dattec_codigo:".$this->dattec_codigo."<br>";
	echo "datpro_id:".$this->datpro_id."<br>";	
	echo "estdes_codigo:".$this->estdes_codigo."<br>";
	echo "dattec_finicio:".$this->dattec_finicio."<br>";
	echo "dattec_ffinal:".$this->dattec_ffinal."<br>";
	echo "dattec_duracion:".$this->dattec_duracion."<br>";
	echo "dattec_beneficiario:".$this->dattec_beneficiario."<br>";
	
	echo "dattec_monto:".$this->dattec_monto."<br>";
	echo "mon_codigo:".$this->mon_codigo."<br>";
	echo "<hr>";
  }  
  
  function setear()
  {
  	if((strlen($this->dattec_finicio)==0)||($this->dattec_finicio=="-"))
  	  $this->dattec_finicio="";
  	if((strlen($this->dattec_ffinal)==0)||($this->dattec_ffinal=="-"))
  	  $this->dattec_ffinal="";  
  }
  
  function validar()
  {
  	$this->setear();//pone cero en los valores q no han sido escogidos
  	/*
  	$sql="select dattec_codigo from dp_datotecnico "
  		."where estdes_codigo=$this->estdes_codigo "
  		."and datpro_id=$this->datpro_id ";
  	*/	
  	$sql="select dattec_codigo from dp_datotecnico "
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
  	if(!$existe)
  	{
  	  $res=$this->add();	
  	}
  	else
  	{
  	  $res=$this->update($existe);	
  	}
  	return($res);
  } 
  
  //funciones con base de datos
  function add()
  {
  	$insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into dp_datotecnico"
			." (datpro_id,estdes_codigo,dattec_finicio,dattec_ffinal,"
			."dattec_duracion,dattec_beneficiario,dattec_monto,mon_codigo)"
			." values ("
			."$this->datpro_id,$this->estdes_codigo,'$this->dattec_finicio','$this->dattec_ffinal',"
			."'$this->dattec_duracion','$this->dattec_beneficiario','$this->dattec_monto','$this->mon_codigo')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del dp_datotecnicoes insertado, dattec_codigo
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
  	$aux=new c_dpDatoTecnico($this->con);
  	$aux->info($id);
  	$sql="delete from dp_datotecnico "
		."where dattec_codigo=$id ";
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
 	$dattec=$this->buscarxdatpro($datpro);
 	$odet=new c_dattecxent($this->con);
 	
 	$odet->delxdattec($dattec);
 	$this->del($dattec);
 	
 	$oaux=new c_datoProyecto($this->con);
	$oaux->actFechaAudit($datpro);
 	  
	return($datpro);
  }
  
  function update($id)
  {
	$aux=new c_dpDatoTecnico($this->con);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE dp_datotecnico "
		  ."set "
		  ."estdes_codigo='$this->estdes_codigo',"
		  ."dattec_finicio='$this->dattec_finicio',"
		  ."dattec_ffinal='$this->dattec_ffinal',"
		  ."dattec_duracion='$this->dattec_duracion',"
		  ."dattec_beneficiario='$this->dattec_beneficiario',"
		  ."mon_codigo='$this->mon_codigo' "
		  ."WHERE dattec_codigo=$id";
//	echo "<br>$sql <br>";
//	$this->mostrar_dato();		
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $this->actualizarmonto($id);
	  return $id;
	}	  
	else
	  return 0;	
  	}
  }

  function buscarxpro($datpro)
  {
  	$sql="select dattec_codigo from dp_datotecnico where datpro_id=$datpro ";
  	$rs=&$this->con->Execute($sql);
  	if($rs->EOF)
  	  $res=0;
  	else
  	  $res=$rs->fields[0];
  	return($res);    
  }
  
  function info($id)
  {
  	$sql="select datpro_id,estdes_codigo,date_format(dattec_finicio,'$this->fcorta'),date_format(dattec_ffinal,'$this->fcorta'),"
  		."dattec_duracion,dattec_beneficiario,dattec_monto,mon_codigo "
  		."from dp_datotecnico "
  		."where dattec_codigo=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->dattec_codigo=$id;
  	  $this->datpro_id=$rs->fields[0];
  	  $this->estdes_codigo=$rs->fields[1];
  	  $this->dattec_finicio=$rs->fields[2];
  	  $this->dattec_ffinal=$rs->fields[3];
  	  $this->dattec_duracion=$rs->fields[4];
  	  $this->dattec_beneficiario=$rs->fields[5];
  	  $this->dattec_monto=$rs->fields[6];
  	  $this->mon_codigo=$rs->fields[7];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function calcularmonto($id)
  {
    $this->info($id);
    $cmon=new c_moneda($this->con);
    //convertir todo a $
    $sql="select sum(dte.dte_monto*(mon.mon2dolar)) "
    	."from dattecxent dte, moneda mon "
    	."where dte.mon_codigo=mon.mon_codigo and dte.dattec_codigo=$this->dattec_codigo ";
    $rs=&$this->con->Execute($sql);
    $montodolar=$rs->fields[0];
    
    //recuperar la moneda del datoTecnico
    $cmon->info($this->mon_codigo);
    $monto=$montodolar/$cmon->mon2dolar;	
    return ($monto);
  }
  
  function actualizarmonto($id)
  {
  	$monto=$this->calcularmonto($id);
  	$sql="update dp_datotecnico set dattec_monto='$monto' where dattec_codigo=$id ";
  	$rs=&$this->con->Execute($sql);
  	
  	$aux=new c_dpDatoTecnico($this->con);
  	$aux->info($id);
  	$oaux=new c_datoProyecto($this->con);
	$oaux->actFechaAudit($aux->datpro_id);
  	
  	return($id);
  }
  
  function buscarxdatpro($datpro)
  {
  	$sql="select dattec_codigo from dp_datotecnico where datpro_id=$datpro ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	  $res=$rs->fields[0];
  	else
  	  $res=0;
  	return ($res);    
  } 
       
}
?>