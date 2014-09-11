<?php
define('FILENAME', '../data/address_book.csv');

// add new contact info in new row
function read_from_csv($filename = FILENAME) {

    $handle = fopen($filename, 'r');

    while (!feof($handle)) {
        $row = fgetcsv($handle);

        if (!empty($row)) {
            $address_book[] = $row;
        }
    }

    return $address_book;
}

// enact function to save csv file (pass in the filename);
function save_to_csv($address_book, $filename = FILENAME) {
    $handle = fopen($filename, 'w');

    foreach ($address_book as $row) {
        fputcsv($handle, $row);
    }

    fclose($handle);  
}

$address_book = read_from_csv();

// =============================================================================
   
// make this block of code/method into it's own function; 
// the new function should read into the csv
// function add_newcontact_row($handle, $row) {
//     $handle = fopen(FILENAME, 'r');
//     while (!feof($handle)) {
//         $row = fgetcsv($handle);

//         if(!empty($row)) {
//            $address_book[] = ($row);
//         }
//     }
// }    

// make into multidementional array by breaking down each contact into it's own array
 // $address_book = [
 //      ['The White House, 1000 Abraham Lincoln Drive', 'Washington', 
 //      'DC', 10101],
 //      ['Marvel Comics', 'Lois Lane', 'Long Island', 'NY', 10102],
 //      ['Ima D\'best', '100 Awesome Street', 'Great City', 'GS', 10103]
 //  ];

 // Look for newly added contacts in POST 
    if (!empty($_POST)) {
      // If new contact is present, add from POST to "contacts" array
      // make into array
      // var_dump($_POST);


        $contact = [
            $_POST['contact_name'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['city'],
            $_POST['state'],
            $_POST['zip']
            
        ];

        // check names on these, enter correct variable names - are correct (doublecheck?);
        $address_book[] = $contact;
        save_to_csv($address_book);
    }  // End POST Check 


    if (isset($_GET['remove'])) {
        // define the variable user would like to remove next
        $keytoremove = $_GET['remove'];
        // remove item selected; specified with $_GET
        unset($address_book[$keytoremove]);
        // reindex numbers of list with item removed
        $address_book = array_values($address_book);
        //save new todo to file with "save_to_file" function
        save_to_csv($address_book); 
    }

?>
<html>
<head>
    <title>Address Book</title>
</head>
<body>
    <table border = "1">
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Delete Contact</th>
         </tr>

        <?php foreach ($address_book as $key => $contact): ?>
            <tr>
            <?php foreach ($contact as $key2 => $value): ?>
              <td><?= $value; ?></td>
            <?php endforeach ?>
            <td><a href="?remove=<?= $key; ?>">Delete Contact</a></td>
            </tr>
        <?php endforeach ?>

    </table>

    <!-- Add Address Form -->
    <form name="additem" method="POST" action="address_book.php"><br>
        <input type="text"  name="contact_name" placeholder="Name" id="contact_name" />
        <input type="text"  name="phone" placeholder="Phone" id="phone" />
        <input type="text"  name="address" placeholder="Address" id="address" />
        <input type="text"  name="city" placeholder="City" id="city" />
        <input type="text"  name="state" placeholder="State" id="state" />
        <input type="text"  name="zip" placeholder="Zip" id="zip" />
        <button value="submit">Submit</button>
    </form>

</body>
</html>