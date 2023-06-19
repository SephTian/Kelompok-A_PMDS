<?php
require_once '../vendor/autoload.php';
require "connect_db.php";

//Connect mongodb db
$databaseConnection = new MongoDB\Client("mongodb://localhost:27017");

//connecting specific db in mongodb
$myDatabase = $databaseConnection->pmds;

// //connecting to the collection
$user_collection = $myDatabase->resto;

//Mengambil semua data pada country dari MySQL
$list_country = "SELECT country_id, country_name FROM country";
$result_country = $conn->query($list_country);
$arr_country = array(); //index[id][ 0: country_name]
foreach ($result_country as $row) {
    $arr_country[$row['country_id']] = [$row['country_name']];
}

//Mengambil semua data pada city dari MySQL
$list_city = "SELECT city_id, city_name FROM city";
$result_city = $conn->query($list_city);
$arr_city = array(); //index[id][ 0: city_name]
foreach ($result_city as $row) {
    $arr_city[$row['city_id']] = [$row['city_name']];
}

//taking the data
$grouping_data = ['$group' => ['_id' => ['city_id' => '$city_id', 'country_id' => '$country_id'], 'jumlah_resto' => ['$sum' => 1]]];
$sort_jml_resto = ['$sort' => ['jumlah_resto' => -1]];
$data = $user_collection->aggregate([$grouping_data, $sort_jml_resto]);

//mengambil data yang unik dari setaip colom untuk combo-box
$country_uniq = $user_collection->distinct('country_id');

//ketika button submit filter dipencet
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $country_value = $_POST["country_opt"];
    if (empty($country_value)) {
        $country_value = ["$" . "regex" => ''];
    } else {
        $selected_country = "SELECT country_id FROM country WHERE country_name='$country_value'";
        $result_selected_country = $conn->query($selected_country);
        foreach ($result_selected_country as $row) {
            $country_value = $row['country_id'];
        }
    }

    $match_data = ['$match' => ['_id.country_id' => $country_value]];
    $data = $user_collection->aggregate([$grouping_data, $match_data, $sort_jml_resto]);
}

// print_r($data);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restoran Review</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-color: rgb(255, 161, 84);">

    <!-- bagian navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="index.html" class="navbar-brand mb-0 h2">Restaurant Review</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="resto_list.php">Resto List</a>
                    <a class="nav-link active" araia-current="page" href="">Number of Resto</a>
                    <a class="nav-link" href="resto_best.php">Best Resto</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- bagian bawah navbar -->
    <div class="rounded container my-5" style="background-color: white;padding: 2rem;">
        <div class="container d-flex justify-content-center">
            <p style="font-weight: bold;font-size: 2rem;">Number of Resto by The City</p>
        </div>
        <!-- bagian filter -->
        <div class="container" style="margin: 15px 0;">
            <h3>Filter</h3>
            <form method="post">
                <div class="d-flex gap-3">
                    <div>
                        <!-- Bagian Filter untuk Country -->
                        <label for="country_opt"> Pilih negara: </label><br>
                        <select name="country_opt" id="country_opt">
                            <option></option>
                            <?php
                            foreach ($country_uniq as $country_list) {
                                echo "<option>" . $arr_country[$country_list][0] . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                    </div>
                    <div class="d-flex align-items-end">
                        <button class="btn btn-primary">submit</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- bagian tabel -->
        <div class="table-responsive" style="height:600px">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="table-info">
                        <th>Country</th>
                        <th>City</th>
                        <th>Total Restaurant</th>
                    </tr>
                </thead>
                <tbody class="table table-striped">
                    <?php
                    foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>" . $arr_country[$row['_id']['country_id']][0] . "</td>";
                        echo "<td>" . $arr_city[$row['_id']['city_id']][0] . "</td>";
                        echo "<td>" . $row['jumlah_resto'] . "</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>