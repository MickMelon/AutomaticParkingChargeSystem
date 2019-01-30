<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
 ?>
<form action="index.php?controller=login&action=login" method="post">
    Email: <input type="text" name="email"><br />
    Password: <input type="password" name="password"><br />
    <input type="submit" value="Login" />
</form>