<?php
namespace Mparaiso\SilexPress\Admin\Media\Service;

use Mparaiso\SilexPress\Core\Service\Base as BaseService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Upload extends BaseService
{

    protected $mongoDB;
    protected $tempDir;
    protected $attachmentService;
    protected $attachmentClass;

    function __construct(\MongoDB $mongoDB, $tempDir, BaseService $attachmentService, $attachmentClass)
    {
        $this->mongoDB = $mongoDB;
        $this->tempDir = $tempDir;
        $this->attachmentService = $attachmentService;
        $this->attachmentClass = $attachmentClass;
    }


    function upload(UploadedFile $file)
    {
        /* http://stackoverflow.com/questions/16150875/symfony-2-2-upload-files */
        $fileName = $file->getRealPath();
        $gridFS = $this->mongoDB->getGridFS();
        $post_meta = array(
            "type" => $file->getMimeType(),
            "extension" => $file->getExtension(),
            "name" => $file->getFilename(),
            "date" => $file->getCTime(),
            "size" => $file->getSize(),
            "owner" => $file->getOwner()
        );
        $id = $gridFS->storeFile($fileName, $post_meta);
        $model = new $this->attachmentClass(
            array(
                "post_title" => $file->getClientOriginalName(),
                "post_date" => new \MongoDate(),
                "post_modified" => new \MongoDate(),
                "post_status" => "inherit",
                "comment_status" => "open",
                "ping_status" => "open",
                "post_name" => $file->getClientOriginalName(),
                "guid" => $id,
                "post_type" => "attachment",
                "post_mime_type" => $file->getClientMimeType(),
                "post_meta" => $post_meta
            )
        );
        $this->attachmentService->persist($model);
        return $model;
    }

    /**
     * return all the uploaded files
     */
    function findAll()
    {
        return $this->attachmentService->findBy(array("post_type" => "attachment"));
    }

    /* find a file by id */
    function serve($id)
    {
        return $this->mongoDB->getGridFS()->findOne(array("_id" => new \MongoId($id)));
    }

}
