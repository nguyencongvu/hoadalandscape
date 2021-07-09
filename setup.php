<?php  

$NEW_DOMAIN = 'shilenanailsspa'; 
// branch = main  



echo 'cd /opt/www/danhba.top/web';
echo "<br>";
// echo "rm -rf shilenanailsspa";
// echo "<br>";
echo $a = "git clone -b main https://github.com/WebUp-top/{$NEW_DOMAIN}.git";
echo "<br>";
echo $a = "chmod -R 755 ./{$NEW_DOMAIN}";
echo $a = "<br>";
echo $a = "chown -R www:www ./{$NEW_DOMAIN}";
echo "<br>";


?>
