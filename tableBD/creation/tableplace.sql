--table LesPlaces(noPlace,noRang,numZ) qui est renomm� comme sur  base de donn� (theatre) lesSieges

create table LesSieges ( noPlace int not null,noRang int not null,nozone int not null,constraint PK_1 primary key(noPlace,noRang),constraint nozone_C2  foreign key (nozone) references LesZones(nozone)  );
