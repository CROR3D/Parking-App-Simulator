$(document).ready(function() {
  var result = 0;
  var prevEntry = 0;
  var operation = null;
  var currentEntry = '';

  $('.button').on('click', function(evt) {
    var buttonPressed = $(this).html();
    console.log(buttonPressed);

    if (buttonPressed === "C") {
      result = 0;
      currentEntry = '';
  } else if (isNumber(buttonPressed)) {
      currentEntry = currentEntry + buttonPressed;
    }

    currentEntry = currentEntry.toString();
    currentEntry = currentEntry.substring(0, 4);

    document.getElementById("screen").value = currentEntry;
  });
});

isNumber = function(value) {
  return !isNaN(value);
}
