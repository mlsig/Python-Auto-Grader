function sign_out()
{
  var ajax=new XMLHttpRequest();
  ajax.onreadystatechange = function()
  {
    window.location.pathname = '/~aa2296/frontEnd.html';
  }
  var send="ucid= &pass= ";
  ajax.open("POST", "/~aa2296/frontPhp.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send(send);
}

function grabQuestions(filter)
{
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function()
  {
    if(ajax.readyState == 4 && ajax.status == 200)
    {
      var display = document.getElementById("questionBank");
      var response = JSON.parse(this.responseText);
      var amount = response.length;
      var toAdd = '<br><br><div style="padding-bottom: 200px;"><table id="table" style="border-spacing: 10px 10px;"><tr><td id="col1" width="200px"><b>Problem Title</b><td id="col2" width="500px"><b>Prompt</b></td><td id="col3" width="150px"><b>Difficulty</b></td><td class="col4" width="150px"><b>Topic</b></td><td></td></tr>';
      var i=0;
      for(; i<amount; i++)
      {
        toAdd += '<tr><td width="200px">'+response[i]["title"]+'</td><td align="left" width="500px">'+response[i]["prompt"]+'</td><td width="150px">'+response[i]["difficulty"]+'</td><td width="150px">'+response[i]["topic"]+'</td><td><input type="button" value="Add to Test" onclick="addToTest(\''+response[i]["qid"]+'\',\''+response[i]["title"]+'\')"</tr>';
      }
      toAdd += '</table>';
      if(i==0)
      {
        toAdd+='<p>No values in the table</p>';
      }
      toAdd+='</div>'; 
      display.innerHTML+=toAdd;
      
    }
  }
  document.getElementById("questionBank").innerHTML="";
  if(filter == "ShowAll")
  {
    ajax.open("POST", "https://web.njit.edu/~ms2437/cs490/rc/requestQuestions.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var userInfo = "command=getQuestions"; 
    ajax.send(userInfo);
  }
  else if(filter == "Easy")
  {
    ajax.open("POST", "https://web.njit.edu/~gc288/490/getQuestionsDiff.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var userInfo = "difficulty=easy"; 
    ajax.send(userInfo);
  }
  else if(filter == "Medium")
  {
    ajax.open("POST", "https://web.njit.edu/~gc288/490/getQuestionsDiff.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var userInfo = "difficulty=medium"; 
    ajax.send(userInfo);
  }
  else if(filter == "Hard")
  {
  ajax.open("POST", "https://web.njit.edu/~gc288/490/getQuestionsDiff.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var userInfo = "difficulty=hard"; 
    ajax.send(userInfo);
  }
  else if(filter == "for")
  {
    ajax.open("POST", "https://web.njit.edu/~gc288/490/getQuestionsTopic.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var userInfo = "topic=for"; 
    ajax.send(userInfo);
  }
  else if(filter == "while")
  {
    ajax.open("POST", "https://web.njit.edu/~gc288/490/getQuestionsTopic.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var userInfo = "topic=while"; 
    ajax.send(userInfo);
  }
  else if(filter == "print")
  {
  ajax.open("POST", "https://web.njit.edu/~gc288/490/getQuestionsTopic.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var userInfo = "topic=print"; 
    ajax.send(userInfo);
  }
  else
  {
    ajax.open("POST", "https://web.njit.edu/~gc288/490/getQuestionsKeyword.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var userInfo = "substring="+filter; 
    ajax.send(userInfo);
  }
}


var ucid="";

function go_back()
{
  window.location.pathname = '/~aa2296/frontInstructor.php';
}

function checkSign()
{
  grabQuestions("ShowAll");
  var ajax= new XMLHttpRequest();
  ajax.onreadystatechange = function()
  {
    if(ajax.readyState == 4 && ajax.status == 200)
    {
      document.getElementById("ucidHolder").innerHTML=this.responseText;
      ucid=document.getElementById("ucidHolder").innerHTML;
      ucid=ucid.trim();
      if(ucid=="")
      {
        window.location.href="/~aa2296/frontEnd.html";
      }
      else
      {
      }
    }
  }
  ajax.open("POST", "/~aa2296/frontPhp.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var userInfo = "";
  ajax.send(userInfo);
}

function addToTest(qid, title)
{
  var table=document.getElementById("testTable");
  var row=table.insertRow(0);
  var cell1=row.insertCell(0);
  var cell2=row.insertCell(1);
  var cell3=row.insertCell(2);
  var cell4=row.insertCell(3);
  var cell5=row.insertCell(4);
  cell1.style="display:none;";
  cell1.innerHTML=qid;
  cell2.innerHTML=title; 
  cell3.innerHTML='Point Value:';
  cell4.innerHTML='<input type="input" id="points" size="5">';
  cell5.innerHTML='<input type="button" value="Remove" onclick="removeRow(this);">';
  
}

function removeRow(rowtoD)
{
 var oRow = rowtoD.parentElement.parentElement;
 document.all("testTable").deleteRow(oRow.rowIndex);
}

function send_test()
{
  var ajax = new XMLHttpRequest();
  var table = document.getElementById("testTable");
  var len = table.rows.length;
  ajax.onreadystatechange = function()
  {
    window.location.pathname = '/~aa2296/frontInstructor.php';
     
  }
  
  var testTitle = document.getElementById("testTitle").value;
  var testQs=table.rows[0].cells[0].innerHTML;
  var testPoints = table.rows[0].cells[3].children[0].value;
  if(len>1)
  {
    for(var i=1; i<len; i++)
    {
      testPoints += ","+table.rows[i].cells[3].children[0].value;
      testQs+=","+table.rows[i].cells[0].innerHTML;
    }
  }
  if(((testTitle=="") || (testQs == "") || (testPoints == "")))
  {
    alert("Please Enter all fields");
  }
  else
  {
  
    ajax.open("POST", "https://web.njit.edu/~ms2437/cs490/rc/saveExam.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var testInfo = "title="+testTitle+"&qids="+testQs+"&points="+testPoints;

    ajax.send(testInfo); 
  }
}


