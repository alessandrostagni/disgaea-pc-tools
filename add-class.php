<?php
	require_once("utils.php");

    $charProperties = array('exp', 'equipment', 'name', 'unknown01', 'title', 'unknown02', 'unknown03', 'resistances', 'unknown04', 'skillexp', 'skills', 'skilllevel', 'currenthp', 'currentsp', 'stats', 'realstats', 'unknown05', 'mana', 'unknown06', 'weaponmasterylv', 'weaponmasteryrate', 'basestats', 'level', 'unknown07', 'class', 'class2', 'skilltree', 'unknown08', 'unknown09', 'unknown10', 'basejm', 'jm', 'basemv', 'mv', 'counter', 'senaterank');


    if (!isset($argv[1])) {
		die("Usage: <original-SAVExxx.DAT> \nLists characters in savefile");
	} elseif (!file_exists($argv[1])) {
		die("Filename $argv[1] not found\n");
	}

	$save		= new \Disgaea\SaveFile($argv[1]);
	$saveData	= $save->getSaveObject();

	$characters			= $saveData->getChunk('characters');
    // $newCharacter = new \Disgaea\Data\Character();
    // array_push($characters, $characters[0]);
    // array_push($characters, $characters[0]);
    // $characters[$argv[2]]->setChunk('class', 2172);
    // $characters[$argv[2]]->setChunk('level', 100);
    $newCharIndex = null;
    for($i=0; $i<count($characters); $i++) {
        if(($characters[$i]->getChunk('name') == 'Reception' && $characters[$i]->getChunk('class') == 2918) || (($characters[$i]->getChunk('name') == 'Ark' || $characters[$i]->getChunk('name') == '') && $characters[$i]->getChunk('class') == 0))
        {
            $newCharIndex = $i;
            break;
        }
	}
    if(!$newCharIndex)
    {
        print("Couldn't add character, empty slot not found.\n\n");
    }
    else{
        print("Empty slot found at index $newCharIndex. Addding character... \n\n");
    }
    // Copy character in new slot
    foreach ($charProperties as $charProperty) {
        if($charProperty != 'equipment' && $charProperty != 'stats' && $charProperty != 'realstats' && $charProperty != 'basestats' && $charProperty != 'resistances' && $charProperty != 'skillexp' && $charProperty != 'skills' && $charProperty != 'skilllevel') {
            $characters[$newCharIndex]->setChunk($charProperty, $characters[$argv[2]]->getChunk($charProperty));
        }
    }
    // Increment number of characters in current party
    $saveData->setChunk('charactercount', $saveData->getChunk('charactercount') + 1);
    print($saveData->getChunk('charactercount'));
    print("-----------------------\n\n");
    $save->updateSaveFile($saveData);
	print "Writing save file...\n";
	$save->writeSaveFile($argv[1]);
	print "Done\n";

	print "\n\n";
?>