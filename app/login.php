<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php
		extract($_REQUEST);
		include("class/c_user.php");
		$objeto=new c_user($conn);
		$res=$objeto->verificar_user($username,$password);
		//$query="select * from usuario where usu_codigo='".$username."'";
		//$query.=" and usu_clave='".$password."'"; 
        //$recordSetuser = &$conn->Execute($query);
        //if (!$recordSetuser||$recordSetuser->EOF)
		if (!$res)
        {        
			header("location:index.php?reason=bad");
		}
		//registrar las variables de sesion necesarias
		session_start();
		session_register('session_username');
		$session_username=$username;
		
		require_once('includes/header.php');
		buildmenu($username);
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
<? include('includes/footer.php'); ?>