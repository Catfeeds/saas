/**
 * Write By <yanghuilei@itsport.club>
 * Create At 2018/7/9  Friday
 */
!function ($, w) {
    "use strict";
    var L = function () {
        this.show = function () {
            var e = $('#rbac-loading');
            if (e.hasClass('rbac-loading-hide')) {
                e.removeClass('rbac-loading-hide');
            }
        };
        this.hide = function () {
            var e = $('#rbac-loading');
            if (!e.hasClass('rbac-loading-hide')) {
                e.addClass('rbac-loading-hide');
            }
        };
    };
    w.load = new L();
}(jQuery, window);

/**
 * Write By <yanghuilei@itsport.club>
 * Create At 2018/7/9  Friday
 */
!function ($, w) {
    "use strict";
    var P = function () {
        this.J = function (p) {
            return p;
        };

        this.M = function (t, m1, m2, o) {
            var a = '<div id="rbac-container"></div>',
                b = '<div class="alert ' + t + ' alert-dismissible" role="alert">' +
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>' +
                    '<strong class="m1">' + m1 + '</strong>' +
                    '<span class="m2">' + m2 + '</span>' +
                    '</div>';

            if (o === 1) {
                return $(a);
            }

            return $(b);
        };

        this.success = function (m) {
            this.T(this.H('tip-success', '成功提示：', m));
        };

        this.warning = function (m) {
            this.T(this.H('tip-warning', '警告提示：', m));
        };

        this.error = function (m) {
            this.T(this.H('tip-error', '错误提示：', m));
        };

        this.H = function (c, m1, m2) {
            var o = this.M(c, m1, m2, 2),
                C = $('div#rbac-container'),
                O;

            if (C.length && C.length > 0 && C.children("div").length > 3) {
                return;

            } else if (C.length && C.length > 0) {
                C.prepend(o);
            } else {
                O = this.M(c, m1, m2, 1);
                $('body').prepend(O);
                O.prepend(o);

            }
            $(o).fadeIn(200);

            return o;
        };

        this.T = function (e) {
            var that = this,
                K;
            if (undefined === e) {
                return;
            }

            K = that.I(e);
            $(e).hover(function () {
                clearTimeout(K);
            }, function () {
                K = that.I(e);
            });
        };

        this.I = function (e) {
            var C = $('div#rbac-container'),
                O = setTimeout(function () {
                    $(e).fadeOut('slow', function () {
                        $(this).remove();
                        if (C.length && C.length > 0 && C.children("div").length === 0) {
                            C.remove();
                        }
                    });

                }, 900);

            return this.J(O);
        };
    };

    w.Markword = new P();

}(jQuery, window);

/**
 * Write By <yanghuilei@itsport.club>
 * Create At 2018/7/9  Friday
 */
!function (w, M) {
    "use strict";
    w.Tip = {
        success: function (m) {
            return M.success(m);
        }, error: function (m) {
            return M.error(m);
        }, warning: function (m) {
            return M.warning(m);
        }
    };
}(window, Markword);