<?php
//clase para ingreso_proyecto
/**
 * Clase usada para el manejo de la tabla ingreso_proyecto
 *
 */
class c_ingresoProyecto
{
  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  var $ingpro_codigo;
  var $ingpro_usuario;
  var $ingpro_fecha;
  var $ingpro_nrodptotecnico;
  var $ingpro_nrorecepcion;
  
  var $ingpro_nrodocint;
  var $ingpro_empentrega;
  var $ingpro_nroproyectos;
  
  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  var $con;
  
  var $msg;
  var $hora;
  
  /**
   * Enter description here...
   *
   * @var unknown_type
   */
  var $fcorta;
  var $flarga;

  
  //constructor
  /**
   * Contructor de la clase c_ingresoProyecto
   *
   * @param BDD $conBd
   * @param Character $usuario
   * @return c_ingresoProyecto
   */
  function c_ingresoProyecto($conBd,$usuario)
  {
	  include_once("class/c_datoProyecto.php");
  	
  	  $this->ingpro_codigo=0;
	  $this->ingpro_usuario=$usuario;	  
	  $this->ingpro_fecha="";
	  $this->ingpro_nrodptotecnico="";
	  $this->ingpro_nrorecepcion="";
	  
	  $this->ingpro_nrodocint="";
	  $this->ingpro_empentrega=0;
	  $this->ingpro_nroproyectos=0;
	  
	  $this->con=&$conBd;
	  
	  $this->fcorta="%Y-%m-%d";
	  $this->flarga="%Y-%m-%d %H:%i:%S";
	  
	  $this->hora=date("H:i:s");
  }
    
//funciones para cargar datos desde un arreglo, no se carga id
  /**
   * Enter description here...
   *
   * @param unknown_type $dato
   */
  function cargar_dato($dato)			
  {
    $ncampos=6;
	if($ncampos==count($dato))
	{
	  $this->ingpro_fecha=$dato[0];      
      $this->ingpro_nrodptotecnico=$dato[1];
      $this->ingpro_nrorecepcion=$dato[2];
      $this->ingpro_nrodocint=$dato[3];
      $this->ingpro_empentrega=$dato[4];
      $this->ingpro_nroproyectos=$dato[5];
	} 
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_ingresoProyecto <br>";
  	echo "ingpro_codigo:".$this->ingpro_codigo."<br>";
	echo "ingpro_usuario:".$this->ingpro_usuario."<br>";	
	echo "ingpro_fecha:".$this->ingpro_fecha."<br>";
	echo "ingpro_nrodptotecnico:".$this->ingpro_nrodptotecnico."<br>";
	echo "ingpro_nrorecepcion:".$this->ingpro_nrorecepcion."<br>";
	
	echo "ingpro_nrodocint:".$this->ingpro_nrodocint."<br>";
	echo "ingpro_empentrega:".$this->ingpro_empentrega."<br>";
	echo "ingpro_nroproyectos:".$this->ingpro_nroproyectos."<br>";
	echo "<hr>";
  }  
  
  function validar()
  {
  	$sql="select ingpro_codigo from ingreso_proyecto "
  		."where date_format(ingpro_fecha,'%Y-%m-%d')='$this->ingpro_fecha' "
  		."and ingpro_nrodptotecnico='$this->ingpro_nrodptotecnico' "
  		."and ingpro_nrorecepcion='$this->ingpro_nrorecepcion' "
  		."and ingpro_nrodocint='$this->ingpro_nrodocint' ";
	$rs = &$this->con->Execute($sql);
	if(!$rs->EOF)
	  $res=$rs->fields[0];
	else
	  $res=0; 
	return ($res);
  }  
  
