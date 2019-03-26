<form action="index.php?controller=admin&action=updatepermitprice" method="post">
    <div class="form-group">
        <label for="first">Permit Price:</label>
        <input type="price" name="price" class="form-control" id="price" value="<?= $price ?>" minlength="0.00" maxlength="1000.00" step="0.01" required>
        <small id="price" class="form-text text-muted">Caution: This changes the monthly parking permit price.</small>
    </div>
    <button type="submit" class="btn btn-outline-danger">Update Permit Price!</button>
</form>
<br/>
<br/>
<br/>
<form action="index.php?controller=admin&action=removeallpermits" method="post">
    <div class="form-group">
        <button type="submit" id="rap" class="btn btn-danger">REMOVE ALL CURRENT PERMITS!</button>
        <small id="rap" class="form-text text-muted">DANGER: THIS BUTTON REMOVES ALL PARKING PERMITS FOR THIS CURRENT MONTH.</small>
    </div>
</form>