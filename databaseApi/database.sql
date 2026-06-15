create database if not exists blogDB;
use blogDB;

create table if not exists Users(
    id int primary key auto_increment,
    Nome varchar(255) not null,
    Username varchar(255) not null,
    Email varchar(255) not null unique,
    Passwd varchar(255) not null,
    Role_user varchar(255) default 'User' check (Role_user in ("Admin", "Author", "User")) 
);

create table if not exists Categoria(
    idCat int auto_increment primary key,
    Nome varchar(255) not null unique
);

create table if not exists Posts(
    id int primary key auto_increment,
    Titolo varchar(255) not null,
    dataPublicazione datetime not null,
    Contenuto text not null,
    ContenutoEstratto varchar(24) not null,

    idUser int not null,
    idCat int not null,
    foreign key (idUser) references Users(id) on delete cascade,
    foreign key (idCat) references Categoria(idCat) on delete cascade
);

create table if not exists Progetti(
    id int primary key auto_increment,
    Nome varchar(255) not null,
    Descrizione text not null,
    DataCreazione datetime not null,
    link varchar(255) not null,
    stato varchar(255) not null check (stato in ("In corso", "Completato")),
    tecnologie text,

    idUser int not null,
    idCat int not null,
    foreign key (idUser) references Users(id) on delete cascade,
    foreign key (idCat) references Categoria(idCat) on delete cascade
);
