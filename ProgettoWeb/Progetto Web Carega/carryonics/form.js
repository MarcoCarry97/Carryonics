

function hide()
{
  document.getElementById("musicform").style.display="none";
  document.getElementById("filmform").style.display="none";
  document.getElementById("gameform").style.display="none";
}

window.onload=function()
{
  hide();
}

function show()
{
  document.getElementById("bookform").style.display="none";
  var cat=document.getElementById("cat");
  var form="";
  hide();

  switch(cat.value)
  {
    case "books": form="bookform"; break;
    case "films": form="filmform"; break;
    case "musics": form="musicform"; break;
    case "games": form="gameform"; break;
  }
  document.getElementById(form).style.display="block";
}

/*$('input[type=file]').change(function () {
    console.log(this.files[0].mozFullPath);
});*/
