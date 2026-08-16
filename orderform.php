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
    <?php session_start(); ?>
    
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
        <div class="row py-3 justify-content-between">
            <div class="col-md-8 col-lg-7">
                <main class="py-2">
                <h2>Rental Details</h2>

                <form class="row g-3 needs-validation" novalidate method="post" action="confirmed.php">
                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">First name</label>
                    <input type="text" class="form-control" id="validationCustom01" name="fname" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="validationCustom02" name="lname" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustomEmail" class="form-label">Email</label>
                    <div class="input-group has-validation">
                    <input type="email" class="form-control" id="validationCustomEmail" name="email" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Please enter a valid email.
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustomNumber" class="form-label">Mobile Number</label>
                    <div class="input-group has-validation">
                    <input type="tel" class="form-control" name="num" minlength="10" maxlength="10" id="validationCustomNumber" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Please enter a valid number.
                    </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                        <label class="form-check-label" for="invalidCheck">
                            I have a driver's license.
                        </label>
                        <div class="invalid-feedback">
                            I have a driver's license.
                        </div>
                    </div>
                </div>
                
                <!-- car values -->
                <input id="car_id" type="hidden" name="id" value="<?php echo $_SESSION['reservation'] ?>">
                <input id="car_qty" type="hidden" name="qty" value="">

                <!-- extra form info for database -->
                <input id="order_start" type="hidden" name="start_date" value="">
                <input id="order_end" type="hidden" name="end_date" value="">
                <input id="order_price" type="hidden" name="price" value="">
                <input id="order_status" type="hidden" name="status" value="false">

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Confirm Reservation</button>
                </div>
                </form>


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
                <script>
                (() => {
                    'use strict'

                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    const forms = document.querySelectorAll('.needs-validation')

                    // Loop over them and prevent submission
                    Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                    })
                })()

                </script>
                <script>
                    document.getElementById("car_qty").setValue("value", parseInt(localStorage.getItem("rent_qty")));
                    document.getElementById("order_price").setValue("value", parseInt(localStorage.getItem("total")));
                    document.getElementById("order_start").setValue("value", new Date(localStorage.getItem("start_date")));
                    document.getElementById("order_end").setValue("value", new Date(localStorage.getItem("end_date")));
                </script>
                </main>
            </div>
            <?php

            $strJSONContents = file_get_contents("cars.json");
            $array = json_decode($strJSONContents, true);

            foreach($array['cars'] as &$car) {
                if ($car['id'] == $_SESSION['reservation']) {?>
                    <div class="card col-4 px-0">
                        <div class="card-title p-3">
                            <h2>Current Reservation</h2>
                        </div>
                        <img src="imgs/<?php echo$car['Image'] ?>" class="w-100" alt="...">
                        <div class="card-body">
                            <h4 class="card-title pb-2">
                                <?php echo $car['Brand']." ".$car['Car Model']; ?>
                            </h4>

                            <ul class="list-inline justify-content-evenly d-flex">
                                <li class="list-inline-item">
                                    <i class="bi bi-person-fill"></i>
                                    <span class="my-auto px-2">
                                        <?php echo $car['Seats']; //seat ?>
                                    </span>
                                </li>
                                <li class="list-inline-item">
                                <i class="bi bi-speedometer2"></i>
                                    <span class="my-auto px-2">
                                        <?php echo $car['Mileage']; //seat ?>
                                    </span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="bi bi-currency-dollar"></i>
                                    <span class="my-auto px-2">
                                        <?php echo $car['Price/day']." / day"; //seat ?>
                                    </span>
                                </li>
                            </ul>
                            <ul class="list-inline justify-content-evenly d-flex">
                                <li class="list-inline-item">
                                    <i class="bi bi-calendar"></i>
                                    <span class="my-auto px-2" id="start"></span>
                                </li>
                                <li class="list-inline-item">
                                    to
                                </li>
                                <li class="list-inline-item">
                                    <i class="bi bi-calendar"></i>
                                    <span class="my-auto px-2" id="end"></span>
                                </li>
                            </ul>

                            <hr>
                            <div class="col-12 text-end d-flex justify-content-end">
                                <h5 class="px-2">Quantity:</h5>
                                <h5 id="qty"></h5>
                            </div>
                            <div class="row">
                                <div class="col-12 text-end d-flex justify-content-end">
                                    <h3 class="px-2">Total: </h3>
                                    <h3 id="total"></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
    </div>
    <script>
        var startDate = new Date(localStorage.getItem("start_date"));
        var startDateString = formatDate(startDate);

        var endDate = new Date(localStorage.getItem("end_date"));
        var endDateString = formatDate(endDate);

        document.getElementById("start").innerHTML = startDateString;
        document.getElementById("end").innerHTML = endDateString;
        document.getElementById("qty").innerHTML = parseInt(localStorage.getItem("rent_qty"));
        document.getElementById("total").innerHTML = parseInt(localStorage.getItem("total"));

        function formatDate(date) {
            var year = date.getFullYear().toString();
            var month = String(date.getMonth() + 1).padStart(2, '0')
            var day = String(date.getDate()).padStart(2, '0')

            return day + "/" + month + "/" + year;
        }
    </script>
</body>
</html>
