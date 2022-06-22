<?php
     function iterate($folder, $rec = false)
     {
         global $files,$wrong;
         foreach (glob($folder . '/*') as $filename) {
             if ($rec == true) {
                 if (is_dir($filename)) {
                     iterate($filename, true);
                 };
             };
             if (mime_content_type($filename) == 'image/png') {
                 $files[] = $filename;
             };
             if (mime_content_type($filename) != 'image/png' && !is_dir($filename)) {
                $wrong[] = $filename;
            };
   
         };
         return [$files, $wrong];
     };
