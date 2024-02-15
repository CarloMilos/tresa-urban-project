<?php
include 'dbcon.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRESA Resident Input Form</title>

    <style>
.autocomplete-container {
  margin-bottom: 20px;
}

.input-container {
  display: flex;
  position: relative;
  width: 500px;
}

.input-container input {
  flex: 1;
  outline: none;
  
  border: 1px solid rgba(0, 0, 0, 0.2);
  padding: 10px;
  padding-right: 31px;
  font-size: 16px;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid rgba(0, 0, 0, 0.1);
  box-shadow: 0px 2px 10px 2px rgba(0, 0, 0, 0.1);
  border-top: none;
  background-color: #fff;

  z-index: 99;
  top: calc(100% + 2px);
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
}

.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: rgba(0, 0, 0, 0.1);
}

.autocomplete-items .autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: rgba(0, 0, 0, 0.1);
}

.clear-button {
  color: rgba(0, 0, 0, 0.4);
  cursor: pointer;
  
  position: absolute;
  right: 5px;
  top: 0;

  height: 100%;
  display: none;
  align-items: center;
}

.clear-button.visible {
  display: flex;
}

.clear-button:hover {
  color: rgba(0, 0, 0, 0.6);
}

    .tags-input { 
        display: inline-block; 
        position: relative; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
        padding: 5px; 
        box-shadow: 2px 2px 5px #00000033; 
        width: 400px; 
    } 

    .tags-input ul { 
        list-style: none; 
        padding: 0; 
        margin: 0; 
    } 

    .tags-input li { 
        display: inline-block; 
        background-color: #f2f2f2; 
        color: #333; 
        border-radius: 20px; 
        padding: 5px 10px; 
        margin-right: 5px; 
        margin-bottom: 5px; 
    } 

    .tags-input input[type="text"] { 
        border: none; 
        outline: none; 
        padding: 5px; 
        font-size: 14px; 
    } 

    .tags-input input[type="text"]:focus { 
        outline: none; 
    } 

    .tags-input .delete-button { 
        background-color: transparent; 
        border: none; 
        color: #999; 
        cursor: pointer; 
        margin-left: 5px; 
    } 
    </style>
</head>
<body>

    <h1> By Completing this form you are authorising this form data to be added to the TRESA Urban Nature Reserve Map Database </h1>
    <h3> If you would like to opt out of having your data added to the map, tick the final box!</h3>

    <form action="#" method="POST" enctype="multipart/form-data">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
        </div>
        <div>
            <label for="address">Address of Nature Reserve:</label>
            <div class="autocomplete-container" id="autocomplete-container">
            </div>
        </div>
        <div>
            <label for="dimensions">Dimensions:</label>
            <input type="number" id="dimensions" name="dimensions" required>
            <select name="unit">
                <option value="cm2">cm<sup>2</sup></option>
                <option value="m2">m<sup>2</sup></option>
            </select>
        </div>
        <div>
            <label for="garden-description">Garden Description:</label><br>
            <textarea id="garden-description" name="garden-description" rows="4" cols="50" required></textarea>
        </div>
        <div>
            <label for="image-upload">Image Upload:</label>
            <input type="file" id="image-upload" name="image-upload" accept="image/*" required>
        </div>
        <div class="tags-input">
            <label for="tags">Tags (Press Enter to create new tag)</label>
            <ul id="tags"></ul> 
            <input type="text" id="input-tag" 
                placeholder="Enter tag name" /> 
        </div> 
        <div>
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">I agree to the terms and conditions</label>
        </div>
        <div>
            <input type="checkbox" id="anonymous" name="anonymous">
            <label for="anonymous">Submit anonymously</label>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    
