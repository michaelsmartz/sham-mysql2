<?php
/* parameters SQL SERVER*/
$mysql_serverName = 'LAPTOP-ASTV8JLD';
$mssql_databaseName = 'ShamTest';
$mssql_connection_string = 'DRIVER={SQL Server};SERVER='.$mysql_serverName.';DATABASE='.$mssql_databaseName;
$mssql_uid = 'sa12345';
$mssql_pwd = '12345678';

/* parameters MYSQL*/
$mysql_serverName = "localhost";
$mysql_uid = "root";
$mysql_pwd = "";
$mysql_databaseName = "ShamDev";

//to access .env
require __DIR__.'/../vendor/autoload.php'; //Load composer autoload
$dot = new \Dotenv\Dotenv(__DIR__.'/../'); //Location of .env
$dot->load(); //Load the configuration (Not override, for override use overload() method

//disk and directories where all medias from sql server are saved, path configured in .env
$disk = getenv('UPLOADS_STORAGE_PATH');
$directories = explode(',', getenv('UPLOADS_STORAGE_DIRECTORIES'));

//increase php script exec time
ini_set('max_execution_time', 0); //0 value disable the time limit

//to read bigger files
ini_set('odbc.defaultlrl', '15M');
ini_set('mssql.textlimit', '15M');
ini_set('mssql.textsize', '15M');


// Create sql server connection
$conn_mssql = odbc_connect($mssql_connection_string, $mssql_uid, $mssql_pwd);
if (!$conn_mssql) {
    die("Connection failed: " . $conn_mssql->connect_error);
}

// Create mysql connection
$conn_mysql = new mysqli($mysql_serverName, $mysql_uid, $mysql_pwd, $mysql_databaseName);
// Check connection
if ($conn_mysql->connect_error) {
    die("Connection failed: " . $conn_mysql->connect_error);
}

//remove disk base folder exist else create a new one
if (file_exists($disk)) {
    rrmdir($disk);
}
mkdir($disk, 0777, true);

//initially truncate both media and mediables tables
truncateResetAutoincrementMediaMediables($conn_mysql);

//create table media and mediables
updateCreateMedias($conn_mssql, $conn_mysql, $directories, $disk, $project_name, 'create');

//update table media
updateCreateMedias($conn_mssql, $conn_mysql, $directories, $disk, $project_name, 'update');


function updateCreateMedias($conn_mssql, $conn_mysql, $directories, $disk, $project_name, $type){
    //to be inserted in mediables as autoincrement media_id
    $media_id = 1;
    $morphTo = "";
    $varbinary = false;

    foreach($directories as $directory){

        //remove disk directory if exist else create a new one and only on create
        if($type ==="create"){
            if (file_exists($disk.$directory)) {
                rrmdir($disk.$directory);
            }
            mkdir($disk.$directory, 0777, true);
        }

        switch ($directory){
            case 'EmployeeAttachments':
                $mssql = "select EmployeeId as mediableId, 
                      OriginalFileName as filename,
                      Content as content, 
                      Comment as comment,
                      EmployeeAttachmentTypeId  as employeeAttachmentTypeId
                    from EmployeeAttachments
                    where Active !=0
                    and OriginalFileName is not null
                    and Content is not null
                    order by OriginalFileName Asc;
                    ";
                $morphTo = "Employee";
                $varbinary = true;
                break;
            case 'Evaluations':
                $mssql = "select AssessmentId as mediableId,
                    OriginalFileName as filename,
                    QaSample as content
                    from Evaluations
                    where Active !=0
                    and OriginalFileName is not null
                    and QaSample is not null
                    order by OriginalFileName Asc;
                    ";
                $morphTo = "ProductCategory";
                $varbinary = true;
                break;
            case 'LawDocuments':
                $mssql = "select LawId as mediableId,
                    Name as filename,
                    Content as content
                    from LawDocuments
                    where Name is not null
                    and Content is not null
                    order by Name Asc;
                    ";
                $morphTo = "Law";
                $varbinary = false;
                break;
            case 'PolicyDocuments':
                $mssql = "select PolicyId as mediableId,
                    Name as filename,
                    Content as content
                    from PolicyDocuments 
                    where Name is not null
                    and Content is not null
                    order by Name Asc;
                    ";
                $morphTo = "Policy";
                $varbinary = false;
                break;
            case 'TopicAttachments':
                $mssql = "select TopicId as mediableId,
                    OriginalFileName as filename,
                    Content as content
                    from TopicAttachments
                    where Active !=0
                    and OriginalFileName is not null
                    and Content is not null
                    order by OriginalFileName Asc;
                    ";
                $morphTo = "Topic";
                $varbinary = false;
                break;
        }

        /* Execute the query. */
        $rs = odbc_exec($conn_mssql, $mssql);

        if (!$rs)
        {
            die("Error in SQL");
        }

        //to increment to insert in mediable to simulate media_id
        $order = 1;

        /* Iterate through the result set printing a row of data upon each iteration.*/
        while(odbc_fetch_row($rs)) {
            $string = odbc_result($rs,"content");
            $mediable_id = odbc_result($rs,"mediableId");
            $filename = odbc_result($rs,"filename");

             if($directory == "EmployeeAttachments" && $type === "update"){
                 $comment = odbc_result($rs,"comment");
                 $employeeAttachmentTypeId = odbc_result($rs,"employeeAttachmentTypeId");
                 updateMedias($conn_mysql, $media_id, $comment, $employeeAttachmentTypeId);
             }
             else if($type === "create"){
                 $filename = checkFileExist($disk, $directory, $filename);

                 $file = $disk.$directory.DIRECTORY_SEPARATOR.$filename;

                 insertMediables($conn_mysql, $media_id, $mediable_id, $morphTo, $directory, $order);

                 if (base64ToFile($string, $file, $varbinary)) {
                     echo "***SUCCESS*** ". $filename. " was successfully saved to <b>". $file. "</b><br><br>\n";
                 } else {
                     echo "***ERROR*** ". $file. " was not saved to <b>". $file. "</b><br><br>\n";
                 }
             }

            $order++;
            $media_id++;
        }
    }

    //insert in media table
    if($type === "create"){
        //EXEC "php artisan media:import uploads" when uploads of files is completed
        //cd on project root NB: one directory back since script on same project
        chdir("..");
        $command = "php artisan media:import uploads";
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
function insertMediables($conn_mysql, $mediaId, $mediableId, $morphTo, $directory, $order){

    $mysql = "INSERT INTO mediables(media_id, mediable_type, mediable_id, tag, `order`) 
                 VALUES ($mediaId,
                     'App\\\\".$morphTo."',
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
 * convert data in database to file
 * @param $data
 * @param $output_file
 * @param $varbinary
 * @return bool|int|null
 */
function base64ToFile($data, $output_file, $varbinary) {
    $decoded = "";
    $result = null;

    //if column data is in varbinary we must base64_encode it first
    if($varbinary)
        $data = base64_encode($data);

    //if large file
    for ($i=0; $i < ceil(strlen($data)/256); $i++)
        $decoded = $decoded . base64_decode(substr($data,$i*256,256));

    $result = file_put_contents($output_file, $decoded);

    return $result;
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
        return $file_name.'_'.count(glob($disk.$directory.DIRECTORY_SEPARATOR."$file_name*.$file_ext")).'.'.$file_ext;
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
odbc_close($conn_mssql);
$conn_mysql->close();
