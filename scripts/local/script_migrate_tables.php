<?php

include 'conn.php';

//in order of foreign key
$tables = [
    //'Assessments',
    //'Employees',
    //"LawDocuments",
    //"LawCategories",
    //'Laws',
    //"PolicyDocuments",
    //"PolicyCategories",
    //'Policies',
    //'Topics',
    //"ShamUsers",
    "ReportTemplates"
];


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

renameTables($conn_mysql);

//TODO initially truncate tables
truncateResetAutoincrement($conn_mysql, $tables);

addMissingColumns($conn_mysql);

copyData($conn_mysql, $conn_mssql, $tables);

//setForeignKey($conn_mysql);

function renameTables($conn_mysql){
     $mysql = "rename table lawcategories to law_categories;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>succesful renamed</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }
    $mysql = "rename table lawdocuments to law_documents;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>succesful renamed</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }
}

function setForeignKey($conn_mysql){
    $mysql = "SET GLOBAL FOREIGN_KEY_CHECKS=1;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>FOREIGN KEY CHECK ENABLED</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }
}

/**
 * Initially all tables should be empty
 * @param $conn_mysql
 * @param $tables
 */
function truncateResetAutoincrement($conn_mysql, $tables){

    $mysql = "SET GLOBAL FOREIGN_KEY_CHECKS=0;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>FOREIGN KEY CHECK DISABLED</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }

    foreach ($tables as $table){

        $ltable =  ltrim(strtolower(preg_replace('/([A-Z]+)/', "_$1", $table)),'_');

        //truncate
        $mysql = "TRUNCATE TABLE $ltable;";
        if ($conn_mysql->query($mysql) === TRUE) {
            echo "<b>$ltable truncated successfully</b><br><br>";
        } else {
            echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
        }
        //reset autoincrement
        $mysql = "ALTER TABLE $ltable AUTO_INCREMENT = 1;";
        if ($conn_mysql->query($mysql) === TRUE) {
            echo "<b>$ltable autoincrement reset successfully</b><br>";
        } else {
            echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
        }
    }
}

//add missing columns
function addMissingColumns($conn_mysql){

    $mysql = "ALTER TABLE laws
            ADD COLUMN `deleted_at` datetime,
            ADD COLUMN `updated_by` varchar(100),
            ADD COLUMN `updated_when` datetime;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>Column add successfully</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }


    $mysql = "ALTER TABLE policies
            ADD COLUMN `deleted_at` datetime,
            ADD COLUMN `updated_by` varchar(100),
            ADD COLUMN `updated_when` datetime;";
    if ($conn_mysql->query($mysql) === TRUE) {
        echo "<b>Column add successfully</b><br>";
    } else {
        echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
    }
}

/**
 * copy data from old mssql data to new mysql database for the array of tables
 * @param $conn_mysql
 * @param $conn_mssql
 * @param $tables
 */
function copyData($conn_mysql, $conn_mssql, $tables){

    foreach ($tables as $table) {
        $mssql = "select * from $table";

        /* Execute the query. */
        $rs = odbc_exec($conn_mssql, $mssql);

        if (!$rs) {
            die("Error in SQL");
        }

        //fetching data from mssql
        $datas = fetch2DArray($rs);
        insertData($conn_mysql, $datas, $table);
    }
}

/**
 * obtain mssql in form of an array
 * @param $res
 * @return array
 */
function fetch2DArray($res){
    $i = 0;
    $ar = [];
    $toReturn = [];

    while(odbc_fetch_row($res))
    {
        for ($j = 1; $j <= odbc_num_fields($res); $j++)
        {
            $field_name = odbc_field_name($res, $j);
            $ar[$field_name] = odbc_result($res, $field_name);
        }

        $toReturn[$i] = $ar;
        $i++;
    }
    return $toReturn;
}

function insertData($conn_mysql, $datas, $table){

    foreach($datas as $data){
        $fields = "";
        $values = "";

        foreach ($data as $key=>$value){
            //special cases
            if($key === 'Active')
                $key = 'is_active';
            if($key === 'Public')
                $key = 'is_public';
            if($key === 'Active')
                $key = 'is_active';
            if($key === 'ExpiryDate')
                $key = 'expires_on';
            if($key === 'Order')
                $key = "`order`";
            if($key === 'Source')
                $key = "`source`";
            if($key === 'ShamUserProfileId' || $key ==='LawId') {
                $fields .= $key.',';
            }else{
                $fields .= ltrim(strtolower(preg_replace('/([A-Z]+)/', "_$1", $key)), '_') . ',';
            }

            $values .= ($key === 'UpdatedWhen' || $key === 'EmployeeId' || $key === '`order`' ||
                        $key === 'ShamUserProfileId' || $key === 'is_public')?'null'.',':"'".$value."'".',';
        }

        $fields = rtrim($fields,',');
        $values =  rtrim($values,',');

        $ltable =  ltrim(strtolower(preg_replace('/([A-Z]+)/', "_$1", $table)),'_');

        $mysql = "INSERT INTO $ltable($fields) VALUES ($values)";
        if ($conn_mysql->query($mysql) === TRUE) {
            echo "New record created successfully<br><br>";
        } else {
            echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
        }
    }
}