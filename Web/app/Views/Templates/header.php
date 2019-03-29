<!DOCTYPE html>
<html lang="en"> 
<head>
    <title><?php echo (isset($pageTitle) ? $pageTitle : ''); ?> - <?= $siteTitle ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="icon" href="public/images/icon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <div class="jumbotron jumbotron-fluid" style="margin-bottom: 0; background-image: url('public/images/banner.jpg'); background-repeat: no-repeat; background-size: 100% 300px;">
            <div class="container">
                <h1 class="display-4">Smart Parking</h1>
                <p class="lead">Developed and managed by Error418 for a group project.</p>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><?= $siteTitle ?></a>
                </div>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Documentation</a></li>
                    <?php if ($loggedIn) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Account Action
                            <span class="caret"></span></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="index.php?controller=user&action=show">Your Account</a>
                                <a class="dropdown-item" href="index.php?controller=vehicle&action=index">Vehicles</a>
                                <?php if ($isAdmin) { ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="index.php?controller=admin&action=index">Admin</a>
                                <?php } ?>
                            </div>
                        </li>
                    
                    <?php } else { ?>
                        <!---do nothing --->
                    <?php } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($loggedIn) { ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=login&action=logout"> Logout</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=login&action=index"> Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?controller=register&action=index"> Register</a></li>                        
                    <?php } ?>
                </ul>
            </div>
        </nav>  
    </header>
    <main>
    <?php echo (isset($pageTitle) ? '<h3>' . $pageTitle . '</h3>' : ''); ?>



    
    
    
      
    
    
      
    
      
    
 