<?php
function css_generator($info)

{
    $inst= getInstructions();
    $pad = $inst['padding'] == null ? 0 : $inst['padding'];
    $img_name = $inst['img_name'];
    $sheet_name = $inst['sheet_name'];
    $css = fopen("./result/src/$sheet_name", "w+");  // open and write file css
    $place = 0;


    // Initialisation des variables
    $img_css = ".sprite {\ndisplay: inline-block;\n background: url('../src/$img_name') no-repeat;\n }\n\n";
    fwrite($css, $img_css);

    foreach ($info as $data) {
        static $n = 1;
        $txt = "#img$n {\n background-position: -0px -"."$place"."px;\n width: $data[width]px;\n height: $data[height]px;\n }\n\n";
        $place +=$pad+ $data['width'];
        fwrite($css, $txt);
        $n++;
    };
    echo "➡ Le fichier de style a été créé avec succès.\n";
    fclose($css);
}


