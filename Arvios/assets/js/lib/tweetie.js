! function(e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : e(jQuery)
}(function(e) {
    e.fn.tweet = function(t) {
        function r(e, t) {
            if ("string" == typeof e) {
                var r = e;
                for (var a in t) {
                    var n = t[a];
                    r = r.replace(new RegExp("{" + a + "}", "g"), null === n ? "" : n)
                }
                return r
            }
            return e(t)
        }

        function a(t, r) {
            return function() {
                var a = [];
                return this.each(function() {
                    a.push(this.replace(t, r))
                }), e(a)
            }
        }

        function n(e) {
            return e.replace(/</g, "<").replace(/>/g, "^>")
        }

        function i(e, t) {
            return e.replace(p, function(e) {
                for (var r = /^[a-z]+:/i.test(e) ? e : "http://" + e, a = e, i = 0; i < t.length; ++i) {
                    var s = t[i];
                    if (s.url == r && s.expanded_url) {
                        r = s.expanded_url, a = s.display_url;
                        break
                    }
                }
                return '<a href="' + n(r) + '">' + n(a) + "</a>"
            })
        }

        function s(e) {
            return Date.parse(e.replace(/^([a-z]{3})( [a-z]{3} \d\d?)(.*)( \d{4})$/i, "$1,$2$4$3"))
        }

        function u(e) {
            var t = arguments.length > 1 ? arguments[1] : new Date,
                r = parseInt((t.getTime() - e) / 1e3, 10),
                a = "";
            return a = 1 > r ? "just now" : 60 > r ? r + " seconds ago" : 120 > r ? "about a minute ago" : 2700 > r ? "about " + parseInt(r / 60, 10).toString() + " minutes ago" : 7200 > r ? "about an hour ago" : 86400 > r ? "about " + parseInt(r / 3600, 10).toString() + " hours ago" : 172800 > r ? "about a day ago" : "about " + parseInt(r / 86400, 10).toString() + " days ago"
        }

        function o(e) {
            return e.match(/^(@([A-Za-z0-9-_]+)) .*/i) ? w.auto_join_text_reply : e.match(p) ? w.auto_join_text_url : e.match(/^((\w+ed)|just) .*/im) ? w.auto_join_text_ed : e.match(/^(\w*ing) .*/i) ? w.auto_join_text_ing : w.auto_join_text_default
        }

        function _() {
            var t = (w.modpath, null === w.fetch ? w.count : w.fetch),
                r = {
                    include_entities: 1
                };
            if (w.list) return {
                host: w.twitter_api_url,
                url: "/1.1/lists/statuses.json",
                parameters: e.extend({}, r, {
                    list_id: w.list_id,
                    slug: w.list,
                    owner_screen_name: w.username,
                    page: w.page,
                    count: t,
                    include_rts: w.retweets ? 1 : 0
                })
            };
            if (w.favorites) return {
                host: w.twitter_api_url,
                url: "/1.1/favorites/list.json",
                parameters: e.extend({}, r, {
                    list_id: w.list_id,
                    screen_name: w.username,
                    page: w.page,
                    count: t
                })
            };
            if (null === w.query && 1 === w.username.length) return {
                host: w.twitter_api_url,
                url: "/1.1/statuses/user_timeline.json",
                parameters: e.extend({}, r, {
                    screen_name: w.username,
                    page: w.page,
                    count: t,
                    include_rts: w.retweets ? 1 : 0
                })
            };
            var a = w.query || "from:" + w.username.join(" OR from:");
            return {
                host: w.twitter_search_url,
                url: "/search.json",
                parameters: e.extend({}, r, {
                    page: w.page,
                    q: a,
                    rpp: t
                })
            }
        }

        function l(e, t) {
            return t ? "user" in e ? e.user.profile_image_url_https : l(e, !1).replace(/^http:\/\/[a-z0-9]{1,3}\.twimg\.com\//, "https://s3.amazonaws.com/twitter_production/") : e.profile_image_url || e.user.profile_image_url
        }

        function c(t) {
            var a = {};
            return a.item = t, a.source = t.source, a.name = t.from_user_name || t.user.name, a.screen_name = t.from_user || t.user.screen_name, a.avatar_size = w.avatar_size, a.avatar_url = l(t, "https:" === document.location.protocol), a.retweet = "undefined" != typeof t.retweeted_status, a.tweet_time = s(t.created_at), a.join_text = "auto" == w.join_text ? o(t.text) : w.join_text, a.tweet_id = t.id_str, a.twitter_base = "http://" + w.twitter_url + "/", a.user_url = a.twitter_base + a.screen_name, a.tweet_url = a.user_url + "/status/" + a.tweet_id, a.reply_url = a.twitter_base + "intent/tweet?in_reply_to=" + a.tweet_id, a.retweet_url = a.twitter_base + "intent/retweet?tweet_id=" + a.tweet_id, a.favorite_url = a.twitter_base + "intent/favorite?tweet_id=" + a.tweet_id, a.retweeted_screen_name = a.retweet && t.retweeted_status.user.screen_name, a.tweet_relative_time = u(a.tweet_time), a.entities = t.entities ? (t.entities.urls || []).concat(t.entities.media || []) : [], a.tweet_raw_text = a.retweet ? "RT @" + a.retweeted_screen_name + " " + t.retweeted_status.text : t.text, a.tweet_text = e([i(a.tweet_raw_text, a.entities)]).linkUser().linkHash()[0], a.tweet_text_fancy = e([a.tweet_text]).makeHeart()[0], a.user = r('<a class="tweet_user" href="{user_url}">{screen_name}</a>', a), a.join = w.join_text ? r(' <span class="tweet_join">{join_text}</span> ', a) : " ", a.avatar = a.avatar_size ? r('<a class="tweet_avatar" href="{user_url}"><img src="{avatar_url}" height="{avatar_size}" width="{avatar_size}" alt="{screen_name}\'s avatar" title="{screen_name}\'s avatar" border="0"/></a>', a) : "", a.time = r('<span class="tweet_time"><a href="{tweet_url}" title="view tweet on twitter">{tweet_relative_time}</a></span>', a), a.text = r('<span class="tweet_text">{tweet_text_fancy}</span>', a), a.reply_action = r('<a class="tweet_action tweet_reply" href="{reply_url}">reply</a>', a), a.retweet_action = r('<a class="tweet_action tweet_retweet" href="{retweet_url}">retweet</a>', a), a.favorite_action = r('<a class="tweet_action tweet_favorite" href="{favorite_url}">favorite</a>', a), a
        }
        var w = e.extend({
                modpath: "/twitter/",
                username: null,
                list_id: null,
                list: null,
                favorites: !1,
                query: null,
                avatar_size: null,
                count: 3,
                fetch: null,
                page: 1,
                retweets: !0,
                intro_text: null,
                outro_text: null,
                join_text: null,
                auto_join_text_default: "i said,",
                auto_join_text_ed: "i",
                auto_join_text_ing: "i am",
                auto_join_text_reply: "i replied to",
                auto_join_text_url: "i was looking at",
                loading_text: null,
                refresh_interval: null,
                twitter_url: "twitter.com",
                twitter_api_url: "api.twitter.com",
                twitter_search_url: "search.twitter.com",
                template: "{avatar}{time}{join}{text}",
                comparator: function(e, t) {
                    return t.tweet_time - e.tweet_time
                },
                filter: function() {
                    return !0
                }
            }, t),
            p = /\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))/gi;
        return e.extend({
            tweet: {
                t: r
            }
        }), e.fn.extend({
            linkUser: a(/(^|[\W])@(\w+)/gi, '$1<span class="at">@</span><a href="http://' + w.twitter_url + '/$2">$2</a>'),
            linkHash: a(/(?:^| )[\#]+([\w\u00c0-\u00d6\u00d8-\u00f6\u00f8-\u00ff\u0600-\u06ff]+)/gi, ' <a href="http://' + w.twitter_search_url + "/search?q=&tag=$1&lang=all" + (w.username && 1 == w.username.length && !w.list ? "&from=" + w.username.join("%2BOR%2B") : "") + '" class="tweet_hashtag">#$1</a>'),
            makeHeart: a(/(<)+[3]/gi, "<tt class='heart'>&#x2665;</tt>")
        }), this.each(function(t, a) {
            var n = e('<div class="twitter-slider">'),
                i = '<p class="tweet_intro">' + w.intro_text + "</p>",
                s = '<p class="tweet_outro">' + w.outro_text + "</p>",
                u = e('<p class="loading">' + w.loading_text + "</p>");
            w.username && "string" == typeof w.username && (w.username = [w.username]), e(a).unbind("tweet:load").bind("tweet:load", function() {
               	// console.log(e(a).empty().append(u));
                w.loading_text && e(a).empty().append(u), e.ajax({
                    dataType: "json",
                    type: "post",
                    // async: false,
                    url: w.modpath || "/twitter/",
                    data: {
                        action: "handle_tweet",
                        request: _()
                    },
                    success: function(t) {
                    	console.log("dad");
                        t.message && console.log(t.message);
                        var u = t.response;
                        e(a).empty().append(n), w.intro_text && n.before(i), n.empty(), resp = void 0 !== u.statuses ? u.statuses : void 0 !== u.results ? u.results : u;
                        var o = e.map(resp, c);
                        o = e.grep(o, w.filter).sort(w.comparator).slice(0, w.count), n.append(e.map(o, function(e) {
                            return "<div class='twitter-item text-center'>" + r(w.template, e) + "</div>"
                        }).join("")), w.outro_text && n.after(s), e(a).trigger("loaded").trigger(o ? "empty" : "full"), w.refresh_interval && window.setTimeout(function() {
                            e(a).trigger("tweet:load")
                        }, 1e3 * w.refresh_interval)
                    }
                })
            }).trigger("tweet:load")
        })
    }
});