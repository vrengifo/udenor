<?php
//clase para dp_documentacion
/**
 * Clase usada para administrar los valores de la documentación que tiene el proyecto al ingresar sus datos 
 *
 */
class c_dpDocumentacion
{
  var $doc_codigo;
  var $datpro_id;
  var $tipdoc_codigo;
  var $doc_codigosis;
  var $doc_nombre;  
  var $doc_path;

  var $separador;
  
  var $con;

  
  //constructor
  function c_dpDocumentacion($conBd)
  {
  	  include_once("class/c_datoProyecto.php");
  	  $this->doc_codigo=0;
	  $this->datpro_id=0;	  
	  $this->doc_codigosis="";
	  $this->tipdoc_codigo=0;
	  $this->doc_nombre="";
	  
	  $this->doc_path="";
	  
	  $this->con=&$conBd;
	  
	  $this->separador=".";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=3;
	if($ncampos==count($dato))
	{
	  //$this->datpro_id=$dato[0];
	  $this->tipdoc_codigo=$dato[0];
	  //$this->doc_codigosis=$dato[1];      
      $this->doc_nombre=$dato[1];
      $this->doc_path=$dato[2];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_dpDocumentacion <br>";
  	echo "doc_codigo:".$this->doc_codigo."<br>";
	echo "datpro_id:".$this->datpro_id."<br>";	
	echo "tipdoc_codigo:".$this->tipdoc_codigo."<br>";
	echo "doc_codigosis:".$this->doc_codigosis."<br>";
	echo "doc_nombre:".$this->doc_nombre."<br>";
	echo "doc_path:".$this->doc_path."<br>";
	echo "<hr>";
  }  
  
  function setear()
  {
  	$cdatPro=new c_datoProyecto($this->con);
  	$cdatPro->info($this->datpro_id);
  	
  	$aux=new c_dpDocumentacion($this->con);
  	
  	
  	$existe=$aux->tienedocumentos($this->datpro_id);
  	
  	if(!$existe)
  	{
  	  $this->doc_codigosis=$cdatPro->datpro_codigo.$this->separador."1";	
  	}
  	else 
  	{
  	  $sql="select max(doc_codigosis) from dp_documentacion where datpro_id=$cdatPro->datpro_id ";
  	  $rs=&$this->con->Execute($sql);
  	  $mayor=$rs->fields[0];
  	  
  	  list($codigo,$nactual)=explode($this->separador,$mayor);
  	  $this->doc_codigosis=$codigo.$this->separador.($nactual+1);
  	} 
  }
  
  function tienedocumentos($datpro)
  {
  	$sql="select count(doc_codigo) from dp_documentacion "
  		."where datpro_id=$datpro ";
  	$rs=&$this->con->Execute($sql);
  	$res=$rs->fields[0];
  	return($res);	
  }
  
  function validar()
  {
  	$sql="select doc_codigo from dp_documentacion "
  		."where doc_codigosis='$this->doc_codigosis' "
  		."and datpro_id=$this->datpro_id ";
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
  	//$this->con->debug=true;
  	$this->setear();
  	$insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into dp_documentacion"
			." (datpro_id,tipdoc_codigo,doc_codigosis,doc_nombre,"
			."doc_path)"
			." values ("
			."$this->datpro_id,$this->tipdoc_codigo,'$this->doc_codigosis','$this->doc_nombre',"
			."'$this->doc_path')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del dp_documentaciones insertado, doc_codigo
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
 	$aux=new c_dpDocumentacion($this->con);
  	$sql="delete from dp_documentacion "
		."where doc_codigo=$id ";
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
 	$sql="delete from dp_documentacion "
		."where datpro_id=$datpro ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $oaux=new c_datoProyecto($this->con);
	  $oaux->actFechaAudit($datpro);
	  return($datpro);
	}
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$aux=new c_dpDocumentacion($this->con);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE dp_documentacion "
		  ."set "
		  ."doc_nombre='$this->doc_nombre',"
		  ."doc_path='$this->doc_path' "
		  ."WHERE doc_codigo=$id";
//	echo "<br>$sql <br>";
//	$this->mostrar_dato();		
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
  }

  function info($id)
  {
  	$sql="select datpro_id,tipdoc_codigo,doc_codigosis,doc_nombre,"
  		."doc_path "
  		."from dp_documentacion "
  		."where doc_codigo=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->doc_codigo=$id;
  	  $this->datpro_id=$rs->fields[0];
  	  $this->tipdoc_codigo=$rs->fields[1];
  	  $this->doc_codigosis=$rs->fields[2];
  	  $this->doc_nombre=$rs->fields[3];
  	  $this->doc_path=$rs->fields[4];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
}
?>