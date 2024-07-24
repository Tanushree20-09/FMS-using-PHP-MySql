<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>East Coast Railway</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('train.jpg');
            background-size: cover;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(0, 123, 255, 0.8);
            padding: 20px;
            color: white;
        }
        .header img {
            margin-right: 20px;
            width: 50px;
            height: auto;
        }
        .header h1 {
            margin: 0;
            display: flex;
            align-items: center;
        }
        .date-time {
            font-weight: bold;
            margin-right: 20px;
        }
        
        .header-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .profile-container {
            position: relative;
            display: inline-block;
        }
        .profile-icon {
            width: 40px;
            height: 40px;
            background: url('user.png') no-repeat center center;
            background-size: contain;
            cursor: pointer;
            border-radius: 50%;
        }
        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            width: 200px;
        }
        .profile-dropdown div {
            margin-bottom: 10px;
        }
        .profile-dropdown #username {
        color: black;
        font-weight: bold;
    }
        .profile-dropdown button {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .profile-dropdown button:hover {
            background-color: #c82333;
        }
        .sidebar {
            width: 280px;
            height: calc(100vh - 50px);
            border-right: 1px solid #ccc;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            position: fixed;
            top: 78px;
            margin-top: 10px;
            overflow-y: auto;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .sidebar li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 5px 0;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 5px;
        }
        .sidebar li:hover {
            background-color: rgba(0, 123, 255, 0.8);
            color: black;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 5px 10px;
            font-size: 12px;
            transition: background-color 0.2s ease-in-out;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .content {
            margin-left: 300px;
            padding: 20px;
        }
        .table-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            opacity: 0; /* Start hidden for animation */
            transform: scale(0.95); /* Slightly scaled down for animation */
            transition: opacity 0.5s ease-in, transform 0.5s ease-in;
        }
        .table-container.show {
            opacity: 1; /* Fade in */
            transform: scale(1); /* Scale up */
        }
        .table-container h2 {
            margin: 0;
            padding-bottom: 10px;
            font-size: 18px;
            color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        td {
            background-color: #fff;
        }
        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }


        .buttons-container {
            margin-top: 10px;
            display: flex;
            gap: 15px;
        }
        .buttons-container button {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .buttons-container button:hover {
            background-color: #003d82;
        }
        .add-category-container {
            margin-top: 20px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
        }
        .add-category-container input, .add-category-container select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: calc(100% - 120px);
            margin-right: 10px;
        }
        .add-category-container button {
            padding: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-category-container button:hover {
            background-color: #003d82;
        }
        .subcategory-container {
            display: none; /* Hide by default */
            margin-top: 10px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
        }
        .subcategory-container div {
            cursor: pointer; /* Show pointer cursor for clickable items */
            padding: 5px;
            border-radius: 3px;
            transition: background-color 0.3s, color 0.3s;
    font-size: 16px; /* Adjust font size if needed */
        }
        .subcategory-container div:hover {
    background-color: rgba(0, 123, 255, 0.6); /* Highlight on hover */
    color: white; /* Change text color on hover */
}
.subcategory-table-body td {
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s, transform 0.2s;
    }

    .subcategory-table-body td:hover {
        background-color: #e7f0ff; /* Light blue background on hover */
        color: #0056b3; /* Darker text color on hover */
        transform: scale(1.02); /* Slightly enlarge on hover */
    }
    
    .subcategory-table-body td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    
    .subcategory-table-body td:first-child {
        font-weight: bold;
    }
    .delete-button {
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    padding: 5px 10px;
    font-size: 12px;
    transition: background-color 0.2s ease-in-out;
}

.delete-button:hover {
    background-color: #c82333;
}

    
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            updateTime();
            setInterval(updateTime, 1000);
            loadCategories(); // Ensure categories are loaded on page load
            fetchUsername(); // Fetch and display the username
        });

        function updateTime() {
            var now = new Date();
            var options = { timeZone: 'Asia/Kolkata', hour12: true };
            var timeString = now.toLocaleString('en-IN', options);
            document.getElementById('date-time').textContent = timeString;
        }

        function fetchUsername() {
            fetch('get_username.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('username').textContent = data.username;
                })
                .catch(error => console.error('Error fetching username:', error));
        }

        function loadCategories() {
            fetch('categories.php')
                .then(response => response.json())
                .then(data => {
                    const categoryList = document.getElementById('category-list');
                    const categorySelect = document.getElementById('category-select');
                    categoryList.innerHTML = ''; // Clear existing list
                    categorySelect.innerHTML = '<option value="">Select Category</option>'; // Reset select options

                    data.forEach(category => {
                        // Add category to the sidebar list
                        const li = document.createElement('li');
                        li.innerHTML = `
                            <span onclick="toggleSubcategoryPanel(${category.id})">${category.name}</span>
                            <div id="subcategory-panel-${category.id}" class="subcategory-container">
                                <!-- Subcategories will be dynamically loaded here -->
                            </div>
                            <button onclick="deleteCategory(${category.id})" class="delete-button">Delete</button>
                        `;
                        categoryList.appendChild(li);

                        // Add category to the select dropdown
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);

                        loadSubcategories(category.id);
                    });
                });
        }
        function toggleSubcategoryPanel(categoryId, categoryName) {
    const tableContainer = document.getElementById('subcategory-table-container');
    const tableHeader = document.getElementById('subcategory-table-header');

    fetch(`subcat.php?categoryId=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('subcategory-table-body');
            tableBody.innerHTML = ''; // Clear existing rows

            // Update the header with the category name
            tableHeader.textContent = `Category: ${data.categoryName}`;

            data.subcategories.forEach((subcategory, index) => {
                const tr = document.createElement('tr');

                const tdSerial = document.createElement('td');
                tdSerial.textContent = index + 1;
                tr.appendChild(tdSerial);

                const tdName = document.createElement('td');
                tdName.textContent = subcategory.name;
                tdName.onclick = function() {
                    window.location.href = `upload.php?subcategoryId=${subcategory.id}`; // Redirect to upload.php with subcategory ID
                };
                tr.appendChild(tdName);

                const tdDelete = document.createElement('td');
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.className = 'delete-button';
                deleteButton.onclick = function(event) {
                    event.stopPropagation(); // Prevent table row click event
                    deleteSubcategory(subcategory.id, categoryId);
                };
                tdDelete.appendChild(deleteButton);
                tr.appendChild(tdDelete);

                tableBody.appendChild(tr);
            });

            tableContainer.classList.add('show'); // Trigger animation
        })
        .catch(error => console.error('Error fetching subcategories:', error));
}


function deleteSubcategory(subcategoryId, categoryId) {
    fetch('delete_subcat.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: subcategoryId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toggleSubcategoryPanel(categoryId, document.getElementById('subcategory-table-header').textContent.replace('Category: ', ''));
        } else {
            alert('Failed to delete subcategory.');
        }
    })
    .catch(error => console.error('Error:', error));
}



        function addCategory() {
            const categoryInput = document.getElementById('new-category');
            const categoryName = categoryInput.value.trim();
            if (categoryName !== '') {
                fetch('add_category.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name: categoryName })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadCategories();
                        categoryInput.value = '';
                    } else {
                        alert('Failed to add category.');
                    }
                });
            }
        }

        function deleteCategory(categoryId) {
            fetch('delete_cat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: categoryId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCategories(); // Reload categories after deletion
                } else {
                    alert('Failed to delete category.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function addSubcategory() {
            const categorySelect = document.getElementById('category-select');
            const subcategoryInput = document.getElementById('new-subcategory');
            const categoryId = categorySelect.value;
            const subcategoryName = subcategoryInput.value.trim();
            if (subcategoryName !== '' && categoryId !== '') {
                fetch('add_subcat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name: subcategoryName, categoryId: categoryId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadSubcategories(categoryId);
                        subcategoryInput.value = '';
                    } else {
                        alert('Failed to add subcategory.');
                    }
                });
            }
        }

        function loadSubcategories(categoryId) {
    fetch(`subcat.php?categoryId=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('subcategory-table-body');
            tableBody.innerHTML = ''; // Clear existing rows
            data.forEach((subcategory, index) => {
                const tr = document.createElement('tr');
                const tdSerial = document.createElement('td');
                tdSerial.textContent = index + 1;
                const tdName = document.createElement('td');
                tdName.textContent = subcategory.name;
                tdName.onclick = function() {
                    window.location.href = `upload.php?subcategoryId=${subcategory.id}`; // Redirect to upload.php with subcategory ID
                };
                tr.appendChild(tdSerial);
                tr.appendChild(tdName);
                tableBody.appendChild(tr);
            });

            tableContainer.classList.add('show'); // Trigger animation
        })
        .catch(error => console.error('Error fetching subcategories:', error));
}



      

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
        }

        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</head>
