var Swiper = function (e, t) {
    "use strict";
    function r(e, t) {
        if (document.querySelectorAll)
            return(t || document).querySelectorAll(e);
        else
            return jQuery(e, t)
    }
    function b(e) {
        if (Object.prototype.toString.apply(e) === "[object Array]")
            return true;
        return false
    }
    function x() {
        var e = u - l;
        if (t.freeMode) {
            e = u - l
        }
        if (t.slidesPerView > i.slides.length && !t.centeredSlides) {
            e = 0
        }
        if (e < 0)
            e = 0;
        return e
    }
    function T() {
        function o(e) {
            var n = new Image;
            n.onload = function () {
                if (i && i.imagesLoaded !== undefined)
                    i.imagesLoaded++;
                if (i.imagesLoaded === i.imagesToLoad.length) {
                    i.reInit();
                    if (t.onImagesReady)
                        i.fireCallback(t.onImagesReady, i)
                }
            };
            n.src = e
        }
        var e = i.h.addEventListener;
        var n = t.eventTarget === "wrapper" ? i.wrapper : i.container;
        if (!(i.browser.ie10 || i.browser.ie11)) {
            if (i.support.touch) {
                e(n, "touchstart", I);
                e(n, "touchmove", U);
                e(n, "touchend", z)
            }
            if (t.simulateTouch) {
                e(n, "mousedown", I);
                e(document, "mousemove", U);
                e(document, "mouseup", z)
            }
        } else {
            e(n, i.touchEvents.touchStart, I);
            e(document, i.touchEvents.touchMove, U);
            e(document, i.touchEvents.touchEnd, z)
        }
        if (t.autoResize) {
            e(window, "resize", i.resizeFix)
        }
        N();
        i._wheelEvent = false;
        if (t.mousewheelControl) {
            if (document.onmousewheel !== undefined) {
                i._wheelEvent = "mousewheel"
            }
            if (!i._wheelEvent) {
                try {
                    new WheelEvent("wheel");
                    i._wheelEvent = "wheel"
                } catch (s) {
                }
            }
            if (!i._wheelEvent) {
                i._wheelEvent = "DOMMouseScroll"
            }
            if (i._wheelEvent) {
                e(i.container, i._wheelEvent, A)
            }
        }
        if (t.keyboardControl) {
            e(document, "keydown", k)
        }
        if (t.updateOnImagesReady) {
            i.imagesToLoad = r("img", i.container);
            for (var u = 0; u < i.imagesToLoad.length; u++) {
                o(i.imagesToLoad[u].getAttribute("src"))
            }
        }
    }
    function N() {
        var e = i.h.addEventListener, n;
        if (t.preventLinks) {
            var s = r("a", i.container);
            for (n = 0; n < s.length; n++) {
                e(s[n], "click", P)
            }
        }
        if (t.releaseFormElements) {
            var o = r("input, textarea, select", i.container);
            for (n = 0; n < o.length; n++) {
                e(o[n], i.touchEvents.touchStart, H, true)
            }
        }
        if (t.onSlideClick) {
            for (n = 0; n < i.slides.length; n++) {
                e(i.slides[n], "click", M)
            }
        }
        if (t.onSlideTouch) {
            for (n = 0; n < i.slides.length; n++) {
                e(i.slides[n], i.touchEvents.touchStart, _)
            }
        }
    }
    function C() {
        var e = i.h.removeEventListener, n;
        if (t.onSlideClick) {
            for (n = 0; n < i.slides.length; n++) {
                e(i.slides[n], "click", M)
            }
        }
        if (t.onSlideTouch) {
            for (n = 0; n < i.slides.length; n++) {
                e(i.slides[n], i.touchEvents.touchStart, _)
            }
        }
        if (t.releaseFormElements) {
            var s = r("input, textarea, select", i.container);
            for (n = 0; n < s.length; n++) {
                e(s[n], i.touchEvents.touchStart, H, true)
            }
        }
        if (t.preventLinks) {
            var o = r("a", i.container);
            for (n = 0; n < o.length; n++) {
                e(o[n], "click", P)
            }
        }
    }
    function k(e) {
        var t = e.keyCode || e.charCode;
        if (e.shiftKey || e.altKey || e.ctrlKey || e.metaKey)
            return;
        if (t === 37 || t === 39 || t === 38 || t === 40) {
            var n = false;
            var r = i.h.getOffset(i.container);
            var s = i.h.windowScroll().left;
            var o = i.h.windowScroll().top;
            var u = i.h.windowWidth();
            var a = i.h.windowHeight();
            var f = [[r.left, r.top], [r.left + i.width, r.top], [r.left, r.top + i.height], [r.left + i.width, r.top + i.height]];
            for (var l = 0; l < f.length; l++) {
                var c = f[l];
                if (c[0] >= s && c[0] <= s + u && c[1] >= o && c[1] <= o + a) {
                    n = true
                }
            }
            if (!n)
                return
        }
        if (d) {
            if (t === 37 || t === 39) {
                if (e.preventDefault)
                    e.preventDefault();
                else
                    e.returnValue = false
            }
            if (t === 39)
                i.swipeNext();
            if (t === 37)
                i.swipePrev()
        } else {
            if (t === 38 || t === 40) {
                if (e.preventDefault)
                    e.preventDefault();
                else
                    e.returnValue = false
            }
            if (t === 40)
                i.swipeNext();
            if (t === 38)
                i.swipePrev()
        }
    }
    function A(e) {
        var n = i._wheelEvent;
        var r = 0;
        if (e.detail)
            r = -e.detail;
        else if (n === "mousewheel") {
            if (t.mousewheelControlForceToAxis) {
                if (d) {
                    if (Math.abs(e.wheelDeltaX) > Math.abs(e.wheelDeltaY))
                        r = e.wheelDeltaX;
                    else
                        return
                } else {
                    if (Math.abs(e.wheelDeltaY) > Math.abs(e.wheelDeltaX))
                        r = e.wheelDeltaY;
                    else
                        return
                }
            } else {
                r = e.wheelDelta
            }
        } else if (n === "DOMMouseScroll")
            r = -e.detail;
        else if (n === "wheel") {
            if (t.mousewheelControlForceToAxis) {
                if (d) {
                    if (Math.abs(e.deltaX) > Math.abs(e.deltaY))
                        r = -e.deltaX;
                    else
                        return
                } else {
                    if (Math.abs(e.deltaY) > Math.abs(e.deltaX))
                        r = -e.deltaY;
                    else
                        return
                }
            } else {
                r = Math.abs(e.deltaX) > Math.abs(e.deltaY) ? -e.deltaX : -e.deltaY
            }
        }
        if (!t.freeMode) {
            if ((new Date).getTime() - L > 60) {
                if (r < 0)
                    i.swipeNext();
                else
                    i.swipePrev()
            }
            L = (new Date).getTime()
        } else {
            var s = i.getWrapperTranslate() + r;
            if (s > 0)
                s = 0;
            if (s < -x())
                s = -x();
            i.setWrapperTransition(0);
            i.setWrapperTranslate(s);
            i.updateActiveSlide(s);
            if (s === 0 || s === -x())
                return
        }
        if (t.autoplay)
            i.stopAutoplay(true);
        if (e.preventDefault)
            e.preventDefault();
        else
            e.returnValue = false;
        return false
    }
    function M(e) {
        if (i.allowSlideClick) {
            D(e);
            i.fireCallback(t.onSlideClick, i, e)
        }
    }
    function _(e) {
        D(e);
        i.fireCallback(t.onSlideTouch, i, e)
    }
    function D(e) {
        if (!e.currentTarget) {
            var n = e.srcElement;
            do {
                if (n.className.indexOf(t.slideClass) > -1) {
                    break
                }
                n = n.parentNode
            } while (n);
            i.clickedSlide = n
        } else {
            i.clickedSlide = e.currentTarget
        }
        i.clickedSlideIndex = i.slides.indexOf(i.clickedSlide);
        i.clickedSlideLoopIndex = i.clickedSlideIndex - (i.loopedSlides || 0)
    }
    function P(e) {
        if (!i.allowLinks) {
            if (e.preventDefault)
                e.preventDefault();
            else
                e.returnValue = false;
            if (t.preventLinksPropagation && "stopPropagation"in e) {
                e.stopPropagation()
            }
            return false
        }
    }
    function H(e) {
        if (e.stopPropagation)
            e.stopPropagation();
        else
            e.returnValue = false;
        return false
    }
    function I(e) {
        if (t.preventLinks)
            i.allowLinks = true;
        if (i.isTouched || t.onlyExternal) {
            return false
        }
        if (t.noSwiping && (e.target || e.srcElement) && W(e.target || e.srcElement))
            return false;
        F = false;
        i.isTouched = true;
        B = e.type === "touchstart";
        if (!B || e.targetTouches.length === 1) {
            i.callPlugins("onTouchStartBegin");
            if (!B && !i.isAndroid) {
                if (e.preventDefault)
                    e.preventDefault();
                else
                    e.returnValue = false
            }
            var n = B ? e.targetTouches[0].pageX : e.pageX || e.clientX;
            var r = B ? e.targetTouches[0].pageY : e.pageY || e.clientY;
            i.touches.startX = i.touches.currentX = n;
            i.touches.startY = i.touches.currentY = r;
            i.touches.start = i.touches.current = d ? n : r;
            i.setWrapperTransition(0);
            i.positions.start = i.positions.current = i.getWrapperTranslate();
            i.setWrapperTranslate(i.positions.start);
            i.times.start = (new Date).getTime();
            f = undefined;
            if (t.moveStartThreshold > 0) {
                j = false
            }
            if (t.onTouchStart)
                i.fireCallback(t.onTouchStart, i, e);
            i.callPlugins("onTouchStartEnd")
        }
    }
    function U(e) {
        if (!i.isTouched || t.onlyExternal)
            return;
        if (B && e.type === "mousemove")
            return;
        var n = B ? e.targetTouches[0].pageX : e.pageX || e.clientX;
        var r = B ? e.targetTouches[0].pageY : e.pageY || e.clientY;
        if (typeof f === "undefined" && d) {
            f = !!(f || Math.abs(r - i.touches.startY) > Math.abs(n - i.touches.startX))
        }
        if (typeof f === "undefined" && !d) {
            f = !!(f || Math.abs(r - i.touches.startY) < Math.abs(n - i.touches.startX))
        }
        if (f) {
            i.isTouched = false;
            return
        }
        if (e.assignedToSwiper) {
            i.isTouched = false;
            return
        }
        e.assignedToSwiper = true;
        if (t.preventLinks) {
            i.allowLinks = false
        }
        if (t.onSlideClick) {
            i.allowSlideClick = false
        }
        if (t.autoplay) {
            i.stopAutoplay(true)
        }
        if (!B || e.touches.length === 1) {
            if (!i.isMoved) {
                i.callPlugins("onTouchMoveStart");
                if (t.loop) {
                    i.fixLoop();
                    i.positions.start = i.getWrapperTranslate()
                }
                if (t.onTouchMoveStart)
                    i.fireCallback(t.onTouchMoveStart, i)
            }
            i.isMoved = true;
            if (e.preventDefault)
                e.preventDefault();
            else
                e.returnValue = false;
            i.touches.current = d ? n : r;
            i.positions.current = (i.touches.current - i.touches.start) * t.touchRatio + i.positions.start;
            if (i.positions.current > 0 && t.onResistanceBefore) {
                i.fireCallback(t.onResistanceBefore, i, i.positions.current)
            }
            if (i.positions.current < -x() && t.onResistanceAfter) {
                i.fireCallback(t.onResistanceAfter, i, Math.abs(i.positions.current + x()))
            }
            if (t.resistance && t.resistance !== "100%") {
                var s;
                if (i.positions.current > 0) {
                    s = 1 - i.positions.current / l / 2;
                    if (s < .5)
                        i.positions.current = l / 2;
                    else
                        i.positions.current = i.positions.current * s
                }
                if (i.positions.current < -x()) {
                    var o = (i.touches.current - i.touches.start) * t.touchRatio + (x() + i.positions.start);
                    s = (l + o) / l;
                    var u = i.positions.current - o * (1 - s) / 2;
                    var a = -x() - l / 2;
                    if (u < a || s <= 0)
                        i.positions.current = a;
                    else
                        i.positions.current = u
                }
            }
            if (t.resistance && t.resistance === "100%") {
                if (i.positions.current > 0 && !(t.freeMode && !t.freeModeFluid)) {
                    i.positions.current = 0
                }
                if (i.positions.current < -x() && !(t.freeMode && !t.freeModeFluid)) {
                    i.positions.current = -x()
                }
            }
            if (!t.followFinger)
                return;
            if (!t.moveStartThreshold) {
                i.setWrapperTranslate(i.positions.current)
            } else {
                if (Math.abs(i.touches.current - i.touches.start) > t.moveStartThreshold || j) {
                    if (!j) {
                        j = true;
                        i.touches.start = i.touches.current;
                        return
                    }
                    i.setWrapperTranslate(i.positions.current)
                } else {
                    i.positions.current = i.positions.start
                }
            }
            if (t.freeMode || t.watchActiveIndex) {
                i.updateActiveSlide(i.positions.current)
            }
            if (t.grabCursor) {
                i.container.style.cursor = "move";
                i.container.style.cursor = "grabbing";
                i.container.style.cursor = "-moz-grabbin";
                i.container.style.cursor = "-webkit-grabbing"
            }
            if (!q)
                q = i.touches.current;
            if (!R)
                R = (new Date).getTime();
            i.velocity = (i.touches.current - q) / ((new Date).getTime() - R) / 2;
            if (Math.abs(i.touches.current - q) < 2)
                i.velocity = 0;
            q = i.touches.current;
            R = (new Date).getTime();
            i.callPlugins("onTouchMoveEnd");
            if (t.onTouchMove)
                i.fireCallback(t.onTouchMove, i, e);
            return false
        }
    }
    function z(e) {
        if (f) {
            i.swipeReset()
        }
        if (t.onlyExternal || !i.isTouched)
            return;
        i.isTouched = false;
        if (t.grabCursor) {
            i.container.style.cursor = "move";
            i.container.style.cursor = "grab";
            i.container.style.cursor = "-moz-grab";
            i.container.style.cursor = "-webkit-grab"
        }
        if (!i.positions.current && i.positions.current !== 0) {
            i.positions.current = i.positions.start
        }
        if (t.followFinger) {
            i.setWrapperTranslate(i.positions.current)
        }
        i.times.end = (new Date).getTime();
        i.touches.diff = i.touches.current - i.touches.start;
        i.touches.abs = Math.abs(i.touches.diff);
        i.positions.diff = i.positions.current - i.positions.start;
        i.positions.abs = Math.abs(i.positions.diff);
        var n = i.positions.diff;
        var r = i.positions.abs;
        var s = i.times.end - i.times.start;
        if (r < 5 && s < 300 && i.allowLinks === false) {
            if (!t.freeMode && r !== 0)
                i.swipeReset();
            if (t.preventLinks) {
                i.allowLinks = true
            }
            if (t.onSlideClick) {
                i.allowSlideClick = true
            }
        }
        setTimeout(function () {
            if (t.preventLinks) {
                i.allowLinks = true
            }
            if (t.onSlideClick) {
                i.allowSlideClick = true
            }
        }, 100);
        var u = x();
        if (!i.isMoved && t.freeMode) {
            i.isMoved = false;
            if (t.onTouchEnd)
                i.fireCallback(t.onTouchEnd, i, e);
            i.callPlugins("onTouchEnd");
            return
        }
        if (!i.isMoved || i.positions.current > 0 || i.positions.current < -u) {
            i.swipeReset();
            if (t.onTouchEnd)
                i.fireCallback(t.onTouchEnd, i, e);
            i.callPlugins("onTouchEnd");
            return
        }
        i.isMoved = false;
        if (t.freeMode) {
            if (t.freeModeFluid) {
                var c = 1e3 * t.momentumRatio;
                var h = i.velocity * c;
                var p = i.positions.current + h;
                var v = false;
                var m;
                var g = Math.abs(i.velocity) * 20 * t.momentumBounceRatio;
                if (p < -u) {
                    if (t.momentumBounce && i.support.transitions) {
                        if (p + u < -g)
                            p = -u - g;
                        m = -u;
                        v = true;
                        F = true
                    } else
                        p = -u
                }
                if (p > 0) {
                    if (t.momentumBounce && i.support.transitions) {
                        if (p > g)
                            p = g;
                        m = 0;
                        v = true;
                        F = true
                    } else
                        p = 0
                }
                if (i.velocity !== 0)
                    c = Math.abs((p - i.positions.current) / i.velocity);
                i.setWrapperTranslate(p);
                i.setWrapperTransition(c);
                if (t.momentumBounce && v) {
                    i.wrapperTransitionEnd(function () {
                        if (!F)
                            return;
                        if (t.onMomentumBounce)
                            i.fireCallback(t.onMomentumBounce, i);
                        i.callPlugins("onMomentumBounce");
                        i.setWrapperTranslate(m);
                        i.setWrapperTransition(300)
                    })
                }
                i.updateActiveSlide(p)
            }
            if (!t.freeModeFluid || s >= 300)
                i.updateActiveSlide(i.positions.current);
            if (t.onTouchEnd)
                i.fireCallback(t.onTouchEnd, i, e);
            i.callPlugins("onTouchEnd");
            return
        }
        a = n < 0 ? "toNext" : "toPrev";
        if (a === "toNext" && s <= 300) {
            if (r < 30 || !t.shortSwipes)
                i.swipeReset();
            else
                i.swipeNext(true)
        }
        if (a === "toPrev" && s <= 300) {
            if (r < 30 || !t.shortSwipes)
                i.swipeReset();
            else
                i.swipePrev(true)
        }
        var y = 0;
        if (t.slidesPerView === "auto") {
            var b = Math.abs(i.getWrapperTranslate());
            var w = 0;
            var E;
            for (var S = 0; S < i.slides.length; S++) {
                E = d ? i.slides[S].getWidth(true, t.roundLengths) : i.slides[S].getHeight(true, t.roundLengths);
                w += E;
                if (w > b) {
                    y = E;
                    break
                }
            }
            if (y > l)
                y = l
        } else {
            y = o * t.slidesPerView
        }
        if (a === "toNext" && s > 300) {
            if (r >= y * t.longSwipesRatio) {
                i.swipeNext(true)
            } else {
                i.swipeReset()
            }
        }
        if (a === "toPrev" && s > 300) {
            if (r >= y * t.longSwipesRatio) {
                i.swipePrev(true)
            } else {
                i.swipeReset()
            }
        }
        if (t.onTouchEnd)
            i.fireCallback(t.onTouchEnd, i, e);
        i.callPlugins("onTouchEnd")
    }
    function W(e) {
        var n = false;
        do {
            if (e.className.indexOf(t.noSwipingClass) > -1) {
                n = true
            }
            e = e.parentElement
        } while (!n && e.parentElement && e.className.indexOf(t.wrapperClass) === -1);
        if (!n && e.className.indexOf(t.wrapperClass) > -1 && e.className.indexOf(t.noSwipingClass) > -1)
            n = true;
        return n
    }
    function X(e, t) {
        var n = document.createElement("div");
        var r;
        n.innerHTML = t;
        r = n.firstChild;
        r.className += " " + e;
        return r.outerHTML
    }
    function V(e, n, r) {
        function u() {
            var s = +(new Date);
            var h = s - o;
            a += f * h / (1e3 / 60);
            c = l === "toNext" ? a > e : a < e;
            if (c) {
                i.setWrapperTranslate(Math.ceil(a));
                i._DOMAnimating = true;
                window.setTimeout(function () {
                    u()
                }, 1e3 / 60)
            } else {
                if (t.onSlideChangeEnd) {
                    if (n === "to") {
                        if (r.runCallbacks === true)
                            i.fireCallback(t.onSlideChangeEnd, i)
                    } else {
                        i.fireCallback(t.onSlideChangeEnd, i)
                    }
                }
                i.setWrapperTranslate(e);
                i._DOMAnimating = false
            }
        }
        var s = n === "to" && r.speed >= 0 ? r.speed : t.speed;
        var o = +(new Date);
        if (i.support.transitions || !t.DOMAnimation) {
            i.setWrapperTranslate(e);
            i.setWrapperTransition(s)
        } else {
            var a = i.getWrapperTranslate();
            var f = Math.ceil((e - a) / s * (1e3 / 60));
            var l = a > e ? "toNext" : "toPrev";
            var c = l === "toNext" ? a > e : a < e;
            if (i._DOMAnimating)
                return;
            u()
        }
        i.updateActiveSlide(e);
        if (t.onSlideNext && n === "next") {
            i.fireCallback(t.onSlideNext, i, e)
        }
        if (t.onSlidePrev && n === "prev") {
            i.fireCallback(t.onSlidePrev, i, e)
        }
        if (t.onSlideReset && n === "reset") {
            i.fireCallback(t.onSlideReset, i, e)
        }
        if (n === "next" || n === "prev" || n === "to" && r.runCallbacks === true)
            $(n)
    }
    function $(e) {
        i.callPlugins("onSlideChangeStart");
        if (t.onSlideChangeStart) {
            if (t.queueStartCallbacks && i.support.transitions) {
                if (i._queueStartCallbacks)
                    return;
                i._queueStartCallbacks = true;
                i.fireCallback(t.onSlideChangeStart, i, e);
                i.wrapperTransitionEnd(function () {
                    i._queueStartCallbacks = false
                })
            } else
                i.fireCallback(t.onSlideChangeStart, i, e)
        }
        if (t.onSlideChangeEnd) {
            if (i.support.transitions) {
                if (t.queueEndCallbacks) {
                    if (i._queueEndCallbacks)
                        return;
                    i._queueEndCallbacks = true;
                    i.wrapperTransitionEnd(function (n) {
                        i.fireCallback(t.onSlideChangeEnd, n, e)
                    })
                } else {
                    i.wrapperTransitionEnd(function (n) {
                        i.fireCallback(t.onSlideChangeEnd, n, e)
                    })
                }
            } else {
                if (!t.DOMAnimation) {
                    setTimeout(function () {
                        i.fireCallback(t.onSlideChangeEnd, i, e)
                    }, 10)
                }
            }
        }
    }
    function J() {
        var e = i.paginationButtons;
        if (e) {
            for (var t = 0; t < e.length; t++) {
                i.h.removeEventListener(e[t], "click", Q)
            }
        }
    }
    function K() {
        var e = i.paginationButtons;
        if (e) {
            for (var t = 0; t < e.length; t++) {
                i.h.addEventListener(e[t], "click", Q)
            }
        }
    }
    function Q(e) {
        var t;
        var n = e.target || e.srcElement;
        var r = i.paginationButtons;
        for (var s = 0; s < r.length; s++) {
            if (n === r[s])
                t = s
        }
        i.swipeTo(t)
    }
    function Z() {
        G = setTimeout(function () {
            if (t.loop) {
                i.fixLoop();
                i.swipeNext(true)
            } else if (!i.swipeNext(true)) {
                if (!t.autoplayStopOnLast)
                    i.swipeTo(0);
                else {
                    clearTimeout(G);
                    G = undefined
                }
            }
            i.wrapperTransitionEnd(function () {
                if (typeof G !== "undefined")
                    Z()
            })
        }, t.autoplay)
    }
    function et() {
        i.calcSlides();
        if (t.loader.slides.length > 0 && i.slides.length === 0) {
            i.loadSlides()
        }
        if (t.loop) {
            i.createLoop()
        }
        i.init();
        T();
        if (t.pagination) {
            i.createPagination(true)
        }
        if (t.loop || t.initialSlide > 0) {
            i.swipeTo(t.initialSlide, 0, false)
        } else {
            i.updateActiveSlide(0)
        }
        if (t.autoplay) {
            i.startAutoplay()
        }
        i.centerIndex = i.activeIndex;
        if (t.onSwiperCreated)
            i.fireCallback(t.onSwiperCreated, i);
        i.callPlugins("onSwiperCreated")
    }
    if (document.body.__defineGetter__) {
        if (HTMLElement) {
            var n = HTMLElement.prototype;
            if (n.__defineGetter__) {
                n.__defineGetter__("outerHTML", function () {
                    return(new XMLSerializer).serializeToString(this)
                })
            }
        }
    }
    if (!window.getComputedStyle) {
        window.getComputedStyle = function (e, t) {
            this.el = e;
            this.getPropertyValue = function (t) {
                var n = /(\-([a-z]){1})/g;
                if (t === "float")
                    t = "styleFloat";
                if (n.test(t)) {
                    t = t.replace(n, function () {
                        return arguments[2].toUpperCase()
                    })
                }
                return e.currentStyle[t] ? e.currentStyle[t] : null
            };
            return this
        }
    }
    if (!Array.prototype.indexOf) {
        Array.prototype.indexOf = function (e, t) {
            for (var n = t || 0, r = this.length; n < r; n++) {
                if (this[n] === e) {
                    return n
                }
            }
            return-1
        }
    }
    if (!document.querySelectorAll) {
        if (!window.jQuery)
            return
    }
    if (typeof e === "undefined")
        return;
    if (!e.nodeType) {
        if (r(e).length === 0)
            return
    }
    var i = this;
    i.touches = {start: 0, startX: 0, startY: 0, current: 0, currentX: 0, currentY: 0, diff: 0, abs: 0};
    i.positions = {start: 0, abs: 0, diff: 0, current: 0};
    i.times = {start: 0, end: 0};
    i.id = (new Date).getTime();
    i.container = e.nodeType ? e : r(e)[0];
    i.isTouched = false;
    i.isMoved = false;
    i.activeIndex = 0;
    i.centerIndex = 0;
    i.activeLoaderIndex = 0;
    i.activeLoopIndex = 0;
    i.previousIndex = null;
    i.velocity = 0;
    i.snapGrid = [];
    i.slidesGrid = [];
    i.imagesToLoad = [];
    i.imagesLoaded = 0;
    i.wrapperLeft = 0;
    i.wrapperRight = 0;
    i.wrapperTop = 0;
    i.wrapperBottom = 0;
    i.isAndroid = navigator.userAgent.toLowerCase().indexOf("android") >= 0;
    var s, o, u, a, f, l;
    var c = {eventTarget: "wrapper", mode: "horizontal", touchRatio: 1, speed: 300, freeMode: false, freeModeFluid: false, momentumRatio: 1, momentumBounce: true, momentumBounceRatio: 1, slidesPerView: 1, slidesPerGroup: 1, slidesPerViewFit: true, simulateTouch: true, followFinger: true, shortSwipes: true, longSwipesRatio: .5, moveStartThreshold: false, onlyExternal: false, createPagination: true, pagination: false, paginationElement: "span", paginationClickable: false, paginationAsRange: true, resistance: true, scrollContainer: false, preventLinks: true, preventLinksPropagation: false, noSwiping: false, noSwipingClass: "swiper-no-swiping", initialSlide: 0, keyboardControl: false, mousewheelControl: false, mousewheelControlForceToAxis: false, useCSS3Transforms: true, autoplay: false, autoplayDisableOnInteraction: true, autoplayStopOnLast: false, loop: false, loopAdditionalSlides: 0, roundLengths: false, calculateHeight: false, cssWidthAndHeight: false, updateOnImagesReady: true, releaseFormElements: true, watchActiveIndex: false, visibilityFullFit: false, offsetPxBefore: 0, offsetPxAfter: 0, offsetSlidesBefore: 0, offsetSlidesAfter: 0, centeredSlides: false, queueStartCallbacks: false, queueEndCallbacks: false, autoResize: true, resizeReInit: false, DOMAnimation: true, loader: {slides: [], slidesHTMLType: "inner", surroundGroups: 1, logic: "reload", loadAllSlides: false}, slideElement: "div", slideClass: "swiper-slide", slideActiveClass: "swiper-slide-active", slideVisibleClass: "swiper-slide-visible", slideDuplicateClass: "swiper-slide-duplicate", wrapperClass: "swiper-wrapper", paginationElementClass: "swiper-pagination-switch", paginationActiveClass: "swiper-active-switch", paginationVisibleClass: "swiper-visible-switch"};
    t = t || {};
    for (var h in c) {
        if (h in t && typeof t[h] === "object") {
            for (var p in c[h]) {
                if (!(p in t[h])) {
                    t[h][p] = c[h][p]
                }
            }
        } else if (!(h in t)) {
            t[h] = c[h]
        }
    }
    i.params = t;
    if (t.scrollContainer) {
        t.freeMode = true;
        t.freeModeFluid = true
    }
    if (t.loop) {
        t.resistance = "100%"
    }
    var d = t.mode === "horizontal";
    var v = ["mousedown", "mousemove", "mouseup"];
    if (i.browser.ie10)
        v = ["MSPointerDown", "MSPointerMove", "MSPointerUp"];
    if (i.browser.ie11)
        v = ["pointerdown", "pointermove", "pointerup"];
    i.touchEvents = {touchStart: i.support.touch || !t.simulateTouch ? "touchstart" : v[0], touchMove: i.support.touch || !t.simulateTouch ? "touchmove" : v[1], touchEnd: i.support.touch || !t.simulateTouch ? "touchend" : v[2]};
    for (var m = i.container.childNodes.length - 1; m >= 0; m--) {
        if (i.container.childNodes[m].className) {
            var g = i.container.childNodes[m].className.split(/\s+/);
            for (var y = 0; y < g.length; y++) {
                if (g[y] === t.wrapperClass) {
                    s = i.container.childNodes[m]
                }
            }
        }
    }
    i.wrapper = s;
    i._extendSwiperSlide = function (e) {
        e.append = function () {
            if (t.loop) {
                e.insertAfter(i.slides.length - i.loopedSlides)
            } else {
                i.wrapper.appendChild(e);
                i.reInit()
            }
            return e
        };
        e.prepend = function () {
            if (t.loop) {
                i.wrapper.insertBefore(e, i.slides[i.loopedSlides]);
                i.removeLoopedSlides();
                i.calcSlides();
                i.createLoop()
            } else {
                i.wrapper.insertBefore(e, i.wrapper.firstChild)
            }
            i.reInit();
            return e
        };
        e.insertAfter = function (n) {
            if (typeof n === "undefined")
                return false;
            var r;
            if (t.loop) {
                r = i.slides[n + 1 + i.loopedSlides];
                if (r) {
                    i.wrapper.insertBefore(e, r)
                } else {
                    i.wrapper.appendChild(e)
                }
                i.removeLoopedSlides();
                i.calcSlides();
                i.createLoop()
            } else {
                r = i.slides[n + 1];
                i.wrapper.insertBefore(e, r)
            }
            i.reInit();
            return e
        };
        e.clone = function () {
            return i._extendSwiperSlide(e.cloneNode(true))
        };
        e.remove = function () {
            i.wrapper.removeChild(e);
            i.reInit()
        };
        e.html = function (t) {
            if (typeof t === "undefined") {
                return e.innerHTML
            } else {
                e.innerHTML = t;
                return e
            }
        };
        e.index = function () {
            var t;
            for (var n = i.slides.length - 1; n >= 0; n--) {
                if (e === i.slides[n])
                    t = n
            }
            return t
        };
        e.isActive = function () {
            if (e.index() === i.activeIndex)
                return true;
            else
                return false
        };
        if (!e.swiperSlideDataStorage)
            e.swiperSlideDataStorage = {};
        e.getData = function (t) {
            return e.swiperSlideDataStorage[t]
        };
        e.setData = function (t, n) {
            e.swiperSlideDataStorage[t] = n;
            return e
        };
        e.data = function (t, n) {
            if (typeof n === "undefined") {
                return e.getAttribute("data-" + t)
            } else {
                e.setAttribute("data-" + t, n);
                return e
            }
        };
        e.getWidth = function (t, n) {
            return i.h.getWidth(e, t, n)
        };
        e.getHeight = function (t, n) {
            return i.h.getHeight(e, t, n)
        };
        e.getOffset = function () {
            return i.h.getOffset(e)
        };
        return e
    };
    i.calcSlides = function (e) {
        var n = i.slides ? i.slides.length : false;
        i.slides = [];
        i.displaySlides = [];
        for (var r = 0; r < i.wrapper.childNodes.length; r++) {
            if (i.wrapper.childNodes[r].className) {
                var s = i.wrapper.childNodes[r].className;
                var o = s.split(/\s+/);
                for (var u = 0; u < o.length; u++) {
                    if (o[u] === t.slideClass) {
                        i.slides.push(i.wrapper.childNodes[r])
                    }
                }
            }
        }
        for (r = i.slides.length - 1; r >= 0; r--) {
            i._extendSwiperSlide(i.slides[r])
        }
        if (n === false)
            return;
        if (n !== i.slides.length || e) {
            C();
            N();
            i.updateActiveSlide();
            if (i.params.pagination)
                i.createPagination();
            i.callPlugins("numberOfSlidesChanged")
        }
    };
    i.createSlide = function (e, n, r) {
        n = n || i.params.slideClass;
        r = r || t.slideElement;
        var s = document.createElement(r);
        s.innerHTML = e || "";
        s.className = n;
        return i._extendSwiperSlide(s)
    };
    i.appendSlide = function (e, t, n) {
        if (!e)
            return;
        if (e.nodeType) {
            return i._extendSwiperSlide(e).append()
        } else {
            return i.createSlide(e, t, n).append()
        }
    };
    i.prependSlide = function (e, t, n) {
        if (!e)
            return;
        if (e.nodeType) {
            return i._extendSwiperSlide(e).prepend()
        } else {
            return i.createSlide(e, t, n).prepend()
        }
    };
    i.insertSlideAfter = function (e, t, n, r) {
        if (typeof e === "undefined")
            return false;
        if (t.nodeType) {
            return i._extendSwiperSlide(t).insertAfter(e)
        } else {
            return i.createSlide(t, n, r).insertAfter(e)
        }
    };
    i.removeSlide = function (e) {
        if (i.slides[e]) {
            if (t.loop) {
                if (!i.slides[e + i.loopedSlides])
                    return false;
                i.slides[e + i.loopedSlides].remove();
                i.removeLoopedSlides();
                i.calcSlides();
                i.createLoop()
            } else
                i.slides[e].remove();
            return true
        } else
            return false
    };
    i.removeLastSlide = function () {
        if (i.slides.length > 0) {
            if (t.loop) {
                i.slides[i.slides.length - 1 - i.loopedSlides].remove();
                i.removeLoopedSlides();
                i.calcSlides();
                i.createLoop()
            } else
                i.slides[i.slides.length - 1].remove();
            return true
        } else {
            return false
        }
    };
    i.removeAllSlides = function () {
        for (var e = i.slides.length - 1; e >= 0; e--) {
            i.slides[e].remove()
        }
    };
    i.getSlide = function (e) {
        return i.slides[e]
    };
    i.getLastSlide = function () {
        return i.slides[i.slides.length - 1]
    };
    i.getFirstSlide = function () {
        return i.slides[0]
    };
    i.activeSlide = function () {
        return i.slides[i.activeIndex]
    };
    i.fireCallback = function () {
        var e = arguments[0];
        if (Object.prototype.toString.call(e) === "[object Array]") {
            for (var n = 0; n < e.length; n++) {
                if (typeof e[n] === "function") {
                    e[n](arguments[1], arguments[2], arguments[3], arguments[4], arguments[5])
                }
            }
        } else if (Object.prototype.toString.call(e) === "[object String]") {
            if (t["on" + e])
                i.fireCallback(t["on" + e], arguments[1], arguments[2], arguments[3], arguments[4], arguments[5])
        } else {
            e(arguments[1], arguments[2], arguments[3], arguments[4], arguments[5])
        }
    };
    i.addCallback = function (e, t) {
        var n = this, r;
        if (n.params["on" + e]) {
            if (b(this.params["on" + e])) {
                return this.params["on" + e].push(t)
            } else if (typeof this.params["on" + e] === "function") {
                r = this.params["on" + e];
                this.params["on" + e] = [];
                this.params["on" + e].push(r);
                return this.params["on" + e].push(t)
            }
        } else {
            this.params["on" + e] = [];
            return this.params["on" + e].push(t)
        }
    };
    i.removeCallbacks = function (e) {
        if (i.params["on" + e]) {
            i.params["on" + e] = null
        }
    };
    var w = [];
    for (var E in i.plugins) {
        if (t[E]) {
            var S = i.plugins[E](i, t[E]);
            if (S)
                w.push(S)
        }
    }
    i.callPlugins = function (e, t) {
        if (!t)
            t = {};
        for (var n = 0; n < w.length; n++) {
            if (e in w[n]) {
                w[n][e](t)
            }
        }
    };
    if ((i.browser.ie10 || i.browser.ie11) && !t.onlyExternal) {
        i.wrapper.classList.add("swiper-wp8-" + (d ? "horizontal" : "vertical"))
    }
    if (t.freeMode) {
        i.container.className += " swiper-free-mode"
    }
    i.initialized = false;
    i.init = function (e, n) {
        var r = i.h.getWidth(i.container, false, t.roundLengths);
        var s = i.h.getHeight(i.container, false, t.roundLengths);
        if (r === i.width && s === i.height && !e)
            return;
        i.width = r;
        i.height = s;
        var a, f, c, h, p, v;
        var m;
        l = d ? r : s;
        var g = i.wrapper;
        if (e) {
            i.calcSlides(n)
        }
        if (t.slidesPerView === "auto") {
            var y = 0;
            var b = 0;
            if (t.slidesOffset > 0) {
                g.style.paddingLeft = "";
                g.style.paddingRight = "";
                g.style.paddingTop = "";
                g.style.paddingBottom = ""
            }
            g.style.width = "";
            g.style.height = "";
            if (t.offsetPxBefore > 0) {
                if (d)
                    i.wrapperLeft = t.offsetPxBefore;
                else
                    i.wrapperTop = t.offsetPxBefore
            }
            if (t.offsetPxAfter > 0) {
                if (d)
                    i.wrapperRight = t.offsetPxAfter;
                else
                    i.wrapperBottom = t.offsetPxAfter
            }
            if (t.centeredSlides) {
                if (d) {
                    i.wrapperLeft = (l - this.slides[0].getWidth(true, t.roundLengths)) / 2;
                    i.wrapperRight = (l - i.slides[i.slides.length - 1].getWidth(true, t.roundLengths)) / 2
                } else {
                    i.wrapperTop = (l - i.slides[0].getHeight(true, t.roundLengths)) / 2;
                    i.wrapperBottom = (l - i.slides[i.slides.length - 1].getHeight(true, t.roundLengths)) / 2
                }
            }
            if (d) {
                if (i.wrapperLeft >= 0)
                    g.style.paddingLeft = i.wrapperLeft + "px";
                if (i.wrapperRight >= 0)
                    g.style.paddingRight = i.wrapperRight + "px"
            } else {
                if (i.wrapperTop >= 0)
                    g.style.paddingTop = i.wrapperTop + "px";
                if (i.wrapperBottom >= 0)
                    g.style.paddingBottom = i.wrapperBottom + "px"
            }
            v = 0;
            var w = 0;
            i.snapGrid = [];
            i.slidesGrid = [];
            c = 0;
            for (m = 0; m < i.slides.length; m++) {
                a = i.slides[m].getWidth(true, t.roundLengths);
                f = i.slides[m].getHeight(true, t.roundLengths);
                if (t.calculateHeight) {
                    c = Math.max(c, f)
                }
                var E = d ? a : f;
                if (t.centeredSlides) {
                    var S = m === i.slides.length - 1 ? 0 : i.slides[m + 1].getWidth(true, t.roundLengths);
                    var x = m === i.slides.length - 1 ? 0 : i.slides[m + 1].getHeight(true, t.roundLengths);
                    var T = d ? S : x;
                    if (E > l) {
                        if (t.slidesPerViewFit) {
                            i.snapGrid.push(v + i.wrapperLeft);
                            i.snapGrid.push(v + E - l + i.wrapperLeft)
                        } else {
                            for (var N = 0; N <= Math.floor(E / (l + i.wrapperLeft)); N++) {
                                if (N === 0)
                                    i.snapGrid.push(v + i.wrapperLeft);
                                else
                                    i.snapGrid.push(v + i.wrapperLeft + l * N)
                            }
                        }
                        i.slidesGrid.push(v + i.wrapperLeft)
                    } else {
                        i.snapGrid.push(w);
                        i.slidesGrid.push(w)
                    }
                    w += E / 2 + T / 2
                } else {
                    if (E > l) {
                        if (t.slidesPerViewFit) {
                            i.snapGrid.push(v);
                            i.snapGrid.push(v + E - l)
                        } else {
                            if (l !== 0) {
                                for (var C = 0; C <= Math.floor(E / l); C++) {
                                    i.snapGrid.push(v + l * C)
                                }
                            } else {
                                i.snapGrid.push(v)
                            }
                        }
                    } else {
                        i.snapGrid.push(v)
                    }
                    i.slidesGrid.push(v)
                }
                v += E;
                y += a;
                b += f
            }
            if (t.calculateHeight)
                i.height = c;
            if (d) {
                u = y + i.wrapperRight + i.wrapperLeft;
                g.style.width = y + "px";
                g.style.height = i.height + "px"
            } else {
                u = b + i.wrapperTop + i.wrapperBottom;
                g.style.width = i.width + "px";
                g.style.height = b + "px"
            }
        } else if (t.scrollContainer) {
            g.style.width = "";
            g.style.height = "";
            h = i.slides[0].getWidth(true, t.roundLengths);
            p = i.slides[0].getHeight(true, t.roundLengths);
            u = d ? h : p;
            g.style.width = h + "px";
            g.style.height = p + "px";
            o = d ? h : p
        } else {
            if (t.calculateHeight) {
                c = 0;
                p = 0;
                if (!d)
                    i.container.style.height = "";
                g.style.height = "";
                for (m = 0; m < i.slides.length; m++) {
                    i.slides[m].style.height = "";
                    c = Math.max(i.slides[m].getHeight(true), c);
                    if (!d)
                        p += i.slides[m].getHeight(true)
                }
                f = c;
                i.height = f;
                if (d)
                    p = f;
                else {
                    l = f;
                    i.container.style.height = l + "px"
                }
            } else {
                f = d ? i.height : i.height / t.slidesPerView;
                if (t.roundLengths)
                    f = Math.ceil(f);
                p = d ? i.height : i.slides.length * f
            }
            a = d ? i.width / t.slidesPerView : i.width;
            if (t.roundLengths)
                a = Math.ceil(a);
            h = d ? i.slides.length * a : i.width;
            o = d ? a : f;
            if (t.offsetSlidesBefore > 0) {
                if (d)
                    i.wrapperLeft = o * t.offsetSlidesBefore;
                else
                    i.wrapperTop = o * t.offsetSlidesBefore
            }
            if (t.offsetSlidesAfter > 0) {
                if (d)
                    i.wrapperRight = o * t.offsetSlidesAfter;
                else
                    i.wrapperBottom = o * t.offsetSlidesAfter
            }
            if (t.offsetPxBefore > 0) {
                if (d)
                    i.wrapperLeft = t.offsetPxBefore;
                else
                    i.wrapperTop = t.offsetPxBefore
            }
            if (t.offsetPxAfter > 0) {
                if (d)
                    i.wrapperRight = t.offsetPxAfter;
                else
                    i.wrapperBottom = t.offsetPxAfter
            }
            if (t.centeredSlides) {
                if (d) {
                    i.wrapperLeft = (l - o) / 2;
                    i.wrapperRight = (l - o) / 2
                } else {
                    i.wrapperTop = (l - o) / 2;
                    i.wrapperBottom = (l - o) / 2
                }
            }
            if (d) {
                if (i.wrapperLeft > 0)
                    g.style.paddingLeft = i.wrapperLeft + "px";
                if (i.wrapperRight > 0)
                    g.style.paddingRight = i.wrapperRight + "px"
            } else {
                if (i.wrapperTop > 0)
                    g.style.paddingTop = i.wrapperTop + "px";
                if (i.wrapperBottom > 0)
                    g.style.paddingBottom = i.wrapperBottom + "px"
            }
            u = d ? h + i.wrapperRight + i.wrapperLeft : p + i.wrapperTop + i.wrapperBottom;
            if (!t.cssWidthAndHeight) {
                if (parseFloat(h) > 0) {
                    g.style.width = h + "px"
                }
                if (parseFloat(p) > 0) {
                    g.style.height = p + "px"
                }
            }
            v = 0;
            i.snapGrid = [];
            i.slidesGrid = [];
            for (m = 0; m < i.slides.length; m++) {
                i.snapGrid.push(v);
                i.slidesGrid.push(v);
                v += o;
                if (!t.cssWidthAndHeight) {
                    if (parseFloat(a) > 0) {
                        i.slides[m].style.width = a + "px"
                    }
                    if (parseFloat(f) > 0) {
                        i.slides[m].style.height = f + "px"
                    }
                }
            }
        }
        if (!i.initialized) {
            i.callPlugins("onFirstInit");
            if (t.onFirstInit)
                i.fireCallback(t.onFirstInit, i)
        } else {
            i.callPlugins("onInit");
            if (t.onInit)
                i.fireCallback(t.onInit, i)
        }
        i.initialized = true
    };
    i.reInit = function (e) {
        i.init(true, e)
    };
    i.resizeFix = function (e) {
        i.callPlugins("beforeResizeFix");
        i.init(t.resizeReInit || e);
        if (!t.freeMode) {
            i.swipeTo(t.loop ? i.activeLoopIndex : i.activeIndex, 0, false);
            if (t.autoplay) {
                if (i.support.transitions && typeof G !== "undefined") {
                    if (typeof G !== "undefined") {
                        clearTimeout(G);
                        G = undefined;
                        i.startAutoplay()
                    }
                } else {
                    if (typeof Y !== "undefined") {
                        clearInterval(Y);
                        Y = undefined;
                        i.startAutoplay()
                    }
                }
            }
        } else if (i.getWrapperTranslate() < -x()) {
            i.setWrapperTransition(0);
            i.setWrapperTranslate(-x())
        }
        i.callPlugins("afterResizeFix")
    };
    i.destroy = function () {
        var e = i.h.removeEventListener;
        var n = t.eventTarget === "wrapper" ? i.wrapper : i.container;
        if (!(i.browser.ie10 || i.browser.ie11)) {
            if (i.support.touch) {
                e(n, "touchstart", I);
                e(n, "touchmove", U);
                e(n, "touchend", z)
            }
            if (t.simulateTouch) {
                e(n, "mousedown", I);
                e(document, "mousemove", U);
                e(document, "mouseup", z)
            }
        } else {
            e(n, i.touchEvents.touchStart, I);
            e(document, i.touchEvents.touchMove, U);
            e(document, i.touchEvents.touchEnd, z)
        }
        if (t.autoResize) {
            e(window, "resize", i.resizeFix)
        }
        C();
        if (t.paginationClickable) {
            J()
        }
        if (t.mousewheelControl && i._wheelEvent) {
            e(i.container, i._wheelEvent, A)
        }
        if (t.keyboardControl) {
            e(document, "keydown", k)
        }
        if (t.autoplay) {
            i.stopAutoplay()
        }
        i.callPlugins("onDestroy");
        i = null
    };
    i.disableKeyboardControl = function () {
        t.keyboardControl = false;
        i.h.removeEventListener(document, "keydown", k)
    };
    i.enableKeyboardControl = function () {
        t.keyboardControl = true;
        i.h.addEventListener(document, "keydown", k)
    };
    var L = (new Date).getTime();
    i.disableMousewheelControl = function () {
        if (!i._wheelEvent)
            return false;
        t.mousewheelControl = false;
        i.h.removeEventListener(i.container, i._wheelEvent, A);
        return true
    };
    i.enableMousewheelControl = function () {
        if (!i._wheelEvent)
            return false;
        t.mousewheelControl = true;
        i.h.addEventListener(i.container, i._wheelEvent, A);
        return true
    };
    if (t.grabCursor) {
        var O = i.container.style;
        O.cursor = "move";
        O.cursor = "grab";
        O.cursor = "-moz-grab";
        O.cursor = "-webkit-grab"
    }
    i.allowSlideClick = true;
    i.allowLinks = true;
    var B = false;
    var j;
    var F = true;
    var q, R;
    i.swipeNext = function (e) {
        if (!e && t.loop)
            i.fixLoop();
        if (!e && t.autoplay)
            i.stopAutoplay(true);
        i.callPlugins("onSwipeNext");
        var n = i.getWrapperTranslate();
        var r = n;
        if (t.slidesPerView === "auto") {
            for (var s = 0; s < i.snapGrid.length; s++) {
                if (-n >= i.snapGrid[s] && -n < i.snapGrid[s + 1]) {
                    r = -i.snapGrid[s + 1];
                    break
                }
            }
        } else {
            var u = o * t.slidesPerGroup;
            r = -(Math.floor(Math.abs(n) / Math.floor(u)) * u + u)
        }
        if (r < -x()) {
            r = -x()
        }
        if (r === n)
            return false;
        V(r, "next");
        return true
    };
    i.swipePrev = function (e) {
        if (!e && t.loop)
            i.fixLoop();
        if (!e && t.autoplay)
            i.stopAutoplay(true);
        i.callPlugins("onSwipePrev");
        var n = Math.ceil(i.getWrapperTranslate());
        var r;
        if (t.slidesPerView === "auto") {
            r = 0;
            for (var s = 1; s < i.snapGrid.length; s++) {
                if (-n === i.snapGrid[s]) {
                    r = -i.snapGrid[s - 1];
                    break
                }
                if (-n > i.snapGrid[s] && -n < i.snapGrid[s + 1]) {
                    r = -i.snapGrid[s];
                    break
                }
            }
        } else {
            var u = o * t.slidesPerGroup;
            r = -(Math.ceil(-n / u) - 1) * u
        }
        if (r > 0)
            r = 0;
        if (r === n)
            return false;
        V(r, "prev");
        return true
    };
    i.swipeReset = function () {
        i.callPlugins("onSwipeReset");
        var e = i.getWrapperTranslate();
        var n = o * t.slidesPerGroup;
        var r;
        var s = -x();
        if (t.slidesPerView === "auto") {
            r = 0;
            for (var u = 0; u < i.snapGrid.length; u++) {
                if (-e === i.snapGrid[u])
                    return;
                if (-e >= i.snapGrid[u] && -e < i.snapGrid[u + 1]) {
                    if (i.positions.diff > 0)
                        r = -i.snapGrid[u + 1];
                    else
                        r = -i.snapGrid[u];
                    break
                }
            }
            if (-e >= i.snapGrid[i.snapGrid.length - 1])
                r = -i.snapGrid[i.snapGrid.length - 1];
            if (e <= -x())
                r = -x()
        } else {
            r = e < 0 ? Math.ceil(e / n) * n : 0
        }
        if (t.scrollContainer) {
            r = e < 0 ? e : 0
        }
        if (r < -x()) {
            r = -x()
        }
        if (t.scrollContainer && l > o) {
            r = 0
        }
        if (r === e)
            return false;
        V(r, "reset");
        return true
    };
    i.swipeTo = function (e, n, r) {
        e = parseInt(e, 10);
        i.callPlugins("onSwipeTo", {index: e, speed: n});
        if (t.loop)
            e = e + i.loopedSlides;
        var s = i.getWrapperTranslate();
        if (e > i.slides.length - 1 || e < 0)
            return;
        var u;
        if (t.slidesPerView === "auto") {
            u = -i.slidesGrid[e]
        } else {
            u = -e * o
        }
        if (u < -x()) {
            u = -x()
        }
        if (u === s)
            return false;
        r = r === false ? false : true;
        V(u, "to", {index: e, speed: n, runCallbacks: r});
        return true
    };
    i._queueStartCallbacks = false;
    i._queueEndCallbacks = false;
    i.updateActiveSlide = function (e) {
        if (!i.initialized)
            return;
        if (i.slides.length === 0)
            return;
        i.previousIndex = i.activeIndex;
        if (typeof e === "undefined")
            e = i.getWrapperTranslate();
        if (e > 0)
            e = 0;
        var n;
        if (t.slidesPerView === "auto") {
            var r = 0;
            i.activeIndex = i.slidesGrid.indexOf(-e);
            if (i.activeIndex < 0) {
                for (n = 0; n < i.slidesGrid.length - 1; n++) {
                    if (-e > i.slidesGrid[n] && -e < i.slidesGrid[n + 1]) {
                        break
                    }
                }
                var s = Math.abs(i.slidesGrid[n] + e);
                var u = Math.abs(i.slidesGrid[n + 1] + e);
                if (s <= u)
                    i.activeIndex = n;
                else
                    i.activeIndex = n + 1
            }
        } else {
            i.activeIndex = Math[t.visibilityFullFit ? "ceil" : "round"](-e / o)
        }
        if (i.activeIndex === i.slides.length)
            i.activeIndex = i.slides.length - 1;
        if (i.activeIndex < 0)
            i.activeIndex = 0;
        if (!i.slides[i.activeIndex])
            return;
        i.calcVisibleSlides(e);
        if (i.support.classList) {
            var a;
            for (n = 0; n < i.slides.length; n++) {
                a = i.slides[n];
                a.classList.remove(t.slideActiveClass);
                if (i.visibleSlides.indexOf(a) >= 0) {
                    a.classList.add(t.slideVisibleClass)
                } else {
                    a.classList.remove(t.slideVisibleClass)
                }
            }
            i.slides[i.activeIndex].classList.add(t.slideActiveClass)
        } else {
            var f = new RegExp("\\s*" + t.slideActiveClass);
            var l = new RegExp("\\s*" + t.slideVisibleClass);
            for (n = 0; n < i.slides.length; n++) {
                i.slides[n].className = i.slides[n].className.replace(f, "").replace(l, "");
                if (i.visibleSlides.indexOf(i.slides[n]) >= 0) {
                    i.slides[n].className += " " + t.slideVisibleClass
                }
            }
            i.slides[i.activeIndex].className += " " + t.slideActiveClass
        }
        if (t.loop) {
            var c = i.loopedSlides;
            i.activeLoopIndex = i.activeIndex - c;
            if (i.activeLoopIndex >= i.slides.length - c * 2) {
                i.activeLoopIndex = i.slides.length - c * 2 - i.activeLoopIndex
            }
            if (i.activeLoopIndex < 0) {
                i.activeLoopIndex = i.slides.length - c * 2 + i.activeLoopIndex
            }
            if (i.activeLoopIndex < 0)
                i.activeLoopIndex = 0
        } else {
            i.activeLoopIndex = i.activeIndex
        }
        if (t.pagination) {
            i.updatePagination(e)
        }
    };
    i.createPagination = function (e) {
        if (t.paginationClickable && i.paginationButtons) {
            J()
        }
        i.paginationContainer = t.pagination.nodeType ? t.pagination : r(t.pagination)[0];
        if (t.createPagination) {
            var n = "";
            var s = i.slides.length;
            var o = s;
            if (t.loop)
                o -= i.loopedSlides * 2;
            for (var u = 0; u < o; u++) {
                n += "<" + t.paginationElement + ' class="' + t.paginationElementClass + '"></' + t.paginationElement + ">"
            }
            i.paginationContainer.innerHTML = n
        }
        i.paginationButtons = r("." + t.paginationElementClass, i.paginationContainer);
        if (!e)
            i.updatePagination();
        i.callPlugins("onCreatePagination");
        if (t.paginationClickable) {
            K()
        }
    };
    i.updatePagination = function (e) {
        if (!t.pagination)
            return;
        if (i.slides.length < 1)
            return;
        var n = r("." + t.paginationActiveClass, i.paginationContainer);
        if (!n)
            return;
        var s = i.paginationButtons;
        if (s.length === 0)
            return;
        for (var o = 0; o < s.length; o++) {
            s[o].className = t.paginationElementClass
        }
        var u = t.loop ? i.loopedSlides : 0;
        if (t.paginationAsRange) {
            if (!i.visibleSlides)
                i.calcVisibleSlides(e);
            var a = [];
            var f;
            for (f = 0; f < i.visibleSlides.length; f++) {
                var l = i.slides.indexOf(i.visibleSlides[f]) - u;
                if (t.loop && l < 0) {
                    l = i.slides.length - i.loopedSlides * 2 + l
                }
                if (t.loop && l >= i.slides.length - i.loopedSlides * 2) {
                    l = i.slides.length - i.loopedSlides * 2 - l;
                    l = Math.abs(l)
                }
                a.push(l)
            }
            for (f = 0; f < a.length; f++) {
                if (s[a[f]])
                    s[a[f]].className += " " + t.paginationVisibleClass
            }
            if (t.loop) {
                if (s[i.activeLoopIndex] !== undefined) {
                    s[i.activeLoopIndex].className += " " + t.paginationActiveClass
                }
            } else {
                s[i.activeIndex].className += " " + t.paginationActiveClass
            }
        } else {
            if (t.loop) {
                if (s[i.activeLoopIndex])
                    s[i.activeLoopIndex].className += " " + t.paginationActiveClass + " " + t.paginationVisibleClass
            } else {
                s[i.activeIndex].className += " " + t.paginationActiveClass + " " + t.paginationVisibleClass
            }
        }
    };
    i.calcVisibleSlides = function (e) {
        var n = [];
        var r = 0, s = 0, u = 0;
        if (d && i.wrapperLeft > 0)
            e = e + i.wrapperLeft;
        if (!d && i.wrapperTop > 0)
            e = e + i.wrapperTop;
        for (var a = 0; a < i.slides.length; a++) {
            r += s;
            if (t.slidesPerView === "auto")
                s = d ? i.h.getWidth(i.slides[a], true, t.roundLengths) : i.h.getHeight(i.slides[a], true, t.roundLengths);
            else
                s = o;
            u = r + s;
            var f = false;
            if (t.visibilityFullFit) {
                if (r >= -e && u <= -e + l)
                    f = true;
                if (r <= -e && u >= -e + l)
                    f = true
            } else {
                if (u > -e && u <= -e + l)
                    f = true;
                if (r >= -e && r < -e + l)
                    f = true;
                if (r < -e && u > -e + l)
                    f = true
            }
            if (f)
                n.push(i.slides[a])
        }
        if (n.length === 0)
            n = [i.slides[i.activeIndex]];
        i.visibleSlides = n
    };
    var G, Y;
    i.startAutoplay = function () {
        if (i.support.transitions) {
            if (typeof G !== "undefined")
                return false;
            if (!t.autoplay)
                return;
            i.callPlugins("onAutoplayStart");
            if (t.onAutoplayStart)
                i.fireCallback(t.onAutoplayStart, i);
            Z()
        } else {
            if (typeof Y !== "undefined")
                return false;
            if (!t.autoplay)
                return;
            i.callPlugins("onAutoplayStart");
            if (t.onAutoplayStart)
                i.fireCallback(t.onAutoplayStart, i);
            Y = setInterval(function () {
                if (t.loop) {
                    i.fixLoop();
                    i.swipeNext(true)
                } else if (!i.swipeNext(true)) {
                    if (!t.autoplayStopOnLast)
                        i.swipeTo(0);
                    else {
                        clearInterval(Y);
                        Y = undefined
                    }
                }
            }, t.autoplay)
        }
    };
    i.stopAutoplay = function (e) {
        if (i.support.transitions) {
            if (!G)
                return;
            if (G)
                clearTimeout(G);
            G = undefined;
            if (e && !t.autoplayDisableOnInteraction) {
                i.wrapperTransitionEnd(function () {
                    Z()
                })
            }
            i.callPlugins("onAutoplayStop");
            if (t.onAutoplayStop)
                i.fireCallback(t.onAutoplayStop, i)
        } else {
            if (Y)
                clearInterval(Y);
            Y = undefined;
            i.callPlugins("onAutoplayStop");
            if (t.onAutoplayStop)
                i.fireCallback(t.onAutoplayStop, i)
        }
    };
    i.loopCreated = false;
    i.removeLoopedSlides = function () {
        if (i.loopCreated) {
            for (var e = 0; e < i.slides.length; e++) {
                if (i.slides[e].getData("looped") === true)
                    i.wrapper.removeChild(i.slides[e])
            }
        }
    };
    i.createLoop = function () {
        if (i.slides.length === 0)
            return;
        if (t.slidesPerView === "auto") {
            i.loopedSlides = t.loopedSlides || 1
        } else {
            i.loopedSlides = t.slidesPerView + t.loopAdditionalSlides
        }
        if (i.loopedSlides > i.slides.length) {
            i.loopedSlides = i.slides.length
        }
        var e = "", n = "", r;
        var o = "";
        var u = i.slides.length;
        var a = Math.floor(i.loopedSlides / u);
        var f = i.loopedSlides % u;
        for (r = 0; r < a * u; r++) {
            var l = r;
            if (r >= u) {
                var c = Math.floor(r / u);
                l = r - u * c
            }
            o += i.slides[l].outerHTML
        }
        for (r = 0; r < f; r++) {
            n += X(t.slideDuplicateClass, i.slides[r].outerHTML)
        }
        for (r = u - f; r < u; r++) {
            e += X(t.slideDuplicateClass, i.slides[r].outerHTML)
        }
        var h = e + o + s.innerHTML + o + n;
        s.innerHTML = h;
        i.loopCreated = true;
        i.calcSlides();
        for (r = 0; r < i.slides.length; r++) {
            if (r < i.loopedSlides || r >= i.slides.length - i.loopedSlides)
                i.slides[r].setData("looped", true)
        }
        i.callPlugins("onCreateLoop")
    };
    i.fixLoop = function () {
        var e;
        if (i.activeIndex < i.loopedSlides) {
            e = i.slides.length - i.loopedSlides * 3 + i.activeIndex;
            i.swipeTo(e, 0, false)
        } else if (t.slidesPerView === "auto" && i.activeIndex >= i.loopedSlides * 2 || i.activeIndex > i.slides.length - t.slidesPerView * 2) {
            e = -i.slides.length + i.activeIndex + i.loopedSlides;
            i.swipeTo(e, 0, false)
        }
    };
    i.loadSlides = function () {
        var e = "";
        i.activeLoaderIndex = 0;
        var n = t.loader.slides;
        var r = t.loader.loadAllSlides ? n.length : t.slidesPerView * (1 + t.loader.surroundGroups);
        for (var s = 0; s < r; s++) {
            if (t.loader.slidesHTMLType === "outer")
                e += n[s];
            else {
                e += "<" + t.slideElement + ' class="' + t.slideClass + '" data-swiperindex="' + s + '">' + n[s] + "</" + t.slideElement + ">"
            }
        }
        i.wrapper.innerHTML = e;
        i.calcSlides(true);
        if (!t.loader.loadAllSlides) {
            i.wrapperTransitionEnd(i.reloadSlides, true)
        }
    };
    i.reloadSlides = function () {
        var e = t.loader.slides;
        var n = parseInt(i.activeSlide().data("swiperindex"), 10);
        if (n < 0 || n > e.length - 1)
            return;
        i.activeLoaderIndex = n;
        var r = Math.max(0, n - t.slidesPerView * t.loader.surroundGroups);
        var s = Math.min(n + t.slidesPerView * (1 + t.loader.surroundGroups) - 1, e.length - 1);
        if (n > 0) {
            var u = -o * (n - r);
            i.setWrapperTranslate(u);
            i.setWrapperTransition(0)
        }
        var a;
        if (t.loader.logic === "reload") {
            i.wrapper.innerHTML = "";
            var f = "";
            for (a = r; a <= s; a++) {
                f += t.loader.slidesHTMLType === "outer" ? e[a] : "<" + t.slideElement + ' class="' + t.slideClass + '" data-swiperindex="' + a + '">' + e[a] + "</" + t.slideElement + ">"
            }
            i.wrapper.innerHTML = f
        } else {
            var l = 1e3;
            var c = 0;
            for (a = 0; a < i.slides.length; a++) {
                var h = i.slides[a].data("swiperindex");
                if (h < r || h > s) {
                    i.wrapper.removeChild(i.slides[a])
                } else {
                    l = Math.min(h, l);
                    c = Math.max(h, c)
                }
            }
            for (a = r; a <= s; a++) {
                var p;
                if (a < l) {
                    p = document.createElement(t.slideElement);
                    p.className = t.slideClass;
                    p.setAttribute("data-swiperindex", a);
                    p.innerHTML = e[a];
                    i.wrapper.insertBefore(p, i.wrapper.firstChild)
                }
                if (a > c) {
                    p = document.createElement(t.slideElement);
                    p.className = t.slideClass;
                    p.setAttribute("data-swiperindex", a);
                    p.innerHTML = e[a];
                    i.wrapper.appendChild(p)
                }
            }
        }
        i.reInit(true)
    };
    et()
};
Swiper.prototype = {plugins: {}, wrapperTransitionEnd: function (e, t) {
        "use strict";
        function o() {
            e(n);
            if (n.params.queueEndCallbacks)
                n._queueEndCallbacks = false;
            if (!t) {
                for (s = 0; s < i.length; s++) {
                    n.h.removeEventListener(r, i[s], o)
                }
            }
        }
        var n = this, r = n.wrapper, i = ["webkitTransitionEnd", "transitionend", "oTransitionEnd", "MSTransitionEnd", "msTransitionEnd"], s;
        if (e) {
            for (s = 0; s < i.length; s++) {
                n.h.addEventListener(r, i[s], o)
            }
        }
    }, getWrapperTranslate: function (e) {
        "use strict";
        var t = this.wrapper, n, r, i, s;
        if (typeof e === "undefined") {
            e = this.params.mode === "horizontal" ? "x" : "y"
        }
        if (this.support.transforms && this.params.useCSS3Transforms) {
            i = window.getComputedStyle(t, null);
            if (window.WebKitCSSMatrix) {
                s = new WebKitCSSMatrix(i.webkitTransform === "none" ? "" : i.webkitTransform)
            } else {
                s = i.MozTransform || i.OTransform || i.MsTransform || i.msTransform || i.transform || i.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,");
                n = s.toString().split(",")
            }
            if (e === "x") {
                if (window.WebKitCSSMatrix)
                    r = s.m41;
                else if (n.length === 16)
                    r = parseFloat(n[12]);
                else
                    r = parseFloat(n[4])
            }
            if (e === "y") {
                if (window.WebKitCSSMatrix)
                    r = s.m42;
                else if (n.length === 16)
                    r = parseFloat(n[13]);
                else
                    r = parseFloat(n[5])
            }
        } else {
            if (e === "x")
                r = parseFloat(t.style.left, 10) || 0;
            if (e === "y")
                r = parseFloat(t.style.top, 10) || 0
        }
        return r || 0
    }, setWrapperTranslate: function (e, t, n) {
        "use strict";
        var r = this.wrapper.style, i = {x: 0, y: 0, z: 0}, s;
        if (arguments.length === 3) {
            i.x = e;
            i.y = t;
            i.z = n
        } else {
            if (typeof t === "undefined") {
                t = this.params.mode === "horizontal" ? "x" : "y"
            }
            i[t] = e
        }
        if (this.support.transforms && this.params.useCSS3Transforms) {
            s = this.support.transforms3d ? "translate3d(" + i.x + "px, " + i.y + "px, " + i.z + "px)" : "translate(" + i.x + "px, " + i.y + "px)";
            r.webkitTransform = r.MsTransform = r.msTransform = r.MozTransform = r.OTransform = r.transform = s
        } else {
            r.left = i.x + "px";
            r.top = i.y + "px"
        }
        this.callPlugins("onSetWrapperTransform", i);
        if (this.params.onSetWrapperTransform)
            this.fireCallback(this.params.onSetWrapperTransform, this, i)
    }, setWrapperTransition: function (e) {
        "use strict";
        var t = this.wrapper.style;
        t.webkitTransitionDuration = t.MsTransitionDuration = t.msTransitionDuration = t.MozTransitionDuration = t.OTransitionDuration = t.transitionDuration = e / 1e3 + "s";
        this.callPlugins("onSetWrapperTransition", {duration: e});
        if (this.params.onSetWrapperTransition)
            this.fireCallback(this.params.onSetWrapperTransition, this, e)
    }, h: {getWidth: function (e, t, n) {
            "use strict";
            var r = window.getComputedStyle(e, null).getPropertyValue("width");
            var i = parseFloat(r);
            if (isNaN(i) || r.indexOf("%") > 0 || i < 0) {
                i = e.offsetWidth - parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-left")) - parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-right"))
            }
            if (t)
                i += parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-left")) + parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-right"));
            if (n)
                return Math.ceil(i);
            else
                return i
        }, getHeight: function (e, t, n) {
            "use strict";
            if (t)
                return e.offsetHeight;
            var r = window.getComputedStyle(e, null).getPropertyValue("height");
            var i = parseFloat(r);
            if (isNaN(i) || r.indexOf("%") > 0 || i < 0) {
                i = e.offsetHeight - parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-top")) - parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-bottom"))
            }
            if (t)
                i += parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-top")) + parseFloat(window.getComputedStyle(e, null).getPropertyValue("padding-bottom"));
            if (n)
                return Math.ceil(i);
            else
                return i
        }, getOffset: function (e) {
            "use strict";
            var t = e.getBoundingClientRect();
            var n = document.body;
            var r = e.clientTop || n.clientTop || 0;
            var i = e.clientLeft || n.clientLeft || 0;
            var s = window.pageYOffset || e.scrollTop;
            var o = window.pageXOffset || e.scrollLeft;
            if (document.documentElement && !window.pageYOffset) {
                s = document.documentElement.scrollTop;
                o = document.documentElement.scrollLeft
            }
            return{top: t.top + s - r, left: t.left + o - i}
        }, windowWidth: function () {
            "use strict";
            if (window.innerWidth)
                return window.innerWidth;
            else if (document.documentElement && document.documentElement.clientWidth)
                return document.documentElement.clientWidth
        }, windowHeight: function () {
            "use strict";
            if (window.innerHeight)
                return window.innerHeight;
            else if (document.documentElement && document.documentElement.clientHeight)
                return document.documentElement.clientHeight
        }, windowScroll: function () {
            "use strict";
            if (typeof pageYOffset !== "undefined") {
                return{left: window.pageXOffset, top: window.pageYOffset}
            } else if (document.documentElement) {
                return{left: document.documentElement.scrollLeft, top: document.documentElement.scrollTop}
            }
        }, addEventListener: function (e, t, n, r) {
            "use strict";
            if (typeof r === "undefined") {
                r = false
            }
            if (e.addEventListener) {
                e.addEventListener(t, n, r)
            } else if (e.attachEvent) {
                e.attachEvent("on" + t, n)
            }
        }, removeEventListener: function (e, t, n, r) {
            "use strict";
            if (typeof r === "undefined") {
                r = false
            }
            if (e.removeEventListener) {
                e.removeEventListener(t, n, r)
            } else if (e.detachEvent) {
                e.detachEvent("on" + t, n)
            }
        }}, setTransform: function (e, t) {
        "use strict";
        var n = e.style;
        n.webkitTransform = n.MsTransform = n.msTransform = n.MozTransform = n.OTransform = n.transform = t
    }, setTranslate: function (e, t) {
        "use strict";
        var n = e.style;
        var r = {x: t.x || 0, y: t.y || 0, z: t.z || 0};
        var i = this.support.transforms3d ? "translate3d(" + r.x + "px," + r.y + "px," + r.z + "px)" : "translate(" + r.x + "px," + r.y + "px)";
        n.webkitTransform = n.MsTransform = n.msTransform = n.MozTransform = n.OTransform = n.transform = i;
        if (!this.support.transforms) {
            n.left = r.x + "px";
            n.top = r.y + "px"
        }
    }, setTransition: function (e, t) {
        "use strict";
        var n = e.style;
        n.webkitTransitionDuration = n.MsTransitionDuration = n.msTransitionDuration = n.MozTransitionDuration = n.OTransitionDuration = n.transitionDuration = t + "ms"
    }, support: {touch: window.Modernizr && Modernizr.touch === true || function () {
            "use strict";
            return!!("ontouchstart"in window || window.DocumentTouch && document instanceof DocumentTouch)
        }(), transforms3d: window.Modernizr && Modernizr.csstransforms3d === true || function () {
            "use strict";
            var e = document.createElement("div").style;
            return"webkitPerspective"in e || "MozPerspective"in e || "OPerspective"in e || "MsPerspective"in e || "perspective"in e
        }(), transforms: window.Modernizr && Modernizr.csstransforms === true || function () {
            "use strict";
            var e = document.createElement("div").style;
            return"transform"in e || "WebkitTransform"in e || "MozTransform"in e || "msTransform"in e || "MsTransform"in e || "OTransform"in e
        }(), transitions: window.Modernizr && Modernizr.csstransitions === true || function () {
            "use strict";
            var e = document.createElement("div").style;
            return"transition"in e || "WebkitTransition"in e || "MozTransition"in e || "msTransition"in e || "MsTransition"in e || "OTransition"in e
        }(), classList: function () {
            "use strict";
            var e = document.createElement("div").style;
            return"classList"in e
        }()}, browser: {ie8: function () {
            "use strict";
            var e = -1;
            if (navigator.appName === "Microsoft Internet Explorer") {
                var t = navigator.userAgent;
                var n = new RegExp(/MSIE ([0-9]{1,}[\.0-9]{0,})/);
                if (n.exec(t) !== null)
                    e = parseFloat(RegExp.$1)
            }
            return e !== -1 && e < 9
        }(), ie10: window.navigator.msPointerEnabled, ie11: window.navigator.pointerEnabled}};
if (window.jQuery || window.Zepto) {
    (function (e) {
        "use strict";
        e.fn.swiper = function (t) {
            var n = new Swiper(e(this)[0], t);
            e(this).data("swiper", n);
            return n
        }
    })(window.jQuery || window.Zepto)
}
if (typeof module !== "undefined") {
    module.exports = Swiper
}
if (typeof define === "function" && define.amd) {
    define([], function () {
        "use strict";
        return Swiper
    })
}