  //funciones con base de datos
  /**
   * Añade a la base de datos un nuevo registro en la tabla ingreso_proyecto
   *
   * @return ingpro_codigo/0
   */
  function add()
  {
  	$insertado=$this->validar();	
	if(!$insertado)
	{
	  $this->ingpro_fecha.=" ".$this->hora;
	  $sql="insert into ingreso_proyecto"
			." (ingpro_usuario,ingpro_fecha,ingpro_nrodptotecnico,ingpro_nrorecepcion,"
			."ingpro_nrodocint,ingpro_empentrega,ingpro_nroproyectos)"
			." values ("
			."'$this->ingpro_usuario','$this->ingpro_fecha','$this->ingpro_nrodptotecnico','$this->ingpro_nrorecepcion',"
			."'$this->ingpro_nrodocint','$this->ingpro_empentrega','$this->ingpro_nroproyectos')";
	  $rs = &$this->con->Execute($sql);
	  
	  if($rs)
	  {
	    //recuperar el id del ingreso_proyectoes insertado, ingpro_codigo
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
  
  function sepuedeeliminar($id)
  {
  	$odatpro=new c_datoProyecto($this->con);
  	$sql="select datpro_id from dato_proyecto "
  		."where ingpro_codigo=$id ";
  	$rs=&$this->con->Execute($sql);
  	$cont=0;
  	$acu=0;
  	while(!$rs->EOF)
  	{
  	  $datpro=$rs->fields[0];
  	  $acu+=$odatpro->sepuedeeliminar($datpro);	
  	  $cont++;
  	  $rs->MoveNext();
  	}
  	if($cont==$acu)
  	  $res=$id;
  	else
  	  $res=0;
  	return($res);    	
  }
  
  function del($id)
  {
 	if($this->sepuedeeliminar($id))
 	{
  	  $odatpro=new c_datoProyecto($this->con);
 	  $sqldp="select datpro_id from dato_proyecto "
  			."where ingpro_codigo=$id ";
  	  $rs=&$this->con->Execute($sqldp);
  	  while(!$rs->EOF)
  	  {
  	  	$datpro=$rs->fields[0];
  	  	$odatpro->del($datpro);
  	  	$rs->MoveNext();
  	  }
  	  
 	  $sql="delete from ingreso_proyecto "
		."where ingpro_codigo=$id ";
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
	$aux=new c_ingresoProyecto($this->con,$this->ingpro_usuario);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  $this->ingpro_fecha.=" ".$this->hora;
  	  
  	  $sql="UPDATE ingreso_proyecto "
		  ."set ingpro_fecha='$this->ingpro_fecha',"
		  ."ingpro_nrodptotecnico='$this->ingpro_nrodptotecnico',"
		  ."ingpro_nrorecepcion='$this->ingpro_nrorecepcion',"
		  ."ingpro_nrodocint='$this->ingpro_nrodocint',"
		  ."ingpro_empentrega='$this->ingpro_empentrega',"
		  ."ingpro_nroproyectos='$this->ingpro_nroproyectos' "
		  ."WHERE ingpro_codigo=$id";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    $this->msg="";
	    return $id;
	  }  
	  else
	  {
	    $this->msg="Error al actualizar datos";
	  	return 0;	
	  }
  	}
  	else
  	{
  	  $this->msg="Dato no existe y no se va a actualizar";
  	  return($id);
  	}
  }

  function info($id)
  {
  	$sql="select ingpro_usuario,date_format(ingpro_fecha,'$this->fcorta'),ingpro_nrodptotecnico,ingpro_nrorecepcion,"
  		."ingpro_nrodocint,ingpro_empentrega,ingpro_nroproyectos "
  		."from ingreso_proyecto "
  		."where ingpro_codigo=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->ingpro_codigo=$id;
  	  $this->ingpro_usuario=$rs->fields[0];
  	  $this->ingpro_fecha=$rs->fields[1];
  	  $this->ingpro_nrodptotecnico=$rs->fields[2];
  	  $this->ingpro_nrorecepcion=$rs->fields[3];
  	  $this->ingpro_nrodocint=$rs->fields[4];
  	  $this->ingpro_empentrega=$rs->fields[5];
  	  $this->ingpro_nroproyectos=$rs->fields[6];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function cuantos($id)
  {
  	$sql="select count(ingpro_codigo) from dato_proyecto "
  		."where ingpro_codigo=$id ";
  	$rs=&$this->con->Execute($sql);
  	return($rs->fields[0]);	    
  }
  
  /**
   * Retorna el nro de proyectos que se pueden ingresar aún a la carpeta
   *
   * @param ingpro_codigo $id
   * @return int
   */
  function disponibles($id)
  {
  	$aux=new c_ingresoProyecto($this->con,$this->ingpro_usuario);
  	$existe=$aux->info($id);
  	if($existe)
  	{
  	  $maximo=$aux->ingpro_nroproyectos;
  	  $tiene=$aux->cuantos($id);
  	  $res=$maximo-$tiene;	
  	}
  	else
  	{
  	  $res=0;	
  	}
  	return($res);
  } 
       
}
?>