<?php

echo "<pre>";

// ================= PHP String and String Functions =================

// Q1
echo "Q1\n";
$str = "Twinkle, twinkle, little star.";
$arr = explode(" ", $str);
var_dump($arr);
echo "\n";

// Q2
echo "Q2\n";
$char = 'z';
$next = ($char == 'z') ? 'a' : (($char == 'Z') ? 'A' : chr(ord($char) + 1));
echo $next . "\n\n";

// Q3
echo "Q3\n";
$str = 'The brown fox';
echo substr_replace($str, 'quick ', 4, 0) . "\n\n"; // The quick brown fox

// Q3 (extra - first word of a sentence)
echo "Q3 (extra)\n";
$str = 'The quick brown fox';
$words = explode(' ', $str);
echo $words[0] . "\n\n"; // The

// Q4
echo "Q4\n";
$str = '0000657022.24';
echo str_replace('0', '', $str) . "\n\n"; // 65722.24

// Q5
echo "Q5\n";
$str = 'The quick brown fox jumps over the lazy dog---';
echo rtrim($str, '-') . "\n\n";

// Q6
echo "Q6\n";
$str = 'The quick brown fox jumps over the lazy dog';
$words = explode(' ', $str);
echo implode(' ', array_slice($words, 0, 5)) . "\n\n"; // The quick brown fox jumps

// Q7
echo "Q7\n";
$str = '2,543.12';
$num = (float) str_replace(',', '', $str);
echo $num . "\n\n"; // 2543.12


// ================= LOOP =================
echo "Loop\n\n";

// Q1
echo "Q1\n";
$n = 10;
$a = 0;
$b = 1;
$result = [];
for ($i = 0; $i < $n; $i++) {
    $result[] = $a;
    $temp = $a + $b;
    $a = $b;
    $b = $temp;
}
echo implode(', ', $result) . "\n\n";

// Q2
echo "Q2\n";
$n = 5;
$num = 1;
for ($i = 1; $i <= $n; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo $num . " ";
        $num++;
    }
    echo "\n";
}
echo "\n";

// Q3
echo "Q3\n";
$n = 5;
for ($i = 1; $i <= 2 * $n - 1; $i++) {
    $row = ($i <= $n) ? $i : 2 * $n - $i;
    echo str_repeat(" ", $n - $row);
    for ($j = 0; $j < $row; $j++) {
        echo chr(65 + $j) . " ";
    }
    echo "\n";
}
echo "\n";


// ================= Logical Statements and Operators =================
echo "Logical Statements and Operators \n\n";

// Q1
echo "Q1\n";
$year = 2013;
if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
    echo "This year is a leap year\n\n";
} else {
    echo "This year is not a leap year\n\n";
}

// Q2
echo "Q2\n";
$temp = 27;
if ($temp < 20) {
    echo "It is wintertime!\n\n";
} else {
    echo "It is summertime!\n\n";
}

// Q3
echo "Q3\n";
$firstInteger = 2;
$secondInteger = 2;
$sum = $firstInteger + $secondInteger;
if ($firstInteger == $secondInteger) {
    echo "( $firstInteger + $secondInteger ) * 3 = " . ($sum * 3) . "\n\n";
} else {
    echo "$firstInteger + $secondInteger = $sum\n\n";
}

// Q4
echo "Q4\n";
$numbers = [];
for ($i = 200; $i <= 250; $i++) {
    if ($i % 4 == 0) {
        $numbers[] = $i;
    }
}
echo implode(',', $numbers) . "\n\n";

// Q5
echo "Q5\n";
$min = 11;
$max = 20;
$numbers = range($min, $max);
shuffle($numbers);
echo implode(' ', array_slice($numbers, 0, 10)) . "\n";

echo "</pre>";
