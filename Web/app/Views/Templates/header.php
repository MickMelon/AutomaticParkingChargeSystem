<!DOCTYPE html>
<head>
    <title><?php echo (isset($pageTitle) ? $pageTitle : ''); ?> - <?= $siteTitle ?></title>
</head>
<body>
    <header>
        <h1><?= $siteTitle ?></h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if ($loggedIn) { ?>
                <li><a href="index.php?controller=login&action=logout">Logout</a></li>
                <li><a href="index.php?controller=user&action=show">Your Account</a></li>
                <li><a href="index.php?controller=vehicle&action=index">Vehicles</a></li>
                <?php if ($isAdmin) { ?>
                    <li><a href="index.php?controller=admin&action=index">Admin</a></li>
                <?php } ?>
            <?php } else { ?>
                <li><a href="index.php?controller=login&action=index">Login</a></li>
                <li><a href="index.php?controller=register&action=index">Register</a></li>
            <?php } ?>
        </ul>
        <?php echo (isset($pageTitle) ? '<h3>' . $pageTitle . '</h3>' : ''); ?>
    </header>
    
    <main>