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
              <h5 class="text-center mb-3 mt-2"><strong>Student Management</strong></h5>
              <!-- Added label for the search input -->
              <div class="mb-3 d-flex align-items-center">
                <label for="searchInput" class="search-label me-2">Search:</label>
                <input type="text" id="searchInput" class="form-control search-input" placeholder="Enter Matric No"
                  aria-label="Enter Matric No" aria-describedby="basic-addon2">
              </div>
              <!-- Table to display rooms -->
              <table class="table mt-4 table-bordered table-striped">
                <thead>
                  <tr>
                    <!-- <th>No.</th> -->
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Matric No</th>
                    <th style="text-align: center;">Room</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Blacklist Status</th>
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

    // Function to fetch and display all rooms
    function fetchStudents() {
      fetch('get_student_management.php')
        .then(response => response.json())
        .then(data => {
          console.log('Response:', data); // Add this debug statement to log the response from the server

          const roomTableBody = document.getElementById('roomTableBody');
          roomTableBody.innerHTML = ''; // Clear existing data
          data.forEach(student => {
            const row = document.createElement('tr');
            const room = student.room; // Move the declaration here
            row.innerHTML = `
    <td  style="text-align: center;">${student.fullname}</td>
    <td  style="text-align: center;">${student.studentID}</td>
    <td  style="text-align: center;">${room}</td>
    <td>
    <select class="form-select status-select" data-student-id="${student.studentID}" ${student.bookingStatus !== 'APPROVED' ? 'disabled' : ''} style="${student.bookingStatus !== 'APPROVED' ? 'background-color: #f0f0f0; color: #999; cursor: not-allowed;' : ''}">
        <option  style="text-align: center;" value="PENDING" ${student.status === 'PENDING' ? 'selected' : ''}>Default</option>
        <option  style="text-align: center;" value="CHECKEDIN" ${student.status === 'CHECKEDIN' ? 'selected' : ''}>Checked in</option>
        <option  style="text-align: center;" value="CHECKEDOUT" ${student.status === 'CHECKEDOUT' ? 'selected' : ''}>Checked out</option>
    </select>
</td>
    <td>
        <select class="form-select blacklist-select" data-student-id="${student.studentID}">
            <option  style="text-align: center;" value="ELIGIBLE" ${student.blacklist === 'ELIGIBLE' ? 'selected' : ''}>Eligible</option>
            <option  style="text-align: center;" value="BLACKLISTED" ${student.blacklist === 'BLACKLISTED' ? 'selected' : ''}>Blacklisted</option>
        </select>
    </td>
`;
            roomTableBody.appendChild(row);
          });
        })
        .catch(error => {
          console.log(error);
        });
    }


    // Function to update student status
    function updateStudentStatus(studentID, status) {
      console.log('Updating student status:', studentID, status); // Add this debug statement to log the parameters
      fetch('update_student_status.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          studentID: studentID,
          status: status
        }),
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to update student status');
          }
          return response.json();
        })
        .then(data => {
          console.log('Response:', data); // Add this debug statement to log the response from the server
          if (data.success) {
            fetchStudents(); // Refresh student data
            alert('Student status updated successfully');
          } else {
            alert('Failed to update student status: ' + data.error);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating student status');
        });
    }

    // Function to update student blacklist status
    function updateBlacklistStatus(studentID, blacklist) {
      console.log('Updating student blacklist status:', studentID, blacklist); // Add this debug statement to log the parameters
      fetch('update_blacklist_status.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          studentID: studentID,
          blacklist: blacklist
        }),
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to update student blacklist status');
          }
          return response.json();
        })
        .then(data => {
          console.log('Response:', data); // Add this debug statement to log the response from the server
          if (data.success) {
            fetchStudents(); // Refresh student data
            alert('Student blacklist status updated successfully');
          } else {
            alert('Failed to update student blacklist status: ' + data.error);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating student blacklist status');
        });
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
    fetchStudents();

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