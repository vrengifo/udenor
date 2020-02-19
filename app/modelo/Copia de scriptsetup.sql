/* Tipos de Usuario */
insert into tipo_usuario (tipusu_codigo,tipusu_nombre) values ('T','Técnico');
insert into tipo_usuario (tipusu_codigo,tipusu_nombre) values ('A','Administrador');
insert into tipo_usuario (tipusu_codigo,tipusu_nombre) values ('N','Usuario Normal');
/* Usuario Administrador */
insert into usuario (usu_codigo,tipusu_codigo,usu_clave,usu_nombre) values ('admin','A','admin','Administrador del Sistema');
/* Aplicaciones */
insert into aplicacion values (1,'Setup','aSetup.php','s360.gif',1);
insert into aplicacion values (2,'Usuario','aUsuario.php','s360.gif',2);
insert into aplicacion values (3,'Tabla Sistema','aSistema.php','s360.gif',3);
insert into aplicacion values (4,'Proyecto','aProyecto.php','s360.gif',4);
insert into aplicacion values (5,'Proyecto - Técnico','aTProyecto.php','s360.gif',5);
insert into aplicacion values (6,'Consulta','aConsulta.php','s360.gif',6);
/* Subaplicaciones */
/* Setup */
insert into subaplicacion values (0,1,'Módulos','application.php','images/360/pubfile.gif',1);
insert into subaplicacion values (0,1,'Submódulos','subapplication.php','images/360/pubfile.gif',2);
/* Usuario */
insert into subaplicacion values (0,2,'Tipo Usuario','user.php','images/360/person.gif',1);
insert into subaplicacion values (0,2,'Usuario','user.php','images/360/person.gif',2);
insert into subaplicacion values (0,2,'Usuario - Módulo','user_modu.php','images/360/person.gif',3);
/* Tabla Sistema */
insert into subaplicacion values (0,3,'Empleado','empleado.php','images/360/person.gif',1);
insert into subaplicacion values (0,3,'Componente','componente.php','images/360/person.gif',2);
insert into subaplicacion values (0,3,'Subcomponente','subcomponente.php','images/360/person.gif',3);
insert into subaplicacion values (0,3,'Tipo Proyecto','tipoproyecto.php','images/360/person.gif',4);
insert into subaplicacion values (0,3,'Estado Proyecto','estadoproyecto.php','images/360/person.gif',5);
insert into subaplicacion values (0,3,'Provincia','provincia.php','images/360/person.gif',6);
insert into subaplicacion values (0,3,'Cantón','canton.php','images/360/person.gif',7);
insert into subaplicacion values (0,3,'Parroquia','parroquia.php','images/360/person.gif',8);
insert into subaplicacion values (0,3,'Estado Desarrollo Pro.','estadodesarrollo.php','images/360/person.gif',9);
insert into subaplicacion values (0,3,'Moneda','moneda.php','images/360/person.gif',10);
insert into subaplicacion values (0,3,'Tipo Entidad','tipoentidad.php','images/360/person.gif',11);
insert into subaplicacion values (0,3,'Entidad','entidad.php','images/360/person.gif',12);
insert into subaplicacion values (0,3,'Tipo Documento','tipodocumento.php','images/360/person.gif',13);
insert into subaplicacion values (0,3,'Parámetros','parametro.php','images/360/person.gif',14);
/* Proyecto */
insert into subaplicacion values (0,4,'Ingreso Proyectos','proyecto.php','images/360/pubfile.gif',1);
insert into subaplicacion values (0,4,'Consultas','consulingpro.php','images/360/pubfile.gif',2);
/* Proyecto Técnico */
insert into subaplicacion values (0,5,'Calificación Proyecto','calificaproyecto.php','images/360/pubfile.gif',1);
insert into subaplicacion values (0,5,'Consultas','consultecpro.php','images/360/pubfile.gif',2);
/* Consultas */
insert into subaplicacion values (0,6,'Búsqueda Simple','buscasimple.php','images/360/pubfile.gif',1);
insert into subaplicacion values (0,6,'Búsqueda Compleja','buscacompleja.php','images/360/pubfile.gif',2);
/* Usuario x Aplicacion */
insert into usuario_aplicacion values ('admin',1);
insert into usuario_aplicacion values ('admin',2);
insert into usuario_aplicacion values ('admin',3);
insert into usuario_aplicacion values ('admin',4);
insert into usuario_aplicacion values ('admin',5);
insert into usuario_aplicacion values ('admin',6);