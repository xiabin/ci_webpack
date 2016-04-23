/**
 * Created by xiabin on 2016/4/14.
 */


module.exports = {
    /**
     *
     * @param obj1
     * @param obj2
     * @returns {{}}
     */
    'array_diff': function (obj1, obj2) {
        var result = {};
        $.each(obj1, function (key, value) {
            if (!obj2.hasOwnProperty(key) || obj2[key] !== obj1[key]) {
                result[key] = value;
            }
        });
        return result;
    },
    'is_empty': function (obj) {

        // null and undefined are "empty"
        if (obj == null) return true;

        // Assume if it has a length property with a non-zero value
        // that that property is correct.
        if (obj.length > 0)    return false;
        if (obj.length === 0)  return true;

        // Otherwise, does it have any properties of its own?
        // Note that this doesn't handle
        // toString and valueOf enumeration bugs in IE < 9
        for (var key in obj) {
            if (hasOwnProperty.call(obj, key)) return false;
        }

        return true;
    },
    'parse_url': function (url) {
        var a = document.createElement('a');
        a.href = url;
        return a;
    }
}