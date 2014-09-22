<?php

 class Filestore {

     public $filename = '';

     function __construct($filename = '')
     {
         $this->filename = $filename;
     }
// =================================
    // * Returns array of lines in $this->filename
    function read_lines()
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
     function write_lines($items)
     {
       $handle = fopen($this->filename, 'w');
         foreach ($items as $item => $value) {
           fwrite($handle, $item . PHP_EOL);
         }

         fclose($handle);   
     }
// =================================
     /**
      * Reads contents of csv $this->filename, returns an array
      */
     function read_csv()
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
 
     function write_csv($array) {
        $handle = fopen($this->filename, 'w');

        foreach ($array as $row) 
        {
            fputcsv($handle, $row);
        }

        fclose($handle);
        return $array;
    }
   
   }

?>