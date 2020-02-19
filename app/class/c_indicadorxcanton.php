<?php
//clase para indicadorxcanton
/**
 * Clase usada para administrar los valores que toma un indicador con respecto a un cantón
 *
 */
class c_indicadorxcanton
{
  var $can_codigo;
  var $ind_codigo;
  
  var $indxcan_valor;
  
  var $separador;
  
  var $con;
  var $msg;

  
  //constructor
  function c_indicadorxcanton($conBd)
  {
  	  $this->can_codigo=0;
	  $this->ind_codigo="";
	  $this->indxcan_valor="";
	    
	  $this->con=&$conBd;
	  
	  $this->separador=":";
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=3;
	if($ncampos==count($dato))
	{
	  $this->can_codigo=$dato[0];
	  $this->ind_codigo=$dato[1];
	  $this->indxcan_valor=$dato[2];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_indicadorxcanton <br>";
  	echo "can_codigo:".$this->can_codigo."<br>";
	echo "ind_codigo:".$this->ind_codigo."<br>";	
	echo "indxcan_valor:".$this->indxcan_valor."<br>";
	echo "<hr>";
  }  
    
  function cad2id($valor)
  {
  	list($this->can_codigo,$this->ind_codigo)=explode($this->separador,$valor);
  	return(1);
  }
  
  function id2cad($can,$ind)
  {
  	$cad=$can.$this->separador.$ind;
  	return($cad);
  }
  
  function validar()
  {
  	$sql="select can_codigo,ind_codigo from indicadorxcanton "
  		."where can_codigo=$this->can_codigo and ind_codigo='$this->ind_codigo' ";
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $can=$rs->fields[0];
	  $ind=$rs->fields[1];
	  $res=$this->id2cad($can,$ind);
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
	  $sql="insert into indicadorxcanton"
			." (can_codigo,ind_codigo,indxcan_valor)"
			." values ("
			."$this->can_codigo,'$this->ind_codigo','$this->indxcan_valor')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del indicadorxcantones insertado, can_codigo
	    $nid=$this->validar();
	    $this->msg="";
	  }
	  else
	  {
	    $nid=0;
	    $this->msg="Error al crear dato";
	  }  
	}
	else
	{
	  $nid=0;
	  $this->msg="Dato ya existe";
	}  
	  
	return($nid);
  }
  
  function del($id)
  {
 	$this->cad2id($id);
  	$sql="delete from indicadorxcanton "
		."where can_codigo=$this->can_codigo and ind_codigo='$this->ind_codigo' ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$aux=new c_indicadorxcanton($this->con);
	$res=$aux->info($id);
	
	$this->msg="";
	
  	if($res!=0)
  	{
	  $this->cad2id($id);
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE indicadorxcanton "
		  ."set "
		  ."indxcan_valor='$this->indxcan_valor' "
		  ."WHERE can_codigo=$this->can_codigo and ind_codigo='$this->ind_codigo' ";
  //	echo "<br>$sql <br>";
  //	$this->mostrar_dato();		
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    return ($id);
	  }	  
	  else
	  {
	    $this->msg="Error al actualizar dato";
	  	return (0);	
	  }
  	}
  	else 
  	{
  	  $this->msg="Dato no existe y no se va a actualizar";
  	  return ($id);
  	}
  }

  function info($id)
  {
  	$this->cad2id($id);
  	
  	$sql="select can_codigo,ind_codigo,indxcan_valor "
  		."from indicadorxcanton "
  		."where can_codigo=$this->can_codigo and ind_codigo='$this->ind_codigo' ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->can_codigo=$rs->fields[0];
  	  $this->ind_codigo=$rs->fields[1];
  	  $this->indxcan_valor=$rs->fields[2];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
}
?>