$j = '[{
        "qid":"qid0",
        "title": "helloWorld",
        "sol": "b",
        "io": ["input1;output1"],
        "rubric": [2,3]
    },{
        "qid": "qid1",
        "title": "doubleIt",
        "sol": "a",
        "io": ["input2;output2"],
        "rubric": [1,4]
    }
]';
	
    //do the grading
	$c = "python3 grade.py " . $t . " " . $s . " " . $io . " " . $rubric;
    $command = escapeshellcmd($c);
    
	echo $c;
	//$output = shell_exec($command);
	
	//parse
    //save the grade into some question object in an array*/
    
}   

/*
//set up and print final results
$creds = [
    'autoGrade' => $g,
    'qids' => $qs,
];*/


?>

