--table LesZones(numZ,nomC)

create table LesZones ( nozone int not null, nomC varchar(30),constraint nozone_C1 primary key (nozone),constraint nomC_C2 foreign key (nomC) references LesCategories(nomC));
