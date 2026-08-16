<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <script src="https://kit.fontawesome.com/227992c34f.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        session_start();
        $strJSONContents = file_get_contents("cars.json");
        $array = json_decode($strJSONContents, true);
        if (isset($_SESSION['reservation'])) {
            if (isset($_POST['car_id']) && ($_POST['car_id'] != $_SESSION['reservation'])) {
                $car_id = $_POST['car_id'];
                $_SESSION['reservation'] = $car_id;
                ?> 
                <script>
                    localStorage.clear();
                </script>
                <?php
            }
        }
        else if (!isset($_SESSION['reservation']) && isset($_POST['car_id'])) {
            $car_id = $_POST['car_id'];
            $_SESSION['reservation'] = $car_id;
        }
    ?>

<nav class="navbar bg-body-tertiary">
    <div class="container-fluid col-lg-8 p-4">
        <ul class="navbar nav">
            <li class="nav-item">
            <a class="navbar-brand" href="index.php">
                <img src="imgs/logo.svg" height="80"/>  <!-- logo -->
            </a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link" href="index.php">Home</a>
            </li>
        </ul>
        <a class="btn btn-outline-primary text-decoration-none d-flex col-2" href="reservation.php">
            <i class="bi bi-car-front-fill align-middle my-auto h3"></i>
            <span class="my-auto align-middle px-2" id="reservation-cart">
                Reservation
            </span>
        </a>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-between">
        <h2>Current Reservation</h2>
        <div class="col-8">
        
            <?php
                if (isset($_SESSION['reservation']))
                {
                foreach($array['cars'] as &$car) {
                    if ($car['id'] == $_SESSION['reservation']) {?>
                        <div id="reservation" class="col-12 car-card d-flex h-100" style="border: 1px solid #d4d4d4;">
                            <div>
                                <img src="imgs/<?php echo$car['Image'] ?>" class="d-inline-flex h-100" alt="..." width=350>
                            </div>
                            <div class="m-4">
                                <div class="card-header">
                                    <h4 class="card-title"><?php echo $car['Brand']." ".$car['Car Model']; ?></h4>
                                </div>
                                <div class="card-body">
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
                                                <script>var perDayPrice = <?php echo $car['Price/day'] ?>;</script>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    }
                }
                else
                {?>
                    <p>No reservation found.</p>
                <?php }
            ?>
        </div>
        <?php
        if (isset($_SESSION['reservation'])) {
        ?>
        <div class="col-lg-4" style="border: 1px solid #d4d4d4;">
            <form class="p-4 h-100">
                <div class="d-flex my-2">
                    <label class="form-label">Quantity</label>
                    <input id="qty" type="number" name="rental_amt" value="1" size=5 min=1 max=3 class="form-control text-center mx-4" onchange="calculateTotal()" />
                </div>
                <div class="d-flex my-2">
                    <label class="form-label">Start Date</label>
                    <input id="start" type="date" name="rental_start" min="<?php echo date("Y-m-d"); ?>" class="form-control text-center" onchange="calculateTotal()">
                </div>

                <div class="d-flex my-2">
                    <label class="form-label">End Date</label>
                    <input id="end" type="date" name="rental_end" min="<?php echo date("Y-m-d"); ?>" class="form-control text-center" onchange="calculateTotal()">
                </div>
                <input type="hidden" id="total_cost" name="total_cost" value="">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 my-4 text-end">
            <h3>Total: <span id="total">
            </span></h3>
            <div class="d-flex justify-content-end">
                <form action="index.php" method="post" class="px-2">
                    <input type="submit" name="cancel" value="Cancel" class="btn btn-outline-danger btn-lg d-inline-flex"></input>
                </form>
                <a href="orderform.php"><button class="btn btn-outline-primary btn-lg d-inline-flex">Rent a Car</button></a>
            </div>
            
        </div>
    </div>
</div>
<script>
    if (localStorage.length > 0)
    {
        // setting input on page
        document.getElementById("qty").value = parseInt(localStorage.getItem("rent_qty"));
        document.getElementById("total").innerHTML = parseInt(localStorage.getItem("total"));
        document.getElementById("start").value = getDate(new Date(localStorage.getItem("start_date")));
        document.getElementById("end").value = getDate(new Date(localStorage.getItem("end_date")));

        // setting values
        document.getElementById("qty").setValue("value", parseInt(localStorage.getItem("rent_qty")));
        document.getElementById("total_cost").setValue("value", parseInt(localStorage.getItem("total")));
        document.getElementById("start").setValue("value", getDate(new Date(localStorage.getItem("start_date"))));
        document.getElementById("end").setValue("value", getDate(new Date(localStorage.getItem("end_date"))));
    }
    

    function setActualValues() {
        document.getElementById("qty").setValue("value", parseInt(localStorage.getItem("rent_qty")));
        document.getElementById("total_cost").setValue("value", parseInt(localStorage.getItem("total")));
        document.getElementById("start").setValue("value", getDate(new Date(localStorage.getItem("start_date"))));
        document.getElementById("end").setValue("value", getDate(new Date(localStorage.getItem("end_date"))));
    }

    function calculateTotal() {
        var rent_qty = document.getElementById("qty").value;
        var total_cost = rent_qty * perDayPrice * dateDiff();
        document.getElementById("total").innerHTML = total_cost;
        localStorage.setItem("total", total_cost.toString());
        localStorage.setItem("rent_qty", rent_qty.toString());
        setActualValues();
    }
    function dateDiff() {
        var start = new Date(document.getElementById("start").value);
        var end = new Date(document.getElementById("end").value);

        localStorage.setItem("start_date", start.toString());
        localStorage.setItem("end_date", end.toString());

        var diff = Math.abs(start - end);
        return diff / (24 * 3600 * 1000);
    }


    // code from stackoverflow: https://stackoverflow.com/questions/28729634/set-values-in-input-type-date-and-time-in-javascript
    function getDate(date) {
    var day = date.getDate(),
        month = date.getMonth() + 1,
        year = date.getFullYear();

        month = (month < 10 ? "0" : "") + month;
        day = (day < 10 ? "0" : "") + day;

        var formattedDate = year + "-" + month + "-" + day;

        return formattedDate;
    }
</script>
<?php
    }
?>
</body>
</html>