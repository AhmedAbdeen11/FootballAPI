<?php

getLeagues();

global $id;

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $url = "http://localhost/FootballAPI/API/match/readMatchById.php";
//Initiate cURL.
    $ch = curl_init($url);

    //The JSON data.
    $jsonData = array(
        'id' => $_GET['id']
    );

    $jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
    global $match;
    $json = curl_exec($ch);
    $json = json_decode($json, true);
    $json = $json["matches"];
    $match = $json[0];
    curl_close($ch);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $url = "http://localhost/FootballAPI/API/match/update.php";
    //Initiate cURL.
    $ch = curl_init($url);

    global $id;

    //The JSON data.
    $jsonData = array(
         'id' => $id,
        'localteam_name' => $_POST['localteam_name'],
        'localteam_score' => $_POST['localteam_score'],
        'visitorteam_name' => $_POST['visitorteam_name'],
        'visitorteam_score' =>  $_POST['visitorteam_score'],
        'date' => $_POST['date'],
        'time' =>$_POST['time'],
        'league_id' =>$_POST['league_id'],
    );

    $jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
    $result = curl_exec($ch);
    curl_close($ch);

    $header_string = "Location: matches.php?league_id=" . $_POST['league_id'];
    header($header_string);
}

function getLeagues(){
    $url = "http://localhost/FootballAPI/API/league/read.php";
//Initiate cURL.
    $ch = curl_init($url);


//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
    global $leagues_json;
    $leagues_json = curl_exec($ch);
    $leagues_json = json_decode($leagues_json, true);
    curl_close($ch);
}


?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Forms</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
<div class="page-wrapper">

    <!-- PAGE CONTAINER-->
    <div class="page-container">

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">تعديل المباراة</h3>
                                    </div>
                                    <hr>
                                    <form action="updateMatch.php?id=<?php echo $_GET['id'];?>" method="post" name="updateMatchForm" onsubmit="return validateForm()" >

                                        <div class="form-group has-success">
                                            <label for="cc-name" class="control-label mb-1">اختر الدوري</label>
                                            <select name="league_id" dir="rtl" class="form-control">
                                                <!--Print All the Leagues In the selection-->
                                                <?php

                                                global $leagues_json;

                                                if(key_exists("leagues", $leagues_json)) {
                                                    foreach ($leagues_json['leagues'] as $league){
                                                        echo "<option value=\"".$league['id']."\" ";
                                                        if($league['id'] == $match['league_id'])
                                                            echo "selected=\"selected\"";
                                                        echo ">".$league['league_name']."</option>";
                                                    }
                                                }

                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">اسم الفريق صاحب الملعب</label>
                                            <input id="cc-pament" name="localteam_name" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                                   value="<?php echo $match['localteam_name']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">عدد الاهداف</label>
                                            <input id="cc-pament" name="localteam_score" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                                   value="<?php echo $match['localteam_score']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">اسم الفريق الضيف</label>
                                            <input id="cc-pament" name="visitorteam_name" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                                   value="<?php echo $match['visitorteam_name']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">عدد الاهداف</label>
                                            <input id="cc-pament" name="visitorteam_score" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                                   value="<?php echo $match['visitorteam_score']; ?>">
                                        </div>

                                        <div class="form-group has-success">
                                            <label for="cc-name" class="control-label mb-1">التاريخ</label>
                                            <input id="cc-name" name="date" type="date" dir="ltr" class="form-control cc-name valid" data-val="true" data-val-required="Please enter the name on card"
                                                   autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error"
                                                   value="<?php echo $match['date']; ?>">
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                        </div>

                                        <div class="form-group has-success">
                                            <label for="cc-name" class="control-label mb-1">موعد المباراة</label>
                                            <input id="cc-name" name="time" type="time" dir="ltr" class="form-control cc-name valid" data-val="true" data-val-required="Please enter the name on card"
                                                   autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error"
                                                   value="<?php echo $match['time']; ?>">
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                                        </div>
                                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                <span id="payment-button-amount">حفظ التعديلات</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Jquery JS-->
<script src="vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="vendor/bootstrap-4.1/popper.min.js"></script>
<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="vendor/slick/slick.min.js">
</script>
<script src="vendor/wow/wow.min.js"></script>
<script src="vendor/animsition/animsition.min.js"></script>
<script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="vendor/chartjs/Chart.bundle.min.js"></script>
<script src="vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="js/main.js"></script>
<script>
    function validateForm() {
        /*var fn = document.forms["updateFeatureForm"]["feature_name"].value;
        var va = document.forms["updateFeatureForm"]["verification_aspects"].value;
        var sa = document.forms["updateFeatureForm"]["suggested_activities"].value;
        if (fn == "" || va == "" || sa == "") {
            alert("Please fill all the fields");
            return false;
        }*/
        return true;
    }
</script>

</body>

</html>
<!-- end document-->