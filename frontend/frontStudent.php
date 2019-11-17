
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
    <title>
        Student
    </title>
</head>
<body onload="tryThis();">
<style>
.header
    {
  		padding: 1px;
  		text-align: center;
  		background: #cb37d0;
  		color: white;
    }
</style>
<div class='header'>
    <h1>
        Welcome Student
        <input type="button" value="Sign Out" onclick="sign_out();" style="float: right;">
    </h1>
    
</div>
<br><br>
<div id="choices" style="display: full; text-align: center">
    <form class="form-choices" id="choices" name="choices" method="post">
      <nav>
        <input type="button" value="Take Test" onclick="seeTests();"/>
        |
        <input type="button" value="See Graded Tests" onclick="chooseGraded();"/>
      </nav>
</div>
 
<div id="ucidHolder" style="display: none">
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

<div id="blah">
</div>


<div id="confirm" style="display: none">
You have successfully taken the test!
</div>

<div id="storeTest" style="display: none">
</div>
</div>
</body>
</html>
<script src="/~aa2296/testSubmission.js" type="text/JavaScript"></script>
<script src="/~aa2296/student.js" type="text/JavaScript"></script>