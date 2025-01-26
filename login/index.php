<!DOCTYPE html>
<html>
<head>
    <title>Event Scheduling System</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            background-image: url('background.jpg'); /* Adjust the image URL as needed */
            background-size: cover;
            background-position: center;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #333;
            color: white;
        }
        .logout-link {
            color: white;
            text-decoration: none;
        }
        .logout-link:hover {
            text-decoration: underline;
        }
        .system-name {
            font-size: 24px;
            margin-left: auto;
            margin-right: auto;
        }
        .subtopics {
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            background-color: #ddd;
        }
        .subtopic-link {
            color: #333;
            text-decoration: none;
            padding: 5px 10px;
        }
        .subtopic-link:hover {
            background-color: #ccc;
        }
        /* Style the dropdown button */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Style the dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            margin-top: 20px; /* Adjust the top margin as needed */
        }

        /* Style the dropdown links */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* Center the content container */
        .content {
            text-align: center;
            margin-top: 50px;
        }
    </style>
	
    
</head>
<body>
    <div class="header">
        <div class="system-name">Event Scheduling System</div>
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
    <div class="subtopics">
        <div class="dropdown">
            <a href="#" class="subtopic-link" onclick="loadWelcome()">Home</a>
        </div>
        <div class="dropdown" id="second-dropdown">
            <a href="#" class="subtopic-link" onclick="toggleDropdown('second-dropdown')">Category</a>
            <div class="dropdown-content">
                <a href="#" onclick="loadContent('category1.php'); closeDropdown('second-dropdown')">Event</a>
                <a href="#" onclick="loadContent('category2.php'); closeDropdown('second-dropdown')">Event for</a>
                <a href="#" onclick="loadContent('category3.php'); closeDropdown('second-dropdown')">Event Type</a>
            </div>
        </div>
        <div class="dropdown" id="third-dropdown">
            <a href="#" class="subtopic-link" onclick="toggleDropdown('third-dropdown')">Trainer Information</a>
            <div class="dropdown-content">
                <a href="#" onclick="loadContent('trainer.php'); closeDropdown('third-dropdown')">Create</a>
                <a href="#" onclick="loadContent('viewtrainers.php'); closeDropdown('third-dropdown')">View</a>
            </div>
        </div>
        
        <div class="dropdown" id="fourth-dropdown">
            <a href="#" class="subtopic-link" onclick="toggleDropdown('fourth-dropdown')">Workshop/class</a>
            <div class="dropdown-content">
                <a href="#" onclick="loadContent('class.php'); closeDropdown('fourth-dropdown')">Create</a>
                <a href="#" onclick="loadContent('viewworcls.php'); closeDropdown('fourth-dropdown')">View</a>
            </div>
        </div>
        
        <div class="dropdown" id="fifth-dropdown">
            <a href="#" class="subtopic-link" onclick="toggleDropdown('fifth-dropdown')">Timeslot</a>
            <div class="dropdown-content">
                <a href="#" onclick="loadContent('process_form.php'); closeDropdown('fifth-dropdown')">Create</a>
                <a href="#" onclick="loadContent('viewtimeslots.php'); closeDropdown('fifth-dropdown')">View</a>
            </div>
        </div>
        
        
        <div class="dropdown" id="sixth-dropdown">
            <a href="#" class="subtopic-link" onclick="toggleDropdown('sixth-dropdown')">Event Planner</a>
            <div class="dropdown-content">
              
<a href="#" onclick="closeDropdown('sixth-dropdown'); window.location.href='submit_event.php';">Create</a>


                <a href="#" onclick="loadContent('view_clpn.php'); closeDropdown('sixth-dropdown')">View</a>
            </div>
        </div>
        <!-- Add more subtopics here -->
    </div>

    <div id="content-container" class="content">
        <!-- Content loaded dynamically will appear here -->
    </div>

    <script type="text/javascript">
        function toggleDropdown(id) {
            var dropdown = document.getElementById(id);
            var dropdownContent = dropdown.querySelector('.dropdown-content');
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        }

        function loadContent(url) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content-container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
        }

        function loadWelcome() {
            document.getElementById("content-container").innerHTML = "<p>Welcome to the Event Scheduling System.</p>";
        }

        function closeDropdown(id) {
            var dropdown = document.getElementById(id);
            var dropdownContent = dropdown.querySelector('.dropdown-content');
            dropdownContent.style.display = 'none';
        }
    </script>
</body>
</html>
