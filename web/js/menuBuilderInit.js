/**
 * init silexpress menu builder
 */
$(function () {
    "use strict";
    var pages, categories, menus, menuBuilderTemplate, menuBuilder, menu_post_meta, data, menu_post_title;
    menu_post_meta = $("#menu_post_meta");
    // load pages,cats,menus,and templates
    $.when($.getJSON("/admin/api/page"),
            $.getJSON("/admin/api/menu"),
            $.getJSON("/admin/api/category"),
            $.get("/vendor/silexpressmenubuilder/src/menubuilder.mustache")
        ).done(
        function (data_page, data_menu, data_category, data_template) {
            categories = data_category[0].categories.map(function (item) {
                return {title: item.name, id: item._id.$id};
            });
            menus = data_menu[0].menus.filter(function (item) {
                return true;
            }).map(function (item) {
                    return {id: item._id.$id, title: item.post_title};
                });
            pages = data_page[0].pages.map(function (item) {
                return {title: item.post_title, id: item._id.$id};
            });
            // load menuBuilder template
            menuBuilderTemplate = data_template[0];
            // init menuBuilder
            menuBuilder = new MenuBuilder({template: menuBuilderTemplate, el: "#menuBuilder"});
            // if menu_post_meta not empty and valid json , init menu.items datas with menu_post_meta value
            if (menu_post_meta.val() != null) {
                try {
                    data = JSON.parse(menu_post_meta.val());
                    menuBuilder.set("menu.items", data.items);
                } catch (e) {
                    console.log(e);
                }
            }
            menuBuilder.set("menus", menus);
            menuBuilder.set("pages", pages);
            menuBuilder.set("categories", categories);
            menuBuilder.observe("menu.items", function (old, new_) {
                if (!new_)new_ = old;
                menu_post_meta.val(JSON.stringify({items: new_}));
            });
        })
});