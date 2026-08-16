<?php
$strJSONContents = file_get_contents("cars.json");
$array = json_decode($strJSONContents, true);
?>

<div class="container-fluid col-9">
        <div class="row">
<?php
foreach ($array['cars'] as &$car) {
?>
            <div class="card col-4 mx-3 my-2 car-card p-0" style="width:24rem" onMouseOver="this.style.backgroundColor='#e9e9e9'" onMouseOut="this.style.backgroundColor='#ffffff'">
                <img src="imgs/<?php echo$car['Image'] ?>" class="card-img-top w-100" alt="...">
                <div class="card-body">
                    <h6>
                        <?php echo $car['Brand']; ?>
                    </h6>
                    <h5 class="card-title">
                        <?php echo $car['Car Model']; ?>
                    </h5>
                    <p class="card-text">
                        <?php echo $car['Description:']; ?>
                    </p>

                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <i class="bi bi-person-fill"></i>
                            <span class="my-auto align-middle px-2">
                                <?php echo $car['Seats']; //seat ?>
                            </span>
                        </li>
                        <li class="list-inline-item">
                        <i class="bi bi-speedometer2"></i>
                            <span class="my-auto align-middle px-2">
                                <?php echo $car['Mileage']; //seat ?>
                            </span>
                        </li>
                        <li class="list-inline-item">
                            <i class="bi bi-currency-dollar"></i>
                            <span class="my-auto align-middle px-2">
                                <?php echo $car['Price/day']." / day"; //seat ?>
                            </span>
                        </li>
                    </ul>
                    <form method="post" action="reservation.php" class="text-end">
                        <input type="hidden" name="car_id" value="<?php echo $car['id']?>" />
                        
                        <?php
                            if ($car['Quantity'] > 0) {?>
                            <input type="submit" value="Rent" class="btn btn-outline-primary" />
                        <?php
                            }
                            else { ?>
                            <input type="submit" value="Unavailable" class="btn btn-outline-primary" disabled />
                        <?php
                            }
                        ?>
                        
                    </form>
                </div>
            </div>
<?php
}

?>
        </div>
    </div>