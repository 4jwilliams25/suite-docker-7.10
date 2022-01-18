function addTag() {
  //Pulls values from html
  let tagNames = JSON.parse($("#tagNames").val().toLowerCase());
  let tagIds = JSON.parse($("#tagIds").val());
  let tag = $("#tagInput").val().toLowerCase();

  //get tagID from value index
  let tagIndex = tagNames.indexOf(tag);
  let tagID = tagIds[tagIndex];

  //tag verification
  if (verifyTag(tag, tagNames, tagID)) {
    //clear out bad data
    $("#tagInput").val("");

    showTagError();

    return;
  }

  //add tag id to hidden value
  if ($("#mcccd_tags").val() === "") {
    $("#mcccd_tags").val(tag);
  } else {
    let temp = $("#mcccd_tags").val();
    $("#mcccd_tags").val(temp + "," + tag);
  }

  //creates new input and adds it to the HTML
  let existingDiv = document.getElementById("tagDiv");
  let newInput = document.createElement("div");
  newInput.id = "tag_" + tagID;
  newInput.innerHTML =
    "<input type='text' id='" +
    tagID +
    "_input' value='" +
    capitalizeStr(tag) +
    "' disabled> " +
    "<button id='" +
    tagID +
    "_remove'type='button'class='btn btn-danger' onclick='removeTag(" +
    '"' +
    tagID +
    '"' +
    ")' title='Remove Tag'>" +
    " <span class='suitepicon suitepicon-action-minus'></span></button>";
  existingDiv.appendChild(newInput);

  //blanks out the tag input field
  $("#tagInput").val("");
  $("#tagInput").focus();
}

//Controlls auto complete functionality
function doAutoComplete(fieldOptions) {
  const upperCaseTags = capitalizeArr(fieldOptions);
  $("#tagInput").autocomplete({
    source: upperCaseTags,
    appendTo: "#tagDiv",
  });
}

//Checks to make sure the tag the user inputs is in the accepted list
function verifyTag(tag, tagList, tagID) {
  let tagError = false;
  const $currentTags = $("#mcccd_tags").val();

  //searches for duplicate
  if ($currentTags.search(tagID) != -1) {
    tagError = true;
    document.getElementById("tagError").innerHTML =
      "That tag has already been added";
  }

  if (!tagList.includes(tag)) {
    tagError = true;
    document.getElementById("tagError").innerHTML = "Invalid Tag";
  }

  /*Will make it so users can only add 1 tag at a time
    If we ever figure out how to format the search string 
    properly we could remove this
    */
  if ($("#mcccd_tags").val() !== "") {
    tagError = true;
    document.getElementById("tagError").innerHTML =
      "We currently can only search by one tag at a time";
  }

  if (tag === "") {
    tagError = true;
    document.getElementById("tagError").innerHTML = "Tag field is empty";
  }

  return tagError;
}

//removes tag from front end
function removeTag(tagID) {
  let selectedTags = $("#mcccd_tags").val();
  let tagIds = JSON.parse($("#tagIds").val());
  let tagNames = JSON.parse($("#tagNames").val());
  let tagIndex = tagIds.indexOf(tagID);
  let tagName = tagNames[tagIndex].toLowerCase();

  if (
    selectedTags.includes("," + tagName) ||
    selectedTags.includes(tagName + ",")
  ) {
    selectedTags = selectedTags.replace("," + tagName, "");
    selectedTags = selectedTags.replace(tagName + ",", "");
  } else if (selectedTags.includes(tagName)) {
    selectedTags = selectedTags.replace(tagName, "");
  } else {
    showTagError();
  }
  $("#mcccd_tags").val(selectedTags);

  let input = document.getElementById(tagID + "_input");
  let button = document.getElementById(tagID + "_remove");

  input.remove();
  button.remove();
}

//Shows a tag error and then hides the error message
function showTagError() {
  document.getElementById("tagError").style.display = "block";

  setTimeout(function () {
    document.getElementById("tagError").style.display = "none";
  }, 2000);
}

function capitalizeStr(str) {
  let lowerStr = str.toLowerCase();

  const arr = lowerStr.split(" ");

  for (var i = 0; i < arr.length; i++) {
    arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
  }

  const returnStr = arr.join(" ");

  return returnStr;
}

function capitalizeArr(arr) {
  for (i = 0; i < arr.length; i++) {
    arr[i] = capitalizeStr(arr[i]);
  }

  return arr;
}
