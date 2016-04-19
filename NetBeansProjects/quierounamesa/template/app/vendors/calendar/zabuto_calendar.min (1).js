if (typeof jQuery == "undefined") {
    throw new Error("jQuery is not loaded")
}
$.fn.zabuto_calendar = function (b) {
    var c = $.extend({}, $.fn.zabuto_calendar_defaults(), b);
    var a = $.fn.zabuto_calendar_language(c.language);
    c = $.extend({}, c, a);
    this.each(function () {
        var u = $(this);
        u.attr("id", "zabuto_calendar_" + Math.floor(Math.random() * 99999).toString(36));
        u.data("initYear", c.year);
        u.data("initMonth", c.month);
        u.data("monthLabels", c.month_labels);
        u.data("weekStartsOn", c.weekstartson);
        u.data("navIcons", c.nav_icon);
        u.data("dowLabels", c.dow_labels);
        u.data("showToday", c.today);
        u.data("showDays", c.show_days);
        u.data("showPrevious", c.show_previous);
        u.data("showNext", c.show_next);
        u.data("cellBorder", c.cell_border);
        u.data("ajaxSettings", c.ajax);
        u.data("legendList", c.legend);
        u.data("actionFunction", c.action);
        u.data("actionNavFunction", c.action_nav);
        e();
        function e() {
            var w = parseInt(u.data("initYear"));
            var y = parseInt(u.data("initMonth")) - 1;
            var z = new Date(w, y, 1, 0, 0, 0, 0);
            u.data("initDate", z);
            var A = (u.data("cellBorder") === true) ? " table-bordered" : "";
            $tableObj = $('<table class="table' + A + '"></table>');
            $tableObj = r(u, $tableObj, z.getFullYear(), z.getMonth());
            $legendObj = g(u);
            var x = $('<div class="zabuto_calendar" id="' + u.attr("id") + '"></div>');
            x.append($tableObj);
            x.append($legendObj);
            u.append(x)
        }

        function r(y, A, x, z) {
            var w = new Date(x, z, 1, 0, 0, 0, 0);
            y.data("currDate", w);
            A.empty();
            A = q(y, A, x, z);
            A = n(y, A);
            A = s(y, A, x, z);
            v(y, x, z);
            return A
        }

        function g(y) {
            var w = $('<div class="legend" id="' + y.attr("id") + '_legend"></div>');
            var x = y.data("legendList");
            if (typeof(x) == "object" && x.length > 0) {
                $(x).each(function (C, E) {
                    if (typeof(E) == "object") {
                        if ("type" in E) {
                            var D = "";
                            if ("label" in E) {
                                D = E.label
                            }
                            switch (E.type) {
                                case"text":
                                    if (D !== "") {
                                        var B = "";
                                        if ("badge" in E) {
                                            if (typeof(E.classname) === "undefined") {
                                                var F = "badge-event"
                                            } else {
                                                var F = E.classname
                                            }
                                            B = '<span class="badge ' + F + '">' + E.badge + "</span> "
                                        }
                                        w.append('<span class="legend-' + E.type + '">' + B + D + "</span>")
                                    }
                                    break;
                                case"block":
                                    if (D !== "") {
                                        D = "<span>" + D + "</span>"
                                    }
                                    if (typeof(E.classname) === "undefined") {
                                        var A = "event"
                                    } else {
                                        var A = "event-styled " + E.classname
                                    }
                                    w.append('<span class="legend-' + E.type + '"><ul class="legend"><li class="' + A + '"></li></u>' + D + "</span>");
                                    break;
                                case"list":
                                    if ("list" in E && typeof(E.list) == "object" && E.list.length > 0) {
                                        var z = $('<ul class="legend"></u>');
                                        $(E.list).each(function (H, G) {
                                            z.append('<li class="' + G + '"></li>')
                                        });
                                        w.append(z)
                                    }
                                    break;
                                case"spacer":
                                    w.append('<span class="legend-' + E.type + '"> </span>');
                                    break
                            }
                        }
                    }
                })
            }
            return w
        }

        function q(L, z, I, G) {
            var H = L.data("navIcons");
            var E = $('<span><span class="glyphicon glyphicon-chevron-left"></span></span>');
            var F = $('<span><span class="glyphicon glyphicon-chevron-right"></span></span>');
            if (typeof(H) === "object") {
                if ("prev" in H) {
                    E.html(H.prev)
                }
                if ("next" in H) {
                    F.html(H.next)
                }
            }
            var K = L.data("showPrevious");
            if (typeof(K) === "number" || K === false) {
                K = h(L.data("showPrevious"), true)
            }
            var J = $('<div class="calendar-month-navigation"></div>');
            J.attr("id", L.attr("id") + "_nav-prev");
            J.data("navigation", "prev");
            if (K !== false) {
                prevMonth = (G - 1);
                prevYear = I;
                if (prevMonth == -1) {
                    prevYear = (prevYear - 1);
                    prevMonth = 11
                }
                J.data("to", {year: prevYear, month: (prevMonth + 1)});
                J.append(E);
                if (typeof(L.data("actionNavFunction")) === "function") {
                    J.click(L.data("actionNavFunction"))
                }
                J.click(function (N) {
                    r(L, z, prevYear, prevMonth)
                })
            }
            var D = L.data("showNext");
            if (typeof(D) === "number" || D === false) {
                D = h(L.data("showNext"), false)
            }
            var B = $('<div class="calendar-month-navigation"></div>');
            B.attr("id", L.attr("id") + "_nav-next");
            B.data("navigation", "next");
            if (D !== false) {
                nextMonth = (G + 1);
                nextYear = I;
                if (nextMonth == 12) {
                    nextYear = (nextYear + 1);
                    nextMonth = 0
                }
                B.data("to", {year: nextYear, month: (nextMonth + 1)});
                B.append(F);
                if (typeof(L.data("actionNavFunction")) === "function") {
                    B.click(L.data("actionNavFunction"))
                }
                B.click(function (N) {
                    r(L, z, nextYear, nextMonth)
                })
            }
            var M = L.data("monthLabels");
            var C = $("<th></th>").append(J);
            var w = $("<th></th>").append(B);
            var A = $("<span>" + M[G] + " " + I + "</span>");
            A.dblclick(function () {
                var N = L.data("initDate");
                r(L, z, N.getFullYear(), N.getMonth())
            });
            var x = $('<th colspan="5"></th>');
            x.append(A);
            var y = $('<tr class="calendar-month-header"></tr>');
            y.append(C, x, w);
            z.append(y);
            return z
        }

        function n(z, B) {
            if (z.data("showDays") === true) {
                var w = z.data("weekStartsOn");
                var x = z.data("dowLabels");
                if (w === 0) {
                    var A = $.extend([], x);
                    var C = new Array(A.pop());
                    x = C.concat(A)
                }
                var y = $('<tr class="calendar-dow-header"></tr>');
                $(x).each(function (D, E) {
                    y.append("<th>" + E + "</th>")
                });
                B.append(y)
            }
            return B
        }

        function s(E, D, G, L) {
            var C = E.data("ajaxSettings");
            var F = o(G, L);
            var w = k(G, L);
            var B = i(G, L, 1);
            var N = i(G, L, w);
            var A = 1;
            var z = E.data("weekStartsOn");
            if (z === 0) {
                if (N == 6) {
                    F++
                }
                if (B == 6 && (N == 0 || N == 1 || N == 5)) {
                    F--
                }
                B++;
                if (B == 7) {
                    B = 0
                }
            }
            for (var y = 0; y < F; y++) {
                var x = $('<tr class="calendar-dow"></tr>');
                for (var I = 0; I < 7; I++) {
                    if (I < B || A > w) {
                        x.append("<td></td>")
                    } else {
                        var M = E.attr("id") + "_" + t(G, L, A);
                        var K = M + "_day";
                        var J = $('<div id="' + K + '" class="day" >' + A + "</div>");
                        J.data("day", A);
                        if (E.data("showToday") === true) {
                            if (l(G, L, A)) {
                                J.html('<span class="badge badge-today">' + A + "</span>")
                            }
                        }
                        var H = $('<td id="' + M + '"></td>');
                        H.append(J);
                        H.data("date", t(G, L, A));
                        H.data("hasEvent", false);
                        if (typeof(E.data("actionFunction")) === "function") {
                            H.addClass("dow-clickable");
                            H.click(function () {
                                E.data("selectedDate", $(this).data("date"))
                            });
                            H.click(E.data("actionFunction"))
                        }
                        x.append(H);
                        A++
                    }
                    if (I == 6) {
                        B = 0
                    }
                }
                D.append(x)
            }
            return D
        }

        function p(z, F, E, H) {
            var G = $('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>');
            var y = $('<h4 class="modal-title" id="' + z + '_modal_title">' + F + "</h4>");
            var I = $('<div class="modal-header"></div>');
            I.append(G);
            I.append(y);
            var D = $('<div class="modal-body" id="' + z + '_modal_body">' + E + "</div>");
            var C = $('<div class="modal-footer" id="' + z + '_modal_footer"></div>');
            if (typeof(H) !== "undefined") {
                var x = $("<div>" + H + "</div>");
                C.append(x)
            }
            var A = $('<div class="modal-content"></div>');
            A.append(I);
            A.append(D);
            A.append(C);
            var w = $('<div class="modal-dialog"></div>');
            w.append(A);
            var B = $('<div class="modal fade" id="' + z + '_modal" tabindex="-1" role="dialog" aria-labelledby="' + z + '_modal_title" aria-hidden="true"></div>');
            B.append(w);
            B.data("dateId", z);
            B.attr("dateId", z);
            return B
        }

        function v(x, w, A) {
            var z = x.data("ajaxSettings");
            x.data("events", false);
            if (z === false) {
                return true
            }
            if (typeof(z) != "object" || typeof(z.url) == "undefined") {
                alert("Invalid calendar event settings");
                return false
            }
            var y = {year: w, month: (A + 1)};
            $.ajax({type: "GET", url: z.url, data: y, dataType: "json"}).done(function (B) {
                var C = [];
                $.each(B, function (E, D) {
                    C.push(B[E])
                });
                x.data("events", C);
                j(x)
            })
        }

        function j(x) {
            var y = x.data("ajaxSettings");
            var w = x.data("events");
            if (w !== false) {
                $(w).each(function (B, F) {
                    var G = x.attr("id") + "_" + F.date;
                    var C = $("#" + G);
                    var A = $("#" + G + "_day");
                    C.data("hasEvent", true);
                    if (typeof(F.title) !== "undefined") {
                        C.attr("title", F.title)
                    }
                    if (typeof(F.classname) === "undefined") {
                        C.addClass("event")
                    } else {
                        C.addClass("event-styled");
                        A.addClass(F.classname)
                    }
                    if (typeof(F.badge) !== "undefined" && F.badge !== false) {
                        var E = (F.badge === true) ? "" : " badge-" + F.badge;
                        var D = A.data("day");
                        A.html('<span class="badge badge-event' + E + '">' + D + "</span>")
                    }
                    if (typeof(F.body) !== "undefined") {
                        if ("modal" in y && (y.modal === true)) {
                            C.addClass("event-clickable");
                            var z = p(G, F.title, F.body, F.footer);
                            $("body").append(z);
                            $("#" + G).click(function () {
                                $("#" + G + "_modal").modal()
                            })
                        }
                    }
                })
            }
        }

        function l(y, z, x) {
            var A = new Date();
            var w = new Date(y, z, x);
            return(w.toDateString() == A.toDateString())
        }

        function t(x, y, w) {
            d = (w < 10) ? "0" + w : w;
            m = y + 1;
            m = (m < 10) ? "0" + m : m;
            return x + "-" + m + "-" + d
        }

        function i(y, z, x) {
            var w = new Date(y, z, x, 0, 0, 0, 0);
            var A = w.getDay();
            if (A == 0) {
                A = 6
            } else {
                A--
            }
            return A
        }

        function k(x, y) {
            var w = 28;
            while (f(x, y + 1, w + 1)) {
                w++
            }
            return w
        }

        function o(y, A) {
            var w = k(y, A);
            var C = i(y, A, 1);
            var z = i(y, A, w);
            var B = w;
            var x = (C - z);
            if (x > 0) {
                B += x
            }
            return Math.ceil(B / 7)
        }

        function f(z, w, x) {
            return w > 0 && w < 13 && z > 0 && z < 32768 && x > 0 && x <= (new Date(z, w, 0)).getDate()
        }

        function h(y, A) {
            if (y === false) {
                y = 0
            }
            var z = u.data("currDate");
            var x = u.data("initDate");
            var w;
            w = (x.getFullYear() - z.getFullYear()) * 12;
            w -= z.getMonth() + 1;
            w += x.getMonth();
            if (A === true) {
                if (w < (parseInt(y) - 1)) {
                    return true
                }
            } else {
                if (w >= (0 - parseInt(y))) {
                    return true
                }
            }
            return false
        }
    });
    return this
};
$.fn.zabuto_calendar_defaults = function () {
    var a = new Date();
    var c = a.getFullYear();
    var e = a.getMonth() + 1;
    var b = {language: false, year: c, month: e, show_previous: true, show_next: true, cell_border: false, today: false, show_days: true, weekstartson: 1, nav_icon: false, ajax: false, legend: false, action: false, action_nav: false};
    return b
};
$.fn.zabuto_calendar_language = function (a) {
    if (typeof(a) == "undefined" || a === false) {
        a = "en"
    }
    switch (a.toLowerCase()) {
        case"de":
            return{month_labels: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"], dow_labels: ["Mo", "Di", "Mi", "Do", "Fr", "Sa", "So"]};
            break;
        case"en":
            return{month_labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"], dow_labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]};
            break;
        case"es":
            return{month_labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"], dow_labels: ["Lu", "Ma", "Mi", "Ju", "Vi", "Sá", "Do"]};
            break;
        case"fr":
            return{month_labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"], dow_labels: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"]};
            break;
        case"it":
            return{month_labels: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"], dow_labels: ["Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"]};
            break;
        case"nl":
            return{month_labels: ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"], dow_labels: ["Ma", "Di", "Wo", "Do", "Vr", "Za", "Zo"]};
            break
    }
};