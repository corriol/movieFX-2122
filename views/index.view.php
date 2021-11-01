<!doctype html>
<html lang="ca">
<head>
    <title>MovieFX</title>
</head>
<body>
    <h1>Pel·lícules</h1>
    <ul>
    <?php foreach ($movies as $movie):?>
        <li><a href="movie.php?id=<?=$movie->getId()?>"><?=$movie->getTitle()?></a></li>
    <?php endforeach; ?>
    </ul>
</body>

</html>


