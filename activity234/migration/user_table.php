<?php

include '../database/db.php';

class UserMigration extends Database
{
    public function createTable()
    {
        $this->conn->query('CREATE TABLE IF NOT EXISTS user(
            id int primary key auto_increment,
            fname varchar(255) not null,
            lname varchar(255) not null,
            gender varchar(255) not null,
            age varchar(255) not null
        )');
    }
}

?>