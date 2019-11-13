<?php
//get data from gc
//$j = $_POST['json'];

$j = '[{
    "qid": "qid0",
    "title": "returnDouble",
    "sol": "def returnDouble(num):\n\treturn num*2",
    "io": [{
        "in": "2",
        "out": "4"
    }, {
        "in": "3",
        "out": "6"
    }],
    "rubric": "10"
}, {
    "qid": "qid1",
    "title": "returnHalf",
    "sol": "def returnHalf(num):\n\treturn num*.5",
    "io": [{
        "in": "4",
        "out": "2"
    }],
    "rubric": "15"
}]';

//make data list
$data = json_decode($j);

//track what a perfct score is
$perf = 0;

//track exam score
$g = 0;

//array for the new question data
$qs = [];

foreach ($data as &$q) {

    //get info
    $qid = $q->qid;
    $t = $q->title;
    $s = $q->sol;
    $io = $q->io;
    //starting perfect, subtracting as we go
    $r = $q->rubric;
    
    //track perfect score
    $perf = $perf + $r;
    
    //array of comments
    $c = [];
    
    //check function name
    $func = strstr($s, $t);
    $pos = strpos($s, $t);
    $fun = gettype($func);
    if($fun != "string" || $pos != 4){
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
    $fi = explode(")",$s);
    $f = strlen($fi[0]) + 1;
    
    if($typ != "string" || $pos != $f){ //NEED DO
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
    $index = 0; 
    foreach ($i as &$tests){
        $in = $i["in"];
        $out = $i["out"];
        $call = "print(" . $t . "(" . $in . "))";
        $code = $s . "\n{$call}";
        $c = "echo \"{$code}\" | python -";
        $output = shell_exec($c);
        $o = trim(preg_replace('/\s+/', ' ', $output));
        if($out != $o){
            $r = $r - 10;
            if($r < 1){
                $r = 0;
            }
            array_push($c,"Minus 10 for missing for incorrect output");
        }
        $index++;
    }
    
    $g = $g + $r;
    
    //push to qs array
    $finQuestion = [
        'qid' => $qid,
        'deductions' => $c,
        'autoPoints' => $r,
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
