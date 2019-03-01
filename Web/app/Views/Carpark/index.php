<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">Car Park ID</th>
            <th scope="col">Car Park Name</th>
            <th scope="col">Current Price (£)</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($carparks as $carpark) { ?>
            <tr>
                <th scope="row"><?= $carpark->ID ?></th>
                <td><?= $carpark->Name ?></td>
                <td>£<?= $carpark->Price ?></td>
                <td><a class="btn btn-outline-danger" href="index.php?controller=carpark&action=show&id=<?= $carpark->ID ?>">View Car Park</a></td>
                <td><a class="btn btn-outline-danger" href="index.php?controller=carpark&action=update&id=<?= $carpark->ID ?>">Update Car Park</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>