<!-- Navbar Start-->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="index.php"><img src="images/logo.png" alt="" style="width: 45px;"> Online Travel Booking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-white"></span>
        </button>
        <div class="collapse text-white navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="about.php">About</a>
                </li>
                <?php
                if (isset($_SESSION['logged']) && $_SESSION['logged'] = true) {
                    echo '<li class="nav-item">
                    <a class="nav-link text-white" href="my_flights.php">My Flights</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="my_tickets.php">Tickets</a>
                </li>
                    ';
                }

                ?>

            </ul>
            <?php
            if (isset($_SESSION['logged']) && $_SESSION['logged'] = true) {
                echo '
                        <a class="nav-link  text-white" href="#"><i class="bi bi-person-circle"></i> ' . $_SESSION['name'] . '</a>
                   
                    <a class="btn fw-bold  text-white" href="logout.php" ><i class="bi bi-box-arrow-right"></i></a>
                    ';
            } else {
                echo '
                    <a class="btn btn-outline-light fw-bold" href="login.php">Login/Signup</a>';
            }

            ?>
        </div>
    </div>
</nav>
<!-- Navbar End -->