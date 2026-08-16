<header>
<?php
session_start();
$strJSONContents = file_get_contents("cars.json");
$array = json_decode($strJSONContents, true);
$carname_array = array();
foreach ($array["cars"] as &$car) {
    $string = $car['Brand'].' '.$car['Car Model'];
    array_push($carname_array,$string);
}

if (isset($_SESSION['search_history'])) {
    if (isset($_REQUEST['car_search'])) {
        if (!in_array($_REQUEST['car_search'], $_SESSION['search_history']))
        {
            array_push($_SESSION['search_history'], $_REQUEST['car_search']);
        }
    }
}
else {
    $_SESSION['search_history'] = array();
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
        <form class="d-flex col-lg-6" role="search" action="index.php">
            <div class="input-group autocomplete">
                <input id ="search" autocomplete="off" class="form-control" name="car_search" type="search" placeholder="Search for a car..." aria-label="Search">
                <span class="input-group-text">
                    <button class="btn btn-link p-0" type="submit" value="Retrieve Data">
                        <i class="bi bi-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <a class="btn btn-outline-primary text-decoration-none d-flex col-2" href="reservation.php">
            <i class="bi bi-car-front-fill align-middle my-auto h3"></i>
            <span class="my-auto align-middle px-2" id="reservation-cart">
                Reservation
            </span>
        </a>
    </div>
</nav>

<script>
// autocomplete code adapted/modified from w3schools
function AutoComplete(search, array) {
    var selectedItem;

    search.addEventListener("input", function(e) { // event listener for reading input
        var container = this.value; // container for the autocomplete list
        var match, inputValue = this.value;
        var i = this.value;
        closeAllLists();
        selectedItem = -1; // -1 so no item is being selected
        container = document.createElement("div");
        container.setAttribute("id", this.id + "autocomplete-list");
        container.setAttribute("class", "autocomplete-items d-flex flex-column col-12 bg-white"); // add bootstrap classes
        this.parentNode.appendChild(container);

        if (inputValue == "")
        {
            var history = <?php echo json_encode(array_filter($_SESSION['search_history'])); ?>;
            container.innerHTML = "<h5 class='px-3 pt-3'>Recent Searches</h5>";
            if (history.length > 0) {
                for (i = 0; i < history.length; i++) {
                    recentSearch = document.createElement("div");
                    recentSearch.setAttribute("class", "container-fluid px-4");
                    recentSearch.innerHTML = history[i];
                    recentSearch.innerHTML += "<input type='hidden' value='" + history[i] + "'>";

                    recentSearch.addEventListener("click", function(e) {
                        search.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                container.appendChild(recentSearch);
                }
            }
        }
        else 
        {
            container.innerHTML = "";
            for (i = 0; i < array.length; i++) {
                if (array[i].substr(0, inputValue.length).toLowerCase() == inputValue.toLowerCase()) {
                    match = document.createElement("div");
                    match.setAttribute("class", "container-fluid px-4");
                    match.innerHTML = array[i].substr(0, inputValue.length);
                    match.innerHTML += "<b>" + array[i].substr(inputValue.length) + "</b>";
                    match.innerHTML += "<input type='hidden' value='" + array[i] + "'>";
                    
                    match.addEventListener("click", function(e) {
                        search.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    container.appendChild(match);
                }
            }
        }
    });

    search.addEventListener("click", function(e) {
        var container = this.value; // container for the autocomplete list
        selectedItem = -1; // -1 so no item is being selected
        container = document.createElement("div");
        container.setAttribute("id", this.id + "autocomplete-list");
        container.setAttribute("class", "autocomplete-items d-flex flex-column col-12 bg-white"); // add bootstrap classes
        container.innerHTML = "<h5 class='px-3 pt-3'>Recent Searches</h5>";
        this.parentNode.appendChild(container);
        if (this.value == null || this.value == "") {
            var history = <?php echo json_encode(array_filter($_SESSION['search_history'])); ?>;
            if (history.length > 0) {
                for (i = 0; i < history.length; i++) {
                    var recentSearch = document.createElement("div");
                    recentSearch.setAttribute("class", "container-fluid px-4");
                    recentSearch.innerHTML = history[i];
                    recentSearch.innerHTML += "<input type='hidden' value='" + history[i] + "'>";

                    recentSearch.addEventListener("click", function(e) {
                        search.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                container.appendChild(recentSearch);
                }
            }
        }
    });

    function setActive(list) {
        if (list == null) return false;
        removeActive(list);
        if (currentFocus >= list.length) // check if current focus is out of bounds
        {
            currentFocus = 0;
        }

        if (currentFocus < 0) // check if current focus is out of bounds
        {
            currentFocus(list.length - 1);
        }
        list[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(list) {
        for (var i = 0; i < list.length; i++) {
            list[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(element) {
        var autocompleteList = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < autocompleteList.length; i++) {
            if (element != autocompleteList[i] && element != search) {
                autocompleteList[i].parentNode.removeChild(autocompleteList[i]);
            }
        }
    }

    document.addEventListener("click", function (e) {
        closeAllLists(e.target); // close when another part of the page is clicked
    });
}
</script>
<script>
    var carname_array = <?php echo json_encode($carname_array); ?>;
    var search = document.getElementById("search");
    AutoComplete(search, carname_array);
</script>
</header>