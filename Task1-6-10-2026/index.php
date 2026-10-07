<?php

$colors = ['white', 'green', 'red'];

echo 'Array';
echo '<br>';
echo "Q1";
echo "<ul>";
foreach ($colors as $color) {
    echo "<li> $color </li>";
}
echo "</ul>";

// ======================================================================================

echo '<br>';
echo 'Q2';
echo '<br>';

$cities = array( "Italy" => "Rome",
"Luxembourg" => "Luxembourg",
"Belgium" => "Brussels",
"Denmark" => "Copenhagen",
"Finland" => "Helsinki",
"France" => "Paris",
"Slovakia" => "Bratislava",
"Slovenia" => "Ljubljana",
"Germany" => "Berlin",
"Greece" => "Athens",
"Ireland" => "Dublin",
"Netherlands" => "Amsterdam",
"Portugal" => "Lisbon",
"Spain" => "Madrid" );

asort($cities);
$countries =  array_keys($cities);

for ($i = 0; $i < count($cities); $i++) {
    if ($i == 3) {
        break;
    }
    $country = $countries[$i];
    echo "The capital of $country is " . $cities[$country] . '<br>';
}

// ======================================================================================

echo '<br>';
echo 'Q3';
echo '<br>';

$colors = [4 => 'white' , 6 => 'green' , 11 => 'red'];
echo reset($colors);
echo '<br>';

// ======================================================================================

echo '<br>';
echo 'Q4';
echo '<br>';
$arr = [1,2,3,4,5];
$location = 4;
$newItem = '$';

array_splice($arr, $location - 1, 0, $newItem);

foreach ($arr as $item) {
    echo "$item ";
}

echo '<br>';

// ======================================================================================

echo '<br>';
echo 'Q5';
echo '<br>';

$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
asort($fruits);

foreach ($fruits as $key => $fruit) {
    echo "$key = $fruit <br>";
}
echo '<br>';

// ======================================================================================


echo '<br>';
echo 'Q6';
echo '<br>';

$temperature = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];
$sum = 0;
sort($temperature);

// $seven_lowest = slice;

foreach ($temperature as $temp) {
    $sum += $temp;
}

$avg = $sum / count($temperature);
echo 'Average Temperature is : ' . round($avg, 1) . '<br>';

$unique = array_unique($temperature);
sort($unique);

echo 'List of seven lowest temperatures : ';
foreach (array_slice($unique, 0, 7) as $t) {
    echo $t . ", ";
}

echo '<br>';

echo 'List of seven highest temperatures : ';
foreach (array_slice($unique, -7) as $t) {
    echo $t . ", ";
}

echo '<br>';

// ======================================================================================

echo '<br>';
echo 'Q7';
echo '<br>';

$array1 = array("color" => "red", 2, 4);
$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);

echo '<pre>';
print_r(array_merge($array1, $array2));
echo '</pre>';
echo '<br>';

// ======================================================================================

echo '<br>';
echo 'Q8';
echo '<br>';


$colors = array("red","blue", "white","yellow");
$upperColors = [];
foreach ($colors as $key => $value) {
    $upperColors[$key] = strtoupper($value);
}

echo '<pre>';
print_r($upperColors);
echo '</pre>';


echo '<br>';
// ======================================================================================

echo 'Function';
echo '<br>';
echo 'Q1';
echo '<br>';


function isPrime($n)
{
    if ($n < 2) {
        return false;
    }

    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) {
            return false;
        }
    }
    return true;
}

$num = 3;
echo isPrime($num) ? "$num is a prime number\n" : "$num is not a prime number\n";


echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q2';
echo '<br>';

function reverseString($str)
{
    $reversed = "";
    for ($i = strlen($str) - 1; $i >= 0; $i--) {
        $reversed .= $str[$i];
    }
    return $reversed;
}

echo reverseString("remove") . "\n";
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q3';
echo '<br>';

function swap(&$x, &$y)
{
    $temp = $x;
    $x = $y;
    $y = $temp;
}

$x = 12;
$y = 10;
swap($x, $y);
echo "y=$y x=$x\n";
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q4';
echo '<br>';

function isArmstrong($n)
{
    $sum = 0;
    $temp = $n;
    while ($temp > 0) {
        $digit = $temp % 10;
        $sum += $digit ** 3;
        $temp = intdiv($temp, 10);
    }
    return $sum == $n;
}

$num = 407;
echo isArmstrong($num) ? "$num is Armstrong Number\n" : "$num is not Armstrong Number\n";
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q5';
echo '<br>';

function isPalindrome($str)
{
    $clean = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $str));
    return $clean == strrev($clean);
}

$text = "Eva, can I see bees in a cave?";
echo isPalindrome($text) ? "Yes it is a palindrome\n" : "No it is not a palindrome\n";
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q6';
echo '<br>';

function removeDuplicates($arr)
{
    $result = [];
    foreach ($arr as $value) {
        if (!in_array($value, $result)) {
            $result[] = $value;
        }
    }
    return $result;
}

$array1 = array(2, 4, 7, 4, 8, 4);
print_r(removeDuplicates($array1));
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Logical Statements and Operators';
echo '<br>';
echo 'Q1';
echo '<br>';

function sumIs30($a, $b)
{
    $sum = $a + $b;
    if ($sum == 30) {
        return $sum;
    } else {
        return false;
    }
}

var_export(sumIs30(10, 10));
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q2';
echo '<br>';

function isMultipleOf3($n)
{
    return $n % 3 == 0;
}

var_export(isMultipleOf3(20));
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q3';
echo '<br>';

