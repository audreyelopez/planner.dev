<?php

// create "server" one file before "public", so that other's cannot access it once app is live
define('FILENAME', '../data/mylist.txt'); 

function loadfile($fileName = FILENAME)
{
    $items = array();
    if (is_readable($fileName) && filesize($fileName) > 0) {
        $handle = fopen($fileName, 'r');
        $contents = trim(fread($handle, filesize($fileName)));
        $items = explode(PHP_EOL, $contents);
        fclose($handle);
    }
    return $items;
}

$items = loadfile();

// Save list items to the file
function save_to_list($items, $fileName = FILENAME) {
    $handle = fopen($fileName, 'w');
    foreach ($items as $item) {
        fwrite($handle, $item . PHP_EOL);
    }
    
    fclose($handle);
} 

// check for 'additem' key in POST to see if user has added an item 
if (isset($_POST['additem'])) {
    // add new item from POST to $items array
    $items[] = $_POST['additem'];
    // save array with new item added 
    save_to_list($items);
}

if (isset($_GET['remove'])) {
    // define the variable user would like to remove next
    $keytoremove = $_GET['remove'];
   // remove item selected; specified with $_GET
   unset($items[$keytoremove]);
   // reindex numbers of list with item removed
   $items = array_values($items);
   //save new todo to file with "save_to_file" function
   save_to_list($items); 
}

// Verify that files were uploaded and no errors occured
if (count($_FILES) > 0 && $_FILES ['file1']['error'] == 0) {
    // create or set destination directory for uploaded files
    $upload_dir = '/vagrant/sites/planner.dev/public/uploads/';
    // select fileName from uploaded file by basename
    $fileName = basename($_FILES['file1']['name']);
    // save file under original file name and OUR upload directory
    $saved_filename = $upload_dir . $fileName ;
    // move file to temporary location, our upload directory folder
    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
}
?>

<html>
<head>
    <title>Sample TODO list</title>
    <style>
        h1 {
            color: PaleVioletRed;
            text-decoration: underline;
        } 

        body {
            background-color: MediumSpringGreen;
            font-style: cursive;
        }

        li {
            list-style: cursive;
        }
        botton {

        }
    </style>          
</head>
<body>

    <h1> TODO List </h1>
<ul>
    <?php foreach ($items as $key => $item) : ?>
        <li><a href='?remove=<?= $key; ?>'>Item Completed</a> - <?= htmlspecialchars(strip_tags($item)); ?></li>
    <?php endforeach; ?>

</ul>


 <!-- Add Form, to allow for items to be added  -->
<form name="additem" method="POST" action="todo_list.php">
    <label>Add Item: </label>
    <input type="text" id="additem" name="additem">
    <button value="submit">Add Item</button>
</form>


<!-- check whether file has been saved  -->
<? if (isset($saved_filename)): ?>
    // if successfully saved, show link to newly uploaded file
<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p> 
<? endif; ?>

<h2> Upload File: <h2>
    <form method="POST" enctype="multipart/form-data" action="todo_list.php">
       <p>
       <label for="file1">File to upload: </label>
       <input type="file" id="file1" name="file1">
       </p>
       <p>
       <input type="submit" value="Upload">
       </p>
    </form>
</body>
</html>
   