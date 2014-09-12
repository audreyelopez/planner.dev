<?php

define('FILENAME', '../data/address_book.csv');

class AddressDataStore {
    public $filename = '';

    // set name on instantiation
    function __construct($filename = FILENAME)
    {
        $this->filename = $filename;
    }

    // add new contact info in new row
    function read_from_csv() {

        $handle = fopen($this->filename, 'r');

        while (!feof($handle)) {
            $row = fgetcsv($handle);

            if (!empty($row)) {
                $address_book[] = $row;
            }
        }

        return $address_book;
    }

    function save_to_csv($address_book) {
        $handle = fopen($this->filename, 'w');

        foreach ($address_book as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
    }
}

// enact function to save csv file (pass in the filename);
$ads = new AddressDataStore();
$address_book = $ads->read_from_csv();

// Look for newly added contacts in POST 
    if (!empty($_POST)) {
      // If new contact is present, add from POST to "contacts" array
      // make into array

        $contact = [
            $_POST['contact_name'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['city'],
            $_POST['state'],
            $_POST['zip']
        ];

        $address_book[] = $contact;
        $ads->save_to_csv($address_book);
    }  // End POST Check 


    if (isset($_GET['remove'])) {
        // define the contact/row user would like to remove
        $keytoremove = $_GET['remove'];

        // remove contact selected; specified with $_GET
        unset($address_book[$keytoremove]);

        // reindex numbers of list with item removed
        $address_book = array_values($address_book);

        //save new todo to file with "save_to_file" function
        $ads->save_to_csv($address_book); 
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
        
        // add constructor
        $newAds = new AddressDataStore($saved_filename);

        $upload_items = $newAds->read_from_csv();
        $address_book = array_merge($address_book, $upload_items);
        $ads->save_to_csv($address_book);
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

    <form method="POST" enctype="multipart/form-data" action="address_book.php">
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