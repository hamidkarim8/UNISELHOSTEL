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
                        <a href="./student-login.php"
                            class="btn btn-outline-primary mx-3 mt-4 d-block logout-btn">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-6 mt-4 mx-auto">
                    <div class="card">
                        <div class="card-body text-justify bg-light py-1 rounded p-4">
                            <div class="text-nowrap logo-img text-center d-block py-1 w-100 mb-4 mt-4">
                                <img src="../assets/images/logos/logounisel.png" width="250" alt="">
                            </div>
                            <?php
                            // Include the PHP script to fetch memos
                            include 'get_memos.php';

                            // Loop through the memos and display them
                            foreach ($memos as $memo) {
                                echo '<h5 class="text-center">MEMO RESIDENSI PELAJAR</h5>';
                                echo '<h5 class="text-center">KOLEJ KEDIAMAN BESTARI JAYA</h5>';
                                echo '<h5 class="text-center mb-4">PEMBANGUNAN KOMUNITI DAN PELAJAR</h5>';
                                echo '<p class="text-left mb-1"><strong>FROM</strong>: ' . $memo['sender'] . '</p>';
                                echo '<p class="text-left mb-1"><strong>TO</strong>: ' . $memo['recipient'] . '</p>';
                                echo '<p class="text-left mb-1"><strong>DATE</strong>: ' . $memo['date'] . '</p>';
                                echo '<hr>';
                                echo '<p class="mb-2" style="text-align: center;">' . $memo['greeting'] . '</p>';
                                echo '<p class="mb-4" style="text-align: justify;">' . $memo['content'] . '</p>';
                            }
                            ?>
                        </div>
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