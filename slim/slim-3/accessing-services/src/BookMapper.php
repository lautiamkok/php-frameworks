<?php

class BookMapper
{
    protected $Pdo;

    public function __construct(PDO $Pdo)
    {
        // Set dependency.
        $this->Pdo = $Pdo;
    }
}