<body>
    <div class="header">
        <h1><img src="logo.png" alt="Logo">East Coast Railway</h1>
        <div class="header-controls">
            <div id="date-time" class="date-time"></div>
            
            <div class="profile-container">
                <div class="profile-icon" onclick="toggleProfileDropdown()"></div>
                <div id="profile-dropdown" class="profile-dropdown">
                    <div id="username" >Username</div>
                    <button onclick="confirmLogout()">Logout</button>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <ul id="category-list">
            <!-- Categories will be dynamically loaded here -->
        </ul>
        <div class="add-category-container">
            <input type="text" id="new-category" placeholder="CATEGORY/DEPARTMENT NAME">
            <button onclick="addCategory()">SUBMIT</button>
        </div>
    </div>
    <div class="content">
        <div class="add-category-container">
            <select id="category-select">
                <!-- Categories will be dynamically loaded here -->
            </select>
            <input type="text" id="new-subcategory" placeholder="SUBCATEGORY NAME">
            <button onclick="addSubcategory()">ADD SUBCATEGORY</button>
        </div>
        <div id="subcategory-table-container" class="table-container">
    <h2 id="subcategory-table-header">Category: </h2>
    <table>
        <thead>
            <tr>
                <th>SL NO</th>
                <th>Subcategory</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="subcategory-table-body">
            <!-- Subcategories will be dynamically loaded here -->
        </tbody>
    </table>
</div>

    </div>
</body>
</html>
    </div>
</body>
</html>
