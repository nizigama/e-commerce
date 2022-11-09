<?php

namespace App\Classes;

class User
{

    public function __construct(
        public string $email,
        public ?string $names = null,
        public ?string $password = null,
        public ?int $id = null,
    ) {
    }
}
