<?php
 session_start();
 include('includes/main.php');
 include('adodb/tohtml.inc.php');
 include("class/c_user.php");
?>
<?php

		extract($_REQUEST);		

		$username=$session_username;
/*		require_once('includes/header.php');
		buildmenu($username);
		buildsubmenu($id_aplicacion,$id_subaplicacion);
*/

?>
<?php
//pv
$cait=new c_user($conn);

//recuperar todos los datos de la otra forma
$destino="location:change_password2.php";

if($pass1==$pass2)
{ 
 $res=$cait->cambiar_clave($username,$pass1);
}
else
{
 $res=0;
}

$destino.="?res=".$res;

header($destino);

?>	
	<br>
<?php
		buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
