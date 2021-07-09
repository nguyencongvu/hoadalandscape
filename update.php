<?php 

//Store the output of the executed command in an array
exec('ls -l *.php', $output);

//Print the output of the executed command
echo "<pre>";
print_r($output);
echo "</pre>";

?>