<?php session_start(); ?>
<? include('includes/main.php'); ?>
<? include('adodb/tohtml.inc.php'); ?>
<?php

		extract($_REQUEST);		
		require_once('includes/header.php');
		$username=$session_username;
		//buildmenu($username);
		//buildsubmenu($id_aplicacion,$id_subaplicacion);
	?>
	
	<br>
	Under Construction!!!

<?php
  $sql="select * from usuario_aux ";
  $conn->debug=true;
  $rs=$conn->Execute($sql);		
  //echo $rs->RecordCount()."<br>";
  build_table($rs,false,false,"titulo","","50%",true);
  buildsubmenufooter();		
		//rs2html($recordSet,"border=3 bgcolor='#effee'");
		
?>
</body>
</html>
