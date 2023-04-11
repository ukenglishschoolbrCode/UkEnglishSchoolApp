!(function (e, t) {
    "object" == typeof exports && "object" == typeof module ? (module.exports = t()) : "function" == typeof define && define.amd ? define("party", [], t) : "object" == typeof exports ? (exports.party = t()) : (e.party = t());
})(self, function () {
    return (() => {
        "use strict";
        var e = {
                "./src/components/circle.ts": (e, t) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Circle = void 0);
                    var r = (function () {
                        function e(e, t, r) {
                            void 0 === r && (r = 0), (this.x = e), (this.y = t), (this.radius = r);
                        }
                        return (e.zero = new e(0, 0)), e;
                    })();
                    t.Circle = r;
                },
                "./src/components/color.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Color = void 0);
                    var i = r("./src/systems/math.ts"),
                        n = (function () {
                            function e(e, t, r) {
                                (this.values = new Float32Array(3)), (this.rgb = [e, t, r]);
                            }
                            return (
                                Object.defineProperty(e.prototype, "r", {
                                    get: function () {
                                        return this.values[0];
                                    },
                                    set: function (e) {
                                        this.values[0] = Math.floor(e);
                                    },
                                    enumerable: !1,
                                    configurable: !0,
                                }),
                                    Object.defineProperty(e.prototype, "g", {
                                        get: function () {
                                            return this.values[1];
                                        },
                                        set: function (e) {
                                            this.values[1] = Math.floor(e);
                                        },
                                        enumerable: !1,
                                        configurable: !0,
                                    }),
                                    Object.defineProperty(e.prototype, "b", {
                                        get: function () {
                                            return this.values[2];
                                        },
                                        set: function (e) {
                                            this.values[2] = Math.floor(e);
                                        },
                                        enumerable: !1,
                                        configurable: !0,
                                    }),
                                    Object.defineProperty(e.prototype, "rgb", {
                                        get: function () {
                                            return [this.r, this.g, this.b];
                                        },
                                        set: function (e) {
                                            (this.r = e[0]), (this.g = e[1]), (this.b = e[2]);
                                        },
                                        enumerable: !1,
                                        configurable: !0,
                                    }),
                                    (e.prototype.mix = function (t, r) {
                                        return void 0 === r && (r = 0.5), new e(i.lerp(this.r, t.r, r), i.lerp(this.g, t.g, r), i.lerp(this.b, t.b, r));
                                    }),
                                    (e.prototype.toHex = function () {
                                        var e = function (e) {
                                            return e.toString(16).padStart(2, "0");
                                        };
                                        return "#" + e(this.r) + e(this.g) + e(this.b);
                                    }),
                                    (e.prototype.toString = function () {
                                        return "rgb(" + this.values.join(", ") + ")";
                                    }),
                                    (e.fromHex = function (t) {
                                        return t.startsWith("#") && (t = t.substr(1)), new e(parseInt(t.substr(0, 2), 16), parseInt(t.substr(2, 2), 16), parseInt(t.substr(4, 2), 16));
                                    }),
                                    (e.fromHsl = function (t, r, i) {
                                        if (((t /= 360), (i /= 100), 0 === (r /= 100))) return new e(i, i, i);
                                        var n = function (e, t, r) {
                                                return r < 0 && (r += 1), r > 1 && (r -= 1), r < 1 / 6 ? e + 6 * (t - e) * r : r < 0.5 ? t : r < 2 / 3 ? e + (t - e) * (2 / 3 - r) * 6 : e;
                                            },
                                            o = function (e) {
                                                return Math.min(255, 256 * e);
                                            },
                                            s = i < 0.5 ? i * (1 + r) : i + r - i * r,
                                            a = 2 * i - s;
                                        return new e(o(n(a, s, t + 1 / 3)), o(n(a, s, t)), o(n(a, s, t - 1 / 3)));
                                    }),
                                    (e.white = new e(255, 255, 255)),
                                    (e.black = new e(0, 0, 0)),
                                    e
                            );
                        })();
                    t.Color = n;
                },
                "./src/components/gradient.ts": function (e, t, r) {
                    var i,
                        n =
                            (this && this.__extends) ||
                            ((i = function (e, t) {
                                return (i =
                                    Object.setPrototypeOf ||
                                    ({ __proto__: [] } instanceof Array &&
                                        function (e, t) {
                                            e.__proto__ = t;
                                        }) ||
                                    function (e, t) {
                                        for (var r in t) Object.prototype.hasOwnProperty.call(t, r) && (e[r] = t[r]);
                                    })(e, t);
                            }),
                                function (e, t) {
                                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");
                                    function r() {
                                        this.constructor = e;
                                    }
                                    i(e, t), (e.prototype = null === t ? Object.create(t) : ((r.prototype = t.prototype), new r()));
                                }),
                        o =
                            (this && this.__spreadArray) ||
                            function (e, t) {
                                for (var r = 0, i = t.length, n = e.length; r < i; r++, n++) e[n] = t[r];
                                return e;
                            };
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Gradient = void 0);
                    var s = (function (e) {
                        function t() {
                            return (null !== e && e.apply(this, arguments)) || this;
                        }
                        return (
                            n(t, e),
                                (t.prototype.interpolate = function (e, t, r) {
                                    return e.mix(t, r);
                                }),
                                (t.solid = function (e) {
                                    return new t({ value: e, time: 0.5 });
                                }),
                                (t.simple = function () {
                                    for (var e = [], r = 0; r < arguments.length; r++) e[r] = arguments[r];
                                    var i = 1 / (e.length - 1);
                                    return new (t.bind.apply(
                                        t,
                                        o(
                                            [void 0],
                                            e.map(function (e, t) {
                                                return { value: e, time: t * i };
                                            })
                                        )
                                    ))();
                                }),
                                t
                        );
                    })(r("./src/components/spline.ts").Spline);
                    t.Gradient = s;
                },
                "./src/components/index.ts": function (e, t, r) {
                    var i =
                            (this && this.__createBinding) ||
                            (Object.create
                                ? function (e, t, r, i) {
                                    void 0 === i && (i = r),
                                        Object.defineProperty(e, i, {
                                            enumerable: !0,
                                            get: function () {
                                                return t[r];
                                            },
                                        });
                                }
                                : function (e, t, r, i) {
                                    void 0 === i && (i = r), (e[i] = t[r]);
                                }),
                        n =
                            (this && this.__exportStar) ||
                            function (e, t) {
                                for (var r in e) "default" === r || Object.prototype.hasOwnProperty.call(t, r) || i(t, e, r);
                            };
                    Object.defineProperty(t, "__esModule", { value: !0 }),
                        n(r("./src/components/circle.ts"), t),
                        n(r("./src/components/color.ts"), t),
                        n(r("./src/components/gradient.ts"), t),
                        n(r("./src/components/numericSpline.ts"), t),
                        n(r("./src/components/rect.ts"), t),
                        n(r("./src/components/vector.ts"), t);
                },
                "./src/components/numericSpline.ts": function (e, t, r) {
                    var i,
                        n =
                            (this && this.__extends) ||
                            ((i = function (e, t) {
                                return (i =
                                    Object.setPrototypeOf ||
                                    ({ __proto__: [] } instanceof Array &&
                                        function (e, t) {
                                            e.__proto__ = t;
                                        }) ||
                                    function (e, t) {
                                        for (var r in t) Object.prototype.hasOwnProperty.call(t, r) && (e[r] = t[r]);
                                    })(e, t);
                            }),
                                function (e, t) {
                                    if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");
                                    function r() {
                                        this.constructor = e;
                                    }
                                    i(e, t), (e.prototype = null === t ? Object.create(t) : ((r.prototype = t.prototype), new r()));
                                });
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.NumericSpline = void 0);
                    var o = r("./src/systems/math.ts"),
                        s = (function (e) {
                            function t() {
                                return (null !== e && e.apply(this, arguments)) || this;
                            }
                            return (
                                n(t, e),
                                    (t.prototype.interpolate = function (e, t, r) {
                                        return o.slerp(e, t, r);
                                    }),
                                    t
                            );
                        })(r("./src/components/spline.ts").Spline);
                    t.NumericSpline = s;
                },
                "./src/components/rect.ts": (e, t) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Rect = void 0);
                    var r = (function () {
                        function e(e, t, r, i) {
                            void 0 === r && (r = 0), void 0 === i && (i = 0), (this.x = e), (this.y = t), (this.width = r), (this.height = i);
                        }
                        return (
                            (e.fromScreen = function () {
                                return new e(window.scrollX, window.scrollY, window.innerWidth, window.innerHeight);
                            }),
                                (e.fromElement = function (t) {
                                    var r = t.getBoundingClientRect();
                                    return new e(window.scrollX + r.x, window.scrollY + r.y, r.width, r.height);
                                }),
                                (e.zero = new e(0, 0)),
                                e
                        );
                    })();
                    t.Rect = r;
                },
                "./src/components/spline.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Spline = void 0);
                    var i = r("./src/systems/math.ts"),
                        n = (function () {
                            function e() {
                                for (var e = [], t = 0; t < arguments.length; t++) e[t] = arguments[t];
                                if (0 === e.length) throw new Error("Splines require at least one key.");
                                if (Array.isArray(e[0])) throw new Error("You are trying to pass an array to the spline constructor, which is not supported. Try to spread the array into the constructor instead.");
                                this.keys = e;
                            }
                            return (
                                (e.prototype.evaluate = function (e) {
                                    if (0 === this.keys.length) throw new Error("Attempt to evaluate a spline with no keys.");
                                    if (1 === this.keys.length) return this.keys[0].value;
                                    var t = this.keys.sort(function (e, t) {
                                            return e.time - t.time;
                                        }),
                                        r = t.findIndex(function (t) {
                                            return t.time > e;
                                        });
                                    if (0 === r) return t[0].value;
                                    if (-1 === r) return t[t.length - 1].value;
                                    var n = t[r - 1],
                                        o = t[r],
                                        s = i.invlerp(n.time, o.time, e);
                                    return this.interpolate(n.value, o.value, s);
                                }),
                                    e
                            );
                        })();
                    t.Spline = n;
                },
                "./src/components/vector.ts": function (e, t, r) {
                    var i =
                        (this && this.__spreadArray) ||
                        function (e, t) {
                            for (var r = 0, i = t.length, n = e.length; r < i; r++, n++) e[n] = t[r];
                            return e;
                        };
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Vector = void 0);
                    var n = r("./src/systems/math.ts"),
                        o = (function () {
                            function e(e, t, r) {
                                void 0 === e && (e = 0), void 0 === t && (t = 0), void 0 === r && (r = 0), (this.values = new Float32Array(3)), (this.xyz = [e, t, r]);
                            }
                            return (
                                Object.defineProperty(e.prototype, "x", {
                                    get: function () {
                                        return this.values[0];
                                    },
                                    set: function (e) {
                                        this.values[0] = e;
                                    },
                                    enumerable: !1,
                                    configurable: !0,
                                }),
                                    Object.defineProperty(e.prototype, "y", {
                                        get: function () {
                                            return this.values[1];
                                        },
                                        set: function (e) {
                                            this.values[1] = e;
                                        },
                                        enumerable: !1,
                                        configurable: !0,
                                    }),
                                    Object.defineProperty(e.prototype, "z", {
                                        get: function () {
                                            return this.values[2];
                                        },
                                        set: function (e) {
                                            this.values[2] = e;
                                        },
                                        enumerable: !1,
                                        configurable: !0,
                                    }),
                                    Object.defineProperty(e.prototype, "xyz", {
                                        get: function () {
                                            return [this.x, this.y, this.z];
                                        },
                                        set: function (e) {
                                            (this.values[0] = e[0]), (this.values[1] = e[1]), (this.values[2] = e[2]);
                                        },
                                        enumerable: !1,
                                        configurable: !0,
                                    }),
                                    (e.prototype.magnitude = function () {
                                        return Math.sqrt(this.sqrMagnitude());
                                    }),
                                    (e.prototype.sqrMagnitude = function () {
                                        return this.x * this.x + this.y * this.y + this.z * this.z;
                                    }),
                                    (e.prototype.add = function (t) {
                                        return new e(this.x + t.x, this.y + t.y, this.z + t.z);
                                    }),
                                    (e.prototype.subtract = function (t) {
                                        return new e(this.x - t.x, this.y - t.y, this.z - t.z);
                                    }),
                                    (e.prototype.scale = function (t) {
                                        return "number" == typeof t ? new e(this.x * t, this.y * t, this.z * t) : new e(this.x * t.x, this.y * t.y, this.z * t.z);
                                    }),
                                    (e.prototype.normalized = function () {
                                        var t = this.magnitude();
                                        return 0 !== t ? this.scale(1 / t) : new (e.bind.apply(e, i([void 0], this.xyz)))();
                                    }),
                                    (e.prototype.angle = function (e) {
                                        return n.rad2deg * Math.acos((this.x * e.x + this.y * e.y + this.z * e.z) / (this.magnitude() * e.magnitude()));
                                    }),
                                    (e.prototype.cross = function (t) {
                                        return new e(this.y * t.z - this.z * t.y, this.z * t.x - this.x * t.z, this.x * t.y - this.y * t.x);
                                    }),
                                    (e.prototype.dot = function (e) {
                                        return this.magnitude() * e.magnitude() * Math.cos(n.deg2rad * this.angle(e));
                                    }),
                                    (e.prototype.toString = function () {
                                        return "Vector(" + this.values.join(", ") + ")";
                                    }),
                                    (e.from2dAngle = function (t) {
                                        return new e(Math.cos(t * n.deg2rad), Math.sin(t * n.deg2rad));
                                    }),
                                    (e.zero = new e(0, 0, 0)),
                                    (e.one = new e(1, 1, 1)),
                                    (e.right = new e(1, 0, 0)),
                                    (e.up = new e(0, 1, 0)),
                                    (e.forward = new e(0, 0, 1)),
                                    e
                            );
                        })();
                    t.Vector = o;
                },
                "./src/containers.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.particleContainer = t.debugContainer = t.rootContainer = void 0);
                    var i = r("./src/settings.ts"),
                        n = r("./src/util/index.ts");
                    function o(e) {
                        return e && e.isConnected;
                    }
                    function s(e, t, r) {
                        var i = document.createElement("div");
                        return (i.id = "party-js-" + e), Object.assign(i.style, t), r.appendChild(i);
                    }
                    (t.rootContainer = new n.Lazy(function () {
                        return s("container", { position: "fixed", left: "0", top: "0", height: "100vh", width: "100vw", pointerEvents: "none", userSelect: "none", zIndex: i.settings.zIndex.toString() }, document.body);
                    }, o)),
                        (t.debugContainer = new n.Lazy(function () {
                            return s(
                                "debug",
                                { position: "absolute", top: "0", left: "0", margin: "0.5em", padding: "0.5em 1em", border: "2px solid rgb(0, 0, 0, 0.2)", background: "rgb(0, 0, 0, 0.1)", color: "#555", fontFamily: "monospace" },
                                t.rootContainer.current
                            );
                        }, o)),
                        (t.particleContainer = new n.Lazy(function () {
                            return s("particles", { width: "100%", height: "100%", overflow: "hidden", perspective: "1200px" }, t.rootContainer.current);
                        }, o));
                },
                "./src/debug.ts": function (e, t, r) {
                    var i =
                        (this && this.__spreadArray) ||
                        function (e, t) {
                            for (var r = 0, i = t.length, n = e.length; r < i; r++, n++) e[n] = t[r];
                            return e;
                        };
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Debug = void 0);
                    var n = r("./src/containers.ts"),
                        o = r("./src/settings.ts"),
                        s = (function () {
                            function e(e) {
                                (this.scene = e), (this.refreshRate = 8), (this.refreshTimer = 1 / this.refreshRate);
                            }
                            return (
                                (e.prototype.tick = function (e) {
                                    var t = n.debugContainer.current,
                                        r = o.settings.debug ? "block" : "none";
                                    t.style.display !== r && (t.style.display = r),
                                    o.settings.debug && ((this.refreshTimer += e), this.refreshTimer > 1 / this.refreshRate && ((this.refreshTimer = 0), (t.innerHTML = this.getDebugInformation(e).join("<br>"))));
                                }),
                                    (e.prototype.getDebugInformation = function (e) {
                                        var t = this.scene.emitters.length,
                                            r = this.scene.emitters.reduce(function (e, t) {
                                                return e + t.particles.length;
                                            }, 0),
                                            n = ["<b>party.js Debug</b>", "--------------", "FPS: " + Math.round(1 / e), "Emitters: " + t, "Particles: " + r],
                                            o = this.scene.emitters.map(function (e) {
                                                return [
                                                    "⭯: " + (e.currentLoop + 1) + "/" + (e.options.loops >= 0 ? e.options.loops : "∞"),
                                                    "Σp: " + e.particles.length,
                                                    e.isExpired ? "<i>expired</i>" : "Σt: " + e.durationTimer.toFixed(3) + "s",
                                                ].join(", ");
                                            });
                                        return n.push.apply(n, i(["--------------"], o)), n;
                                    }),
                                    e
                            );
                        })();
                    t.Debug = s;
                },
                "./src/index.ts": function (e, t, r) {
                    var i =
                            (this && this.__createBinding) ||
                            (Object.create
                                ? function (e, t, r, i) {
                                    void 0 === i && (i = r),
                                        Object.defineProperty(e, i, {
                                            enumerable: !0,
                                            get: function () {
                                                return t[r];
                                            },
                                        });
                                }
                                : function (e, t, r, i) {
                                    void 0 === i && (i = r), (e[i] = t[r]);
                                }),
                        n =
                            (this && this.__exportStar) ||
                            function (e, t) {
                                for (var r in e) "default" === r || Object.prototype.hasOwnProperty.call(t, r) || i(t, e, r);
                            };
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.default = t.forceInit = t.util = t.math = t.random = t.sources = t.variation = t.Emitter = t.Particle = t.settings = t.scene = void 0);
                    var o = r("./src/scene.ts"),
                        s = r("./src/util/index.ts");
                    n(r("./src/components/index.ts"), t),
                        n(r("./src/templates/index.ts"), t),
                        n(r("./src/systems/shapes.ts"), t),
                        n(r("./src/systems/modules.ts"), t),
                        (t.scene = new s.Lazy(function () {
                            if ("undefined" == typeof document || "undefined" == typeof window) throw new Error("It seems like you are trying to run party.js in a non-browser-like environment, which is not supported.");
                            return new o.Scene();
                        }));
                    var a = r("./src/settings.ts");
                    Object.defineProperty(t, "settings", {
                        enumerable: !0,
                        get: function () {
                            return a.settings;
                        },
                    });
                    var c = r("./src/particles/particle.ts");
                    Object.defineProperty(t, "Particle", {
                        enumerable: !0,
                        get: function () {
                            return c.Particle;
                        },
                    });
                    var u = r("./src/particles/emitter.ts");
                    Object.defineProperty(t, "Emitter", {
                        enumerable: !0,
                        get: function () {
                            return u.Emitter;
                        },
                    }),
                        (t.variation = r("./src/systems/variation.ts")),
                        (t.sources = r("./src/systems/sources.ts")),
                        (t.random = r("./src/systems/random.ts")),
                        (t.math = r("./src/systems/math.ts")),
                        (t.util = r("./src/util/index.ts")),
                        (t.forceInit = function () {
                            t.scene.current;
                        }),
                        (t.default = r("./src/index.ts"));
                },
                "./src/particles/emitter.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Emitter = void 0);
                    var i = r("./src/components/vector.ts"),
                        n = r("./src/settings.ts"),
                        o = r("./src/systems/variation.ts"),
                        s = r("./src/util/config.ts"),
                        a = r("./src/particles/options/index.ts"),
                        c = r("./src/particles/particle.ts"),
                        u = (function () {
                            function e(e) {
                                (this.particles = []),
                                    (this.currentLoop = 0),
                                    (this.durationTimer = 0),
                                    (this.emissionTimer = 0),
                                    (this.attemptedBurstIndices = []),
                                    (this.options = s.overrideDefaults(a.getDefaultEmitterOptions(), null == e ? void 0 : e.emitterOptions)),
                                    (this.emission = s.overrideDefaults(a.getDefaultEmissionOptions(), null == e ? void 0 : e.emissionOptions)),
                                    (this.renderer = s.overrideDefaults(a.getDefaultRendererOptions(), null == e ? void 0 : e.rendererOptions));
                            }
                            return (
                                Object.defineProperty(e.prototype, "isExpired", {
                                    get: function () {
                                        return this.options.loops >= 0 && this.currentLoop >= this.options.loops;
                                    },
                                    enumerable: !1,
                                    configurable: !0,
                                }),
                                    Object.defineProperty(e.prototype, "canRemove", {
                                        get: function () {
                                            return 0 === this.particles.length;
                                        },
                                        enumerable: !1,
                                        configurable: !0,
                                    }),
                                    (e.prototype.clearParticles = function () {
                                        return this.particles.splice(0).length;
                                    }),
                                    (e.prototype.tick = function (e) {
                                        if (!this.isExpired && ((this.durationTimer += e), this.durationTimer >= this.options.duration && (this.currentLoop++, (this.durationTimer = 0), (this.attemptedBurstIndices = [])), !this.isExpired)) {
                                            for (var t = 0, r = 0, i = this.emission.bursts; r < i.length; r++) {
                                                var n = i[r];
                                                if (n.time <= this.durationTimer && !this.attemptedBurstIndices.includes(t)) {
                                                    for (var s = o.evaluateVariation(n.count), a = 0; a < s; a++) this.emitParticle();
                                                    this.attemptedBurstIndices.push(t);
                                                }
                                                t++;
                                            }
                                            this.emissionTimer += e;
                                            for (var c = 1 / this.emission.rate; this.emissionTimer > c; ) (this.emissionTimer -= c), this.emitParticle();
                                        }
                                        var u = function (t) {
                                                var r = l.particles[t];
                                                l.tickParticle(r, e),
                                                l.options.despawningRules.some(function (e) {
                                                    return e(r);
                                                }) && l.particles.splice(t, 1);
                                            },
                                            l = this;
                                        for (a = this.particles.length - 1; a >= 0; a--) u(a);
                                    }),
                                    (e.prototype.tickParticle = function (e, t) {
                                        (e.lifetime -= t), this.options.useGravity && (e.velocity = e.velocity.add(i.Vector.up.scale(n.settings.gravity * t))), (e.location = e.location.add(e.velocity.scale(t)));
                                        for (var r = 0, o = this.options.modules; r < o.length; r++) {
                                            (0, o[r])(e);
                                        }
                                    }),
                                    (e.prototype.emitParticle = function () {
                                        var e = new c.Particle({
                                            location: this.emission.sourceSampler(),
                                            lifetime: o.evaluateVariation(this.emission.initialLifetime),
                                            velocity: i.Vector.from2dAngle(o.evaluateVariation(this.emission.angle)).scale(o.evaluateVariation(this.emission.initialSpeed)),
                                            size: o.evaluateVariation(this.emission.initialSize),
                                            rotation: o.evaluateVariation(this.emission.initialRotation),
                                            color: o.evaluateVariation(this.emission.initialColor),
                                        });
                                        return this.particles.push(e), this.particles.length > this.options.maxParticles && this.particles.shift(), e;
                                    }),
                                    e
                            );
                        })();
                    t.Emitter = u;
                },
                "./src/particles/options/emissionOptions.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.getDefaultEmissionOptions = void 0);
                    var i = r("./src/components/index.ts"),
                        n = r("./src/systems/sources.ts");
                    t.getDefaultEmissionOptions = function () {
                        return { rate: 10, angle: 0, bursts: [], sourceSampler: n.rectSource(i.Rect.zero), initialLifetime: 5, initialSpeed: 5, initialSize: 1, initialRotation: i.Vector.zero, initialColor: i.Color.white };
                    };
                },
                "./src/particles/options/emitterOptions.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.getDefaultEmitterOptions = void 0);
                    var i = r("./src/util/rules.ts");
                    t.getDefaultEmitterOptions = function () {
                        return { duration: 5, loops: 1, useGravity: !0, maxParticles: 300, despawningRules: [i.despawningRules.lifetime, i.despawningRules.bounds], modules: [] };
                    };
                },
                "./src/particles/options/index.ts": function (e, t, r) {
                    var i =
                            (this && this.__createBinding) ||
                            (Object.create
                                ? function (e, t, r, i) {
                                    void 0 === i && (i = r),
                                        Object.defineProperty(e, i, {
                                            enumerable: !0,
                                            get: function () {
                                                return t[r];
                                            },
                                        });
                                }
                                : function (e, t, r, i) {
                                    void 0 === i && (i = r), (e[i] = t[r]);
                                }),
                        n =
                            (this && this.__exportStar) ||
                            function (e, t) {
                                for (var r in e) "default" === r || Object.prototype.hasOwnProperty.call(t, r) || i(t, e, r);
                            };
                    Object.defineProperty(t, "__esModule", { value: !0 }), n(r("./src/particles/options/emitterOptions.ts"), t), n(r("./src/particles/options/emissionOptions.ts"), t), n(r("./src/particles/options/renderOptions.ts"), t);
                },
                "./src/particles/options/renderOptions.ts": (e, t) => {
                    function r(e, t) {
                        var r = e.toHex();
                        switch (t.nodeName.toLowerCase()) {
                            case "div":
                                t.style.background = r;
                                break;
                            case "svg":
                                t.style.fill = t.style.color = r;
                                break;
                            default:
                                t.style.color = r;
                        }
                    }
                    function i(e, t) {
                        t.style.opacity = e.toString();
                    }
                    function n(e, t) {
                        t.style.filter = "brightness(" + (0.5 + Math.abs(e)) + ")";
                    }
                    function o(e, t) {
                        t.style.transform =
                            "translateX(" +
                            (e.location.x - window.scrollX).toFixed(3) +
                            "px) translateY(" +
                            (e.location.y - window.scrollY).toFixed(3) +
                            "px) translateZ(" +
                            e.location.z.toFixed(3) +
                            "px) rotateX(" +
                            e.rotation.x.toFixed(3) +
                            "deg) rotateY(" +
                            e.rotation.y.toFixed(3) +
                            "deg) rotateZ(" +
                            e.rotation.z.toFixed(3) +
                            "deg) scale(" +
                            e.size.toFixed(3) +
                            ")";
                    }
                    Object.defineProperty(t, "__esModule", { value: !0 }),
                        (t.getDefaultRendererOptions = void 0),
                        (t.getDefaultRendererOptions = function () {
                            return { shapeFactory: "square", applyColor: r, applyOpacity: i, applyLighting: n, applyTransform: o };
                        });
                },
                "./src/particles/particle.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Particle = void 0);
                    var i = r("./src/components/index.ts"),
                        n = r("./src/util/config.ts"),
                        o = function (e) {
                            var t = n.overrideDefaults({ lifetime: 0, size: 1, location: i.Vector.zero, rotation: i.Vector.zero, velocity: i.Vector.zero, color: i.Color.white, opacity: 1 }, e);
                            (this.id = Symbol()),
                                (this.size = this.initialSize = t.size),
                                (this.lifetime = this.initialLifetime = t.lifetime),
                                (this.rotation = this.initialRotation = t.rotation),
                                (this.location = t.location),
                                (this.velocity = t.velocity),
                                (this.color = t.color),
                                (this.opacity = t.opacity);
                        };
                    t.Particle = o;
                },
                "./src/particles/renderer.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Renderer = void 0);
                    var i = r("./src/index.ts"),
                        n = r("./src/components/vector.ts"),
                        o = r("./src/containers.ts"),
                        s = r("./src/systems/shapes.ts"),
                        a = r("./src/util/index.ts"),
                        c = (function () {
                            function e() {
                                (this.elements = new Map()), (this.light = new n.Vector(0, 0, 1)), (this.enabled = !0), (this.enabled = !i.settings.respectReducedMotion || !window.matchMedia("(prefers-reduced-motion)").matches);
                            }
                            return (
                                (e.prototype.begin = function () {
                                    this.renderedParticles = [];
                                }),
                                    (e.prototype.end = function () {
                                        for (var e = this.elements.keys(), t = e.next(); !t.done; ) {
                                            var r = t.value;
                                            this.renderedParticles.includes(r) || (this.elements.get(r).remove(), this.elements.delete(r)), (t = e.next());
                                        }
                                        return this.renderedParticles.length;
                                    }),
                                    (e.prototype.renderParticle = function (e, t) {
                                        if (this.enabled) {
                                            var r = t.renderer,
                                                i = this.elements.has(e.id) ? this.elements.get(e.id) : this.createParticleElement(e, r);
                                            if ((r.applyColor && r.applyColor(e.color, i), r.applyOpacity && r.applyOpacity(e.opacity, i), r.applyLighting)) {
                                                var n = a.rotationToNormal(e.rotation).dot(this.light);
                                                r.applyLighting(n, i);
                                            }
                                            r.applyTransform && r.applyTransform(e, i), this.renderedParticles.push(e.id);
                                        }
                                    }),
                                    (e.prototype.createParticleElement = function (e, t) {
                                        var r = s.resolveShapeFactory(t.shapeFactory).cloneNode(!0);
                                        return (r.style.position = "absolute"), this.elements.set(e.id, o.particleContainer.current.appendChild(r)), r;
                                    }),
                                    e
                            );
                        })();
                    t.Renderer = c;
                },
                "./src/scene.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Scene = void 0);
                    var i = r("./src/debug.ts"),
                        n = r("./src/particles/emitter.ts"),
                        o = r("./src/particles/renderer.ts"),
                        s = (function () {
                            function e() {
                                (this.emitters = []),
                                    (this.debug = new i.Debug(this)),
                                    (this.renderer = new o.Renderer()),
                                    (this.scheduledTickId = void 0),
                                    (this.lastTickTimestamp = performance.now()),
                                    (this.tick = this.tick.bind(this)),
                                    this.scheduleTick();
                            }
                            return (
                                (e.prototype.createEmitter = function (e) {
                                    var t = new n.Emitter(e);
                                    return this.emitters.push(t), t;
                                }),
                                    (e.prototype.clearEmitters = function () {
                                        return this.emitters.splice(0).length;
                                    }),
                                    (e.prototype.clearParticles = function () {
                                        return this.emitters.reduce(function (e, t) {
                                            return e + t.clearParticles();
                                        }, 0);
                                    }),
                                    (e.prototype.scheduleTick = function () {
                                        this.scheduledTickId = window.requestAnimationFrame(this.tick);
                                    }),
                                    (e.prototype.cancelTick = function () {
                                        window.cancelAnimationFrame(this.scheduledTickId);
                                    }),
                                    (e.prototype.tick = function (e) {
                                        var t = (e - this.lastTickTimestamp) / 1e3;
                                        try {
                                            for (var r = 0; r < this.emitters.length; r++) {
                                                (o = this.emitters[r]).tick(t), o.isExpired && o.canRemove && this.emitters.splice(r--, 1);
                                            }
                                        } catch (e) {
                                            console.error("An error occurred while updating the scene's emitters:\n\"" + e + '"');
                                        }
                                        try {
                                            this.renderer.begin();
                                            for (var i = 0, n = this.emitters; i < n.length; i++)
                                                for (var o = n[i], s = 0, a = o.particles; s < a.length; s++) {
                                                    var c = a[s];
                                                    this.renderer.renderParticle(c, o);
                                                }
                                            this.renderer.end();
                                        } catch (e) {
                                            console.error("An error occurred while rendering the scene's particles:\n\"" + e + '"');
                                        }
                                        this.debug.tick(t), (this.lastTickTimestamp = e), this.scheduleTick();
                                    }),
                                    e
                            );
                        })();
                    t.Scene = s;
                },
                "./src/settings.ts": (e, t) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.settings = void 0), (t.settings = { debug: !1, gravity: 800, zIndex: 99999, respectReducedMotion: !0 });
                },
                "./src/systems/math.ts": (e, t) => {
                    function r(e, t, r) {
                        return (1 - r) * e + r * t;
                    }
                    Object.defineProperty(t, "__esModule", { value: !0 }),
                        (t.approximately = t.clamp = t.invlerp = t.slerp = t.lerp = t.epsilon = t.rad2deg = t.deg2rad = void 0),
                        (t.deg2rad = Math.PI / 180),
                        (t.rad2deg = 180 / Math.PI),
                        (t.epsilon = 1e-6),
                        (t.lerp = r),
                        (t.slerp = function (e, t, i) {
                            return r(e, t, (1 - Math.cos(i * Math.PI)) / 2);
                        }),
                        (t.invlerp = function (e, t, r) {
                            return (r - e) / (t - e);
                        }),
                        (t.clamp = function (e, t, r) {
                            return Math.min(r, Math.max(t, e));
                        }),
                        (t.approximately = function (e, r) {
                            return Math.abs(e - r) < t.epsilon;
                        });
                },
                "./src/systems/modules.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.ModuleBuilder = void 0);
                    var i = r("./src/components/index.ts"),
                        n = (function () {
                            function e() {
                                (this.factor = "lifetime"), (this.isRelative = !1);
                            }
                            return (
                                (e.prototype.drive = function (e) {
                                    return (this.driverKey = e), this;
                                }),
                                    (e.prototype.through = function (e) {
                                        return (this.factor = e), this;
                                    }),
                                    (e.prototype.by = function (e) {
                                        return (this.driverValue = e), this;
                                    }),
                                    (e.prototype.relative = function (e) {
                                        return void 0 === e && (e = !0), (this.isRelative = e), this;
                                    }),
                                    (e.prototype.build = function () {
                                        var e = this;
                                        if (void 0 === this.driverKey) throw new Error("No driving key was provided in the module builder. Did you forget a '.drive()' call?");
                                        if (void 0 === this.driverValue) throw new Error("No driving value was provided in the module builder. Did you forget a '.through()' call?");
                                        return function (t) {
                                            o(
                                                t,
                                                e.driverKey,
                                                (function (e, t, r) {
                                                    if ("object" == typeof e && "evaluate" in e) return e.evaluate(t);
                                                    if ("function" == typeof e) return e(t, r);
                                                    return e;
                                                })(
                                                    e.driverValue,
                                                    (function (e, t) {
                                                        switch (e) {
                                                            case "lifetime":
                                                                return t.initialLifetime - t.lifetime;
                                                            case "relativeLifetime":
                                                                return (t.initialLifetime - t.lifetime) / t.initialLifetime;
                                                            case "size":
                                                                return t.size;
                                                            default:
                                                                throw new Error("Invalid driving factor '" + e + "'.");
                                                        }
                                                    })(e.factor, t),
                                                    t
                                                ),
                                                e.isRelative
                                            );
                                        };
                                    }),
                                    e
                            );
                        })();
                    function o(e, t, r, n) {
                        if ((void 0 === n && (n = !1), n)) {
                            var s = e["initial" + t[0].toUpperCase() + t.substr(1)];
                            if (void 0 === s) throw new Error("Unable to use relative chaining with key '" + t + "'; no initial value exists.");
                            if (r instanceof i.Vector) o(e, t, s.add(r));
                            else {
                                if ("number" != typeof r) throw new Error("Unable to use relative chaining with particle key '" + t + "'; no relative operation for '" + r + "' could be inferred.");
                                o(e, t, s * r);
                            }
                        } else e[t] = r;
                    }
                    t.ModuleBuilder = n;
                },
                "./src/systems/random.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.randomInsideCircle = t.randomInsideRect = t.randomUnitVector = t.pick = t.randomRange = void 0);
                    var i = r("./src/components/index.ts"),
                        n = r("./src/systems/math.ts");
                    function o(e, t) {
                        return void 0 === e && (e = 0), void 0 === t && (t = 1), n.lerp(e, t, Math.random());
                    }
                    (t.randomRange = o),
                        (t.pick = function (e) {
                            return 0 === e.length ? void 0 : e[Math.floor(Math.random() * e.length)];
                        }),
                        (t.randomUnitVector = function () {
                            var e = o(0, 2 * Math.PI),
                                t = o(-1, 1);
                            return new i.Vector(Math.sqrt(1 - t * t) * Math.cos(e), Math.sqrt(1 - t * t) * Math.sin(e), t);
                        }),
                        (t.randomInsideRect = function (e) {
                            return new i.Vector(e.x + o(0, e.width), e.y + o(0, e.height));
                        }),
                        (t.randomInsideCircle = function (e) {
                            var t = o(0, 2 * Math.PI),
                                r = o(0, e.radius);
                            return new i.Vector(e.x + Math.cos(t) * r, e.y + Math.sin(t) * r);
                        });
                },
                "./src/systems/shapes.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.resolveShapeFactory = t.resolvableShapes = void 0);
                    var i = r("./src/systems/variation.ts");
                    (t.resolvableShapes = {
                        square: '<div style="height: 10px; width: 10px;"></div>',
                        rectangle: '<div style="height: 6px; width: 10px;"></div>',
                        circle: '<svg viewBox="0 0 2 2" width="10" height="10"><circle cx="1" cy="1" r="1" fill="currentColor"/></svg>',
                        roundedSquare: '<div style="height: 10px; width: 10px; border-radius: 3px;"></div>',
                        roundedRectangle: '<div style="height: 6px; width: 10px; border-radius: 3px;"></div>',
                        star:
                            '<svg viewBox="0 0 512 512" width="15" height="15"><polygon fill="currentColor" points="512,197.816 325.961,185.585 255.898,9.569 185.835,185.585 0,197.816 142.534,318.842 95.762,502.431 255.898,401.21 416.035,502.431 369.263,318.842"/></svg>',
                    }),
                        (t.resolveShapeFactory = function (e) {
                            var r = i.evaluateVariation(e);
                            if ("string" == typeof r) {
                                var n = t.resolvableShapes[r];
                                if (!n) throw new Error("Failed to resolve shape key '" + r + "'. Did you forget to add it to the 'resolvableShapes' lookup?");
                                var o = document.createElement("div");
                                return (o.innerHTML = n), o.firstElementChild;
                            }
                            return r;
                        });
                },
                "./src/systems/sources.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.circleSource = t.rectSource = t.mouseSource = t.elementSource = t.dynamicSource = void 0);
                    var i = r("./src/components/index.ts"),
                        n = r("./src/systems/random.ts");
                    function o(e) {
                        return function () {
                            return n.randomInsideRect(i.Rect.fromElement(e));
                        };
                    }
                    function s(e) {
                        return function () {
                            return new i.Vector(window.scrollX + e.clientX, window.scrollY + e.clientY);
                        };
                    }
                    function a(e) {
                        return function () {
                            return n.randomInsideRect(e);
                        };
                    }
                    function c(e) {
                        return function () {
                            return n.randomInsideCircle(e);
                        };
                    }
                    (t.dynamicSource = function (e) {
                        if (e instanceof HTMLElement) return o(e);
                        if (e instanceof i.Circle) return c(e);
                        if (e instanceof i.Rect) return a(e);
                        if (e instanceof MouseEvent) return s(e);
                        throw new Error("Cannot infer the source type of '" + e + "'.");
                    }),
                        (t.elementSource = o),
                        (t.mouseSource = s),
                        (t.rectSource = a),
                        (t.circleSource = c);
                },
                "./src/systems/variation.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.gradientSample = t.splineSample = t.skewRelative = t.skew = t.range = t.evaluateVariation = void 0);
                    var i = r("./src/systems/random.ts");
                    function n(e) {
                        return function () {
                            return e.evaluate(Math.random());
                        };
                    }
                    (t.evaluateVariation = function (e) {
                        return Array.isArray(e) ? i.pick(e) : "function" == typeof e ? e() : e;
                    }),
                        (t.range = function (e, t) {
                            return function () {
                                return i.randomRange(e, t);
                            };
                        }),
                        (t.skew = function (e, t) {
                            return function () {
                                return e + i.randomRange(-t, t);
                            };
                        }),
                        (t.skewRelative = function (e, t) {
                            return function () {
                                return e * (1 + i.randomRange(-t, t));
                            };
                        }),
                        (t.splineSample = n),
                        (t.gradientSample = function (e) {
                            return n(e);
                        });
                },
                "./src/templates/confetti.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.confetti = void 0);
                    var i = r("./src/index.ts"),
                        n = r("./src/components/index.ts"),
                        o = r("./src/systems/modules.ts"),
                        s = r("./src/systems/random.ts"),
                        a = r("./src/systems/sources.ts"),
                        c = r("./src/systems/variation.ts"),
                        u = r("./src/util/index.ts");
                    t.confetti = function (e, t) {
                        var r = u.overrideDefaults(
                            {
                                count: c.range(20, 40),
                                spread: c.range(35, 45),
                                speed: c.range(300, 600),
                                size: c.skew(1, 0.2),
                                rotation: function () {
                                    return s.randomUnitVector().scale(180);
                                },
                                color: function () {
                                    return n.Color.fromHsl(s.randomRange(0, 360), 100, 70);
                                },
                                modules: [
                                    new o.ModuleBuilder()
                                        .drive("size")
                                        .by(function (e) {
                                            return Math.min(1, 3 * e);
                                        })
                                        .relative()
                                        .build(),
                                    new o.ModuleBuilder()
                                        .drive("rotation")
                                        .by(function (e) {
                                            return new n.Vector(140, 200, 260).scale(e);
                                        })
                                        .relative()
                                        .build(),
                                ],
                                shapes: ["square", "circle"],
                            },
                            t
                        );
                        return i.scene.current.createEmitter({
                            emitterOptions: { loops: 1, duration: 8, modules: r.modules },
                            emissionOptions: {
                                rate: 0,
                                bursts: [{ time: 0, count: r.count }],
                                sourceSampler: a.dynamicSource(e),
                                angle: c.skew(-90, c.evaluateVariation(r.spread)),
                                initialLifetime: 8,
                                initialSpeed: r.speed,
                                initialSize: r.size,
                                initialRotation: r.rotation,
                                initialColor: r.color,
                            },
                            rendererOptions: { shapeFactory: r.shapes },
                        });
                    };
                },
                "./src/templates/index.ts": function (e, t, r) {
                    var i =
                            (this && this.__createBinding) ||
                            (Object.create
                                ? function (e, t, r, i) {
                                    void 0 === i && (i = r),
                                        Object.defineProperty(e, i, {
                                            enumerable: !0,
                                            get: function () {
                                                return t[r];
                                            },
                                        });
                                }
                                : function (e, t, r, i) {
                                    void 0 === i && (i = r), (e[i] = t[r]);
                                }),
                        n =
                            (this && this.__exportStar) ||
                            function (e, t) {
                                for (var r in e) "default" === r || Object.prototype.hasOwnProperty.call(t, r) || i(t, e, r);
                            };
                    Object.defineProperty(t, "__esModule", { value: !0 }), n(r("./src/templates/confetti.ts"), t), n(r("./src/templates/sparkles.ts"), t);
                },
                "./src/templates/sparkles.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.sparkles = void 0);
                    var i = r("./src/index.ts"),
                        n = r("./src/components/index.ts"),
                        o = r("./src/systems/modules.ts"),
                        s = r("./src/systems/random.ts"),
                        a = r("./src/systems/sources.ts"),
                        c = r("./src/systems/variation.ts"),
                        u = r("./src/util/index.ts");
                    t.sparkles = function (e, t) {
                        var r = u.overrideDefaults(
                            {
                                lifetime: c.range(1, 2),
                                count: c.range(10, 20),
                                speed: c.range(100, 200),
                                size: c.range(0.8, 1.8),
                                shapes: ["star"],
                                rotation: function () {
                                    return new n.Vector(0, 0, s.randomRange(0, 360));
                                },
                                color: function () {
                                    return n.Color.fromHsl(50, 100, s.randomRange(55, 85));
                                },
                                modules: [
                                    new o.ModuleBuilder()
                                        .drive("rotation")
                                        .by(function (e) {
                                            return new n.Vector(0, 0, 200).scale(e);
                                        })
                                        .relative()
                                        .build(),
                                    new o.ModuleBuilder()
                                        .drive("size")
                                        .by(new n.NumericSpline({ time: 0, value: 0 }, { time: 0.3, value: 1 }, { time: 0.7, value: 1 }, { time: 1, value: 0 }))
                                        .through("relativeLifetime")
                                        .relative()
                                        .build(),
                                    new o.ModuleBuilder()
                                        .drive("opacity")
                                        .by(new n.NumericSpline({ time: 0, value: 1 }, { time: 0.5, value: 1 }, { time: 1, value: 0 }))
                                        .through("relativeLifetime")
                                        .build(),
                                ],
                            },
                            t
                        );
                        return i.scene.current.createEmitter({
                            emitterOptions: { loops: 1, duration: 3, useGravity: !1, modules: r.modules },
                            emissionOptions: {
                                rate: 0,
                                bursts: [{ time: 0, count: r.count }],
                                sourceSampler: a.dynamicSource(e),
                                angle: c.range(0, 360),
                                initialLifetime: r.lifetime,
                                initialSpeed: r.speed,
                                initialSize: r.size,
                                initialRotation: r.rotation,
                                initialColor: r.color,
                            },
                            rendererOptions: { applyLighting: void 0, shapeFactory: r.shapes },
                        });
                    };
                },
                "./src/util/config.ts": (e, t) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }),
                        (t.overrideDefaults = void 0),
                        (t.overrideDefaults = function (e, t) {
                            return Object.assign({}, e, t);
                        });
                },
                "./src/util/index.ts": function (e, t, r) {
                    var i =
                            (this && this.__createBinding) ||
                            (Object.create
                                ? function (e, t, r, i) {
                                    void 0 === i && (i = r),
                                        Object.defineProperty(e, i, {
                                            enumerable: !0,
                                            get: function () {
                                                return t[r];
                                            },
                                        });
                                }
                                : function (e, t, r, i) {
                                    void 0 === i && (i = r), (e[i] = t[r]);
                                }),
                        n =
                            (this && this.__exportStar) ||
                            function (e, t) {
                                for (var r in e) "default" === r || Object.prototype.hasOwnProperty.call(t, r) || i(t, e, r);
                            };
                    Object.defineProperty(t, "__esModule", { value: !0 }), n(r("./src/util/config.ts"), t), n(r("./src/util/rotation.ts"), t), n(r("./src/util/rules.ts"), t), n(r("./src/util/lazy.ts"), t);
                },
                "./src/util/lazy.ts": (e, t) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.Lazy = void 0);
                    var r = (function () {
                        function e(t, r) {
                            void 0 === r && (r = e.defaultExists), (this.factory = t), (this.exists = r);
                        }
                        return (
                            Object.defineProperty(e.prototype, "current", {
                                get: function () {
                                    return this.exists(this.value) || (this.value = this.factory()), this.value;
                                },
                                enumerable: !1,
                                configurable: !0,
                            }),
                                (e.defaultExists = function (e) {
                                    return void 0 !== e;
                                }),
                                e
                        );
                    })();
                    t.Lazy = r;
                },
                "./src/util/rotation.ts": (e, t, r) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }), (t.rotationToNormal = void 0);
                    var i = r("./src/components/index.ts"),
                        n = r("./src/systems/math.ts");
                    t.rotationToNormal = function (e) {
                        var t = e.x * n.deg2rad,
                            r = e.y * n.deg2rad,
                            o = new i.Vector(Math.cos(r), 0, Math.sin(r)),
                            s = new i.Vector(0, Math.cos(t), Math.sin(t));
                        return o.cross(s);
                    };
                },
                "./src/util/rules.ts": (e, t) => {
                    Object.defineProperty(t, "__esModule", { value: !0 }),
                        (t.despawningRules = void 0),
                        (t.despawningRules = {
                            lifetime: function (e) {
                                return e.lifetime <= 0;
                            },
                            bounds: function (e) {
                                var t = document.documentElement.scrollHeight;
                                return e.location.y > t;
                            },
                        });
                },
            },
            t = {};
        var r = (function r(i) {
            var n = t[i];
            if (void 0 !== n) return n.exports;
            var o = (t[i] = { exports: {} });
            return e[i].call(o.exports, o, o.exports, r), o.exports;
        })("./src/index.ts");
        return (r = r.default);
    })();
});