<?php
function my_merge_image()
{
    global $argv, $argc;
    if ($argc > 1) {
        $input = $argv[$argc - 1];
        if (is_dir($input)) {
            if (!str_ends_with($input, '/')) {
                $folder = rtrim($input, '/');
            } else {
                // The el is not a folder and then should be ignored
                echo "Le répértoire spécifié n'est pas un dossier.\n";
                return;
            }
            // var_dump($input);
            $w = 0;
            $h = 0;
            $place = 0;
            // Initialisation de $width, $height, $type et conditions de remplacement
            $inst = getInstructions();
            // var_dump($inst['recursive']);

            if ($inst['recursive']) {
                $result = iterate($folder, true);
            } else $result = iterate($folder);
            $files = $result[0];
            $wrong = $result[1];

            if ($files>0) {
                if ($wrong > 0) {
                    $c = count(($wrong));
                    if ($c == 1) {
                        echo "\n❗Votre dossier contient un fichier qui n'est pas au format PNG. Il sera ignoré.\n\n";
                    } else {
                        echo "❗Votre dossier contient $c fichiers qui ne sont pas au format PNG. Ils seront ignorés.\n\n";
                    };
                };
                foreach ($files as $file) {
                    $value = getimagesize($file); // Get the size of an image
                    $width = $value[0];
                    $height = $value[1];
                    $type = $value[2];
                    $h += $height;
                    if ($w <= $width) {
                        $w = $width;
                    }
                    //SET values in the array
                    $imgs[] = array('file' => $file, 'type' => $type, 'width' => $width, 'height' => $height);
                }
                // Padding options
                $count = count($files) - 1;
                $pad = $inst['padding'] == null ? 0 : $inst['padding'];
                $h += $pad * $count; //new height with padding
                // Create sprite w/ transparent background
                $sprite = imagecreatetruecolor($w, $h);
                imagealphablending($sprite, false);
                imagesavealpha($sprite, true);
                $background = imagecolorallocatealpha($sprite, 255, 255, 255, 127);
                imagefill($sprite, 0, 0, $background);

                foreach ($imgs as $img) {
                    if ($img['type'] == IMAGETYPE_PNG) {
                        $file = imagecreatefrompng($img['file']);
                    }
                    imagecopy($sprite, $file, 0, $place, 0, 0, $img['width'], $img['height']);
                    $place += $pad + $img['width'];
                }
                $name = $inst['img_name'];
                $sprite = imagepng($sprite, "./result/src/$name");

                echo "➡️ Le fichier de sprite été créé avec succès.\n";
                $img_name = $inst["img_name"];
                $sheet_name = $inst["sheet_name"];
                css_generator($imgs);  // Appel de la function CSS_GENERATOR
                echo "\nFichier de style : ./result/src/$sheet_name\nFichier sprite : ./result/src/$img_name\n";
                echo "\n\n✨ La génération du sprite et l'écriture du fichier de style sont terminés.";



            } else {
                echo "Le dossier donné ne contient aucun fichier sous le format PNG.";
               
            }
        } else {
            echo "\033[31m" . "Le dernier élèment \"$input\" n'est pas un dossier.\nVeuillez renseigner une commande sous ce format : SCRIPT [OTPION(S)] DOSSIER.\n";
            return false;
        };
    } else {
        return false;
    }
}
