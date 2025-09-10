<?php
require_once("utils.php");
// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Define the target directory for uploads
    $target_dir = "uploads/";
    $processed_directory = "processed/";
    $uploadOk = 1;

    // Create the upload directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Check if file was uploaded without errors
    if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['uploaded_file'];
        
        // Generate a unique filename with hash
        $hashed_filename = md5(uniqid()) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $target_path = $target_dir . basename($hashed_filename);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            // Process the file and modify it as needed
            ob_start();
            echo "The file ". htmlspecialchars(basename($file["name"])) ." has been uploaded successfully.";
            unlockAllClasses($hashed_filename, $target_dir, $processed_directory);
            ob_end_clean();

            // Force download of the processed file
            forceDownload($hashed_filename, $processed_directory);
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    } else {
        die("Error: " . $_FILES['uploaded_file']['error']);
    }
} else {
    header('Location: unlock-human-classes.html');
}

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
        die("Couldn't add character, there needs to be 6 or less characters present in your save file.\n\n");
    }
    else{
        echo("Empty slot found at index $newCharIndex. Adding character... \n\n");
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

function unlockAllClasses($filename, $directory, $processed_directory) {
    $fullPath = $directory . $filename;
    if (!isset($fullPath)) {
		die("Usage: <original-SAVExxx.DAT> \nLists characters in savefile");
	} elseif (!file_exists($fullPath)) {
		die("Filename $fullPath not found\n");
	}

	$save		= new \Disgaea\SaveFile($fullPath);
	$saveData	= $save->getSaveObject();
	$characters			= $saveData->getChunk('characters'); // Add level 200 Brawler Male

    addNewCharacter($saveData, $characters, 1010, 200, 0); // Add level 200 Brawler Male
    addNewCharacter($saveData, $characters, 1020, 200, 0); // Add level 200 Brawler Female
    addNewCharacter($saveData, $characters, 1030, 200, 0); // Add level 200 Warrior Male
    addNewCharacter($saveData, $characters, 1040, 200, 0); // Add level 200 Warrior Female
    addNewCharacter($saveData, $characters, 1050, 500, 0); // Add level 500 Majin
    addNewCharacter($saveData, $characters, 1060, 200, 0); // Add level 200 Ninja
    addNewCharacter($saveData, $characters, 1070, 200, 0); // Add level 200 Ronin
    addNewCharacter($saveData, $characters, 1080, 200, 0); // Add level 200 Rune Knight
    addNewCharacter($saveData, $characters, 1090, 200, 0); // Add level 200 Archer
    addNewCharacter($saveData, $characters, 1120, 200, 0); // Add level 200 Healer Male
    addNewCharacter($saveData, $characters, 1130, 200, 0); // Add level 200 Healer Female
    addNewCharacter($saveData, $characters, 1140, 200, 0); // Add level 200 Scout
    addNewCharacter($saveData, $characters, 1150, 200, 0); // Add level 200 EDF Soldier
    addNewCharacter($saveData, $characters, 1160, 200, 0); // Add level 200 Angel
    addNewCharacter($saveData, $characters, 1170, 200, 0); // Add level 200 Rogue
    addNewCharacter($saveData, $characters, 1100, 200, 0); // Add level 200 Skull Fire
    addNewCharacter($saveData, $characters, 1101, 200, 0); // Add level 200 Skull Wind
    addNewCharacter($saveData, $characters, 1102, 200, 0); // Add level 200 Skull Ice
    addNewCharacter($saveData, $characters, 1103, 200, 0); // Add level 200 Star Skull
    addNewCharacter($saveData, $characters, 1104, 200, 0); // Add level 200 Prism Skull
    addNewCharacter($saveData, $characters, 1110, 200, 0); // Add level 200 Red Mage
    addNewCharacter($saveData, $characters, 1111, 200, 0); // Add level 200 Wind Mage
    addNewCharacter($saveData, $characters, 1112, 200, 0); // Add level 200 Blue Mage
    addNewCharacter($saveData, $characters, 1113, 200, 0); // Add level 200 Star Mage
    addNewCharacter($saveData, $characters, 1114, 200, 0); // Add level 200 Prism Mage

    // Increment number of characters in current party
    $save->updateSaveFile($saveData);
	$save->writeSaveFile($processed_directory . 'processed_' . $filename);
}

function forceDownload($filename, $processed_directory) {
    // Set headers for forcing a download
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: binary");
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

    readfile($processed_directory . 'processed_' . $filename);
}
closelog();
?>
