<?php
require 'subclasses/billboard_location_sst.php';
$sst = new billboard_location_sst;
$sst->auto_test('detail_view');
$sst_script = $sst->script;