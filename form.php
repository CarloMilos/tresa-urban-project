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

    <form action="formpost.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="uname">Name:</label>
            <input type="text" id="name" name="uname" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
        </div>
        <div>
            <label for="uaddress">1st line of Address:</label>
            <input type="text" id="email" name="uaddress" required>
        </div>
        <div>
            <label for="postcode">Postcode</label>
            <input type="text" id="postcode" name="postcode" required>
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
            <label for="terms">I agree to the terms and conditions INSERT LINK??</label>
        </div>
        <div>
            <input type="checkbox" id="anon" name="anon">
            <label for="anonymous">Submit anonymously?</label>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    
</body>
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