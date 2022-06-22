<?php
function getInstructions()
{
    global $argc;
    // Default values
    $instructions = [
        'recursive' => NULL,
        'img_name' => 'sprite.png',
        'sheet_name' => 'styles.css',
        'size' => NULL,
        'columns' => NULL,
        'padding' => NULL,
    ];
    // handles man
    if ($argc == 2) {
        $help = getopt('h', ['help']);
        if (key_exists('h', $help) || key_exists('help', $help)) {
            man:
          echo "\nHELP MANUAL :\n\n";
          echo "\e[32m -h, --help\n\n " ; 
          echo "\e[37m     Display help. \n\n ";
          echo "\e[32m -r, --recursive \n\n" ;  
          echo "\e[37m     Look for images into the assets_folder passed as arguement and all of its subdirectories.\n\n" ; 
          echo "\e[32m -i, --output-image=IMAGE\n\n";
          echo "\e[37m     Name of the generated image. If blank, the default name is « sprite.png ».\n\n ";   
          echo "\e[32m-s,  --output-style=STYLE\n\n" ;
          echo "\e[37m     Name of the generated stylesheet. If blank, the default name is « style.css ».\n\n "  ;
          echo "\e[32m -o, --override-size=SIZE\n\n" ;   
          echo "\e[37m     Force each images of the sprite to fit a size of SIZExSIZE pixels.\n\n "  ;
          echo "\e[32m-c, --columns_number=NUMBER\n\n" ;  
          echo "\e[37m     The maximum number of elements to be generated horizontally.\n\n " ;  
          echo "\e[32m-p, --padding=NUMBER\n\n" ;    
          echo "\e[37m     Add padding between images of NUMBER pixels.\n\n\n;" ;
            return;
        };
    };
    // Gets options from CLI
    if ($argc == 1) {
        goto man;
    } else if ($argc > 2) {
        $opt = getopt('hri:s:o:c:p:', ['help', 'recursive', 'output-image:', 'output-style:', 'override-size:', 'columns_number:', 'padding:']);

        if (isset($opt) && $opt > 0) {
            // Print the manual
            if (key_exists('h', $opt) || key_exists('help', $opt)) {
            };
            
            // Handles the 'recursivness'
            if (key_exists('r', $opt) || key_exists('recursive', $opt)) {
                $instructions['recursive'] = true;
            };

            // Handles the output file name
            if (key_exists('i', $opt) || key_exists('output-image', $opt)) {
                $val = key_exists('i', $opt) ? $opt['i'] : $opt['output-image'];
                if (!str_ends_with($val, '.png')) {
                    $val .= '.png';
                };
                $instructions['img_name'] = $val;
            };

            // Handles the stylesheet name
            if (key_exists('s', $opt) || key_exists('output-style', $opt)) {
                $val = key_exists('s', $opt) ? $opt['s'] : $opt['output-style'];
                if (!str_ends_with($val, '.css')) {
                    $val .= '.css';
                };
                $instructions['sheet_name'] = $val;
            };
            // Handles padding option
            if (key_exists('p', $opt) || key_exists('padding', $opt)) {
                $val = key_exists('p', $opt) ? $opt['p'] : $opt['padding'];
                $val = (int)$val;

                if ($val !== 0) {
                    $instructions['padding'] = $val;
                } else {
                    echo "Le padding doit être un nombre entier et être supérieur à 0.\n";
                    return;
                };
            };
        };
    };
    return $instructions;
};