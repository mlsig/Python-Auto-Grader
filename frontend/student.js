var ucid ="";

function tryThis()
{
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




function submitTest()
{
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function()
  {
    if(ajax.readyState == 4 && ajax.status == 200)
    {
      //this is where we open choices back up and say you took test
      document.getElementById("choices").style="display: full";
      document.getElementById("takeTest").style="display: none";
      document.getElementById("confirm").style="display: full";
      document.getElementById("confirm").innerHTML="Test has been submitted";
    }
  }
  var qtable=document.getElementById("questionTable");
  var tosubmit = '{"eid":"'+document.getElementById("storeTest").innerHTML+'",'
    +'"ucid":"'+ucid+'",';
  tosubmit += '"solutions":[';
  for(var i=5; i<qtable.rows.length; i+=6)
  {
    tosubmit += '{"qid":"'+qtable.rows[i].cells[0].innerHTML+'",';
    tosubmit += '"sol":"'+qtable.rows[i+1].cells[0].children[0].value+'"},';
  }
  tosubmit = tosubmit.substring(0, tosubmit.length - 1);
  tosubmit+=']}';
  var jsonSent = "codeJSON="+tosubmit;
  ajax.open("POST", "https://web.njit.edu/~gc288/490/examSubmission.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.send(jsonSent);
  
}

function takeTest(eid)
{
  var ajax = new XMLHttpRequest();
  ajax.onreadystatechange = function()
  {
    if(ajax.readyState == 4 && ajax.status == 200)
    {
      
      var display = document.getElementById("takeTest");
      var response = JSON.parse(this.responseText);
      document.getElementById("storeTest").innerHTML = response["eid"];
      toAdd='<br><br><table id="questionTable"><tr><td colspan="2"><h1>'+response["etitle"]+'</h1></td></tr>';
      
      var questions = response["qids"];
      
      for(var i=0; i<questions.length; i++)
      {
        toAdd += '<tr><td align="left" width="350px"><b><u>Question '+(i+1)+'</b></u></td></tr>';
        toAdd += '<tr><td align="left" height="50">Question Title: '+questions[i]["qtitle"]+'</td><td align="left" width="350px">Point Value: '+questions[i]["points"]+'</td></tr>';
        toAdd +='<tr><td colspan="2" align="left">Question Prompt: '+questions[i]["prompt"]+'</td></tr>';
        toAdd +='<tr><td colspan="2" height="50" align="left">Enter Your Solution Below</td></tr>';
        toAdd += '<tr style="display: none;"><td>'+questions[i]["qid"]+'</td></tr>';
        toAdd +='<tr><td colspan="2" align="left"><textarea rows="10" cols="70" placeholder="Enter solution here"></textarea></td></tr>';
      }
      toAdd += '</table>'; 
      toAdd += '<br><input type="button" value="Submit Test" onclick="submitTest();"/><br><br><br>';
      display.innerHTML+=toAdd;
      
    }
  }
  if(eid == "")
  {
    alert("Please enter a test ID to take.");
  }
  else
  {
    document.getElementById("tests").style="display: none";
    document.getElementById("choices").style="display: none";
    document.getElementById("takeTest").style="display: full";
    document.getElementById("takeTest").innerHTML="";
    ajax.open("POST", "https://web.njit.edu/~ms2437/cs490/rc/getExam.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var sendUcid="eid="+eid;
    ajax.send(sendUcid);
  }
}

function seeTests()
{
  document.getElementById("chooseGraded").style="display: none";
  document.getElementById("gradedTest").style="display: none";
  document.getElementById("confirm").style="display: none";
  document.getElementById("tests").style="display: full";
  document.getElementById("tests").innerHTML="";
  
  var newAjax = new XMLHttpRequest();
  newAjax.onreadystatechange = function()
  {
    if(newAjax.readyState == 4 && newAjax.status == 200)
    {
      var display = document.getElementById("tests");
      var response = JSON.parse(this.responseText);
      var amount = response.length;
      var toAdd = '<br><br><table style="margin-left:auto;margin-right:auto;"><tr><td width="150px"><b>Test Title(s)</b></td><td></td></tr>';
      for(var i=0; i<amount; i++)
      {
        var eidd = response[i]["eid"];
        toAdd += "</tr><tr><td width='150px'>"+response[i]["title"]+"</td><td><input type='button' value='Take Exam' onclick='takeTest(\""+eidd+"\");'></td></tr>";
      }
      toAdd += "</table>"; 
      display.innerHTML+=toAdd;
    }
  }
  newAjax.open("POST", "https://web.njit.edu/~ms2437/cs490/rc/requestExams.php", true);
  newAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var sendUcid="ucid="+ucid;
  newAjax.send(sendUcid);
}
