<?php



// create "server" one file before "public", so that other's cannot access it once app is live
define('FILENAME', '../data/mylist.txt'); 

function open_file($fileName = FILENAME) {
  $handle = fopen($fileName, 'r'); 
  $contents = trim(fread($handle, filesize($fileName)));
  $contents_array = explode("\n", $contents);
  fclose($handle);
  return $contents_array;
  }


// Save list items to the file
function save_to_list($todo, $filename = FILENAME) {
  $handle = fopen($filename, 'w');
  foreach ($todo as $key) {
	fwrite($handle, $key . PHP_EOL);
	}
	
	fclose($handle);
    } 

    $items = open_file();

// check for 'additem' key in POST to see if user has added an item 
if (isset($_POST['additem'])) {
	// add new item from POST to $items array
	$items[] = $_POST['additem'];
	// save array with new item added 
	save_to_list($items);
    }
?>

<html>
<head>
 <title>Sample TODO list</title>
  <style>
	h2  {
	     color: PaleVioletRed;
	     text-decoration: underline;
	     } 

	body {
	      background-color: MediumSpringGreen;
	      font-style: cursive;
	      }

	li    {
	      list-style: cursive;
	      }	
    </style>       	  
</head>
 <body>

   <h2>TODO List</h2>
   
<?php
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
  
   // Loop through array $items and output key => value pairs
   foreach ($items as $key => $item) {
	// Include anchor tag and link to perform GET request, according to $key 
	echo '<li> <a href=' . "?remove=$key" . '>Item Completed</a> - ' . "$item</li>";
    }
?>

<ul>
<!--Add Form, to allow for items to be added  -->
 <form name="additem" method="POST" action="todo_list.php">
   <label>Add Item: </label>
   <input type="text" id="additem" name="additem">
   <button value="submit">Add Item</button>
 </form>
</body>
</html>
   