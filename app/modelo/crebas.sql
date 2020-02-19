/* ============================================================ */
/*   Database name:  MODEL_1                                    */
/*   DBMS name:      Sybase AS Anywhere 6                       */
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
    ID_APLICACION          integer               not null,
    NOMBRE_APLICACION      varchar(100)                  ,
    FILE_APLICACION        varchar(100)                  ,
    IMAGEN_APLICACION      varchar(100)                  ,
    primary key (ID_APLICACION)
);

/* ============================================================ */
/*   Table: COMPONENTE                                          */
/* ============================================================ */
create table COMPONENTE
(
    COM_CODIGO             varchar(3)            not null,
    COM_DESCRIPCION        varchar(100)          not null,
    primary key (COM_CODIGO)
);

/* ============================================================ */
/*   Table: PROVINCIA                                           */
/* ============================================================ */
create table PROVINCIA
(
    PRO_CODIGO             integer               not null,
    PRO_NOMBRE             varchar(50)           not null,
    PRO_FOTO               varchar(220)                  ,
    primary key (PRO_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO_USUARIO                                        */
/* ============================================================ */
create table TIPO_USUARIO
(
    TIPUSU_CODIGO          varchar(2)            not null,
    TIPUSU_NOMBRE          varchar(30)           not null,
    primary key (TIPUSU_CODIGO)
);

/* ============================================================ */
/*   Table: EMPLEADO                                            */
/* ============================================================ */
create table EMPLEADO
(
    EMP_CODIGO             integer               not null,
    EMP_NOMBRE             varchar(100)          not null,
    primary key (EMP_CODIGO)
);

/* ============================================================ */
/*   Table: ESTADO_PROYECTO                                     */
/* ============================================================ */
create table ESTADO_PROYECTO
(
    EST_CODIGO             integer               not null,
    EST_NOMBRE             varchar(30)           not null,
    primary key (EST_CODIGO)
);

/* ============================================================ */
/*   Table: ENTIDAD                                             */
/* ============================================================ */
create table ENTIDAD
(
    ENT_CODIGO             integer               not null,
    ENT_NOMBRE             varchar(100)          not null,
    primary key (ENT_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO_ENTIDAD                                        */
/* ============================================================ */
create table TIPO_ENTIDAD
(
    TIPENT_CODIGO          varchar(3)            not null,
    TIPENT_NOMBRE          varchar(100)          not null,
    TIPENT_ORDEN           integer                       ,
    primary key (TIPENT_CODIGO)
);

/* ============================================================ */
/*   Table: MONEDA                                              */
/* ============================================================ */
create table MONEDA
(
    MON_CODIGO             varchar(10)           not null,
    MON_NOMBRE             varchar(50)           not null,
    MON2DOLAR              numeric(5,5)          not null,
    primary key (MON_CODIGO)
);

/* ============================================================ */
/*   Table: ESTADO_DESARROLLO                                   */
/* ============================================================ */
create table ESTADO_DESARROLLO
(
    ESTDES_CODIGO          integer               not null,
    ESTDES_NOMBRE          varchar(100)          not null,
    primary key (ESTDES_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO_DOCUMENTO                                      */
/* ============================================================ */
create table TIPO_DOCUMENTO
(
    TIPDOC_CODIGO          integer               not null,
    TIPDOC_NOMBRE          varchar(30)           not null,
    primary key (TIPDOC_CODIGO)
);

/* ============================================================ */
/*   Table: PROYECTO                                            */
/* ============================================================ */
create table PROYECTO
(
    PRO_CODIGO             varchar(3)            not null,
    COM_CODIGO             varchar(3)                    ,
    PRO_DESCRIPCION        varchar(100)          not null,
    primary key (PRO_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO                                                */
/* ============================================================ */
create table TIPO
(
    TIP_CODIGO             varchar(3)            not null,
    PRO_CODIGO             varchar(3)                    ,
    TIP_DESCRIPCION        varchar(100)          not null,
    TIP_DESDE              integer               not null,
    TIP_HASTA              integer               not null,
    TIP_ACTUAL             integer               not null,
    primary key (TIP_CODIGO)
);

/* ============================================================ */
/*   Table: DATO_PROYECTO                                       */
/* ============================================================ */
create table DATO_PROYECTO
(
    DATPRO_ID              integer               not null,
    INGPRO_CODIGO          integer               not null,
    COM_CODIGO             varchar(3)            not null,
    PRO_CODIGO             varchar(3)            not null,
    TIP_CODIGO             varchar(3)            not null,
    EST_CODIGO             integer                       ,
    DATPRO_CODIGO          varchar(20)           not null,
    DATPRO_NOMBRE          varchar(100)          not null,
    primary key (DATPRO_ID)
);

/* ============================================================ */
/*   Table: DP_DATOTECNICO                                      */
/* ============================================================ */
create table DP_DATOTECNICO
(
    DATTEC_CODIGO          integer               not null,
    DATPRO_ID              integer                       ,
    ESTDES_CODIGO          integer                       ,
    DATTEC_FINICIO         date                          ,
    DATTEC_FFINAL          date                          ,
    DATTEC_DURACION        varchar(100)                  ,
    DATTEC_BENEFICIARIO    integer                       ,
    DATTEC_MONTO           numeric(20,2)                 ,
    MON_CODIGO             varchar(10)                   ,
    primary key (DATTEC_CODIGO)
);

/* ============================================================ */
/*   Table: CANTON                                              */
/* ============================================================ */
create table CANTON
(
    CAN_CODIGO             integer               not null,
    PRO_CODIGO             integer                       ,
    CAN_NOMBRE             varchar(50)           not null,
    CAN_FOTO               varchar(220)                  ,
    primary key (CAN_CODIGO)
);

/* ============================================================ */
/*   Table: PARROQUIA                                           */
/* ============================================================ */
create table PARROQUIA
(
    PAR_CODIGO             integer               not null,
    CAN_CODIGO             integer                       ,
    PAR_NOMBRE             varchar(50)           not null,
    PAR_FOTO               varchar(220)                  ,
    primary key (PAR_CODIGO)
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
    primary key (USU_CODIGO)
);

/* ============================================================ */
/*   Table: INGRESO_PROYECTO                                    */
/* ============================================================ */
create table INGRESO_PROYECTO
(
    INGPRO_CODIGO          integer               not null,
    INGPRO_USUARIO         varchar(15)                   ,
    INGPRO_FECHA           datetime              not null,
    INGPRO_NRODPTOTECNICO  varchar(20)                   ,
    INGPRO_NRORECEPCION    varchar(20)                   ,
    INGPRO_NRODOCINT       varchar(20)                   ,
    INGPRO_EMPENTREGA      integer                       ,
    INGPRO_NROPROYECTOS    integer                       ,
    primary key (INGPRO_CODIGO)
);

/* ============================================================ */
/*   Table: SUBAPLICACION                                       */
/* ============================================================ */
create table SUBAPLICACION
(
    ID_SUBAPLICACION       integer               not null,
    ID_APLICACION          integer                       ,
    NOMBRE_SUBAPLICACION   varchar(100)                  ,
    FILE_SUBAPLICACION     varchar(250)                  ,
    IMAGEN_SUBAPLICACION   varchar(250)                  ,
    primary key (ID_SUBAPLICACION)
);

/* ============================================================ */
/*   Table: USUARIO_APLICACION                                  */
/* ============================================================ */
create table USUARIO_APLICACION
(
    USU_CODIGO             varchar(15)                   ,
    ID_APLICACION          integer                       
);

/* ============================================================ */
/*   Table: DP_UBICACION                                        */
/* ============================================================ */
create table DP_UBICACION
(
    UBI_CODIGO             integer               not null,
    DATPRO_ID              integer               not null,
    PRO_CODIGO             integer               not null,
    CAN_CODIGO             integer               not null,
    PAR_CODIGO             integer               not null,
    UBI_COMUNIDAD          blob                          ,
    UBI_OBSERVACION        blob                          ,
    primary key (UBI_CODIGO)
);

/* ============================================================ */
/*   Table: DATTECXENT                                          */
/* ============================================================ */
create table DATTECXENT
(
    DATTEC_CODIGO          integer                       ,
    MON_CODIGO             varchar(10)                   ,
    ENT_CODIGO             integer                       ,
    DTE_MONTO              numeric(20,2)         not null
);

/* ============================================================ */
/*   Table: DP_ENTIDADES                                        */
/* ============================================================ */
create table DP_ENTIDADES
(
    ENT_CODIGO             integer               not null,
    TIPENT_CODIGO          varchar(3)            not null,
    DATPRO_ID              integer                       ,
    primary key (ENT_CODIGO, TIPENT_CODIGO)
);

/* ============================================================ */
/*   Table: DP_DOCUMENTACION                                    */
/* ============================================================ */
create table DP_DOCUMENTACION
(
    DOC_CODIGO             integer               not null,
    TIPDOC_CODIGO          integer                       ,
    DATPRO_ID              integer                       ,
    DOC_CODIGOSIS          varchar(50)           not null,
    DOC_NOMBRE             varchar(100)          not null,
    DOC_PATH               varchar(200)                  ,
    primary key (DOC_CODIGO)
);

alter table PROYECTO
    add foreign key FK_PROYECTO_REF_1589_COMPONEN (COM_CODIGO)
       references COMPONENTE (COM_CODIGO) on update restrict on delete restrict;

alter table TIPO
    add foreign key FK_TIPO_REF_1593_PROYECTO (PRO_CODIGO)
       references PROYECTO (PRO_CODIGO) on update restrict on delete restrict;

alter table DATO_PROYECTO
    add foreign key FK_DATO_PRO_REF_1634_INGRESO_ (INGPRO_CODIGO)
       references INGRESO_PROYECTO (INGPRO_CODIGO) on update restrict on delete restrict;

alter table DATO_PROYECTO
    add foreign key FK_DATO_PRO_REF_1638_COMPONEN (COM_CODIGO)
       references COMPONENTE (COM_CODIGO) on update restrict on delete restrict;

alter table DATO_PROYECTO
    add foreign key FK_DATO_PRO_REF_1642_PROYECTO (PRO_CODIGO)
       references PROYECTO (PRO_CODIGO) on update restrict on delete restrict;

alter table DATO_PROYECTO
    add foreign key FK_DATO_PRO_REF_1646_TIPO (TIP_CODIGO)
       references TIPO (TIP_CODIGO) on update restrict on delete restrict;

alter table DATO_PROYECTO
    add foreign key FK_DATO_PRO_REF_2092_ESTADO_P (EST_CODIGO)
       references ESTADO_PROYECTO (EST_CODIGO) on update restrict on delete restrict;

alter table DP_DATOTECNICO
    add foreign key FK_DP_DATOT_REF_1822_DATO_PRO (DATPRO_ID)
       references DATO_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table DP_DATOTECNICO
    add foreign key FK_DP_DATOT_REF_1826_ESTADO_D (ESTDES_CODIGO)
       references ESTADO_DESARROLLO (ESTDES_CODIGO) on update restrict on delete restrict;

alter table DP_DATOTECNICO
    add foreign key FK_DP_DATOT_REF_1839_MONEDA (MON_CODIGO)
       references MONEDA (MON_CODIGO) on update restrict on delete restrict;

alter table CANTON
    add foreign key FK_CANTON_REF_1571_PROVINCI (PRO_CODIGO)
       references PROVINCIA (PRO_CODIGO) on update restrict on delete restrict;

alter table PARROQUIA
    add foreign key FK_PARROQUI_REF_1575_CANTON (CAN_CODIGO)
       references CANTON (CAN_CODIGO) on update restrict on delete restrict;

alter table USUARIO
    add foreign key FK_USUARIO_REF_1606_TIPO_USU (TIPUSU_CODIGO)
       references TIPO_USUARIO (TIPUSU_CODIGO) on update restrict on delete restrict;

alter table INGRESO_PROYECTO
    add foreign key FK_INGRESO__REF_1610_USUARIO (INGPRO_USUARIO)
       references USUARIO (USU_CODIGO) on update restrict on delete restrict;

alter table INGRESO_PROYECTO
    add foreign key FK_INGRESO__REF_1622_EMPLEADO (INGPRO_EMPENTREGA)
       references EMPLEADO (EMP_CODIGO) on update restrict on delete restrict;

alter table SUBAPLICACION
    add foreign key FK_SUBAPLIC_RAPLIXSUB_APLICACI (ID_APLICACION)
       references APLICACION (ID_APLICACION) on update restrict on delete cascade;

alter table USUARIO_APLICACION
    add foreign key FK_USUARIO__RAPLI_USU_APLICACI (ID_APLICACION)
       references APLICACION (ID_APLICACION) on update restrict on delete cascade;

alter table USUARIO_APLICACION
    add foreign key FK_USUARIO__RUSU_USU__USUARIO (USU_CODIGO)
       references USUARIO (USU_CODIGO) on update restrict on delete cascade;

alter table DP_UBICACION
    add foreign key FK_DP_UBICA_REF_1651_PROVINCI (PRO_CODIGO)
       references PROVINCIA (PRO_CODIGO) on update restrict on delete restrict;

alter table DP_UBICACION
    add foreign key FK_DP_UBICA_REF_1655_CANTON (CAN_CODIGO)
       references CANTON (CAN_CODIGO) on update restrict on delete restrict;

alter table DP_UBICACION
    add foreign key FK_DP_UBICA_REF_1659_PARROQUI (PAR_CODIGO)
       references PARROQUIA (PAR_CODIGO) on update restrict on delete restrict;

alter table DP_UBICACION
    add foreign key FK_DP_UBICA_REF_1663_DATO_PRO (DATPRO_ID)
       references DATO_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table DATTECXENT
    add foreign key FK_DATTECXE_REF_1845_DP_DATOT (DATTEC_CODIGO)
       references DP_DATOTECNICO (DATTEC_CODIGO) on update restrict on delete restrict;

alter table DATTECXENT
    add foreign key FK_DATTECXE_REF_1849_MONEDA (MON_CODIGO)
       references MONEDA (MON_CODIGO) on update restrict on delete restrict;

alter table DATTECXENT
    add foreign key FK_DATTECXE_REF_1853_ENTIDAD (ENT_CODIGO)
       references ENTIDAD (ENT_CODIGO) on update restrict on delete restrict;

alter table DP_ENTIDADES
    add foreign key FK_DP_ENTID_REF_1858_ENTIDAD (ENT_CODIGO)
       references ENTIDAD (ENT_CODIGO) on update restrict on delete restrict;

alter table DP_ENTIDADES
    add foreign key FK_DP_ENTID_REF_1866_TIPO_ENT (TIPENT_CODIGO)
       references TIPO_ENTIDAD (TIPENT_CODIGO) on update restrict on delete restrict;

alter table DP_ENTIDADES
    add foreign key FK_DP_ENTID_REF_1870_DATO_PRO (DATPRO_ID)
       references DATO_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table DP_DOCUMENTACION
    add foreign key FK_DP_DOCUM_REF_1883_TIPO_DOC (TIPDOC_CODIGO)
       references TIPO_DOCUMENTO (TIPDOC_CODIGO) on update restrict on delete restrict;

alter table DP_DOCUMENTACION
    add foreign key FK_DP_DOCUM_REF_1887_DATO_PRO (DATPRO_ID)
       references DATO_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

