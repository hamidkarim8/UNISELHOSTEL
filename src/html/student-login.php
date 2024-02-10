<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UNISEL HOSTEL MANAGEMENT SYSTEM</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logounisel.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <style>
    .background-container {
      position: relative;
      background: url('../assets/images/backgrounds/backimage3.png') center center no-repeat;
      background-size: cover;
      min-height: 20vh;
    }

    .modal-container {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.7);
}

.modal-content {
  background-color: #fefefe;
  margin: 10% auto; /* Adjust margin for vertical positioning */
  padding: 40px; /* Increase padding for better spacing */
  border: 2px solid #f78f1e; /* Add border for better visibility */
  width: 60%; /* Adjust width as needed */
  max-width: 500px; /* Set maximum width to prevent modal from becoming too wide */
  border-radius: 10px; /* Add border-radius for rounded corners */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add box-shadow for depth */
}

.modal-content p {
  margin-bottom: 20px;
}

.modal-content button {
  background-color: #f78f1e;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}


  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="background-container">

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
      data-sidebar-position="fixed" data-header-position="fixed">
      <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
          <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
              <div class="card mb-0">
                <div class="card-body">
                  <div class="text-nowrap logo-img text-center d-block py-3 w-100">
                    <img src="../assets/images/logos/logounisel.png" width="180" alt="">
                  </div>
                  <p class="text-center fw-bold mb-4" style="font-size: 1.5em;">UNISEL HOSTEL MANAGEMENT SYSTEM</p>

                  <?php
                  if (isset($_POST['loginBtn'])) {
                    session_start();

                    $getStudentID = $_POST['studentID'];
                    $getPassword = $_POST['password'];

                    $con = mysqli_connect("localhost", "root", "", "uniselhostel");

                    $query = "SELECT studentID, password, blacklist FROM student WHERE studentID = '$getStudentID'";

                    $result = mysqli_query($con, $query);

                    if ($row = mysqli_fetch_assoc($result)) {
                      $studentID = $row['studentID'];
                      $password = $row['password'];
                      $blacklist = $row['blacklist'];

                      if ($getStudentID == $studentID && $getPassword === $password) {
                        if ($blacklist === 'ELIGIBLE') {
                          $_SESSION['studentID'] = $studentID;
                          header("Location: index.php");
                          exit();
                        } else {
                          // Display the modal instead of redirecting
                          echo '<script>document.addEventListener("DOMContentLoaded", function() {
                            document.querySelector(".modal-container").style.display = "block";
                          });</script>';
                        }
                      } else {
                        echo '<p class="text-center text-danger">Invalid username or password. Please try again.</p>';
                      }
                    } else {
                      echo '<p class="text-center text-danger">Invalid username or password. Please try again.</p>';
                    }

                    mysqli_close($con);
                  }
                  ?>

                  <form method="post">
                    <div class="mb-3">
                      <label for="studentID" class="form-label">Matric ID</label>
                      <input type="text" class="form-control" id="studentID" aria-describedby="textHelp"
                        name="studentID">
                    </div>
                    <div class="mb-4">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <button type="submit" name="loginBtn"
                      class="btn btn-primary w-100 py-8 fs-4 mb-3 rounded-2"
                      style="background-color: #F78F1E; color: #fff;">Log in</button>

                    <div class="d-flex align-items-center justify-content-center mb-2">
                      <a class="text-primary fw-bold" href="./admin-login.php"
                        style="text-decoration: underline;">Login as Admin</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                      <p class="fs-4 mb-0 fw-bold">Haven't Registered?</p>
                      <a class="text-primary fw-bold ms-2" href="./student-register.php">Create an account</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal HTML -->
  <div class="modal-container" id="blacklistModal">
    <div class="modal-content">
      <p>You are blacklisted and not permissible to access this system. Please contact <a
          href="mailto:residentoffice@gmail.com">residentoffice@gmail.com</a>.</p>
      <button onclick="window.location.href = 'student-login.php';">OK</button>
    </div>
  </div>

  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
