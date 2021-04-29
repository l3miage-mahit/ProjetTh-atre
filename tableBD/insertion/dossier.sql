--insertion des Dossiers

insert into lesDossiers (noDossier,montant) select noDossier,sum(prix) From theatre.lestickets natural join theatre.lesSieges natural join theatre.leszones natural join theatre.lescategories group by nodossier order by noDossier;