<?php
//get data from gc
$j = $_POST['json'];

/*
$j = '[{
    "qid": "qid1",
    "title": "doubleIt",
    "sol": "def doubleIt(num):\n\treturn num*2",
    "io": ["2;4"],
    "rubric": [2, 4]
}]';*/

//make data list
$data = json_decode($j);

//var to store final grade;
$g = 0;
$perf = 0;

//array for the new question data
$qs = [];

foreach ($data as &$q) {

    //get info
    $qid = $q->qid;
    $t = $q->title;
    $s = $q->sol;
    $io = $q->io;
    $r = $q->rubric;
    
    $test = [];
    foreach ($io as &$dataset){
        $io_arr = explode(";", $dataset); 
        $in = $io_arr[0];
        $out = $io_arr[1];
        $test[$in] = $out;
    }
    
    $points = [];
    foreach ($r as &$p){
        array_push($points, $p);
        $perf = $perf + $p;
    }
    
    //temporarily doing a dumb php string search / replace while i build a python parse tree to do this work
    $finalGrades = [];    
    
    //check function name
    $func = strstr($s, $t);
    $pos = strpos($s, $t);
    $fun = gettype($func);
    
    
    if($fun == "string"){
        if($pos == 4){
            $finalGrades[0] = $points[0];
        }
    }else{
        //find fucntion name
        $fi = explode("(",$s);
        $f = $fi[0];
        $de = "def " . $t;
        //fix their fucntion name
        $s = str_replace($f,$de,$s);
        $finalGrades[0] = ($points[0]/2);
    }
    $g = $g + $finalGrades[0];

    //add and run each io calls
    $index = 1; 
    foreach ($test as $in => $out){
        $call = "print(" . $t . "(" . $in . "))";
        $code = $s . "\n{$call}";
        $c = "echo \"{$code}\" | python -";
        $output = shell_exec($c);
        $o = trim(preg_replace('/\s+/', ' ', $output));
        if($out != $o){
          $finalGrades[$index] = 0;
        }
        else{
          $finalGrades[$index] = $points[$index];
        }
        $g = $g + $finalGrades[$index];
        $index++;
    }
    
    //push to qs array
    $finQuestion = [
        'qid' => $qid,
        'points' => $finalGrades,
    ];
    
    array_push($qs,$finQuestion);
} 

//setup return json
$results = [
    'points_possible' => $perf,
    'points_given' => $g,
    'qids' => $qs,
];

echo json_encode($results);
?>
