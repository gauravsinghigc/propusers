//get instant time
function GetInstantTime(DisplayAt, type = "value") {
  let now = new Date();
  let hours = now.getHours();
  let minutes = now.getMinutes();
  let seconds = now.getSeconds();

  if (hours < 10) {
    hours = "0" + hours;
  }

  if (minutes < 10) {
    minutes = "0" + minutes;
  }

  if (seconds < 10) {
    seconds = "0" + seconds;
  }

  var CurrentTime = hours + ":" + minutes + ":" + seconds;
  if (type == "value") {
    document.getElementById(DisplayAt).value = CurrentTime;
  } else {
    document.getElementById(DisplayAt).innerHTML = CurrentTime;
  }
}

//button animations
function ButtonAnimation(BtnID, AnimationText) {
  document.getElementById(BtnID).innerHTML =
    "<i class='fa fa-refresh fa-spin'></i> " + AnimationText;
  document.getElementById(BtnID).classList.remove("btn-primary");
  document.getElementById(BtnID).classList.remove("btn-info");
  document.getElementById(BtnID).classList.remove("btn-warning");
  document.getElementById(BtnID).classList.remove("btn-default");
  document.getElementById(BtnID).classList.add("btn-success");
}

//databars
function Databar(data) {
  databar = document.getElementById("" + data + "");
  if (databar.style.display === "block") {
    databar.style.display = "none";
  } else {
    databar.style.display = "block";
  }
}

//search suggestions and display selective or entered values only
function SearchData(searchinput, items_box) {
  // Get the search input
  var searchInput = document.getElementById("" + searchinput + "").value;

  // Get all content items
  var contentItems = document.getElementsByClassName("" + items_box + "");

  // Loop through all content items
  for (var i = 0; i < contentItems.length; i++) {
    // Get the current item
    var item = contentItems[i];

    // Get the text of the current item
    var itemText = item.textContent.toLowerCase();

    // Check if the search input is found in the item text
    if (itemText.includes(searchInput.toLowerCase())) {
      // If found, show the item
      item.style.display = "block";
    } else {
      // If not found, hide the item
      item.style.display = "none";
    }
  }
}

//hide msg notes
function HideMsgNote(NoteID) {
  document.getElementById(NoteID).style.display = "none";
}
