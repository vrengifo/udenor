<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);
		require_once('includes/header.php');
	//	$username='mlara';
		$username=$session_username;
		buildmenu($username);
		buildsubmenu($id_aplicacion,0);
		buildsubmenufooter();
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
<center>
  Click en los submódulos para acceder a su requerimiento.
</center>
</body>
</html>
