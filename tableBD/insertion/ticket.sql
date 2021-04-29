--insertion des Tickets

insert into lesTickets (noSerie,noSpec,dateRep,noplace,norang,dateEmiss,noDossier) select noSerie,noSpec,dateRep,noplace,norang,dateEmission,noDossier from theatre.lesTickets natural join theatre.lesRepresentations;