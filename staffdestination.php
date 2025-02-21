<?php
    if(isset($_GET["option"])){
        if($_GET["option"] == "view"){

        }
        else if($_GET["option"] == "add"){
            ?>

<div class="slider-area slider-area2">
    <div class="slider-active dot-style">
        <!-- Slider Single -->
        <div class="single-slider  d-flex align-items-center slider-height2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-8 col-md-10 ">
                        <div class="hero-wrapper">
                            <div class="hero__caption">
                                <h1 data-animation="fadeInUp" data-delay=".3s">Staff destination</h1>
                                <p data-animation="fadeInUp" data-delay=".6s">"Focus on the journey, not the
                                    destination. Joy is found not in finishing an activity but in doing it."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2 Column and 2 Row Form</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .h1 {
        text-align: center;
        font-size: 40px;

    }

    .form-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* Two columns */
        grid-gap: 20px;
        /* Space between columns and rows */
        max-width: 600px;
        margin: 20px auto;
        font-size: 20px;
    }

    .form-container label {
        display: block;
        margin-bottom: 5px;
    }

    .form-container input,
    .form-container select,
    .form-container textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    .form-actions {
        grid-column: 1 / -1;
        /* Span across both columns */
        text-align: center;
    }

    button {
        padding: 10px 20px;
        margin: 5px;
        background-color: #ffffff;
        /* Red */
        color: #000000;
    }
    </style>
</head>

<body>
    <div class="h1"> Staff destination Details</h1>
    </div>
    <form action="connectstaff.php" method="POST">
        <div class="form-container">
            <!-- Column 1, Row 1 -->
            <div>
                <label for="destination_id">Destination Id:</label>
                <input type="text" id="destination_id" name="destination_id" placeholder="Enter your destination_id"
                    required>
            </div>
            <!-- Column 1, Row 2 -->
            <div>
                <label for="staff_id">Staff ID:</label>
                <input type="text" id="staff_id" name="staff_id" placeholder="Enter your staff Id" required>
            </div>
            <!-- Column 1, Row 2 -->
            <div>
                <label for="current_location">Current location:</label>
                <input type="current_location" id="current_location" name="current_location"
                    placeholder="Enter your current_location" required>
            </div>
            <!-- Column 2, Row 1 -->
            <div>
                <label for="shift_time">Hire Date:</label>
                <input type="date" id="shift_time" name="shift_time" placeholder="Enter your shift_time" required>
            </div>
            <!-- Column 3, Row 1 -->

            <!-- Column 1, Row 6 -->
            <div>

                <label for="remarks">Remarks:</label>
                <select id="remarks" name="remarks" required>
                    <option value="excellent">Excellent</option>
                    <option value="good">Good</option>
                    <option value="poor">Poor</option>
                </select>
            </div>


            <!-- Column 2, Row 6 -->
            <div class="form-actions">
                <button type="submit">Submit</button>
            </div>
    </form>


</body>

</html>



<?php

        }
        else if($_GET["option"] == "edit"){

        }
        else if($_GET["option"] == "fullview"){

        }
        else if($_GET["option"] == "delete"){

        }
    }
    else{
        echo'<script>window.location.href="index.php";</script>';
    }
    ?>