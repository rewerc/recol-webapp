<?php
$error = false;

if (isset($_POST['submit'])) {
    if (isset($_POST['m1']) && isset($_POST['m2'])) {

        $matrix1 = $_POST['m1'];
        $matrix2 = $_POST['m2'];
        
        $matrix1 = explode("\n", $matrix1);
        $matrix2 = explode("\n", $matrix2);

        for ($i = 0; $i < count($matrix1); $i++) {
            $matrix1[$i] = explode(" ", $matrix1[$i]);
        }

        for ($i = 0; $i < count($matrix2); $i++) {
            $matrix2[$i] = explode(" ", $matrix2[$i]);
        }

        $x1 = count($matrix1[0]);
        $x2 = count($matrix2[0]);
        $y1 = count($matrix1);
        $y2 = count($matrix2);
        
        if ($x1 !== $y2) $error = true;
        if ($x1 !== $y2) $error = true;
        
        $result = array();
        
        for ($w = 0; $w < $y1; $w++) {
            $temparr = array();
            for ($i = 0; $i < $x2; $i++) {
                $temp = 0;
                for ($j = 0; $j < $x1; $j++) {
                    $temp += $matrix1[$w][$j] * $matrix2[$j][$i];
                }
                $temparr[] = $temp;
            }
            $result[] = $temparr;
        }

    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrix Multiplication</title>
</head>

<body>
    <form action="" method="post">
        <div style="display: inline-block">
            Matrix 1
            <br>
            <textarea name="m1" cols="30" rows="10"></textarea>
        </div>
        <div style="display: inline-block">
            Matrix 2
            <br>
            <textarea name="m2" cols="30" rows="10"></textarea>
        </div>
        <button type="submit" name="submit">Calculate</button>
    </form>

    <h4>Result: </h4>
    <p>
        <?php 
        if (isset($result)) {
            for ($j = 0; $j < count($result[0]); $j++) {
                for ($i = 0; $i < count($result); $i++) {
                    echo "<div style='display: inline-block; text-align: center; width:30px; margin-bottom: 5px;'>" . $result[$j][$i] . "</div>";
                }
                echo "<br>";
            }
        }
        ?>
    </p>
</body>

</html>