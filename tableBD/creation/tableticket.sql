--table lesTickets(noSerie,noSpec,dateRep,noplace,norang,dateEmission,noDossier)

create table lesTickets (
    noSerie int not null,noSpec int not null, dateRep date, noPlace int not null,noRang int not null, dateEmiss date, noDossier int not null, 
    constraint pk_2 primary key(noSerie,noSpec,dateRep,noPlace,noRang),
    constraint lesticket_C1 foreign key (noSpec,dateRep) references lesRepresentations (noSpec,dateRep), 
    constraint lesticket_C2 foreign key (noPlace,noRang) references lesSieges(noPlace,noRang), 
    constraint lesticket_C3 foreign key(noDossier) references lesdossiers(noDossier),
    constraint lesticket_C4 check (dateEmiss < dateRep)  
);

