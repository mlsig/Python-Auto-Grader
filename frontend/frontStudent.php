<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="frontStudent.css">
<meta charset="utf-8"/>
    <title>
        Student
    </title>
</head>
<body onload="tryThis();">
<div class='header'>
    <h1>
        Welcome Student
    </h1>
    <h2>
        <div id="ucidHolder">
        </div>
    </h2>
    <div style="padding-right: 10px; float: right;">
        <input type="button" value="Sign Out" onclick="sign_out();">
        <br>
    </div>
    <br>
    <br>
</div>
<br><br><br><br>
<div class="centered">
<br><br>
<div id="choices" style="display: full; text-align: center">
    <form class="form-choices" id="choices" name="choices" method="post">
      <nav>
        <input type="button" value="Take Test" onclick="seeTests();"/>
        |
        <input type="button" value="See Graded Tests" onclick="chooseGraded();"/>
      </nav>
</div>
<div id="testing">
</div>
<div id="center" style="text-align: center">
<div id="tests" style="display: none">
</div>


<div id="chooseGraded" style="display: none">
</div>

<div id="gradedTest" style="display: none">
</div>

<div id="takeTest" style="display: none">
</div>


<div id="confirm" style="display: none">
You have successfully taken the test!
</div>

<div id="storeTest" style="display: none">
</div>
</div>
<div id="blah">
</div>

</div>


</body>
</html>
<script src="/~aa2296/testSubmission.js" type="text/JavaScript"></script>
<script src="/~aa2296/student.js" type="text/JavaScript"></script>