<?php
extract($_REQUEST);

$f=$file;
if(!file_exists($f))
    die('File :'.$f.' does not exist');

//Handle special IE request if needed
if($HTTP_SERVER_VARS['HTTP_USER_AGENT']=='contype')
{
    Header('Content-Type: application/pdf');
    exit;
}
//Output PDF
Header('Content-Type: application/pdf');
Header('Content-Length: '.filesize($f));
readfile($f);
//Remove file
unlink($f);
exit;
?>
