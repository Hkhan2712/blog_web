<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBlog</title>
    <link rel="icon" type="image/x-icon" href="<?=RootREL?>media/img/favicon.png">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?=RootREL?>media/css/reset.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href= "<?=RootREL?>media/css/header.css">
    <link rel="stylesheet" href="<?=RootREL?>media/css/footer.css">
    <link rel="stylesheet" href="<?=RootREL?>media/css/main.css">
</head>
<body>
<header>
    <nav class="container navbar navbar-expand-lg d-flex justify-content-around gap-3">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
            <a href="" class="navbar-brand"><span class="navbar-brand__head">M</span>Blog</a>
            <ul class="navbar-nav mr-auto d-flex gap-3">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo AppUtil::url(array('ctl'=>'home'))?>">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo AppUtil::url(['ctl'=>'post'])?>">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Creators</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Comunity</a>
                </li>
            </ul>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <form class="d-flex form-inline my-2 my-lg-0 gap-1">
                <input class="form-control mr-sm-2" type="search" placeholder="Search on VBlog" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                </button>
            </form>
            
            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'add'])?>" class="link-bell">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                    </svg>
                </a>
                <a href="<?php echo AppUtil::url(['ctl' => 'profile']); ?>" class="link-account">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="link-bell bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                </a>
                <a href="<?php echo AppUtil::url(['ctl' => 'auth', 'act' => 'logout']); ?>" class="btn btn-danger border-0">Logout</a>
                <?php else: ?>
                    <a href="<?php echo AppUtil::url(['ctl' => 'auth', 'act' => 'login']); ?>" class="btn">Sign In</a>
                    <a href="<?php echo AppUtil::url(['ctl' => 'auth', 'act' => 'register']); ?>" class="btn btn-primary">Sign Up</a>
                <?php endif; ?>
        </div>
    </nav>

</header>
<main>

    
