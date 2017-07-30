<?php
$item = 0;

foreach (range(1,5) as $item){
    if ($item>3)
        break;
}

echo  $item;
