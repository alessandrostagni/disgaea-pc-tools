<?php
	require_once("utils.php");

    function addNewCharacter($saveData, $characters, $class, $level, $cloned) {
        $charProperties = array('exp', 'equipment', 'name', 'unknown01', 'title', 'unknown02', 'unknown03', 'resistances', 'unknown04', 'skillexp', 'skills', 'skilllevel', 'currenthp', 'currentsp', 'stats', 'realstats', 'unknown05', 'mana', 'unknown06', 'weaponmasterylv', 'weaponmasteryrate', 'basestats', 'level', 'unknown07', 'class', 'class2', 'skilltree', 'unknown08', 'unknown09', 'unknown10', 'basejm', 'jm', 'basemv', 'mv', 'counter', 'senaterank');
        $newCharIndex = null;
        for($i=0; $i<count($characters); $i++) {
            if(($characters[$i]->getChunk('name') == 'Reception' && $characters[$i]->getChunk('class') == 2918))
            {
                $newCharIndex = $i;
                break;
            }
	    }
        if(is_null($newCharIndex))
        {
            throw new \Exception("Couldn't add character, empty slot not found.\n\n");
        }
        else{
            print("Empty slot found at index $newCharIndex. Addding character... \n\n");
        }
        // Copy character in new slot
        foreach ($charProperties as $charProperty) {
            if($charProperty != 'equipment' && $charProperty != 'stats' && $charProperty != 'realstats' && $charProperty != 'basestats' && $charProperty != 'resistances' && $charProperty != 'skillexp' && $charProperty != 'skills' && $charProperty != 'skilllevel') {
                $characters[$newCharIndex]->setChunk($charProperty, $characters[$cloned]->getChunk($charProperty));
            }
            $characters[$newCharIndex]->setChunk('class', $class);   // Set target class
            $characters[$newCharIndex]->setChunk('level', $level);   // Set target level
            $characters[$newCharIndex]->setChunk('currenthp', 1);   // Set hp to 1 to avoid overflow
            $characters[$newCharIndex]->setChunk('currentsp', 1);   // Set sp to 1 to avoid overflow
            $characters[$newCharIndex]->setChunk('weaponmasterylv', "aaaaaaaa");   // Set high mastery level to unlock all classes
        }
        $saveData->setChunk('charactercount', $saveData->getChunk('charactercount') + 1);
    }

    if (!isset($argv[1])) {
		die("Usage: <original-SAVExxx.DAT> \nLists characters in savefile");
	} elseif (!file_exists($argv[1])) {
		die("Filename $argv[1] not found\n");
	}

	$save		= new \Disgaea\SaveFile($argv[1]);
	$saveData	= $save->getSaveObject();
	$characters			= $saveData->getChunk('characters'); // Add level 200 Brawler Male

    addNewCharacter($saveData, $characters, 1010, 200, $argv[2]); // Add level 200 Brawler Male
    addNewCharacter($saveData, $characters, 1020, 200, $argv[2]); // Add level 200 Brawler Female
    addNewCharacter($saveData, $characters, 1030, 200, $argv[2]); // Add level 200 Warrior Male
    addNewCharacter($saveData, $characters, 1040, 200, $argv[2]); // Add level 200 Warrior Female
    addNewCharacter($saveData, $characters, 1050, 500, $argv[2]); // Add level 500 Majin
    addNewCharacter($saveData, $characters, 1060, 200, $argv[2]); // Add level 200 Ninja
    addNewCharacter($saveData, $characters, 1070, 200, $argv[2]); // Add level 200 Ronin
    addNewCharacter($saveData, $characters, 1080, 200, $argv[2]); // Add level 200 Rune Knight
    addNewCharacter($saveData, $characters, 1090, 200, $argv[2]); // Add level 200 Archer
    addNewCharacter($saveData, $characters, 1120, 200, $argv[2]); // Add level 200 Healer Male
    addNewCharacter($saveData, $characters, 1130, 200, $argv[2]); // Add level 200 Healer Female
    addNewCharacter($saveData, $characters, 1140, 200, $argv[2]); // Add level 200 Scout
    addNewCharacter($saveData, $characters, 1150, 200, $argv[2]); // Add level 200 EDF Soldier
    addNewCharacter($saveData, $characters, 1160, 200, $argv[2]); // Add level 200 Angel
    addNewCharacter($saveData, $characters, 1170, 200, $argv[2]); // Add level 200 Rogue
    addNewCharacter($saveData, $characters, 1100, 200, $argv[2]); // Add level 200 Skull Fire
    addNewCharacter($saveData, $characters, 1101, 200, $argv[2]); // Add level 200 Skull Wind
    addNewCharacter($saveData, $characters, 1102, 200, $argv[2]); // Add level 200 Skull Ice
    addNewCharacter($saveData, $characters, 1103, 200, $argv[2]); // Add level 200 Star Skull
    addNewCharacter($saveData, $characters, 1104, 200, $argv[2]); // Add level 200 Prism Skull
    addNewCharacter($saveData, $characters, 1110, 200, $argv[2]); // Add level 200 Red Mage
    addNewCharacter($saveData, $characters, 1111, 200, $argv[2]); // Add level 200 Wind Mage
    addNewCharacter($saveData, $characters, 1112, 200, $argv[2]); // Add level 200 Blue Mage
    addNewCharacter($saveData, $characters, 1113, 200, $argv[2]); // Add level 200 Star Mage
    addNewCharacter($saveData, $characters, 1114, 200, $argv[2]); // Add level 200 Prism Mage

    // Increment number of characters in current party
    print($saveData->getChunk('charactercount'));
    print("-----------------------\n\n");
    $save->updateSaveFile($saveData);
	print "Writing save file...\n";
	$save->writeSaveFile($argv[1]);
	print "Done\n";
	print "\n\n";
?>