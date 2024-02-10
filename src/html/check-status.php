<?php
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['studentID'])) {
    header("Location: student-login.php");
    exit();
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
      <div class="row">
        <div class="col-md-6 mt-4 mx-auto">
          <div class="card">
            <div class="card-body text-justify bg-light py-1 rounded p-4">
            <h5 class="text-center mb-4 mt-2"><strong>Booking Details</strong></h5>
                            <div id="bookingDetails"></div> <!-- Container for booking details -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
fetch('get_booking_status.php')
        .then(response => response.json())
        .then(data => {
            // Display booking details in the container
            const bookingDetailsContainer = document.getElementById('bookingDetails');
            if (data.success) {
                const bookingDetails = data.bookingDetails;

                // Set color based on booking status
                let statusColor = '';
                switch (bookingDetails.status) {
                    case 'APPROVED':
                        statusColor = 'green';
                        break;
                    case 'REJECTED':
                        statusColor = 'red';
                        break;
                    default:
                        statusColor = 'black';
                }

                // Construct HTML with dynamically colored status
                bookingDetailsContainer.innerHTML = `
                    <p><strong>Name:</strong> ${bookingDetails.fullname}</p>
                    <p><strong>Matric ID:</strong> ${bookingDetails.studentID}</p>
                    <p><strong>Block:</strong> ${bookingDetails.block}</p>
                    <p><strong>Floor:</strong> ${bookingDetails.floor}</p>
                    <p><strong>Unit:</strong> ${bookingDetails.unit}</p>
                    <p><strong>Room Number:</strong> ${bookingDetails.roomNumber}</p>
                    <p><strong>Booking Date:</strong> ${bookingDetails.created_at}</p>
                    <p><strong>Booking Status:</strong> <span style="color: ${statusColor}; font-weight: bold;">${bookingDetails.status}</span></p>
                `;
            } else {
                bookingDetailsContainer.innerHTML = `<p class="text-danger">${data.message}</p>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
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