<!DOCTYPE html>
<html>
    <head>
        <title>Fridge - Dashboard</title>

        <style>
            body{
                width: 40%;
                margin: 0 auto;
            }
            ul {
                list-style-type: none;
                padding: 0;
                width: 300px;
                background-color: #f1f1f1;
                border: 1px solid #555;
                font-family: sans-serif;
            }

            li a {
                display: block;
                color: #000;
                padding: 8px 16px;
                text-decoration: none;
            }

            li {
                text-align: center;
                border-bottom: 1px solid #555;
            }

            li:last-child {
                border-bottom: none;
            }

            li a.active {
                background-color: #4CAF50;
                color: white;
            }

            li a:hover:not(.active) {
                background-color: #555;
                color: white;
            }
        </style>
    </head>
    <body>

        <h2>Admin - Dashboard</h2>

        <ul>
            <li><a class="active" href="<?php echo base_url() . 'dashboard'; ?>">Home</a></li>
            <li><a href="<?php echo base_url() . 'push_form'; ?>">Push Notification</a></li>
            <li><a href="<?php echo base_url() . 'ind_push_form'; ?>">Individual Push Notification</a></li>
            <li><a href="<?php echo base_url() . 'admin_logout'; ?>">Logout</a></li>
        </ul>