<?php
//clase para calificacion_proyecto
/**
 * Clase usada para administrar los valores generados al calificar un proyecto una vez que han sido ingresados los valores de priorización
 *
 */
class c_calificacionProyecto
{
  var $datpro_id;
  
  var $cal_concordancia;
  var $cal_concordanciac;
  var $cal_concordanciaval;
  
  
  var $cal_beneficiosocial;
  var $cal_beneficiosocialc;
  var $cal_beneficiosocialval;
  
  var $cal_benecotir;
  var $cal_benecotirc;
  var $cal_benecotirval;
  
  var $cal_benecovan;
  var $cal_benecovanc;
  var $cal_benecovanval;
  
  var $cal_benecoga;
  var $cal_benecogac;
  var $cal_benecogaval;
  
  var $cal_vialidad;
  var $cal_vialidadc;
  var $cal_vialidadval;
  
  var $cal_contrapartida;
  var $cal_contrapartidac;
  var $cal_contrapartidaval;
  
  var $cal_ambiental;
  var $cal_ambientalc;
  var $cal_ambientalval;
  
  var $total_sobre;
  var $total_puntaje;
  
  var $usu_audit;
  var $usu_faudit;

  var $separador;
  
  var $con;
  var $debug;
  var $fcorta;

  
  //constructor
  function c_calificacionProyecto($conBd,$usuario)
  {
  	  include_once("class/c_objxpri.php");
  	  include_once("class/c_estavaproxpri.php");
  	  include_once("class/c_beneficioSocial.php");
  	  include_once("class/c_beneficioEconomico.php");
  	  include_once("class/c_viaparxpri.php");
  	  include_once("class/c_contrapartida.php");
  	  include_once("class/c_benambxpri.php");
  	  
  	
  	  $this->datpro_id=0;
  	  
  	  $this->total_sobre=48;
  	  
	  $this->cal_concordanciac="1";
	  $this->cal_beneficiosocialc="2";
	  $this->cal_benecotirc="3";
	  $this->cal_benecovanc="4";
	  $this->cal_benecogac="5";
	  $this->cal_vialidadc="6";
	  $this->cal_contrapartidac="7";
	  $this->cal_ambientalc="8";	
	  
	  $this->usu_faudit=date("Y-m-d");
	  $this->usu_audit=$usuario;
	  
	  $this->fcorta="%Y-%m-%d";
	  
	  $this->con=&$conBd;
	  
	  $this->separador=".";
	  $this->debug=0;
	  
	  if($this->debug==1)
	    $this->con->debug=true;
  }  
  
//funciones para cargar datos desde un arreglo, no se carga id
  function cargar_dato($dato)			
  {
    
  }
  
  function mostrar_dato()
  {
	echo "<hr>class c_calificacionProyecto <br>";
  	echo "datpro_id:".$this->datpro_id."<br>";
	echo "cal_concordancia:".$this->cal_concordancia."<br>";	
	echo "cal_concordanciac:".$this->cal_concordanciac."<br>";
	echo "cal_concordanciaval:".$this->cal_concordanciaval."<br>";
	
	echo "cal_beneficiosocial:".$this->cal_beneficiosocial."<br>";	
	echo "cal_beneficiosocialc:".$this->cal_beneficiosocialc."<br>";
	echo "cal_beneficiosocialval:".$this->cal_beneficiosocialval."<br>";
	
	echo "cal_benecotir:".$this->cal_benecotir."<br>";	
	echo "cal_benecotirc:".$this->cal_benecotirc."<br>";
	echo "cal_benecotirval:".$this->cal_benecotirval."<br>";
	
	echo "cal_benecovan:".$this->cal_benecovan."<br>";	
	echo "cal_benecovanc:".$this->cal_benecovanc."<br>";
	echo "cal_benecovanval:".$this->cal_benecovanval."<br>";
	
	echo "cal_benecoga:".$this->cal_benecoga."<br>";	
	echo "cal_benecogac:".$this->cal_benecogac."<br>";
	echo "cal_benecogaval:".$this->cal_benecogaval."<br>";
	
	echo "cal_vialidad:".$this->cal_vialidad."<br>";	
	echo "cal_vialidadc:".$this->cal_vialidadc."<br>";
	echo "cal_vialidadval:".$this->cal_vialidadval."<br>";
	
	echo "cal_contrapartida:".$this->cal_contrapartida."<br>";	
	echo "cal_contrapartidac:".$this->cal_contrapartidac."<br>";
	echo "cal_contrapartidaval:".$this->cal_contrapartidaval."<br>";
	
	echo "cal_ambiental:".$this->cal_ambiental."<br>";	
	echo "cal_ambientalc:".$this->cal_ambientalc."<br>";
	echo "cal_ambientalval:".$this->cal_ambientalval."<br>";
	
	echo "total_sobre:".$this->total_sobre."<br>";
	echo "total_puntaje:".$this->total_puntaje."<br>";
	
	echo "usu_audit:".$this->usu_audit."<br>";
	echo "usu_faudit:".$this->usu_faudit."<br>";
	echo "<hr>";
  }  
    
