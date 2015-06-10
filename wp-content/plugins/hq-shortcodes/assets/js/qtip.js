/* qTip2 v2.1.1 tips modal viewport svg imagemap ie6 | qtip2.com | Licensed MIT, GPL | Thu Jul 11 2013 14:03:02 */
(function (t, e, s) {
    (function (t) {
        "use strict";
        "function" == typeof define && define.amd ? define(["jquery", "imagesloaded"], t) : jQuery && !jQuery.fn.qtip && t(jQuery)
    })(function (o) {
        function n(t, e, i, s) {
            this.id = i, this.target = t, this.tooltip = E, this.elements = elements = {target: t}, this._id = $ + "-" + i, this.timers = {img: {}}, this.options = e, this.plugins = {}, this.cache = cache = {event: {}, target: o(), disabled: S, attr: s, onTooltip: S, lastClass: ""}, this.rendered = this.destroyed = this.disabled = this.waiting = this.hiddenDuringWait = this.positioning = this.triggering = S
        }
        function r(t) {
            return t === E || "object" !== o.type(t)
        }
        function a(t) {
            return!(o.isFunction(t) || t && t.attr || t.length || "object" === o.type(t) && (t.jquery || t.then))
        }
        function h(t) {
            var e, i, s, n;
            return r(t) ? S : (r(t.metadata) && (t.metadata = {type: t.metadata}), "content"in t && (e = t.content, r(e) || e.jquery || e.done ? e = t.content = {text: i = a(e) ? S : e} : i = e.text, "ajax"in e && (s = e.ajax, n = s && s.once !== S, delete e.ajax, e.text = function (t, e) {
                var r = i || o(this).attr(e.options.content.attr) || "Loading...", a = o.ajax(o.extend({}, s, {context: e})).then(s.success, E, s.error).then(function (t) {
                    return t && n && e.set("content.text", t), t
                }, function (t, i, s) {
                    e.destroyed || 0 === t.status || e.set("content.text", i + ": " + s)
                });
                return n ? r : (e.set("content.text", r), a)
            }), "title"in e && (r(e.title) || (e.button = e.title.button, e.title = e.title.text), a(e.title || S) && (e.title = S))), "position"in t && r(t.position) && (t.position = {my: t.position, at: t.position}), "show"in t && r(t.show) && (t.show = t.show.jquery ? {target: t.show} : t.show === M ? {ready: M} : {event: t.show}), "hide"in t && r(t.hide) && (t.hide = t.hide.jquery ? {target: t.hide} : {event: t.hide}), "style"in t && r(t.style) && (t.style = {classes: t.style}), o.each(N, function () {
                this.sanitize && this.sanitize(t)
            }), t)
        }
        function l(t, e) {
            for (var i, s = 0, o = t, n = e.split("."); o = o[n[s++]]; )
                n.length > s && (i = o);
            return[i || t, n.pop()]
        }
        function c(t, e) {
            var i, s, o;
            for (i in this.checks)
                for (s in this.checks[i])
                    (o = RegExp(s, "i").exec(t)) && (e.push(o), ("builtin" === i || this.plugins[i]) && this.checks[i][s].apply(this.plugins[i] || this, e))
        }
        function p(t) {
            return H.concat("").join(t ? "-" + t + " " : " ")
        }
        function d(t) {
            if (this.tooltip.hasClass(te))
                return S;
            clearTimeout(this.timers.show), clearTimeout(this.timers.hide);
            var e = o.proxy(function () {
                this.toggle(M, t)
            }, this);
            this.options.show.delay > 0 ? this.timers.show = setTimeout(e, this.options.show.delay) : e()
        }
        function u(t) {
            if (this.tooltip.hasClass(te))
                return S;
            var e = o(t.relatedTarget), i = e.closest(G)[0] === this.tooltip[0], s = e[0] === this.options.show.target[0];
            if (clearTimeout(this.timers.show), clearTimeout(this.timers.hide), this !== e[0] && "mouse" === this.options.position.target && i || this.options.hide.fixed && /mouse(out|leave|move)/.test(t.type) && (i || s))
                try {
                    t.preventDefault(), t.stopImmediatePropagation()
                } catch (n) {
                }
            else {
                var r = o.proxy(function () {
                    this.toggle(S, t)
                }, this);
                this.options.hide.delay > 0 ? this.timers.hide = setTimeout(r, this.options.hide.delay) : r()
            }
        }
        function f(t) {
            return this.tooltip.hasClass(te) || !this.options.hide.inactive ? S : (clearTimeout(this.timers.inactive), this.timers.inactive = setTimeout(o.proxy(function () {
                this.hide(t)
            }, this), this.options.hide.inactive), s)
        }
        function g(t) {
            this.rendered && this.tooltip[0].offsetWidth > 0 && this.reposition(t)
        }
        function m(t, i, s) {
            o(e.body).delegate(t, (i.split ? i : i.join(re + " ")) + re, function () {
                var t = T.api[o.attr(this, Y)];
                t && !t.disabled && s.apply(t, arguments)
            })
        }
        function v(t, i, s) {
            var r, a, l, c, p, d = o(e.body), u = t[0] === e ? d : t, f = t.metadata ? t.metadata(s.metadata) : E, g = "html5" === s.metadata.type && f ? f[s.metadata.name] : E, m = t.data(s.metadata.name || "qtipopts");
            try {
                m = "string" == typeof m ? o.parseJSON(m) : m
            } catch (v) {
            }
            if (c = o.extend(M, {}, T.defaults, s, "object" == typeof m ? h(m) : E, h(g || f)), a = c.position, c.id = i, "boolean" == typeof c.content.text) {
                if (l = t.attr(c.content.attr), c.content.attr === S || !l)
                    return S;
                c.content.text = l
            }
            if (a.container.length || (a.container = d), a.target === S && (a.target = u), c.show.target === S && (c.show.target = u), c.show.solo === M && (c.show.solo = a.container.closest("body")), c.hide.target === S && (c.hide.target = u), c.position.viewport === M && (c.position.viewport = a.container), a.container = a.container.eq(0), a.at = new j(a.at, M), a.my = new j(a.my), t.data($))
                if (c.overwrite)
                    t.qtip("destroy");
                else if (c.overwrite === S)
                    return S;
            return t.attr(X, i), c.suppress && (p = t.attr("title")) && t.removeAttr("title").attr(ie, p).attr("title", ""), r = new n(t, c, i, !!l), t.data($, r), t.one("remove.qtip-" + i + " removeqtip.qtip-" + i, function () {
                var t;
                (t = o(this).data($)) && t.destroy()
            }), r
        }
        function y(t) {
            return t.charAt(0).toUpperCase() + t.slice(1)
        }
        function b(t, e) {
            var i, o, n = e.charAt(0).toUpperCase() + e.slice(1), r = (e + " " + ve.join(n + " ") + n).split(" "), a = 0;
            if (me[e])
                return t.css(me[e]);
            for (; i = r[a++]; )
                if ((o = t.css(i)) !== s)
                    return me[e] = i, o
        }
        function w(t, e) {
            return parseInt(b(t, e), 10)
        }
        function x(t, e) {
            this._ns = "tip", this.options = e, this.offset = e.offset, this.size = [e.width, e.height], this.init(this.qtip = t)
        }
        function _(t, e) {
            this.options = e, this._ns = "-modal", this.init(this.qtip = t)
        }
        function q(t) {
            this._ns = "ie6", this.init(this.qtip = t)
        }
        var T, C, j, z, W, M = !0, S = !1, E = null, O = "x", R = "y", I = "width", k = "height", B = "top", L = "left", P = "bottom", V = "right", D = "center", A = "flipinvert", F = "shift", N = {}, $ = "qtip", X = "data-hasqtip", Y = "data-qtip-id", H = ["ui-widget", "ui-tooltip"], G = "." + $, U = "click dblclick mousedown mouseup mousemove mouseleave mouseenter".split(" "), Q = $ + "-fixed", J = $ + "-default", K = $ + "-focus", Z = $ + "-hover", te = $ + "-disabled", ee = "_replacedByqTip", ie = "oldtitle";
        BROWSER = {ie: function () {
                for (var t = 3, i = e.createElement("div"); (i.innerHTML = "<!--[if gt IE " + ++t + "]><i></i><![endif]-->") && i.getElementsByTagName("i")[0]; )
                    ;
                return t > 4 ? t : 0 / 0
            }(), iOS: parseFloat(("" + (/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(navigator.userAgent) || [0, ""])[1]).replace("undefined", "3_2").replace("_", ".").replace("_", "")) || S}, C = n.prototype, C.render = function (t) {
            if (this.rendered || this.destroyed)
                return this;
            var e = this, i = this.options, s = this.cache, n = this.elements, r = i.content.text, a = i.content.title, h = i.content.button, l = i.position, c = "." + this._id + " ", p = [];
            return o.attr(this.target[0], "aria-describedby", this._id), this.tooltip = n.tooltip = tooltip = o("<div/>", {id: this._id, "class": [$, J, i.style.classes, $ + "-pos-" + i.position.my.abbrev()].join(" "), width: i.style.width || "", height: i.style.height || "", tracking: "mouse" === l.target && l.adjust.mouse, role: "alert", "aria-live": "polite", "aria-atomic": S, "aria-describedby": this._id + "-content", "aria-hidden": M}).toggleClass(te, this.disabled).attr(Y, this.id).data($, this).appendTo(l.container).append(n.content = o("<div />", {"class": $ + "-content", id: this._id + "-content", "aria-atomic": M})), this.rendered = -1, this.positioning = M, a && (this._createTitle(), o.isFunction(a) || p.push(this._updateTitle(a, S))), h && this._createButton(), o.isFunction(r) || p.push(this._updateContent(r, S)), this.rendered = M, this._setWidget(), o.each(i.events, function (t, e) {
                o.isFunction(e) && tooltip.bind(("toggle" === t ? ["tooltipshow", "tooltiphide"] : ["tooltip" + t]).join(c) + c, e)
            }), o.each(N, function (t) {
                var i;
                "render" === this.initialize && (i = this(e)) && (e.plugins[t] = i)
            }), this._assignEvents(), o.when.apply(o, p).then(function () {
                e._trigger("render"), e.positioning = S, e.hiddenDuringWait || !i.show.ready && !t || e.toggle(M, s.event, S), e.hiddenDuringWait = S
            }), T.api[this.id] = this, this
        }, C.destroy = function (t) {
            function e() {
                if (!this.destroyed) {
                    this.destroyed = M;
                    var t = this.target, e = t.attr(ie);
                    this.rendered && this.tooltip.stop(1, 0).find("*").remove().end().remove(), o.each(this.plugins, function () {
                        this.destroy && this.destroy()
                    }), clearTimeout(this.timers.show), clearTimeout(this.timers.hide), this._unassignEvents(), t.removeData($).removeAttr(Y).removeAttr("aria-describedby"), this.options.suppress && e && t.attr("title", e).removeAttr(ie), this._unbind(t), this.options = this.elements = this.cache = this.timers = this.plugins = this.mouse = E, delete T.api[this.id]
                }
            }
            return this.destroyed ? this.target : (t !== M && this.rendered ? (tooltip.one("tooltiphidden", o.proxy(e, this)), !this.triggering && this.hide()) : e.call(this), this.target)
        }, z = C.checks = {builtin: {"^id$": function (t, e, i, s) {
                    var n = i === M ? T.nextid : i, r = $ + "-" + n;
                    n !== S && n.length > 0 && !o("#" + r).length ? (this._id = r, this.rendered && (this.tooltip[0].id = this._id, this.elements.content[0].id = this._id + "-content", this.elements.title[0].id = this._id + "-title")) : t[e] = s
                }, "^prerender": function (t, e, i) {
                    i && !this.rendered && this.render(this.options.show.ready)
                }, "^content.text$": function (t, e, i) {
                    this._updateContent(i)
                }, "^content.attr$": function (t, e, i, s) {
                    this.options.content.text === this.target.attr(s) && this._updateContent(this.target.attr(i))
                }, "^content.title$": function (t, e, i) {
                    return i ? (i && !this.elements.title && this._createTitle(), this._updateTitle(i), s) : this._removeTitle()
                }, "^content.button$": function (t, e, i) {
                    this._updateButton(i)
                }, "^content.title.(text|button)$": function (t, e, i) {
                    this.set("content." + e, i)
                }, "^position.(my|at)$": function (t, e, i) {
                    "string" == typeof i && (t[e] = new j(i, "at" === e))
                }, "^position.container$": function (t, e, i) {
                    this.tooltip.appendTo(i)
                }, "^show.ready$": function (t, e, i) {
                    i && (!this.rendered && this.render(M) || this.toggle(M))
                }, "^style.classes$": function (t, e, i, s) {
                    this.tooltip.removeClass(s).addClass(i)
                }, "^style.width|height": function (t, e, i) {
                    this.tooltip.css(e, i)
                }, "^style.widget|content.title": function () {
                    this._setWidget()
                }, "^style.def": function (t, e, i) {
                    this.tooltip.toggleClass(J, !!i)
                }, "^events.(render|show|move|hide|focus|blur)$": function (t, e, i) {
                    tooltip[(o.isFunction(i) ? "" : "un") + "bind"]("tooltip" + e, i)
                }, "^(show|hide|position).(event|target|fixed|inactive|leave|distance|viewport|adjust)": function () {
                    var t = this.options.position;
                    tooltip.attr("tracking", "mouse" === t.target && t.adjust.mouse), this._unassignEvents(), this._assignEvents()
                }}}, C.get = function (t) {
            if (this.destroyed)
                return this;
            var e = l(this.options, t.toLowerCase()), i = e[0][e[1]];
            return i.precedance ? i.string() : i
        };
        var se = /^position\.(my|at|adjust|target|container|viewport)|style|content|show\.ready/i, oe = /^prerender|show\.ready/i;
        C.set = function (t, e) {
            if (this.destroyed)
                return this;
            var i, n = this.rendered, r = S, a = this.options;
            return this.checks, "string" == typeof t ? (i = t, t = {}, t[i] = e) : t = o.extend({}, t), o.each(t, function (e, i) {
                if (!n && !oe.test(e))
                    return delete t[e], s;
                var h, c = l(a, e.toLowerCase());
                h = c[0][c[1]], c[0][c[1]] = i && i.nodeType ? o(i) : i, r = se.test(e) || r, t[e] = [c[0], c[1], i, h]
            }), h(a), this.positioning = M, o.each(t, o.proxy(c, this)), this.positioning = S, this.rendered && this.tooltip[0].offsetWidth > 0 && r && this.reposition("mouse" === a.position.target ? E : this.cache.event), this
        }, C._update = function (t, e) {
            var i = this, s = this.cache;
            return this.rendered && t ? (o.isFunction(t) && (t = t.call(this.elements.target, s.event, this) || ""), o.isFunction(t.then) ? (s.waiting = M, t.then(function (t) {
                return s.waiting = S, i._update(t, e)
            }, E, function (t) {
                return i._update(t, e)
            })) : t === S || !t && "" !== t ? S : (t.jquery && t.length > 0 ? e.children().detach().end().append(t.css({display: "block"})) : e.html(t), s.waiting = M, (o.fn.imagesLoaded ? e.imagesLoaded() : o.Deferred().resolve(o([]))).done(function (t) {
                s.waiting = S, t.length && i.rendered && i.tooltip[0].offsetWidth > 0 && i.reposition(s.event, !t.length)
            }).promise())) : S
        }, C._updateContent = function (t, e) {
            this._update(t, this.elements.content, e)
        }, C._updateTitle = function (t, e) {
            this._update(t, this.elements.title, e) === S && this._removeTitle(S)
        }, C._createTitle = function () {
            var t = this.elements, e = this._id + "-title";
            t.titlebar && this._removeTitle(), t.titlebar = o("<div />", {"class": $ + "-titlebar " + (this.options.style.widget ? p("header") : "")}).append(t.title = o("<div />", {id: e, "class": $ + "-title", "aria-atomic": M})).insertBefore(t.content).delegate(".qtip-close", "mousedown keydown mouseup keyup mouseout", function (t) {
                o(this).toggleClass("ui-state-active ui-state-focus", "down" === t.type.substr(-4))
            }).delegate(".qtip-close", "mouseover mouseout", function (t) {
                o(this).toggleClass("ui-state-hover", "mouseover" === t.type)
            }), this.options.content.button && this._createButton()
        }, C._removeTitle = function (t) {
            var e = this.elements;
            e.title && (e.titlebar.remove(), e.titlebar = e.title = e.button = E, t !== S && this.reposition())
        }, C.reposition = function (i, s) {
            if (!this.rendered || this.positioning || this.destroyed)
                return this;
            this.positioning = M;
            var n, r, a = this.cache, h = this.tooltip, l = this.options.position, c = l.target, p = l.my, d = l.at, u = l.viewport, f = l.container, g = l.adjust, m = g.method.split(" "), v = h.outerWidth(S), y = h.outerHeight(S), b = 0, w = 0, x = h.css("position"), _ = {left: 0, top: 0}, q = h[0].offsetWidth > 0, T = i && "scroll" === i.type, C = o(t), j = f[0].ownerDocument, z = this.mouse;
            if (o.isArray(c) && 2 === c.length)
                d = {x: L, y: B}, _ = {left: c[0], top: c[1]};
            else if ("mouse" === c && (i && i.pageX || a.event.pageX))
                d = {x: L, y: B}, i = !z || !z.pageX || !g.mouse && i && i.pageX ? (!i || "resize" !== i.type && "scroll" !== i.type ? i && i.pageX && "mousemove" === i.type ? i : (!g.mouse || this.options.show.distance) && a.origin && a.origin.pageX ? a.origin : i : a.event) || i || a.event || z || {} : z, "static" !== x && (_ = f.offset()), j.body.offsetWidth !== (t.innerWidth || j.documentElement.clientWidth) && (r = o(j.body).offset()), _ = {left: i.pageX - _.left + (r && r.left || 0), top: i.pageY - _.top + (r && r.top || 0)}, g.mouse && T && (_.left -= z.scrollX - C.scrollLeft(), _.top -= z.scrollY - C.scrollTop());
            else {
                if ("event" === c && i && i.target && "scroll" !== i.type && "resize" !== i.type ? a.target = o(i.target) : "event" !== c && (a.target = o(c.jquery ? c : elements.target)), c = a.target, c = o(c).eq(0), 0 === c.length)
                    return this;
                c[0] === e || c[0] === t ? (b = BROWSER.iOS ? t.innerWidth : c.width(), w = BROWSER.iOS ? t.innerHeight : c.height(), c[0] === t && (_ = {top: (u || c).scrollTop(), left: (u || c).scrollLeft()})) : N.imagemap && c.is("area") ? n = N.imagemap(this, c, d, N.viewport ? m : S) : N.svg && c[0].ownerSVGElement ? n = N.svg(this, c, d, N.viewport ? m : S) : (b = c.outerWidth(S), w = c.outerHeight(S), _ = c.offset()), n && (b = n.width, w = n.height, r = n.offset, _ = n.position), _ = this.reposition.offset(c, _, f), (BROWSER.iOS > 3.1 && 4.1 > BROWSER.iOS || BROWSER.iOS >= 4.3 && 4.33 > BROWSER.iOS || !BROWSER.iOS && "fixed" === x) && (_.left -= C.scrollLeft(), _.top -= C.scrollTop()), (!n || n && n.adjustable !== S) && (_.left += d.x === V ? b : d.x === D ? b / 2 : 0, _.top += d.y === P ? w : d.y === D ? w / 2 : 0)
            }
            return _.left += g.x + (p.x === V ? -v : p.x === D ? -v / 2 : 0), _.top += g.y + (p.y === P ? -y : p.y === D ? -y / 2 : 0), N.viewport ? (_.adjusted = N.viewport(this, _, l, b, w, v, y), r && _.adjusted.left && (_.left += r.left), r && _.adjusted.top && (_.top += r.top)) : _.adjusted = {left: 0, top: 0}, this._trigger("move", [_, u.elem || u], i) ? (delete _.adjusted, s === S || !q || isNaN(_.left) || isNaN(_.top) || "mouse" === c || !o.isFunction(l.effect) ? h.css(_) : o.isFunction(l.effect) && (l.effect.call(h, this, o.extend({}, _)), h.queue(function (t) {
                o(this).css({opacity: "", height: ""}), BROWSER.ie && this.style.removeAttribute("filter"), t()
            })), this.positioning = S, this) : this
        }, C.reposition.offset = function (t, i, s) {
            function n(t, e) {
                i.left += e * t.scrollLeft(), i.top += e * t.scrollTop()
            }
            if (!s[0])
                return i;
            var r, a, h, l, c = o(t[0].ownerDocument), p = !!BROWSER.ie && "CSS1Compat" !== e.compatMode, d = s[0];
            do
                "static" !== (a = o.css(d, "position")) && ("fixed" === a ? (h = d.getBoundingClientRect(), n(c, -1)) : (h = o(d).position(), h.left += parseFloat(o.css(d, "borderLeftWidth")) || 0, h.top += parseFloat(o.css(d, "borderTopWidth")) || 0), i.left -= h.left + (parseFloat(o.css(d, "marginLeft")) || 0), i.top -= h.top + (parseFloat(o.css(d, "marginTop")) || 0), r || "hidden" === (l = o.css(d, "overflow")) || "visible" === l || (r = o(d)));
            while (d = d.offsetParent);
            return r && (r[0] !== c[0] || p) && n(r, 1), i
        };
        var ne = (j = C.reposition.Corner = function (t, e) {
            t = ("" + t).replace(/([A-Z])/, " $1").replace(/middle/gi, D).toLowerCase(), this.x = (t.match(/left|right/i) || t.match(/center/) || ["inherit"])[0].toLowerCase(), this.y = (t.match(/top|bottom|center/i) || ["inherit"])[0].toLowerCase(), this.forceY = !!e;
            var i = t.charAt(0);
            this.precedance = "t" === i || "b" === i ? R : O
        }).prototype;
        ne.invert = function (t, e) {
            this[t] = this[t] === L ? V : this[t] === V ? L : e || this[t]
        }, ne.string = function () {
            var t = this.x, e = this.y;
            return t === e ? t : this.precedance === R || this.forceY && "center" !== e ? e + " " + t : t + " " + e
        }, ne.abbrev = function () {
            var t = this.string().split(" ");
            return t[0].charAt(0) + (t[1] && t[1].charAt(0) || "")
        }, ne.clone = function () {
            return new j(this.string(), this.forceY)
        }, C.toggle = function (t, i) {
            var s = this.cache, n = this.options, r = this.tooltip;
            if (i) {
                if (/over|enter/.test(i.type) && /out|leave/.test(s.event.type) && n.show.target.add(i.target).length === n.show.target.length && r.has(i.relatedTarget).length)
                    return this;
                s.event = o.extend({}, i)
            }
            if (this.waiting && !t && (this.hiddenDuringWait = M), !this.rendered)
                return t ? this.render(1) : this;
            if (this.destroyed || this.disabled)
                return this;
            var a, h, l = t ? "show" : "hide", c = this.options[l], p = (this.options[t ? "hide" : "show"], this.options.position), d = this.options.content, u = this.tooltip.css("width"), f = this.tooltip[0].offsetWidth > 0, g = t || 1 === c.target.length, m = !i || 2 > c.target.length || s.target[0] === i.target;
            return(typeof t).search("boolean|number") && (t = !f), a = !r.is(":animated") && f === t && m, h = a ? E : !!this._trigger(l, [90]), h !== S && t && this.focus(i), !h || a ? this : (o.attr(r[0], "aria-hidden", !t), t ? (s.origin = o.extend({}, this.mouse), o.isFunction(d.text) && this._updateContent(d.text, S), o.isFunction(d.title) && this._updateTitle(d.title, S), !W && "mouse" === p.target && p.adjust.mouse && (o(e).bind("mousemove." + $, this._storeMouse), W = M), u || r.css("width", r.outerWidth(S)), this.reposition(i, arguments[2]), u || r.css("width", ""), c.solo && ("string" == typeof c.solo ? o(c.solo) : o(G, c.solo)).not(r).not(c.target).qtip("hide", o.Event("tooltipsolo"))) : (clearTimeout(this.timers.show), delete s.origin, W && !o(G + '[tracking="true"]:visible', c.solo).not(r).length && (o(e).unbind("mousemove." + $), W = S), this.blur(i)), after = o.proxy(function () {
                t ? (BROWSER.ie && r[0].style.removeAttribute("filter"), r.css("overflow", ""), "string" == typeof c.autofocus && o(this.options.show.autofocus, r).focus(), this.options.show.target.trigger("qtip-" + this.id + "-inactive")) : r.css({display: "", visibility: "", opacity: "", left: "", top: ""}), this._trigger(t ? "visible" : "hidden")
            }, this), c.effect === S || g === S ? (r[l](), after()) : o.isFunction(c.effect) ? (r.stop(1, 1), c.effect.call(r, this), r.queue("fx", function (t) {
                after(), t()
            })) : r.fadeTo(90, t ? 1 : 0, after), t && c.target.trigger("qtip-" + this.id + "-inactive"), this)
        }, C.show = function (t) {
            return this.toggle(M, t)
        }, C.hide = function (t) {
            return this.toggle(S, t)
        }, C.focus = function (t) {
            if (!this.rendered || this.destroyed)
                return this;
            var e = o(G), i = this.tooltip, s = parseInt(i[0].style.zIndex, 10), n = T.zindex + e.length;
            return i.hasClass(K) || this._trigger("focus", [n], t) && (s !== n && (e.each(function () {
                this.style.zIndex > s && (this.style.zIndex = this.style.zIndex - 1)
            }), e.filter("." + K).qtip("blur", t)), i.addClass(K)[0].style.zIndex = n), this
        }, C.blur = function (t) {
            return!this.rendered || this.destroyed ? this : (this.tooltip.removeClass(K), this._trigger("blur", [this.tooltip.css("zIndex")], t), this)
        }, C.disable = function (t) {
            return this.destroyed ? this : ("boolean" != typeof t && (t = !(this.tooltip.hasClass(te) || this.disabled)), this.rendered && this.tooltip.toggleClass(te, t).attr("aria-disabled", t), this.disabled = !!t, this)
        }, C.enable = function () {
            return this.disable(S)
        }, C._createButton = function () {
            var t = this, e = this.elements, i = e.tooltip, s = this.options.content.button, n = "string" == typeof s, r = n ? s : "Close tooltip";
            e.button && e.button.remove(), e.button = s.jquery ? s : o("<a />", {"class": "qtip-close " + (this.options.style.widget ? "" : $ + "-icon"), title: r, "aria-label": r}).prepend(o("<span />", {"class": "ui-icon ui-icon-close", html: "&times;"})), e.button.appendTo(e.titlebar || i).attr("role", "button").click(function (e) {
                return i.hasClass(te) || t.hide(e), S
            })
        }, C._updateButton = function (t) {
            if (!this.rendered)
                return S;
            var e = this.elements.button;
            t ? this._createButton() : e.remove()
        }, C._setWidget = function () {
            var t = this.options.style.widget, e = this.elements, i = e.tooltip, s = i.hasClass(te);
            i.removeClass(te), te = t ? "ui-state-disabled" : "qtip-disabled", i.toggleClass(te, s), i.toggleClass("ui-helper-reset " + p(), t).toggleClass(J, this.options.style.def && !t), e.content && e.content.toggleClass(p("content"), t), e.titlebar && e.titlebar.toggleClass(p("header"), t), e.button && e.button.toggleClass($ + "-icon", !t)
        }, C._storeMouse = function (i) {
            this.mouse = {pageX: i.pageX, pageY: i.pageY, type: "mousemove", scrollX: t.pageXOffset || e.body.scrollLeft || e.documentElement.scrollLeft, scrollY: t.pageYOffset || e.body.scrollTop || e.documentElement.scrollTop}
        }, C._bind = function (t, e, i, s, n) {
            var r = "." + this._id + (s ? "-" + s : "");
            e.length && o(t).bind((e.split ? e : e.join(r + " ")) + r, o.proxy(i, n || this))
        }, C._unbind = function (t, e) {
            o(t).unbind("." + this._id + (e ? "-" + e : ""))
        };
        var re = "." + $;
        o(function () {
            m(G, ["mouseenter", "mouseleave"], function (t) {
                var e = "mouseenter" === t.type, i = o(t.currentTarget), s = o(t.relatedTarget || t.target), n = this.options;
                e ? (this.focus(t), i.hasClass(Q) && !i.hasClass(te) && clearTimeout(this.timers.hide)) : "mouse" === n.position.target && n.hide.event && n.show.target && !s.closest(n.show.target[0]).length && this.hide(t), i.toggleClass(Z, e)
            }), m("[" + Y + "]", U, f)
        }), C._trigger = function (t, e, i) {
            var s = o.Event("tooltip" + t);
            return s.originalEvent = i && o.extend({}, i) || this.cache.event || E, this.triggering = M, this.tooltip.trigger(s, [this].concat(e || [])), this.triggering = S, !s.isDefaultPrevented()
        }, C._assignEvents = function () {
            var i = this.options, n = i.position, r = this.tooltip, a = i.show.target, h = i.hide.target, l = n.container, c = n.viewport, p = o(e), m = (o(e.body), o(t)), v = i.show.event ? o.trim("" + i.show.event).split(" ") : [], y = i.hide.event ? o.trim("" + i.hide.event).split(" ") : [], b = [];
            /mouse(out|leave)/i.test(i.hide.event) && "window" === i.hide.leave && this._bind(p, ["mouseout", "blur"], function (t) {
                /select|option/.test(t.target.nodeName) || t.relatedTarget || this.hide(t)
            }), i.hide.fixed ? h = h.add(r.addClass(Q)) : /mouse(over|enter)/i.test(i.show.event) && this._bind(h, "mouseleave", function () {
                clearTimeout(this.timers.show)
            }), ("" + i.hide.event).indexOf("unfocus") > -1 && this._bind(l.closest("html"), ["mousedown", "touchstart"], function (t) {
                var e = o(t.target), i = this.rendered && !this.tooltip.hasClass(te) && this.tooltip[0].offsetWidth > 0, s = e.parents(G).filter(this.tooltip[0]).length > 0;
                e[0] === this.target[0] || e[0] === this.tooltip[0] || s || this.target.has(e[0]).length || !i || this.hide(t)
            }), "number" == typeof i.hide.inactive && (this._bind(a, "qtip-" + this.id + "-inactive", f), this._bind(h.add(r), T.inactiveEvents, f, "-inactive")), y = o.map(y, function (t) {
                var e = o.inArray(t, v);
                return e > -1 && h.add(a).length === h.length ? (b.push(v.splice(e, 1)[0]), s) : t
            }), this._bind(a, v, d), this._bind(h, y, u), this._bind(a, b, function (t) {
                (this.tooltip[0].offsetWidth > 0 ? u : d).call(this, t)
            }), this._bind(a.add(r), "mousemove", function (t) {
                if ("number" == typeof i.hide.distance) {
                    var e = this.cache.origin || {}, s = this.options.hide.distance, o = Math.abs;
                    (o(t.pageX - e.pageX) >= s || o(t.pageY - e.pageY) >= s) && this.hide(t)
                }
                this._storeMouse(t)
            }), "mouse" === n.target && n.adjust.mouse && (i.hide.event && this._bind(a, ["mouseenter", "mouseleave"], function (t) {
                this.cache.onTarget = "mouseenter" === t.type
            }), this._bind(p, "mousemove", function (t) {
                this.rendered && this.cache.onTarget && !this.tooltip.hasClass(te) && this.tooltip[0].offsetWidth > 0 && this.reposition(t)
            })), (n.adjust.resize || c.length) && this._bind(o.event.special.resize ? c : m, "resize", g), n.adjust.scroll && this._bind(m.add(n.container), "scroll", g)
        }, C._unassignEvents = function () {
            var i = [this.options.show.target[0], this.options.hide.target[0], this.rendered && this.tooltip[0], this.options.position.container[0], this.options.position.viewport[0], this.options.position.container.closest("html")[0], t, e];
            this.rendered ? this._unbind(o([]).pushStack(o.grep(i, function (t) {
                return"object" == typeof t
            }))) : o(i[0]).unbind("." + this._id + "-create")
        }, T = o.fn.qtip = function (t, e, i) {
            var n = ("" + t).toLowerCase(), r = E, a = o.makeArray(arguments).slice(1), l = a[a.length - 1], c = this[0] ? o.data(this[0], $) : E;
            return!arguments.length && c || "api" === n ? c : "string" == typeof t ? (this.each(function () {
                var t = o.data(this, $);
                if (!t)
                    return M;
                if (l && l.timeStamp && (t.cache.event = l), !e || "option" !== n && "options" !== n)
                    t[n] && t[n].apply(t, a);
                else {
                    if (i === s && !o.isPlainObject(e))
                        return r = t.get(e), S;
                    t.set(e, i)
                }
            }), r !== E ? r : this) : "object" != typeof t && arguments.length ? s : (c = h(o.extend(M, {}, t)), T.bind.call(this, c, l))
        }, T.bind = function (t, e) {
            return this.each(function (i) {
                function n(t) {
                    function e() {
                        c.render("object" == typeof t || r.show.ready), a.show.add(a.hide).unbind(l)
                    }
                    return c.disabled ? S : (c.cache.event = o.extend({}, t), c.cache.target = t ? o(t.target) : [s], r.show.delay > 0 ? (clearTimeout(c.timers.show), c.timers.show = setTimeout(e, r.show.delay), h.show !== h.hide && a.hide.bind(h.hide, function () {
                        clearTimeout(c.timers.show)
                    })) : e(), s)
                }
                var r, a, h, l, c, p;
                return p = o.isArray(t.id) ? t.id[i] : t.id, p = !p || p === S || 1 > p.length || T.api[p] ? T.nextid++ : p, l = ".qtip-" + p + "-create", c = v(o(this), p, t), c === S ? M : (T.api[p] = c, r = c.options, o.each(N, function () {
                    "initialize" === this.initialize && this(c)
                }), a = {show: r.show.target, hide: r.hide.target}, h = {show: o.trim("" + r.show.event).replace(/ /g, l + " ") + l, hide: o.trim("" + r.hide.event).replace(/ /g, l + " ") + l}, /mouse(over|enter)/i.test(h.show) && !/mouse(out|leave)/i.test(h.hide) && (h.hide += " mouseleave" + l), a.show.bind("mousemove" + l, function (t) {
                    c._storeMouse(t), c.cache.onTarget = M
                }), a.show.bind(h.show, n), (r.show.ready || r.prerender) && n(e), s)
            })
        }, T.api = {}, o.each({attr: function (t, e) {
                if (this.length) {
                    var i = this[0], s = "title", n = o.data(i, "qtip");
                    if (t === s && n && "object" == typeof n && n.options.suppress)
                        return 2 > arguments.length ? o.attr(i, ie) : (n && n.options.content.attr === s && n.cache.attr && n.set("content.text", e), this.attr(ie, e))
                }
                return o.fn["attr" + ee].apply(this, arguments)
            }, clone: function (t) {
                var e = (o([]), o.fn["clone" + ee].apply(this, arguments));
                return t || e.filter("[" + ie + "]").attr("title", function () {
                    return o.attr(this, ie)
                }).removeAttr(ie), e
            }}, function (t, e) {
            if (!e || o.fn[t + ee])
                return M;
            var i = o.fn[t + ee] = o.fn[t];
            o.fn[t] = function () {
                return e.apply(this, arguments) || i.apply(this, arguments)
            }
        }), o.ui || (o["cleanData" + ee] = o.cleanData, o.cleanData = function (t) {
            for (var e, i = 0; (e = o(t[i])).length; i++)
                if (e.attr(X))
                    try {
                        e.triggerHandler("removeqtip")
                    } catch (s) {
                    }
            o["cleanData" + ee].apply(this, arguments)
        }), T.version = "2.1.1", T.nextid = 0, T.inactiveEvents = U, T.zindex = 15e3, T.defaults = {prerender: S, id: S, overwrite: M, suppress: M, content: {text: M, attr: "title", title: S, button: S}, position: {my: "top left", at: "bottom right", target: S, container: S, viewport: S, adjust: {x: 0, y: 0, mouse: M, scroll: M, resize: M, method: "flipinvert flipinvert"}, effect: function (t, e) {
                    o(this).animate(e, {duration: 200, queue: S})
                }}, show: {target: S, event: "mouseenter", effect: M, delay: 90, solo: S, ready: S, autofocus: S}, hide: {target: S, event: "mouseleave", effect: M, delay: 0, fixed: S, inactive: S, leave: "window", distance: S}, style: {classes: "", widget: S, width: S, height: S, def: M}, events: {render: E, move: E, show: E, hide: E, toggle: E, visible: E, hidden: E, focus: E, blur: E}};
        var ae, he = "margin", le = "border", ce = "color", pe = "background-color", de = "transparent", ue = " !important", fe = !!e.createElement("canvas").getContext, ge = /rgba?\(0, 0, 0(, 0)?\)|transparent|#123456/i, me = {}, ve = ["Webkit", "O", "Moz", "ms"];
        fe || (createVML = function (t, e, i) {
            return"<qtipvml:" + t + ' xmlns="urn:schemas-microsoft.com:vml" class="qtip-vml" ' + (e || "") + ' style="behavior: url(#default#VML); ' + (i || "") + '" />'
        }), o.extend(x.prototype, {init: function (t) {
                var e, i;
                i = this.element = t.elements.tip = o("<div />", {"class": $ + "-tip"}).prependTo(t.tooltip), fe ? (e = o("<canvas />").appendTo(this.element)[0].getContext("2d"), e.lineJoin = "miter", e.miterLimit = 100, e.save()) : (e = createVML("shape", 'coordorigin="0,0"', "position:absolute;"), this.element.html(e + e), t._bind(o("*", i).add(i), ["click", "mousedown"], function (t) {
                    t.stopPropagation()
                }, this._ns)), t._bind(t.tooltip, "tooltipmove", this.reposition, this._ns, this), this.create()
            }, _swapDimensions: function () {
                this.size[0] = this.options.height, this.size[1] = this.options.width
            }, _resetDimensions: function () {
                this.size[0] = this.options.width, this.size[1] = this.options.height
            }, _useTitle: function (t) {
                var e = this.qtip.elements.titlebar;
                return e && (t.y === B || t.y === D && this.element.position().top + this.size[1] / 2 + this.options.offset < e.outerHeight(M))
            }, _parseCorner: function (t) {
                var e = this.qtip.options.position.my;
                return t === S || e === S ? t = S : t === M ? t = new j(e.string()) : t.string || (t = new j(t), t.fixed = M), t
            }, _parseWidth: function (t, e, i) {
                var s = this.qtip.elements, o = le + y(e) + "Width";
                return(i ? w(i, o) : w(s.content, o) || w(this._useTitle(t) && s.titlebar || s.content, o) || w(tooltip, o)) || 0
            }, _parseRadius: function (t) {
                var e = this.qtip.elements, i = le + y(t.y) + y(t.x) + "Radius";
                return 9 > BROWSER.ie ? 0 : w(this._useTitle(t) && e.titlebar || e.content, i) || w(e.tooltip, i) || 0
            }, _invalidColour: function (t, e, i) {
                var s = t.css(e);
                return!s || i && s === t.css(i) || ge.test(s) ? S : s
            }, _parseColours: function (t) {
                var e = this.qtip.elements, i = this.element.css("cssText", ""), s = le + y(t[t.precedance]) + y(ce), n = this._useTitle(t) && e.titlebar || e.content, r = this._invalidColour, a = [];
                return a[0] = r(i, pe) || r(n, pe) || r(e.content, pe) || r(tooltip, pe) || i.css(pe), a[1] = r(i, s, ce) || r(n, s, ce) || r(e.content, s, ce) || r(tooltip, s, ce) || tooltip.css(s), o("*", i).add(i).css("cssText", pe + ":" + de + ue + ";" + le + ":0" + ue + ";"), a
            }, _calculateSize: function (t) {
                var e, i, s, o = t.precedance === R, n = this.options[o ? "height" : "width"], r = this.options[o ? "width" : "height"], a = "c" === t.abbrev(), h = n * (a ? .5 : 1), l = Math.pow, c = Math.round, p = Math.sqrt(l(h, 2) + l(r, 2)), d = [this.border / h * p, this.border / r * p];
                return d[2] = Math.sqrt(l(d[0], 2) - l(this.border, 2)), d[3] = Math.sqrt(l(d[1], 2) - l(this.border, 2)), e = p + d[2] + d[3] + (a ? 0 : d[0]), i = e / p, s = [c(i * n), c(i * r)], o ? s : s.reverse()
            }, _calculateTip: function (t) {
                var e = this.size[0], i = this.size[1], s = Math.ceil(e / 2), o = Math.ceil(i / 2), n = {br: [0, 0, e, i, e, 0], bl: [0, 0, e, 0, 0, i], tr: [0, i, e, 0, e, i], tl: [0, 0, 0, i, e, i], tc: [0, i, s, 0, e, i], bc: [0, 0, e, 0, s, i], rc: [0, 0, e, o, 0, i], lc: [e, 0, e, i, 0, o]};
                return n.lt = n.br, n.rt = n.bl, n.lb = n.tr, n.rb = n.tl, n[t.abbrev()]
            }, create: function () {
                var t = this.corner = (fe || BROWSER.ie) && this._parseCorner(this.options.corner);
                return(this.enabled = !!this.corner && "c" !== this.corner.abbrev()) && (this.qtip.cache.corner = t.clone(), this.update()), this.element.toggle(this.enabled), this.corner
            }, update: function (t, e) {
                if (!this.enabled)
                    return this;
                var i, s, n, r, a, h, l, c = (this.qtip.elements, this.element), p = c.children(), d = this.options, u = this.size, f = d.mimic, g = Math.round;
                t || (t = this.qtip.cache.corner || this.corner), f === S ? f = t : (f = new j(f), f.precedance = t.precedance, "inherit" === f.x ? f.x = t.x : "inherit" === f.y ? f.y = t.y : f.x === f.y && (f[t.precedance] = t[t.precedance])), s = f.precedance, t.precedance === O ? this._swapDimensions() : this._resetDimensions(), i = this.color = this._parseColours(t), i[1] !== de ? (l = this.border = this._parseWidth(t, t[t.precedance]), d.border && 1 > l && (i[0] = i[1]), this.border = l = d.border !== M ? d.border : l) : this.border = l = 0, r = this._calculateTip(f), h = this.size = this._calculateSize(t), c.css({width: h[0], height: h[1], lineHeight: h[1] + "px"}), a = t.precedance === R ? [g(f.x === L ? l : f.x === V ? h[0] - u[0] - l : (h[0] - u[0]) / 2), g(f.y === B ? h[1] - u[1] : 0)] : [g(f.x === L ? h[0] - u[0] : 0), g(f.y === B ? l : f.y === P ? h[1] - u[1] - l : (h[1] - u[1]) / 2)], fe ? (p.attr(I, h[0]).attr(k, h[1]), n = p[0].getContext("2d"), n.restore(), n.save(), n.clearRect(0, 0, 3e3, 3e3), n.fillStyle = i[0], n.strokeStyle = i[1], n.lineWidth = 2 * l, n.translate(a[0], a[1]), n.beginPath(), n.moveTo(r[0], r[1]), n.lineTo(r[2], r[3]), n.lineTo(r[4], r[5]), n.closePath(), l && ("border-box" === tooltip.css("background-clip") && (n.strokeStyle = i[0], n.stroke()), n.strokeStyle = i[1], n.stroke()), n.fill()) : (r = "m" + r[0] + "," + r[1] + " l" + r[2] + "," + r[3] + " " + r[4] + "," + r[5] + " xe", a[2] = l && /^(r|b)/i.test(t.string()) ? 8 === BROWSER.ie ? 2 : 1 : 0, p.css({coordsize: u[0] + l + " " + (u[1] + l), antialias: "" + (f.string().indexOf(D) > -1), left: a[0] - a[2] * Number(s === O), top: a[1] - a[2] * Number(s === R), width: u[0] + l, height: u[1] + l}).each(function (t) {
                    var e = o(this);
                    e[e.prop ? "prop" : "attr"]({coordsize: u[0] + l + " " + (u[1] + l), path: r, fillcolor: i[0], filled: !!t, stroked: !t}).toggle(!(!l && !t)), !t && e.html(createVML("stroke", 'weight="' + 2 * l + 'px" color="' + i[1] + '" miterlimit="1000" joinstyle="miter"'))
                })), e !== S && this.calculate(t)
            }, calculate: function (t) {
                if (!this.enabled)
                    return S;
                var e, i, s, n = this, r = this.qtip.elements, a = this.element, h = this.options.offset, l = (this.qtip.tooltip.hasClass("ui-widget"), {});
                return t = t || this.corner, e = t.precedance, i = this._calculateSize(t), s = [t.x, t.y], e === O && s.reverse(), o.each(s, function (s, o) {
                    var a, c, p;
                    o === D ? (a = e === R ? L : B, l[a] = "50%", l[he + "-" + a] = -Math.round(i[e === R ? 0 : 1] / 2) + h) : (a = n._parseWidth(t, o, r.tooltip), c = n._parseWidth(t, o, r.content), p = n._parseRadius(t), l[o] = Math.max(-n.border, s ? c : h + (p > a ? p : -a)))
                }), l[t[e]] -= i[e === O ? 0 : 1], a.css({margin: "", top: "", bottom: "", left: "", right: ""}).css(l), l
            }, reposition: function (t, e, i) {
                if (this.enabled) {
                    var o, n, r = e.cache, a = this.corner.clone(), h = i.adjusted, l = e.options.position.adjust.method.split(" "), c = l[0], p = l[1] || l[0], d = {left: S, top: S, x: 0, y: 0}, u = {};
                    this.corner.fixed !== M && (c === F && a.precedance === O && h.left && a.y !== D ? a.precedance = a.precedance === O ? R : O : c !== F && h.left && (a.x = a.x === D ? h.left > 0 ? L : V : a.x === L ? V : L), p === F && a.precedance === R && h.top && a.x !== D ? a.precedance = a.precedance === R ? O : R : p !== F && h.top && (a.y = a.y === D ? h.top > 0 ? B : P : a.y === B ? P : B), a.string() === r.corner.string() || r.cornerTop === h.top && r.cornerLeft === h.left || this.update(a, S)), o = this.calculate(a, h), o.right !== s && (o.left = -o.right), o.bottom !== s && (o.top = -o.bottom), o.user = this.offset, (d.left = c === F && !!h.left) && (a.x === D ? u[he + "-left"] = d.x = o[he + "-left"] - h.left : (n = o.right !== s ? [h.left, -o.left] : [-h.left, o.left], (d.x = Math.max(n[0], n[1])) > n[0] && (i.left -= h.left, d.left = S), u[o.right !== s ? V : L] = d.x)), (d.top = p === F && !!h.top) && (a.y === D ? u[he + "-top"] = d.y = o[he + "-top"] - h.top : (n = o.bottom !== s ? [h.top, -o.top] : [-h.top, o.top], (d.y = Math.max(n[0], n[1])) > n[0] && (i.top -= h.top, d.top = S), u[o.bottom !== s ? P : B] = d.y)), this.element.css(u).toggle(!(d.x && d.y || a.x === D && d.y || a.y === D && d.x)), i.left -= o.left.charAt ? o.user : c !== F || d.top || !d.left && !d.top ? o.left : 0, i.top -= o.top.charAt ? o.user : p !== F || d.left || !d.left && !d.top ? o.top : 0, r.cornerLeft = h.left, r.cornerTop = h.top, r.corner = a.clone()
                }
            }, destroy: function () {
                this.qtip._unbind(this.qtip.tooltip, this._ns), this.qtip.elements.tip && this.qtip.elements.tip.find("*").remove().end().remove()
            }}), ae = N.tip = function (t) {
            return new x(t, t.options.style.tip)
        }, ae.initialize = "render", ae.sanitize = function (t) {
            t.style && "tip"in t.style && (opts = t.style.tip, "object" != typeof opts && (opts = t.style.tip = {corner: opts}), /string|boolean/i.test(typeof opts.corner) || (opts.corner = M))
        }, z.tip = {"^position.my|style.tip.(corner|mimic|border)$": function () {
                this.create(), this.qtip.reposition()
            }, "^style.tip.(height|width)$": function (t) {
                this.size = size = [t.width, t.height], this.update(), this.qtip.reposition()
            }, "^content.title|style.(classes|widget)$": function () {
                this.update()
            }}, o.extend(M, T.defaults, {style: {tip: {corner: M, mimic: S, width: 6, height: 6, border: M, offset: 0}}});
        var ye, be, we = "qtip-modal", xe = "." + we;
        be = function () {
            function i(t) {
                if (o.expr[":"].focusable)
                    return o.expr[":"].focusable;
                var e, i, s, n = !isNaN(o.attr(t, "tabindex")), r = t.nodeName && t.nodeName.toLowerCase();
                return"area" === r ? (e = t.parentNode, i = e.name, t.href && i && "map" === e.nodeName.toLowerCase() ? (s = o("img[usemap=#" + i + "]")[0], !!s && s.is(":visible")) : !1) : /input|select|textarea|button|object/.test(r) ? !t.disabled : "a" === r ? t.href || n : n
            }
            function s(t) {
                1 > p.length && t.length ? t.not("body").blur() : p.first().focus()
            }
            function n(t) {
                if (l.is(":visible")) {
                    var e, i = o(t.target), n = r.tooltip, h = i.closest(G);
                    e = 1 > h.length ? S : parseInt(h[0].style.zIndex, 10) > parseInt(n[0].style.zIndex, 10), e || i.closest(G)[0] === n[0] || s(i), a = t.target === p[p.length - 1]
                }
            }
            var r, a, h, l, c = this, p = {};
            o.extend(c, {init: function () {
                    function i() {
                        var t = o(this);
                        l.css({height: t.height(), width: t.width()})
                    }
                    return l = c.elem = o("<div />", {id: "qtip-overlay", html: "<div></div>", mousedown: function () {
                            return S
                        }}).hide(), o(t).bind("resize" + xe, i), i(), o(e.body).bind("focusin" + xe, n), o(e).bind("keydown" + xe, function (t) {
                        r && r.options.show.modal.escape && 27 === t.keyCode && r.hide(t)
                    }), l.bind("click" + xe, function (t) {
                        r && r.options.show.modal.blur && r.hide(t)
                    }), c
                }, update: function (t) {
                    r = t, p = t.options.show.modal.stealfocus !== S ? t.tooltip.find("*").filter(function () {
                        return i(this)
                    }) : []
                }, toggle: function (t, i, n) {
                    var a = (o(e.body), t.tooltip), p = t.options.show.modal, d = p.effect, u = i ? "show" : "hide", f = l.is(":visible"), g = o(xe).filter(":visible:not(:animated)").not(a);
                    return c.update(t), i && p.stealfocus !== S && s(o(":focus")), l.toggleClass("blurs", p.blur), i && l.css({left: 0, top: 0}).appendTo(e.body), l.is(":animated") && f === i && h !== S || !i && g.length ? c : (l.stop(M, S), o.isFunction(d) ? d.call(l, i) : d === S ? l[u]() : l.fadeTo(parseInt(n, 10) || 90, i ? 1 : 0, function () {
                        i || l.hide()
                    }), i || l.queue(function (t) {
                        l.css({left: "", top: ""}), o(xe).length || l.detach(), t()
                    }), h = i, r.destroyed && (r = E), c)
                }}), c.init()
        }, be = new be, o.extend(_.prototype, {init: function (t) {
                var e = t.tooltip;
                return this.options.on ? (t.elements.overlay = be.elem, e.addClass(we).css("z-index", N.modal.zindex + o(xe).length), t._bind(e, ["tooltipshow", "tooltiphide"], function (t, i, s) {
                    var n = t.originalEvent;
                    if (t.target === e[0])
                        if (n && "tooltiphide" === t.type && /mouse(leave|enter)/.test(n.type) && o(n.relatedTarget).closest(overlay[0]).length)
                            try {
                                t.preventDefault()
                            } catch (r) {
                            }
                        else
                            (!n || n && !n.solo) && this.toggle(t, "tooltipshow" === t.type, s)
                }, this._ns, this), t._bind(e, "tooltipfocus", function (t, i) {
                    if (!t.isDefaultPrevented() && t.target === e[0]) {
                        var s = o(xe), n = N.modal.zindex + s.length, r = parseInt(e[0].style.zIndex, 10);
                        be.elem[0].style.zIndex = n - 1, s.each(function () {
                            this.style.zIndex > r && (this.style.zIndex -= 1)
                        }), s.filter("." + K).qtip("blur", t.originalEvent), e.addClass(K)[0].style.zIndex = n, be.update(i);
                        try {
                            t.preventDefault()
                        } catch (a) {
                        }
                    }
                }, this._ns, this), t._bind(e, "tooltiphide", function (t) {
                    t.target === e[0] && o(xe).filter(":visible").not(e).last().qtip("focus", t)
                }, this._ns, this), s) : this
            }, toggle: function (t, e, i) {
                return t && t.isDefaultPrevented() ? this : (be.toggle(this.qtip, !!e, i), s)
            }, destroy: function () {
                this.qtip.tooltip.removeClass(we), this.qtip._unbind(this.qtip.tooltip, this._ns), be.toggle(this.qtip, S), delete this.qtip.elements.overlay
            }}), ye = N.modal = function (t) {
            return new _(t, t.options.show.modal)
        }, ye.sanitize = function (t) {
            t.show && ("object" != typeof t.show.modal ? t.show.modal = {on: !!t.show.modal} : t.show.modal.on === s && (t.show.modal.on = M))
        }, ye.zindex = T.zindex - 200, ye.initialize = "render", z.modal = {"^show.modal.(on|blur)$": function () {
                this.destroy(), this.init(), this.qtip.elems.overlay.toggle(this.qtip.tooltip[0].offsetWidth > 0)
            }}, o.extend(M, T.defaults, {show: {modal: {on: S, effect: M, blur: M, stealfocus: M, escape: M}}}), N.viewport = function (i, s, o, n, r, a, h) {
            function l(t, e, i, o, n, r, a, h, l) {
                var c = s[n], d = g[t], u = m[t], f = i === F, v = -_.offset[n] + x.offset[n] + x["scroll" + n], y = d === n ? l : d === r ? -l : -l / 2, b = u === n ? h : u === r ? -h : -h / 2, w = T && T.size ? T.size[a] || 0 : 0, q = T && T.corner && T.corner.precedance === t && !f ? w : 0, C = v - c + q, j = c + l - x[a] - v + q, z = y - (g.precedance === t || d === g[e] ? b : 0) - (u === D ? h / 2 : 0);
                return f ? (q = T && T.corner && T.corner.precedance === e ? w : 0, z = (d === n ? 1 : -1) * y - q, s[n] += C > 0 ? C : j > 0 ? -j : 0, s[n] = Math.max(-_.offset[n] + x.offset[n] + (q && T.corner[t] === D ? T.offset : 0), c - z, Math.min(Math.max(-_.offset[n] + x.offset[n] + x[a], c + z), s[n]))) : (o *= i === A ? 2 : 0, C > 0 && (d !== n || j > 0) ? (s[n] -= z + o, p.invert(t, n)) : j > 0 && (d !== r || C > 0) && (s[n] -= (d === D ? -z : z) + o, p.invert(t, r)), v > s[n] && -s[n] > j && (s[n] = c, p = g.clone())), s[n] - c
            }
            var c, p, d, u = o.target, f = i.elements.tooltip, g = o.my, m = o.at, v = o.adjust, y = v.method.split(" "), b = y[0], w = y[1] || y[0], x = o.viewport, _ = o.container, q = i.cache, T = i.plugins.tip, C = {left: 0, top: 0};
            return x.jquery && u[0] !== t && u[0] !== e.body && "none" !== v.method ? (c = "fixed" === f.css("position"), x = {elem: x, width: x[0] === t ? x.width() : x.outerWidth(S), height: x[0] === t ? x.height() : x.outerHeight(S), scrollleft: c ? 0 : x.scrollLeft(), scrolltop: c ? 0 : x.scrollTop(), offset: x.offset() || {left: 0, top: 0}}, _ = {elem: _, scrollLeft: _.scrollLeft(), scrollTop: _.scrollTop(), offset: _.offset() || {left: 0, top: 0}}, ("shift" !== b || "shift" !== w) && (p = g.clone()), C = {left: "none" !== b ? l(O, R, b, v.x, L, V, I, n, a) : 0, top: "none" !== w ? l(R, O, w, v.y, B, P, k, r, h) : 0}, p && q.lastClass !== (d = $ + "-pos-" + p.abbrev()) && f.removeClass(i.cache.lastClass).addClass(i.cache.lastClass = d), C) : C
        }, N.polys = {polygon: function (t, e) {
                var i, s, o, n = {width: 0, height: 0, position: {top: 1e10, right: 0, bottom: 0, left: 1e10}, adjustable: S}, r = 0, a = [], h = 1, l = 1, c = 0, p = 0;
                for (r = t.length; r--; )
                    i = [parseInt(t[--r], 10), parseInt(t[r + 1], 10)], i[0] > n.position.right && (n.position.right = i[0]), i[0] < n.position.left && (n.position.left = i[0]), i[1] > n.position.bottom && (n.position.bottom = i[1]), i[1] < n.position.top && (n.position.top = i[1]), a.push(i);
                if (s = n.width = Math.abs(n.position.right - n.position.left), o = n.height = Math.abs(n.position.bottom - n.position.top), "c" === e.abbrev())
                    n.position = {left: n.position.left + n.width / 2, top: n.position.top + n.height / 2};
                else {
                    for (; s > 0 && o > 0 && h > 0 && l > 0; )
                        for (s = Math.floor(s / 2), o = Math.floor(o / 2), e.x === L?h = s:e.x === V?h = n.width - s:h += Math.floor(s / 2), e.y === B?l = o:e.y === P?l = n.height - o:l += Math.floor(o / 2), r = a.length; r-- && !(2 > a.length); )
                            c = a[r][0] - n.position.left, p = a[r][1] - n.position.top, (e.x === L && c >= h || e.x === V && h >= c || e.x === D && (h > c || c > n.width - h) || e.y === B && p >= l || e.y === P && l >= p || e.y === D && (l > p || p > n.height - l)) && a.splice(r, 1);
                    n.position = {left: a[0][0], top: a[0][1]}
                }
                return n
            }, rect: function (t, e, i, s) {
                return{width: Math.abs(i - t), height: Math.abs(s - e), position: {left: Math.min(t, i), top: Math.min(e, s)}}
            }, _angles: {tc: 1.5, tr: 7 / 4, tl: 5 / 4, bc: .5, br: .25, bl: .75, rc: 2, lc: 1, c: 0}, ellipse: function (t, e, i, s, o) {
                var n = N.polys._angles[o.abbrev()], r = i * Math.cos(n * Math.PI), a = s * Math.sin(n * Math.PI);
                return{width: 2 * i - Math.abs(r), height: 2 * s - Math.abs(a), position: {left: t + r, top: e + a}, adjustable: S}
            }, circle: function (t, e, i, s) {
                return N.polys.ellipse(t, e, i, i, s)
            }}, N.svg = function (t, s, n) {
            for (var r, a, h, l = o(e), c = s[0], p = {}; !c.getBBox; )
                c = c.parentNode;
            if (!c.getBBox || !c.parentNode)
                return S;
            switch (c.nodeName) {
                case"rect":
                    a = N.svg.toPixel(c, c.x.baseVal.value, c.y.baseVal.value), h = N.svg.toPixel(c, c.x.baseVal.value + c.width.baseVal.value, c.y.baseVal.value + c.height.baseVal.value), p = N.polys.rect(a[0], a[1], h[0], h[1], n);
                    break;
                case"ellipse":
                case"circle":
                    a = N.svg.toPixel(c, c.cx.baseVal.value, c.cy.baseVal.value), p = N.polys.ellipse(a[0], a[1], (c.rx || c.r).baseVal.value, (c.ry || c.r).baseVal.value, n);
                    break;
                case"line":
                case"polygon":
                case"polyline":
                    for (points = c.points || [{x:c.x1.baseVal.value, y:c.y1.baseVal.value}, {x:c.x2.baseVal.value, y:c.y2.baseVal.value}], p = [], i = - 1, len = points.numberOfItems || points.length; len > ++i; )
                        next = points.getItem ? points.getItem(i) : points[i], p.push.apply(p, N.svg.toPixel(c, next.x, next.y));
                    p = N.polys.polygon(p, n);
                    break;
                default:
                    if (r = c.getBBox(), mtx = c.getScreenCTM(), root = c.farthestViewportElement || c, !root.createSVGPoint)
                        return S;
                    point = root.createSVGPoint(), point.x = r.x, point.y = r.y, tPoint = point.matrixTransform(mtx), p.position = {left: tPoint.x, top: tPoint.y}, point.x += r.width, point.y += r.height, tPoint = point.matrixTransform(mtx), p.width = tPoint.x - p.position.left, p.height = tPoint.y - p.position.top
            }
            return p.position.left += l.scrollLeft(), p.position.top += l.scrollTop(), p
        }, N.svg.toPixel = function (t, e, i) {
            var s, o, n = t.getScreenCTM(), r = t.farthestViewportElement || t;
            return r.createSVGPoint ? (o = r.createSVGPoint(), o.x = e, o.y = i, s = o.matrixTransform(n), [s.x, s.y]) : S
        }, N.imagemap = function (t, e, i) {
            e.jquery || (e = o(e));
            var s, n, r, a = e.attr("shape").toLowerCase().replace("poly", "polygon"), h = o('img[usemap="#' + e.parent("map").attr("name") + '"]'), l = e.attr("coords"), c = l.split(",");
            if (!h.length)
                return S;
            if ("polygon" === a)
                result = N.polys.polygon(c, i);
            else {
                if (!N.polys[a])
                    return S;
                for (r = - 1, len = c.length, n = []; len > ++r; )
                    n.push(parseInt(c[r], 10));
                result = N.polys[a].apply(this, n.concat(i))
            }
            return s = h.offset(), s.left += Math.ceil((h.outerWidth(S) - h.width()) / 2), s.top += Math.ceil((h.outerHeight(S) - h.height()) / 2), result.position.left += s.left, result.position.top += s.top, result
        };
        var _e, qe = '<iframe class="qtip-bgiframe" frameborder="0" tabindex="-1" src="javascript:\'\';"  style="display:block; position:absolute; z-index:-1; filter:alpha(opacity=0); -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";"></iframe>';
        o.extend(q.prototype, {_scroll: function () {
                var e = this.qtip.elements.overlay;
                e && (e[0].style.top = o(t).scrollTop() + "px")
            }, init: function (i) {
                var s = i.tooltip;
                1 > o("select, object").length && (this.bgiframe = i.elements.bgiframe = o(qe).appendTo(s), i._bind(s, "tooltipmove", this.adjustBGIFrame, this._ns, this)), this.redrawContainer = o("<div/>", {id: $ + "-rcontainer"}).appendTo(e.body), i.elements.overlay && i.elements.overlay.addClass("qtipmodal-ie6fix") && (i._bind(t, ["scroll", "resize"], this._scroll, this._ns, this), i._bind(s, ["tooltipshow"], this._scroll, this._ns, this)), this.redraw()
            }, adjustBGIFrame: function () {
                var t, e, i = this.qtip.tooltip, s = {height: i.outerHeight(S), width: i.outerWidth(S)}, o = this.qtip.plugins.tip, n = this.qtip.elements.tip;
                e = parseInt(i.css("borderLeftWidth"), 10) || 0, e = {left: -e, top: -e}, o && n && (t = "x" === o.corner.precedance ? [I, L] : [k, B], e[t[1]] -= n[t[0]]()), this.bgiframe.css(e).css(s)
            }, redraw: function () {
                if (1 > this.qtip.rendered || this.drawing)
                    return self;
                var t, e, i, s, o = this.qtip.tooltip, n = this.qtip.options.style, r = this.qtip.options.position.container;
                return this.qtip.drawing = 1, n.height && o.css(k, n.height), n.width ? o.css(I, n.width) : (o.css(I, "").appendTo(this.redrawContainer), e = o.width(), 1 > e % 2 && (e += 1), i = o.css("maxWidth") || "", s = o.css("minWidth") || "", t = (i + s).indexOf("%") > -1 ? r.width() / 100 : 0, i = (i.indexOf("%") > -1 ? t : 1) * parseInt(i, 10) || e, s = (s.indexOf("%") > -1 ? t : 1) * parseInt(s, 10) || 0, e = i + s ? Math.min(Math.max(e, s), i) : e, o.css(I, Math.round(e)).appendTo(r)), this.drawing = 0, self
            }, destroy: function () {
                this.bgiframe && this.bgiframe.remove(), this.qtip._unbind([t, this.qtip.tooltip], this._ns)
            }}), _e = N.ie6 = function (t) {
            return 6 === BROWSER.ie ? new q(t) : S
        }, _e.initialize = "render", z.ie6 = {"^content|style$": function () {
                this.redraw()
            }}
    })
})(window, document);