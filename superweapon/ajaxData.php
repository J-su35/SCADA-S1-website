<?php
//Include database configuration file
include('includes/dbConfig.php');

if(isset($_POST["substation"]) && !empty($_POST["substation"])){
    //Get all state data
    // $query = $db->query("SELECT feeder FROM data WHERE substation = ".$_POST['sub']." GROUP BY feeder ORDER BY sub ASC");
    // $query = $db->query("SELECT feeder FROM data WHERE substation = ".$_POST['sub']."");
    $query = $db->query("SELECT feeder FROM data");
    // $query = $db->query("SELECT * FROM feeder WHERE substation = ".$_POST['sub']."");

    //Count total number of rows
    $rowCount = $query->num_rows;
    //Display feeder list
    if($rowCount > 0){
        echo '<option value="">Select feeder</option>';
        while($row = $query->fetch_assoc()){
            echo '<option value="'.$row['feeder'].'">'.$row['feeder'].'</option>';
        }
    }else{
        echo '<option value="">feeder not available</option>';
    }
}

// if(isset($_POST["state_id"]) && !empty($_POST["state_id"])){
//     //Get all city data
//     $query = $db->query("SELECT * FROM cities WHERE state_id = ".$_POST['state_id']." AND status = 1 ORDER BY city_name ASC");
//
//     //Count total number of rows
//     $rowCount = $query->num_rows;
//
//     //Display cities list
//     if($rowCount > 0){
//         echo '<option value="">Select city</option>';
//         while($row = $query->fetch_assoc()){
//             echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
//         }
//     }else{
//         echo '<option value="">City not available</option>';
//     }
}
?>
