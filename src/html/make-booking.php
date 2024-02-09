<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $block = $_POST["block"];
  $floor = $_POST["floor"];
  $unit = $_POST["unit"];
  $roomNumber = $_POST["roomNumber"];

  $block = htmlspecialchars($block);
  $floor = htmlspecialchars($floor);
  $unit = htmlspecialchars($unit);
  $roomNumber = htmlspecialchars($roomNumber);


  $studentID = $_SESSION['studentID'];


  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "uniselhostel";


  $conn = new mysqli($servername, $username, $password, $dbname);


  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $existingBooking = $conn->query("SELECT * FROM student WHERE studentID = '$studentID'");

  if ($existingBooking->num_rows > 0) {

    $stmt = $conn->prepare("UPDATE student SET block = ?, floor = ?, unit = ?, roomNumber = ? WHERE studentID = ?");
    $stmt->bind_param("sssss", $block, $floor, $unit, $roomNumber, $studentID);
  } else {

    $stmt = $conn->prepare("INSERT INTO student (studentID, block, floor, unit, roomNumber, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $studentID, $block, $floor, $unit, $roomNumber);
  }
  if ($stmt->execute()) {
    $message = "Booking successful!";
  } else {
    $error = "Error: " . $stmt->error;
  }
  $stmt->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UNISEL HOSTEL MANAGEMENT SYSTEM</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logounisel.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <style>
    body {
      background: url('../assets/images/backgrounds/backimage5.png') no-repeat center center fixed;
      background-size: cover;
    }

    .logout-btn {
      background-color: #f7a500;
      color: #000000;
      border: none;
    }
    .card {
      max-width: 650px;
      margin: auto;
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar bg-light">
      <div>
        <br></br>
        <div class="brand-logo d-flex align-items-center justify-content-between mb-10">
          <a href="./index.php" class="text-nowrap logo-img">
            <img src="../assets/images/logos/logounisel.png" width="200" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar bg-light text-white" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./index.php" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Memo</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">MENU</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./make-booking.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Make Booking</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./check-status.php" aria-expanded="false">
                <span>
                  <i class="ti ti-alert-circle"></i>
                </span>
                <span class="hide-menu">Booking Details</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
    <div class="body-wrapper">
      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
          <li class="nav-item dropdown">

            <a href="./student-login.php" class="btn btn-outline-primary mx-3 mt-4 d-block logout-btn">Logout</a>
          </li>
        </ul>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
          <div class="card">
            <div class="card-body text-justify bg-light py-1 rounded p-4">
              <h5 class="text-center mb-3 mt-2"><strong>Room Booking</strong></h5>
              <form method="post" action="make-booking.php" id="roomBookingForm">
                <div class="mb-3">
                  <label for="blockSelection" class="form-label">Block:</label>
                  <select class="form-select" id="blockSelection" name="block">
                    <option value="Block A">Block
                      A</option>
                    <option value="Block B">Block
                      B</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="floorSelection" class="form-label">Floor:</label>
                  <select class="form-select" id="floorSelection" name="floor">
                    <option value="Floor 1">Floor
                      1</option>
                    <option value="Floor 2">Floor
                      2</option>
                    <option value="Floor 3">Floor
                      3</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="unitSelection" class="form-label">Unit:</label>
                  <select class="form-select" id="unitSelection" name="unit">
                    <option value="Unit 1">Unit
                      1</option>
                    <option value="Unit 2">Unit
                      2</option>
                    <option value="Unit 3">Unit
                      3</option>
                    <option value="Unit 4">Unit
                      4</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="roomNumberSelection" class="form-label">Room
                    Number:</label>
                  <select class="form-select" id="roomNumberSelection" name="roomNumber">
                    <option value="Room 1">Room
                      1</option>
                    <option value="Room 2">Room
                      2</option>
                    <option value="Room 3">Room
                      3</option>
                  </select>
                </div>
                <div class="text-center mt-3">
                  <button type="submit" class="btn btn-primary mb-2">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>