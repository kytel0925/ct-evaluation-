
CREATE TABLE pais ( 
	codigo               varchar(5) NOT NULL  PRIMARY KEY  ,
	nombre               varchar(45) NOT NULL    ,
	created_at           datetime     ,
	updated_at           datetime     ,
	deleted_at           datetime     
 );

 CREATE TABLE persona ( 
	id                   integer NOT NULL  PRIMARY KEY,
	nombre               varchar(45) NOT NULL,
    apellido             varchar(40) NOT NULL,
    fecha_nacimiento     datetime NOT NULL, 
    genero               varchar(5) NOT NULL,
    codigo_pais          varchar(5) NOT NULL,
	created_at           datetime,
	updated_at           datetime,
	deleted_at           datetime,
    FOREIGN KEY ( codigo_pais ) REFERENCES pais ( codigo ) ON DELETE RESTRICT ON UPDATE CASCADE
 );

CREATE TABLE identificacion ( 
	id                   integer NOT NULL  PRIMARY KEY,
	persona_id           integer NOT NULL,
    tipo                 varchar(15) NOT NULL,
    valor                varchar(50) NOT NULL, 
	created_at           datetime,
	updated_at           datetime,
	deleted_at           datetime,
    FOREIGN KEY ( persona_id ) REFERENCES persona ( id ) ON DELETE RESTRICT ON UPDATE CASCADE
 );

CREATE TABLE factura ( 
	id                   varchar(20) NOT NULL  PRIMARY KEY,
    identificacion_id    integer NOT NULL,
    fecha                datetime NOT NULL,
    total                float NOT NULL, 
	created_at           datetime,
	updated_at           datetime,
	deleted_at           datetime,
    FOREIGN KEY ( identificacion_id ) REFERENCES identificacion ( id ) ON DELETE RESTRICT ON UPDATE CASCADE
 );

CREATE TABLE direcciones ( 
	id                   integer NOT NULL  PRIMARY KEY,
	persona_id           integer NOT NULL,
    codigo_pais          varchar(5) NOT NULL,
    postal_code          varchar(30) NOT NULL,
    detalle              varchar(100) NOT NULL,
	created_at           datetime,
	updated_at           datetime,
	deleted_at           datetime,
    FOREIGN KEY ( persona_id ) REFERENCES persona ( id ) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY ( codigo_pais ) REFERENCES pais ( codigo ) ON DELETE RESTRICT ON UPDATE CASCADE
 );


 
