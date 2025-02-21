<?php
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
                                            <h1 data-animation="fadeInUp" data-delay=".3s">Patients details</h1>
                                            <p data-animation="fadeInUp" data-delay=".6s">  "Live with hope today; tomorrow's wellness will surely be on your side."</p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                    <div>
                    <a href="index.php?pg=patient.php&option=add" class="genric-btn success radius">Add</a>
                    </div>
                        <?php
                        $sqlView = "SELECT * FROM patient";
                        $sqlResult = mysqli_query($con, $sqlView);
                        echo'
                            <table class="table table-striped">
                            <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">First_name</th>
                            <th scope="col">Last_name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile number</th>
                            <th scope="col">Age</th>
                            <th scope="col">Address</th>
                            <th scope="col">NIC</th>
                            <th scope="col">DOB</th>
                            <th scope="col">Address</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Height</th>
                            <th scope="col">Action</th>
                            </tr>
                            </thead>';
                        while($sqlRow = mysqli_fetch_assoc($sqlResult)) 
                        {
                            
                            echo'<tr>
                            <td>'.$sqlRow['id'].'</td>
                            <td>'.$sqlRow['first_name'].'</td>
                            <td>'.$sqlRow['last_name'].'</td>
                            <td>'.$sqlRow['email'].'</td>
                            <td>'.$sqlRow['mobile_number'].'</td>
                            <td>'.$sqlRow['age'].'</td>
                            <td>'.$sqlRow['address'].'</td>
                            <td>'.$sqlRow['nic_no'].'</td>
                            <td>'.$sqlRow['dob'].'</td>
                            <td>'.$sqlRow['gender'].'</td>
                            <td>'.$sqlRow['dob'].'</td>
                            <td>'.$sqlRow['weight'].'</td>
                            <td>'.$sqlRow['height'].'</td>
                            <td>'.$sqlRow['gender'].'</td>
                           
                            <td>'
                            ?>
                                <a href="index.php?pg=patient.php&option=edit?bstaffId=<?php echo $sqlRow['id'] ?>" class="genric-btn success radius"><i class="far fa-edit"></i></a>
                                <a href="index.php?pg=patient.php&option=delete?bstaffId=<?php echo $sqlRow['id'] ?>" class="genric-btn danger radius"><i class="fas fa-trash-alt"></i></a>
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
                                <h1 data-animation="fadeInUp" data-delay=".3s">Patients</h1>
                                <p data-animation="fadeInUp" data-delay=".6s">
                                    "Live with hope today; tomorrow's wellness will surely be on your side."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</<body>

</html>

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
    <div class="h1"> Add Your Details First! </h1>
    </div>
    <form action="connectpatient.php" method="POST">
        <div class="form-container">
            <!-- Column 1, Row 1 -->
            <div>
                <label for="name">First Name:</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter your Firstname" required>
            </div>
            <!-- Column 1, Row 2 -->
            <div>
                <label for="name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" placeholder="Enter your Last name" required>
            </div>
            <!-- Column 1, Row 2 -->
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <!-- Column 2, Row 2 -->
            <div>
                <label for="mobile Number">Mobile Number:</label>
                <input type="mobile_number" id="mobile_number" name="mobile_number"
                    placeholder="Enter your mobile number" required>
            </div>
            <!-- Column 1, Row 3 -->
            <div>
                <label for="age">Age:</label>
                <input type="age" id="age" name="age" placeholder="Enter your age" required>
            </div>
            <!-- Column 2, Row 3 -->
            <div>
                <label for="address">Address:</label>
                <input type="address" id="address" name="address" placeholder="Enter your address" required>
            </div>
            <!-- Column 1, Row 4 -->
            <div>
                <label for="nic_no">NIC NO:</label>
                <input type="nic_no" id="nic_no" name="nic_no" placeholder="Enter your nic" required>
            </div>
            <!-- Column 2, Row 4 -->
            <div>

                <label for="dob">DOB:</label>
                <input type="date" id="dob" name="dob" placeholder="Enter your dob" required>
            </div>
            <!-- Column 1, Row 5 -->
            <div>
                <label for="weight">Weight:</label>
                <input type="weight" id="weight" name="weight" placeholder="Enter your weight" required>
            </div>
            <!-- Column 2, Row 5 -->
            <div>
                <label for="height">Height:</label>
                <input type="height" id="height" name="height" placeholder="Enter your height" required>
            </div>
            <!-- Column 1, Row 6 -->
            <div>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
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
          
            ?>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

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
                                    <h1 data-animation="fadeInUp" data-delay=".3s">Patients</h1>
                                    <p data-animation="fadeInUp" data-delay=".6s">Almost before we knew it, we<br> had
                                        left the ground</p>
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


<?php
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