<?php

namespace Mparaiso\SilexPress\Admin\Media\Service;

use Mparaiso\SilexPress\Core\Service\Post;

class Attachment extends Post
{
    protected $posttype = "attachment";

    function count(array $query = array("post_type" => "attachment"))
    {
        return parent::count($query);
    }
}
