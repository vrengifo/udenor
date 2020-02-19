<?php
//clase para priorizacion_proyecto
/**
 * Clase usada para administrar los proyectos que han pasado a la fase de priorización
 *
 */
class c_priorizacionProyecto
{
  var $datpro_id;
  var $datpro_codigo;
  var $usu_audit;
  var $usu_faudit;

  var $separador;
  
  var $con;

  
  //constructor
  function c_priorizacionProyecto($conBd,$usuario)
  {
  	  $this->datpro_id=0;
	  $this->datpro_codigo="";	  
	  $this->usu_faudit=date("Y-m-d H:i:s");
	  $this->usu_audit=$usuario;
	  
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
	  $this->datpro_codigo=$dato[1];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_priorizacionProyecto <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "datpro_codigo:".$this->datpro_codigo."<br>";	
	echo "usu_audit:".$this->usu_audit."<br>";
	echo "usu_faudit:".$this->usu_faudit."<br>";
	echo "<hr>";
  }  
    
  function validar()
  {
  	$sql="select datpro_id from priorizacion_proyecto "
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
	  $sql="insert into priorizacion_proyecto"
			." (datpro_codigo,usu_audit,usu_faudit,datpro_id)"
			." values ("
			."'$this->datpro_codigo','$this->usu_audit','$this->usu_faudit',$this->datpro_id)";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del priorizacion_proyectoes insertado, datpro_id
	    $nid=$this->validar();
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
 	$sql="delete from priorizacion_proyecto "
		."where datpro_id=$id ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$aux=new c_priorizacionProyecto($this->con);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE priorizacion_proyecto "
		  ."set "
		  ."usu_audit='$this->usu_audit',"
		  ."usu_faudit='$this->usu_faudit' "
		  ."WHERE datpro_id=$id";
//	echo "<br>$sql <br>";
//	$this->mostrar_dato();		
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  return $id;
	}	  
	else
	  return 0;	
  	}
  }

  function info($id)
  {
  	$sql="select datpro_codigo,usu_audit,usu_faudit "
  		."from priorizacion_proyecto "
  		."where datpro_id=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->datpro_id=$id;
  	  $this->datpro_codigo=$rs->fields[0];
  	  $this->usu_audit=$rs->fields[1];
  	  $this->usu_faudit=$rs->fields[2];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function actFechaAudit($id)
  {
  	$sql="update priorizacion_proyecto "
  		."set usu_faudit='$this->usu_faudit' "
  		."where datpro_id=$id ";
  	$rs=&$this->con->Execute($sql);	
  }
  
}
?>