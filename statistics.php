<?php
include 'db_connection.php';

$isLoading = true;
$currentQuarter = 1;
if (isset($_GET["year"])) {
    $currentYear = $_GET["year"];
    if (isset($_POST['quarter'])) {
        $currentQuarter = $_POST['quarter'];
    }
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
        WHERE YEAR(record_date) = ? AND QUARTER(record_date) = ?
        ORDER BY record_date";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $currentYear, $currentQuarter);
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
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
        <?php
if (!$isLoading) {
    echo '<section class="row justify-content-center' . (!$isLoading ? ' animate__animated animate__bounceInDown' : '') . '">
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
                        <a class="category-btn ' . ($_GET["year"] == 2018 ? "active" : "") . '"
                    href="statistics.php?year=2018">2018</a>
                    </div>
                    <div class="col-sm-4 btn-col">
                        <a class="category-btn ' . ($_GET["year"] == 2019 ? "active" : "") . '"
                    href="statistics.php?year=2019">2019</a>
                    </div>
                    <div class="col-sm-4 btn-col">
                        <a class="category-btn ' . ($_GET["year"] == 2020 ? "active" : "") . '"
                    href="statistics.php?year=2020">2020</a>
                    </div>
                </div>
            </div>
        </section>';
    echo "<section class='row justify-content-center mb-4'>
                <div class='col-lg-4 col-sm-6 col-9'>
                    <span class='data-per-header'>DISPLAY DATA FOR</span>
                    <form action='' method='POST'>
                        <select name='quarter' class='custom-select'>
                            <option " . ($currentQuarter == 1 ? 'selected' : '') . " value='1'>First quarter</option>
                            <option " . ($currentQuarter == 2 ? 'selected' : '') . " value='2'>Second quarter</option>
                            <option " . ($currentQuarter == 3 ? 'selected' : '') . " value='3'>Third quarter</option>
                            <option " . ($currentQuarter == 4 ? 'selected' : '') . " value='4'>Fourth quarter</option>
                        </select>
                        <button class='custom-btn' name='show' type='submit'>Show</button>
                    </form>
                </div>
            </section>
            <section>
                <div class='row'>
                    <div class='col-lg-6'>
                        <canvas class='temperature-chart'></canvas>
                    </div>
                    <div class='col-lg-6'>
                        <canvas class='humidity-chart'></canvas>
                    </div>
                </div>
                <div class='row mt-4 row animate__delay-1s'>
                    <div class='col-lg-6'>
                        <canvas class='airpressure-chart'></canvas>
                    </div>
                    <div class='col-lg-6'>
                        <canvas class='precipitation-chart'></canvas>
                    </div>
                </div>
            </section>";
} else {
    echo '<section class="loader-wrapper">
        <div class="loader"></div>
    </section>';
}
?>

    </main>

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
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>

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
                        fontColor: "white",
                        stepSize: 15
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
                        fontColor: "white",
                        stepSize: 15
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
                        fontColor: "white",
                        stepSize: 200
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
                        stepSize: 15
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