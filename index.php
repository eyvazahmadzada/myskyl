<?php
include 'db_connection.php';

$isLoading = true;
if (isset($_GET["year"])) {
    $currentYear = $_GET["year"];
    $sql = "SELECT record_id, qualitative_data_1.weather_condition, qualitative_data_2.humidity,
        qualitative_data_3.wind, qualitative_data_4.visibility, qualitative_data_5.fog,
        temprature_celsius, humidity_percent, air_pressure, precipitation_percent,
        quantitative_data.visibility AS visibility_km, cloud_cover_percent, record_date FROM
        quantitative_data INNER JOIN qualitative_data_1 ON
        quantitative_data.weather_condition_id = qualitative_data_1.weather_condition_id
        INNER JOIN qualitative_data_2 ON quantitative_data.humidity_id = qualitative_data_2.humidity_id
        INNER JOIN qualitative_data_3 ON quantitative_data.wind_id = qualitative_data_3.wind_id
        INNER JOIN qualitative_data_4 ON quantitative_data.visibility_id = qualitative_data_4.visibility_id
        INNER JOIN qualitative_data_5 ON quantitative_data.fog_id = qualitative_data_5.fog_id
        WHERE YEAR(record_date) = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $currentYear);
        $stmt->execute();
    }
    $result = $stmt->get_result();
    $isLoading = false;

    $conn->close();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/index.css">
    <title>MySKYL | Home</title>
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
                    <li class="nav-item active">
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

        <?php
if (!$isLoading && $result->num_rows > 0) {
    echo
        '<section class="row justify-content-center' . (!$isLoading ? ' animate__animated animate__bounceInDown' : '') . '">
            <div class="header col-md-12 col-11">
                <h3>WEATHER RECORDS</h3>
                <p>“There is no such thing as bad weather, only different kinds of good weather” - John Ruskin
                </p>
            </div>
        </section>
        <section class="row justify-content-center mb-4">
            <div class="col-lg-7 col-md-9">
                <div class="row">
                    <div class="col-sm-4 btn-col">
                        <a class="category-btn ' . ($_GET["year"] == 2018 ? "active" : "") . '"
                href="index.php?year=2018">2018</a>
            </div>
            <div class="col-sm-4 btn-col">
                <a class="category-btn ' . ($_GET["year"] == 2019 ? "active" : "") . '"
                    href="index.php?year=2019">2019</a>
            </div>
            <div class="col-sm-4 btn-col">
                <a class="category-btn ' . ($_GET["year"] == 2020 ? "active" : "") . '"
                    href="index.php?year=2020">2020</a>
            </div>
        </section>
        <section class="row justify-content-center">
            <div class="col-11">
                <div class="row justify-content-center align-items-center">';
    while ($row = $result->fetch_assoc()) {
        $weather_icon;
        switch ($row["weather_condition"]) {
            case "cold":
                $weather_icon = "wi-snowflake-cold";
                break;
            case "mild":
                $weather_icon = "wi-day-cloudy";
                break;
            case "warm":
                $weather_icon = "wi-hot";
                break;
            case "sunny":
                $weather_icon = "wi-day-sunny";
                break;
            case "chilly":
                $weather_icon = "wi-day-sunny-overcast";
                break;
            default:
                $weather_icon = "wi-day-cloudy";
        }
        echo '<div class="col-lg-4 col-md-6" onclick="goToDetails(' . $row["record_id"] . ')">
                <div class="weather-card animate__animated animate__fadeInLeft animate__faster">
                    <i class="wi ' . $weather_icon . ' weather-icon" aria-hidden="true"></i>
                    <h2 class="degree">' . $row["temprature_celsius"] . '°</h2>
                    <span class="condition">' . ucfirst($row["weather_condition"]) . '</span>
                    <div class="details">
                        <div class="part-1">
                            <span><i class="fa fa-tint" aria-hidden="true"></i>Humidity: ' . $row["humidity_percent"] . '%</span>
                            <span><i class="fa fa-tachometer" aria-hidden="true"></i>Pressure: ' . $row["air_pressure"] . ' hPa</span>
                        </div>
                        <div class="part-2">
                            <span><i class="fa fa-cloud" aria-hidden="true"></i>Precipitation: ' . $row["precipitation_percent"] . '%</span>
                            <span><i class="fa fa-eye" aria-hidden="true"></i>Visibility: ' . $row["visibility_km"] . ' km</span>
                        </div>
                    </div>
                    <span class="date">' . date_format(date_create($row["record_date"]), "F j, Y") . ' </span>
                </div>
            </div>';
    }
    echo '</div></div></section>';
} else {
    echo '<section class="loader-wrapper">
        <div class="loader"></div>
    </section>';
}
?>
    </main>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.location.href.indexOf("year") === -1) {
            const aTag = document.createElement("a");
            aTag.href = "index.php?year=2018";
            document.body.appendChild(aTag);
            aTag.click();
            aTag.remove();
        }
        const cardAnimations = document.querySelectorAll(".animate__fadeInLeft");
        cardAnimations.forEach(function(item, index) {
            item.style.animationDelay = (index / 5) + 's';
        });
    });

    function goToDetails(id) {
        window.location.replace("/myskyl/details.php?id=" + id);
    }
    </script>
</body>

</html>