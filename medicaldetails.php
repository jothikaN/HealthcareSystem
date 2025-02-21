<?php
    if(isset($_GET["option"])){
        if($_GET["option"] == "view"){

        }
        else if($_GET["option"] == "add"){
            ?>
<html>

<head>
    <title></title>

<body>
    <div class="slider-area slider-area2">
        <div class="slider-active dot-style">
            <!-- Slider Single -->
            <div class="single-slider  d-flex align-items-center slider-height2">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-7 col-lg-8 col-md-10 ">
                            <div class="hero-wrapper">
                                <div class="hero__caption">
                                    <h1 data-animation="fadeInUp" data-delay=".3s">medical Details</h1>
                                    <p data-animation="fadeInUp" data-delay=".6s">Almost before we knew it, we<br> had
                                        left
                                        the ground</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

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
    <div class="h1">Check Your Medical Details</h1>
    </div>
    <form action="" method="POST">
        <div class="form-container">

            <div class="blood-sugar-box">
    <label for="range">Blood Sugar</label>
    <div class="input-container">
        <input type="number" id="range" name="range" placeholder="Enter value" required>
        <select id="types" name="types" required>
            <option value="mg/dL">mg/dL</option>
            <option value="mmol/L">mmol/L</option>
        </select>
    </div>
</div>
            <div>
                <label for="range">Blood Pressure:</label>
                <input type="text" id="range" name="range" placeholder="Enter value" required>
            </div>


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