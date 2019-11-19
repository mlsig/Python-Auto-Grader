<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="testcreation.css">
<meta charset="utf-8"/>
    <title>
        Instructor
    </title>
</head> 
<body onload="checkSign();">
<div class='header'>
    <h1>
        This is the Test Creation Page
    </h1>
        <div id="ucidHolder" style="display: none;"></div>
    <div style="padding-right: 10px; float: right;">
        <input type="button" value="Sign Out" onclick="sign_out();">
         | 
         <input type="button" value="Go Back" onclick="go_back();">
        <br>
    </div>
    <br>
    <br>
</div>
<div class="split left">
  <div class="centered">
    <div class ="testCreation" id="testCreation" style="display: full">
      <br><form name="testForm"><label>Test Title: </label><input type="text" id="testTitle" placeholder="Enter test title"><br><br>
      <div id="tableHere "style="padding-bottom: 200px;">     
      <table id="testTable" style="border-spacing: 5px 10px;">
      </table>
      <br><br>
      <input type="button" value="Create Exam" onclick="send_test()"></form>
      </div>
    </div>
    <div id="testing"></div>
    <div id="test" style="display: none"></div>
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
    <br><br>
  </div>
</div>
</body>
</html>

<script src="/~aa2296/testCreation.js" type="text/JavaScript"></script>