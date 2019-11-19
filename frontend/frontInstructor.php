<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="frontInstructor.css">
<meta charset="utf-8"/>
    <title>
        Instructor
    </title>
</head> 
<body onload="checkSign();">
<div class='header'>
    <h1>
        Welcome Instructor
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
<br>
<div class="split left">
  <div class="instructorChoice">
        <form class="form-choices" id="choices" name="choices" method="post">
            <input type="button" value="Add New Question" onclick="add_Question_form();"/>
            |
            <input type="button" value="Create Test" onclick="create_test();"/>
            |
            <input type="button" value="View Test Submissions" onclick="checkTests();"/>
            
    </div>
  <div class="centered">
    <br>
    <div class ="newQuestion" id="newQuestion" style="display: none;">
     <br>
     <label>Question Title</label><br>
      <input type="text" id="title" placeholder="Please enter a title here"><br>
      <br>
      <label>Prompt</label><br>
      <textarea name="prompt" id="prompt" rows="5" cols="20" placeholder="Please enter the prompt here"></textarea><br>
      <br>
      <label>Topic</label><br>
      <select id="topic">
      <option value="for">For</option>
      <option value="while">While</option>
      <option value="print">Print</option>
      </select><br>
      <br>
      <label>Difficulty</label><br>
      <select id="difficulty">
      <option value="easy">Easy</option>
      <option value="medium">Medium</option>
      <option value="hard">Hard</option>
      </select>
      <br>
      <br>
      <table style="border-spacing: 20px 20px;">
      <tr><td valign="top">Input 1</td><td><input type="text" name="in1" id="in1" size="8" placeholder="input1"></td>
        <td valign="top">Output 1</td><td><input type="text" name="out1" id="out1" size="8" placeholder="output1"></td></tr>
      <tr><td valign="top">Input 2</td><td><input type="text" name="in2" id="in2" size="8" placeholder="input2"></td>
        <td valign="top">Output 2</td><td><input type="text" name="out2" id="out2" size="8" placeholder="output2"></td></tr>
      <tr><td valign="top">Input 3</td><td><input type="text" name="in3" id="in3" size="8" placeholder="input3"></td>
        <td valign="top">Output 3</td><td><input type="text" name="out3" id="out3" size="8" placeholder="output3"></td></tr>
      <tr id="IO4" style="display: none;"><td valign="top">Input 4</td><td><input type="text" name="in4" id="in4" size="8" placeholder="input4"></td>
        <td valign="top">Output 4</td><td><input type="text" name="out4" id="out4" size="8" placeholder="output4"></td></tr>
      <tr id="IO5" style="display: none;"><td valign="top">Input 5</td><td><input type="text" name="in5" id="in5" size="8" placeholder="input5"></td>
        <td valign="top">Output 5</td><td><input type="text" name="out5" id="out5" size="8" placeholder="output5"></td>
      <tr id="IO6" style="display: none;"><td valign="top">Input 6</td><td><input type="text" name="in6" id="in6" size="8" placeholder="input6"></td>
      <td valign="top">Output 6</td><td><input type="text" name="out6" id="out6" size="8" placeholder="output6"></td>
      </table>
      <div id="IO3b" style="display: full;">
      <input type="button" value="Add another I/O" onclick="addIO4()"/>
      </div>
      <div id="IO4b" style="display: none;">
      <input type="button" value="Add another I/O" onclick="addIO5()"/>
      </div>
      <div id="IO5b" style="display: none;">
      <input type="button" value="Add another I/O" onclick="addIO6()"/>
      </div>
      <br>
      <div id="invalid">
      </div>
      
      <input type="button" id="submitB" value="Submit Question" onclick="add_Question()">
      <br><br>
    </div>
    <div class ="testCreation" id="testCreation" style="display: none">
      <br><form name="testForm"><label>Test Title: </label><input type="text" id="testTitle" placeholder="Enter test title"><br>
      <label>QuestionIDs: </label><input type="text" id="questionIDs" placeholder="qID1,qID2,..."><br>
      <label>Point Values: </label><input type="text" id="points" placeholder="part1,par2;part1,part2">
      <br><br>
      <input type="button" value="Create Exam" onclick="send_test()"></form>
      </div>
    <div class="lookTests" id="lookTests" style="display: none">
    </div>
      
    <div class="finalGrade" id="finalGrade" style="display: none">
    </div>
    <div id="storeTest" style="display: none">
    </div>
    <div id="ucidToGrade" style="display: none">
    </div>
    <div id="test" style="display: none"></div>
    <div id="testing"></div>
    <div id="sampletest"></div>
  </div>
</div>
<div class = "split right">
  <div class= "centered">
    <div class="filtering" id="filtering">
    <label>Filter By:</label>
    <select id="filterChoice">
    <optgroup label="Difficulty">
      <option value="Easy">Easy</option>
      <option value="Medium">Medium</option>
      <option value="Hard">Hard</option></optgroup>
    <optgroup label="Topic">
      <option value="for">For</option>
      <option value="while">While</option>
      <option value="print">Print</option></optgroup>
    <option value="ShowAll">Show All</option>
    </select>
    <input type="button" value="Filter" onclick="grabQuestions(filterChoice.value);">
    <br><br>
    <label>Filter By Keyword</label>
    <input type="text" id="keyww" placeholder="Enter Keyword here">
    <input type="button" value="Filter" onclick="grabQuestions(keyww.value);">
    </div>
    
    <div id="filterDif" style="display: none">
    
    </div>
    <div id="filterTop" style="display: none">
    </div>
    
    <div class ="questionBank" id="questionBank">
    </div>
  </div>
</div>
</body>
</html>

<script src="/~aa2296/frontInstructor.js" type="text/JavaScript"></script>