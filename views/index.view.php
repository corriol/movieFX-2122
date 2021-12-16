<!doctype html>
<html lang="ca">
<head>
    <title>MovieFX</title>
    <link rel="stylesheet" href="assets/global.css" />
</head>
<body>
    <h1>Pel·lícules</h1>
    <?php use App\Registry;

    if (!empty($message)) :?>
        <div><?=$message?></div>
    <?php endif; ?>
    <p><a href="movies-create.php">Nova pel·lícula</a></p>
    <ul>
    <?php foreach ($movies as $movie):?>
        <li><a href="movie.php?id=<?=$movie->getId()?>"><?=$movie->getTitle()?></a>
            <ul>
                <li><a href="<?=Registry::get(\App\Registry::ROUTER)->generate("movie_edit",  ["id" => $movie->getId()])?>">Editar</a>
                <li><a href="movies-delete.php?id=<?=$movie->getId()?>">Borrar</a>
            </ul>
        </li>
    <?php endforeach; ?>
    </ul>
</body>

</html>


