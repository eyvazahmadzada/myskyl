<?php
include 'db_connection.php';

$id = $_GET["id"];

if (array_key_exists('delete-row', $_POST)) {
    $sqlDelete = "DELETE from quantitative_data WHERE record_id = ?";
    $stmt = $conn->prepare($sqlDelete);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    $result = $stmt->get_result();
    header("Location: /myskyl/index.php?year=2018");
} else {
    $sql = "SELECT record_id, qualitative_data_1.weather_condition,
    qualitative_data_2.humidity, qualitative_data_3.wind, qualitative_data_4.visibility,
    qualitative_data_5.fog, temprature_celsius, humidity_percent, air_pressure,
    precipitation_percent, quantitative_data.visibility AS visibility_km, cloud_cover_percent,
    record_date FROM quantitative_data INNER JOIN qualitative_data_1 ON
    quantitative_data.weather_condition_id = qualitative_data_1.weather_condition_id
    INNER JOIN qualitative_data_2 ON quantitative_data.humidity_id = qualitative_data_2.humidity_id
    INNER JOIN qualitative_data_3 ON quantitative_data.wind_id = qualitative_data_3.wind_id
    INNER JOIN qualitative_data_4 ON quantitative_data.visibility_id = qualitative_data_4.visibility_id
    INNER JOIN qualitative_data_5 ON quantitative_data.fog_id = qualitative_data_5.fog_id
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.10/css/weather-icons.min.css">
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/details.css">
    <title>MySKYL | Details</title>
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
        <section class="row text-align flex-column animate__animated animate__fadeInLeft">
            <h1><i class="fa fa-calendar"
                    aria-hidden="true"></i><?php echo date_format(date_create($row["record_date"]), "F j, Y") ?>
            </h1>
            <div class="col-lg-6 col-sm-9 mx-auto">
                <div class="row weather">
                    <div class="col-lg-3 col-md-4 temperature">
                        <i class="wi <?php echo $weather_icon ?> weather-icon" aria-hidden="true"></i>
                        <h1 class="degree"><?php echo $row["temprature_celsius"] ?>°</h1>
                        <span class="condition"><?php echo ucfirst($row["weather_condition"]) ?></span>
                    </div>
                    <div class="col-lg-9  col-md-8 info">
                        <div class="details">
                            <div class="part-1">
                                <span><i class="fa fa-tint" aria-hidden="true"></i>Humidity:
                                    <?php echo $row["humidity_percent"] ?>%</span>
                                <span><i class="fa fa-tachometer" aria-hidden="true"></i>Pressure:
                                    <?php echo $row["air_pressure"] ?> hPa</span>
                            </div>
                            <div class="part-2">
                                <span><i class="fa fa-cloud" aria-hidden="true"></i>Precipitation:
                                    <?php echo $row["precipitation_percent"] ?>%</span>
                                <span><i class="fa fa-eye" aria-hidden="true"></i>Visibility:
                                    <?php echo $row["visibility_km"] ?> km</span>
                            </div>
                        </div>
                        <div class="about">The weather is
                            <?php echo $row["weather_condition"] . ', ' . $row["humidity"] . ', ' . $row["wind"] . ', ' . $row["visibility"] . ', ' . $row["fog"] ?>
                        </div>
                        <div class="btns">
                            <button class="custom-btn" type="button"
                                onclick="goToModify(<?php echo $id ?>)">Modify</button>
                            <form action="" method="POST">
                                <button class=" custom-btn delete-btn" name="delete-row" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
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
    function goToModify(id) {
        window.location.replace("/myskyl/modify.php?id=" + id);
    }
    </script>
</body>

</html>