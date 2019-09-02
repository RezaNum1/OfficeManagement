<?php

namespace App\Service;


class MessageGenerator{
    public function getHappyMassage(){
        $message = [
            'Data Berhasil Di Ubah',
        ];

        $index = array_rand($message);
        return $message[$index];
    }
}