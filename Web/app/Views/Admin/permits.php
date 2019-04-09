<h4>Hourly Rate</h4>
<form action="index.php?controller=admin&action=updatehourlyrate" method="post" onsubmit="return checkHourlyRateForm()">
    <div class="form-group">
        <label for="first">Hourly Rate:</label>
        <input type="price" name="price" class="form-control" id="hourlyPrice" value="<?= $hourlyRate ?>" minlength="0.00" maxlength="100.00" step="0.01" required>
        <small id="price" class="form-text text-muted">Caution: This changes the monthly parking permit price.</small>
    </div>
    <button type="submit" class="btn btn-outline-danger">Update Hourly Rate!</button>
</form>
<br />
<h4>Permits</h4>
<form action="index.php?controller=admin&action=updatepermitprice" method="post" onsubmit="return checkPermitPriceForm()">
    <div class="form-group">
        <label for="first">Permit Price:</label>
        <input type="price" name="price" class="form-control" id="permitPrice" value="<?= $permitPrice ?>" minlength="0.00" maxlength="100.00" step="0.01" required>
        <small id="price" class="form-text text-muted">Caution: This changes the monthly parking permit price.</small>
    </div>
    <button type="submit" class="btn btn-outline-danger">Update Permit Price!</button>
</form>
<br />
<form action="index.php?controller=admin&action=removeallpermits" method="post">
    <div class="form-group">
        <button type="submit" id="rap" class="btn btn-danger">REMOVE ALL CURRENT PERMITS!</button>
        <small id="rap" class="form-text text-muted">DANGER: THIS BUTTON REMOVES ALL PARKING PERMITS FOR THIS CURRENT MONTH.</small>
    </div>
</form>

<script>
function checkHourlyRateForm() {
    var price = document.getElementById("hourlyPrice").value;

    if (price > 100 || price < 0)
    {
        alert("Hourly price cannot be less than 0 or more than 100.");
        return false;
    }

    return true;
}

function checkPermitPriceForm() {
    var price = document.getElementById("permitPrice").value;

    if (price > 100 || price < 0)
    {
        alert("Permit price cannot be less than 0 or more than 100.");
        return false;
    }

    return true;
}
</script>