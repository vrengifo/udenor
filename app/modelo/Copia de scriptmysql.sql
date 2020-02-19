/* ============================================================ */
/*   Database name:  MODEL_1                                    */
/*   DBMS name:      Mysql		                        */
/*   Created on:     27/02/2005  1:03                           */
/* ============================================================ */

/* ============================================================ */
/*   Table: PARAMETRO                                           */
/* ============================================================ */
create table PARAMETRO
(
    PAR_IMGECU             varchar(220)                  
);

/* ============================================================ */
/*   Table: APLICACION                                          */
/* ============================================================ */
create table APLICACION
(
    ID_APLICACION          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    NOMBRE_APLICACION      varchar(100)                  ,
    FILE_APLICACION        varchar(100)                  ,
    IMAGEN_APLICACION      varchar(100)                  ,
    ORDEN_APLICACION       int(3) UNSIGNED DEFAULT "0"   ,
    primary key (ID_APLICACION),
    unique (ID_APLICACION),
    index (ID_APLICACION)
);

/* ============================================================ */
/*   Table: COMPONENTE                                          */
/* ============================================================ */
create table COMPONENTE
(
    COM_CODIGO             varchar(3)            not null,
    COM_DESCRIPCION        varchar(100)          not null,
    primary key (COM_CODIGO),
    unique (COM_CODIGO),
    index (COM_CODIGO)
);

