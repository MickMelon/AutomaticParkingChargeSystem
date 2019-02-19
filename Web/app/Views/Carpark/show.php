Car Park

ID: <?= $id ?><br />
Name: <?= $name ?><br />
Price: <?= $price ?><br />
<a href="index.php?controller=carpark&action=update&id=<?= $id ?>">Update</a>
<br />
Usage Logs:
<table border="1">
    <tr>
        <th>Reg</th>
        <th>Entry Time</th>
        <th>Exit Time</th>
    </tr>
    
    <?php foreach ($logs as $log) { ?>
    <tr>
        <td><?= $log->Reg ?></td>
        <td><?= $log->EntryDateTime ?></td>
        <td><?= $log->ExitDateTime ?></td>
    </tr>
    <?php } ?>
</table>