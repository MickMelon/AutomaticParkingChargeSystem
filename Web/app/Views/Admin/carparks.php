<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th></th>
    </tr>
    <?php foreach($carparks as $carpark) { ?>
    <tr>
        <td><?= $carpark->ID ?></td>
        <td><?= $carpark->Name ?></td>
        <td><?= $carpark->Price ?></td>
        <td><a href="index.php?controller=admin&action=updatecarpark&id=<?= $carpark->ID ?>">Update</a></td>
    </tr>
    <?php } ?>
</table>