/* ============================================================ */
/*   Table: PROVINCIA                                           */
/* ============================================================ */
create table PROVINCIA
(
    PRO_CODIGO             int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    PRO_NOMBRE             varchar(50)           not null,
    PRO_FOTO               varchar(220)                  ,
    primary key (PRO_CODIGO),
    unique (PRO_CODIGO),
    index (PRO_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO_USUARIO                                        */
/* ============================================================ */
create table TIPO_USUARIO
(
    TIPUSU_CODIGO          varchar(2)            not null,
    TIPUSU_NOMBRE          varchar(30)           not null,
    primary key (TIPUSU_CODIGO),
    unique (TIPUSU_CODIGO),
    index (TIPUSU_CODIGO)
);

/* ============================================================ */
/*   Table: EMPLEADO                                            */
/* ============================================================ */
create table EMPLEADO
(
    EMP_CODIGO             int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    EMP_NOMBRE             varchar(100)          not null,
    primary key (EMP_CODIGO),
    unique (EMP_CODIGO),
    index (EMP_CODIGO)
);

/* ============================================================ */
/*   Table: ESTADO_PROYECTO                                     */
/* ============================================================ */
create table ESTADO_PROYECTO
(
    EST_CODIGO             int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    EST_NOMBRE             varchar(30)           not null,
    primary key (EST_CODIGO),
    unique (EST_CODIGO),
    index (EST_CODIGO)
);

/* ============================================================ */
/*   Table: ENTIDAD                                             */
/* ============================================================ */
create table ENTIDAD
(
    ENT_CODIGO             int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    ENT_NOMBRE             varchar(100)          not null,
    primary key (ENT_CODIGO),
    unique (ENT_CODIGO),
    index (ENT_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO_ENTIDAD                                        */
/* ============================================================ */
create table TIPO_ENTIDAD
(
    TIPENT_CODIGO          varchar(3)            not null,
    TIPENT_NOMBRE          varchar(100)          not null,
    TIPENT_ORDEN           int(10)                       ,
    primary key (TIPENT_CODIGO),
    unique (TIPENT_CODIGO),
    index (TIPENT_CODIGO)
);

/* ============================================================ */
/*   Table: MONEDA                                              */
/* ============================================================ */
create table MONEDA
(
    MON_CODIGO             varchar(10)           NOT NULL,
    MON_NOMBRE             varchar(50)           not null,
    MON2DOLAR              numeric(5,5)          not null,
    primary key (MON_CODIGO),
    unique (MON_CODIGO),
    index (MON_CODIGO)
);

/* ============================================================ */
/*   Table: ESTADO_DESARROLLO                                   */
/* ============================================================ */
create table ESTADO_DESARROLLO
(
    ESTDES_CODIGO          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    ESTDES_NOMBRE          varchar(100)          not null,
    primary key (ESTDES_CODIGO),
    unique (ESTDES_CODIGO),
    index (ESTDES_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO_DOCUMENTO                                      */
/* ============================================================ */
create table TIPO_DOCUMENTO
(
    TIPDOC_CODIGO          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    TIPDOC_NOMBRE          varchar(30)           not null,
    primary key (TIPDOC_CODIGO),
    unique (TIPDOC_CODIGO),
    index (TIPDOC_CODIGO)
);

/* ============================================================ */
/*   Table: PROYECTO                                            */
/* ============================================================ */
create table PROYECTO
(
    PRO_CODIGO             varchar(3)            not null,
    COM_CODIGO             varchar(3)                    ,
    PRO_DESCRIPCION        varchar(100)          not null,
    primary key (PRO_CODIGO),
    unique (PRO_CODIGO),
    index (PRO_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO                                                */
/* ============================================================ */
create table TIPO
(
    TIP_CODIGO             varchar(3)            not null,
    PRO_CODIGO             varchar(3)                    ,
    TIP_DESCRIPCION        varchar(100)          not null,
    TIP_DESDE              int(10)               not null,
    TIP_HASTA              int(10)               not null,
    TIP_ACTUAL             int(10)               not null,
    primary key (TIP_CODIGO),
    unique (TIP_CODIGO),
    index (TIP_CODIGO)
);

/* ============================================================ */
/*   Table: DATO_PROYECTO                                       */
/* ============================================================ */
create table DATO_PROYECTO
(
    DATPRO_ID              int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    INGPRO_CODIGO          int(10)               not null,
    COM_CODIGO             varchar(3)            not null,
    PRO_CODIGO             varchar(3)            not null,
    TIP_CODIGO             varchar(3)            not null,
    EST_CODIGO             int(10)                       ,
    DATPRO_CODIGO          varchar(20)           not null,
    DATPRO_NOMBRE          varchar(100)          not null,
    primary key (DATPRO_ID),
    unique (DATPRO_ID),
    index (DATPRO_ID)
);

/* ============================================================ */
/*   Table: DP_DATOTECNICO                                      */
/* ============================================================ */
create table DP_DATOTECNICO
(
    DATTEC_CODIGO          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    DATPRO_ID              int(10)                       ,
    ESTDES_CODIGO          int(10)                       ,
    DATTEC_FINICIO         date                          ,
    DATTEC_FFINAL          date                          ,
    DATTEC_DURACION        varchar(100)                  ,
    DATTEC_BENEFICIARIO    int(10)                       ,
    DATTEC_MONTO           numeric(20,2)                 ,
    MON_CODIGO             varchar(10)                   ,
    primary key (DATTEC_CODIGO),
    unique (DATTEC_CODIGO),
    index (DATTEC_CODIGO)
);

/* ============================================================ */
/*   Table: CANTON                                              */
/* ============================================================ */
create table CANTON
(
    CAN_CODIGO             int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    PRO_CODIGO             int(10)                       ,
    CAN_NOMBRE             varchar(50)           not null,
    CAN_FOTO               varchar(220)                  ,
    primary key (CAN_CODIGO),
    unique (CAN_CODIGO),
    index (CAN_CODIGO)
);

/* ============================================================ */
/*   Table: PARROQUIA                                           */
/* ============================================================ */
create table PARROQUIA
(
    PAR_CODIGO             int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    CAN_CODIGO             int(10)                       ,
    PAR_NOMBRE             varchar(50)           not null,
    PAR_FOTO               varchar(220)                  ,
    PAR_POBLACION          int(10)  UNSIGNED DEFAULT "0" not null,
    primary key (PAR_CODIGO),
    unique (PAR_CODIGO),
    index (PAR_CODIGO)
);

/* ============================================================ */
/*   Table: USUARIO                                             */
/* ============================================================ */
create table USUARIO
(
    USU_CODIGO             varchar(15)           not null,
    TIPUSU_CODIGO          varchar(2)                    ,
    USU_CLAVE              varchar(15)           not null,
    USU_NOMBRE             varchar(100)                  ,
    primary key (USU_CODIGO),
    unique (USU_CODIGO),
    index (USU_CODIGO)
);

/* ============================================================ */
/*   Table: INGRESO_PROYECTO                                    */
/* ============================================================ */
create table INGRESO_PROYECTO
(
    INGPRO_CODIGO          int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    INGPRO_USUARIO         varchar(15)                   ,
    INGPRO_FECHA           datetime              not null,
    INGPRO_NRODPTOTECNICO  varchar(20)                   ,
    INGPRO_NRORECEPCION    varchar(20)                   ,
    INGPRO_NRODOCINT       varchar(20)                   ,
    INGPRO_EMPENTREGA      int(10)                       ,
    INGPRO_NROPROYECTOS    int(10)                       ,
    primary key (INGPRO_CODIGO),
    unique (INGPRO_CODIGO),
    index (INGPRO_CODIGO)
);

/* ============================================================ */
/*   Table: SUBAPLICACION                                       */
/* ============================================================ */
create table SUBAPLICACION
(
    ID_SUBAPLICACION       int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    ID_APLICACION          int(10)                       ,
    NOMBRE_SUBAPLICACION   varchar(100)                  ,
    FILE_SUBAPLICACION     varchar(250)                  ,
    IMAGEN_SUBAPLICACION   varchar(250)                  ,
    ORDEN_SUBAPLICACION    int(3) UNSIGNED DEFAULT "0"   ,
    primary key (ID_SUBAPLICACION),
    unique (ID_SUBAPLICACION),
    index (ID_SUBAPLICACION)
);

/* ============================================================ */
/*   Table: USUARIO_APLICACION                                  */
/* ============================================================ */
create table USUARIO_APLICACION
(
    USU_CODIGO             varchar(15)                   ,
    ID_APLICACION          int(10)                       
);

/* ============================================================ */
/*   Table: DP_UBICACION                                        */
/* ============================================================ */
create table DP_UBICACION
(
    UBI_CODIGO             int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    DATPRO_ID              int(10)               not null,
    PRO_CODIGO             int(10)               not null,
    CAN_CODIGO             int(10)               not null,
    PAR_CODIGO             int(10)               not null,
    UBI_COMUNIDAD          blob                          ,
    UBI_OBSERVACION        blob                          ,
    primary key (UBI_CODIGO),
    unique (UBI_CODIGO),
    index (UBI_CODIGO)
);

/* ============================================================ */
/*   Table: DATTECXENT                                          */
/* ============================================================ */
create table DATTECXENT
(
    DATTEC_CODIGO          int(10)                       ,
    MON_CODIGO             varchar(10)                   ,
    ENT_CODIGO             int(10)                       ,
    DTE_MONTO              numeric(20,2)         not null,
    primary key (DATTEC_CODIGO, ENT_CODIGO),
    unique (DATTEC_CODIGO, ENT_CODIGO),
    index (DATTEC_CODIGO, ENT_CODIGO)
);

/* ============================================================ */
/*   Table: DP_ENTIDADES                                        */
/* ============================================================ */
create table DP_ENTIDADES
(
    ENT_CODIGO             int(10)               not null,
    TIPENT_CODIGO          varchar(3)            not null,
    DATPRO_ID              int(10)                       ,
    primary key (ENT_CODIGO, TIPENT_CODIGO),
    unique (ENT_CODIGO, TIPENT_CODIGO),
    index (ENT_CODIGO, TIPENT_CODIGO)
);

/* ============================================================ */
/*   Table: DP_DOCUMENTACION                                    */
/* ============================================================ */
create table DP_DOCUMENTACION
(
    DOC_CODIGO             int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    TIPDOC_CODIGO          int(10)                       ,
    DATPRO_ID              int(10)                       ,
    DOC_CODIGOSIS          varchar(50)           not null,
    DOC_NOMBRE             varchar(100)          not null,
    DOC_PATH               varchar(200)                  ,
    primary key (DOC_CODIGO),
    unique (DOC_CODIGO),
    index (DOC_CODIGO)
);

