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
    .form-select {
  width: auto;
  min-width: fit-content;
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
<!-- Button filter -->
<div class="mb-3">
  <label for="statusFilter" class="form-label">Filter by Status:</label>
  <select class="form-select" id="statusFilter" onchange="filterRooms()">
    <option value="All">All</option>
    <option value="Available">Available</option>
    <option value="Unavailable">Unavailable</option>
  </select>
</div>

<!-- Table to display rooms -->
<table class="table mt-4 table-bordered table-striped">
  <thead>
    <tr>
      <th>Block</th>
      <th>Floor</th>
      <th>Unit</th>
      <th>Room Number</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody id="roomTableBody">
    <!-- Room data will be displayed here -->
  </tbody>
</table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>


// Function to fetch and display filtered rooms
function filterRooms() {
  const statusFilter = document.getElementById('statusFilter').value;
  fetch('get_rooms.php')
    .then(response => response.json())
    .then(data => {
      const roomTableBody = document.getElementById('roomTableBody');
      roomTableBody.innerHTML = ''; // Clear existing data
      data.forEach(room => {
        if (statusFilter === 'All' || room.status === statusFilter) {
          const row = document.createElement('tr');
          row.innerHTML = `
              <td>${room.block}</td>
              <td>${room.floor}</td>
              <td>${room.unit}</td>
              <td>${room.roomNumber}</td>
              <td>${room.status}</td>
              <td>
              <button class="btn btn-danger btn-sm" onclick="bookHostel(${room.hostelID})" ${room.status !== 'Available' ? 'disabled' : ''}>
                    Book
                </button>
              </td>
          `;
          roomTableBody.appendChild(row);
        }
      });
    });
}
// Function to book hostel room
function bookHostel(hostelID) {
    if (confirm('Are you sure you want to book this room?')) {
        fetch('book_room.php', {
            method: 'POST',
            body: JSON.stringify({ hostelID: hostelID }),
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Booking was successful
                filterRooms(); // Reload the room list
                alert('Room booked successfully!');
            } else {
              alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred, please try again');
        });
    }
}


// Call filterRooms function when the page loads
filterRooms();
</script>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../assets/js/dashboard.js"></script>
</body>

</html>