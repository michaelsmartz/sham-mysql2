<?php

include 'conn.php';

$msTable = "ShamUsers";

$mysqlTable = 'users';

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

copyData($conn_mysql, $conn_mssql, $msTable, $mysqlTable);


/**
 * copy data from old mssql data to new mysql database for the array of tables
 * @param $conn_mysql
 * @param $conn_mssql
 * @param $msTable
 * @param $mysqlTable
 */
function copyData($conn_mysql, $conn_mssql, $msTable, $mysqlTable){

    $mssql = "select * from $msTable";

    /* Execute the query. */
    $rs = odbc_exec($conn_mssql, $mssql);

    if (!$rs) {
        die("Error in SQL");
    }

    //fetching data from mssql
    $datas = fetch2DArray($rs);
    insertData($conn_mysql, $datas, $mysqlTable);
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

function insertData($conn_mysql, $datas, $mysqlTable){

    foreach($datas as $data){
        $fields = "";
        $values = "";

        foreach ($data as $key=>$value){
            //special cases
            if($key === 'Active')
                $key = 'is_active';

            if($key === 'DateCreated')
                $key = 'created_at';

            if($key === 'EmailAddress')
                $key = 'email';

            if($key === 'Active')
                $key = 'is_active';

            $fields .= ltrim(strtolower(preg_replace('/([A-Z]+)/', "_$1", $key)), '_') . ',';

            $values .= ($key === 'ShamUserProfileId' || $key === 'EmployeeId')?'null'.',':"'".$value."'".',';
        }

        $fields = rtrim($fields,',');
        $values =  rtrim($values,',');


        $mysql = "INSERT INTO $mysqlTable($fields) VALUES ($values)";
        if ($conn_mysql->query($mysql) === TRUE) {
            echo "New record created successfully<br><br>";
        } else {
            echo "Error: " . $mysql . "<br>" . $conn_mysql->error;
        }
    }
}