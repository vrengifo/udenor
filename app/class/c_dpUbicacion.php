<?php
//clase para dp_ubicacion
/**
 * Clase usada para registrar la ubicación en la cual tiene ámbito de acción el proyecto
 *
 */
include_once("class/c_datoProyecto.php");
class c_dpUbicacion
{
  var $ubi_codigo;
  var $datpro_id;
  var $pro_codigo;
  var $can_codigo;
  var $par_codigo;
  
  var $ubi_comunidad;
  var $ubi_observacion;
  
  var $con;

  
  //constructor
  function c_dpUbicacion($conBd)
  {
  	  $this->ubi_codigo=0;
	  $this->datpro_id=0;	  
	  $this->can_codigo=0;
	  $this->pro_codigo=0;
	  $this->par_codigo=0;
	  
	  $this->ubi_comunidad="";
	  $this->ubi_observacion="";
	  
	  $this->con=&$conBd;
  }  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=5;
	if($ncampos==count($dato))
	{
	  //$this->datpro_id=$dato[0];
	  $this->pro_codigo=$dato[0];
	  $this->can_codigo=$dato[1];      
      $this->par_codigo=$dato[2];
      $this->ubi_comunidad=$dato[3];
      $this->ubi_observacion=$dato[4];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_dpUbicacion <br>";
  	echo "ubi_codigo:".$this->ubi_codigo."<br>";
	echo "datpro_id:".$this->datpro_id."<br>";	
	echo "pro_codigo:".$this->pro_codigo."<br>";
	echo "can_codigo:".$this->can_codigo."<br>";
	echo "par_codigo:".$this->par_codigo."<br>";
	
	echo "ubi_comunidad:".$this->ubi_comunidad."<br>";
	echo "ubi_observacion:".$this->ubi_observacion."<br>";
	echo "<hr>";
  }  
  
  function setear()
  {
  	if((strlen($this->can_codigo)==0)||($this->can_codigo=="-")||($this->can_codigo=="0"))
  	  $this->can_codigo=0;
  	if((strlen($this->par_codigo)==0)||($this->par_codigo=="-")||($this->par_codigo=="0"))
  	  $this->par_codigo=0;  
  }
  
  function validar()
  {
  	$this->setear();//pone cero en los valores q no han sido escogidos
  	$sql="select ubi_codigo from dp_ubicacion "
  		."where pro_codigo=$this->pro_codigo "
  		."and can_codigo=$this->can_codigo and par_codigo=$this->par_codigo "
  		."and datpro_id=$this->datpro_id ";
  	//echo "$sql";	
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	  $res=$rs->fields[0];
	else
	  $res=0; 
	return ($res);
  }  
  
  //funciones con base de datos
  function add()
  {
  	$insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into dp_ubicacion"
			." (datpro_id,pro_codigo,can_codigo,par_codigo,"
			."ubi_comunidad,ubi_observacion)"
			." values ("
			."$this->datpro_id,$this->pro_codigo,$this->can_codigo,$this->par_codigo,"
			."'$this->ubi_comunidad','$this->ubi_observacion')";
	  //echo "<br>$sql<br>";		
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del dp_ubicaciones insertado, ubi_codigo
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
 	$aux=new c_dpUbicacion($this->con);
 	$aux->info($id);
  	//$this->con->debug=true;
  	$sql="delete from dp_ubicacion "
		."where ubi_codigo=$id ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_datoProyecto($this->con);
	  $oaux->actFechaAudit($aux->datpro_id);
	  return $id;
	}  
	else
	  return 0;  		
  }
  
  function delxdatpro($datpro)
  {
 	//$this->con->debug=true;
  	$sql="delete from dp_ubicacion "
		."where datpro_id=$datpro ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_datoProyecto($this->con);
	  $oaux->actFechaAudit($datpro);
	  return $datpro;
	}  
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$aux=new c_dpUbicacion($this->con);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  $sql="UPDATE dp_ubicacion "
		  ."set "
		  ."ubi_comunidad='$this->ubi_comunidad',"
		  ."ubi_observacion='$this->ubi_observacion' "
		  ."WHERE ubi_codigo=$id";
//	echo "<br>$sql <br>";
//	$this->mostrar_dato();		
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_datoProyecto($this->con);
	  $oaux->actFechaAudit($aux->datpro_id);
	  return $id;
	}
	else
	  return 0;	
  	}
  }

  function info($id)
  {
  	$sql="select datpro_id,can_codigo,pro_codigo,par_codigo,"
  		."ubi_comunidad,ubi_observacion "
  		."from dp_ubicacion "
  		."where ubi_codigo=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->ubi_codigo=$id;
  	  $this->datpro_id=$rs->fields[0];
  	  $this->can_codigo=$rs->fields[1];
  	  $this->pro_codigo=$rs->fields[2];
  	  $this->par_codigo=$rs->fields[3];
  	  $this->ubi_comunidad=$rs->fields[4];
  	  $this->ubi_observacion=$rs->fields[5];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function totalpoblacion($id)
  {
  	$this->info($id);
  	
  	//si se escogio solo provincia pero no canton y parroquia
  	if(($this->can_codigo==0)&&($this->par_codigo==0))
  	{
  	  $sql="select sum(par.par_poblacion) "
  	  	  ."from canton can,parroquia par "
  	  	  ."where can.pro_codigo=$this->pro_codigo "
  	  	  ."and par.can_codigo=can.can_codigo ";
  	}
  	if(($this->can_codigo!=0)&&($this->par_codigo==0))
  	{
  	  $sql="select sum(par.par_poblacion) "
  	  	  ."from canton can,parroquia par "
  	  	  ."where can.can_codigo=$this->can_codigo "
  	  	  ."and par.can_codigo=can.can_codigo ";	
  	}
  	if($this->par_codigo!=0)
  	{
  	  $sql="select sum(par.par_poblacion) "
  	  	  ."from parroquia par "
  	  	  ."where par.par_codigo=$this->par_codigo ";
  	}
  	$rs=&$this->con->Execute($sql);
  	$res=$rs->fields[0];
  	return ($res);
  } 
       
}
?>