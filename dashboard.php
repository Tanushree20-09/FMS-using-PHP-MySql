<?php
require 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>East Coast Railway Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Add your existing styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('back.jpg');
            background-size: cover;
            background-position: center;
            animation: zoomEffect 20s infinite alternate;
        }
        @keyframes zoomEffect {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(0, 123, 255, 0.8);
            padding: 20px;
            color: white;
            position: relative;
            z-index: 1;
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
            animation: slideIn 2s ease-out, fadeIn 2s ease-in;
            
        }
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(0);
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .date-time {
            margin-right: 180px;
            font-weight: bold;
        }
        .login-container {
            display: flex;
            align-items: center;
        }
        .login-button {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            margin-right: 10px;
        }
        .login-button:hover {
            background-color: #003d82;
        }
        .icon {
            width: 40px; /* Adjust width as needed */
            height: auto;
            margin-left: 10px; 
        }
        .sidebar {
            width: 250px;
            height: calc(100vh - 60px);
            border-right: 1px solid #ccc;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            position: fixed;
            top: 78px;
            margin-top: 10px;
            overflow-y: auto;
            z-index: 1;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        .category {
            cursor: pointer;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            position: relative;
        }
        .category:hover {
            background-color: rgba(0, 123, 255, 0.2);
        }
        .category::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: rgba(0, 123, 255, 1);
            transition: width 0.3s;
        }
        .category.active::after {
            width: 100%;
        }
        .subcategory-container {
            display: none;
            border-bottom: 1px solid #eee;
        }
        .subcategory {
            padding: 10px;
            padding-left: 20px;
            cursor: pointer;
        }
        .subcategory:hover {
            background-color: rgba(0, 123, 255, 0.2);
        }
        .subcategory.clicked {
            background-color: rgba(0, 123, 255, 0.4);
        }
        .category.active + .subcategory-container {
            display: block;
        }
        .selected-info, .years, .files {
            display: none;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ccc;
            margin: 10px 0;
            border-radius: 10px;
        }
        .selected-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .selected-info span {
            font-weight: bold;
            font-size: 1.2em;
        }
        .years button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            transition: background-color 0.2s ease-in-out;
        }
        .years button:hover {
            background-color: #0056b3;
        }
        .files table {
            width: 100%;
            border-collapse: collapse;
        }
        .files th, .files td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .files th {
            background-color: #007bff;
            color: white;
        }
        .files tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function updateTime() {
            var now = new Date();
            var options = { timeZone: 'Asia/Kolkata', hour12: true };
            var timeString = now.toLocaleString('en-IN', options);
            document.getElementById('date-time').textContent = timeString;
        }

        document.addEventListener('DOMContentLoaded', function () {
            fetch('display.php')
                .then(response => response.json())
                .then(data => {
                    const sidebar = document.querySelector('.sidebar');
                    const selectedInfo = document.querySelector('.selected-info');
                    const selectedInfoText = document.querySelector('.selected-info span');
                    const yearsContainer = document.querySelector('.years');
                    const filesContainer = document.querySelector('.files');
                    const years = ['2021', '2022', '2023', '2024'];

                    data.forEach(category => {
                        const categoryElement = document.createElement('div');
                        categoryElement.classList.add('category');
                        categoryElement.textContent = category.name;
                        sidebar.appendChild(categoryElement);

                        const subcategoryContainer = document.createElement('div');
                        subcategoryContainer.classList.add('subcategory-container');
                        sidebar.appendChild(subcategoryContainer);

                        category.subcategories.forEach(subcategory => {
                            const subcategoryElement = document.createElement('div');
                            subcategoryElement.classList.add('subcategory');
                            subcategoryElement.textContent = subcategory.name;
                            subcategoryElement.dataset.id = subcategory.id; // Store subcategory ID
                            subcategoryContainer.appendChild(subcategoryElement);

                            subcategoryElement.addEventListener('click', (e) => {
                                e.stopPropagation();
                                subcategoryElement.classList.toggle('clicked');

                                // Update selected category and subcategory
                                selectedInfoText.textContent = `${category.name} > ${subcategory.name}`;
                                selectedInfo.style.display = 'flex';

                                // Display the years
                                yearsContainer.innerHTML = years.map(year => 
                                    `<button onclick="fetchFiles(${subcategory.id}, '${year}')">${year}</button>`
                                ).join('');
                                yearsContainer.style.display = 'flex';

                                // Hide files container initially
                                filesContainer.style.display = 'none';
                            });
                        });

                        categoryElement.addEventListener('click', () => {
                            const subcategoryContainers = document.querySelectorAll('.subcategory-container');
                            subcategoryContainers.forEach(container => {
                                if (container.previousElementSibling !== categoryElement) {
                                    container.style.display = 'none';
                                    container.previousElementSibling.classList.remove('active');
                                }
                            });

                            if (subcategoryContainer.style.display === 'block') {
                                subcategoryContainer.style.display = 'none';
                                selectedInfo.style.display = 'none';
                                yearsContainer.style.display = 'none';
                                filesContainer.style.display = 'none';
                            } else {
                                subcategoryContainer.style.display = 'block';
                                categoryElement.classList.add('active');
                            }
                        });
                    });
                });
        });

        function fetchFiles(subcategoryId, year) {
            fetch(`files.php?subcategory_id=${subcategoryId}&year=${year}`)
                .then(response => response.text())
                .then(html => {
                    const filesContainer = document.querySelector('.files');
                    filesContainer.innerHTML = html;
                    filesContainer.style.display = 'block';
                });
        }

        function redirectToLogin() {
            window.location.href = 'login.php';
        }
    </script>
</head>
<body onload="updateTime()">
    <div class="background"></div>
    <div class="header">
        <h1><img src="logo.png" alt="Logo">East Coast Railway</h1>
        <div class="login-container">
            <button class="login-button" onclick="redirectToLogin()">Log in</button>
            <img src="icon.jpg" alt="User Icon" class="icon"> <!-- JPEG Image for icon -->
        </div>
    </div>
    

    <div class="sidebar"></div>
    <div class="content">
        <div class="selected-info">
            <span>Category > Subcategory</span>
        </div>
        <div class="years"></div>
        <div class="files"></div>
        <!-- Additional content can go here -->
    </div>
</body>
</html>
