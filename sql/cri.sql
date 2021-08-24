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

delimiter |

create trigger crearHistorialPub
before update on publicacion
for each row
begin

	if(old.titulo <> new.titulo) then
		insert into historial_pub(idPub, fecha_cambio, detalle) values
		(new.idPub, 
		current_date(), 
		concat("Se registró el cambio del TITULO", char(13), char(13), 
			"Antes:", char(13), old.titulo, char(13), char(13), 
			"Ahora:", char(13), new.titulo, char(13) ) );
	end if;

	if(old.resumen <> new.resumen) then
		insert into historial_pub(idPub, fecha_cambio, detalle) values
		(new.idPub, 
		current_date(), 
		concat("Se registró el cambio del RESUMEN", char(13), char(13), 
			"Antes:", char(13), old.resumen, char(13), char(13), 
			"Ahora:", char(13), new.resumen, char(13) ) );
	end if;

	if(old.tipo <> new.tipo) then
		insert into historial_pub(idPub, fecha_cambio, detalle) values
		(new.idPub, 
		current_date(), 
		concat("Se registró el cambio del TIPO DE PUBLICACIÓN", char(13), char(13), 
			"Antes:", char(13), old.tipo, char(13), char(13), 
			"Ahora:", char(13), new.tipo, char(13) ) );
	end if;

	if(old.APA <> new.APA) then
		insert into historial_pub(idPub, fecha_cambio, detalle) values
		(new.idPub, 
		current_date(), 
		concat("Se registró el cambio de la CITACIÓN APA", char(13), char(13), 
			"Antes:", char(13), old.APA, char(13), char(13), 
			"Ahora:", char(13), new.APA, char(13) ) );
	end if;

	if(old.unidad_investigacion <> new.unidad_investigacion) then
		insert into historial_pub(idPub, fecha_cambio, detalle) values
		(new.idPub, 
		current_date(), 
		concat("Se registró el cambio de la UNIDAD DE INVESTIGACIÓN", char(13), char(13), 
			"Antes:", char(13), old.unidad_investigacion, char(13), char(13), 
			"Ahora:", char(13), new.unidad_investigacion, char(13) ) );
	end if;

	if(old.linea_investigacion <> new.linea_investigacion) then
		insert into historial_pub(idPub, fecha_cambio, detalle) values
		(new.idPub, 
		current_date(), 
		concat("Se registró el cambio de la LÍNEA DE INVESTIGACIÓN", char(13), char(13), 
			"Antes:", char(13), old.linea_investigacion, char(13), char(13), 
			"Ahora:", char(13), new.linea_investigacion, char(13) ) );
	end if;

	if(old.estado <> new.estado) then
		insert into historial_pub(idPub, fecha_cambio, detalle) values
		(new.idPub, current_date(), "Se registró el cambio de la UNIDAD DE INVESTIGACIÓN");
	end if;

end |

delimiter ;

delimiter |

create trigger crearHistorialInv
before update on investigacion
for each row begin

	if(new.nombre <> old.nombre) then
		insert into historial_inv(idInv, fecha_cambio, detalle) values 
        (new.idInv, cast(now() as date),concat("Se registró el cambio del TITULO", char(13), char(13), "Antes:", char(13), old.nombre, char(13), char(13), "Ahora:", char(13), new.nombre, char(13)));
	end if;
	if(new.nombre_corto <> old.nombre_corto) then
		insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio del NOMBRE CORTO", char(13), char(13) , "Antes:" , char(13) , old.nombre_corto ,char(13), char(13), "Ahora:", char(13), new.nombre_corto, char(13)));
	end if;
	if(new.resumen <> old.resumen) then
		insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio del RESUMEN", char(13), char(13), "Antes:", char(13), old.resumen, char(13), char(13), "Ahora:", char(13), new.resumen, char(13)));
	end if;
	if(new.fecha_inicio <> old.fecha_inicio) then
		insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio de la FECHA DE INICIO" , char(13) , char(13) , "Antes:" , char(13) , old.fecha_inicio , char(13) , char(13) , "Ahora:" , char(13) , new.fecha_inicio , char(13)));
	end if;
	if(new.fecha_fin <> old.fecha_fin) then
		insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio de la FECHA DE FINALIZACION " , char(13) , char(13) , "Antes:" , char(13) , old.fecha_fin , char(13) , char(13) , "Ahora:" , char(13) , new.fecha_fin , char(13)));
	end if;
	if(new.unidad_investigacion <> old.unidad_investigacion) then
		insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio de la UNIDAD DE INVESTIGACION " , char(13) , char(13) , "Antes:" , char(13) , old.unidad_investigacion , char(13) , char(13) , "Ahora:" , char(13) , new.unidad_investigacion , char(13)));
	end if;
	if(new.linea_investigacion <> old.linea_investigacion) then
		insert into historial_inv(idInv, fecha_cambio,detalle) values
        (new.idInv,cast(now() as date),concat("Se registró el cambio de la LINEA DE INVESTIGACION" , char(13) , char(13) , "Antes:" , char(13) , old.linea_investigacion , char(13) , char(13) , "Ahora:" , char(13) , new.linea_investigacion , char(13)));
	end if;
end;
|

create trigger crearHistorialFin
before update on financiador
for each row begin
    if(new.tipo_financiador <> old.tipo_financiador) then
        insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio del TIPO FINANCIADOR" , char(13) , char(13) , "Antes:" , char(13) , old.tipo_financiador , char(13) , char(13) , "Ahora:" , char(13) , new.tipo_financiador , char(13)));
    end if;
    if(new.nombre_financiador <> old.nombre_financiador) then
        insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio del NOMBRE DE FINANCIADOR" , char(13) , char(13) , "Antes:" , char(13) , old.nombre_financiador , char(13) , char(13) , "Ahora:" , char(13) , new.nombre_financiador , char(13)));
    end if;
    if(new.tipo_financiamiento <> old.tipo_financiamiento) then
        insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio del TIPO FINANCIAMIENTO" , char(13) , char(13) , "Antes:" , char(13) , old.tipo_financiamiento , char(13) , char(13) , "Ahora:" , char(13) , new.tipo_financiamiento , char(13)));
    end if;
    if(new.monto <> old.monto) then
        insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio del MONTO" , char(13) , char(13) , "Antes:" , char(13) , old.monto , char(13) , char(13) , "Ahora:" , char(13) , new.monto , char(13)));
    end if;
    if(new.observaciones <> old.observaciones) then
        insert into historial_inv(idInv, fecha_cambio,detalle) values 
        (new.idInv,cast(now() as date),concat("Se registró el cambio de las OBSERVACIONES" , char(13) , char(13) , "Antes:" , char(13) , old.observaciones , char(13) , char(13) , "Ahora:" , char(13) , new.observaciones , char(13)));
    end if;
end;
|
delimiter ;

