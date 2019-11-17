function checkInfo(form)
{
  var ajax=new XMLHttpRequest();
  var ucid;
  ajax.onreadystatechange = function()
  {
    document.getElementById("confirmhere").innerHTML = "Please wait while we check your credentials...";
    if(ajax.readyState == 4 && ajax.status == 200)
    {
      var creds=JSON.parse(this.responseText);
      creds = creds.level;
      if((creds)=="i")
      {
          window.location.pathname = '/~aa2296/frontInstructor.php';
      }
      else if ((creds)=="s")
      {
          window.location.pathname = '/~aa2296/frontStudent.php';
      }
      else if ((creds)=="n")
      {
          alert("You are not a valid student or instructor");
          document.location.reload(true); 
      }  
    }
  }
  
  //const userForm = document.getElementById("userform");
  ucid = form.ucid.value;
  var pass = form.pass.value;
  if(ucid == "" || pass == "")
  {
  alert("Make sure enter values for both");
  document.location.reload(true)
  }
  else
  {
  ajax.open("POST", "/~aa2296/frontPhp.php", true);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var userInfo = "ucid="+form.ucid.value+"&pass="+form.pass.value;
  //document.getElementById("confirmhere").innerHTML = userInfo; 
  ajax.send(userInfo);
         
  }
}
function test(ucid)
{
  var form = document.createElement("ucidSend");
          document.body.appendChild(form);
          form.method='post';
          form.action = '/~aa2296/frontStudent.php';
          var input = document.createElement('input');
          input.type='hidden';
          input.name = 'ucid';
          input.value = ucid;
          form.appendChild(input);
          form.submit();
}
