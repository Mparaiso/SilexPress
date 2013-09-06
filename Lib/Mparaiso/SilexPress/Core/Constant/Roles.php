<?php

namespace Mparaiso\SilexPress\Core\Constant;

class Roles
{

    // capabilities
    const ROLE_ACTIVATE_PLUGINS = "ROLE_ACTIVATE_PLUGINS";
    const ROLE_DELETE_OTHERS_PAGES = "ROLE_DELETE_OTHERS_PAGES";
    const ROLE_DELETE_OTHERS_POSTS = "ROLE_DELETE_OTHERS_POSTS";
    const ROLE_DELETE_PAGES = "ROLE_DELETE_PAGES";
    const ROLE_DELETE_PLUGINS = "ROLE_DELETE_PLUGINS";
    const ROLE_DELETE_POSTS = "ROLE_DELETE_POSTS";
    const ROLE_DELETE_PRIVATE_PAGES = "ROLE_DELETE_PRIVATE_PAGES";
    const ROLE_DELETE_PRIVATE_POSTS = "ROLE_DELETE_PRIVATE_POSTS";
    const ROLE_DELETE_PUBLISHED_PAGES = "ROLE_DELETE_PUBLISHED_PAGES";
    const ROLE_DELETE_PUBLISHED_POSTS = "ROLE_DELETE_PUBLISHED_POSTS";
    const ROLE_EDIT_DASHBOARD = "ROLE_EDIT_DASHBOARD";
    const ROLE_EDIT_FILES = "ROLE_EDIT_FILES";
    const ROLE_EDIT_OTHERS_PAGES = "ROLE_EDIT_OTHERS_PAGES";
    const ROLE_EDIT_OTHERS_POSTS = "ROLE_EDIT_OTHERS_POSTS";
    const ROLE_EDIT_PAGES = "ROLE_EDIT_PAGES";
    const ROLE_EDIT_POSTS = "ROLE_EDIT_POSTS";
    const ROLE_EDIT_PRIVATE_PAGES = "ROLE_EDIT_PRIVATE_PAGES";
    const ROLE_EDIT_PRIVATE_POSTS = "ROLE_EDIT_PRIVATE_POSTS";
    const ROLE_EDIT_PUBLISHED_PAGES = "ROLE_EDIT_PUBLISHED_PAGES";
    const ROLE_EDIT_PUBLISHED_POSTS = "ROLE_EDIT_PUBLISHED_POSTS";
    const ROLE_EDIT_THEME_OPTIONS = "ROLE_EDIT_THEME_OPTIONS";
    const ROLE_EXPORT = "ROLE_EXPORT";
    const ROLE_IMPORT = "ROLE_IMPORT";
    const ROLE_LIST_USERS = "ROLE_LIST_USERS";
    const ROLE_MANAGE_CATEGORIES = "ROLE_MANAGE_CATEGORIES";
    const ROLE_MANAGE_LINKS = "ROLE_MANAGE_LINKS";
    const ROLE_MANAGE_OPTIONS = "ROLE_MANAGE_OPTIONS";
    const ROLE_MODERATE_COMMENTS = "ROLE_MODERATE_COMMENTS";
    const ROLE_PROMOTE_USERS = "ROLE_PROMOTE_USERS";
    const ROLE_PUBLISH_PAGES = "ROLE_PUBLISH_PAGES";
    const ROLE_PUBLISH_POSTS = "ROLE_PUBLISH_POSTS";
    const ROLE_READ_PRIVATE_PAGES = "ROLE_READ_PRIVATE_PAGES";
    const ROLE_READ_PRIVATE_POSTS = "ROLE_READ_PRIVATE_POSTS";
    const ROLE_READ = "ROLE_READ";
    const ROLE_REMOVE_USERS = "ROLE_REMOVE_USERS";
    const ROLE_SWITCH_THEMES = "ROLE_SWITCH_THEMES";
    const ROLE_UPLOAD_FILES = "ROLE_UPLOAD_FILES";
    const ROLE_CREATE_PRODUCT = "ROLE_CREATE_PRODUCT";

    // single site installation capabilities

