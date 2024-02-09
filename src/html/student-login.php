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
                if (isset($_POST['loginBtn'])) {
                  session_start();

                  $getStudentID = $_POST['studentID'];
                  $getPassword = $_POST['password'];

                  $con = mysqli_connect("localhost", "root", "", "uniselhostel");

                  $query = "SELECT studentID, password FROM student WHERE studentID = '$getStudentID'";

                  $result = mysqli_query($con, $query);

                  if ($row = mysqli_fetch_assoc($result)) {
                    $studentID = $row['studentID'];
                    $password = $row['password'];

                    if ($getStudentID == $studentID && $getPassword === $password) {
                      $_SESSION['studentID'] = $studentID;
                      header("Location: index.php");
                      exit();
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
                    <input type="text" class="form-control" id="studentID" aria-describedby="textHelp" name="studentID">
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                  </div>

                  <button type="submit" name="loginBtn" class="btn btn-primary w-100 py-8 fs-4 mb-3 rounded-2" style="background-color: #F78F1E; color: #fff;">Log in</button>

                  <div class="d-flex align-items-center justify-content-center mb-2">
                    <a class="text-primary fw-bold" href="./admin-login.php" style="text-decoration: underline;">Login as
                      Admin</a>
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

  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>