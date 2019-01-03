<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
 ?>
<form action="index.php?controller=register&action=register" method="post">
    First Name: <input type="text" name="firstName"><br />
    Last Name: <input type="text" name="lastName"><br />
    Email: <input type="email" name="email"><br />
    Password: <input type="password" name="password"><br />
    Confirm Password: <input type="password" name="confirmPassword"><br />

    <input type="submit" value="Register" />
</form>