</body>
<script>
    function addressAutocomplete(containerElement, callback, options) {

    const MIN_ADDRESS_LENGTH = 3;
    const DEBOUNCE_DELAY = 100;

    // create container for input element
    const inputContainerElement = document.createElement("div");
    inputContainerElement.setAttribute("class", "input-container");
    containerElement.appendChild(inputContainerElement);

    // create input element
    const inputElement = document.createElement("input");
    inputElement.setAttribute("type", "text");
    inputElement.setAttribute("placeholder", options.placeholder);
    inputContainerElement.appendChild(inputElement);

    // add input field clear button
    const clearButton = document.createElement("div");
    clearButton.classList.add("clear-button");
    addIcon(clearButton);
    clearButton.addEventListener("click", (e) => {
    e.stopPropagation();
    inputElement.value = '';
    callback(null);
    clearButton.classList.remove("visible");
    closeDropDownList();
    });
    inputContainerElement.appendChild(clearButton);

    /* We will call the API with a timeout to prevent unneccessary API activity.*/
    let currentTimeout;

    /* Save the current request promise reject function. To be able to cancel the promise when a new request comes */
    let currentPromiseReject;

    /* Focused item in the autocomplete list. This variable is used to navigate with buttons */
    let focusedItemIndex;

    /* Process a user input: */
    inputElement.addEventListener("input", function(e) {
    const currentValue = this.value;

    /* Close any already open dropdown list */
    closeDropDownList();


    // Cancel previous timeout
    if (currentTimeout) {
        clearTimeout(currentTimeout);
    }

    // Cancel previous request promise
    if (currentPromiseReject) {
        currentPromiseReject({
        canceled: true
        });
    }

    if (!currentValue) {
        clearButton.classList.remove("visible");
    }

    // Show clearButton when there is a text
    clearButton.classList.add("visible");

    // Skip empty or short address strings
    if (!currentValue || currentValue.length < MIN_ADDRESS_LENGTH) {
        return false;
    }

    /* Call the Address Autocomplete API with a delay */
    currentTimeout = setTimeout(() => {
        currentTimeout = null;

        /* Create a new promise and send geocoding request */
        const promise = new Promise((resolve, reject) => {
        currentPromiseReject = reject;

        // The API Key provided is restricted to JSFiddle website
        // Get your own API Key on https://myprojects.geoapify.com
        const apiKey = "4fec94fc685f47e3b05b6160cbc869d8";

        var url = `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(currentValue)}&format=json&limit=5&apiKey=${apiKey}`;

        fetch(url)
            .then(response => {
            currentPromiseReject = null;

            // check if the call was successful
            if (response.ok) {
                response.json().then(data => resolve(data));
            } else {
                response.json().then(data => reject(data));
            }
            });
        });

        promise.then((data) => {
        // here we get address suggestions
        currentItems = data.results;

        /*create a DIV element that will contain the items (values):*/
        const autocompleteItemsElement = document.createElement("div");
        autocompleteItemsElement.setAttribute("class", "autocomplete-items");
        inputContainerElement.appendChild(autocompleteItemsElement);

        /* For each item in the results */
        data.results.forEach((result, index) => {
            /* Create a DIV element for each element: */
            const itemElement = document.createElement("div");
            /* Set formatted address as item value */
            itemElement.innerHTML = result.formatted;
            autocompleteItemsElement.appendChild(itemElement);

            /* Set the value for the autocomplete text field and notify: */
            itemElement.addEventListener("click", function(e) {
            inputElement.value = currentItems[index].formatted;
            callback(currentItems[index]);
            /* Close the list of autocompleted values: */
            closeDropDownList();
            });
        });

        }, (err) => {
        if (!err.canceled) {
            console.log(err);
        }
        });
    }, DEBOUNCE_DELAY);
    });

    /* Add support for keyboard navigation */
    inputElement.addEventListener("keydown", function(e) {
    var autocompleteItemsElement = containerElement.querySelector(".autocomplete-items");
    if (autocompleteItemsElement) {
        var itemElements = autocompleteItemsElement.getElementsByTagName("div");
        if (e.keyCode == 40) {
        e.preventDefault();
        /*If the arrow DOWN key is pressed, increase the focusedItemIndex variable:*/
        focusedItemIndex = focusedItemIndex !== itemElements.length - 1 ? focusedItemIndex + 1 : 0;
        /*and and make the current item more visible:*/
        setActive(itemElements, focusedItemIndex);
        } else if (e.keyCode == 38) {
        e.preventDefault();

        /*If the arrow UP key is pressed, decrease the focusedItemIndex variable:*/
        focusedItemIndex = focusedItemIndex !== 0 ? focusedItemIndex - 1 : focusedItemIndex = (itemElements.length - 1);
        /*and and make the current item more visible:*/
        setActive(itemElements, focusedItemIndex);
        } else if (e.keyCode == 13) {
        /* If the ENTER key is pressed and value as selected, close the list*/
        e.preventDefault();
        if (focusedItemIndex > -1) {
            closeDropDownList();
        }
        }
    } else {
        if (e.keyCode == 40) {
        /* Open dropdown list again */
        var event = document.createEvent('Event');
        event.initEvent('input', true, true);
        inputElement.dispatchEvent(event);
        }
    }
    });

    function setActive(items, index) {
    if (!items || !items.length) return false;

    for (var i = 0; i < items.length; i++) {
        items[i].classList.remove("autocomplete-active");
    }

    /* Add class "autocomplete-active" to the active element*/
    items[index].classList.add("autocomplete-active");

    // Change input value and notify
    inputElement.value = currentItems[index].formatted;
    callback(currentItems[index]);
    }

    function closeDropDownList() {
    const autocompleteItemsElement = inputContainerElement.querySelector(".autocomplete-items");
    if (autocompleteItemsElement) {
        inputContainerElement.removeChild(autocompleteItemsElement);
    }

    focusedItemIndex = -1;
    }

    function addIcon(buttonElement) {
    const svgElement = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
    svgElement.setAttribute('viewBox', "0 0 24 24");
    svgElement.setAttribute('height', "24");

    const iconElement = document.createElementNS("http://www.w3.org/2000/svg", 'path');
    iconElement.setAttribute("d", "M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z");
    iconElement.setAttribute('fill', 'currentColor');
    svgElement.appendChild(iconElement);
    buttonElement.appendChild(svgElement);
    }

    /* Close the autocomplete dropdown when the document is clicked. 
    Skip, when a user clicks on the input field */
    document.addEventListener("click", function(e) {
    if (e.target !== inputElement) {
        closeDropDownList();
    } else if (!containerElement.querySelector(".autocomplete-items")) {
        // open dropdown list again
        var event = document.createEvent('Event');
        event.initEvent('input', true, true);
        inputElement.dispatchEvent(event);
    }
    });
    }

    addressAutocomplete(document.getElementById("autocomplete-container"), (data) => {
    console.log("Selected option: ");
    console.log(data);
    }, {
    placeholder: "Start typing your address..."
    });
