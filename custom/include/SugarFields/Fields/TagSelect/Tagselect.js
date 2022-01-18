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
    // clear out bad data and show the error
    $("#tagInput").val("");
    showTagError();
    return;
  }

  //add tag id to hidden value
  if ($("#tags_c").val() === "") {
    $("#tags_c").val(tagID);
  } else {
    let temp = $("#tags_c").val();
    $("#tags_c").val(temp + "," + tagID);
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

  const $currentTags = $("#tags_c").val();

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

  if (tag === "") {
    tagError = true;
    document.getElementById("tagError").innerHTML = "Tag field is empty";
  }

  return tagError;
}

//removes tag from front end
function removeTag(tagID) {
  let selectedTags = $("#tags_c").val();

  if (
    selectedTags.includes("," + tagID) ||
    selectedTags.includes(tagID + ",")
  ) {
    selectedTags = selectedTags.replace("," + tagID, "");
    selectedTags = selectedTags.replace(tagID + ",", "");
  } else if (selectedTags.includes(tagID)) {
    selectedTags = selectedTags.replace(tagID, "");
  } else {
    showTagError();
  }
  $("#tags_c").val(selectedTags);

  let input = document.getElementById(tagID + "_input");
  let button = document.getElementById(tagID + "_remove");

  input.remove();
  button.remove();
}

// Shows a tag error and then hides the error message
function showTagError() {
  document.getElementById("tagError").style.display = "block";

  setTimeout(function () {
    document.getElementById("tagError").style.display = "none";
  }, 2000);
}

function capitalizeStr(str) {
  let lowerStr = str.toLowerCase();

  const arr = lowerStr.split(" ");

  for (let i = 0; i < arr.length; i++) {
    arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
  }

  const returnStr = arr.join(" ");

  return returnStr;
}

function capitalizeArr(arr) {
  for (let i = 0; i < arr.length; i++) {
    arr[i] = capitalizeStr(arr[i]);
  }

  return arr;
}
