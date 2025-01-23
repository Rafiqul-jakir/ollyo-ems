<?php
require_once  "../config/app.php";
$app = App::getInstance();
session_start();
if (isset($_SESSION['id'])) {
  $userId = $_SESSION['id'];
  $admin_info = $app->selectOne("SELECT * FROM users WHERE id='$userId'");
  $numberOfEvents = $app->selectOne("SELECT COUNT(*) AS total FROM events WHERE created_by='$userId'");
  $numberOfAttendees = $app->selectOne("SELECT COUNT(attendees.id) AS total_attendees FROM attendees JOIN  events ON attendees.event_id = events.id WHERE 
    events.created_by = '$userId'");
} else {
  header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="styles/style.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
  <div id="wrapper">
    <nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="../../index.php" target="_blank">Event Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav side-nav">
            <li class="nav-item">
              <a class="nav-link active" style="margin-left: 20px;" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="events/events.php" style="margin-left: 20px;">Events</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-md-auto d-md-flex">
            <li class="nav-item dropdown">
              <a class="dropdown-item text-danger" href="../logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <h2>Welcome <span class="text-primary"><?php echo $admin_info->name ?></span></h2>
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Events</h5>
              <p class="card-text">number of Events: <?php echo $numberOfEvents->total ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Attendee</h5>
              <p class="card-text">number of attendees: <?php echo $numberOfAttendees->total_attendees ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <!-- jQuery, Popper.js, and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/1a6a4e9de4.js" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(document).ready(function() {


    });
  </script>
</body>

</html>