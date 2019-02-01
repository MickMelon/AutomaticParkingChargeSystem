<a href="index.php?controller=vehicle&action=add">Add</a><br />
<hr />
<?php if ($errors) foreach($errors as $error) { ?>
<p style="color: red;"><?= $error ?></p>sd
<?php } ?>

<?php if (sizeof($vehicles) <= 0) { ?>
You do not have any vehicles.
<?php }
else foreach ($vehicles as $vehicle) { ?>
<?= $vehicle->Reg ?> - 
<a href="index.php?controller=vehicle&action=remove&reg=<?= $vehicle->Reg ?>">
    Remove
</a> | 
<?php if ($vehicle->HasPermit) { ?>
    Valid Permit
<?php } else { ?>
    <a href="index.php?controller=vehicle&action=purchasepermit&reg=<?= $vehicle->Reg ?>">Purchase Permit</a>
<?php } ?>
<br /><hr />
<?php } ?>

<form action="index.php?controller=vehicle&action=add" method="post">
    Reg: <input type="text" name="reg" />
    <input type="submit" value="Add Vehicle" />
</form>