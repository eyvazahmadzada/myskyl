<?php
include 'db_connection.php';

if (array_key_exists('add-row', $_POST) && isset($_POST["temperature"])
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
    $record_date = date('Y-m-d');
    $record_time = date('h:i:s');

    $sql = "INSERT INTO quantitative_data (record_id, temprature_celsius,
    humidity_percent, air_pressure, precipitation_percent, visibility,
    cloud_cover_percent, record_date, record_time, wind_speed, fog_id,
    wind_id, visibility_id, humidity_id, weather_condition_id)
    VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, 10, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ddddddssiiiii", $temperature, $humidity_percent, $airpressure,
            $precipitation, $visibility_km, $cloudcover, $record_date, $record_time,
            $fog, $wind, $visibility, $humidity, $weather_condition);
        $stmt->execute();
    }
    $result = $stmt->get_result();
    header("Location: /myskyl/index.php?year=2020");

}
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
    <title>MySKYL | Add Data</title>
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
                    <li class="nav-item active">
                        <a class="nav-link" href="add_data.php">ADD DATA</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container-fluid">
        <section class="row justify-content-center animate__animated animate__bounceInDown">
            <div class="header col-md-12 col-11">
                <h3>ADD A NEW RECORD</h3>
                <p>“In the end, all it takes is one small action, by one person. One at a time” - Susan Cooper
                </p>
            </div>
        </section>
        <section class="row justify-content-center">
            <div class="col-lg-9 col-md-10 col-11">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-data">
                        <h4 class="section-header animate__animated animate__fadeInLeft">Quantitative
                            values</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <input type="text" class="form-control" name="temperature"
                                        placeholder="Temperature in celsius">
                                </div>
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <input type="text" class="form-control" name="airpressure"
                                        placeholder="Air pressure in hPa">
                                </div>
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <input type="text" class="form-control" name="visibility_km"
                                        placeholder="Visibility percentage">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <input type="text" class="form-control" name="humidity_percent"
                                        placeholder="Humidity percentage">
                                </div>
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <input type="text" class="form-control" name="precipitation"
                                        placeholder="Precipitation percentage">
                                </div>
                                <div class="form-group animate__animated animate__fadeInLeft">
                                    <input type="text" class="form-control" name="cloudcover"
                                        placeholder="Cloud cover percentage">
                                </div>
                            </div>
                        </div>

                        <h4 class="section-header animate__animated animate__fadeInLeft">Qualitative
                            values</h4>
                        <div class="row justify-content-center">
                            <div class="col-sm-6">
                                <select name="weather-condition"
                                    class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How is the weather?</option>
                                    <option value="1">Cold</option>
                                    <option value="2">Mild</option>
                                    <option value="3">Warm</option>
                                    <option value="4">Sunny</option>
                                    <option value="5">Chilly</option>
                                </select>
                                <select name="humidity" class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How humid the weather is?</option>
                                    <option value="1">Wet</option>
                                    <option value="2">Dry</option>
                                    <option value="3">Rainy</option>
                                    <option value="4">Soggy</option>
                                    <option value="5">Humid</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select name="wind" class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How windy the weather is?</option>
                                    <option value="1">Windy</option>
                                    <option value="2">Breezy</option>
                                    <option value="3">Blustery</option>
                                    <option value="4">Gusty</option>
                                    <option value="5">Blowy</option>
                                </select>
                                <select name="visibility" class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How visible the weather is?</option>
                                    <option value="1">Clear</option>
                                    <option value="2">Conspicuous</option>
                                    <option value="3">Invisible</option>
                                    <option value="4">Fair</option>
                                    <option value="5">Detectable</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select name="fog" class="custom-select animate__animated animate__fadeInLeft">
                                    <option>How foggy the weather is?</option>
                                    <option value="1">Hazy</option>
                                    <option value="2">Misty</option>
                                    <option value="3">Smoggy</option>
                                    <option value="4">Fuzzy</option>
                                    <option value="5">Vague</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="custom-btn animate__animated animate__fadeInLeft" type="submit"
                        name="add-row">Add</button>
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