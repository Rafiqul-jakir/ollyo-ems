<?php
require_once  "../../config/app.php";
$app = App::getInstance();
session_start();
if (isset($_SESSION['id'])) {
  $userId = $_SESSION['id'];
  $admin_info = $app->selectOne("SELECT * FROM users WHERE id='$userId'");
} else {
  header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="../styles/style.css" rel="stylesheet">
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
              <a class="nav-link" style="margin-left: 20px;" href="../index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#" style="margin-left: 20px;">Events</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-md-auto d-md-flex">
            <li class="nav-item dropdown">
              <a class="dropdown-item text-danger" href="../../logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid">

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">All Events</h5>
              <button type="button" class="btn btn-primary mb-4 text-center float-right" id="createEventButton" data-toggle="modal" data-target="#eventModal">
                Create Event
              </button>
              <div class="table-responsive">
                <table class="table text-center" id="allEventsTable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Title</th>
                      <th scope="col">Description</th>
                      <th scope="col">Max Attendee</th>
                      <th scope="col">Enroll Attendee</th>
                      <th scope="col">Date</th>
                      <th scope="col">Time</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Data will be dynamically inserted here using AJAX -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
    <!-- The Modal -->
    <div class="modal fade" id="eventModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Create New Event</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal Body with Form -->
          <div class="modal-body">
            <form id="eventRegister">
              <!-- Event Title -->
              <div class="form-group">
                <label for="eventTitle">Event Title</label>
                <input type="text" class="form-control" id="eventTitle" name="eventTitle" placeholder="Enter event title" required>
              </div>

              <!-- Event Description -->
              <div class="form-group">
                <label for="eventDescription">Event Description</label>
                <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3" placeholder="Enter event description" required></textarea>
              </div>

              <!-- Number of Attendees -->
              <div class="form-group">
                <label for="totalAttendee">Number of Attendees</label>
                <input type="number" class="form-control" id="totalAttendee" name="totalAttendee" placeholder="Enter number of attendees" required>
              </div>
              <div class="row">
                <div class="col-6">
                  <!-- Event Date -->
                  <div class="form-group">
                    <label for="eventDate">Event Date</label>
                    <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                  </div>
                </div>
                <div class="col-6">
                  <!-- event Time -->
                  <div class="form-group">
                    <label for="eventTime">Event Time</label>
                    <input type="time" class="form-control" id="eventTime" name="eventTime" placeholder="Enter number of attendees" required>
                    <input type="hidden" name="createdBy" value="<?php echo $userId ?>">
                    <input type="hidden" name="eventId" id="eventId" value="">
                  </div>
                </div>
              </div>

              <p id="eventCreatedMessage" class="m-0 p-0"></p>
          </div>

          <!-- Modal Footer with Submit Button -->
          <div class="modal-footer">

            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" id="modalClose" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          </form>
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
        $('#eventRegister').submit(function(event) {
          event.preventDefault(); // Prevent default form submission

          // Send the form data using AJAX
          $.ajax({
            url: 'create_event.php', // URL of the PHP script
            type: 'POST', // HTTP method
            data: $(this).serialize(), // Serialize form data for sending
            success: function(response) {
              if (response == 'success') {
                $("#eventCreatedMessage")
                  .addClass("text-success")
                  .text("Event created successfully!")
                  .show()
                  .delay(2300)
                  .fadeOut(function() {
                    // Auto-click the modal close button
                    $('#createEventButton').click();
                    eventLoad();
                  });

              } else if (response == "updated-success") {

                $("#eventCreatedMessage")
                  .addClass("text-success")
                  .text("Event Updated successfully!")
                  .show()
                  .delay(2300)
                  .fadeOut(function() {
                    // Auto-click the modal close button
                    $('#modalClose').click();


                    eventLoad();
                  });
              } else {
                $("#eventCreatedMessage").addClass("text-danger").text("Something is wrong !").show()
                  .delay(2300)
                  .fadeOut();
              }
            },
            error: function(xhr, status, error) {
              console.error('Error:', error);
            },
          });

        });
        $("#allEventsTable").on('click', '.event-delete', function() {
          let userConfirmed = confirm("Are you sure you want to delete this event?");
          if (userConfirmed) {
            let eventId = $(this).data('id');
            $.ajax({
              type: "POST",
              url: "event_delete.php",
              data: {
                eventId: eventId
              },
              success: function(response) {
                eventLoad();
              }
            });
          }
        });
        $("#allEventsTable").on('click', '.event-edit', function() {
          let eventId = $(this).data('id');
          let row = $(this).closest("tr");
          let event_id = row.find("td:eq(0)").text();
          let eventTitle = row.find("td:eq(1)").text();
          let eventDescription = row.find("td:eq(2)").text();
          let totalAttendee = row.find("td:eq(3)").text();
          let eventDate = row.find("td:eq(5)").text();
          let eventTime = row.find("td:eq(6)").text();

          //Change date format
          var date = new Date(eventDate);
          var year = date.getFullYear();
          var month = ('0' + (date.getMonth() + 1)).slice(-2);
          var day = ('0' + date.getDate()).slice(-2);
          var formattedDate = year + '-' + month + '-' + day;

          // Format the time to 24-hour format (HH:mm)
          var date = new Date("01/01/2021 " + eventTime);
          var hours = ('0' + date.getHours()).slice(-2);
          var minutes = ('0' + date.getMinutes()).slice(-2);
          var time24hr = hours + ':' + minutes;

          $('#eventTitle').val(eventTitle);
          $('#eventDescription').val(eventDescription);
          $('#totalAttendee').val(totalAttendee);
          $('#eventDate').val(formattedDate);
          $('#eventTime').val(time24hr);
          $("#eventId").val(eventId);
          // Show the modal
          $('#eventModal').modal('show');
        });
        eventLoad();

        function eventLoad() {
          $.ajax({
            type: "POST",
            url: "user_all_events.php",
            data: {
              userId: <?php echo $userId ?>
            },
            dataType: "json",
            success: function(response) {
              if (response.message == "success") {
                $("#allEventsTable tbody").empty();
                $.each(response.data, function(indexInArray, valueOfElement) {
                  $("#allEventsTable tbody").append(`
                    <tr>
                      <td>${valueOfElement.id}</td>
                      <td>${valueOfElement.title}</td>
                      <td>${valueOfElement.description}</td>
                      <td>${valueOfElement.max_capacity}</td>
                       <td>${valueOfElement.enroll_attendee}</td>
                      <td>${valueOfElement.event_date}</td>
                      <td>${valueOfElement.time}</td>
                      <td>
                        <a class="btn btn-warning event-edit btn-sm" data-id="${valueOfElement.id}">Edit</a>
                        <a class="btn btn-danger text-white event-delete btn-sm" data-id="${valueOfElement.id}">Delete</a>
                        <a class="btn btn-success text-white btn-sm" href="csv.php?eventid=${valueOfElement.id}" title="Download CSV"><i class="fas fa-download"></i></a>
                      </td>
                    </tr>
                  `);
                });
              }

            }
          });
        }
      });
    </script>

</body>

</html>