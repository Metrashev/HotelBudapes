define("ace/mode/xml", ["require", "exports", "module", "ace/lib/oop", "ace/lib/lang", "ace/mode/text", "ace/mode/xml_highlight_rules", "ace/mode/behaviour/xml", "ace/mode/folding/xml"], function (e, t, n) {
    var r = e("../lib/oop"), i = e("../lib/lang"), s = e("./text").Mode, o = e("./xml_highlight_rules").XmlHighlightRules, u = e("./behaviour/xml").XmlBehaviour, a = e("./folding/xml").FoldMode, f = function () {
        this.HighlightRules = o, this.$behaviour = new u, this.foldingRules = new a
    };
    r.inherits(f, s), function () {
        this.voidElements = i.arrayToMap([]), this.blockComment = {start: "<!--", end: "-->"}, this.$id = "ace/mode/xml"
    }.call(f.prototype), t.Mode = f
}), define("ace/mode/xml_highlight_rules", ["require", "exports", "module", "ace/lib/oop", "ace/mode/text_highlight_rules"], function (e, t, n) {
    var r = e("../lib/oop"), i = e("./text_highlight_rules").TextHighlightRules, s = function (e) {
        this.$rules = {start: [{token: "string.cdata.xml", regex: "<\\!\\[CDATA\\[", next: "cdata"}, {token: ["punctuation.xml-decl.xml", "keyword.xml-decl.xml"], regex: "(<\\?)(xml)(?=[\\s])", next: "xml_decl", caseInsensitive: !0}, {token: ["punctuation.instruction.xml", "keyword.instruction.xml"], regex: "(<\\?)([-_a-zA-Z0-9]+)", next: "processing_instruction"}, {token: "comment.xml", regex: "<\\!--", next: "comment"}, {token: ["xml-pe.doctype.xml", "xml-pe.doctype.xml"], regex: "(<\\!)(DOCTYPE)(?=[\\s])", next: "doctype", caseInsensitive: !0}, {include: "tag"}, {token: "text.end-tag-open.xml", regex: "</"}, {token: "text.tag-open.xml", regex: "<"}, {include: "reference"}, {defaultToken: "text.xml"}], xml_decl: [{token: "entity.other.attribute-name.decl-attribute-name.xml", regex: "(?:[-_a-zA-Z0-9]+:)?[-_a-zA-Z0-9]+"}, {token: "keyword.operator.decl-attribute-equals.xml", regex: "="}, {include: "whitespace"}, {include: "string"}, {token: "punctuation.xml-decl.xml", regex: "\\?>", next: "start"}], processing_instruction: [{token: "punctuation.instruction.xml", regex: "\\?>", next: "start"}, {defaultToken: "instruction.xml"}], doctype: [{include: "whitespace"}, {include: "string"}, {token: "xml-pe.doctype.xml", regex: ">", next: "start"}, {token: "xml-pe.xml", regex: "[-_a-zA-Z0-9:]+"}, {token: "punctuation.int-subset", regex: "\\[", push: "int_subset"}], int_subset: [{token: "text.xml", regex: "\\s+"}, {token: "punctuation.int-subset.xml", regex: "]", next: "pop"}, {token: ["punctuation.markup-decl.xml", "keyword.markup-decl.xml"], regex: "(<\\!)([-_a-zA-Z0-9]+)", push: [{token: "text", regex: "\\s+"}, {token: "punctuation.markup-decl.xml", regex: ">", next: "pop"}, {include: "string"}]}], cdata: [{token: "string.cdata.xml", regex: "\\]\\]>", next: "start"}, {token: "text.xml", regex: "\\s+"}, {token: "text.xml", regex: "(?:[^\\]]|\\](?!\\]>))+"}], comment: [{token: "comment.xml", regex: "-->", next: "start"}, {defaultToken: "comment.xml"}], reference: [{token: "constant.language.escape.reference.xml", regex: "(?:&#[0-9]+;)|(?:&#x[0-9a-fA-F]+;)|(?:&[a-zA-Z0-9_:\\.-]+;)"}], attr_reference: [{token: "constant.language.escape.reference.attribute-value.xml", regex: "(?:&#[0-9]+;)|(?:&#x[0-9a-fA-F]+;)|(?:&[a-zA-Z0-9_:\\.-]+;)"}], tag: [{token: ["meta.tag.punctuation.tag-open.xml", "meta.tag.punctuation.end-tag-open.xml", "meta.tag.tag-name.xml"], regex: "(?:(<)|(</))((?:[-_a-zA-Z0-9]+:)?[-_a-zA-Z0-9]+)", next: [{include: "attributes"}, {token: "meta.tag.punctuation.tag-close.xml", regex: "/?>", next: "start"}]}], tag_whitespace: [{token: "text.tag-whitespace.xml", regex: "\\s+"}], whitespace: [{token: "text.whitespace.xml", regex: "\\s+"}], string: [{token: "string.xml", regex: "'", push: [{token: "string.xml", regex: "'", next: "pop"}, {defaultToken: "string.xml"}]}, {token: "string.xml", regex: '"', push: [{token: "string.xml", regex: '"', next: "pop"}, {defaultToken: "string.xml"}]}], attributes: [{token: "entity.other.attribute-name.xml", regex: "(?:[-_a-zA-Z0-9]+:)?[-_a-zA-Z0-9]+"}, {token: "keyword.operator.attribute-equals.xml", regex: "="}, {include: "tag_whitespace"}, {include: "attribute_value"}], attribute_value: [{token: "string.attribute-value.xml", regex: "'", push: [{token: "string.attribute-value.xml", regex: "'", next: "pop"}, {include: "attr_reference"}, {defaultToken: "string.attribute-value.xml"}]}, {token: "string.attribute-value.xml", regex: '"', push: [{token: "string.attribute-value.xml", regex: '"', next: "pop"}, {include: "attr_reference"}, {defaultToken: "string.attribute-value.xml"}]}]}, this.constructor === s && this.normalizeRules()
    };
    (function () {
        this.embedTagRules = function (e, t, n) {
            this.$rules.tag.unshift({token: ["meta.tag.punctuation.tag-open.xml", "meta.tag." + n + ".tag-name.xml"], regex: "(<)(" + n + "(?=\\s|>|$))", next: [{include: "attributes"}, {token: "meta.tag.punctuation.tag-close.xml", regex: "/?>", next: t + "start"}]}), this.$rules[n + "-end"] = [{include: "attributes"}, {token: "meta.tag.punctuation.tag-close.xml", regex: "/?>", next: "start", onMatch: function (e, t, n) {
                        return n.splice(0), this.token
                    }}], this.embedRules(e, t, [{token: ["meta.tag.punctuation.end-tag-open.xml", "meta.tag." + n + ".tag-name.xml"], regex: "(</)(" + n + "(?=\\s|>|$))", next: n + "-end"}, {token: "string.cdata.xml", regex: "<\\!\\[CDATA\\["}, {token: "string.cdata.xml", regex: "\\]\\]>"}])
        }
    }).call(i.prototype), r.inherits(s, i), t.XmlHighlightRules = s
}), define("ace/mode/behaviour/xml", ["require", "exports", "module", "ace/lib/oop", "ace/mode/behaviour", "ace/token_iterator"], function (e, t, n) {
    function o(e, t) {
        return e.type.lastIndexOf(t + ".xml") > -1
    }
    var r = e("../../lib/oop"), i = e("../behaviour").Behaviour, s = e("../../token_iterator").TokenIterator, u = function () {
        this.add("string_dquotes", "insertion", function (e, t, n, r, i) {
            if (i == '"' || i == "'") {
                var u = i, a = r.doc.getTextRange(n.getSelectionRange());
                if (a !== "" && a !== "'" && a != '"' && n.getWrapBehavioursEnabled())
                    return{text: u + a + u, selection: !1};
                var f = n.getCursorPosition(), l = r.doc.getLine(f.row), c = l.substring(f.column, f.column + 1), h = new s(r, f.row, f.column), p = h.getCurrentToken();
                if (c == u && (o(p, "attribute-value") || o(p, "string")))
                    return{text: "", selection: [1, 1]};
                p || (p = h.stepBackward());
                if (!p)
                    return;
                while (o(p, "tag-whitespace") || o(p, "whitespace"))
                    p = h.stepBackward();
                var d = !c || c.match(/\s/);
                if (o(p, "attribute-equals") && (d || c == ">") || o(p, "decl-attribute-equals") && (d || c == "?"))
                    return{text: u + u, selection: [1, 1]}
            }
        }), this.add("string_dquotes", "deletion", function (e, t, n, r, i) {
            var s = r.doc.getTextRange(i);
            if (!i.isMultiLine() && (s == '"' || s == "'")) {
                var o = r.doc.getLine(i.start.row), u = o.substring(i.start.column + 1, i.start.column + 2);
                if (u == s)
                    return i.end.column++, i
            }
        }), this.add("autoclosing", "insertion", function (e, t, n, r, i) {
            if (i == ">") {
                var u = n.getCursorPosition(), a = new s(r, u.row, u.column), f = a.getCurrentToken() || a.stepBackward();
                if (!f || !(o(f, "tag-name") || o(f, "tag-whitespace") || o(f, "attribute-name") || o(f, "attribute-equals") || o(f, "attribute-value")))
                    return;
                if (o(f, "reference.attribute-value"))
                    return;
                if (o(f, "attribute-value")) {
                    var l = f.value.charAt(0);
                    if (l == '"' || l == "'") {
                        var c = f.value.charAt(f.value.length - 1), h = a.getCurrentTokenColumn() + f.value.length;
                        if (h > u.column || h == u.column && l != c)
                            return
                    }
                }
                while (!o(f, "tag-name"))
                    f = a.stepBackward();
                var p = a.getCurrentTokenRow(), d = a.getCurrentTokenColumn();
                if (o(a.stepBackward(), "end-tag-open"))
                    return;
                var v = f.value;
                p == u.row && (v = v.substring(0, u.column - d));
                if (this.voidElements.hasOwnProperty(v.toLowerCase()))
                    return;
                return{text: "></" + v + ">", selection: [1, 1]}
            }
        }), this.add("autoindent", "insertion", function (e, t, n, r, i) {
            if (i == "\n") {
                var s = n.getCursorPosition(), o = r.getLine(s.row), u = o.substring(s.column, s.column + 2);
                if (u == "</") {
                    var a = this.$getIndent(o), f = a + r.getTabString();
                    return{text: "\n" + f + "\n" + a, selection: [1, f.length, 1, f.length]}
                }
            }
        })
    };
    r.inherits(u, i), t.XmlBehaviour = u
}), define("ace/mode/folding/xml", ["require", "exports", "module", "ace/lib/oop", "ace/lib/lang", "ace/range", "ace/mode/folding/fold_mode", "ace/token_iterator"], function (e, t, n) {
    function l(e, t) {
        return e.type.lastIndexOf(t + ".xml") > -1
    }
    var r = e("../../lib/oop"), i = e("../../lib/lang"), s = e("../../range").Range, o = e("./fold_mode").FoldMode, u = e("../../token_iterator").TokenIterator, a = t.FoldMode = function (e, t) {
        o.call(this), this.voidElements = r.mixin(e || {}, t || {})
    };
    r.inherits(a, o);
    var f = function () {
        this.tagName = "", this.closing = !1, this.selfClosing = !1, this.start = {row: 0, column: 0}, this.end = {row: 0, column: 0}
    };
    (function () {
        this.getFoldWidget = function (e, t, n) {
            var r = this._getFirstTagInLine(e, n);
            return r ? r.closing || !r.tagName && r.selfClosing ? t == "markbeginend" ? "end" : "" : !r.tagName || r.selfClosing || this.voidElements.hasOwnProperty(r.tagName.toLowerCase()) ? "" : this._findEndTagInLine(e, n, r.tagName, r.end.column) ? "" : "start" : ""
        }, this._getFirstTagInLine = function (e, t) {
            var n = e.getTokens(t), r = new f;
            for (var i = 0; i < n.length; i++) {
                var s = n[i];
                if (l(s, "tag-open")) {
                    r.end.column = r.start.column + s.value.length, r.closing = l(s, "end-tag-open"), s = n[++i];
                    if (!s)
                        return null;
                    r.tagName = s.value, r.end.column += s.value.length;
                    for (i++; i < n.length; i++) {
                        s = n[i], r.end.column += s.value.length;
                        if (l(s, "tag-close")) {
                            r.selfClosing = s.value == "/>";
                            break
                        }
                    }
                    return r
                }
                if (l(s, "tag-close"))
                    return r.selfClosing = s.value == "/>", r;
                r.start.column += s.value.length
            }
            return null
        }, this._findEndTagInLine = function (e, t, n, r) {
            var i = e.getTokens(t), s = 0;
            for (var o = 0; o < i.length; o++) {
                var u = i[o];
                s += u.value.length;
                if (s < r)
                    continue;
                if (l(u, "end-tag-open")) {
                    u = i[o + 1];
                    if (u && u.value == n)
                        return!0
                }
            }
            return!1
        }, this._readTagForward = function (e) {
            var t = e.getCurrentToken();
            if (!t)
                return null;
            var n = new f;
            do
                if (l(t, "tag-open"))
                    n.closing = l(t, "end-tag-open"), n.start.row = e.getCurrentTokenRow(), n.start.column = e.getCurrentTokenColumn();
                else if (l(t, "tag-name"))
                    n.tagName = t.value;
                else if (l(t, "tag-close"))
                    return n.selfClosing = t.value == "/>", n.end.row = e.getCurrentTokenRow(), n.end.column = e.getCurrentTokenColumn() + t.value.length, e.stepForward(), n;
            while (t = e.stepForward());
            return null
        }, this._readTagBackward = function (e) {
            var t = e.getCurrentToken();
            if (!t)
                return null;
            var n = new f;
            do {
                if (l(t, "tag-open"))
                    return n.closing = l(t, "end-tag-open"), n.start.row = e.getCurrentTokenRow(), n.start.column = e.getCurrentTokenColumn(), e.stepBackward(), n;
                l(t, "tag-name") ? n.tagName = t.value : l(t, "tag-close") && (n.selfClosing = t.value == "/>", n.end.row = e.getCurrentTokenRow(), n.end.column = e.getCurrentTokenColumn() + t.value.length)
            } while (t = e.stepBackward());
            return null
        }, this._pop = function (e, t) {
            while (e.length) {
                var n = e[e.length - 1];
                if (!t || n.tagName == t.tagName)
                    return e.pop();
                if (this.voidElements.hasOwnProperty(t.tagName))
                    return;
                if (this.voidElements.hasOwnProperty(n.tagName)) {
                    e.pop();
                    continue
                }
                return null
            }
        }, this.getFoldWidgetRange = function (e, t, n) {
            var r = this._getFirstTagInLine(e, n);
            if (!r)
                return null;
            var i = r.closing || r.selfClosing, o = [], a;
            if (!i) {
                var f = new u(e, n, r.start.column), l = {row: n, column: r.start.column + r.tagName.length + 2};
                while (a = this._readTagForward(f)) {
                    if (a.selfClosing) {
                        if (!o.length)
                            return a.start.column += a.tagName.length + 2, a.end.column -= 2, s.fromPoints(a.start, a.end);
                        continue
                    }
                    if (a.closing) {
                        this._pop(o, a);
                        if (o.length == 0)
                            return s.fromPoints(l, a.start)
                    } else
                        o.push(a)
                }
            } else {
                var f = new u(e, n, r.end.column), c = {row: n, column: r.start.column};
                while (a = this._readTagBackward(f)) {
                    if (a.selfClosing) {
                        if (!o.length)
                            return a.start.column += a.tagName.length + 2, a.end.column -= 2, s.fromPoints(a.start, a.end);
                        continue
                    }
                    if (!a.closing) {
                        this._pop(o, a);
                        if (o.length == 0)
                            return a.start.column += a.tagName.length + 2, s.fromPoints(a.start, c)
                    } else
                        o.push(a)
                }
            }
        }
    }).call(a.prototype)
})