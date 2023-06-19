<?php

require_once '../vendor/autoload.php';
require "connect_db.php";

//Connect mongodb db
$databaseConnection = new MongoDB\Client("mongodb://localhost:27017");

//connecting specific db in mongodb
$myDatabase = $databaseConnection->pmds;

//connecting to the collection
$user_collection = $myDatabase->resto;

// Check if the sort value is specified in the request
$sortValue = isset($_GET['sort']) ? $_GET['sort'] : 'highest';

// Set the sort direction based on the selected option
$sortDirection = $sortValue === 'lowest' ? 1 : -1;

// Find and sort the documents by "angka_rating" field
$data = $user_collection->find([], ['sort' => ['angka_rating' => $sortDirection]]);

//Mengambil semua data pada cuisine dari MySQL
$list_cuisine = "SELECT cuisine_id, cuisine_name FROM cuisine";
$result_cuisine = $conn->query($list_cuisine);
$arr_cuisine = array(); //index[id][ 0: cuisine_name]
foreach ($result_cuisine as $row) {
    $arr_cuisine[$row['cuisine_id']] = [$row['cuisine_name']];
}

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

//Mengambil semua data pada rating dari MySQL
$list_rating = "SELECT rating_id, rating_text, rating_color FROM rating";
$result_rating = $conn->query($list_rating);
$arr_rating = array(); //index[id][ 0: rating_text, 1:  rating_color]
foreach ($result_rating as $row) {
    $arr_rating[$row['rating_id']] = [$row['rating_text'], $row['rating_color']];
}

//mengambil data yang unik dari setaip colom untuk combo-box
$cuisine_uniq = $user_collection->distinct('cuisine');
$country_uniq = $user_collection->distinct('country_id');

//ketika button submit filter dipencet
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Mengubah value pada opsi cuisine
    $cuisine_value = $_POST["cuisine_opt"];
    if (empty($cuisine_value)) {
        $cuisine_value = ["$" . "regex" => ''];
    } else {
        $selected_cuisine = "SELECT cuisine_id FROM cuisine WHERE cuisine_name='$cuisine_value'";
        $result_selected_cuisine = $conn->query($selected_cuisine);
        foreach ($result_selected_cuisine as $row) {
            $cuisine_value = $row['cuisine_id'];
        }
    }

    // Mengubah value pada opsi country
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

    $data = $user_collection->aggregate([['$match' => ['country_id' => $country_value, 'cuisine' => $cuisine_value]], ['$sort' => ['angka_rating' => $sortDirection]]]);
}

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
                    <a class="nav-link active" aria-current="page" href="">Resto List</a>
                    <a class="nav-link" href="resto_num.php">Number of Resto</a>
                    <a class="nav-link" href="resto_best.php">Best Resto</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- bagian bawah navbar -->
    <div class="rounded container my-5" style="background-color: white;padding: 2rem;">
        <div class="container d-flex justify-content-center">
            <p style="font-weight: bold;font-size: 2rem;">Restaurant list</p>
        </div>
        <!-- bagian filter -->
        <div class="container d-flex justify-content-between" style="margin: 15px 0;">
            <div>
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

                        <div>
                            <!-- Bagian Filter untuk Cuisine -->
                            <label for="cuisine_opt"> Pilih cuisine: </label><br>
                            <select name="cuisine_opt" id="cuisine_opt">
                                <option></option>
                                <?php
                                foreach ($cuisine_uniq as $cuisine_list) {
                                    echo "<option>" . $arr_cuisine[$cuisine_list][0] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-flex align-items-end">
                            <button class="btn btn-primary">submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-flex align-items-end">
                <?php
                // Add the dropdown for sort options
                $html = '<form method="GET">';
                $html .= '<label for="sort-select">Sort By:</label>';
                $html .= '<br>';
                $html .= '<select id="sort-select" name="sort" onchange="this.form.submit()">';
                $html .= '<option value="highest" ' . ($sortValue === 'highest' ? 'selected' : '') . '>Highest Rating</option>';
                $html .= '<option value="lowest" ' . ($sortValue === 'lowest' ? 'selected' : '') . '>Lowest Rating</option>';
                $html .= '</select>';
                $html .= '</form>';
                echo $html;
                ?>
            </div>
        </div>

        <!-- bagian tabel -->
        <div class="table-responsive" style="height:600px">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="table-info">
                        <th>Restoran</th>
                        <th>cuisine</th>
                        <th>Localization</th>
                        <th>Address</th>
                        <th>Table book?</th>
                        <th>Price range</th>
                        <th>Rating</th>
                        <th>Votes</th>
                    </tr>
                </thead>
                <tbody class="table table-striped">
                    <?php

                    // Menampilkan data pada tabel
                    foreach ($data as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['resto_name'] . "</td>";
                        $kumpulan_cuisine = "";
                        foreach ($row["cuisine"] as $cui) {
                            $kumpulan_cuisine .= $arr_cuisine[$cui][0] . " ";
                        }
                        echo "<td>" . $kumpulan_cuisine . "</td>";
                        echo "<td>" . $arr_city[$row['city_id']][0] . " - " . $arr_country[$row['country_id']][0] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['table_book'] . "</td>";
                        echo "<td>" . $row['price_range'] . "</td>";
                        echo "<td>";
                        echo "<div class='rounded' style='background-color:" . str_replace(' ', '', $arr_rating[$row['rating_id']][1]) . "'>";
                        echo "<p class='' style='font-weight: bold; margin:0px'>" . $row['angka_rating'] . " - " . $arr_rating[$row['rating_id']][0] . "</p>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td>" . $row['votes'] . "</td>";
                        echo "</tr>";
                        //border border-primary
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>