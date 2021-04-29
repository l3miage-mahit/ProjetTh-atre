--table lesRepresentation (dateRep,nomS)

create table lesRepresentations ( dateRep DATE,noSpec int not null, constraint dateRep_C1 primary key (dateRep,noSpec), constraint noSpec_C2  foreign key (noSpec) references lesSpectacles(noSpec)  );
