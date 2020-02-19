<?php
//clase para dattecxent
/**
 * Clase usada para registrar los valores generados al ingresar las entidades y los montos que aportan al proyecto como dato técnico 
 *
 */
class c_dattecxent
{
  var $dattec_codigo;
  var $ent_codigo;
  
  var $dte_monto;
  var $mon_codigo;

  var $separador;
  
  var $con;

  
  //constructor
  function c_dattecxent($conBd)
  {
  	include_once("class/c_dpDatoTecnico.php");  
  	
  	$this->dattec_codigo=0;
	$this->ent_codigo="";
	$this->dte_monto="";
	  
	$this->mon_codigo="";
	
	$this->con=&$conBd;
	  
	$this->separador=":";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=3;
	if($ncampos==count($dato))
	{
	  //$this->dattec_codigo=$dato[0];
	  $this->ent_codigo=$dato[0];
	  $this->dte_monto=$dato[1];
	  $this->mon_codigo=$dato[2];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_dattecxent <br>";
  	echo "dattec_codigo:".$this->dattec_codigo."<br>";
	echo "ent_codigo:".$this->ent_codigo."<br>";	
	echo "dte_monto:".$this->dte_monto."<br>";
	echo "mon_codigo:".$this->mon_codigo."<br>";
	echo "<hr>";
  }  
    
  function cad2id($valor)
  {
  	list($this->dattec_codigo,$this->ent_codigo)=explode($this->separador,$valor);
  	return(1);
  }
  
  function id2cad($dat,$ent)
  {
  	$cad=$dat.$this->separador.$ent;
  	return($cad);
  }
  
  function validar()
  {
  	$sql="select dattec_codigo,ent_codigo from dattecxent "
  		."where dattec_codigo=$this->dattec_codigo and ent_codigo=$this->ent_codigo ";
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $dat=$rs->fields[0];
	  $ent=$rs->fields[1];
	  $res=$this->id2cad($dat,$ent);
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
    $cdt=new c_dpDatoTecnico($this->con);
    $cdt->actualizarmonto($this->dattec_codigo);
    return ($res);
  } 
  
  //funciones con base de datos
  function add()
  {
  	$insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into dattecxent"
			." (dattec_codigo,ent_codigo,mon_codigo,dte_monto)"
			." values ("
			."$this->dattec_codigo,$this->ent_codigo,'$this->mon_codigo','$this->dte_monto')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del dattecxentes insertado, dattec_codigo
	    $nid=$this->validar();
	    
	    $cdt=new c_dpDatoTecnico($this->con);
    	$cdt->actualizarmonto($this->dattec_codigo);
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
 	$this->cad2id($id);
  	$sql="delete from dattecxent "
		."where dattec_codigo=$this->dattec_codigo and ent_codigo=$this->ent_codigo ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	{
	  $cdt=new c_dpDatoTecnico($this->con);
	  $cdt->actualizarmonto($this->dattec_codigo);
	  return $id;
	}  
	else
	  return 0;  		
  }
  
  function delxdattec($dattec)
  {
  	$sql="delete from dattecxent "
		."where dattec_codigo=$dattec ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $dattec;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$aux=new c_dattecxent($this->con);
	$res=$aux->info($id);
	
  	if($res!=0)
  	{
	  $this->cad2id($id);
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE dattecxent "
		  ."set "
		  ."dte_monto='$this->dte_monto',"
		  ."mon_codigo='$this->mon_codigo' "
		  ."WHERE dattec_codigo=$this->dattec_codigo and ent_codigo=$this->ent_codigo ";
  //	echo "<br>$sql <br>";
  //	$this->mostrar_dato();		
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    $cdt=new c_dpDatoTecnico($this->con);
    	$cdt->actualizarmonto($this->dattec_codigo);
	  	
    	return ($id);
	  }	  
	  else
	    return 0;	
  	}
  	else 
  	  return ($id);
  }

  function info($id)
  {
  	$this->cad2id($id);
  	
  	$sql="select dattec_codigo,ent_codigo,dte_monto,mon_codigo "
  		."from dattecxent "
  		."where dattec_codigo=$this->dattec_codigo and ent_codigo=$this->ent_codigo ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->dattec_codigo=$rs->fields[0];
  	  $this->ent_codigo=$rs->fields[1];
  	  $this->dte_monto=$rs->fields[2];
  	  $this->mon_codigo=$rs->fields[3];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
}
?>