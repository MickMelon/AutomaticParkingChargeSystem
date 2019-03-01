<?php 
if (isset($errors)) { 
    foreach ($errors as $error) {
        echo '<p style="color:red;">' . $error . '</p>';
    } 
} 
 ?>
<form action="index.php?controller=login&action=login" method="post">
    <div class="form-group">
        <label for="Email">Email Address:</label>
        <input type="email" name="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="e.g. tw@armbands.co.uk" required>
        <small id="emailHelp" class="form-text text-muted">We value your privacy and don't like GDPR requests so we'll try not to share this with anyone.</small>
    </div>
    <div class="form-group">
        <label for="Password">Password:</label>
        <input type="password" name="password" class="form-control" id="Password" placeholder="**********" required>
    </div>
    <button type="submit" class="btn btn-primary">Login!</button>
</form>