<?php
namespace Model\Entity {
    class Post extends Base
    {
        protected $ID;
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
    }
}