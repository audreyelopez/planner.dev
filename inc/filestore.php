<?php

 class Filestore {

     private $filename = '';
     private $is_csv = FALSE;
     
     function __construct($filename = ''){
         $this->filename = $filename;
         // create a substring to check file extention 
         if(substr($this->filename, -3) == 'csv'){ 
            $this->is_csv = TRUE;
         }

     }   
         
         public function read() 
          {
            if($this->is_csv) {
            return $this->read_csv();
            } else {
              return $this->read_lines();
              }  

         }

         public function write($array)
         {
          if($this->is_csv) {
            return $this->write_csv($array);
           } else {
              return $this->write_lines($array);
              }    
         } 
// =================================
    // * Returns array of lines in $this->filename
    private function read_lines()
    {
        $items = array();
        if (is_readable($this->filename) && filesize($this->filename) > 0) {
            $handle = fopen($this->filename, 'r');
            $contents = trim(fread($handle, filesize($this->filename)));
            $items = explode(PHP_EOL, $contents);
            fclose($handle);
        }
        return $items;
    }

// =================================
     /**
      * Writes each element in $array to a new line in $this->filename
      */
     private function write_lines($items)
     {
       $handle = fopen($this->filename, 'w');
         foreach ($items as $value) {
           fwrite($handle, $value . PHP_EOL);
         }

         fclose($handle);   
     }
// =================================
     /**
      * Reads contents of csv $this->filename, returns an array
      */
     private function read_csv()
     {
        $array = array();
        $handle = fopen($this->filename, 'r');

        while (!feof($handle)) {
            $row = fgetcsv($handle);

            if (!empty($row)) {
                $array[] = $row;
            }
        }
         
        fclose($handle);
        return $array;
    }

// =================================
     /**
      * Writes contents of $array to csv $this->filename
      */
 
     private function write_csv($array) {
        $handle = fopen($this->filename, 'w');

        foreach ($array as $row) 
        {
            fputcsv($handle, $row);

        }

        fclose($handle);
        return $array;
    }
   
   

   // ===============================
if (isset($_GET['remove'])) {
        // define the contact/row user would like to remove
        // $keytoremove = $_GET['remove'];
// 
        // remove contact selected; specified with $_GET
        // unset($address_book[$keytoremove]);
// 
        // reindex numbers of list with item removed
        // $address_book = array_values($address_book);
// 
        // save new contact to file with "save_to_file" function
        // $ads->write_address_book($address_book); 
 }

public function remove($row) {
    foreach $contact as $row {

    }
}

?>