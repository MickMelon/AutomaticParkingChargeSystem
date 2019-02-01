<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
?>
<form action="index.php?controller=register&action=register" method="post">
    First Name: <input type="text" name="firstName" maxlength="16" required><br />
    Last Name: <input type="text" name="lastName" maxlength="16" required><br />
    Email: <input type="email" name="email" maxlength="128" required><br />
    Password: <input type="password" name="password" minlength="6" required><br />
    Confirm Password: <input type="password" name="confirmPassword" minlength="6" required><br />

    <input type="submit" value="Register" />
</form>