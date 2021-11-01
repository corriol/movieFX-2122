<?php

$movie = new Movie();
$movie->setId(1);
$movie->setTitle("Eve");
$movie->setPoster("eve-2019.jpg");
$movie->setReleaseDate("2019-10-19");
$movie->setOverview("When a talented actress fails to land the role of her dreams, 
    she becomes obsessed with the up-and-comer who gets the part.");
$movie->setRating(2.05);

$movies[] = $movie;

$movie = new Movie();
$movie->setId(2);
$movie->setTitle("Dune");
$movie->setPoster("dune-2021.jpg");
$movie->setReleaseDate("2021-09-17");
$movie->setOverview("Paul Atreides, a brilliant and gifted young man born into a great destiny beyond 
    his understanding, must travel to the most dangerous planet in the universe to ensure the future of his 
    family and his people. As malevolent forces explode into conflict over the planet's exclusive supply of the 
    most precious resource in existence-a commodity capable of unlocking humanity's greatest potential-only those 
    who can conquer their fear will survive.");
$movie->setRating(4.00);

$movies[] = $movie;

$movie = new Movie();
$movie->setId(3);
$movie->setTitle("Venom: Let There Be Carnage");
$movie->setPoster("venom-2021.jpg");
$movie->setReleaseDate("2021-10-15");
$movie->setOverview("After finding a host body in investigative reporter Eddie Brock, the alien symbiote 
    must face a new enemy, Carnage, the alter ego of serial killer Cletus Kasady.");
$movie->setRating(3.20);

$movies[] = $movie;