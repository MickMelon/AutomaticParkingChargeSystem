<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">Car Park ID</th>
            <th scope="col">Car Park Name</th>
            <th scope="col">Current Price (£)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row"><?= $id ?></th>
            <td><?= $name ?></td>
            <td>£<?= $price ?></td>
        </tr>
    </tbody>
</table>
<a class="btn btn-outline-danger" href="index.php?controller=carpark&action=update&id=<?= $id ?>">Update Car Park Information</a>

<br />
<br />
<br />
<h4>Usage Logs</h4>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Regisration Mk.</th>
            <th scope="col">Entry Time</th>
            <th scope="col">Exit Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log) { ?>
        <tr>
            <th scope="row"><button type="button" class="btn btn-warning" disabled><strong><?= $log->Reg ?></strong></button></th>
            <td><?= $log->EntryDateTime ?></td>
            <td><?= $log->ExitDateTime ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>