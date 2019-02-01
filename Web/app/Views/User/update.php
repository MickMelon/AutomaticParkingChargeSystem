<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
 ?>
<form action="index.php?controller=user&action=submitupdate" method="post">
    First Name: <input type="text" name="firstName" value="<?= $user->FirstName ?>" minlength="3" maxlength="16" required><br />
    Last Name: <input type="text" name="lastName" value="<?= $user->LastName ?>" minlength="3" maxlength="16" required><br />
    Password: <input type="password" name="password" minlength="6" required><br />
    Confirm Password: <input type="password" name="confirmPassword" minlength="6" required><br />
    <input type="hidden" name="userId" value="<?= $user->ID ?>" />
    <input type="submit" value="Update" />
</form>