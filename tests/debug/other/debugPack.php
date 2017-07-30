<?php

var_dump(unpack("C*", "abcde"));
$int = unpack("C", "aa")[1];
echo $int;
echo $int >> 8;
echo ($int & 0xff);
