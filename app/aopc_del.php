<?php 
  session_start();
  include('includes/main.php');
  include('adodb/tohtml.inc.php');
  include("class/c_opcion.php");
  
  extract($_REQUEST);		

  //pv
  $cait=new c_opcion($conn);

  for($i=0;$i<$total;$i++)
  {
    if(isset($chc[$i]))
    {
  	  $id=$chc[$i];
	  //echo "borrar $id <br>";	
	  $cait->del($id);
    }
  }

  //destino
  $cextra=explode("|",$cextra);
  $t_cextra=count($cextra);
  $cad_dest="";
  for ($i=0;$i<$t_cextra;$i++)
  {
	$c1=$cextra[$i];
	if($c1=="principal")
	  $destino="location:".$$c1."?";
	else	
	  $cad_dest.=$c1."=".$$c1."&";
	//echo "c1 $c1 -- ".$$c1." <br>";  
  }
  $cad_dest=substr($cad_dest,0,(strlen($cad_dest)-1));
  $destino=$destino.$cad_dest;
  header($destino);

?>