window.onload=function()
{
  hideAttributes();
  document.getElementById("products").style.display="block";
}

function hideAttributes()
{
  document.getElementById("books").style.display="none";
  document.getElementById("films").style.display="none";
  document.getElementById("games").style.display="none";
  document.getElementById("products").style.display="none";
}

function showAttributes()
{
  hideAttributes();
  var select=document.getElementById("cat").value;
  document.getElementById(select).style.display="block";
}
