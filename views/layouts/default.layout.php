<!DOCTYPE html>
<html lang="ca">
<head>
    <title><?=$title ?? "Movie FX"?> - Movie FX</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/global.css" rel="stylesheet">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
<header>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Movie FX</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Movies</a>
                    </li>
                </ul>

                <ul class="nav navbar-nav ml-auto">
                    <?php if (empty($user)): ?>

                        <li class="nav-item ">
                            <a class="nav-item nav-link mr-md-2" id="bd-versions" aria-haspopup="false"
                               aria-expanded="false" href="/login">
                                Log in
                            </a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link" aria-haspopup="false" aria-expanded="false"
                               href="">
                                Register
                            </a>
                        </li>
                    <?php else :?>
                        <li class="nav-item">
                            <a class="nav-item nav-link mr-md-2" id="bd-versions" aria-haspopup="false"
                               aria-expanded="false" href="/logout">
                                Log out
                            </a>

                        </li>
                    <?php endif; ?>
                </ul>
                <form class="form-inline ml-2 my-2 my-lg-0">
                    <input class="form-control mr-sm-2" name="q" type="text" placeholder="Search" aria-label="Search" value="">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>
</header>
<main class="mt-2 flex-fill">
<?=$content?>
</main>
<!-- FOOTER Start
    ================================================== -->

<footer class="bg-dark text-secondary pt-4 footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>MOVIE FX</h4>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s
                </p>
                <h4 class="connect-heading">CONNECT WITH US</h4>
                <ul class="connect list-group ml-2 list-group-horizontal">
                    <li class="bg-dark list-group-item">
                        <a class="facebook-icon" href="#">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    <li class="bg-dark list-group-item">
                        <a class="plus-icon" href="#">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </li>
                    <li class="bg-dark list-group-item">
                        <a class="twitter-icon" href="#">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    <li class="bg-dark list-group-item">
                        <a class="pinterest-icon" href="#">
                            <i class="fa fa-pinterest"></i>
                        </a>
                    </li>
                    <li class="bg-dark list-group-item">
                        <a class="linkedin-icon" href="#">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                </ul>    <!-- End Of /.social-icon -->
            </div> <!-- End Of /.Col-md-4 -->
            <div class="col-md-6">
                <h4>GET IN TOUCH</h4>

                <p><i class="fa  fa-map-marker"></i> <span>La Marina Valley,</span>03780 Pego,
                    Spain</p>
                <p><i class="fa  fa-phone"></i> <span>Phone:</span> (+34) 940 123 456 </p>

                <p><i class="fa  fa-mobile"></i> <span>Mobile:</span> (+34) 940 654 123 651</p>

                <p class="mail"><i class="fa  fa-envelope"></i> <a href="/contact">Contact form</a></p>

            </div> <!-- End Of Col-md-3 -->
        </div> <!-- End Of /.row -->
    </div> <!-- End Of /.Container -->
</footer></body>
</html>