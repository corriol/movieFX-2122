<!doctype html>
<html lang="ca">
<head>
    <title>MovieFX</title>
</head>
<body>
    <h1>Pel·lícules</h1>
    <?php use App\Movie;

    if (!empty($movie)): ?>
        <h2><?=$movie->getTitle()?></h2>
        <figure>
            <img style="width: 100px" alt="<?=$movie->getTitle() ?>" src="<?=Movie::POSTER_PATH?>/<?=$movie->getPoster() ?>" />
        </figure>
        <p><?=$movie->getOverview()?></p>
    <?php else: ?>
        <h3><?=array_shift($errors)?></h3>
    <?php endif; ?>
</body>

</html>


