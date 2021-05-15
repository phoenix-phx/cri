create database cri;
use cri;

create table usuario(
    idUsuario int not null auto_increment primary key,
    nombre varchar(100),
    correo varchar(100),
    celular varchar(100),
    telefono varchar(100),

    filiacion varchar(50),
    unidad_investigacion varchar(100),
    rol varchar(50),
    
    user varchar(100) unique,
    pass varchar(100)
);

create table curriculum(
    idCV int not null auto_increment primary key,
    idUsuario int not null,
    nombre varchar(500),
    tipo varchar(100),
    doc longblob,
    
    foreign key (idUsuario) references usuario(idUsuario)
    on delete cascade
    on update cascade
);

create table investigacion(
    idInv int not null auto_increment primary key,
    idUsuario int not null,
    codigo varchar(500) unique,
    nombre varchar(500),
    nombre_corto varchar(200),
    resumen text,
    fecha_inicio date,
    fecha_fin date,
    unidad_investigacion varchar(100),
    linea_investigacion varchar(100),
    estado varchar(50),
    
    foreign key (idUsuario) references usuario(idUsuario) 
    on delete cascade
    on update cascade
);

create table publicacion(
    idPub int not null auto_increment primary key,
    idUsuario int not null,
    idInv int,
    codigo varchar(500) unique,
    titulo varchar(500),
    resumen text,
    tipo varchar(100),
    APA text,
    unidad_investigacion varchar(100),
    linea_investigacion varchar(100),
    estado varchar(50),
    
    foreign key (idUsuario) references usuario(idUsuario),
    foreign key (idInv) references investigacion(idInv)
    on delete set null
    on update cascade
);

create table documento(
    idDocumento int not null auto_increment primary key,
    idPub int not null,
    nombre varchar(500),
    tipo varchar(100),
    doc longblob,
    descripcion text,
    feedback text,
    
    foreign key (idPub) references publicacion(idPub)
    on delete cascade
    on update cascade
);

create table autor(
    idAutor int not null auto_increment primary key,
    nombre varchar(100),
    tipo_filiacion varchar(50),
    rol varchar(50),
    unidad_investigacion varchar(100),
    filiacion varchar(50),
    universidad varchar(100)
);

create table colaborador_inv(
    idInv int not null,
    idAutor int not null,
    
    foreign key (idAutor) references autor(idAutor) on delete cascade on update cascade,
    foreign key (idInv) references investigacion(idInv)
    on delete cascade 
    on update cascade
);

create table colaborador_pub(
    idPub int not null,
    idAutor int not null,
    
    foreign key (idAutor) references autor(idAutor) on delete cascade on update cascade,
    foreign key (idPub) references publicacion(idPub)
    on delete cascade
    on update cascade
);

create table financiador(
    idFinanciador int not null auto_increment primary key,
    idInv int not null,
    tipo_financiador varchar(100),
    nombre_financiador varchar(500),
    tipo_financiamiento varchar(100),
    monto double,
    observaciones text,
    
    foreign key (idInv) references investigacion(idInv)
    on delete cascade 
    on update cascade
);

create table actividad(
    idActividad int not null auto_increment primary key,
    idInv int not null,
    nombre varchar(500),
    fecha_inicio date,
    fecha_final date,
    
    foreign key (idInv) references investigacion(idInv)
    on delete cascade
    on update cascade
);

create table historial_inv(
    idHistorial int not null auto_increment primary key,
    idInv int not null,
    fecha_cambio date,
    detalle text,
    
    foreign key (idInv) references investigacion(idInv)
    on delete cascade
    on update cascade
);

create table historial_pub(
    idHistorial int not null auto_increment primary key,
    idPub int not null,
    fecha_cambio date,
    detalle text,
    
    foreign key (idPub) references publicacion(idPub)
    on delete cascade
    on update cascade
);