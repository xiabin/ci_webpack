/**
 * Created by xiabin on 2016/4/16.
 */


$.fn.btnLock = function (lockHTML) {

    var tag = this.get(0).tagName;
    var obj = this;
    var isBtn = (tag == "INPUT" || tag == "BUTTON");

    if (!this.data("btnlock_origHTML")) {
        var html = tag == "input" ? this.val() : this.html();
        this.data("btnlock_origHTML", html);
    }

    this.btnUpdate = function (html) {
        if (isBtn) {
            obj.prop("disabled", true);
        }

        if (tag == "INPUT") {
            obj.val(html);
        } else {
            obj.html(html);
        }
    };

    this.btnUpdate(lockHTML);

    this.btnRelease = function () {
        var origHTML = obj.data("btnlock_origHTML");

        if (isBtn) {
            obj.prop("disabled", false);
        }

        if (tag == "INPUT") {
            obj.val(origHTML);
        } else {
            obj.html(origHTML);
        }
    };

    return this;
};
