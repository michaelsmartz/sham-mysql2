<?php

include 'conn.php';

//to access .env
require __DIR__.'/../../vendor/autoload.php'; //Load composer autoload
$dot = new \Dotenv\Dotenv(__DIR__.'/../../'); //Location of .env
$dot->load(); //Load the configuration (Not override, for override use overload() method

//disk and directories where all medias from sql server are saved, path configured in .env
$disk = getenv('UPLOADS_STORAGE_PATH');

$directories = explode(',', getenv('UPLOADS_STORAGE_DIRECTORIES'));

//increase php script exec time
ini_set('max_execution_time', 0); //0 value disable the time limit
ini_set('pdo_odbc.client_buffer_max_kb_size','524288');

//to read bigger files
ini_set('odbc.defaultlrl', '15M');
ini_set('mssql.textlimit', '15M');
ini_set('mssql.textsize', '15M');


// Create sql server connection
try{
    $conn_mssql = new PDO(sprintf("odbc:DRIVER=freetds;SERVERNAME=%s;DATABASE=%s", $mssql_serverName, $mssql_databaseName), $mssql_uid, $mssql_pwd); 
}
catch(PDOException $e){
    echo $e->getMessage();
}

if (!$conn_mssql) {
    die("Connection failed: " . $conn_mssql->connect_error);
}

// Create mysql connection
$conn_mysql = new mysqli($mysql_serverName, $mysql_uid, $mysql_pwd, $mysql_databaseName);
// Check connection
if ($conn_mysql->connect_error) {
    die("Connection failed: " . $conn_mysql->connect_error);
}

//initially truncate both media and mediables tables
truncateResetAutoincrementMediaMediables($conn_mysql);

//create table media and mediables
updateCreateMedias($conn_mssql, $conn_mysql, $directories, $disk, 'create');

//update table media
updateCreateMedias($conn_mssql, $conn_mysql, $directories, $disk, 'update');


function updateCreateMedias($conn_mssql, $conn_mysql, $directories, $disk, $type){
	
    //to be inserted in mediables as autoincrement media_id
    $media_id = 1;
    $varbinary = false;
	$mssql = '';

    foreach($directories as $directory){

        switch ($directory){
			case 'Assessment':
                $mssql = "select AssessmentId as mediableId,
                    OriginalFileName as filename
                    from Evaluations
                    where Active !=0
                    and OriginalFileName is not null
                    and QaSample is not null
                    order by OriginalFileName Asc;
                    ";
                break;
            case 'Employee':
                $mssql = "select EmployeeId as mediableId, 
                      OriginalFileName as filename,
                      Comment as comment,
                      EmployeeAttachmentTypeId  as employeeAttachmentTypeId
                    from EmployeeAttachments
                    where Active !=0
                    and OriginalFileName is not null
                    and Content is not null
                    order by OriginalFileName Asc;
                    ";
                break;
            case 'Law':
                $mssql = "select LawId as mediableId,
                    Name as filename
                    from LawDocuments
                    where Name is not null
                    and Content is not null
                    order by Name Asc;
                    ";
                break;
            case 'Policy':
                $mssql = "select PolicyId as mediableId,
                    Name as filename
                    from PolicyDocuments 
                    where Name is not null
                    and Content is not null
                    order by Name Asc;
                    ";
                break;
            case 'Topic':
                $mssql = "select TopicId as mediableId,
                    OriginalFileName as filename
                    from TopicAttachments
                    where Active !=0
                    and OriginalFileName is not null
                    and Content is not null
                    order by OriginalFileName Asc;
                    ";
                break;
        }
		
		//$conn_mssql->setAttribute(PDO::MYSQL_ATTR_MAX_BUFFER_SIZE, 1024*1024*256);
		$conn_mssql->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
		
		/* Execute the query. */
		$pdo = $conn_mssql->prepare($mssql);
		$pdo->execute();
		
		//fetching data from mssql
		$datas = $pdo->fetchAll(PDO::FETCH_ASSOC);
	
		//to increment to insert in mediable to simulate media_id
		$order = 1;

		/* Iterate through the result set printing a row of data upon each iteration.*/
		//var_dump($datas);
	
		if($datas){
			foreach($datas as $data){
				//$string = $data["content"];
				$mediable_id = $data["mediableId"];
				$filename = $data["filename"];

				 if($directory == "Employee" && $type === "update"){
					 $comment = $data["comment"];
					 $employeeAttachmentTypeId = $data["employeeAttachmentTypeId"];
					 updateMedias($conn_mysql, $media_id, $comment, $employeeAttachmentTypeId);
				 }
				 else if($type === "create"){
					 $filename = checkFileExist($disk, $directory, $filename);
					 
					 var_dump($directory);

					 $file = $disk.$directory.DIRECTORY_SEPARATOR.$filename;

					 insertMediables($conn_mysql, $media_id, $mediable_id, $directory, $order);
				 }

				$order++;
				$media_id++;
			}
		}
    }

    //insert in media table
    if($type === "create"){
        //EXEC "php artisan media:import uploads" when uploads of files is completed
        //cd on project root NB: one directory back since script on same project
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

/**
 * check if file already exist in folder
 * if already exist add incrementing number
 * and return filename to be added in database
 * @param $disk
 * @param $directory
 * @param $filename
 * @return string
 */
function checkFileExist($disk, $directory, $filename)
{
    $files = glob($disk.$directory.DIRECTORY_SEPARATOR.$filename);
    if (count($files) > 0){
        $tmp = explode(".", $filename);
        $file_ext = end($tmp);
        $file_name = str_replace(('.'.$file_ext),"",$filename);
        return $file_name.'('.count(glob($disk.$directory.DIRECTORY_SEPARATOR."$file_name*.$file_ext")).').'.$file_ext;
    }
    else{
        return $filename;
    }
}

/**
 * remove uploads disk folder if already exist
 * @param $dir
 */
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir")
                    rrmdir($dir."/".$object);
                else unlink   ($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/* Free statement and connection resources. */
$conn_mysql->close();
