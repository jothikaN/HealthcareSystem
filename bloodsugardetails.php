<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    if(isset($_GET["option"])){
        if($_GET["option"] == "view"){

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
                                <h1 data-animation="fadeInUp" data-delay=".3s">Blood Sugar details</h1>
                                <p data-animation="fadeInUp" data-delay=".6s">Almost before we knew it, we<br> had left
                                    the ground</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <div>
        <a href="index.php?pg=bloodsugardetails.php&option=add" class="genric-btn success radius">Add</a>
        </div>
            <?php
            $sqlView = "SELECT * FROM blood_sugar_details";
            $sqlResult = mysqli_query($con, $sqlView);
            echo'
                <table class="table table-striped">
                <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Type</th>
                <th scope="col">Level Type</th>
                <th scope="col">Sugar Range</th>
                <th scope="col">Patient Name</th>
                <th scope="col">Action</th>
                </tr>
                </thead>';
            while($sqlRow = mysqli_fetch_assoc($sqlResult)) 
            {
                $sqlViewPatient = "SELECT first_name FROM patient WHERE id='$sqlRow[patient_id]'";
                $sqlResultPatient = mysqli_query($con, $sqlViewPatient);
                $rowPatient = mysqli_fetch_assoc($sqlResultPatient);
                echo'<tr>
                <td>'.$sqlRow['blood_sugar_id'].'</td>
                <td>'.$sqlRow['types'].'</td>
                <td>'.$sqlRow['level_type'].'</td>
                <td>'.$sqlRow['sugar_range'].'</td>
                <td>'.$rowPatient['first_name'].'</td>
                <td>'
                ?>
                    <a href="index.php?pg=bloodsugardetails.php&option=edit?bsugarId=<?php echo $sqlRow['blood_sugar_id'] ?>" class="genric-btn success radius"><i class="far fa-edit"></i></a>
                    <a href="index.php?pg=bloodsugardetails.php&option=delete?bsugarId=<?php echo $sqlRow['blood_sugar_id'] ?>" class="genric-btn danger radius"><i class="fas fa-trash-alt"></i></a>
                <?php
                echo'</td>
                </tr>';
            }

            echo'</table>';

            ?>
            <?php

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
                                <h1 data-animation="fadeInUp" data-delay=".3s">Blood Sugar details</h1>
                                <p data-animation="fadeInUp" data-delay=".6s">Almost before we knew it, we<br> had left
                                    the ground</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
    <div class="h1">Enter Your Blood Sugar Details</h1>
    </div>
    <form action="bloodsugarconnect.php" method="POST">
        <div class="form-container">
            <!-- Column 1, Row 1 -->
            <div>
                <label for="range">Range:</label>
                <input type="text" id="range" name="range" placeholder="Enter your blood sugar range" required>
            </div>

            <!-- Column 1, Row 2 -->
            <div>
                <label for="types">Types</label>
                <select id="types" name="types" required>
                    <option value="postprandial">Postprandial</option>
                    <option value="fasting">Fasting</option>
                </select>
            </div>
            <!-- Column 1, Row 2 -->
            <div>
                <label for="level type">Level Type</label>
                <select id="level type" name="level type" required>
                    <option value="hyperglycemia">Hyperglycemia</option>
                    <option value="Hyporglycemia">Hyporglycemia</option>
                    <option value="normal">Normal</option>
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