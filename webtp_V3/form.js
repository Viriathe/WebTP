function changeForm(){
  var fieldOne = document.getElementsById('field-one');
  var fieldTwo = document.getElementById('field-two');
  var selected = document.getElementById('select');
  if (selected.value == "1") {
    fieldOne.style.display = none;
    fieldTwo.style.display = flex;
  }

}

changeForm();