</script>
<script> 
      
    // Get the tags and input elements from the DOM 
    const tags = document.getElementById('tags'); 
    const input = document.getElementById('input-tag'); 

    // Add an event listener for keydown on the input element 
    input.addEventListener('keydown', function (event) { 

        // Check if the key pressed is 'Enter' 
        if (event.key === 'Enter') { 
          
            // Prevent the default action of the keypress 
            // event (submitting the form) 
            event.preventDefault(); 
          
            // Create a new list item element for the tag 
            const tag = document.createElement('li'); 
          
            // Get the trimmed value of the input element 
            const tagContent = input.value.trim(); 
          
            // If the trimmed value is not an empty string 
            if (tagContent !== '') { 
          
                // Set the text content of the tag to  
                // the trimmed value 
                tag.innerText = tagContent; 

                // Add a delete button to the tag 
                tag.innerHTML += '<button class="delete-button">X</button>'; 
                  
                // Append the tag to the tags list 
                tags.appendChild(tag); 
                  
                // Clear the input element's value 
                input.value = ''; 
            } 
        } 
    }); 

    // Add an event listener for click on the tags list 
    tags.addEventListener('click', function (event) { 

        // If the clicked element has the class 'delete-button' 
        if (event.target.classList.contains('delete-button')) { 
          
            // Remove the parent element (the tag) 
            event.target.parentNode.remove(); 
        } 
    }); 
</script>
</html>