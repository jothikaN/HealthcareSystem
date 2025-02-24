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
                                <h1 data-animation="fadeInUp" data-delay=".3s">Blood Pressure details</h1>
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
        <a href="index.php?pg=bloodpressuredetails.php&option=add" class="genric-btn success radius">Add</a>
        </div>
            <?php
            $sqlView = "SELECT * FROM blood_pressure_details";
            $sqlResult = mysqli_query($con, $sqlView);
            echo'
                <table class="table table-striped">
                <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Systolic_range</th>
                <th scope="col">Diastolic_range	</th>
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
                    <td>'.$sqlRow['id'].'</td>
                    <td>'.$sqlRow['systolic_range'].'</td>
                    <td>'.$sqlRow['diastolic_range	'].'</td>
                    <td>'.$rowPatient['first_name'].'</td>
                    <td>'
                    ?>
                        <a href="index.php?pg=bloodpressuredetails.php&option=edit?bpressureId=<?php echo $sqlRow['id'] ?>" class="genric-btn success radius"><i class="far fa-edit"></i></a>
                        <a href="index.php?pg=bloodpressuredetails.php&option=delete?bpressureId=<?php echo $sqlRow['id'] ?>" class="genric-btn danger radius"><i class="fas fa-trash-alt"></i></a>
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
                                                    <h1 data-animation="fadeInUp" data-delay=".3s">Blood Pressure</h1>
                                                    <p data-animation="fadeInUp" data-delay=".6s">Almost before we knew it, we<br> had left the ground</p>
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
        max-width: 650px;
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
    <div class="h1">Enter Your Blood Pressure Details</div>

    <form action="bloodpressureconnect.php" method="POST">
        <div class="form-container">
            <!-- Diastolic Range Input -->
            <div>
                <label for="diastolic_range">Diastolic Range: </label>
                <input type="text" id="diastolic_range" name="diastolic_range" placeholder="Enter your diastolic range" required >
              
            </div>

            <!-- Systolic Range Input -->
            <div>
                <label for="systolic_range">Systolic Range:</label>
                <input type="text" id="systolic_range" name="systolic_range" placeholder="Enter your systolic range" required>
              
            </div>

            <!-- Submit Button -->
            <div class="form-actions">
                <button type="submit">Submit</button>
            </div>
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