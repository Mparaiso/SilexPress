<?php
namespace Mparaiso\SilexPress\Admin\Media\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Upload
{

    protected $mongoDB;
    protected $tempDir;

    function __construct(\MongoDB $mongoDB, $tempDir)
    {
        $this->mongoDB = $mongoDB;
        $this->tempDir = $tempDir;
    }


    function upload(UploadedFile $file)
    {
        /* http://stackoverflow.com/questions/16150875/symfony-2-2-upload-files */
        $fileName = $file->getRealPath();
        $gridFS = $this->mongoDB->getGridFS();
        $id = $gridFS->storeFile($fileName, array(
            "name" => $file->getClientOriginalName(),
            "type" => $file->getClientMimeType(),
            "size" => $file->getClientSize(),
            "created" => new \MongoDate()
        ));
        return $id;
    }

    /**
     * return all the uploaded files
     */
    function findAll()
    {
        return $this->mongoDB->getGridFS()->find();
    }

    /* find a file by id */
    function serve($id)
    {
        return $this->mongoDB->getGridFS()->findOne(array("_id" => new \MongoId($id)));
    }
}
