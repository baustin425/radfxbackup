var name_fields = document.getElementById('name_fields');
var type_fields = document.getElementById('type_fields');
var remove_boxes = document.getElementById('remove_boxes');
var description_fields = document.getElementById('description_fields');
var add_fields = document.getElementById('add_fields');
var remove_fields = document.getElementById('remove_fields');

add_fields.onclick = function(){

  var nameField = document.createElement('input');
  nameField.setAttribute('type','text');
  nameField.setAttribute('name','name_fields[]');
  nameField.setAttribute('class','class=u-border-1 u-border-grey-30 u-input u-input-rectangle u-white');
  nameField.setAttribute('size',20);
  nameField.setAttribute('placeholder','Name');
  name_fields.appendChild(nameField);

  var typeField = document.createElement('input');
  typeField.setAttribute('type','text');
  typeField.setAttribute('name','type_fields[]');
  typeField.setAttribute('class','class=u-border-1 u-border-grey-30 u-input u-input-rectangle u-white');
  typeField.setAttribute('size',20);
  typeField.setAttribute('placeholder','Int, Var, or Date');
  type_fields.appendChild(typeField);

  var decriptionField = document.createElement('input');
  decriptionField.setAttribute('type','text');
  decriptionField.setAttribute('name','description_fields[]');
  decriptionField.setAttribute('class','class=u-border-1 u-border-grey-30 u-input u-input-rectangle u-white');
  decriptionField.setAttribute('size',20);
  decriptionField.setAttribute('placeholder','Description');
  description_fields.appendChild(decriptionField);

  var removeBox = document.createElement('input');
  removeBox.setAttribute('type','checkbox');
  removeBox.setAttribute('name','remove_boxes[]');
  removeBox.setAttribute('value','selected');
  remove_boxes.appendChild(removeBox);
  var boxSpace1 = document.createElement('br');
  remove_boxes.appendChild(boxSpace1);
  var boxSpace2 = document.createElement('br');
  remove_boxes.appendChild(boxSpace2);
}

remove_fields.onclick = function(){
  var input_tags = name_fields.getElementsByTagName('input');
  var input_tags2 = type_fields.getElementsByTagName('input');
  var input_tags3 = remove_boxes.getElementsByTagName('input');
  var input_tags4 = description_fields.getElementsByTagName('input');
  var br_tags = remove_boxes.getElementsByTagName('br');
  for(let i = 0; i < input_tags3.length; i++) {
    if(input_tags.length > 1) {
      if(input_tags3[i].checked) {
        name_fields.removeChild(input_tags[i]);
        type_fields.removeChild(input_tags2[i]);
        description_fields.removeChild(input_tags4[i]);
        remove_boxes.removeChild(input_tags3[i]);
        remove_boxes.removeChild(br_tags[i]);
        remove_boxes.removeChild(br_tags[i]);
        i--;
      }
    }
  }
}