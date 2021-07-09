<?php 

// add commit push to branch 
echo 'cd DOMAIN'
echo `git add .`;
echo '<br>';
echo `git commit -m "Auto Backup from host"`;
echo '<br>';


//Store the output of the executed command in an array
// exec('ls -l ./images/*.*', $output);

//Print the output of the executed command
// echo "<pre>";
// print_r($output);
// echo "</pre>";

?>