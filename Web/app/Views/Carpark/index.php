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
        <td>
            <a href="index.php?controller=carpark&action=show&id=<?= $carpark->ID ?>">
                <?= $carpark->Name ?>
            </a>
        </td>
        <td><?= $carpark->Price ?></td>
        <td><a href="index.php?controller=carpark&action=update&id=<?= $carpark->ID ?>">Update</a></td>
    </tr>
    <?php } ?>
</table>