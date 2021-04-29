--insertion des categorie
insert into lescategories (nomC, prix) select nomC,prix from theatre.lescategories;

--insertion des zones
insert into lesZones (noZone, nomC) select noZone,nomC from theatre.leszones;

--insertion des places
insert into LesSieges (noPlace,noRang,noZone) select noPlace,noRang,noZone from theatre.lessieges;

--insertion des spectacles
insert into lesSpectacles (noSpec,nomS) select noSpec,nomS from theatre.lesSpectacles;

--insertion des Representation
insert into lesRepresentations (dateRep,noSpec) select dateRep,noSpec from theatre.lesRepresentations;

--insertion des Dossiers
insert into lesDossiers (noDossier,montant) select noDossier,sum(prix) From theatre.lestickets natural join theatre.lesSieges natural join theatre.leszones natural join theatre.lescategories group by nodossier order by noDossier;

--insertion des Tickets
insert into lesTickets (noSerie,noSpec,dateRep,noplace,norang,dateEmiss,noDossier) select noSerie,noSpec,dateRep,noplace,norang,dateEmission,noDossier from theatre.lesTickets natural join theatre.lesRepresentations;