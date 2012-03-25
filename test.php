<?php

require 'phpirt.php';

$irt = new InstagramRealTime('699495b3bfaf4632bdc5096e7544ff23', '68af47b6e9174f5dbb94ef913fdc42b3', 'http://public.olapic.com/~aseba/PHPIRT/callback.php');
$irt->addSubscription('tag', 'media', 'nyc');
// $irt->addSubscription('tag', 'media', 'hq');
// $irt->addSubscription('tag', 'media', 'catan');
// $irt->deleteSubscription('all');

?>
?>