<?php
namespace Mparaiso\SilexPress\Core\Model {


    class Post extends Base
    {
        protected $ID;//wordpress id
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

        public function setID($ID)
        {
            $this->ID = $ID;
        }

        public function getID()
        {
            return $this->ID;
        }

        public function setCommentCount($comment_count)
        {
            $this->comment_count = $comment_count;
        }

        public function getCommentCount()
        {
            return $this->comment_count;
        }

        public function setCommentStatus($comment_status)
        {
            $this->comment_status = $comment_status;
        }

        public function getCommentStatus()
        {
            return $this->comment_status;
        }

        public function setGuid($guid)
        {
            $this->guid = $guid;
        }

        public function getGuid()
        {
            return $this->guid;
        }

        public function setMenuOrder($menu_order)
        {
            $this->menu_order = $menu_order;
        }

        public function getMenuOrder()
        {
            return $this->menu_order;
        }

        public function setPingStatus($ping_status)
        {
            $this->ping_status = $ping_status;
        }

        public function getPingStatus()
        {
            return $this->ping_status;
        }

        public function setPinged($pinged)
        {
            $this->pinged = $pinged;
        }

        public function getPinged()
        {
            return $this->pinged;
        }

        public function setPostAuthor($post_author)
        {
            $this->post_author = $post_author;
        }

        public function getPostAuthor()
        {
            return $this->post_author;
        }

        public function setPostContent($post_content)
        {
            $this->post_content = $post_content;
        }

        public function getPostContent()
        {
            return $this->post_content;
        }

        public function setPostContentFiltered($post_content_filtered)
        {
            $this->post_content_filtered = $post_content_filtered;
        }

        public function getPostContentFiltered()
        {
            return $this->post_content_filtered;
        }

        public function setPostDate($post_date)
        {
            $this->post_date = $post_date;
        }

        public function getPostDate()
        {
            return $this->post_date;
        }

        public function setPostDateGmt($post_date_gmt)
        {
            $this->post_date_gmt = $post_date_gmt;
        }

        public function getPostDateGmt()
        {
            return $this->post_date_gmt;
        }

        public function setPostExcerpt($post_excerpt)
        {
            $this->post_excerpt = $post_excerpt;
        }

        public function getPostExcerpt()
        {
            return $this->post_excerpt;
        }

        public function setPostMimeType($post_mime_type)
        {
            $this->post_mime_type = $post_mime_type;
        }

        public function getPostMimeType()
        {
            return $this->post_mime_type;
        }

        public function setPostModified($post_modified)
        {
            $this->post_modified = $post_modified;
        }

        public function getPostModified()
        {
            return $this->post_modified;
        }

        public function setPostName($post_name)
        {
            $this->post_name = $post_name;
        }

        public function getPostName()
        {
            return $this->post_name;
        }

        public function setPostParent($post_parent)
        {
            $this->post_parent = $post_parent;
        }

        public function getPostParent()
        {
            return $this->post_parent;
        }

        public function setPostPassword($post_password)
        {
            $this->post_password = $post_password;
        }

        public function getPostPassword()
        {
            return $this->post_password;
        }

        public function setPostStatus($post_status)
        {
            $this->post_status = $post_status;
        }

        public function getPostStatus()
        {
            return $this->post_status;
        }

        public function setPostTitle($post_title)
        {
            $this->post_title = $post_title;
        }

        public function getPostTitle()
        {
            return $this->post_title;
        }

        public function setPostType($post_type)
        {
            $this->post_type = $post_type;
        }

        public function getPostType()
        {
            return $this->post_type;
        }

        public function setToPing($to_ping)
        {
            $this->to_ping = $to_ping;
        }

        public function getToPing()
        {
            return $this->to_ping;
        }


    }
}