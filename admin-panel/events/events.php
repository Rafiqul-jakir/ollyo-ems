<?php
require_once "../../config/app.php";
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
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <h5 class="card-title mb-4 d-inline float-left">All Events</h5>
                </div>
                <div class="col-6">
                  <button
                    type="button"
                    class="btn btn-primary float-right"
                    id="createEventButton"
                    data-toggle="modal"
                    data-target="#createEventModal">
                    Create Event
                  </button>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <input type="text" id="search-box" class="form-control mb-2" placeholder="Search by title...">
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" id="allEventsTable">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" class="align-middle">#</th>
                      <th scope="col" class="align-middle">Title</th>
                      <th scope="col" class="align-middle">Description</th>
                      <th scope="col" class="align-middle">Max Attendee</th>
                      <th scope="col" class="align-middle">Enroll Attendee</th>
                      <th scope="col" class="align-middle">Date</th>
                      <th scope="col" class="align-middle">Time</th>
                      <th scope="col" class="align-middle">Action</th>
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

      <!-- Create Event Modal -->
      <div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h5 class="modal-title" id="createEventModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <!-- Modal Body with Form -->
            <div class="modal-body">
              <form id="eventRegister">
                <div class="form-group">
                  <label for="eventTitle">Event Title</label>
                  <input
                    type="text"
                    class="form-control"
                    id="eventTitle"
                    name="eventTitle"
                    placeholder="Enter event title"
                    required />
                </div>

                <div class="form-group">
                  <label for="eventDescription">Event Description</label>
                  <textarea
                    class="form-control"
                    id="eventDescription"
                    name="eventDescription"
                    rows="3"
                    placeholder="Enter event description"
                    required></textarea>
                </div>

                <div class="form-group">
                  <label for="totalAttendee">Number of Attendees</label>
                  <input
                    type="number"
                    class="form-control"
                    id="totalAttendee"
                    name="totalAttendee"
                    placeholder="Enter number of attendees"
                    required />
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="eventDate">Event Date</label>
                      <input type="date" class="form-control" id="eventDate" name="eventDate" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="eventTime">Event Time</label>
                      <input type="time" class="form-control" id="eventTime" name="eventTime" required />
                      <input type="hidden" name="createdBy" value="<?php echo $userId ?>" />
                      <input type="hidden" name="eventId" id="eventId" value="" />
                    </div>
                  </div>
                </div>

              </form>
              <p id="eventCreatedMessage"></p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
              <button type="submit" form="eventRegister" class="btn btn-success">Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Attendee Info Modal -->
      <div class="modal fade" id="attendeeInfo" tabindex="-1" role="dialog" aria-labelledby="attendeeInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="attendeeInfoLabel">Enroll Attendees</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="text" id="searchBar" class="form-control" placeholder="Search by name or phone" />
              </div>
              <table class="table table-bordered table-hover" id="attendeeInfoTable">
                <thead class="thead-light">
                  <tr>
                    <th>Name</th>
                    <th>Phone</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>John Doe</td>
                    <td>+1-234-567-890</td>
                  </tr>
                  <tr>
                    <td>Jane Smith</td>
                    <td>+1-987-654-321</td>
                  </tr>
                  <tr>
                    <td>Chris Johnson</td>
                    <td>+1-456-789-012</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
      // search 
      $('#search-box').on('keyup', function() {
        var value = $(this).val().toLowerCase(); // Get search value and convert to lowercase
        $('#allEventsTable tbody tr').filter(function() {
          // Toggle row visibility based on match
          $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1);
        });
      });

      $("#createEventButton").on('click', function() {
        $("#createEventModalLabel").text("Create New Event");
        $('#eventRegister').trigger('reset');
      });
      $('#eventRegister').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Send the form data using AJAX
        $.ajax({
          url: 'create_event.php', // URL of the PHP script
          type: 'POST', // HTTP method
          data: $(this).serialize(), // Serialize form data for sending
          success: function(response) {
            console.log(response);

            if (response.status == 'success') {
              $("#eventCreatedMessage")
                .addClass("text-success")
                .removeClass("text-danger")
                .text(response.message)
                .show()
                .delay(2300)
                .fadeOut(function() {
                  // Auto-click the modal close button
                  $('#createEventButton').click();
                  eventLoad();
                });

            } else {
              $("#eventCreatedMessage").addClass("text-danger").removeClass("text-success").text(response.message).show()
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
        $("#createEventModalLabel").text("Edit event");
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
        $('#createEventModal').modal('show');
      });

      // in initial  call
      eventLoad();

      $("#allEventsTable tbody").on('click', '.getAttendeeInfo', function() {
        let event_id = $(this).data("event_id");
        $.ajax({
          type: "POST",
          url: "attendee_info.php",
          data: {
            event_id: event_id
          },
          dataType: "json",
          success: function(response) {
            console.log(response);
            if (response.message == "success") {
              $("#attendeeInfoTable tbody").empty();
              $.each(response.data, function(indexInArray, valueOfElement) {
                $("#attendeeInfoTable tbody").append(`
                  <tr>
                    <td>${valueOfElement.attendeeName}</td>
                    <td>${valueOfElement.attendeePhone}</td>
                  </tr>
                `);
              });
            }

          }
        });

      });
      // search with attendee name or phone number
      $('#searchBar').on('input', function() {
        const searchText = $(this).val().toLowerCase();

        // Loop through each row in the table body
        $('#attendeeInfoTable tbody tr').each(function() {
          const name = $(this).find('td').eq(0).text().toLowerCase();
          const phone = $(this).find('td').eq(1).text().toLowerCase();

          // Check if either name or phone contains the search text
          if (name.includes(searchText) || phone.includes(searchText)) {
            $(this).show(); // Show the row if there's a match
          } else {
            $(this).hide(); // Hide the row if no match
          }
        });
      });

    });

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
            let counter = 0;
            $.each(response.data, function(indexInArray, valueOfElement) {
              counter++;
              $("#allEventsTable tbody").append(`
                    <tr>
                      <td class="align-middle">${counter}</td>
                      <td class="align-middle"><a href="#" data-event_id = "${valueOfElement.id}" data-toggle="modal" data-target="#attendeeInfo" class="getAttendeeInfo">${valueOfElement.title}</a></td>
                      <td class="align-middle">${valueOfElement.description}</td>
                      <td class="align-middle">${valueOfElement.max_capacity}</td>
                      <td class="align-middle">${valueOfElement.enroll_attendee}</td>
                      <td class="align-middle">${valueOfElement.event_date}</td>
                      <td class="align-middle">${valueOfElement.time}</td>
                      <td class="align-middle">
                      <div class="d-flex">
                        <a class="btn btn-warning event-edit btn-sm" data-id="${valueOfElement.id}">Edit</a>
                        <a class="btn btn-danger text-white event-delete btn-sm mr-1 ml-1" data-id="${valueOfElement.id}">Delete</a>
                        <a class="btn btn-success text-white btn-sm" href="csv.php?eventid=${valueOfElement.id}" title="Download CSV"><i class="fas fa-download"></i></a>
                        </div>
                      </td>
                    </tr>
                  `);
            });
          }

        }
      });
    }
  </script>

</body>

</html>