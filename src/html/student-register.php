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
                  if (isset($_POST['registerBtn'])) {
                    session_start();

                    $studentID = $_POST['studentID'];
                    $password = $_POST['password'];
                    $fullname = $_POST['fullname'];

                    $con = mysqli_connect("localhost", "root", "", "uniselhostel");

                    $checkQuery = "SELECT * FROM student WHERE studentID = '$studentID'";
                    $checkResult = mysqli_query($con, $checkQuery);

                    if (mysqli_num_rows($checkResult) > 0) {
                      echo '<p class="text-center text-danger">Matric ID already exists. Please choose a different one.</p>';
                    } else {

                      $insertQuery = "INSERT INTO student (studentID, password, fullname, status, blacklist) VALUES ('$studentID', '$password', '$fullname', 'PENDING', 'ELIGIBLE')";
                      $insertResult = mysqli_query($con, $insertQuery);

                      if ($insertResult) {
                        $_SESSION['studentID'] = $studentID;
                        echo '<script type="text/javascript">';
                        echo 'alert("Successfully Registered!");';
                        echo 'window.location.href = "student-login.php";';
                        echo '</script>';
                      } else {
                        echo '<p class="text-center text-danger">Registration failed. Please try again.</p>';
                      }
                    }

                    mysqli_close($con);
                  }
                  ?>

                  <form method="post">
                    <div class="mb-3">
                      <label for="fullname" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="fullname" aria-describedby="textHelp" name="fullname">
                    </div>
                    <div class="mb-4">
                      <label for="studentID" class="form-label">Matric ID</label>
                      <input type="text" class="form-control" id="studentID" aria-describedby="textHelp"
                        name="studentID">
                    </div>
                    <div class="mb-4">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <!-- <div class="mb-4">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                  </div> -->
                    <!-- <div class="mb-4">
                    <label for="fullname" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                  </div> -->

                    <button type="submit" name="registerBtn" class="btn btn-primary w-100 py-8 fs-4 mb-3 rounded-2"
                      style="background-color: #F78F1E; color: #fff;">Register</button>
                    <div class="d-flex align-items-center justify-content-center">
                      <p class="fs-4 mb-0 fw-bold">Already Has An Account?</p>
                      <a class="text-primary fw-bold ms-2" href="./student-login.php">Log in</a>
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

  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>