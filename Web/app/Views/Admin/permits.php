<form action="index.php?controller=admin&action=updatepermitprice" method="post">
    Permit Price: <input value="<?= $price ?>" name="price" type="number" min="0.00" max="1000.00" step="0.01" />
    <input type="submit" value="Update Price" />
</form>