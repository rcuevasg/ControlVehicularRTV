<?php
session_start();
session_destroy();
//header("Location: http://ciapemregional.veracruz.gob.mx/index.php?v=0");
print "<script> document.location = '../index.php' </script>"
?>