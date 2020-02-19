/* ============================================================ */
/*   Database name:  MODEL_1                                    */
/*   DBMS name:      Sybase AS Anywhere 6                       */
/*   Created on:     15/03/2005  0:13                           */
/* ============================================================ */

/* ============================================================ */
/*   Table: INDICADOR                                           */
/* ============================================================ */
create table INDICADOR
(
    IND_CODIGO       varchar(20)           not null,
    IND_DESCRIPCION  varchar(200)          not null,
    primary key (IND_CODIGO)
);

/* ============================================================ */
/*   Table: INDICADORXCANTON                                    */
/* ============================================================ */
create table INDICADORXCANTON
(
    CAN_CODIGO       integer                       ,
    IND_CODIGO       varchar(20)                   ,
    INDXCAN_VALOR    decimal(10,2)                 
);

alter table INDICADORXCANTON
    add foreign key FK_INDICADO_REF_2472_CANTON (CAN_CODIGO)
       references CANTON (CAN_CODIGO) on update restrict on delete restrict;

alter table INDICADORXCANTON
    add foreign key FK_INDICADO_REF_2476_INDICADO (IND_CODIGO)
       references INDICADOR (IND_CODIGO) on update restrict on delete restrict;

