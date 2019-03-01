<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
?>

<form action="index.php?controller=register&action=register" method="post" onsubmit="return checkForm()">
    <div class="form-group">
        <label for="first">First Name:</label>
        <input type="text" name="firstName" class="form-control" id="first" placeholder="e.g. Laura" maxlength="16" required>
    </div>
    <div class="form-group">
        <label for="last">Last Name:</label>
        <input type="text" name="lastName" class="form-control" id="last" placeholder="e.g. Bird" maxlength="16" required>
    </div>
    <div class="form-group">
        <label for="Email">Email Address:</label>
        <input type="email" name="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="e.g. tw@armbands.co.uk" maxlength="128" required>
        <small id="emailHelp" class="form-text text-muted">We value your privacy and don't like GDPR requests so we'll try not to share this with anyone.</small>
    </div>
    <div class="form-group">
        <label for="Password">Password:</label>
        <input type="password" name="password" class="form-control" id="Password" placeholder="**********" minlength="6" required>
    </div>
    <div class="form-group">
        <label for="Passwordconf">Confirm Password:</label>
        <input type="password" name="confirmPassword" class="form-control" id="Passwordconf" placeholder="**********" minlength="6" required>
    </div>
    <button type="submit" class="btn btn-primary">Register!</button>
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