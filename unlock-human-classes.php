<?php
// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Define the target directory for uploads
    $target_dir = "uploads/";
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
            echo "The file ". htmlspecialchars(basename($file["name"])) ." has been uploaded successfully.";
            
            // Process the file and modify it as needed
            unlockAllClasses($hashed_filename, $target_dir);

            // Force download of the processed file
            forceDownload($hashed_filename, $target_dir);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Error: " . $_FILES['uploaded_file']['error'];
    }
} else {
    header('Location: upload.html');
}

function unlockAllClasses($filename, $directory) {
    if (!isset($filename)) {
		die("Usage: <original-SAVExxx.DAT> \nLists characters in savefile");
	} elseif (!file_exists($filename)) {
		die("Filename $filename not found\n");
	}

	$save		= new \Disgaea\SaveFile($filename);
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
    print($saveData->getChunk('charactercount'));
    print("-----------------------\n\n");
    $save->updateSaveFile($saveData);
	print "Writing save file...\n";
	$save->writeSaveFile($directory . 'processed_' . $filename);
	print "Done\n";
	print "\n\n";
}

function forceDownload($filename, $directory) {
    // Set headers for forcing a download
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: binary");
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

    readfile($directory . 'processed_' . $filename);
}

?>
