/**
 * library - jquery_wolfsblvt_functions
 *
 * functions_global.js
 * http://www.pinkes-forum.de/
 * Author: Clemens Husung (Wolfsblvt)
 * 
 */

// namespacing
$.wolfsblvt = $.extend({}, $.wolfsblvt, {

    get_url_param_from_url: function (name, url) {
        /// <summary>
        ///     Gets the specific url-param from given URL
        /// </summary>
        /// <param name="name" type="string">(string) The name of the parameter</param>
        /// <param name="url" type="string">(string) The url to get the parameter from</param>
        /// <returns type="string">(string) value of the parameter, or empty String</returns>
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");

        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(url);

        if (results == null)
            return "";
        else
            return results[1];
    },

    get_url_param: function (name) {
        /// <summary>
        ///     Gets the specific url-param from current URL
        /// </summary>
        /// <param name="name" type="string">(string) The name of the parameter</param>
        /// <returns type="string">(string) value of the parameter, or empty String</returns>
        return $.wolfsblvt.get_url_param_from_url(name, window.location.href);
    },
});