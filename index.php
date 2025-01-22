<?php
require_once "config/app.php";
$app = App::getInstance();
session_start();
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $admin_info = $app->selectOne("SELECT * FROM users WHERE id='$userId'");
}
$allEvents = $app->selectAll("SELECT
    events.id,
    events.title,
    events.description,
    events.max_capacity,
    events.event_date,
    events.time,
    events.created_by,
    events.created_at,
    (events.max_capacity - COUNT(attendees.id)) AS blank_slots
    FROM
    events
    LEFT JOIN
    attendees ON attendees.event_id = events.id
    GROUP BY
    events.id
    ORDER BY
    events.event_date");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Event Manager</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.html">Home</a>
                        </li>
                        <?php
                        if (isset($_SESSION['id'])) {
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='admin-panel/'>" .  $admin_info->name . "</a>
                            </li>";
                        } else {
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='login.php'>Login</a>
                            </li>";
                        }

                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </div>



    <!-- Main Content -->
    <div class="container my-5">
        <input type="text" id="search-box" class="form-control mb-4" placeholder="Search by title...">
        <div class="row row-cols-1 row-cols-md-3 g-4">

            <?php
            if (!empty($allEvents)) {
                foreach ($allEvents as $events) { ?>
                    <div class="col event-card">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $events->title ?></h5>
                                <p class="card-text"><?php echo $events->description ?></p>
                                <p class="card-text">Available Slot: <?php echo $events->blank_slots ?></p>
                                <p class="card-text"> Date: <?php
                                                            $date = new DateTime($events->event_date);
                                                            $formattedDate = $date->format('d F Y');
                                                            echo $formattedDate . "-";
                                                            $time = new DateTime($events->time);
                                                            $formattedTime = $time->format('h:i A');
                                                            echo $formattedTime;

                                                            ?></p>
                                <button type="button" class="btn btn-primary attend-event-btn" data-eventid="<?php echo $events->id ?>" data-eventtitle="<?php echo $events->title ?>" data-userid="<?php echo $events->created_by ?>">Attend</button>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Event Attend Modal -->
    <div class="modal fade" id="attendEventModal" tabindex="-1" aria-labelledby="attendEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendEventModalLabel">Attend Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="attendEventForm">
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="eventName" name="eventName" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                            <input type="hidden" name="eventId" id="eventId">
                            <input type="hidden" name="userId" id="userId">
                        </div>
                        <p id="eventCreatedMessage"></p>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Show modal and set event name when "Attend" button is clicked
            $('.attend-event-btn').on('click', function() {
                let eventId = $(this).data('eventid');
                let eventTitle = $(this).data('eventtitle');
                let userId = $(this).data('userid');

                $('#eventName').val(eventTitle);
                $('#eventId').val(eventId);
                $('#userId').val(userId);
                $('#attendEventModal').modal('show');
            });

            // Handle form submission
            $('#attendEventForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'register_attendee.php',
                    type: 'POST',
                    data: $(this).serialize(), // Serialize form Data
                    success: function(response) {
                        if (response == 'success') {
                            $("#eventCreatedMessage")
                                .addClass("text-success")
                                .removeClass('text-danger')
                                .text("Event Booked successfully!")
                                .show()
                                .delay(2300)
                                .fadeOut(function() {
                                    // Auto-click the modal close button
                                    $('#attendEventModal').modal('hide');
                                });

                        } else {
                            $("#eventCreatedMessage").addClass("text-danger").removeClass('text-success').text("Something is wrong !").show()
                                .delay(2300)
                                .fadeOut();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    },
                });
                // Hide the modal after submission
            });

            $('#search-box').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();

                // Loop through all the event cards
                $('.event-card').each(function() {
                    const cardTitle = $(this).find('.card-title').text().toLowerCase();

                    // Check if the search text matches the card title
                    if (cardTitle.includes(searchText)) {
                        $(this).show(); // Show the card
                    } else {
                        $(this).hide(); // Hide the card
                    }
                });

                // If search box is empty, show all cards
                if (searchText === '') {
                    $('.event-card').show();
                }
            });

        });
    </script>
</body>

</html>