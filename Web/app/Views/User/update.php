<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
 ?>
<form action="index.php?controller=user&action=submitupdate" method="post">
    First Name: <input type="text" name="firstName" value="<?= $user->FirstName ?>"><br />
    Last Name: <input type="text" name="lastName" value="<?= $user->LastName ?>"><br />
    Password: <input type="password" name="password"><br />
    Confirm Password: <input type="password" name="confirmPassword"><br />
    <input type="hidden" name="userId" value="<?= $user->ID ?>" />
    <input type="submit" value="Update" />
</form>