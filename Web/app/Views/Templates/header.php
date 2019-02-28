<!DOCTYPE html>
<head>
    <title><?php echo (isset($pageTitle) ? $pageTitle : ''); ?> - <?= $siteTitle ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!--- <link rel="icon" href="img/icon.png"> use this later if/when an icon is made--->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#"><?= $siteTitle ?></a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">About Us</a></li>
                    <?php if ($loggedIn) { ?>
                        <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Account Action
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?controller=user&action=show">Your Account</a></li>
                            <li><a href="index.php?controller=vehicle&action=index">Vehicles</a></li>
                        </ul>
                        </li>
                    <?php if ($isAdmin) { ?>
                        <li><a href="index.php?controller=admin&action=index">Admin</a></li>
                    <?php } ?>
                    <?php } else { ?>
                        <!---do nothing --->
                    <?php } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php if ($loggedIn) { ?>
                        <li><a href="index.php?controller=login&action=logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                <?php } else { ?>
                        <li><a href="index.php?controller=login&action=index"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <li><a href="index.php?controller=register&action=index"><span class="glyphicon glyphicon-user"></span> Register</a></li>                        
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <?php echo (isset($pageTitle) ? '<h3>' . $pageTitle . '</h3>' : ''); ?>
    </header>
<main>



    
    
    
      
    
    
      
    
      
    
 