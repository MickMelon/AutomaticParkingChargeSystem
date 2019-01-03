<!DOCTYPE html>
<head>
    <title><?php echo (isset($pageTitle) ? $pageTitle : ''); ?> - <?= $siteTitle ?></title>
</head>
<body>
    <header>
        <h1><?= $siteTitle ?></h1>
        <?php echo (isset($pageTitle) ? '<h3>' . $pageTitle . '</h3>' : ''); ?>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php 
            if (!$loggedIn) echo '<li><a href="index.php?controller=login&action=index">Login</a></li>';
            else echo '<li><a href="index.php?controller=login&action=logout">Logout</a></li>'; 
            ?>
        </ul>
    </header>
    
    <main>