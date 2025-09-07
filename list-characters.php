<?php
	require_once("utils.php");

    if (!isset($argv[1])) {
		die("Usage: <original-SAVExxx.DAT> \nLists characters in savefile");
	} elseif (!file_exists($argv[1])) {
		die("Filename $argv[1] not found\n");
	}

	$save		= new \Disgaea\SaveFile($argv[1]);
	$saveData	= $save->getSaveObject();

	$characters			= $saveData->getChunk('characters');
	print "Done\n";

	foreach ($characters as $id => $character) {
        print("\n");
        print($character);
        print("--------------------------------");
        print("\n\n");
	}

	print "\n\n";
?>