/**
 * init silexpress menu builder
 */
$(function () {
    "use strict";
    var pages, categories, menuBuilderTemplate, menuBuilder, menu_post_meta, data;
    menu_post_meta = $("#menu_post_meta");
    // load pages
    $.getJSON("/admin/api/page").success(function (data) {
        pages = data.pages;
        // load categories
    }).then($.getJSON("/admin/api/category").success(function (data) {
            categories = data.categories;
            // load menuBuilder template
        }).then(function () {
                $.get("/vendor/silexpressmenubuilder/src/menubuilder.mustache").success(function (data) {
                    menuBuilderTemplate = data;
                    // init menuBuilder
                }).then(function () {
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
                        menuBuilder.set("pages", pages.map(function (item) {
                            return {title: item.post_title, id: item._id.$id};
                        }));
                        menuBuilder.set("categories", categories.map(function (item) {
                            return {title: item.name, id: item._id.$id};
                        }));
                        menuBuilder.observe("menu.items", function (old, new_) {
                            menu_post_meta.val(JSON.stringify({items: new_}));
                        });
                    });
            })
        );
});