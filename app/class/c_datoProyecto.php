<?php
//clase para dato_proyecto
/**
 * Clase usada para administrar el contenido de los proyectos cuando son ingresados
 *
 */
class c_datoProyecto
{
  var $datpro_id;
  var $ingpro_codigo;
  var $com_codigo;
  var $pro_codigo;
  var $tip_codigo;
  
  var $est_codigo;
  var $datpro_codigo;
  var $datpro_nombre;
  
  var $usu_audit;
  var $usu_faudit;
  
  var $con;

  
  //constructor
  function c_datoProyecto($conBd,$usuario="udenor")
  {
	  include_once("class/c_tipo.php");
	  //inclusión de clase para calcular el nro de beneficiarios del proyecto
	  include_once("class/c_dpUbicacion.php");
	  include_once("class/c_dpDatoTecnico.php");
	  include_once("class/c_dpEntidades.php");
	  include_once("class/c_dpDocumentacion.php");
	  //inclusión de c_priorizacionProyecto para verificar si el proyecto ya ingresó al proceso de priorización
	  include_once("class/c_priorizacionProyecto.php");
  	
  	  $this->datpro_id=0;
	  $this->ingpro_codigo=0;	  
	  $this->com_codigo="";
	  $this->pro_codigo="";
	  $this->tip_codigo="";
	  
	  $this->est_codigo="";
	  $this->datpro_codigo="";//recuperar con los datos y hacer el procedimiento pa asignar un nuevo codigo
	  $this->datpro_nombre="";
	  
	  $this->con=&$conBd;
	  
	  $this->usu_audit=$usuario;
	  $this->usu_faudit=date("Y-m-d H:i:s");
  }  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=5;
	if($ncampos==count($dato))
	{
	  /*
	  $this->ingpro_codigo=$dato[0];
	  $this->com_codigo=$dato[1];      
      $this->pro_codigo=$dato[2];
      $this->tip_codigo=$dato[3];
      $this->est_codigo=$dato[4];
      $this->datpro_nombre=$dato[5];
      */
	  $this->com_codigo=$dato[0];      
      $this->pro_codigo=$dato[1];
      $this->tip_codigo=$dato[2];
      $this->est_codigo=$dato[3];
      $this->datpro_nombre=$dato[4];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_datoProyecto <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "ingpro_codigo:".$this->ingpro_codigo."<br>";	
	echo "com_codigo:".$this->com_codigo."<br>";
	echo "pro_codigo:".$this->pro_codigo."<br>";
	echo "tip_codigo:".$this->tip_codigo."<br>";
	
	echo "est_codigo:".$this->est_codigo."<br>";
	echo "datpro_codigo:".$this->datpro_codigo."<br>";
	echo "datpro_nombre:".$this->datpro_nombre."<br>";
	echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select datpro_id from dato_proyecto "
  		."where com_codigo='$this->com_codigo' and pro_codigo='$this->pro_codigo' "
  		."and tip_codigo='$this->tip_codigo' and datpro_nombre='$this->datpro_nombre' ";
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
    //solicitar datpro_codigo 
    $ctip=new c_tipo($this->con);
    $tipId=$ctip->id2cad($this->com_codigo,$this->pro_codigo,$this->tip_codigo);
    $this->datpro_codigo=$ctip->nuevoCodigoProyecto($tipId);
  	
  	$insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into dato_proyecto"
			." (ingpro_codigo,com_codigo,pro_codigo,tip_codigo,"
			."est_codigo,datpro_codigo,datpro_nombre,"
			."usu_audit,usu_faudit)"
			." values ("
			."'$this->ingpro_codigo','$this->com_codigo','$this->pro_codigo','$this->tip_codigo',"
			."'$this->est_codigo','$this->datpro_codigo','$this->datpro_nombre',"
			."'$this->usu_audit','$this->usu_faudit')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del dato_proyectoes insertado, datpro_id
	    $nid=$this->validar();
	    $ctip->proximo($tipId);
	  }
	  else
	    $nid=0;
	}
	else
	  $nid=0;  
	  
	return($nid);
  }
  
  function sepuedeeliminar($id)
  {
  	$opriorizacion=new c_priorizacionProyecto($this->con,"system");
 	$sepuede=$opriorizacion->info($id);
 	return(!$sepuede);
  }
  
  function del($id)
  {
 	
 	if($this->sepuedeeliminar($id))
 	{
  	  //eliminar los detalles del proyecto
  	  $oubi=new c_dpUbicacion($this->con);
  	  $odtec=new c_dpDatoTecnico($this->con);
  	  $oent=new c_dpEntidades($this->con);
  	  $odoc=new c_dpDocumentacion($this->con);
  	  
  	  $oubi->delxdatpro($id);
  	  $odtec->delxdatpro($id);
  	  $oent->delxdatpro($id);
  	  $odoc->delxdatpro($id);
  	  
 	  $sql="delete from dato_proyecto "
		."where datpro_id=$id ";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	    return $id;
	  else
	    return 0;  		
 	}
 	else
 	  return(0);
  }
  
  function update($id)
  {
	$aux=new c_datoProyecto($this->con,$this->usu_audit);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  $sql="UPDATE dato_proyecto "
		  ."set "
		  ."est_codigo='$this->est_codigo',"
		  ."usu_faudit='$this->usu_faudit',"
		  ."datpro_nombre='$this->datpro_nombre' "
		  ."WHERE datpro_id=$id";
//	echo "<br>$sql <br>";
//	$this->mostrar_dato();		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;	
  	}
  }

  function info($id)
  {
  	//$this->con->debug=true;
  	$sql="select ingpro_codigo,com_codigo,pro_codigo,tip_codigo,"
  		."est_codigo,datpro_codigo,datpro_nombre,"
  		."usu_audit,usu_faudit "
  		."from dato_proyecto "
  		."where datpro_id=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->datpro_id=$id;
  	  $this->ingpro_codigo=$rs->fields[0];
  	  $this->com_codigo=$rs->fields[1];
  	  $this->pro_codigo=$rs->fields[2];
  	  $this->tip_codigo=$rs->fields[3];
  	  $this->est_codigo=$rs->fields[4];
  	  $this->datpro_codigo=$rs->fields[5];
  	  $this->datpro_nombre=$rs->fields[6];
  	  
  	  $this->usu_audit=$rs->fields[7];
  	  $this->usu_faudit=$rs->fields[8];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function totalbeneficiarios($id)
  {
  	$cdpu=new c_dpUbicacion($this->con);
  	
  	$res=$this->info($id);
  	if($res)
  	{
  	  $sql="select ubi_codigo from dp_ubicacion where datpro_id=$this->datpro_id ";
  	  $rs=&$this->con->Execute($sql);
  	  if(!$rs->EOF)
  	  {
  	  	$acu=0;
  	  	while(!$rs->EOF)
  	  	{
  	  	  $ubicodigo=$rs->fields[0];
  	  	  $acu+=$cdpu->totalpoblacion($ubicodigo);
  	  	  
  	  	  $rs->MoveNext();
  	  	}
  	  	return ($acu);
  	  }
  	  else
  	  {
  	  	return (0);
  	  }	
  	}
  	else
  	{
  	  return(0);	
  	}
  }
  
  function actFechaAudit($id)
  {
  	$sql="update dato_proyecto "
  		."set usu_faudit='$this->usu_faudit' "
  		."where datpro_id=$id ";
  	$rs=&$this->con->Execute($sql);	
  }
       
}
?>