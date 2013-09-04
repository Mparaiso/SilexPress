/**
 * copyright M.Paraiso
 * license MIT
 * @module Charge
 * @author M.Paraiso
 * @version 0.0.1
 * FR : Charge est un script qui simplifie le chargement de resources javascript.
 * Charge télécharge en série une série de resources telles que :
 * - des images via l'object image
 * - des fichiers javascript via des balises scripts
 * - des fichiers coffeescript évalués au chargement
 * - n'importe quelle resource text via AJAX
 * EN: Charge is a library that handles resource loading
 * exemple :
 *  Charge.load(["underscore.js","backbone.js"],function success(resources){
 *      console.log("All the resources are loaded");
 *  });
 * @
 */
(function (ns) {
    "use strict";

    var jsRegExp = /^.+\.js$/i;
    var coffeeRegExp = /^.+\.coffee$/i;
//    var jsonRegExp = /^.+\.json$/i;
//    var xmlRegExp = /^.+\.xml$/i;
    var imageRegExp = /^.+\.(jpg|jpeg|png|gif|webp)$/i;
    var C = {};
    C.TEXT = "text";
    C.JAVASCRIPT = "javascript";
    C.COFFEESCRIPT = "coffeescript";
    C.IMAGE = "image";
    C.loadedResources = {};
    /**
     *
     * @param url {string}
     * @param method {string}
     * @param success {function}
     * @param error {function}
     * @return {XMLHttpRequest}
     */
    C.getXHR = function (url, method, content, success, error) {
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function (event) {
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                success(xmlHttp.responseText, event, xmlHttp);
            }
        };
        xmlHttp.open(method, url);
        xmlHttp.send(content);
        return xmlHttp;
    }
    /**
     * FR : charge une resource selon son type
     * @param type {string}
     * @param method {string}
     * @param url {string}
     * @param success {Function}
     * @param error {Function}
     * @return {object}
     */
    C.request = function (type, method, url, success, error) {
        var r;
        switch (type) {
            case C.IMAGE:
                r = new Image;
                r.onload = function (e) {
                    success(r);
                };
                r.onerror = error;
                r.src = url;
                break;
            case C.COFFEESCRIPT:
                r = C.getXHR(url, "get", null, function r_success(data) {
                    CoffeeScript.eval(data);
                    success(data);
                }, error);
                break;
            case C.JAVASCRIPT:
                r = document.createElement("SCRIPT");
                r.src = url;
                r.onload = function (event) {
                    success(url);
                };
                r.onerror = error;
                document.head.appendChild(r);
                break;
            default:
                r = C.getXHR(url, "get", null, success, error);
                break;
        }
        return r;
    };
    /**
     * FR : charge une série de scripts en série
     * @param resources {Array<string>}
     * @param callback {Function}
     * @param cache {boolean}
     * @param onErrorContinue {boolean}
     * @return {*}
     */
    C.load = function (resourceCollection, callback, onErrorContinue, cache) {
        var resources = resourceCollection.slice();
        var DO = function (resources) {
            /* FR : si rien n'est à charger , executer le callback; */
            if (resources.length <= 0)return callback(C.loadedResources);
            var current = resources.shift();
            var type = C.getType(current);
            C.request(type, null, current, function s_success(data) {
                C.loadedResources[current] = data;
                return DO(resources);
            }, function s_error(data) {
                if (onErrorContinue === true) return DO(resources);
                throw "".concat("failed to load ", current);
            });
        };
        return DO(resources);
    };
    /**
     * @TODO à compléter
     */
    C.loadParrallel = function (resourceCollection) {
        throw "not implemented yet.";
    };
    /**
     * @TODO à compléter
     */
    C.clearCache = function () {
        throw "not implemented yet.";
    };

    /**
     *
     * @param resource {string}
     */
    C.getType = function (resource) {
        if (resource.match(jsRegExp)) {
            return C.JAVASCRIPT;
        } else if (resource.match(coffeeRegExp)) {
            return C.COFFEESCRIPT;
        } else if (resource.match(imageRegExp)) {
            return C.IMAGE;
        } else {
            return C.TEXT;
        }
    };
    // FR : vérouiller Charge
    if (Object.seal && typeof Object.seal === "function") {
        Object.seal(C);
    }
    ns.Charge = C;
    /**
     * @note @requirejs rendre un module compatible avec requirejs et amd
     */
    if (typeof module !== "undefined" && typeof exports !== "undefined") {
        module.exports = C;
    }
})(this);