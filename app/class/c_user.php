<?php
//clase para user
/**
 * Clase usada para administrar los usuarios del sistema
 *
 */
class c_user
{
  var $usu_codigo;
  var $usu_clave;
  var $usu_nombre;  
  var $tipusu_codigo;//tipo de usuario
  
  var $msg;
  
  var $con;//conexión a base de datos

  
  //constructor
  function c_user($conBd)
  {
	  $this->usu_codigo="";
	  $this->usu_clave="";	  
	  $this->usu_nombre="";	  
      $this->tipusu_codigo="";
      $this->con=&$conBd;
  }  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    $ncampos=4;
	if($ncampos==count($dato))
	{
      $this->usu_codigo=$dato[0];
	  $this->usu_clave=$dato[1];      
      $this->usu_nombre=$dato[2];      
      $this->tipusu_codigo=$dato[3];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>";
	echo "clase c_user <br>";
  	echo "usu_codigo: ".$this->usu_codigo."<br>";
	echo "usu_clave: ".$this->usu_clave."<br>";	
	echo "usu_nombre: ".$this->usu_nombre."<br>";
    echo "tipusu_codigo: ".$this->tipusu_codigo."<br>";
    echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select usu_codigo from usuario where usu_codigo='$this->usu_codigo'";
	$rs = &$this->con->Execute($sql);	
	if($rs->EOF)
	  $cuantos=0;
	else  
	  $cuantos=$rs->fields[0];
	return ($cuantos);
  }
  
  function buscarxNombre($nombre)
  {
  	$sql="select usu_codigo from usuario where usu_nombre='$nombre'";
	$rs = &$this->con->Execute($sql);
	if($rs->EOF)
	  $cuantos=0;
	else  
	  $cuantos=$rs->fields[0];
	return ($cuantos);
  }
  
  //funciones con base de datos
  function add()
  {
    $insertado=$this->validar();	
	if(!$insertado)
	{
	  $sql="insert into usuario"
			." (usu_codigo,usu_clave,usu_nombre,tipusu_codigo)"
			." values ("
			."'$this->usu_codigo','$this->usu_clave','$this->usu_nombre','$this->tipusu_codigo')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	$res=$this->usu_codigo;
	  	$this->msg="";
	  }
	  else
	  {
	  	$res=0;
	  	$this->msg="Error al crear dato";
	  }
	}
	else
	{
	  $res=$insertado;
      $this->msg="Dato ya existe";	
	}
	return($res); 
  }
  
  function del($id)
  {
 	$sql="delete from usuario "
			."where usu_codigo='$id' ";
	//echo "<hr>$sql<hr>";		
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$this->msg="";
	
  	$oaux=new c_user($this->con);
	$oaux1=new c_user($this->con);
  	
	$existe=$oaux->info($id);
	$existeNombre=$oaux1->buscarxNombre($this->usu_nombre);
	
  	if($existe)
  	{
  	  $sql="UPDATE usuario"
			." set usu_clave='$this->usu_clave',";
	  if(!$existeNombre)
		$sql.="usu_nombre='$this->usu_nombre',";
	  else
	    $this->msg="Nombre ya existe";	
	  $sql.="tipusu_codigo='$this->tipusu_codigo' "
			." WHERE usu_codigo='$id'";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	  	return ($id);
	  }
	  else
	  {
	    $this->msg="Error al actualizar datos";
	  	return($id);
	  }
    }
    else
    {
      $this->msg="Dato no existe y no se va a actualizar";
	  return($id);	
    }
  }    

  /**
  * @return unknown
  * @param $vuser unknown
  * @param $npass unknown
  * @desc Enter description here...  
 */
  function cambiar_clave($vuser,$npass)
  {
    $sql="update usuario set usu_clave='$npass' where usu_codigo='$vuser' ";
	$rs=&$this->con->Execute($sql);
	if($rs)
	  return 1;
	else
	  return 0;  
  }

  function verificar_user($vuser,$vpass)
  {
    $sql="select count(usu_codigo) from usuario where usu_codigo='$vuser' and usu_clave='$vpass'  ";
	$rs=&$this->con->Execute($sql);
	if($rs)
    {
      $resultado=$rs->fields[0];
      if($resultado==1)
      {
       return 1;
      }
      else
      {
        return 0;
      }
    }
  }
     
  function recuperar_dato($vuser)
  {
    $sql="select usu_codigo,usu_clave,usu_nombre,tipusu_codigo from usuario  "
		."where usu_codigo='$vuser'";
	$rs=&$this->con->Execute($sql);
	if(!$rs->EOF)
	{
	  $this->usu_codigo=$rs->fields[0];
	  $this->usu_clave=$rs->fields[1];
	  $this->usu_nombre=$rs->fields[2];
	  $this->tipusu_codigo=$rs->fields[3];	
	  $res=1;
	}
	else
	  $res=0;
	return ($res);	
  }

  function info($id)
  {
    $res=$this->recuperar_dato($id);
    return($res);
  } 
}
?>
