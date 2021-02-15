drop database if exists inventory;

create database inventory;

use inventory;

create table products(
    id  int unsigned not null auto_increment,
    name varchar(245) not null,
    available int unsigned not null default(0),
    primary key id (id),
    index name (name)
);


create user 'dev'@'localhost' identified by 'password';
grant all PRIVILEGES ON * . * TO 'dev'@'localhost';