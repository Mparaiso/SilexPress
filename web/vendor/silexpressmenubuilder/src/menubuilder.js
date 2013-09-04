/**
 * EN: Menu Builder for silexpress administration<br>
 * dependencies: Ractive.js , jquery
 * FR: Menu Builder pour l'administration de SilexPress<br>
 * dépendences: Ractive.js;
 */
(function () {
    "use strict";
    this.MenuBuilder = Ractive.extend({
        data: {
            menu: {
                name: null,
                items: []
            },
            linkForm: {title: null, url: null},
            pages: [],
            categories: [],
            menus: [],
            selectedCategories: [],
            selectedPages: [],
            selectedMenus: [] },
        getPageById: function (id) {
            var pages = this.get("pages");
            return pages.filter(function (value) {
                return value.id == id;
            }).pop();
        },
        getCategoryById: function (id) {
            return this.get("categories").filter(function (value) {
                return value.id == id;
            }).pop();
        },
        init: function () {
            // events
            this.on({
                /** add pages to menu **/
                addSubMenuToMenu: function (event) {
                    var elements, i;
                    i = event.context.menu.items.length;
                    event.context.menus.filter(function (item) {
                        return event.context.selectedMenus.indexOf(item.id) >= 0;
                    }).map(function (item) {
                            return {post_id: item.id, label: item.title, title: item.title, menu_type: "menu"};
                        }
                    ).forEach(function (item) {
                            event.context.menu.items.push(item);
                        });
                    event.original.preventDefault();
                    event.original.stopPropagation();
                    return false;
                },
                addPageToMenu: function () {
                    var self = this;
                    var pages = this.get("pages").filter(function (item) {
                        return  self.get("selectedPages").indexOf(item.id) >= 0;
                    });
                    pages.forEach(function (page) {
                        self.get("menu.items").push({post_id: page.id, label: page.title, title: page.title, menu_type: "page"});
                    });
                    this.set("selectedPages", []);
                },
                /** add link to menu **/
                addLinkToMenu: function () {
                    var link = this.get("linkForm");
                    if (!link.url)return;
                    if (!link.title)link.title = link.url;
                    this.get("menu.items").push({post_id: null, target: link.target, url: link.url, label: link.title, title: link.title, menu_type: "link"});
                    this.set("linkForm", {});//empty link form
                },
                /** add category to menu **/
                addCategoryToMenu: function () {
                    var i, category, categories, selectedCategories, items, self;
                    self = this;
                    categories = this.get("categories");
                    selectedCategories = this.get("selectedCategories");
                    items = this.get("menu.items");
                    for (i = 0; i < selectedCategories.length; i++) {
                        category = this.getCategoryById(selectedCategories[i]);
                        this.get("menu.items").push({post_id: category.id, label: category.title, title: category.title, menu_type: "category"});
                    }
                    this.set("selectedCategories", []);
                },
                /** move item up in the list **/
                up: function (event) {
                    this.get("menu.items").splice(event.index.i, 1);
                    this.get("menu.items.").splice(event.index.i - 1, 0, event.context);
                    event.original.preventDefault();
                    event.original.stopPropagation();
                    return false;
                },
                /** move down item down in the list **/
                down: function (event) {
                    this.get("menu.items").splice(event.index.i, 1);
                    this.get("menu.items.").splice(event.index.i + 1, 0, event.context);
                    event.original.preventDefault();
                    event.original.stopPropagation();
                    return false;
                },
                /** remove an item **/
                remove: function (event) {
                    this.get("menu.items").splice(event.index.i, 1);
                    event.original.preventDefault();
                    event.original.stopPropagation();
                    return false;
                },
                selectAllPages: function (event) {
                    this.set("selectedPages", this.get("pages").map(function (item) {
                        return item.id;
                    }));
                },
                selectAllCategories: function (event) {
                    this.set("selectedCategories", this.get("categories").map(function (item) {
                        return item.id;
                    }));
                },
                selectAllSubMenus: function (event) {
                    console.log(arguments);
                    event.context.selectedSubMenus = event.context.menus.map(function (item) {
                        return item.id
                    });
                }
            });
        }
    });
}.apply(window));
