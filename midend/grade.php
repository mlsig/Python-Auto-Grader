<?php
//get data from gc
$j = $_POST['json'];

/*
$j = '[{
    "qid": "qid1",
    "title": "doubleIt",
    "sol": "def doubleIt(num):\n\treturn num*2",
    "io": ["2;4"],
    "rubric": 10
}]';*/

//make data list
$data = json_decode($j);

//track what a perfct score is
$perf = 0;

//track exam score
$g = 0

//array for the new question data
$qs = [];

foreach ($data as &$q) {

    //get info
    $qid = $q->qid;
    $t = $q->title;
    //saving len of title for later
    $tLen = strlen($t);
    $s = $q->sol;
    $io = $q->io;
    //starting perfect, subtracting as we go
    $r = $q->rubric;
    
    //track perfect score
    $perf = $perf + $r;
    
    //set up io 
    $test = [];
    foreach ($io as &$dataset){
        $io_arr = explode(";", $dataset); 
        $in = $io_arr[0];
        $out = $io_arr[1];
        $test[$in] = $out;
    }
    
    //array of comments
    $c = [];
    
    //check function name
    $func = strstr($s, $t);
    $pos = strpos($s, $t);
    $fun = gettype($func);
    
    if($fun == "string"){
        if($pos == 4){
            continue;
        }
    }else{
        //find fucntion name
        $fi = explode("(",$s);
        $f = $fi[0];
        $de = "def " . $t;
        //fix their fucntion name
        $s = str_replace($f,$de,$s);
        $r = $r - 5;
        array_push($c,"Minus 5 for incorrect function name");
    }
    
    
    //check for colon
    $col = strstr($s, ":");
    $pos = strpos($s, ":");
    $typ = gettype($col);
    
    if($typ == "string"){
        //4 plus length of the name
        if($pos == 4 + $tLen){
            continue;
        }
    }else{
        //add colon at pos
        /*
        $fi = explode("(",$s);
        $f = $fi[0];
        $de = "def " . $t;
        //fix their fucntion name
        $s = str_replace($f,$de,$s);
        */
        $r = $r - 3;
        array_push($c,"Minus 3 for missing c");
    }

    //add and run each io calls
    $index = 1; 
    foreach ($test as $in => $out){
        $call = "print(" . $t . "(" . $in . "))";
        $code = $s . "\n{$call}";
        $c = "echo \"{$code}\" | python -";
        $output = shell_exec($c);
        $o = trim(preg_replace('/\s+/', ' ', $output));
        if($out != $o){
            $r = $r - 10;
            if($r < 1){
                $r = 0
            }
            array_push($c,"Minus 10 for missing for incorrect output");
        }
        $index++;
    }
    
    $g = $g + $r;
    
    //push to qs array
    $finQuestion = [
        'qid' => $qid,
        'points' => $r,
        'comments' => $c;
    ];
    
    array_push($qs,$finQuestion);
} 

//setup return json
$results = [
    'points_possible' => $perf,
    'total_grade' => $g,
    'qids' => $qs,
];

echo json_encode($results);
?>
