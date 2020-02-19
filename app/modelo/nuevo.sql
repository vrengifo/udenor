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
    BENECO_GASTOSADMIN      decimal(4,2)                  
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
