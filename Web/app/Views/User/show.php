<p>Hi! <b><?= $user->FirstName ?></b>, this is the information that we currently have about your account:</p>
<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">Email</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row"><?= $user->Email ?></th>
            <td><?= $user->FirstName ?></td>
            <td><?= $user->LastName ?></td>
        </tr>
    </tbody>
</table>
<?php if ($isAdmin) { ?>
    <button type="button" class="btn btn-danger" disabled><i>THIS ACCOUNT HAS ADMINISTRATOR PRIVILEGES</i></button> <br/> <br/>
<?php } ?>
<a class="btn btn-outline-danger" href="index.php?controller=user&action=update">Update Account Information</a>