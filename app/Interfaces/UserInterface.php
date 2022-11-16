<?php

namespace App\Interfaces;

interface UserInterface
{
    public function register();
    public function login();
    public function logout();
    public function getProfile();
    public function updateProfile();
    public function respondWithToken($token);
}