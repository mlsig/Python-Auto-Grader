function submitThis()
{
  var ajax= new XMLHttpRequest();
  ajax.onreadystatechange = function()
  {
    if(ajax.readyState == 4 && ajax.status == 200)
    {
      document.getElementById("test").innerHTML=this.responseText;
    }
  }
  ajax.open("POST", "/~aa2296/submitTest.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var userInfo = "exID=23&sID=gc288";
  ajax.send(userInfo);
}

var ucid="";

function doThis()
{
  ucid=document.getElementById("ucidHolder").innerHTML;
  ucid=ucid.trim();
}

function chooseGraded()
{
  doThis();
  document.getElementById("confirm").style="display: none";
  document.getElementById("tests").style="display: none";
  document.getElementById("gradedTest").style="display: none";
  document.getElementById("chooseGraded").style="display: full";
  var ajax=new XMLHttpRequest();
  ajax.onreadystatechange = function()
  {
    if(ajax.readyState==4 && ajax.status==200)
    {
      var display = document.getElementById("chooseGraded");
      display.innerHTML="";
      //display.innerHTML=this.responseText;
      
      var response = JSON.parse(this.responseText);
      var amount = response.length;
      var toAdd = '<br><br><table style="margin-left:auto;margin-right:auto;"><tr><td width="150px"><b>Test Title(s)</b></td><td></td></tr>';
      for(var i=0; i<amount; i++)
      {
        toAdd += '</tr><tr><td width="150px">'+response[i]["etitle"]+'</td><td><input type="button" value="See Graded Exam" onclick="seeGraded(\''+response[i]["eid"]+'\');"></td></tr>';
      }
      toAdd += '</table>'; 
      display.innerHTML+=toAdd;
      
    }
  
  }
  ajax.open("POST", "https://web.njit.edu/~ms2437/cs490/rc/readyExams.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var sendUcid="ucid="+ucid;
  ajax.send(sendUcid);
}


function seeGraded(eid)
{
  document.getElementById("chooseGraded").style="display: none";
  document.getElementById("gradedTest").style="display: full";
  var ajax=new XMLHttpRequest();
  ajax.onreadystatechange = function()
  {
    if(ajax.readyState == 4 && ajax.status == 200)
    {
      
      var display = document.getElementById("gradedTest");
      display.innerHTML="";
      var response = JSON.parse(this.responseText);
      var toAdd = '<br><table id="testT style="border-spacing: 10px 10px;"">'; 
      toAdd += '<tr><td width="150px">Test Title</td><td width="50px">Test Grade</td></tr>';
      toAdd += '<tr><td width="150px"><b>'+response["etitle"]+'</b></td><td width="50px"><b>'+response["finalGrade"]+'</b></tr>';

      var questions = response["questions"];
        
      for(var j=0; j<questions.length; j++) 
      {
        toAdd+='<tr height="10px"></tr>';
        toAdd += '<tr><td width="50px">Question Title:</td><td width="150px">'+questions[j]["qtitle"]+'</td></tr>';
        toAdd +='<tr><td height="50px" width="50px">Question Prompt:</td><td width="150px">'+questions[j]["prompt"]+'</td></tr>';
        toAdd +='<tr><td width="50px">Questions Grade:</td><td>'+questions[j]["points"]+'</td></tr>';
        toAdd += '<tr height="20px"></tr>';
        toAdd +='<tr><td colspan="2"><u>Your solution</u></td></tr>';
        toAdd +='<tr><td colspan="2" style="white-space: pre-wrap">'+questions[j]["sol"]+'</td></tr>';
        toAdd+= '<tr height="20px"></tr>';
        toAdd +='<tr><td colspan="2" >Comments(if any): </td></tr>';
        toAdd +='<tr><td colspan="2" style="white-space: pre-wrap">'+questions[j]["comment"]+'</td></tr><tr height="20"></tr>';
      }
      toAdd+= '<tr></tr><tr></tr>';
      toAdd += '</table>'; 
        display.innerHTML+=toAdd;
      
    }
  }
  ajax.open("POST", "https://web.njit.edu/~ms2437/cs490/rc/getExamGraded.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var sendUcid="ucid="+ucid+"&eid="+eid;
  ajax.send(sendUcid);
}

