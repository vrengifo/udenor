/* ============================================================ */
/*   Database name:  MODEL_1                                    */
/*   DBMS name:      Sybase AS Anywhere 6                       */
/*   Created on:     21/03/2005  14:30                          */
/* ============================================================ */

/* ============================================================ */
/*   Table: ITEM                                                */
/* ============================================================ */
create table ITEM
(
    ITE_ID       varchar(3)            not null,
    ITE_NOMBRE   varchar(240)          not null,
    primary key (ITE_ID)
);

/* ============================================================ */
/*   Table: OPCION                                              */
/* ============================================================ */
create table OPCION
(
    OPC_ID       int(10)               not null,
    ITE_ID       varchar(3)                    ,
    OPC_NOMBRE   blob                          ,
    OPC_PUNTAJE  int(3)                        ,
    OPC_REGLA    blob                          ,
    primary key (OPC_ID)
);

alter table OPCION
    add foreign key FK_OPCION_REF_3199_ITEM (ITE_ID)
       references ITEM (ITE_ID) on update restrict on delete restrict;

