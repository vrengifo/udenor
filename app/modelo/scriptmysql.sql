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
    primary key (PRO_CODIGO,COM_CODIGO)
);

/* ============================================================ */
/*   Table: TIPO                                                */
/* ============================================================ */
create table TIPO
(
    TIP_CODIGO             varchar(3)            not null,
    PRO_CODIGO             varchar(3)            not null,
    COM_CODIGO             varchar(3)            not null,
    TIP_DESCRIPCION        varchar(100)          not null,
    TIP_DESDE              int(10)               not null,
    TIP_HASTA              int(10)               not null,
    TIP_ACTUAL             int(10)               not null,
    primary key (TIP_CODIGO,PRO_CODIGO,COM_CODIGO)
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
    primary key (ENT_CODIGO, TIPENT_CODIGO,DATPRO_ID)
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

/* ============================================================ */
/*   Table: INDICADOR                                           */
/* ============================================================ */
create table INDICADOR
(
    IND_CODIGO       varchar(20)           not null,
    IND_DESCRIPCION  varchar(200)          not null,
    primary key (IND_CODIGO),
    unique (IND_CODIGO),
    index (IND_CODIGO)
);

/* ============================================================ */
/*   Table: INDICADORXCANTON                                    */
/* ============================================================ */
create table INDICADORXCANTON
(
    CAN_CODIGO       int(10)                       ,
    IND_CODIGO       varchar(20)                   ,
    INDXCAN_VALOR    decimal(10,2)                 
);

/* ============================================================ */
/*   Table: OBJETIVO_UDENOR                                     */
/* ============================================================ */
create table OBJETIVO_UDENOR
(
    OBJUDE_CODIGO           int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    OBJUDE_DESCRIPCION      blob                  not null,
    primary key (OBJUDE_CODIGO),
    unique (OBJUDE_CODIGO),
    index (OBJUDE_CODIGO)
);

/* ============================================================ */
/*   Table: PRIORIZACION_PROYECTO                               */
/* ============================================================ */
create table PRIORIZACION_PROYECTO
(
    DATPRO_ID               int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    DATPRO_CODIGO           varchar(20)                   ,
    USU_AUDIT               varchar(15)                   ,
    USU_FAUDIT              datetime                      ,
    primary key (DATPRO_ID),
    unique (DATPRO_ID),
    index (DATPRO_ID)
);

/* ============================================================ */
/*   Table: ESTADO_AVANCEPRO                                    */
/* ============================================================ */
create table ESTADO_AVANCEPRO
(
    ESTAVAPRO_CODIGO        varchar(3)            not null,
    ESTAVAPRO_DESCRIPCION   varchar(100)          not null,
    primary key (ESTAVAPRO_CODIGO),
    unique (ESTAVAPRO_CODIGO),
    index (ESTAVAPRO_CODIGO)
);

/* ============================================================ */
/*   Table: OBJXPRI                                             */
/* ============================================================ */
create table OBJXPRI
(
    DATPRO_ID               int(10)                       ,
    OBJUDE_CODIGO           int(10)                       
);

/* ============================================================ */
/*   Table: ESTAVAPROXPRI                                       */
/* ============================================================ */
create table ESTAVAPROXPRI
(
    DATPRO_ID               int(10)                       ,
    ESTAVAPRO_CODIGO        varchar(3)                    ,
    ESTAVAPROXPRI_FECHA     datetime                      ,
    USU_AUDIT               varchar(15)                   ,
    USU_FAUDIT              datetime                      
);

/* ============================================================ */
/*   Table: BENEFICIOSOCIAL                                     */
/* ============================================================ */
create table BENEFICIOSOCIAL
(
    DATPRO_ID               int(10)                       ,
    BEN_DIRECTOS            int(12)                       ,
    BEN_TOTALPARROQUIAS     int(12)                       
);

/* ============================================================ */
/*   Table: BENEFICIOECONOMICO                                  */
/* ============================================================ */
create table BENEFICIOECONOMICO
(
    DATPRO_ID               int(10)                       ,
    BENECO_TMR              decimal(4,2)                  ,
    BENECO_TIR              decimal(4,2)                  ,
    BENECO_VAN              decimal(4,2)                  ,
    BENECO_GASTOSADMIN      decimal(12,2)                  
);

/* ============================================================ */
/*   Table: VIALIDAD_PARTICIPATIVA                              */
/* ============================================================ */
create table VIALIDAD_PARTICIPATIVA
(
    VIAPAR_ID               int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    VIAPAR_DESCRIPCION      varchar(100)          not null,
    primary key (VIAPAR_ID),
    unique (VIAPAR_ID),
    index (VIAPAR_ID)
);

/* ============================================================ */
/*   Table: VIAPARXPRI                                          */
/* ============================================================ */
create table VIAPARXPRI
(
    DATPRO_ID               int(10)                       ,
    VIAPAR_ID               int(10)                       
);

/* ============================================================ */
/*   Table: CONTRAPARTIDA                                       */
/* ============================================================ */
create table CONTRAPARTIDA
(
    DATPRO_ID               int(10)                       ,
    CONTRA_BENEFICIARIOS    decimal(4,2)                  ,
    CONTRA_PROPONENTE       decimal(4,2)                  
);

/* ============================================================ */
/*   Table: BENAMBXPRI                                          */
/* ============================================================ */
create table BENAMBXPRI
(
    DATPRO_ID               int(10)                       ,
    BENAMB_ID               int(10)                       
);

/* ============================================================ */
/*   Table: BENEFICIO_AMBIENTAL                                 */
/* ============================================================ */
create table BENEFICIO_AMBIENTAL
(
    BENAMB_ID               int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    BENAMB_DESCRIPCION      varchar(100)          not null,
    primary key (BENAMB_ID),
    unique (BENAMB_ID),
    index (BENAMB_ID)
);

/* ============================================================ */
/*   Table: CALIFICACION_PROYECTO                               */
/* ============================================================ */
create table CALIFICACION_PROYECTO
(
    DATPRO_ID               int(10)               not null,
    CAL_CONCORDANCIA        varchar(240)                  ,
    CAL_CONCORDANCIAVAL     int(2)                        ,
    CAL_BENEFICIOSOCIAL     varchar(240)                  ,
    CAL_BENEFICIOSOCIALVAL  int(2)                        ,
    CAL_BENECOTIR           varchar(240)                  ,
    CAL_BENECOTIRVAL        int(2)                        ,
    CAL_BENECOVAN           varchar(240)                  ,
    CAL_BENECOVANVAL        int(2)                        ,
    CAL_BENECOGA            varchar(240)                  ,
    CAL_BENECOGAVAL         int(2)                        ,
    CAL_VIALIDAD            varchar(240)                  ,
    CAL_VIALIDADVAL         int(2)                        ,
    CAL_CONTRAPARTIDA       varchar(240)                  ,
    CAL_CONTRAPARTIDAVAL    int(2)                        ,
    CAL_AMBIENTAL           varchar(240)                  ,
    CAL_AMBIENTALVAL        int(2)                        ,
    TOTAL_SOBRE             int(3)                        ,
    TOTAL_PUNTAJE           int(3)                        ,
    USU_AUDIT               varchar(15)                   ,
    USU_FAUDIT              datetime                      ,
    primary key (DATPRO_ID),
    unique (DATPRO_ID),
    index (DATPRO_ID)
);

/* ============================================================ */
/*   Table: ITEM                                                */
/* ============================================================ */
create table ITEM
(
    ITE_ID       varchar(3)            not null,
    ITE_NOMBRE   varchar(240)          not null,
    primary key (ITE_ID),
    unique (ITE_ID),
    index (ITE_ID),
);

/* ============================================================ */
/*   Table: OPCION                                              */
/* ============================================================ */
create table OPCION
(
    OPC_ID       int(10)     UNSIGNED NOT NULL AUTO_INCREMENT,
    ITE_ID       varchar(3)                    ,
    OPC_NOMBRE   blob                          ,
    OPC_PUNTAJE  int(3)                        ,
    OPC_REGLA    blob                          ,
    primary key (OPC_ID),
    unique (OPC_ID),
    index (OPC_ID)
);
