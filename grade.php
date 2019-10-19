<?php
//get data from gc
//$j = $_POST['json'];
$j = '[{
    "qid": "qid1",
    "title": "doubleIt",
    "sol": "print(2)",
    "io": ["\"none\";2 "],
    "rubric": [1, 4]
}]';

//make data list
$data = json_decode($j);

//array for the new question data
$qs = [];

//var to store final grade;
$g = 0;

foreach ($data as &$q) {

	//get info
	$qid = $q->qid;
	$t = $q->title;
	$s = $q->sol;
	$io = $q->io;
	$r = $q->rubric;
	
	$test = [];
	foreach ($io as &$dataset){
        $io_arr = explode (";", $dataset); 
        $in = $io_arr[0];
        $out = $io_arr[1];
        $test[$in] = $out;
	}
	
	$points = [];
	foreach ($r as &$p){
        array_push($points, $p);
	}
	
	//pass user's code to a file
	$userProgram = fopen("sol.py", "w");
	fwrite($userProgram, "#!/usr/bin/env python\n");
	fwrite($userProgram, $s);
    
    //setup file for execution
    $c = "chmod +x sol.py";
    $command = escapeshellcmd($c);
    $output = shell_exec($command);
    
    //check code results
	$c = "python3 sol.py";
    $command = escapeshellcmd($c);
	$output = shell_exec($command);
	echo "bruh";
    echo $output;
    
    fclose($userProgram);
}  
?>

