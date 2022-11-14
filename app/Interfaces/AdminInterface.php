<?php

namespace App\Interfaces;

interface Admin
{
    public function acceptReport();
    public function assignReport();
    public function getAllReports();
}