--insertion des places

insert into LesSieges (noPlace,noRang,noZone) select noPlace,noRang,noZone from theatre.lessieges;