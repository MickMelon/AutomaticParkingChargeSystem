<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
 ?>
<form action="index.php?controller=login&action=login" method="post">
    Email: <input type="text" name="email" required><br />
    Password: <input type="password" name="password" required><br />
    <input type="submit" value="Login" />
</form>