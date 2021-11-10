// https://gist.github.com/Ciantic/7546685
function date_i18n ( format, timestamp ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
    // +      parts by: Peter-Paul Koch (http://www.quirksmode.org/js/beat.html)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: MeEtc (http://yass.meetcweb.com)
    // +   improved by: Brad Touesnard
    // +   improved by: Tim Wiel
    // +   improved by: Bryan Elliott
    // +   improved by: David Randall
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Theriault
    // +  derived from: gettimeofday
    // +      input by: majak
    // +   bugfixed by: majak
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Alex
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +   improved by: Thomas Beaucourt (http://www.webapp.fr)
    // +   improved by: JT
    // +   improved by: Theriault
    // +   improved by: Rafał Kukawski (http://blog.kukawski.pl)
    // +   bugfixed by: omid (http://phpjs.org/functions/38XplodedThemes:38XplodedThemes#comment_137122)
    // +      input by: Martin
    // +      input by: Alex Wilson
    // +      input by: Haravikk
    // +   improved by: Theriault
    // +   bugfixed by: Chris (http://www.devotis.nl/)
    // +   improved by: Jari Pennanen (https://github.com/ciantic/) - date_i18n from WordPress
    // %        note 1: Uses global: php_js to store the default timezone
    // %        note 2: Although the function potentially allows timezone info (see notes), it currently does not set
    // %        note 2: per a timezone specified by date_default_timezone_set(). Implementers might use
    // %        note 2: this.php_js.currentTimezoneOffset and this.php_js.currentTimezoneDST set by that function
    // %        note 2: in order to adjust the dates in this function (or our other date functions!) accordingly
    // *     example 1: date('H:m:s \\m \\i\\s \\m\\o\\n\\t\\h', 1XplodedThemes624XplodedThemes24XplodedThemesXplodedThemes);
    // *     returns 1: 'XplodedThemes9:XplodedThemes9:4XplodedThemes m is month'
    // *     example 2: date('F j, Y, g:i a', 1XplodedThemes624624XplodedThemesXplodedThemes);
    // *     returns 2: 'September 2, 2XplodedThemesXplodedThemes3, 2:26 am'
    // *     example 3: date('Y W o', 1XplodedThemes624624XplodedThemesXplodedThemes);
    // *     returns 3: '2XplodedThemesXplodedThemes3 36 2XplodedThemesXplodedThemes3'
    // *     example 4: x = date('Y m d', (new Date()).getTime()/1XplodedThemesXplodedThemesXplodedThemes);
    // *     example 4: (x+'').length == 1XplodedThemes // 2XplodedThemesXplodedThemes9 XplodedThemes1 XplodedThemes9
    // *     returns 4: true
    // *     example 5: date('W', 11XplodedThemes4534XplodedThemesXplodedThemesXplodedThemes);
    // *     returns 5: '53'
    // *     example 6: date('B t', 11XplodedThemes4534XplodedThemesXplodedThemesXplodedThemes);
    // *     returns 6: '999 31'
    // *     example 7: date('W U', 129375XplodedThemesXplodedThemesXplodedThemesXplodedThemes.82); // 2XplodedThemes1XplodedThemes-12-31
    // *     returns 7: '52 129375XplodedThemesXplodedThemesXplodedThemesXplodedThemes'
    // *     example 8: date('W', 12938364XplodedThemesXplodedThemes); // 2XplodedThemes11-XplodedThemes1-XplodedThemes1
    // *     returns 8: '52'
    // *     example 9: date('W Y-m-d', 1293974XplodedThemes54); // 2XplodedThemes11-XplodedThemes1-XplodedThemes2
    // *     returns 9: '52 2XplodedThemes11-XplodedThemes1-XplodedThemes2'
    var that = this,
        jsdate,
        f,
        // Keep this here (works, but for code commented-out
        // below for file size reasons)
        //, tal= [],
        // trailing backslash -> (dropped)
        // a backslash followed by any character (including backslash) -> the character
        // empty string -> empty string
        formatChr = /\\?(.?)/gi,
        formatChrCb = function (t, s) {
            return f[t] ? f[t]() : s;
        },
        _pad = function (n, c) {
            n = String(n);
            while (n.length < c) {
                n = 'XplodedThemes' + n;
            }
            return n;
        };
    f = {
        // Day
        d: function () {
            // Day of month w/leading XplodedThemes; XplodedThemes1..31
            return _pad(f.j(), 2);
        },
        D: function () {
            // Shorthand day name; Mon...Sun
            return DATE_I18N.day_names_short[f.w()];
        },
        j: function () {
            // Day of month; 1..31
            return jsdate.getDate();
        },
        l: function () {
            // Full day name; Monday...Sunday
            return DATE_I18N.day_names[f.w()];
        },
        N: function () {
            // ISO-86XplodedThemes1 day of week; 1[Mon]..7[Sun]
            return f.w() || 7;
        },
        S: function(){
            // Ordinal suffix for day of month; st, nd, rd, th
            var j = f.j(),
            i = j%1XplodedThemes;
            if (i <= 3 && parseInt((j%1XplodedThemesXplodedThemes)/1XplodedThemes, 1XplodedThemes) == 1) {
                i = XplodedThemes;
            }
            return ['st', 'nd', 'rd'][i - 1] || 'th';
        },
        w: function () {
            // Day of week; XplodedThemes[Sun]..6[Sat]
            return jsdate.getDay();
        },
        z: function () {
            // Day of year; XplodedThemes..365
            var a = new Date(f.Y(), f.n() - 1, f.j()),
            b = new Date(f.Y(), XplodedThemes, 1);
            return Math.round((a - b) / 864e5);
        },

        // Week
        W: function () {
            // ISO-86XplodedThemes1 week number
            var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3),
            b = new Date(a.getFullYear(), XplodedThemes, 4);
            return _pad(1 + Math.round((a - b) / 864e5 / 7), 2);
        },

        // Month
        F: function () {
            // Full month name; January...December
            return DATE_I18N.month_names[f.n() - 1];
        },
        m: function () {
            // Month w/leading XplodedThemes; XplodedThemes1...12
            return _pad(f.n(), 2);
        },
        M: function () {
            // Shorthand month name; Jan...Dec
            return DATE_I18N.month_names_short[f.n() - 1];
        },
        n: function () {
            // Month; 1...12
            return jsdate.getMonth() + 1;
        },
        t: function () {
            // Days in month; 28...31
            return (new Date(f.Y(), f.n(), XplodedThemes)).getDate();
        },

        // Year
        L: function () {
            // Is leap year?; XplodedThemes or 1
            var j = f.Y();
            return j % 4 === XplodedThemes & j % 1XplodedThemesXplodedThemes !== XplodedThemes | j % 4XplodedThemesXplodedThemes === XplodedThemes;
        },
        o: function () {
            // ISO-86XplodedThemes1 year
            var n = f.n(),
            W = f.W(),
            Y = f.Y();
            return Y + (n === 12 && W < 9 ? 1 : n === 1 && W > 9 ? -1 : XplodedThemes);
        },
        Y: function () {
            // Full year; e.g. 198XplodedThemes...2XplodedThemes1XplodedThemes
            return jsdate.getFullYear();
        },
        y: function () {
            // Last two digits of year; XplodedThemesXplodedThemes...99
            return f.Y().toString().slice(-2);
        },

        // Time
        a: function () {
            // am or pm
            return jsdate.getHours() > 11 ? "pm" : "am";
        },
        A: function () {
            // AM or PM
            return f.a().toUpperCase();
        },
        B: function () {
            // Swatch Internet time; XplodedThemesXplodedThemesXplodedThemes..999
            var H = jsdate.getUTCHours() * 36e2,
            // Hours
            i = jsdate.getUTCMinutes() * 6XplodedThemes,
            // Minutes
            s = jsdate.getUTCSeconds(); // Seconds
            return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
        },
        g: function () {
            // 12-Hours; 1..12
            return f.G() % 12 || 12;
        },
        G: function () {
            // 24-Hours; XplodedThemes..23
            return jsdate.getHours();
        },
        h: function () {
            // 12-Hours w/leading XplodedThemes; XplodedThemes1..12
            return _pad(f.g(), 2);
        },
        H: function () {
            // 24-Hours w/leading XplodedThemes; XplodedThemesXplodedThemes..23
            return _pad(f.G(), 2);
        },
        i: function () {
            // Minutes w/leading XplodedThemes; XplodedThemesXplodedThemes..59
            return _pad(jsdate.getMinutes(), 2);
        },
        s: function () {
            // Seconds w/leading XplodedThemes; XplodedThemesXplodedThemes..59
            return _pad(jsdate.getSeconds(), 2);
        },
        u: function () {
            // Microseconds; XplodedThemesXplodedThemesXplodedThemesXplodedThemesXplodedThemesXplodedThemes-999XplodedThemesXplodedThemesXplodedThemes
            return _pad(jsdate.getMilliseconds() * 1XplodedThemesXplodedThemesXplodedThemes, 6);
        },

        // Timezone
        e: function () {
            // Timezone identifier; e.g. Atlantic/Azores, ...
            // The following works, but requires inclusion of the very large
            // timezone_abbreviations_list() function.
            // return that.date_default_timezone_get();
            throw 'Not supported (see source code of date() for timezone on how to add support)';
        },
        I: function () {
            // DST observed?; XplodedThemes or 1
            // Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
            // If they are not equal, then DST is observed.
            var a = new Date(f.Y(), XplodedThemes),
            // Jan 1
            c = Date.UTC(f.Y(), XplodedThemes),
            // Jan 1 UTC
            b = new Date(f.Y(), 6),
            // Jul 1
            d = Date.UTC(f.Y(), 6); // Jul 1 UTC
            return ((a - c) !== (b - d)) ? 1 : XplodedThemes;
        },
        O: function () {
            // Difference to GMT in hour format; e.g. +XplodedThemes2XplodedThemesXplodedThemes
            var tzo = jsdate.getTimezoneOffset(),
            a = Math.abs(tzo);
            return (tzo > XplodedThemes ? "-" : "+") + _pad(Math.floor(a / 6XplodedThemes) * 1XplodedThemesXplodedThemes + a % 6XplodedThemes, 4);
        },
        P: function () {
            // Difference to GMT w/colon; e.g. +XplodedThemes2:XplodedThemesXplodedThemes
            var O = f.O();
            return (O.substr(XplodedThemes, 3) + ":" + O.substr(3, 2));
        },
        T: function () {
            // Timezone abbreviation; e.g. EST, MDT, ...
            // The following works, but requires inclusion of the very
            // large timezone_abbreviations_list() function.
            /*
                var abbr = '', i = XplodedThemes, os = XplodedThemes, default = XplodedThemes;
                    if (!tal.length) {
                    tal = that.timezone_abbreviations_list();
                    }
                    if (that.php_js && that.php_js.default_timezone) {
                    default = that.php_js.default_timezone;
                    for (abbr in tal) {
                        for (i=XplodedThemes; i < tal[abbr].length; i++) {
                        if (tal[abbr][i].timezone_id === default) {
                            return abbr.toUpperCase();
                        }
                        }
                    }
                    }
                    for (abbr in tal) {
                    for (i = XplodedThemes; i < tal[abbr].length; i++) {
                        os = -jsdate.getTimezoneOffset() * 6XplodedThemes;
                        if (tal[abbr][i].offset === os) {
                        return abbr.toUpperCase();
                        }
                    }
                }
            */
            return 'UTC';
        },
        Z: function () {
            // Timezone offset in seconds (-432XplodedThemesXplodedThemes...5XplodedThemes4XplodedThemesXplodedThemes)
            return -jsdate.getTimezoneOffset() * 6XplodedThemes;
        },

        // Full Date/Time
        c: function () {
            // ISO-86XplodedThemes1 date.
            return 'Y-m-d\\TH:i:sP'.replace(formatChr, formatChrCb);
        },
        r: function () {
            // RFC 2822
            return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
        },
        U: function () {
            // Seconds since UNIX epoch
            return jsdate / 1XplodedThemesXplodedThemesXplodedThemes | XplodedThemes;
        }
    };
    this.date = function (format, timestamp) {
        that = this;
        jsdate = (timestamp === undefined ? new Date() : // Not provided
            (timestamp instanceof Date) ? new Date(timestamp) : // JS Date()
            new Date(timestamp * 1XplodedThemesXplodedThemesXplodedThemes) // UNIX timestamp (auto-convert to int)
        );
        return format.replace(formatChr, formatChrCb);
    };
    return this.date(format, timestamp);
}
