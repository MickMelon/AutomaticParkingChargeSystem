<a class="btn btn-light" href="index.php?controller=vehicle&action=add">Add Vehicle</a><br />

<hr />

<?php if ($errors) foreach($errors as $error) { ?>
    <p style="color: red;"><?= $error ?></p>
<?php } ?>


<?php if (sizeof($vehicles) <= 0) { ?>
    <button type="button" class="btn btn-secondary" disabled>You do not have any vehicles registered with us.</button>
<?php }
else { ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Regisration Mk.</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle) { ?>
                <tr>
                    <th scope="row"><button type="button" class="btn btn-warning" disabled><strong><?= $vehicle->Reg ?></strong></button></th>
                    <td><a class="btn btn-outline-danger" href="index.php?controller=vehicle&action=remove&reg=<?= $vehicle->Reg ?>">Remove Vehicle</a></td>
                    <td>
                        <?php if ($vehicle->HasPermit) { ?> 
                            <button type="button" class="btn btn-outline-success" disabled>Valid Permit</button>
                        <?php } else { ?>
                            <a class="btn btn-outline-danger" href="index.php?controller=vehicle&action=purchasepermit&reg=<?= $vehicle->Reg ?>">Purchase Permit</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>    
<br /><hr />

<form action="index.php?controller=vehicle&action=add" method="post">
    <div class="form-group">
        <label for="reg">Regisration Mk.:</label>
        <input type="text" name="reg" class="form-control" id="reg" placeholder="e.g. SP63 UNK" minlength="2" maxlength="10" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Vehicle</button>
</form>