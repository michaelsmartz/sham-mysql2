<?php

namespace App;

class CsvData extends Model
{
    protected $table = 'csv_data';
    
    protected $fillable = ['csv_filename', 'csv_header', 'csv_data'];

    public static $dbFields = ['first_name', 'last_name', 'email', 'title', 'gender'];
}