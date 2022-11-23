<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;

class CustomerRepository extends UsersRepository
{
    public function createReport()
    {
        $validate = request()->validate([
            'facility' => 'required',
            'location' => 'required',
            'issue' => 'required',
            'proof' => 'required|file|max:1024'
        ], [
            'max' => 'Ukuran berkas maksimal 1 MB'
        ]);
        return $validate;
    }
}