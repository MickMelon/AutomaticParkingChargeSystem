<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
?>
<form action="index.php?controller=admin&action=submitupdatecarpark" method="post">
    Name: <input type="text" name="name" value="<?= $carpark->Name ?>" minlength="3" maxlength="32" required><br />
    Price (£): <input type="number" name="price" value="<?= $carpark->Price ?>" min="0.00" max="1000.00" step="0.01" required><br />
    <input type="hidden" name="carparkId" value="<?= $carpark->ID ?>" />
    <input type="submit" value="Update" />
</form>