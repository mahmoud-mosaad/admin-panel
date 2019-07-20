
use IntCoreTaskDB;

create table users(
	id int AUTO_INCREMENT primary key,
	name varchar(100) not null,
	email varchar(100) not null unique,
    password varchar(255) not null
    );

create table categories(
	id int AUTO_INCREMENT primary key,
	name varchar(100) not null,
	description varchar(100) not null
    );

create table roles(
	id int AUTO_INCREMENT primary key,
	name varchar(100) not null
	);


create table user_roles(
	user_id int,
	role_id int,
    auth boolean,
    primary key(user_id,role_id)
	);


create table tokens(
    token  varchar(250) not null,
	  email varchar(100) not null unique,
    expire timestamp not null
);


insert into roles (name) values("select");
insert into roles (name) values("create");
insert into roles (name) values("update");
insert into roles (name) values("delete");
