#!/usr/bin/env php
<?php 

include_once('./php/get_instructions.php');
include_once('./php/scan_folder.php');
include_once('./php/generator_sprite.php');
include_once('./php/write_files.php');

function main()
{
$inst = getInstructions();
if($inst){
      my_merge_image();
}
else return;
}

main();

