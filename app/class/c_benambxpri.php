<?php
//clase para benambxpri
/**
 * Clase usada para administrar los beneficios ambientales en la priorización de un proyecto
 *
 */
include_once("class/c_priorizacionProyecto.php");
class c_benambxpri
{
  var $benamb_id;
  var $datpro_id;

  var $separador;
  
  var $con;

  
  //constructor
  function c_benambxpri($conBd)
  {
  	  $this->benamb_id=0;
	  $this->datpro_id=0;
	    
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
	  $this->benamb_id=$dato[1];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_benambxpri <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "benamb_id:".$this->benamb_id."<br>";
	echo "<hr>";
  }  
    
  function cad2id($valor)
  {
  	list($this->datpro_id,$this->benamb_id)=explode($this->separador,$valor);
  	return(1);
  }
  
  function id2cad($dat,$via)
  {
  	$cad=$dat.$this->separador.$via;
  	return($cad);
  }
  
  function validar()
  {
  	$sql="select datpro_id,benamb_id from benambxpri "
  		."where datpro_id=$this->datpro_id and benamb_id=$this->benamb_id";
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $dat=$rs->fields[0];
	  $via=$rs->fields[1];
	  
	  $res=$this->id2cad($dat,$via);
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
	  $sql="insert into benambxpri"
			." (benamb_id,datpro_id)"
			." values ("
			."$this->benamb_id,$this->datpro_id)";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del benambxpries insertado, benamb_id
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
 	$aux=new c_benambxpri($this->con);
 	$aux->info($id);
  	
  	$this->cad2id($id);
  	$sql="delete from benambxpri "
		."where benamb_id=$this->benamb_id and datpro_id=$this->datpro_id ";
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
  
  function delall($datpro)
  {
    $sql="delete from benambxpri where datpro_id=$datpro ";
    $rs=&$this->con->Execute($sql);
    $oaux=new c_priorizacionProyecto($this->con,"udenor");
	$oaux->actFechaAudit($datpro);
  }
  
  function update($id)
  {
	$aux=new c_benambxpri($this->con);
	$res=$aux->info($id);
	
	if($res!=0)
  	{
	  $this->cad2id($id);
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE benambxpri "
		  ."set "
		  ."datpro_id='$this->datpro_id',"
		  ."borrar='$this->borrar' "
		  ."WHERE benamb_id=$this->benamb_id and borrar=$this->borrar ";
	  /*
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    return $id;
	  }	  
	  else
	    return 0;	
	  */
	  $oaux=new c_priorizacionProyecto($this->con,"udenor");
	  $oaux->actFechaAudit($aux->datpro_id);
	  return ($id);
  	}
  	else 
  	  return ($id);
  }

  function info($id)
  {
  	$this->cad2id($id);
  	
  	$sql="select benamb_id,datpro_id "
  		."from benambxpri "
  		."where benamb_id=$this->benamb_id and datpro_id=$this->datpro_id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->benamb_id=$rs->fields[0];
  	  $this->datpro_id=$rs->fields[1];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function cuantos($id)
  {
    $sql="select count(datpro_id) from benambxpri "
    	."where datpro_id=$id ";
    $rs=&$this->con->Execute($sql);
    $res=$rs->fields[0];
    return($res);	
  }
  
}
?>