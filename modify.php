<?php
include 'db_connection.php';

$id = $_GET["id"];

if (array_key_exists('modify-row', $_POST) && isset($_POST["temperature"])
    && isset($_POST["airpressure"])
    && isset($_POST["visibility_km"])
    && isset($_POST["humidity_percent"])
    && isset($_POST["precipitation"])
    && isset($_POST["cloudcover"])
    && isset($_POST["weather-condition"])
    && isset($_POST["humidity"])
    && isset($_POST["wind"])
    && isset($_POST["visibility"])
    && isset($_POST["fog"])
) {
    $temperature = $_POST["temperature"];
    $humidity_percent = $_POST["humidity_percent"];
    $airpressure = $_POST["airpressure"];
    $precipitation = $_POST["precipitation"];
    $visibility_km = $_POST["visibility_km"];
    $cloudcover = $_POST["cloudcover"];
    $weather_condition = $_POST["weather-condition"];
    $humidity = $_POST["humidity"];
    $wind = $_POST["wind"];
    $visibility = $_POST["visibility"];
    $fog = $_POST["fog"];

    $sqlModify = "UPDATE quantitative_data SET
            quantitative_data.temprature_celsius = ?,
            quantitative_data.humidity_percent = ?,
            quantitative_data.air_pressure = ?,
            quantitative_data.precipitation_percent = ?,
            quantitative_data.visibility = ?,
            quantitative_data.cloud_cover_percent = ?,
            quantitative_data.weather_condition_id = ?,
            quantitative_data.humidity_id = ?,
            quantitative_data.wind_id = ?,
            quantitative_data.visibility_id = ?,
            quantitative_data.fog_id = ? WHERE
            quantitative_data.record_id = ?;";

    $stmt = $conn->prepare($sqlModify);
    if ($stmt) {
        $stmt->bind_param("ddddddiiiiii", $temperature, $humidity_percent, $airpressure,
            $precipitation, $visibility_km, $cloudcover, $weather_condition, $humidity, $wind,
            $visibility, $fog, $id);
        $stmt->execute();
    }
    $result = $stmt->get_result();
    header("Location: /myskyl/details.php?id=$id");

} else {
    $sql = "SELECT record_id, weather_condition_id, humidity_id,
     wind_id, visibility_id, fog_id,
     temprature_celsius, humidity_percent, air_pressure, precipitation_percent,
     visibility AS visibility_km, cloud_cover_percent, record_date
     FROM quantitative_data
     WHERE record_id = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/add_data.css">
    <title>MySKYL | Modify</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-light">
            <a class="navbar-brand" href="index.php?year=2018"><img src="assets/logo.png" alt="logo" class="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <img src="assets/navbar-toggler.png" alt="navbar-toggler" class="navbar-toggler-icon">
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?year=2018">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="statistics.php?year=2018">STATISTICS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_data.php">ADD DATA</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container-fluid">
        <section class="row justify-content-center">
            <div class="col-lg-9 col-md-10 col-11">
                <form action="" method="post">
                    <div class="form-data">
                        <h4 class="section-header animate__animated animate__fadeInLeft">Quantitative values</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <label for="temperature">Temperature in celsius</label>
                                    <input type="text" class="form-control" name="temperature" id="temperature"
                                        value="<?php echo $row["temprature_celsius"] ?>">
                                </div>
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <label for="airpressure">Air pressure in hPa</label>
                                    <input type="text" class="form-control" name="airpressure" id="airpressure"
                                        value="<?php echo $row["air_pressure"] ?>">
                                </div>
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <label for="visibility_km">Visibility in km</label>
                                    <input type="text" class="form-control" name="visibility_km" id="visibility_km"
                                        value="<?php echo $row["visibility_km"] ?>">
                                </div>
                            </div>
                            <div class=" col-sm-6">
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <label for="humidity_percent">Humidity percentage</label>
                                    <input type="text" class="form-control" name="humidity_percent"
                                        id="humidity_percent" value="<?php echo $row["humidity_percent"] ?>">
                                </div>
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <label for="precipitation">Precipitation percentage</label>
                                    <input type="text" class="form-control" name="precipitation" id="precipitation"
                                        value="<?php echo $row["precipitation_percent"] ?>">
                                </div>
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <label for="cloudcover">Cloud cover percentage</label>
                                    <input type="text" class="form-control" name="cloudcover" id="cloudcover"
                                        value="<?php echo $row["cloud_cover_percent"] ?>">
                                </div>
                            </div>
                        </div>

                        <h4 class="section-header animate__animated animate__fadeInLeft">Qualitative values</h4>
                        <div class="row justify-content-center">
                            <div class="col-sm-6">
                                <select name="weather-condition"
                                    class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How is the weather?</option>
                                    <option <?php echo $row["weather_condition_id"] == "1" ? "selected" : "" ?>
                                        value="1">
                                        Cold</option>
                                    <option <?php echo $row["weather_condition_id"] == "2" ? "selected" : "" ?>
                                        value="2">
                                        Mild</option>
                                    <option <?php echo $row["weather_condition_id"] == "3" ? "selected" : "" ?>
                                        value="3">
                                        Warm</option>
                                    <option <?php echo $row["weather_condition_id"] == "4" ? "selected" : "" ?>
                                        value="4">
                                        Sunny</option>
                                    <option <?php echo $row["weather_condition_id"] == "5" ? "selected" : "" ?>
                                        value="5">
                                        Chilly</option>
                                </select>
                                <select name="humidity" class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How humid the weather is?</option>
                                    <option <?php echo $row["humidity_id"] == "1" ? "selected" : "" ?> value="1">Wet
                                    </option>
                                    <option <?php echo $row["humidity_id"] == "2" ? "selected" : "" ?> value="2">Humid
                                    </option>
                                    <option <?php echo $row["humidity_id"] == "3" ? "selected" : "" ?> value="3">Dry
                                    </option>
                                    <option <?php echo $row["humidity_id"] == "4" ? "selected" : "" ?> value="4">Rainy
                                    </option>
                                    <option <?php echo $row["humidity_id"] == "5" ? "selected" : "" ?> value="5">Soggy
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select name="wind" class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How windy the weather is?</option>
                                    <option <?php echo $row["wind_id"] == "1" ? "selected" : "" ?> value="1">Windy
                                    </option>
                                    <option <?php echo $row["wind_id"] == "2" ? "selected" : "" ?> value="2">Breezy
                                    </option>
                                    <option <?php echo $row["wind_id"] == "3" ? "selected" : "" ?> value="3">
                                        Blustery</option>
                                    <option <?php echo $row["wind_id"] == "4" ? "selected" : "" ?> value="4">Gusty
                                    </option>
                                    <option <?php echo $row["wind_id"] == "5" ? "selected" : "" ?> value="5">Blowy
                                    </option>
                                </select>
                                <select name="visibility" class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How visible the weather is?</option>
                                    <option <?php echo $row["visibility_id"] == "1" ? "selected" : "" ?> value="1">Clear
                                    </option>
                                    <option <?php echo $row["visibility_id"] == "2" ? "selected" : "" ?> value="2">
                                        Conspicuous</option>
                                    <option <?php echo $row["visibility_id"] == "3" ? "selected" : "" ?> value="3">
                                        Invisible</option>
                                    <option <?php echo $row["visibility_id"] == "4" ? "selected" : "" ?> value="4">
                                        Detectable
                                    </option>
                                    <option <?php echo $row["visibility_id"] == "5" ? "selected" : "" ?> value="5">
                                        Discernible</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select name="fog" class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How foggy the weather is?</option>
                                    <option <?php echo $row["fog_id"] == "1" ? "selected" : "" ?> value="1">
                                        Hazy
                                    </option>
                                    <option <?php echo $row["fog_id"] == "2" ? "selected" : "" ?> value="2">
                                        Misty
                                    </option>
                                    <option <?php echo $row["fog_id"] == "3" ? "selected" : "" ?> value="3">
                                        Smoggy
                                    </option>
                                    <option <?php echo $row["fog_id"] == "4" ? "selected" : "" ?> value="4">
                                        Fuzzy
                                    </option>
                                    <option <?php echo $row["fog_id"] == "5" ? "selected" : "" ?> value="5">
                                        Murky
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="custom-btn animate__animated animate__fadeInLeft" name="modify-row"
                        type="submit">Modify</button>
                </form>
            </div>
        </section>
    </main>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const formAnimations = document.querySelectorAll(".animate__fadeInLeft");
        formAnimations.forEach(function(item, index) {
            item.style.animationDelay = (index / 10) + 's';
            item.style.animationDuration = '0.25s';
        });
    });
    </script>
</body>

</html>