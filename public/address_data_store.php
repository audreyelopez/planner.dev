<?php
 
 // TODO: require Filestore class

 require('../inc/filestore.php');
 class AddressDataStore extends Filestore {

     function _construct ($files = '')
     {
     // this overwrites the parent _construct so that new file names are automatically lowercase
     parent::_construct(strtolower($files));
     }



     function read_address_book()
     {
         // TODO: refactor to use new $this->read_csv() method
        return $this->read();
     }

     function write_address_book($addresses_array)
     {
         // TODO: refactor to use new write_csv() method
        return $this->write($addresses_array);
     }

 };

// ======================================================
// class AddressDataStore {
    // (removed now using the parent) public $filename = '';

    // set name on instantiation
    // (removed now using the parent) function __construct($filename = FILENAME)
    // {
        // $this->filename = $filename;
    // }

    // add new contact info in new row
    // function read_from_csv() 
    // {

        // $handle = fopen($this->filename, 'r');

        // while (!feof($handle)) {
            // $row = fgetcsv($handle);

            // if (!empty($row)) {
                // $address_book[] = $row;
            // }
        // }

        // return $address_book;
    // }

    // function save_to_csv($address_book) {
        // $handle = fopen($this->filename, 'w');

        // foreach ($address_book as $row) {
            // fputcsv($handle, $row);
        // }

        // fclose($handle);
    // }

// }
   // 