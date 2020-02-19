/* ============================================================ */
/*   Database name:  MODEL_1                                    */
/*   DBMS name:      Sybase AS Anywhere 6                       */
/*   Created on:     15/03/2005  0:18                           */
/* ============================================================ */

/* ============================================================ */
/*   Table: OBJETIVO_UDENOR                                     */
/* ============================================================ */
create table OBJETIVO_UDENOR
(
    OBJUDE_CODIGO           integer               not null,
    OBJUDE_DESCRIPCION      blob                  not null,
    primary key (OBJUDE_CODIGO)
);

/* ============================================================ */
/*   Table: PRIORIZACION_PROYECTO                               */
/* ============================================================ */
create table PRIORIZACION_PROYECTO
(
    DATPRO_ID               integer               not null,
    DATPRO_CODIGO           varchar(20)                   ,
    USU_AUDIT               varchar(15)                   ,
    USU_FAUDIT              datetime                      ,
    primary key (DATPRO_ID)
);

/* ============================================================ */
/*   Table: ESTADO_AVANCEPRO                                    */
/* ============================================================ */
create table ESTADO_AVANCEPRO
(
    ESTAVAPRO_CODIGO        varchar(3)            not null,
    ESTAVAPRO_DESCRIPCION   varchar(100)          not null,
    primary key (ESTAVAPRO_CODIGO)
);

/* ============================================================ */
/*   Table: OBJXPRI                                             */
/* ============================================================ */
create table OBJXPRI
(
    DATPRO_ID               integer                       ,
    OBJUDE_CODIGO           integer                       
);

/* ============================================================ */
/*   Table: ESTAVAPROXPRI                                       */
/* ============================================================ */
create table ESTAVAPROXPRI
(
    DATPRO_ID               integer                       ,
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
    DATPRO_ID               integer                       ,
    BEN_DIRECTOS            int(12)                       ,
    BEN_TOTALPARROQUIAS     int(12)                       
);

/* ============================================================ */
/*   Table: BENEFICIOECONOMICO                                  */
/* ============================================================ */
create table BENEFICIOECONOMICO
(
    DATPRO_ID               integer                       ,
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
    VIAPAR_ID               integer               not null,
    VIAPAR_DESCRIPCION      varchar(100)          not null,
    primary key (VIAPAR_ID)
);

/* ============================================================ */
/*   Table: VIAPARXPRI                                          */
/* ============================================================ */
create table VIAPARXPRI
(
    DATPRO_ID               integer                       ,
    VIAPAR_ID               integer                       
);

/* ============================================================ */
/*   Table: CONTRAPARTIDA                                       */
/* ============================================================ */
create table CONTRAPARTIDA
(
    DATPRO_ID               integer                       ,
    CONTRA_BENEFICIARIOS    decimal(4,2)                  ,
    CONTRA_PROPONENTE       decimal(4,2)                  
);

/* ============================================================ */
/*   Table: BENAMBXPRI                                          */
/* ============================================================ */
create table BENAMBXPRI
(
    DATPRO_ID               integer                       ,
    BENAMB_ID               integer                       
);

/* ============================================================ */
/*   Table: BENEFICIO_AMBIENTAL                                 */
/* ============================================================ */
create table BENEFICIO_AMBIENTAL
(
    BENAMB_ID               integer               not null,
    BENAMB_DESCRIPCION      varchar(100)          not null,
    primary key (BENAMB_ID)
);

/* ============================================================ */
/*   Table: CALIFICACION_PROYECTO                               */
/* ============================================================ */
create table CALIFICACION_PROYECTO
(
    DATPRO_ID               integer               not null,
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
    primary key (DATPRO_ID)
);

alter table PRIORIZACION_PROYECTO
    add foreign key FK_PRIORIZA_REF_2486_DATO_PRO (DATPRO_ID)
       references DATO_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table OBJXPRI
    add foreign key FK_OBJXPRI_REF_2497_PRIORIZA (DATPRO_ID)
       references PRIORIZACION_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table OBJXPRI
    add foreign key FK_OBJXPRI_REF_2501_OBJETIVO (OBJUDE_CODIGO)
       references OBJETIVO_UDENOR (OBJUDE_CODIGO) on update restrict on delete restrict;

alter table ESTAVAPROXPRI
    add foreign key FK_ESTAVAPR_REF_2508_PRIORIZA (DATPRO_ID)
       references PRIORIZACION_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table ESTAVAPROXPRI
    add foreign key FK_ESTAVAPR_REF_2512_ESTADO_A (ESTAVAPRO_CODIGO)
       references ESTADO_AVANCEPRO (ESTAVAPRO_CODIGO) on update restrict on delete restrict;

alter table BENEFICIOSOCIAL
    add foreign key FK_BENEFICI_REF_2525_PRIORIZA (DATPRO_ID)
       references PRIORIZACION_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table BENEFICIOECONOMICO
    add foreign key FK_BENEFICI_REF_2534_PRIORIZA (DATPRO_ID)
       references PRIORIZACION_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table VIAPARXPRI
    add foreign key FK_VIAPARXP_REF_2548_PRIORIZA (DATPRO_ID)
       references PRIORIZACION_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table VIAPARXPRI
    add foreign key FK_VIAPARXP_REF_2551_VIALIDAD (VIAPAR_ID)
       references VIALIDAD_PARTICIPATIVA (VIAPAR_ID) on update restrict on delete restrict;

alter table CONTRAPARTIDA
    add foreign key FK_CONTRAPA_REF_2561_PRIORIZA (DATPRO_ID)
       references PRIORIZACION_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table BENAMBXPRI
    add foreign key FK_BENAMBXP_REF_2568_PRIORIZA (DATPRO_ID)
       references PRIORIZACION_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

alter table BENAMBXPRI
    add foreign key FK_BENAMBXP_REF_2574_BENEFICI (BENAMB_ID)
       references BENEFICIO_AMBIENTAL (BENAMB_ID) on update restrict on delete restrict;

alter table CALIFICACION_PROYECTO
    add foreign key FK_CALIFICA_REF_2601_DATO_PRO (DATPRO_ID)
       references DATO_PROYECTO (DATPRO_ID) on update restrict on delete restrict;