    const ROLE_UPDATE_CORE = "ROLE_UPDATE_CORE";
    const ROLE_UPDATE_PLUGINS = "ROLE_UPDATE_PLUGINS";
    const ROLE_UPDATE_THEMES = "ROLE_UPDATE_THEMES";
    const ROLE_INSTALL_PLUGINS = "ROLE_INSTALL_PLUGINS";
    const ROLE_INSTALL_THEMES = "ROLE_INSTALL_THEMES";
    const ROLE_DELETE_THEMES = "ROLE_DELETE_THEMES";
    const ROLE_EDIT_PLUGINS = "ROLE_EDIT_PLUGINS";
    const ROLE_EDIT_THEMES = "ROLE_EDIT_THEMES";
    const ROLE_EDIT_USERS = "ROLE_EDIT_USERS";
    const ROLE_CREATE_USERS = "ROLE_CREATE_USERS";
    const ROLE_DELETE_USERS = "ROLE_DELETE_USERS";
    const ROLE_UNFILTERED_HTML = "ROLE_UNFILTERED_HTML";

    // role names

    const ROLE_SUBSCRIBER = "ROLE_SUBSCRIBER";
    const ROLE_CONTRIBUTOR = "ROLE_CONTRIBUTOR";
    const ROLE_AUTHOR = "ROLE_AUTHOR";
    const ROLE_EDITOR = "ROLE_EDITOR";
    const ROLE_ADMINISTRATOR = "ROLE_ADMINISTRATOR";
    const ROLE_SUPER_ADMIN = "ROLE_SUPER_ADMIN";


    public static function getRoles()
    {
        return array(
            self::ROLE_SUPER_ADMIN => array(
                self::ROLE_ADMINISTRATOR,
            ),
            self::ROLE_ADMINISTRATOR => array(
                self::ROLE_EDITOR,
                self::ROLE_CREATE_PRODUCT,
                self::ROLE_SWITCH_THEMES,
                self::ROLE_REMOVE_USERS,
                self::ROLE_PROMOTE_USERS,
                self::ROLE_MANAGE_OPTIONS,
                self::ROLE_LIST_USERS,
                self::ROLE_IMPORT,
                self::ROLE_EXPORT,
                self::ROLE_EDIT_THEME_OPTIONS,
                self::ROLE_EDIT_FILES,
                self::ROLE_EDIT_DASHBOARD,
                self::ROLE_DELETE_PLUGINS,
                self::ROLE_ACTIVATE_PLUGINS,
                self::ROLE_UPDATE_CORE,
                self::ROLE_UPDATE_PLUGINS,
                self::ROLE_UPDATE_THEMES,
                self::ROLE_INSTALL_PLUGINS,
                self::ROLE_INSTALL_THEMES,
                self::ROLE_DELETE_THEMES,
                self::ROLE_EDIT_PLUGINS,
                self::ROLE_EDIT_THEMES,
                self::ROLE_EDIT_USERS,
                self::ROLE_CREATE_USERS,
                self::ROLE_DELETE_USERS,
                self::ROLE_UNFILTERED_HTML,
            ),
            self::ROLE_EDITOR => array(
                self::ROLE_AUTHOR,
                self::ROLE_DELETE_OTHERS_PAGES,
                self::ROLE_DELETE_OTHERS_POSTS,
                self::ROLE_DELETE_PAGES,
                self::ROLE_DELETE_PRIVATE_PAGES,
                self::ROLE_DELETE_PRIVATE_POSTS,
                self::ROLE_UNFILTERED_HTML,
                self::ROLE_READ_PRIVATE_PAGES,
                self::ROLE_READ_PRIVATE_POSTS,
                self::ROLE_PUBLISH_POSTS,
                self::ROLE_PUBLISH_PAGES,
                self::ROLE_MODERATE_COMMENTS,
                self::ROLE_MANAGE_LINKS,
                self::ROLE_MANAGE_CATEGORIES,
                self::ROLE_EDIT_PRIVATE_PAGES,
                self::ROLE_EDIT_PRIVATE_POSTS,
                self::ROLE_EDIT_OTHERS_PAGES,
                self::ROLE_EDIT_OTHERS_POSTS,
                self::ROLE_DELETE_PUBLISHED_PAGES,
                self::ROLE_DELETE_PUBLISHED_POSTS),
            self::ROLE_AUTHOR => array(
                self::ROLE_CONTRIBUTOR,
                self::ROLE_DELETE_PUBLISHED_POSTS,
                self::ROLE_EDIT_PUBLISHED_POSTS,
                self::ROLE_PUBLISH_POSTS,
                self::ROLE_UPLOAD_FILES),
            self::ROLE_CONTRIBUTOR => array(
                self::ROLE_SUBSCRIBER,
                self::ROLE_DELETE_POSTS,
                self::ROLE_EDIT_POSTS),
            self::ROLE_SUBSCRIBER => array(
                self::ROLE_READ
            ),
        );
    }
}
