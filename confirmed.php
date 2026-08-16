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
        // $servername = "awseb-e-kmpmciufwh-stack-awsebrdsdatabase-llrihswtg5n9.cday4s02yxbt.us-east-1.rds.amazonaws.com";
        // $username = "a14360541";
        // $password = "assignment2";
        // $dbname = "assignment2";

        // $connection = mysqli_connect($servername,$username,$password,$dbname);
        // if (!$connection) {
        //     die("Unable to connect");
        // }
        
        // $addUserToDatabase = "insert into orders
        //             values ('"
        //                 .$_POST['email']."','"
        //                 .$_POST['num']."','"
        //                 .$_POST['start_date']."','"
        //                 .$_POST['end_date']."','"
        //                 .$_POST['price']."','false')";

        // if ($connection->query($addUserToDatabase) === TRUE) {
            
        //     } else {
        //     echo "Error: " . $addUserToDatabase . "<br>" . $connection->error;
        //     }
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
        <h2>Reservation confirmed</h2>

        <p>A reservation has been placed for <strong><?php echo $_POST['fname']." ".$_POST['lname'] ?></strong>. Your order details can be found at <?php echo $_POST['email'] ?>.</p>

        <div class="col-12">
        
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
            ?>
        </div>
    </div>
</div>
<?php
unset($_SESSION['reservation'])
?>
<script>
    localStorage.clear();
</script>
</body>
</html>