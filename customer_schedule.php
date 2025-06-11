<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include necessary stylesheets for FullCalendar, Bootstrap, and datetimepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    <!-- Include jQuery and Bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include necessary scripts for FullCalendar and datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Additional head section content -->
    <title>Customer Schedule</title>
    <!-- ... (rest of the head section) ... -->
</head>

<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <b>Customer Schedules</b>
                <span class="float:right">
                    <button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" id="new_schedule">
                        <i class="fa fa-plus"></i> New Entry
                    </button>
                </span>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Member selection modal -->
    <div class="modal fade" id="memberSelectionModal" tabindex="-1" role="dialog" aria-labelledby="memberSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memberSelectionModalLabel">Select Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Search input for customers -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="customerSearchInput" placeholder="Search for customers">
                    </div>

                    <!-- Display registered customers for selection -->
                    <ul class="list-group" id="customerList">
                        <!-- Customers will be dynamically loaded here -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule modal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule for Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="scheduleForm">
                        <div class="form-group">
                            <label for="scheduleDate">Start Date:</label>
                            <input type="text" class="form-control" id="scheduleDate" name="scheduleDate" placeholder="Select start date" required>
                        </div>
                        <div class="form-group">
                            <label for="scheduleDuration">Duration:</label>
                            <select class="form-control" id="scheduleDuration" name="scheduleDuration">
                                <option value="1">One Day</option>
                                <option value="2">Two Days</option>
                                <option value="7">One Week</option>
                                <option value="30">One month</option>
                                <option value="90">Three Months</option>
                                <option value="180">Six Months</option>
                                <option value="365">One Year</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="scheduleTimeIn">Time In:</label>
                            <input type="text" class="form-control" id="scheduleTimeIn" name="scheduleTimeIn" placeholder="Select time in" required>
                        </div>
                        <div class="form-group">
                            <label for="scheduleTimeOut">Time Out:</label>
                            <input type="text" class="form-control" id="scheduleTimeOut" name="scheduleTimeOut" placeholder="Select time out" required>
                        </div>
                        <div class="form-group">
                            <label for="scheduleEndDate">End Date:</label>
                            <input type="text" class="form-control" id="scheduleEndDate" name="scheduleEndDate" readonly>
                        </div>
                        <input type="hidden" id="selectedCustomerId" name="selectedCustomerId">
                        <button type="button" class="btn btn-primary" id="saveScheduleBtn">Save Schedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script section -->
    <script>
        $(document).ready(function () {
            // Initialize FullCalendar
            $('#calendar').fullCalendar({
                // ... (rest of the FullCalendar configuration) ...
            });

            // Display customer selection modal when "New Entry" button is clicked
            $('#new_schedule').click(function () {
                $('#memberSelectionModal').modal('show');
                loadCustomers(); // Load registered customers when the modal is shown
            });

            // Initialize datetimepicker for date and time selection
            $('#scheduleDate').datetimepicker({
                format: 'YYYY-MM-DD',
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-crosshairs',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                },
                useCurrent: false
            });

            $('#scheduleTimeIn, #scheduleTimeOut').datetimepicker({
                format: 'HH:mm',
                stepping: 15,
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-crosshairs',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                }
            });

            // Update end date when start date changes
            $('#scheduleDate').on('dp.change', function (e) {
                updateEndDate();
            });

            // Update end date when duration changes
            $('#scheduleDuration').change(function () {
                updateEndDate();
            });

            $('#saveScheduleBtn').click(function () {
                saveSchedule();
            });
        });

        // Function to load registered customers dynamically using AJAX
        function loadCustomers() {
            $.ajax({
                url: 'get_customers.php',
                method: 'GET',
                dataType: 'json',
                success: function (customers) {
                    displayCustomers(customers);
                },
                error: function (error) {
                    console.error('Error fetching customers:', error);
                }
            });
        }

        // Function to filter displayed customers based on search term
        function filterCustomers(searchTerm) {
            $.ajax({
                url: 'get_customers.php', // Adjust the URL based on your implementation
                method: 'GET',
                dataType: 'json',
                success: function (customers) {
                    var filteredCustomers = customers.filter(function (customer) {
                        return customer.fullname.toLowerCase().includes(searchTerm);
                    });
                    displayCustomers(filteredCustomers);
                },
                error: function (error) {
                    console.error('Error fetching customers:', error);
                }
            });
        }

        // Function to display customers in the list
        function displayCustomers(customers) {
            var customerList = $('#customerList');
            customerList.empty();

            customers.forEach(function (customer) {
                var listItem = $('<li class="list-group-item" data-customer-id="' + customer.customer_id + '">' + customer.fullname + '</li>');
                listItem.click(function () {
                    var selectedCustomerId = $(this).data('customer-id');
                    $('#memberSelectionModal').modal('hide');
                    $('#selectedCustomerId').val(selectedCustomerId);
                    $('#scheduleModal').modal('show');
                });
                customerList.append(listItem);
            });
        }

        // Function to update the end date based on the start date and duration
        function updateEndDate() {
            var startDate = $('#scheduleDate').data("DateTimePicker").date();
            var duration = parseInt($('#scheduleDuration').val());
            if (!isNaN(duration) && startDate) {
                var endDate = moment(startDate).add(duration, 'days').format('YYYY-MM-DD');
                $('#scheduleEndDate').val(endDate);
            }
        }

        // Function to save the schedule
        function saveSchedule() {
            var scheduleDate = $('#scheduleDate').val();
            var scheduleDuration = $('#scheduleDuration').val();
            var scheduleTimeIn = $('#scheduleTimeIn').val();
            var scheduleTimeOut = $('#scheduleTimeOut').val();
            var selectedCustomerId = $('#selectedCustomerId').val();

            // Send schedule data to the server-side script for processing
            $.ajax({
                url: 'save_schedule.php',
                method: 'POST',
                data: {
                    customerId: selectedCustomerId,
                    startDate: scheduleDate,
                    duration: scheduleDuration,
                    timeIn: scheduleTimeIn,
                    timeOut: scheduleTimeOut
                },
                success: function (response) {
                    // Handle the response from the server
                    alert(response);
                },
                error: function (error) {
                    console.error('Error saving schedule:', error);
                }
            });

            // Implement your scheduling logic here
            // For simplicity, let's schedule for the selected date, duration, time in, and time out
            var endDate = moment(scheduleDate).add(scheduleDuration, 'days').format('YYYY-MM-DD');
            var schedule = {
                title: 'Customer Schedule',
                start: scheduleDate + 'T' + scheduleTimeIn,
                end: endDate + 'T' + scheduleTimeOut,
                allDay: false
            };

            // Add the schedule to the FullCalendar
            $('#calendar').fullCalendar('renderEvent', schedule, true);

            // Close the schedule modal
            $('#scheduleModal').modal('hide');
        }
    </script>
</body>

</html>
