<?php 

//Read procedures csv
function procedures(){
    $rows = [];

    if (($handle = fopen(__DIR__."/procedures.csv","r")) !== FALSE) {
        while (($data = fgetcsv($handle)) !== FALSE){
            $rows[] = $data;
        }
        fclose($handle);
    }

    //Insert procedures into their own array
    $procedures = [];
    for ($i = 1; $i < count($rows); $i++){
        $procedures[] = [$rows[$i][0], $rows[$i][3]];
    }

    return $procedures;
}

//Sort final csv function
function sortCSV(){
        $rows = [];

    if (($handle = fopen("patientHistory.csv", "r")) !== false) {
        while (($data = fgetcsv($handle)) !== false) {
            $rows[] = $data;
        }
        fclose($handle);
    }

    // Save the header
    $header = array_shift($rows);

    // Sort by first column (Patient_ID) and third column (Date)
    usort($rows, function($a, $b) {
        // Sort by first column (Patient_ID)
        $result = $a[0] <=> $b[0];

        // If Patient_IDs are equal, sort by third column (Date)
        if ($result === 0) {
            return strcmp($a[2], $b[2]);
        }

        return $result;
    });

    // Write the sorted CSV
    $handle = fopen("patientHistory.csv", "w");

    fputcsv($handle, $header);

    foreach ($rows as $row) {
        fputcsv($handle, $row);
    }

    fclose($handle);
}

//Driver function to create patient history csv
function patientHistory(){
    //Create variable stores
    $procedure_IDs = procedures();
    $notes = ["Routine follow-up", "No complications", "Medication adjusted", "Patient improving", "Lab results reviewed"];

    //Open file
    $file = fopen(__DIR__ ."/patientHistory.csv","w");

    //Add headers
    fputcsv($file, [
        "Patient_ID","Procedure_ID","Date","Amount Billed","Amount Owed","Notes"
    ]);


    //Create patient history entries
    for ($i = 1; $i <= 120; $i++){
        $patient = $i;
        $procedure = $procedure_IDs[rand(0, count($procedure_IDs) -1)];
        $date = date("Y-m-d", rand(strtotime("2023-01-01"), strtotime("today")));
        $billed = $procedure[1] + rand(50, 300);
        $owed = rand(0, $billed);
        $note = $notes[rand(0, count($notes) -1)];

        fputcsv($file, [
            $patient, $procedure[0], $date, "$".$billed, "$".$owed, $note
        ]);
    }

    for ($i = 0; $i <= 25; $i++){
        $patient = rand(1, 120);
        $procedure = $procedure_IDs[rand(0, count($procedure_IDs) -1)];
        $date = date("Y-m-d", rand(strtotime("2023-01-01"), strtotime("today")));
        $billed = $procedure[1] + rand(50, 300);
        $owed = rand(0, $billed);
        $note = $notes[rand(0, count($notes) -1)];

        fputcsv($file, [
            $patient, $procedure[0], $date, "$".$billed, "$".$owed, $note
        ]);
    }
    fclose($file);
}

//Execute functions and produce final csv
patientHistory();
sortCSV();