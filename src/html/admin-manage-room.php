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
  width: 700px;
  margin: auto; /* Center the card horizontally */
  margin-top: 50px;
  margin-bottom: 50px; /* Add margin at the bottom for spacing */

}
.table th{
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
      <div class="row">>
        <div class="col-md-6 mt-4 mx-auto">
          <div class="card">
            <div class="card-body text-justify bg-light py-1 rounded p-4">
              <h5 class="text-center mb-3 mt-2"><strong>Room Management</strong></h5>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addRoomModal">
  Add New Room
</button>

<!-- Modal -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="add_room.php" id="addRoomForm">
          <div class="mb-3">
            <label for="blockSelection" class="form-label">Block:</label>
            <select class="form-select" id="blockSelection" name="block">
              <option value="Block A">Block A</option>
              <option value="Block B">Block B</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="floorSelection" class="form-label">Floor:</label>
            <select class="form-select" id="floorSelection" name="floor">
              <option value="Floor 1">Floor 1</option>
              <option value="Floor 2">Floor 2</option>
              <option value="Floor 3">Floor 3</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="unitSelection" class="form-label">Unit:</label>
            <select class="form-select" id="unitSelection" name="unit">
              <option value="Unit 1">Unit 1</option>
              <option value="Unit 2">Unit 2</option>
              <option value="Unit 3">Unit 3</option>
              <option value="Unit 4">Unit 4</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="roomNumberSelection" class="form-label">Room Number:</label>
            <select class="form-select" id="roomNumberSelection" name="roomNumber">
              <option value="Room 1">Room 1</option>
              <option value="Room 2">Room 2</option>
              <option value="Room 3">Room 3</option>
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

<!-- Table to display rooms -->
<table class="table mt-4 table-bordered table-striped">
  <thead>
    <tr>
      <!-- <th>No.</th> -->
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
  </div>
  <script>
  // JavaScript to handle form submission and display room data
  document.getElementById('addRoomForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = this;
    const formData = new FormData(form);
    fetch('add_room.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // If room added successfully, show success message
          alert('Room added successfully!');
          // Redirect to admin-manage-room page
          window.location.href = './admin-manage-room.php';
        } else {
          alert('Failed to add room');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred, please try again');
      });
  });

  // Function to fetch and display all rooms
  function fetchRooms() {
      fetch('get_rooms.php')
        .then(response => response.json())
        .then(data => {
          const roomTableBody = document.getElementById('roomTableBody');
          roomTableBody.innerHTML = ''; // Clear existing data
          data.forEach(room => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${room.block}</td>
                <td>${room.floor}</td>
                <td>${room.unit}</td>
                <td>${room.roomNumber}</td>
                <td>
                  <select class="form-select" onchange="updateRoomStatus(${room.hostelID}, this.value)">
                    <option value="Available" ${room.status === 'Available' ? 'selected' : ''}>Available</option>
                    <option value="Unavailable" ${room.status === 'Unavailable' ? 'selected' : ''}>Unavailable</option>
                  </select>
                </td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="deleteRoomStatus(${room.hostelID})">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            `;
            roomTableBody.appendChild(row);
          });
        });
    }

    function deleteRoomStatus(hostelID) {
    if (confirm('Are you sure you want to delete this room?')) {
        fetch('delete_room.php', {
            method: 'POST',
            body: JSON.stringify({ hostelID: hostelID }),
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete room');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                fetchRooms(); // Reload the room list
                alert('Room deleted successfully!');
            } else {
                alert('Failed to delete room');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred, please try again');
        });
    }
}

function updateRoomStatus(hostelID, status) {
      fetch('update_room_status.php', {
          method: 'POST',
          body: JSON.stringify({
            hostelID: hostelID,
            status: status
          }),
          headers: {
            'Content-Type': 'application/json'
          },
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to update room status');
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            fetchRooms(); // Reload the room list
            alert('Room status updated successfully!');
          } else {
            alert('Failed to update room status');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred, please try again');
        });
    }


  // Call fetchRooms function when the page loads
  fetchRooms();
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