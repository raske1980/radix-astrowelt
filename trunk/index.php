<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include 'constants.php';
include 'GoogleAPI.php';

$submitValue = "";
if(isset($_POST["submitvalue"])){
    $submitValue = $_POST["submitvalue"];
}
$submitLength = strlen($submitValue);
$results = array();
                        

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            #countryvalidation, #cityvalidation, #postalvalidation,#birthdatevalidation, #birthtimevalidation{
                display: none;
                color:red;
            }
            
            #countrymain, #citymain,#postalmain{
                width: 100%;
            }
            
            label{
                width: 100px;
                display: inline-block
            }
            
            #search{
                margin-top: 20px;
                margin-left: 105px;
            }
            
            input, select{
                width:160px;
            }
            
        </style>
        
        <script type="text/javascript">
            beforeSubmit = function(){
                var countryField = document.getElementById('country');
                var cityField = document.getElementById('city');
                var postalField = document.getElementById('postal');
                
                var birthYear = document.getElementById('year');
                var birthMonth = document.getElementById('month');
                var birthDay = document.getElementById('day');
                var birthHour = document.getElementById('hour');
                var birthMinute = document.getElementById('minute');
                
                var countryValue = countryField.value.toString();
                var cityValue = cityField.value.toString();
                var postalValue = postalField.value.toString();
                
                var birthYearValue = birthYear.value.toString();
                var birthMonthValue = birthMonth.value.toString();
                var birthDayValue = birthDay.value.toString();
                
                var birthHourValue = birthHour.value.toString();
                var birthMinuteValue = birthMinute.value.toString();
                
                if(countryValue != "" && cityValue != "" && postalValue != "" 
                        && birthDayValue != "" && birthMonthValue != "" &&
                        birthYearValue != "" && birthHourValue != "" && birthMinuteValue != "" ){
                    var submitField = document.getElementById('submitvalue');
                    submitField.value = "firstsubmit";
                    return true;
                }
                else{
                    
                    if(birthDayValue.length == 0){
                        document.getElementById('birthdatevalidation').style.display = 'block';
                    }
                    else{
                        document.getElementById('birthdatevalidation').style.display = 'none';
                    }                                        
                    
                    if(birthMonthValue.length == 0){
                        document.getElementById('birthdatevalidation').style.display = 'block';
                    }
                    else{
                        document.getElementById('birthdatevalidation').style.display = 'none';
                    }
                    
                    if(birthYearValue.length == 0){
                        document.getElementById('birthdatevalidation').style.display = 'block';
                    }
                    else{
                        document.getElementById('birthdatevalidation').style.display = 'none';
                    }                                        
                    
                    if(birthHourValue.length == 0){
                        document.getElementById('birthtimevalidation').style.display = 'block';
                    }
                    else{
                        document.getElementById('birthtimevalidation').style.display = 'none';
                    }
                    
                    if(birthMinuteValue.length == 0){
                        document.getElementById('birthtimevalidation').style.display = 'block';
                    }
                    else{
                        document.getElementById('birthtimevalidation').style.display = 'none';
                    }
                    
                    if(countryValue.length == 0){
                        document.getElementById('countryvalidation').style.display = 'block';
                    }
                    else{
                        document.getElementById('countryvalidation').style.display = 'none';
                    }
                    
                    if(cityValue.length == 0){
                        document.getElementById('cityvalidation').style.display = 'block';
                    }
                    else{
                        document.getElementById('cityvalidation').style.display = 'none';
                    }
                    
                    if(postalValue.length == 0){
                        document.getElementById('postalvalidation').style.display = 'block';
                    }
                    else{
                        document.getElementById('postalvalidation').style.display = 'none';
                    }                
                    
                    return false;
                }                                    
            }
        </script>
    </head>
    <body>       
        <form id="mainform" method="POST" action="index.php" onsubmit="return beforeSubmit()">
            <div id="countrymain">
                <p id="countryvalidation">Please provide country.</p>
                <span>
                    <label id="lablelcountry">Country</label>
                    <select id="country" name="country">
                        <option value=""></option>
                        <?php 
                        
                        
                        if($submitLength == 0){
                            foreach ($countryinfo as $cinfo){
                                echo '<option value="'.$cinfo["iso_alpha2"].'" >'.$cinfo["name"].'</option>';
                            }
                        }                         
                        else if($submitValue == "firstsubmit"){                       
                                                                                    
                            $city = $_POST["city"];
                            $country = $_POST["country"];
                            
                            $day = $_POST["day"];
                            $month = $_POST["month"];
                            $year = $_POST["year"];
                            
                            $hour = $_POST["hour"];
                            $minute = $_POST["minute"];
                            
                            foreach ($countryinfo as $cinfo){
                                if($country != $cinfo["iso_alpha2"]){
                                    echo '<option value="'.$cinfo["iso_alpha2"].'" >'.$cinfo["name"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$cinfo["iso_alpha2"].'" selected >'.$cinfo["name"].'</option>';
                                }
                            }
                            
                            $googleAPI = new GoogleAPI();
                            $results = $googleAPI->getCities($city, $country);
                            if(count($results) == 1){                                
                                $redirectUrl = "radix.php?birthdate=".$day.".".$month.".".$year."&long=".$results[0]["longitude"]."&lat=".$results[0]["latitude"]."&time=".$hour.":".$minute;
                                ?>
                        <script type="text/javascript">
                            window.location = "<?php echo $redirectUrl; ?>";
                        </script>
                                <?php
                            }
                        }
                            else if($submitValue == "secondsubmit"){
                                $city = $_POST["city"];
                            $country = $_POST["country"];
                            
                            $day = $_POST["day"];
                            $month = $_POST["month"];
                            $year = $_POST["year"];
                            
                            $hour = $_POST["hour"];
                            $minute = $_POST["minute"];
                                $splitArray = explode("_", $city);
                                $longitude = $splitArray[0];
                                $latitude = $splitArray[1];                                  
                                $redUrl = "radix.php?birthdate=".$day.".".$month.".".$year."&long=".$longitude."&lat=".$latitude."&time=".$hour.".".$minute;
                                ?>                        
                                <script type="text/javascript">
                            window.location = "<?php echo $redUrl; ?>";
                        </script>
                        <?php
                            }
                        
                        ?>
                    </select>
                </span>
            </div>
            
            <div id="cityymain">
                <p id="cityvalidation">Please provide city.</p>
                <span>
                    <label id="lablelcity">City</label> 
                    <?php                         
                        
                        if($submitLength == 0){
                            echo '<input type="text" id="city" name="city" />';                            
                        }
                        else if($submitValue == "firstsubmit"){                                                                                                                                                                      
                            if(count($results) == 0){
                                echo '<input type="text" id="city" name="city" value="Please type valid city name" />';                            
                            }                            
                            else if(count($results) > 1){
                                echo '<select id="city" name="city">';
                                foreach ($results as $result){
                                    echo '<option value="'.$result["longitude"]."_".$result["latitude"].'">'.$result["name"].'</option>';
                                }
                                echo '</select>';
                            }
                        }                        
                    ?>                    
                </span>
            </div>
            
            <div id="postalmain">
                <p id="postalvalidation">Please provide zip code.</p>
                <span>
                    <label id="posatlcountry">Zip Code</label>
                    <?php 
                        if($submitValue == "firstsubmit"){
                            $postalCode = "";
                            if(isset($_POST["postal"])){
                                $postalCode = $_POST["postal"];
                            }
                            echo '<input type="text" id="postal" name="postal" value="'.$postalCode.'" />';
                        }
                        else{
                            echo '<input type="text" id="postal" name="postal" />';
                        }
                    ?>                    
                </span>
            </div>
            <br>
            
            <div id="birthdate">
                <p id="birthdatevalidation">Please provide day,month,year.</p>
                <span>
                    <label id="birthday">Day</label> 
                    <?php 
                        if($submitValue == "firstsubmit"){
                            echo '<input type="text" id="day" name="day" value="'.$day.'" />';
                        }
                        else{
                            echo '<input type="text" id="day" name="day" />';
                        }
                    ?>
                    
                </span><br>                
                <span>
                    <label id="birthmonth">Month</label> 
                    <select id="month" name="month">
                        <?php
                        
                        if($submitValue == "firstsubmit"){
                            $intMonthVal = intval($month);
                            
                            for ($index = 0; $index < 13; $index++) {
                                if($index != $intMonthVal){
                                    if($index == 0){
                                                    echo '<option value=""></option>';
                                                }
                                                else if($index >= 1 && $index<10){
                                                    echo '<option value="0'.$index.'" >0'.$index.'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$index.'" >'.$index.'</option>';
                                                }
                                }
                                else{
                                    if($index == 0){
                                                    echo '<option value="" selected ></option>';
                                                }
                                                else if($index >= 1 && $index<10){
                                                    echo '<option value="0'.$index.'" selected >0'.$index.'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$index.'" selected >'.$index.'</option>';
                                                }
                                }
                                                
                            }
                            
                        }
                        else{
                            for ($index = 0; $index < 13; $index++) {
                                                if($index == 0){
                                                    echo '<option value="" ></option>';
                                                }
                                                else if($index >= 1 && $index<10){
                                                    echo '<option value="0'.$index.'" >0'.$index.'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$index.'" >'.$index.'</option>';
                                                }
                                            }
                        }                                                                                                
                        ?>                        
                    </select>
                </span><br>
                <span>
                    <label id="birthyear">Year</label> 
                    <?php
                        if($submitValue == "firstsubmit"){
                            echo '<input type="text" id="year" name="year" value="'.$year.'" />';
                        }
                        else{
                            echo '<input type="text" id="year" name="year" />';
                        }
                    ?>                    
                </span>

            </div>
            <br>
            
            <div id="birthtime">
                <p id="birthtimevalidation">Please provide hour and minute.</p>
                <span>
                    <label id="birthhour">Hour</label> 
                    <select id="hour" name="hour">
                        <?php 
                        if($submitValue == "firstsubmit"){
                            $intHourhVal = intval($hour);
                            
                            for ($index = 0; $index < 25; $index++) {
                                if($index != $intHourhVal){
                                    if($index == 0){
                                                    echo '<option value=""></option>';
                                                }
                                                else if($index >= 1 && $index<10){
                                                    echo '<option value="0'.$index.'" >0'.$index.'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$index.'" >'.$index.'</option>';
                                                }
                                }
                                else{
                                    if($index == 0){
                                                    echo '<option value="" selected></option>';
                                                }
                                                else if($index >= 1 && $index<10){
                                                    echo '<option value="0'.$index.'" selected >0'.$index.'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$index.'" selected >'.$index.'</option>';
                                                }
                                }
                                                
                            }
                            
                        }
                        else{
                            for ($index = 0; $index < 25; $index++) {
                                                if($index == 0){
                                                    echo '<option value=""  ></option>';
                                                }
                                                else if($index >= 1 && $index < 10){
                                                    echo '<option value="0'.$index.'"  >0'.$index.'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$index.'"  >'.$index.'</option>';
                                                }
                                            }
                        }
                        ?>
                    </select>
                </span><br>                
                <span>
                    <label id="birthinute">Minute</label>
                    <?php
                        if($submitValue == "firstsubmit"){
                            echo '<input type="text" id="minute" name="minute" value="'.$minute.'" /> ';
                        }
                        else {
                            echo '<input type="text" id="minute" name="minute" /> ';
                        }
                    ?>                    
                </span><br>                

            </div>
            
            <?php 
                if($submitValue == "firstsubmit"){
                    echo '<input type="hidden" name="submitvalue" id="submitvalue" value="secondsubmit" />';
                }
                else{
                    echo '<input type="hidden" name="submitvalue" id="submitvalue" value="" />';
                }
            ?>            
            
            <input type="submit" id="search" name ="search" value="Generate Radix" />
             
        </form>
    </body>
</html>
