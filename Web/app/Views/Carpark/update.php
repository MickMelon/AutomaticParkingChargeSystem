<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
?>
<h4><?= $carpark->Name ?></h4>
<form action="index.php?controller=carpark&action=submitupdate" method="post">
    <div class="form-group">
        <label for="first">Name:</label>
        <input type="text" name="name" class="form-control" id="first" value="<?= $carpark->Name ?>" minlength="3" maxlength="32" required>
    </div>
    <div class="form-group">
        <label for="last">Price (£):</label>
        <input type="number" name="lastName" class="form-control" id="last" value="<?= $carpark->Price ?>" minlength="0.00" maxlength="1000.00" required>
    </div>
    <input type="hidden" name="carparkId" value="<?= $carpark->ID ?>" />
    <button type="submit" class="btn btn-primary">Update Car Park!</button>
</form>