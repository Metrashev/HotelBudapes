﻿/*! JsRender v1.0.0-beta: http://github.com/BorisMoore/jsrender and http://jsviews.com/jsviews
 informal pre V1.0 commit counter: 42 */
        (function (n, t, i) {
            "use strict";
            function it(n, t) {
                t && t.onError && t.onError(n) === !1 || (this.name = "JsRender Error", this.message = n || "JsRender error")
            }
            function o(n, t) {
                var i;
                n = n || {};
                for (i in t)
                    n[i] = t[i];
                return n
            }
            function ct(n, t, i) {
                return(!k.rTag || arguments.length) && (v = n ? n.charAt(0) : v, y = n ? n.charAt(1) : y, f = t ? t.charAt(0) : f, h = t ? t.charAt(1) : h, w = i || w, n = "\\" + v + "(\\" + w + ")?\\" + y, t = "\\" + f + "\\" + h, a = "(?:(?:(\\w+(?=[\\/\\s\\" + f + "]))|(?:(\\w+)?(:)|(>)|!--((?:[^-]|-(?!-))*)--|(\\*)))\\s*((?:[^\\" + f + "]|\\" + f + "(?!\\" + h + "))*?)", k.rTag = a + ")", a = new RegExp(n + a + "(\\/)?|(?:\\/(\\w+)))" + t, "g"), et = new RegExp("<.*>|([^\\\\]|^)[{}]|" + n + ".*" + t)), [v, y, f, h, w]
            }
            function ei(n, t) {
                t || (t = n, n = i);
                var e, f, o, u, r = this, s = !t || t === "root";
                if (n) {
                    if (u = r.type === t ? r : i, !u)
                        if (e = r.views, r._.useKey) {
                            for (f in e)
                                if (u = e[f].get(n, t))
                                    break
                        } else
                            for (f = 0, o = e.length; !u && f < o; f++)
                                u = e[f].get(n, t)
                } else if (s)
                    while (r.parent.parent)
                        u = r = r.parent;
                else
                    while (r && !u)
                        u = r.type === t ? r : i, r = r.parent;
                return u
            }
            function lt() {
                var n = this.get("item");
                return n ? n.index : i
            }
            function oi(n, t) {
                var u, f = this, r = t && t[n] || (f.ctx || {})[n];
                return r = r === i ? f.getRsc("helpers", n) : r, r && typeof r == "function" && (u = function () {
                    return r.apply(f, arguments)
                }, o(u, r)), u || r
            }
            function si(n, t, u) {
                var h, f, s, e = +u === u && u, o = t.linkCtx;
                return e && (u = (e = t.tmpl.bnds[e - 1])(t.data, t, r)), s = u.args[0], (n || e) && (f = o && o.tag || {_: {inline: !o, bnd: e}, tagName: n + ":", flow: !0, _is: "tag"}, o && (o.tag = f, f.linkCtx = f.linkCtx || o, u.ctx = l(u.ctx, o.view.ctx)), f.tagCtx = u, u.view = t, f.ctx = u.ctx || {}, delete u.ctx, t._.tag = f, n = n !== "true" && n, n && ((h = t.getRsc("converters", n)) || c("Unknown converter: {{" + n + ":")) && (f.depends = h.depends, s = h.apply(f, u.args)), s = e && t._.onRender ? t._.onRender(s, t, e) : s, t._.tag = i), s
            }
            function hi(n, t) {
                for (var e = this, u = r[n], f = u && u[t]; f === i && e; )
                    u = e.tmpl[n], f = u && u[t], e = e.parent;
                return f
            }
            function ci(n, t, u, f, s) {
                var et, h, ot, it, g, v, ut, p, a, nt, k, st, w, ft, b = "", tt = +f === f && f, y = t.linkCtx || 0, d = t.ctx, ht = u || t.tmpl, ct = t._;
                for (n._is === "tag" && (h = n, n = h.tagName), tt && (f = (st = ht.bnds[tt - 1])(t.data, t, r)), ut = f.length, h = h || y.tag, v = 0; v < ut; v++)
                    a = f[v], k = a.tmpl, k = a.content = k && ht.tmpls[k - 1], u = a.props.tmpl, v || u && h || (w = t.getRsc("tags", n) || c("Unknown tag: {{" + n + "}}")), u = u || (h ? h : w).template || k, u = "" + u === u ? t.getRsc("templates", u) || e(u) : u, o(a, {tmpl: u, render: rt, index: v, view: t, ctx: l(a.ctx, d)}), h || (w._ctr ? (h = new w._ctr, ft = !!h.init, h.attr = h.attr || w.attr || i) : h = {render: w.render}, h._ = {inline: !y}, y && (y.attr = h.attr = y.attr || h.attr, y.tag = h, h.linkCtx = y), (h._.bnd = st || y.fn) ? h._.arrVws = {} : h.dataBoundOnly && c("{^{" + n + "}} tag must be data-bound"), h.tagName = n, h.parent = g = d && d.tag, h._is = "tag", h._def = w), ct.tag = h, a.tag = h, h.tagCtxs = f, h.flow || (nt = a.ctx = a.ctx || {}, ot = h.parents = nt.parentTags = d && l(nt.parentTags, d.parentTags) || {}, g && (ot[g.tagName] = g), nt.tag = h);
                for (h.rendering = {}, v = 0; v < ut; v++)
                    a = h.tagCtx = f[v], h.ctx = a.ctx, !v && ft && (h.init(a, y, h.ctx), ft = i), p = i, (et = h.render) && (p = et.apply(h, a.args)), p = p !== i ? p : a.tmpl && a.render() || (s ? i : ""), b = b ? b + (p || "") : p;
                return delete h.rendering, h.tagCtx = h.tagCtxs[0], h.ctx = h.tagCtx.ctx, h._.inline && (it = h.attr) && it !== "html" && (b = it === "text" ? wt.html(b) : ""), tt && t._.onRender ? t._.onRender(b, t, tt) : b
            }
            function b(n, t, r, u, f, e, o, s) {
                var c, l, a, y = t === "array", v = {key: 0, useKey: y ? 0 : 1, id: "" + fi++, onRender: s, bnds: {}}, h = {data: u, tmpl: f, content: o, views: y ? [] : {}, parent: r, ctx: n, type: t, get: ei, getIndex: lt, getRsc: hi, hlp: oi, _: v, _is: "view"};
                return r && (c = r.views, l = r._, l.useKey ? (c[v.key = "_" + l.useKey++] = h, a = l.tag, v.bnd = y && (!a || !!a._.bnd && a)) : c.splice(v.key = h.index = e !== i ? e : c.length, 0, h), h.ctx = n || r.ctx), h
            }
            function li(n) {
                var t, i, r, u, f;
                for (t in p)
                    if (u = p[t], (f = u.compile) && (i = n[t + "s"]))
                        for (r in i)
                            i[r] = f(r, i[r], n, t, u)
            }
            function ai(n, t, i) {
                var u, r;
                return typeof t == "function" ? t = {depends: t.depends, render: t} : ((r = t.template) && (t.template = "" + r === r ? e[r] || e(r) : r), t.init !== !1 && (u = t._ctr = function () {
                }, (u.prototype = t).constructor = u)), i && (t._parentTmpl = i), t
            }
            function at(r, u, f, o, s, h) {
                function v(i) {
                    if ("" + i === i || i.nodeType > 0) {
                        try {
                            a = i.nodeType > 0 ? i : !et.test(i) && t && t(n.document).find(i)[0]
                        } catch (u) {
                        }
                        return a && (i = a.getAttribute(ht), r = r || i, i = e[i], i || (r = r || "_" + ui++, a.setAttribute(ht, r), i = e[r] = at(r, a.innerHTML, f, o, s, h))), i
                    }
                }
                var c, a;
                return u = u || "", c = v(u), h = h || (u.markup ? u : {}), h.tmplName = r, f && (h._parentTmpl = f), !c && u.markup && (c = v(u.markup)) && c.fn && (c.debug !== u.debug || c.allowCode !== u.allowCode) && (c = c.markup), c !== i ? (r && !f && (tt[r] = function () {
                    return u.render.apply(u, arguments)
                }), c.fn || u.fn ? c.fn && (u = r && r !== c.tmplName ? l(h, c) : c) : (u = vt(c, h), ut(c, u)), li(h), u) : void 0
            }
            function vt(n, t) {
                var i, f = d.wrapMap || {}, r = o({markup: n, tmpls: [], links: {}, tags: {}, bnds: [], _is: "template", render: rt}, t);
                return t.htmlTag || (i = ii.exec(n), r.htmlTag = i ? i[1].toLowerCase() : ""), i = f[r.htmlTag], i && i !== f.div && (r.markup = u.trim(r.markup), r._elCnt = !0), r
            }
            function vi(n, t) {
                function u(e, o, s) {
                    var l, h, a, c;
                    if (e && "" + e !== e && !e.nodeType && !e.markup) {
                        for (a in e)
                            u(a, e[a], o);
                        return r
                    }
                    return o === i && (o = e, e = i), e && "" + e !== e && (s = o, o = e, e = i), c = s ? s[f] = s[f] || {} : u, h = t.compile, (l = k.onBeforeStoreItem) && (h = l(c, e, o, h) || h), e ? o === null ? delete c[e] : c[e] = h ? o = h(e, o, s, n, t) : o : o = h(i, o), h && o && (o._is = n), (l = k.onStoreItem) && l(c, e, o, h), o
                }
                var f = n + "s";
                r[f] = u, p[n] = t
            }
            function rt(n, t, f, o, s, h) {
                var w, ut, nt, y, tt, it, rt, k, p, ft, d, et, v, a = this, ot = !a.attr || a.attr === "html", g = "";
                if (o === !0 && (rt = !0, o = 0), a.tag ? (k = a, a = a.tag, ft = a._, et = a.tagName, v = k.tmpl, t = l(t, a.ctx), p = k.content, k.props.link === !1 && (t = t || {}, t.link = !1), f = f || k.view, n = n === i ? f : n) : v = a.jquery && (a[0] || c('Unknown template: "' + a.selector + '"')) || a, v && (!f && n && n._is === "view" && (f = n), f && (p = p || f.content, h = h || f._.onRender, n === f && (n = f.data, s = !0), t = l(t, f.ctx)), f && f.data !== i || ((t = t || {}).root = n), v.fn || (v = e[v] || e(v)), v)) {
                    if (h = (t && t.link) !== !1 && ot && h, d = h, h === !0 && (d = i, h = f._.onRender), u.isArray(n) && !s)
                        for (y = rt?f:o !== i && f || b(t, "array", f, n, v, o, p, h), w = 0, ut = n.length; w < ut; w++)
                            nt = n[w], tt = b(t, "item", y, nt, v, (o || 0) + w, p, h), it = v.fn(nt, tt, r), g += y._.onRender ? y._.onRender(it, tt) : it;
                    else
                        y = rt ? f : b(t, et || "data", f, n, v, o, p, h), ft && !a.flow && (y.tag = a), g += v.fn(n, y, r);
                    return d ? d(g, y) : g
                }
                return""
            }
            function c(n) {
                throw new r.sub.Error(n);
            }
            function s(n) {
                c("Syntax error\n" + n)
            }
            function ut(n, t, i, r) {
                function v(t) {
                    t -= f, t && h.push(n.substr(f, t).replace(nt, "\\n"))
                }
                function c(t) {
                    t && s('Unmatched or missing tag: "{{/' + t + '}}" in template:\n' + n)
                }
                function y(e, a, y, w, b, k, d, g, tt, it, rt, ut) {
                    k && (b = ":", w = "html"), it = it || i;
                    var at, st, ht = a && [], ot = "", et = "", ct = "", lt = !it && !b && !d;
                    y = y || b, v(ut), f = ut + e.length, g ? p && h.push(["*", "\n" + tt.replace(dt, "$1") + "\n"]) : y ? (y === "else" && (ti.test(tt) && s('for "{{else if expr}}" use "{{else expr}}"'), ht = u[6], u[7] = n.substring(u[7], ut), u = o.pop(), h = u[3], lt = !0), tt && (tt = tt.replace(nt, " "), ot = ft(tt, ht, t).replace(ni, function (n, t, i) {
                        return t ? ct += i + "," : et += i + ",", ""
                    })), et = et.slice(0, -1), ot = ot.slice(0, -1), at = et && et.indexOf("noerror:true") + 1 && et || "", l = [y, w || !!r || "", ot, lt && [], 'params:"' + tt + '",props:{' + et + "}" + (ct ? ",ctx:{" + ct.slice(0, -1) + "}" : ""), at, ht || 0], h.push(l), lt && (o.push(u), u = l, u[7] = f)) : rt && (st = u[0], c(rt !== st && st !== "else" && rt), u[7] = n.substring(u[7], ut), u = o.pop()), c(!u && rt), h = u[3]
                }
                var l, p = t && t.allowCode, e = [], f = 0, o = [], h = e, u = [, , , e];
                return n = n.replace(gt, "\\$&"), c(o[0] && o[0][3].pop()[0]), n.replace(a, y), v(n.length), (f = e[e.length - 1]) && c("" + f !== f && +f[7] === f[7] && f[0]), yt(e, i ? n : t, i)
            }
            function yt(n, i, r) {
                var c, f, e, l, a, y, st, ht, ct, lt, ft, p, o, et, v, tt, w, it, at, b, pt, wt, ot, rt, k, h = 0, u = "", g = "", ut = {}, bt = n.length;
                for ("" + i === i?(v = r?'data-link="' + i.replace(nt, " ").slice(1, - 1) + '"':i, i = 0):(v = i.tmplName || "unnamed", i.allowCode && (ut.allowCode = !0), i.debug && (ut.debug = !0), p = i.bnds, et = i.tmpls), c = 0; c < bt; c++)
                    if (f = n[c], "" + f === f)
                        u += '\nret+="' + f + '";';
                    else if (e = f[0], e === "*")
                        u += "" + f[1];
                    else {
                        if (l = f[1], a = f[2], it = f[3], y = f[4], g = f[5], at = f[7], (wt = e === "else") || (h = 0, p && (o = f[6]) && (h = p.push(o))), (ot = e === ":") ? (l && (e = l === "html" ? ">" : l + e), g && (rt = "prm" + c, g = "try{var " + rt + "=[" + a + "][0];}catch(e){" + rt + '="";}\n', a = rt)) : (it && (tt = vt(at, ut), tt.tmplName = v + "/" + e, yt(it, tt), et.push(tt)), wt || (w = e, pt = u, u = ""), b = n[c + 1], b = b && b[0] === "else"), y += ",args:[" + a + "]}", ot && o || l && e !== ">") {
                            if (k = new Function("data,view,j,u", " // " + v + " " + h + " " + e + "\n" + g + "return {" + y + ";"), k.paths = o, k._ctxs = e, r)
                                return k;
                            ft = 1
                        }
                        if (u += ot ? "\n" + (o ? "" : g) + (r ? "return " : "ret+=") + (ft ? (ft = 0, lt = !0, 'c("' + l + '",view,' + (o ? (p[h - 1] = k, h) : "{" + y) + ");") : e === ">" ? (ht = !0, "h(" + a + ");") : (ct = !0, "(v=" + a + ")!=" + (r ? "=" : "") + 'u?v:"";')) : (st = !0, "{view:view,tmpl:" + (it ? et.length : "0") + "," + y + ","), w && !b) {
                            if (u = "[" + u.slice(0, -1) + "]", (r || o) && (u = new Function("data,view,j,u", " // " + v + " " + h + " " + w + "\nreturn " + u + ";"), o && ((p[h - 1] = u).paths = o), u._ctxs = e, r))
                                return u;
                            u = pt + '\nret+=t("' + w + '",view,this,' + (h || u) + ");", o = 0, w = 0
                        }
                    }
                u = "// " + v + "\nvar j=j||" + (t ? "jQuery." : "js") + "views" + (ct ? ",v" : "") + (st ? ",t=j._tag" : "") + (lt ? ",c=j._cnvt" : "") + (ht ? ",h=j.converters.html" : "") + (r ? ";\n" : ',ret="";\n') + (d.tryCatch ? "try{\n" : "") + (ut.debug ? "debugger;" : "") + u + (r ? "\n" : "\nreturn ret;\n") + (d.tryCatch ? "\n}catch(e){return j._err(e);}" : "");
                try {
                    u = new Function("data,view,j,u", u)
                } catch (kt) {
                    s("Compiled template code:\n\n" + u, kt)
                }
                return i && (i.fn = u), u
            }
            function ft(n, t, i) {
                function b(b, k, d, g, nt, tt, it, rt, et, ot, st, ht, ct, lt, at, vt, yt, pt, wt, kt) {
                    function gt(n, i, r, f, o, s, h) {
                        if (i && (t && (u === "linkTo" && (e = t.to = t.to || [], e.push(nt)), (!u || l) && t.push(nt)), i !== ".")) {
                            var c = (r ? 'view.hlp("' + r + '")' : f ? "view" : "data") + (h ? (o ? "." + o : r ? "" : f ? "" : "." + i) + (s || "") : (h = r ? "" : f ? o || "" : i, ""));
                            return c = c + (h ? "." + h : ""), c.slice(0, 9) === "view.data" ? c.slice(5) : c
                        }
                        return n
                    }
                    var dt;
                    if (tt = tt || "", d = d || k || ht, nt = nt || et, ot = ot || yt || "", it)
                        s(n);
                    else
                        return t && vt && !c && !o && (!u || l || e) && (dt = p[r], kt.length - 2 > wt - dt && (dt = kt.slice(dt, wt + 1), vt = y + ":" + dt + f, vt = w[vt] = w[vt] || ut(v + vt + h, i, !0), vt.paths || ft(dt, vt.paths = [], i), (e || t).push({_jsvOb: vt}))), c ? (c = !ct, c ? b : '"') : o ? (o = !lt, o ? b : '"') : (d ? (r++, p[r] = wt++, d) : "") + (pt ? r ? "" : u ? (u = l = e = !1, "\b") : "," : rt ? (r && s(n), u = nt, l = g, "\b" + nt + ":") : nt ? nt.split("^").join(".").replace(bt, gt) + (ot ? (a[++r] = !0, nt.charAt(0) !== "." && (p[r] = wt), ot) : tt) : tt ? tt : at ? (a[r--] = !1, at) + (ot ? (a[++r] = !0, ot) : "") : st ? (a[r] || s(n), ",") : k ? "" : (c = ct, o = lt, '"'))
                }
                var u, e, l, w = i.links, a = {}, p = {0: -1}, r = 0, o = !1, c = !1;
                return(n + " ").replace(kt, b)
            }
            function l(n, t) {
                return n && n !== t ? t ? o(o({}, t), n) : n : t && o({}, t)
            }
            function pt(n) {
                return st[n] || (st[n] = "&#" + n.charCodeAt(0) + ";")
            }
            if ((!t || !t.views) && !n.jsviews) {
                var u, g, a, et, v = "{", y = "{", f = "}", h = "}", w = "^", bt = /^(?:null|true|false|\d[\d.]*|([\w$]+|\.|~([\w$]+)|#(view|([\w$]+))?)([\w$.^]*?)(?:[.[^]([\w$]+)\]?)?)$/g, kt = /(\()(?=\s*\()|(?:([([])\s*)?(?:(\^?)([#~]?[\w$.^]+)?\s*((\+\+|--)|\+|-|&&|\|\||===|!==|==|!=|<=|>=|[<>%*!:?\/]|(=))\s*|([#~]?[\w$.^]+)([([])?)|(,\s*)|(\(?)\\?(?:(')|("))|(?:\s*(([)\]])(?=\s*\.|\s*\^)|[)\]])([([]?))|(\s+)/g, nt = /[ \t]*(\r\n|\n|\r)/g, dt = /\\(['"])/g, gt = /['"\\]/g, ni = /\x08(~)?([^\x08]+)\x08/g, ti = /^if\s/, ii = /<(\w+)[>\s]/, ot = /[\x00`><"'&]/g, ri = ot, ui = 0, fi = 0, st = {"&": "&amp;", "<": "&lt;", ">": "&gt;", "\x00": "&#0;", "'": "&#39;", '"': "&#34;", "`": "&#96;"}, ht = "data-jsv-tmpl", tt = {}, p = {template: {compile: at}, tag: {compile: ai}, helper: {}, converter: {}}, r = {jsviews: "v1.0.0-beta", render: tt, settings: {delimiters: ct, debugMode: !0, tryCatch: !0}, sub: {View: b, Error: it, tmplFn: ut, parse: ft, extend: o, error: c, syntaxError: s}, _cnvt: si, _tag: ci, _err: function (n) {
                        return d.debugMode ? "Error: " + (n.message || n) + ". " : ""
                    }};
                (it.prototype = new Error).constructor = it, lt.depends = function () {
                    return[this.get("item"), "index"]
                };
                for (g in p)
                    vi(g, p[g]);
                var e = r.templates, wt = r.converters, pi = r.helpers, yi = r.tags, k = r.sub, d = r.settings;
                t ? (u = t, u.fn.render = rt) : (u = n.jsviews = {}, u.isArray = Array && Array.isArray || function (n) {
                    return Object.prototype.toString.call(n) === "[object Array]"
                }), u.render = tt, u.views = r, u.templates = e = r.templates, yi({"else": function () {
                    }, "if": {render: function (n) {
                            var t = this;
                            return t.rendering.done || !n && (arguments.length || !t.tagCtx.index) ? "" : (t.rendering.done = !0, t.selected = t.tagCtx.index, t.tagCtx.render())
                        }, onUpdate: function (n, t, i) {
                            for (var r, f, u = 0; (r = this.tagCtxs[u]) && r.args.length; u++)
                                if (r = r.args[0], f = !r != !i[u].args[0], !!r || f)
                                    return f;
                            return!1
                        }, flow: !0}, "for": {render: function (n) {
                            var t = this, f = t.tagCtx, e = !arguments.length, r = "", o = e || 0;
                            return t.rendering.done || (e ? r = i : n !== i && (r += f.render(n), o += u.isArray(n) ? n.length : 1), (t.rendering.done = o) && (t.selected = f.index)), r
                        }, onArrayChange: function (n, t) {
                            var i, u = this, r = t.change;
                            if (this.tagCtxs[1] && (r === "insert" && n.target.length === t.items.length || r === "remove" && !n.target.length || r === "refresh" && !t.oldItems.length != !n.target.length))
                                this.refresh();
                            else
                                for (i in u._.arrVws)
                                    i = u._.arrVws[i], i.data === n.target && i._.onArrayChange.apply(i, arguments);
                            n.done = !0
                        }, flow: !0}, include: {flow: !0}, "*": {render: function (n) {
                            return n
                        }, flow: !0}}), wt({html: function (n) {
                        return n != i ? String(n).replace(ri, pt) : ""
                    }, attr: function (n) {
                        return n != i ? String(n).replace(ot, pt) : n === null ? null : ""
                    }, url: function (n) {
                        return n != i ? encodeURI(String(n)) : n === null ? null : ""
                    }}), ct()
            }
        })(this, this.jQuery);
//@ sourceMappingURL=jsrender.min.js.map