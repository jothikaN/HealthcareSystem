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
                                <h1 data-animation="fadeInUp" data-delay=".3s">Maintain Suggestion</h1>
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