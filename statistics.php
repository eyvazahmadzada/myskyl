<?php
$servername = "mysql-eyvazahmadzada12.alwaysdata.net";
$username = "190166";
$password = "e3665097";
$dbname = "eyvazahmadzada12_weather";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$isLoading = true;
$currentMonth = 1;
if (isset($_GET["year"]) && array_key_exists('show', $_POST)) {
    $currentYear = $_GET["year"];
    $currentMonth = $_POST['month'];
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
        WHERE YEAR(record_date) = $currentYear AND MONTH(record_date) = $currentMonth";
    $result = $conn->query($sql);
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
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/statistics.css">
    <title>MySKYL | Statistics</title>
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
                    <li class="nav-item active">
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
            <div class="header col-12">
                <h3>ANALYSIS OF THE WEATHER RECORDS</h3>
                <p>“A change in the weather is sufficient to recreate the world and ourselves” - Marcel Proust
                </p>
            </div>
        </section>

        <section class="row justify-content-center mb-4">
            <div class="col-lg-7 col-md-9">
                <div class="row">
                    <div class="col-sm-4 btn-col">
                        <a class="category-btn <?php if ($_GET["year"] == 2018) {echo "active";}?>"
                            href="statistics.php?year=2018">2018</a>
                    </div>
                    <div class="col-sm-4 btn-col">
                        <a class="category-btn <?php if ($_GET["year"] == 2019) {echo "active";}?>"
                            href="statistics.php?year=2019">2019</a>
                    </div>
                    <div class="col-sm-4 btn-col">
                        <a class="category-btn <?php if ($_GET["year"] == 2020) {echo "active";}?>"
                            href="statistics.php?year=2020">2020</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="row justify-content-center mb-4">
            <div class="col-lg-4 col-sm-6 col-9">
                <span class="data-per-header">DISPLAY DATA FOR</span>
                <form action="" method="POST">
                    <select name="month" class="custom-select">
                        <option <?php echo $currentMonth == 1 ? "selected" : "" ?> value="1">January</option>
                        <option <?php echo $currentMonth == 2 ? "selected" : "" ?> value="2">February</option>
                        <option <?php echo $currentMonth == 3 ? "selected" : "" ?> value="3">March</option>
                        <option <?php echo $currentMonth == 4 ? "selected" : "" ?> value="4">Avril</option>
                        <option <?php echo $currentMonth == 5 ? "selected" : "" ?> value="5">May</option>
                        <option <?php echo $currentMonth == 6 ? "selected" : "" ?> value="6">June</option>
                        <option <?php echo $currentMonth == 7 ? "selected" : "" ?> value="7">July</option>
                        <option <?php echo $currentMonth == 8 ? "selected" : "" ?> value="8">August</option>
                        <option <?php echo $currentMonth == 9 ? "selected" : "" ?> value="9">September</option>
                        <option <?php echo $currentMonth == 10 ? "selected" : "" ?> value="10">October</option>
                        <option <?php echo $currentMonth == 11 ? "selected" : "" ?> value="11">November</option>
                        <option <?php echo $currentMonth == 12 ? "selected" : "" ?> value="12">December</option>
                    </select>
                    <button class="custom-btn" name="show" type="submit">Show</button>
                </form>
            </div>
        </section>
        <section>
            <div class="row">
                <div class="col-lg-6">
                    <canvas class="temperature-chart"></canvas>
                </div>
                <div class="col-lg-6">
                    <canvas class="humidity-chart"></canvas>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6">
                    <canvas class="airpressure-chart"></canvas>
                </div>
                <div class="col-lg-6">
                    <canvas class="precipitation-chart"></canvas>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.location.href.indexOf("year") === -1) {
            const aTag = document.createElement("a");
            aTag.href = "statistics.php?year=2018";
            document.body.appendChild(aTag);
            aTag.click();
            aTag.remove();
        }
    });

    const labels = [<?php while ($row = $result->fetch_assoc()) {echo '"' . date_format(date_create($row["record_date"]), "j M") . '",';}?>];
    <?php mysqli_data_seek($result, 0);?>
    const temp_data = [<?php while ($row = $result->fetch_assoc()) {echo '"' . $row["temprature_celsius"] . '",';}?>];
    <?php mysqli_data_seek($result, 0);?>
    const humidity_data = [<?php while ($row = $result->fetch_assoc()) {echo '"' . $row["humidity_percent"] . '",';}?>];
    <?php mysqli_data_seek($result, 0);?>
    const airpressure_data = [<?php while ($row = $result->fetch_assoc()) {echo '"' . $row["air_pressure"] . '",';}?>];
    <?php mysqli_data_seek($result, 0);?>
    const precipitation_data = [<?php while ($row = $result->fetch_assoc()) {echo '"' . $row["precipitation_percent"] . '",';}?>];

    const temp_ctx = document.querySelector('.temperature-chart');
    const tempChart = new Chart(temp_ctx, {
        type: 'line',
        data: {
            labels: [...labels],
            datasets: [{
                label: 'Change in temperature',
                data: [...temp_data],
                borderColor: '#50759F',
                backgroundColor: "#e5e5e5",
                borderWidth: 2,

            }]
        },
        options: {
            legend: {
                labels: {
                    fontColor: "white",
                    fontSize: 18,
                    fontStyle: "bold",
                    fontFamily: 'Titillium Web',
                    boxWidth: 0
                },
                onClick: (e) => e.stopPropagation()
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "white"
                    },
                    labelString: "Temperature",
                    gridLines: {
                        drawOnChartArea: false
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: "white"
                    },
                    gridLines: {
                        drawOnChartArea: false
                    }
                }]
            }
        }
    });

    const humidity_ctx = document.querySelector('.humidity-chart');
    const humidityChart = new Chart(humidity_ctx, {
        type: 'line',
        data: {
            labels: [...labels],
            datasets: [{
                label: 'Evolution of humidity percentage',
                data: [...humidity_data],
                borderColor: '#50759F',
                backgroundColor: "#e5e5e5",
                borderWidth: 2,

            }]
        },
        options: {
            legend: {
                labels: {
                    fontColor: "white",
                    fontSize: 18,
                    fontStyle: "bold",
                    fontFamily: 'Titillium Web',
                    boxWidth: 0
                },
                onClick: (e) => e.stopPropagation()
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "white"
                    },
                    labelString: "Temperature",
                    gridLines: {
                        drawOnChartArea: false
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: "white"
                    },
                    gridLines: {
                        drawOnChartArea: false
                    }
                }]
            }
        }
    });

    const airpressure_ctx = document.querySelector('.airpressure-chart');
    const airpressureChart = new Chart(airpressure_ctx, {
        type: 'line',
        data: {
            labels: [...labels],
            datasets: [{
                label: 'Variation of air pressure',
                data: [...airpressure_data],
                borderColor: '#50759F',
                backgroundColor: "#e5e5e5",
                borderWidth: 2,

            }]
        },
        options: {
            legend: {
                labels: {
                    fontColor: "white",
                    fontSize: 18,
                    fontStyle: "bold",
                    fontFamily: 'Titillium Web',
                    boxWidth: 0
                },
                onClick: (e) => e.stopPropagation()
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "white"
                    },
                    labelString: "Temperature",
                    gridLines: {
                        drawOnChartArea: false
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontColor: "white"
                    },
                    gridLines: {
                        drawOnChartArea: false
                    }
                }]
            }
        }
    });

    const precipitation_ctx = document.querySelector('.precipitation-chart');
    const precipitationChart = new Chart(precipitation_ctx, {
        type: 'line',
        data: {
            labels: [...labels],
            datasets: [{
                label: 'Change of precipitation percentage',
                data: [...precipitation_data],
                borderColor: '#50759F',
                backgroundColor: "#e5e5e5",
                borderWidth: 2,

            }]
        },
        options: {
            legend: {
                labels: {
                    fontColor: "white",
                    fontSize: 18,
                    fontStyle: "bold",
                    fontFamily: 'Titillium Web',
                    boxWidth: 0
                },
                onClick: (e) => e.stopPropagation()
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontColor: "white",
                        stepSize: 10
                    },
                    labelString: "Temperature",
                    gridLines: {
                        drawOnChartArea: false
                    },
                }],
                xAxes: [{
                    ticks: {
                        fontColor: "white"
                    },
                    gridLines: {
                        drawOnChartArea: false
                    }
                }]
            }
        }
    });
    </script>
</body>

</html>