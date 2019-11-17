function add_Question()
{
  var ajaxResponse = new XMLHttpRequest();
  ajaxResponse.onreadystatechange = function()
  {
    if(ajaxResponse.readyState == 4 && ajaxResponse.status == 200)
    {
      var creds=JSON.parse(this.responseText);
      
      document.getElementById("test").innerHTML="Your question has been added";
    }
  }
  var title = document.getElementById("title").value;
  var prompt = document.getElementById("prompt").value;
  var difficulty = document.getElementById("difficulty").value;
  var topic = document.getElementById("topic").value;
  var sample = document.getElementById("sample").value;
  if(title=="" || prompt=="" || difficulty=="" || topic=="" || sample=="")
  {
    alert("You must enter all values");
  }
  else
  {
    document.getElementById("newQuestion").style="display: none";
    var userInfo = "title="+title+"&prompt="+prompt+"&difficulty="+difficulty+"&topic="+topic+"&sampleIO="+sample;
    ajaxResponse.open("POST", "https://web.njit.edu/~aa2296/question.php", true);
    ajaxResponse.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var questionInfo = "title="+title+"&prompt="+prompt+"&difficulty="+difficulty+"&topic="+topic+"&sample="+sample;
    ajaxResponse.send(questionInfo);
  }
}