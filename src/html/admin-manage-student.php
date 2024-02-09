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
              <a class="sidebar-link" href="./admin-manage-student.php" aria-expanded="false">
                <span>
                  <i class="ti ti-alert-circle"></i>
                </span>
                <span class="hide-menu">Manage Student</span>
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
              <h5 class="text-center mb-3 mt-2"><strong>Student Management</strong></h5>
              <!-- Table to display rooms -->
              <table class="table mt-4 table-bordered table-striped">
                <thead>
                  <tr>
                    <!-- <th>No.</th> -->
                    <th>Name</th>
                    <th>Matric No</th>
                    <th>Room</th>
                    <th>Status</th>
                    <th>Blacklist Status</th>
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

    // Function to fetch and display all rooms
    function fetchStudents() {
    fetch('get_student_management.php')
      .then(response => response.json())
      .then(data => {
        const roomTableBody = document.getElementById('roomTableBody');
        roomTableBody.innerHTML = ''; // Clear existing data
        data.forEach(student => {
          const row = document.createElement('tr');
          const room = student.room; // Move the declaration here
          row.innerHTML = `
            <td>${student.fullname}</td>
            <td>${student.studentID}</td>
            <td>${room}</td>
            <td>
              <select class="form-select" onchange="updateStudentStatus(${student.studentID}, this.value)">
                <option value="PENDING" ${student.status === 'PENDING' ? 'selected' : ''}>Default</option>
                <option value="CHECKEDIN" ${student.status === 'CHECKEDIN' ? 'selected' : ''}>Checked in</option>
                <option value="CHECKEDOUT" ${student.status === 'CHECKEDOUT' ? 'selected' : ''}>Checked out</option>
              </select>
            </td>
            <td>
              <select class="form-select" onchange="updateBlacklistStatus(${student.studentID}, this.value)">
                <option value="Eligible" ${student.blacklist === 'ELIGIBLE' ? 'selected' : ''}>Eligible</option>
                <option value="Blacklisted" ${student.blacklist === 'BLACKLISTED' ? 'selected' : ''}>Blacklisted</option>
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
    function updateBlacklistStatus(studentID, blacklistStatus) {
      console.log('Updating student blacklist status:', studentID, blacklistStatus); // Add this debug statement to log the parameters
      fetch('update_blacklist_status.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            studentID: studentID,
            blacklistStatus: blacklistStatus
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
