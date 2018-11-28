<?php

include 'conn.php';

//to access .env
require __DIR__.'/../../vendor/autoload.php'; //Load composer autoload
$dot = new \Dotenv\Dotenv(__DIR__.'/../../'); //Location of .env
$dot->load(); //Load the configuration (Not override, for override use overload() method

//disk and directories where all medias from sql server are saved, path configured in .env
$disk = getenv('UPLOADS_STORAGE_PATH');
$config = getenv('UPLOADS_STORAGE_CONFIG_PATH');

//increase php script exec time
ini_set('max_execution_time', 0); //0 value disable the time limit
ini_set('pdo_odbc.client_buffer_max_kb_size','524288');

//to read bigger files
ini_set('odbc.defaultlrl', '15M');
ini_set('mssql.textlimit', '15M');
ini_set('mssql.textsize', '15M');

// Create mysql connection
$conn_mysql = new mysqli($mysql_serverName, $mysql_uid, $mysql_pwd, $mysql_databaseName);
// Check connection
if ($conn_mysql->connect_error) {
    die("Connection failed: " . $conn_mysql->connect_error);
}

//initially truncate both media and mediables tables
truncateResetAutoincrementMediaMediables($conn_mysql);

//create table media and mediables
updateCreateMedias($conn_mysql, $disk, $config, 'create');
updateCreateMedias($conn_mysql, $disk, $config, 'update');

function updateCreateMedias($conn_mysql, $disk, $config, $type){

    //to be inserted in mediables as autoincrement media_id
    $media_id = 1;

    $allFiles = scandir($disk);
    $directories = array_diff($allFiles, array('.', '..'));

    foreach($directories as $directory){

        $file = $config.DIRECTORY_SEPARATOR."$directory.txt";
        if(file_exists($file)) {
            $order = 1;
            $handle = fopen($file, "r");

            if ($handle) {
                $rows = [];
                $header = fgetcsv($handle);
                while ($row = fgetcsv($handle)) {
                    $rows[] = array_combine($header, $row);
                }
                fclose($handle);

            } else {
                // error opening the file.
                die("Error opening the file $directory.txt");
            }

            if($rows) {
                foreach($rows as $row) {
                    $mediable_id = $row["mediableid"];

                    //to increment to insert in mediable to simulate media_id
                    if ($directory == "Employee" && $type === "update") {
                        $comment = $row["comment"];
                        $employeeAttachmentTypeId = $row["extrable_id"];
                        updateMedias($conn_mysql, $media_id, $comment, $employeeAttachmentTypeId);
                    } else if ($type === "create") {
                        insertMediables($conn_mysql, $media_id, $mediable_id, $directory, $order);
                    }
                    $media_id++;
                    $order++;
                }
            }
        }
    }


    //insert in media table
    if($type === "create"){
        //EXEC "php artisan media:import uploads" when uploads of files is completed
        //cd on project root NB: one directory back since script on same project
		exec("cd ..");
		exec("cd ..");
        $command = "php artisan media:sync uploads";
        exec($command, $output);
        print_r($output);
        echo '<br>';
    }
}

/**
 * initially both media and mediables table should be empty
 * @param $conn_mysql
 */
function truncateResetAutoincrementMediaMediables($conn_mysql){
	
	$mysql = "SET FOREIGN_KEY_CHECKS=0;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>FOREIGN KEY CHECK DISABLED</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }

    $tables = [
        'media',
        'mediables'
    ];

    foreach ($tables as $table){
        //truncate
        $mysql = "TRUNCATE TABLE $table;";
        if ($conn_mysql->query($mysql) === TRUE) {
            echo "<b>Media $table truncated successfully</b><br><br>";
        } else {
            echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
        }
        //reset autoincrement
        $mysql = "ALTER TABLE $table AUTO_INCREMENT = 1;";
        if ($conn_mysql->query($mysql) === TRUE) {
            echo "<b>Media $table autoincrement reset successfully</b><br>";
        } else {
            echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
        }
    }
	
	
	$mysql = "SET GLOBAL FOREIGN_KEY_CHECKS=1;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>FOREIGN KEY CHECK ENABLED</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }
	
	$mysql = "Alter table media DROP INDEX media_disk_directory_filename_extension_unique;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>FOREIGN KEY CHECK ENABLED</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }
}

/**
 * on 2nd loop update table media after
 * command: php artisan media:import uploads is executed
 * @param $conn_mysql
 * @param $media_id
 * @param $comment
 * @param $extrable_id
 */
function updateMedias($conn_mysql, $media_id, $comment, $extrable_id){
    $sql = "UPDATE media SET comment='".$comment."', extrable_id=$extrable_id, extrable_type='App\\\\EmployeeAttachmentType' WHERE id=$media_id";

    if ($conn_mysql->query($sql) === TRUE) {
        echo "Media Record updated successfully<br><br>";
    } else {
        echo "Error updating record: " . $conn_mysql->error ."<br><br>";
    }
}

/**
 * insert in mediables table
 * @param $conn_mysql
 * @param $mediaId
 * @param $mediableId
 * @param $morphTo
 * @param $directory
 * @param $order
 */
function insertMediables($conn_mysql, $mediaId, $mediableId, $directory, $order){

    $mysql = "INSERT INTO mediables(media_id, mediable_type, mediable_id, tag, `order`) 
                 VALUES ($mediaId,
                     'App\\\\".$directory."',
                     $mediableId,
                     '".$directory."',
                     $order
                 )";

    if ($conn_mysql->query($mysql) === TRUE) {
        echo "New mediables record ID:$mediaId created successfully<br><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }
}

/* Free statement and connection resources. */
$conn_mysql->close();
