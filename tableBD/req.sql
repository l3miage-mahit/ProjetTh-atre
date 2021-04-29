--table LesCategories(nomC,prix)
create table LesCategories ( nomC varchar(30),prix float not null,constraint nomC_C1 primary key(nomc) );


--table LesZones(numZ,nomC)
create table LesZones ( nozone int not null, nomC varchar(30),constraint nozone_C1 primary key (nozone),constraint nomC_C2 foreign key (nomC) references LesCategories(nomC));


--table LesPlaces(noPlace,noRang,numZ) qui est renommé comme sur  base de donné (theatre) lesSieges
create table LesSieges ( noPlace int not null,noRang int not null,nozone int not null,constraint PK_1 primary key(noPlace,noRang),constraint nozone_C2  foreign key (nozone) references LesZones(nozone)  );


--table lesspectacles (noSpec,nomS)
create table lesSpectacles ( noSpec int not null,nomS varchar(30), constraint noSpec_C1 primary key (noSpec));


--table lesRepresentation (dateRep,nomS)

create table lesRepresentations ( dateRep DATE,noSpec int not null, constraint dateRep_C1 primary key (dateRep,noSpec), constraint noSpec_C2  foreign key (noSpec) references lesSpectacles(noSpec)  );


--table lesDossiers (noDossier,montant)
create table lesDossiers ( noDossier int not null,montant float not null,constraint nodossier_C1 primary key ( noDossier));


--table lesTickets(noSerie,noSpec,dateRep,noplace,norang,dateEmission,noDossier)
create table lesTickets (
    noSerie int not null,noSpec int not null, dateRep date, noPlace int not null,noRang int not null, dateEmiss date, noDossier int not null, 
    constraint pk_2 primary key(noSerie,noSpec,dateRep,noPlace,noRang),
    constraint lesticket_C1 foreign key (noSpec,dateRep) references lesRepresentations (noSpec,dateRep), 
    constraint lesticket_C2 foreign key (noPlace,noRang) references lesSieges(noPlace,noRang), 
    constraint lesticket_C3 foreign key(noDossier) references lesdossiers(noDossier),
    constraint lesticket_C4 check (dateEmiss < dateRep)  
);




