<?php

use App\Models\Category;
use App\Models\Stocktaking;
use App\Models\Delivery;


function getOpenedStocktakingID($user){
    $stocktaking = Stocktaking::where('user_id',$user->id)->where('completed',false)->first();
    if($stocktaking == null){
        return null;
    } else {
        return $stocktaking->id;
    }
}

function getOpenedDeliveryID($user){
    $delivery = Delivery::where('user_id',$user->id)->where('completed',false)->first();
    if($delivery == null){
        return null;
    } else {
        return $delivery->id;
    }
}


function excelResponse(){
    return 'HELPEEEER';
}

function formatTimeOnly($timestamp) {
    $date = new DateTime($timestamp);
    $hours = $date->format('H');  // Get the hour in 24-hour format as a two-digit number
    $minutes = $date->format('i');  // Get the minutes as a two-digit number
    return "$hours:$minutes";
}


function formatDateOnly($timestamp) {
    $date = new DateTime($timestamp);
    $day = $date->format('d');  // Get the day as a two-digit number
    $month = $date->format('m');  // Get the month as a two-digit number
    $year = $date->format('Y');  // Get the four-digit year
    return "$day.$month.$year";
}

function formatDate($date){
    $date_array = explode("-", $date);
    $formatted_date = $date_array[2] . "." . $date_array[1] . "." . $date_array[0];
    return $formatted_date;
}

function formatTime($time){
    return substr($time, 0, -3);
}

function getDayName($date){
    $nameOfDay = date('D', strtotime($date));

    if($nameOfDay == "Mon"){
        return "Ponedeljek";
    }

    if($nameOfDay == "Tue"){
        return "Torek";
    }

    if($nameOfDay == "Wed"){
        return "Sreda";
    }

    if($nameOfDay == "Thu"){
        return "Cetrtek";
    }

    if($nameOfDay == "Fri"){
        return "Petek";
    }

    if($nameOfDay == "Sat"){
        return "Sobota";
    }

    if($nameOfDay == "Sun"){
        return "Nedelja";
    }
}

function getCategoryName($category_id){
    $category = Category::find($category_id);
    return $category->categoryName;
}

function timestampToDate($timestamp){
    $date = new DateTime($timestamp);
    return $date->format('j.n.Y');
}

function timestampToTime($timestamp){
    $time = new DateTime($timestamp);
    return $time->format('H:i'); // This will return the time in the format '17:30'
}
