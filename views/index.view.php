<!doctype html>
<html lang="ca">
<head>
    <title>MovieFX</title>
</head>
<body>
    <h1>Pel·lícules</h1>
    <p><a href="movies-create.php">Nova pel·lícula</a></p>
    <ul>
    <?php foreach ($movies as $movie):?>
        <li><a href="movie.php?id=<?=$movie->getId()?>"><?=$movie->getTitle()?></a></li>
    <?php endforeach; ?>
    </ul>
</body>

</html>


