<?php

namespace App\Help;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{

    public function __construct(private SluggerInterface $slugger) {}


    public function upload(UploadedFile $file,$name,$dir): string
    {

        $name = $this->slugger->slug( $name).'-'.uniqid().'.'.$file->guessExtension();
        $file->move($dir,$name);
        return $name;

    }
}