  function validar()
  {
  	$sql="select datpro_id from calificacion_proyecto "
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
	  $sql="insert into calificacion_proyecto"
		  ."(datpro_id,"
		  ."cal_concordancia,cal_concordanciaval,"
  		  ."cal_beneficiosocial,cal_beneficiosocialval,"
  		  ."cal_benecotir,cal_benecotirval,"
  		  ."cal_benecovan,cal_benecovanval,"
  		  ."cal_benecoga,cal_benecogaval,"
  		  ."cal_vialidad,cal_vialidadval,"
  		  ."cal_contrapartida,cal_contrapartidaval,"
  		  ."cal_ambiental,cal_ambientalval,"
  		  ."total_sobre,total_puntaje,"
  		  ."usu_audit,usu_faudit)"
		  ." values ("
		  ."$this->datpro_id,"
		  ."'$this->cal_concordancia',$this->cal_concordanciaval,"
		  ."'$this->cal_beneficiosocial',$this->cal_beneficiosocialval,"
		  ."'$this->cal_benecotir',$this->cal_benecotirval,"
		  ."'$this->cal_benecovan',$this->cal_benecovanval,"
		  ."'$this->cal_benecoga',$this->cal_benecogaval,"
		  ."'$this->cal_vialidad',$this->cal_vialidadval,"
		  ."'$this->cal_contrapartida',$this->cal_contrapartidaval,"
		  ."'$this->cal_ambiental',$this->cal_ambientalval,"
		  ."$this->total_sobre,$this->total_puntaje,"
		  ."'$this->usu_audit','$this->usu_faudit')";
	  $rs = &$this->con->Execute($sql);
	  if($rs)
	  {
	    //recuperar el id del calificacion_proyectoes insertado, datpro_id
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
 	$sql="delete from calificacion_proyecto "
		."where datpro_id=$id ";
	$rs = &$this->con->Execute($sql);
	if($rs)
	  return $id;
	else
	  return 0;  		
  }
  
  function update($id)
  {
	$aux=new c_calificacionProyecto($this->con,$this->usu_audit);
	$res=$aux->info($id);
  	if($res!=0)
  	{
  	  //actualiza todo menos el monto que es calculado
  	  $sql="UPDATE calificacion_proyecto "
		  ."set "
		  ."cal_concordancia='$this->cal_concordancia',cal_concordanciaval=$this->cal_concordancia,"
  		  ."cal_beneficiosocial,cal_beneficiosocialval,"
  		  ."cal_benecotir,cal_benecotirval,"
  		  ."cal_benecovan,cal_benecovanval,"
  		  ."cal_benecoga,cal_benecogaval,"
  		  ."cal_vialidad,cal_vialidadval,"
  		  ."cal_contrapartida,cal_contrapartidaval,"
  		  ."cal_ambiental,cal_ambientalval,"
  		  ."total_sobre,total_puntaje,"
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
  	$sql="select datpro_id,"
  		."cal_concordancia,cal_concordanciaval,"
  		."cal_beneficiosocial,cal_beneficiosocialval,"
  		."cal_benecotir,cal_benecotirval,"
  		."cal_benecovan,cal_benecovanval,"
  		."cal_benecoga,cal_benecogaval,"
  		."cal_vialidad,cal_vialidadval,"
  		."cal_contrapartida,cal_contrapartidaval,"
  		."cal_ambiental,cal_ambientalval,"
  		."total_sobre,total_puntaje,"
  		."usu_audit,date_format(usu_faudit,'$this->fcorta') "
  		."from calificacion_proyecto "
  		."where datpro_id=$id ";
  	$rs=&$this->con->Execute($sql);
  	if(!$rs->EOF)
  	{
  	  $this->datpro_id=$rs->fields[0];
  	  $this->cal_concordancia=$rs->fields[1];
  	  $this->cal_concordanciaval=$rs->fields[2];
  	  $this->cal_beneficiosocial=$rs->fields[3];
  	  $this->cal_beneficiosocialval=$rs->fields[4];
  	  $this->cal_benecotir=$rs->fields[5];
  	  $this->cal_benecotirval=$rs->fields[6];
  	  $this->cal_benecovan=$rs->fields[7];
  	  $this->cal_benecovanval=$rs->fields[8];
  	  $this->cal_benecoga=$rs->fields[9];
  	  $this->cal_benecogaval=$rs->fields[10];
  	  $this->cal_vialidad=$rs->fields[11];
  	  $this->cal_vialidadval=$rs->fields[12];
  	  $this->cal_contrapartida=$rs->fields[13];
  	  $this->cal_contrapartidaval=$rs->fields[14];
  	  $this->cal_ambiental=$rs->fields[15];
  	  $this->cal_ambientalval=$rs->fields[16];
  	  $this->total_sobre=$rs->fields[17];
  	  $this->total_puntaje=$rs->fields[18];
  	  
  	  $this->usu_audit=$rs->fields[19];
  	  $this->usu_faudit=$rs->fields[20];
  	  
  	  $res=$id;
    }
    else
      $res=0;
      
    return ($res);	
  }
  
  function sepuedeCalificar($id,&$cad)
  {
  	  $flag=0;
  	  
  	  //objetivos udenor
  	  $cobj=new c_objxpri($this->con);
  	  $objcuantos=$cobj->cuantos($id);
  	  if($objcuantos==0)
  	    $cad.="Objetivos Udenor: No cumple con los Objetivos de Udenor o no se han ingresado datos<br>";
  	
  	  //cantidad de beneficiarios directos
  	  $cbensoc=new c_beneficioSocial($this->con);
  	  $resbensoc=$cbensoc->info($id);
  	  if($resbensoc==0)
  	  {
  	  	$cad.="Beneficio Social: No se han ingresado datos<br>";
  	  	$flag+=1;
  	  }
  	
  	  //beneficio económico
  	  $cbeneco=new c_beneficioEconomico($this->con);
  	  $resbeneco=$cbeneco->info($id);
  	  if($resbeneco==0)
  	  {
  	  	$cad.="Beneficio Económico: No se han ingresado datos<br>";
  	  	$flag+=1;
  	  }

  	  //Vialidad
  	  $cvia=new c_viaparxpri($this->con);
  	  $valor=$cvia->cuantos($id);
  	  if($valor==0)
  	    $cad.="Vialidad Participativa: No tiene Vialidad Participativa o no se han ingresado datos<br>";
  	
  	  //Contrapartida
  	  $ccontra=new c_contrapartida($this->con);
  	  $rescontra=$ccontra->info($id);
  	  if($rescontra==0)
  	  {
  	  	$cad.="Contrapartida: No se han ingresado datos<br>";
  	  	$flag+=1;
  	  }
  	
  	  //Beneficio Ambiental
  	  $camb=new c_benambxpri($this->con);
  	  $valor=$camb->cuantos($id);
  	  if($valor==0)
  	    $cad.="Beneficio Ambiental: No tiene Beneficio Ambiental o no se han ingresado datos<br>";
  	  
  	  if($flag==0)
  	    $sepuede=1;
  	  else   
  	    $sepuede=0;  
  	  return($sepuede);  
  }
  
  function calificar($id,&$msg)
  {
  	if($this->sepuedeCalificar($id,$msg))
  	{  
  	  $this->datpro_id=$res=$id;
  	  
  	  //objetivos udenor
  	  $cobj=new c_objxpri($this->con);
  	  $objcuantos=$cobj->cuantos($id);
  	  $res=$this->buscarvalor($this->cal_concordanciac,$objcuantos);
  	  $this->cal_concordancia=$res["opc_id"];
  	  $this->cal_concordanciaval=$res["puntaje"];
  	
  	  //cantidad de beneficiarios directos
  	  $cbensoc=new c_beneficioSocial($this->con);
  	  $bendirectos=$cbensoc->porcentaje($id);
  	  $res=$this->buscarvalor($this->cal_beneficiosocialc,$bendirectos);
  	  $this->cal_beneficiosocial=$res["opc_id"];
  	  $this->cal_beneficiosocialval=$res["puntaje"];
  	
  	  //beneficio económico
  	  $cbeneco=new c_beneficioEconomico($this->con);
  	  //TIR
  	  $valor=$cbeneco->tir($id);
  	  $res=$this->buscarvalor($this->cal_benecotirc,$valor);
  	  $this->cal_benecotir=$res["opc_id"];
  	  $this->cal_benecotirval=$res["puntaje"];
  	
  	  //VAN
  	  $valor=$cbeneco->van($id);
  	  $res=$this->buscarvalor($this->cal_benecovanc,$valor);
  	  $this->cal_benecovan=$res["opc_id"];
  	  $this->cal_benecovanval=$res["puntaje"];
  	
  	  //Gastos Administrativos
  	  $valor=$cbeneco->ga($id);
  	  $res=$this->buscarvalor($this->cal_benecogac,$valor);
  	  $this->cal_benecoga=$res["opc_id"];
  	  $this->cal_benecogaval=$res["puntaje"];
  	
  	  //Vialidad
  	  $cvia=new c_viaparxpri($this->con);
  	  $valor=$cvia->cuantos($id);
  	  $res=$this->buscarvalor($this->cal_vialidadc,$valor);
  	  $this->cal_vialidad=$res["opc_id"];
  	  $this->cal_vialidadval=$res["puntaje"];
  	
  	  //Contrapartida
  	  $ccontra=new c_contrapartida($this->con);
  	  $valor=$ccontra->sumatoria($id);
  	  $res=$this->buscarvalor($this->cal_contrapartidac,$valor);
  	  $this->cal_contrapartida=$res["opc_id"];
  	  $this->cal_contrapartidaval=$res["puntaje"];
  	
  	  //Beneficio Ambiental
  	  $camb=new c_benambxpri($this->con);
  	  $valor=$camb->cuantos($id);
  	  $res=$this->buscarvalor($this->cal_ambientalc,$valor);
  	  $this->cal_ambiental=$res["opc_id"];
  	  $this->cal_ambientalval=$res["puntaje"];
  	
  	  $this->total_puntaje=$this->calculartotal();
  	  
  	  $this->crearoactualizar();
  	}
  	else 
  	  $res=0;

  	return($res);
  }
  
  function calculartotal()
  {
  	$tot=$this->cal_concordanciaval+$this->cal_beneficiosocialval+$this->cal_benecotirval;
  	$tot+=$this->cal_benecovanval+$this->cal_benecogaval+$this->cal_vialidadval;
  	$tot+=$this->cal_contrapartidaval+$this->cal_ambientalval;
  	return($tot);
  }
  
  function buscarvalor($item,$valor)
  {
  	$sql="select opc_id,opc_puntaje,opc_regla "
  		."from opcion "
  		."where ite_id='$item' ";
  	$rs=&$this->con->Execute($sql);
  	$cont=0;
  	$flag=0;
  	while((!$rs->EOF)&&(!$flag))
  	{
  	  $opcId[$cont]=$rs->fields[0];
  	  $puntaje[$cont]=$rs->fields[1];
  	  $regla[$cont]=explode(" ",$rs->fields[2]);
  	  
  	  $nreglas=count($regla[$cont]);
  	  if($nreglas==1)
  	    $cad2val="(".$valor.$regla[$cont][0].")";
  	  if($nreglas==2)
  	    $cad2val="("."(".$valor.$regla[$cont][0].") && "."(".$valor.$regla[$cont][1].")".")"; 
  	    
  	  $resval=$this->evaluar($cad2val);
  	  if($this->debug)
  	  {
  	    echo "cad2val:".$cad2val."<br>";  
  	  	echo "resval:".$resval;  
  	  }
  	  if($resval)
  	  {
  	  	$res["opc_id"]=$opcId[$cont];
  	  	$res["puntaje"]=$puntaje[$cont];
  	  	$flag=1;
  	  }
  	  $cont++;
  	  $rs->MoveNext();	
  	}
  	return($res);
  }
  
  function evaluar($cad)
  {
  	$sql="select $cad ";
  	$rs=&$this->con->Execute($sql);
  	$res=$rs->fields[0];
  	return($res);
  }
  
  
}
?>