function inRange($n)
{
    return $n >= 20 && $n <= 50;
}

var_export(inRange(50));
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q4';
echo '<br>';

function largest($a, $b, $c)
{
    if ($a >= $b && $a >= $c) {
        return $a;
    } elseif ($b >= $a && $b >= $c) {
        return $b;
    } else {
        return $c;
    }
}

echo largest(1, 5, 9);
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q5';
echo '<br>';

function electricityBill($units)
{
    if ($units <= 50) {
        $bill = $units * 2.50;
    } elseif ($units <= 150) {
        $bill = 50 * 2.50 + ($units - 50) * 5.00;
    } elseif ($units <= 250) {
        $bill = 50 * 2.50 + 100 * 5.00 + ($units - 150) * 6.20;
    } else {
        $bill = 50 * 2.50 + 100 * 5.00 + 100 * 6.20 + ($units - 250) * 7.50;
    }
    return $bill;
}

$units = 300;
echo "Bill for $units units = " . electricityBill($units) . " JOD";
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q6';
echo '<br>';

function calculator($a, $b, $op)
{
    switch ($op) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            if ($b == 0) {
                return "Cannot divide by zero";
            }
            return $a / $b;
        default:
            return "Invalid operator";
    }
}

echo "10 + 5 = " . calculator(10, 5, '+') . '<br>';
echo "10 - 5 = " . calculator(10, 5, '-') . '<br>';
echo "10 * 5 = " . calculator(10, 5, '*') . '<br>';
echo "10 / 5 = " . calculator(10, 5, '/') . '<br>';
// ======================================================================================

echo '<br>';
echo 'Q7';
echo '<br>';

function canVote($age)
{
    if ($age >= 18) {
        return "is eligible to vote";
    } else {
        return "is not eligible to vote";
    }
}

echo canVote(15);
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q8';
echo '<br>';

function checkSign($n)
{
    if ($n > 0) {
        return "Positive";
    } elseif ($n < 0) {
        return "Negative";
    } else {
        return "Zero";
    }
}

echo checkSign(-60);
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q9';
echo '<br>';

function getGrade($scores)
{
    $avg = array_sum($scores) / count($scores);

    if ($avg < 60) {
        return "F";
    } elseif ($avg < 70) {
        return "D";
    } elseif ($avg < 80) {
        return "C";
    } elseif ($avg < 90) {
        return "B";
    } else {
        return "A";
    }
}

$scores = [60, 86, 95, 63, 55, 74, 79, 62, 50];
echo getGrade($scores);
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Loops';
echo '<br>';
echo 'Q1';
echo '<br>';

for ($i = 1; $i <= 10; $i++) {
    echo $i;
    if ($i < 10) {
        echo '-';
    }
}
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q2';
echo '<br>';

$total = 0;
for ($i = 0; $i <= 30; $i++) {
    $total += $i;
}
echo $total;
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q3';
echo '<br>';

for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {
        if ($j <= 5 - $i) {
            echo 'A ';
        } else {
            echo chr(64 + $i) . ' ';
        }
    }
    echo '<br>';
}
// ======================================================================================

echo '<br>';
echo 'Q4';
echo '<br>';

for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {
        if ($j <= 5 - $i) {
            echo '1 ';
        } else {
            echo $i . ' ';
        }
    }
    echo '<br>';
}
// ======================================================================================

echo '<br>';
echo 'Q5';
echo '<br>';

for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {
        if ($i == $j) {
            echo $i . ' ';
        } else {
            echo '0 ';
        }
    }
    echo '<br>';
}
// ======================================================================================

echo '<br>';
echo 'Q6';
echo '<br>';

function factorial($n)
{
    $result = 1;
    for ($i = 1; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

echo factorial(5);
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q7';
echo '<br>';

echo '<table border="1" cellpadding="3px" cellspacing="0px">';
for ($row = 1; $row <= 6; $row++) {
    echo '<tr>';
    for ($col = 1; $col <= 5; $col++) {
        echo '<td>' . "$row * $col = " . ($row * $col) . '</td>';
    }
    echo '</tr>';
}
echo '</table>';
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'PHP String and String Functions';
echo '<br>';
echo 'Q1';
echo '<br>';

$str = "the quick brown fox";

echo strtoupper($str) . '<br>';   // a
echo strtolower($str) . '<br>';   // b
echo ucfirst($str) . '<br>';      // c
echo ucwords($str) . '<br>';      // d
// ======================================================================================

echo '<br>';
echo 'Q2';
echo '<br>';

$time = '085119';
echo implode(':', str_split($time, 2));
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q3';
echo '<br>';

$sentence = 'I am a full stack developer at orange coding academy';
$word = 'Orange';

if (stripos($sentence, $word) !== false) {
    echo 'Word Found!';
} else {
    echo 'Word Not Found!';
}
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q4';
echo '<br>';

$url = 'www.orange.com/index.php';
echo basename($url);
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q5';
echo '<br>';

$email = 'info@orange.com';
echo strstr($email, '@', true);
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q6';
echo '<br>';

echo substr($email, -3);
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q7';
echo '<br>';

$chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
$password = substr(str_shuffle($chars), 0, 8);
echo $password;
echo '<br>';
// ======================================================================================

echo '<br>';
echo 'Q8';
echo '<br>';

$sentence = 'That new trainee is so genius.';
$newWord = 'Our';

$words = explode(' ', $sentence);
$words[0] = $newWord;
echo implode(' ', $words);
echo '<br>';
// ======================================================================================
