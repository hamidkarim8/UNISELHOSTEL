<!doctype html>
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
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    .logout-btn {
      background-color: #f7a500;
      color: #000000;
      border: none;
    }

    .card {
      width: 800px;
      margin: auto;
      /* Center the card horizontally */
      margin-top: 50px;
      margin-bottom: 50px;
      /* Add margin at the bottom for spacing */
    }

    .table th {
      font-weight: bold
    }

    .form-select {
      width: auto;
      min-width: fit-content;
    }

    /* Added CSS */
    .search-label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }

    .search-input {
      width: auto;
      min-width: fit-content;
    }

    .mb-3.d-flex {
      flex-direction: row;
    }

    .mb-3.d-flex>div {
      margin-right: 10px;
      /* Adjust margin as needed */
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
          <a href="./adminhomepage.php" class="text-nowrap logo-img">
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
              <a class="sidebar-link" href="./adminhomepage.php" aria-expanded="false">
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
              <a class="sidebar-link" href="./admin-manage-room.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Manage Room</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./admin-manage-booking.php" aria-expanded="false">
                <span>
                  <i class="ti ti-alert-circle"></i>
                </span>
                <span class="hide-menu">Manage Booking</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./admin-manage-student.php" aria-expanded="false">
                <span>
                  <i class="ti ti-alert-circle"></i>
                </span>
                <span class="hide-menu">Manage Student</span>
              </a>
            </li>

          </ul>
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
              <h5 class="text-center mb-3 mt-2"><strong>Booking Management</strong></h5>
              <!-- Button filter -->

              <div class="mb-3 d-flex align-items-center justify-content-between">
                <div>
                  <label for="statusFilter" class="form-label">Filter by Status:</label>
                  <select class="form-select" id="statusFilter" onchange="fetchBooking()">
                    <option value="All">All</option>
                    <option value="PENDING">Pending</option>
                    <option value="APPROVED">Approved</option>
                    <option value="REJECTED">Rejected</option>
                  </select>
                </div>
                <div>
                  <label for="searchInput" class="search-label me-2">Search:</label>
                  <input type="text" id="searchInput" class="form-control search-input" placeholder="Enter Matric No"
                    aria-label="Enter Matric No" aria-describedby="basic-addon2">
                </div>
              </div>

              <!-- Table to display rooms -->
              <table class="table mt-4 table-bordered table-striped">
                <thead>
                  <tr>
                    <!-- <th>No.</th> -->
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Matric No</th>
                    <th style="text-align: center;">Room</th>
                    <th style="text-align: center;">Booking Date</th>
                    <th style="text-align: center;">Actions</th>
                  </tr>
                </thead>
                <tbody id="roomTableBody">
                  <!-- Room data will be displayed here -->
                </tbody>
              </table>
              <div id="noResultRow" class="alert alert-warning" style="display: none;">No matric ID found</div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>

    document.addEventListener('DOMContentLoaded', function () {
      const searchInput = document.getElementById('searchInput');

      searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toUpperCase();
        const rows = document.querySelectorAll('#roomTableBody tr');
        let found = false; // Flag to track if any matching result found

        rows.forEach(function (row) {
          const studentIDCell = row.cells[1]; // Adjust the index if the column order changes
          if (studentIDCell) {
            const studentID = studentIDCell.textContent || studentIDCell.innerText;
            if (studentID.toUpperCase().indexOf(filter) > -1) {
              row.style.display = '';
              found = true; // Set flag to true if a match is found
            } else {
              row.style.display = 'none';
            }
          }
        });

        // Show or hide the "No matric ID found" message based on the flag
        const noResultRow = document.getElementById('noResultRow');
        if (found) {
          noResultRow.style.display = 'none'; // Hide the message if a match is found
        } else {
          noResultRow.style.display = ''; // Show the message if no match is found
        }
      });
    });


    function fetchBooking() {
      const statusFilter = document.getElementById('statusFilter').value;
      fetch('get_booking_management.php')
        .then(response => response.json())
        .then(data => {
          const roomTableBody = document.getElementById('roomTableBody');
          roomTableBody.innerHTML = ''; // Clear existing data
          data.forEach(student => {
            if (statusFilter === 'All' || student.status === statusFilter) {
              const row = document.createElement('tr');
              const room = student.room; // Move the declaration here
              row.innerHTML = `
                    <td style="text-align: center;">${student.fullname}</td>
                    <td style="text-align: center;">${student.studentID}</td>
                    <td style="text-align: center;">${room}</td>
                    <td style="text-align: center;">${student.created_at}</td>
                    <td style="text-align: center; color: ${getStatusColor(student.status)};">
                      ${student.status === 'PENDING' ? `
                        <button class="btn btn-success btn-sm" onclick="approveBooking(${student.bookingID})"}>
                          Approve
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="rejectBooking(${student.bookingID})"}>
                          Reject
                        </button>` : student.status}
                    </td>
                `;
              roomTableBody.appendChild(row);
            }
          });
        })
        .catch(error => {
          console.log(error);
        });
    }

    function getStatusColor(status) {
      if (status === 'APPROVED') {
        return 'green';
      } else if (status === 'REJECTED') {
        return 'red';
      } else {
        return 'inherit';
      }
    }

    function approveBooking(bookingID) {
      if (confirm('Are you sure you want to approve this booking?')) {
        fetch('approve_booking.php', {
          method: 'POST',
          body: JSON.stringify({ bookingID: bookingID }),
          headers: {
            'Content-Type': 'application/json'
          },
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              fetchBooking(); // Reload the room list
              alert('Room booking successfully approved!');
            } else {
              alert('Failed to approve booking: ' + data.error);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred, please try again');
          });
      }
    }
    function rejectBooking(bookingID) {
      if (confirm('Are you sure you want to approve this booking?')) {
        fetch('reject_booking.php', {
          method: 'POST',
          body: JSON.stringify({ bookingID: bookingID }),
          headers: {
            'Content-Type': 'application/json'
          },
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              fetchBooking(); // Reload the room list
              alert('Room booking successfully rejected!');
            } else {
              alert('Failed to reject booking: ' + data.error);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred, please try again');
          });
      }
    }


    document.addEventListener('DOMContentLoaded', function () {
      // Attach event listener to the parent tbody element
      document.getElementById('roomTableBody').addEventListener('change', function (event) {
        // Check if the target element is a select element
        if (event.target.tagName.toLowerCase() === 'select') {
          const studentID = event.target.dataset.studentId;
          const value = event.target.value;

          // Check if the select element is for updating student status or blacklist status
          if (event.target.classList.contains('status-select')) {
            updateStudentStatus(studentID, value);
          } else if (event.target.classList.contains('blacklist-select')) {
            updateBlacklistStatus(studentID, value);
          }
        }
      });
    });


    // Call fetchRooms function when the page loads
    fetchBooking();

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