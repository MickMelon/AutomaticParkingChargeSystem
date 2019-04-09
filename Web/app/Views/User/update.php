<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
 ?>

<form action="index.php?controller=user&action=submitupdate" method="post" onsubmit="return checkForm()">
    <div class="form-group">
        <label for="first">First Name:</label>
        <input type="text" name="firstName" class="form-control" id="first" value="<?= $user->FirstName ?>" minlength="3" maxlength="16" required>
    </div>
    <div class="form-group">
        <label for="last">Last Name:</label>
        <input type="text" name="lastName" class="form-control" id="last" value="<?= $user->LastName ?>" minlength="3" maxlength="16" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="**********" minlength="6" required>
    </div>
    <div class="form-group">
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="**********" minlength="6" required>
    </div>
    <input type="hidden" name="userId" value="<?= $user->ID ?>" />
    <button type="submit" class="btn btn-primary">Update My Information!</button>
</form>

<script>
function checkForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    if (password === confirmPassword) return true;

    alert("Entered passwords do not match.");
    return false;
}
</script>