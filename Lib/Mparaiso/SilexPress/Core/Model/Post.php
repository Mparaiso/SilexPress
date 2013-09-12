<?php
namespace Mparaiso\SilexPress\Core\Model;


class Post extends Base
{
    /*
        protected $id; //wordpress id
        protected $post_author;
        protected $post_date;
        protected $post_date_gmt;
        protected $post_content;
        protected $post_title;
        protected $post_excerpt;
        protected $post_status;
        protected $comment_status;
        protected $ping_status;
        protected $post_password;
        protected $post_name;
        protected $to_ping;
        protected $pinged;
        protected $post_modified;
        protected $post_content_filtered;
        protected $post_parent;
        protected $guid;
        protected $menu_order;
        protected $post_type;
        protected $post_mime_type;
        protected $comment_count;
    */

    public function setCommentCount($comment_count)
    {
        $this->__set("comment_count", $comment_count);
    }

    public function getCommentCount()
    {
        return $this->__get("comment_count");
    }

    public function setCommentStatus($comment_status)
    {
        $this->__set("comment_status", $comment_status);
    }

    public function getCommentStatus()
    {
        return $this->__get("comment_status");
    }

    public function setGuid($guid)
    {
        $this->__set("guid", $guid);
    }

    public function getGuid()
    {
        return $this->__get("guid");
    }


    public function setMenuOrder($menu_order)
    {
        $this->__set("menu_order", $menu_order);
    }

    public function getMenuOrder()
    {
        return $this->__get("menu_order");
    }

    public function setPingStatus($ping_status)
    {
        $this->__set("ping_status", $ping_status);
    }

    public function getPingStatus()
    {
        return $this->__get("ping_status");
    }

    public function setPinged($pinged)
    {
        $this->__set("pinged", $pinged);
    }

    public function getPinged()
    {
        return $this->__get("pinged");
    }

    public function setPostAuthor($post_author)
    {
        $this->__set("post_author", $post_author);
    }

    public function getPostAuthor()
    {
        return $this->__get("post_author");
    }

    public function setPostContent($post_content)
    {
        $this->__set("post_content", $post_content);
    }

    public function getPostContent()
    {
        return $this->__get("post_content");
    }

    public function setPostContentFiltered($post_content_filtered)
    {
        $this->__set("post_content_filtered", $post_content_filtered);
    }

    public function getPostContentFiltered()
    {
        return $this->__get("post_content_filtered");
    }

    public function setPostDate($post_date)
    {
        $this->__set("post_date", $post_date);
    }

    public function getPostDate()
    {
        $d = $this->__get("post_date");
        if ($d)
            return $d->sec;
    }

    public function setPostDateGmt($post_date_gmt)
    {
        $this->__set("post_date_gmt", $post_date_gmt);
    }

    public function getPostDateGmt()
    {
        return $this->__get("post_date_gmt");
    }

    public function setPostExcerpt($post_excerpt)
    {
        $this->__set("post_excerpt", $post_excerpt);
    }

    public function getPostExcerpt()
    {
        return $this->__get("post_excerpt");
    }

    public function setPostMimeType($post_mime_type)
    {
        $this->__set("post_mime_type", $post_mime_type);
    }

    public function getPostMimeType()
    {
        return $this->__get("post_mime_type");
    }

    public function setPostModified($post_modified)
    {
        $this->__set("post_modified", $post_modified);
    }

    public function getPostModified()
    {
        return $this->__get("post_modified");
    }

    public function setPostName($post_name)
    {
        $this->__set("post_name", $post_name);
    }

    public function getPostName()
    {
        return $this->__get("post_name");
    }

    public function setPostParent($post_parent)
    {
        $this->__set("post_parent", $post_parent);
    }

    public function getPostParent()
    {
        return $this->__get("post_parent");
    }

    public function setPostPassword($post_password)
    {
        $this->__set("post_password", $post_password);
    }

    public function getPostPassword()
    {
        return $this->__get("post_password");
    }

    public function setPostStatus($post_status)
    {
        $this->__set("post_status", $post_status);
    }

    public function getPostStatus()
    {
        return $this->__get("post_status");
    }

    public function setPostTitle($post_title)
    {
        $this->__set("post_title", $post_title);
    }

    public function getPostTitle()
    {
        return $this->__get("post_title");
    }

    public function setPostType($post_type)
    {
        $this->__set("post_type", $post_type);
    }

    public function getPostType()
    {
        return $this->__get("post_type");
    }

    public function setToPing($to_ping)
    {
        $this->__set("to_ping", $to_ping);
    }

    public function getToPing()
    {
        return $this->__get("to_ping");
    }

    function __toString()
    {
        return (string)$this->getPostTitle();
    }

}
