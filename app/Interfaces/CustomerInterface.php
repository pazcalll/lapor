<?php

namespace App\Interfaces;

interface CustomerInterface
{
    public function createReport();
    public function updateReport();
    public function getReports();
    public function getReport();
}