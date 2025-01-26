<?php
require_once "config/app.php";
$app = App::getInstance();
session_start();
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $admin_info = $app->selectOne("SELECT * FROM users WHERE id='$userId'");
}

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
                            <a class="nav-link active" aria-current="page">Home</a>
                        </li>
                        <?php
                        if (isset($_SESSION['id'])) {
                            echo " <li class='nav-item'>
                                <a class='nav-link' href='admin-panel/' target='_blank'> " .  $admin_info->name . " <i class='fas fa-caret-down'></i></a>
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
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <input type="text" id="search-box" class="form-control mb-2" placeholder="Search by title...">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between">
                <!-- Sorting Dropdown -->
                <div class="sorting">
                    <label for="sorting">Sorted by</label>
                    <select id="sorting" class="form-select">
                        <option value="ascending" selected>Date Ascending</option>
                        <option value="descending">Date Descending</option>
                    </select>
                </div>

                <!-- Filter Dropdown -->
                <div class="slot">
                    <label for="slot">Event Type</label>
                    <select id="slot" class="form-select">
                        <option value="all">All</option>
                        <option value="available">Available</option>
                        <option value="booked">Booked</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4" id="all_events">
            <!-- Data Come From Ajax Load with eventLoad() function -->

        </div>
        <div id="pagination" class="mt-3">
            <!-- Pagination controls will be dynamically loaded here -->
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
    <script src="https://kit.fontawesome.com/1a6a4e9de4.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Show modal and set event name when "Attend" button is clicked
            $('#all_events').on('click', '.attend-event-btn', function() {
                let eventId = $(this).data('eventid');
                let eventTitle = $(this).data('eventtitle');
                let userId = $(this).data('userid');

                // Set modal inputs
                $('#eventName').val(eventTitle);
                $('#eventId').val(eventId);
                $('#userId').val(userId);

                // Show the modal
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
                        console.log(response);

                        if (response.status == 'success') {
                            $("#eventCreatedMessage")
                                .addClass("text-success")
                                .removeClass('text-danger')
                                .text(response.message)
                                .show()
                                .delay(2300)
                                .fadeOut(function() {
                                    // Auto-click the modal close button
                                    $('#attendEventModal').modal('hide');
                                    eventLoad(1, 5);
                                });

                        } else {
                            $("#eventCreatedMessage").addClass("text-danger").removeClass('text-success').text(response.message).show()
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
            let currentPage = 1; // Start from page 1
            const eventsPerPage = 6; // Set 5 events per page

            function eventLoad(page = 1, perPage = 5) {
                $.ajax({
                    type: "POST",
                    url: "all_events.php",
                    dataType: "json",
                    data: {
                        page: page,
                        per_page: perPage
                    },
                    success: function(response) {
                        if (response.message == "success") {
                            $("#all_events").empty();
                            $.each(response.data, function(indexInArray, valueOfElement) {
                                // Format the date and time
                                let eventDate = new Date(valueOfElement.event_date); // Event date (e.g., '2025-02-01 00:00:00')

                                // Format the date
                                let day = eventDate.getDate();
                                let month = eventDate.toLocaleString('en-US', {
                                    month: 'long'
                                });
                                let year = eventDate.getFullYear();
                                let formattedDate = `${day} ${month} ${year}`;

                                // Format the time to 12-hour format
                                let time = new Date(`1970-01-01T${valueOfElement.time}Z`); // Event time (e.g., '14:00:00')
                                let formattedTime = time.toLocaleTimeString('en-US', {
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    hour12: true
                                });

                                // Combine the formatted date and time
                                let formattedDateTime = `<span class="date">${formattedDate}</span> - ${formattedTime}`;

                                // Conditionally build the button HTML
                                let buttonHtml = '';
                                if (valueOfElement.blank_slots > 0) {
                                    buttonHtml = `<button type="button" class="btn btn-primary attend-event-btn" data-eventid="${valueOfElement.id}" data-eventtitle="${valueOfElement.title}" data-userid="${valueOfElement.created_by}">Attend</button>`;
                                }

                                // Append the event card
                                $("#all_events").append(`
                        <div class="col event-card">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">${valueOfElement.title}</h5>
                                    <p class="card-text">${valueOfElement.description}</p>
                                    <p class="card-text">Available Slot: <strong class="slot">${valueOfElement.blank_slots}</strong></p>
                                    <p class="card-text"> Date: ${formattedDateTime}</p>
                                    ${buttonHtml}
                                </div>
                            </div>
                        </div>
                    `);
                            });

                            // Generate pagination controls
                            generatePagination(response.total_pages, page);
                        }
                    }
                });
            }

            function generatePagination(totalPages, currentPage) {
                let paginationHtml = `<ul class="pagination">`;

                // Previous button
                if (currentPage > 1) {
                    paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-currentpage="${currentPage - 1}">Previous</a></li>`;
                }

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link" href="#" data-currentpage="${i}">${i}</a>
        </li>`;
                }

                // Next button
                if (currentPage < totalPages) {
                    paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-currentpage="${currentPage + 1}">Next</a></li>`;
                }

                paginationHtml += `</ul>`;

                // Append pagination to a container
                $("#pagination").html(paginationHtml);
            }

            $("#pagination").on('click', '.page-link', function(e) {
                e.preventDefault();

                let currentPage = $(this).data('currentpage');
                console.log(currentPage);

                eventLoad(currentPage, eventsPerPage);
                $("#sorting").val("ascending");
                $("#slot").val("all");
            });



            // Initial load
            eventLoad(currentPage, eventsPerPage);

            // sorting by date
            $('#sorting').change(function() {
                var sortingOrder = $(this).val(); // Get the selected sorting option
                var eventCards = $('.event-card'); // Get all event cards

                // Sort the event cards based on the date
                eventCards.sort(function(a, b) {
                    var dateA = new Date($(a).find('.date').text());
                    var dateB = new Date($(b).find('.date').text());

                    if (sortingOrder === 'ascending') {
                        return dateA - dateB; // Ascending order
                    } else {
                        return dateB - dateA; // Descending order
                    }
                });

                // Reattach the sorted event cards back to the container
                $('#all_events').html(eventCards);
            });

            $('#slot').change(function() {
                var selectedSlot = $(this).val(); // Get the selected event type (all, available, booked)

                // Show or hide event cards based on the selected slot
                $('.event-card').each(function() {
                    var availableSlots = parseInt($(this).find('.slot').text()); // Get the number of available slots

                    if (selectedSlot === 'all') {
                        // If 'All' is selected, show all cards
                        $(this).show();
                    } else if (selectedSlot === 'available' && availableSlots > 0) {
                        // If 'Available' is selected, show cards with available slots > 0
                        $(this).show();
                    } else if (selectedSlot === 'booked' && availableSlots === 0) {
                        // If 'Booked' is selected, show cards with available slots = 0
                        $(this).show();
                    } else {
                        // Hide cards that don't meet the condition
                        $(this).hide();
                    }
                });
            });

        });
    </script>
</body>

</html>