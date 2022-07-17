<?php 

// $con = mysqli_connect("localhost", "id17543566_ssip2021", "Ssip2021001", "id17543566_ssip");
$con = mysqli_connect("localhost", "root", "", "recol");
if (mysqli_connect_errno()) {
    echo "Error: " . mysqli_connect_error();
    exit();
}

function retrieve($query) {
    global $con;
    $res = mysqli_query($con, $query);
    if (!$res) echo ("Error: " . mysqli_error($con));

    $items = [];
    while ($item = mysqli_fetch_assoc($res)) {
        $items[] = $item;
    }

    return $items;
}

function query($query) {
    global $con;
    $res = mysqli_query($con, $query);
    if (!$res) echo("Error: " . mysqli_error($con));
}

function popularVal($likes, $clicks, $post, $totalLikes, $totalViews, $views) {
    $value = array(
        array($likes, $totalLikes, $post),
        array($views, $totalViews, $clicks)
    );

    $maskValue = array(
        array(3),
        array(2),
        array(0.1)
    );

    $x1 = count($value[0]);
    $x2 = count($maskValue[0]);
    $y1 = count($value);
    $y2 = count($maskValue);
    $result = array();
        
    for ($w = 0; $w < $y1; $w++) {
        $temparr = array();
        for ($i = 0; $i < $x2; $i++) {
            $temp = 0;
            for ($j = 0; $j < $x1; $j++) {
                $temp += $value[$w][$j] * $maskValue[$j][$i];
            }
            $temparr[] = $temp;
        }
        $result[] = $temparr;
    }
    
    $sum = 0;
    for ($i = 0; $i < count($result); $i++) {
        for ($j = 0; $j < count($result[0]); $j++) {
            $sum += $result[$i][$j];
        }
    }
    return $sum;
}

function bubble_sort($arr) {
    $len = count($arr)-1;
    for ($i = 0; $i < $len; $i++) {
        for ($j = 0; $j < $len - $i; $j++) {
            $k = $j + 1;
            if ($arr[$k]["popularity"] > $arr[$j]["popularity"]) {
                $temp = $arr[$k];
                $arr[$k] = $arr[$j];
                $arr[$j] = $temp;
            }
        }
    }
    return $arr;
}