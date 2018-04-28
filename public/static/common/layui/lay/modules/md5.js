;!function (win) {
    'use strict';
    layui.define(function (exports) {
        var md5 = {
            config: {
                MOD_NAME: 'md5'
            }
            /**
             * 对字符串进行MD5加密
             * @param str 要加密的字符串
             */
            , calcMD5: function (str) {
                var self = this
                    , x = self.str2blksMD5(str)
                    , a = 0x67452301
                    , b = 0xEFCDAB89
                    , c = 0x98BADCFE
                    , d = 0x10325476;
                for (var i = 0; i < x.length; i += 16) {
                    var olda = a
                        , oldb = b
                        , oldd = d
                        , oldc = c;
                    a = self.ff(a, b, c, d, x[i + 0], 7, 0xD76AA478);
                    d = self.ff(d, a, b, c, x[i + 1], 12, 0xE8C7B756);
                    c = self.ff(c, d, a, b, x[i + 2], 17, 0x242070DB);
                    b = self.ff(b, c, d, a, x[i + 3], 22, 0xC1BDCEEE);
                    a = self.ff(a, b, c, d, x[i + 4], 7, 0xF57C0FAF);
                    d = self.ff(d, a, b, c, x[i + 5], 12, 0x4787C62A);
                    c = self.ff(c, d, a, b, x[i + 6], 17, 0xA8304613);
                    b = self.ff(b, c, d, a, x[i + 7], 22, 0xFD469501);
                    a = self.ff(a, b, c, d, x[i + 8], 7, 0x698098D8);
                    d = self.ff(d, a, b, c, x[i + 9], 12, 0x8B44F7AF);
                    c = self.ff(c, d, a, b, x[i + 10], 17, 0xFFFF5BB1);
                    b = self.ff(b, c, d, a, x[i + 11], 22, 0x895CD7BE);
                    a = self.ff(a, b, c, d, x[i + 12], 7, 0x6B901122);
                    d = self.ff(d, a, b, c, x[i + 13], 12, 0xFD987193);
                    c = self.ff(c, d, a, b, x[i + 14], 17, 0xA679438E);
                    b = self.ff(b, c, d, a, x[i + 15], 22, 0x49B40821);

                    a = self.gg(a, b, c, d, x[i + 1], 5, 0xF61E2562);
                    d = self.gg(d, a, b, c, x[i + 6], 9, 0xC040B340);
                    c = self.gg(c, d, a, b, x[i + 11], 14, 0x265E5A51);
                    b = self.gg(b, c, d, a, x[i + 0], 20, 0xE9B6C7AA);
                    a = self.gg(a, b, c, d, x[i + 5], 5, 0xD62F105D);
                    d = self.gg(d, a, b, c, x[i + 10], 9, 0x02441453);
                    c = self.gg(c, d, a, b, x[i + 15], 14, 0xD8A1E681);
                    b = self.gg(b, c, d, a, x[i + 4], 20, 0xE7D3FBC8);
                    a = self.gg(a, b, c, d, x[i + 9], 5, 0x21E1CDE6);
                    d = self.gg(d, a, b, c, x[i + 14], 9, 0xC33707D6);
                    c = self.gg(c, d, a, b, x[i + 3], 14, 0xF4D50D87);
                    b = self.gg(b, c, d, a, x[i + 8], 20, 0x455A14ED);
                    a = self.gg(a, b, c, d, x[i + 13], 5, 0xA9E3E905);
                    d = self.gg(d, a, b, c, x[i + 2], 9, 0xFCEFA3F8);
                    c = self.gg(c, d, a, b, x[i + 7], 14, 0x676F02D9);
                    b = self.gg(b, c, d, a, x[i + 12], 20, 0x8D2A4C8A);

                    a = self.hh(a, b, c, d, x[i + 5], 4, 0xFFFA3942);
                    d = self.hh(d, a, b, c, x[i + 8], 11, 0x8771F681);
                    c = self.hh(c, d, a, b, x[i + 11], 16, 0x6D9D6122);
                    b = self.hh(b, c, d, a, x[i + 14], 23, 0xFDE5380C);
                    a = self.hh(a, b, c, d, x[i + 1], 4, 0xA4BEEA44);
                    d = self.hh(d, a, b, c, x[i + 4], 11, 0x4BDECFA9);
                    c = self.hh(c, d, a, b, x[i + 7], 16, 0xF6BB4B60);
                    b = self.hh(b, c, d, a, x[i + 10], 23, 0xBEBFBC70);
                    a = self.hh(a, b, c, d, x[i + 13], 4, 0x289B7EC6);
                    d = self.hh(d, a, b, c, x[i + 0], 11, 0xEAA127FA);
                    c = self.hh(c, d, a, b, x[i + 3], 16, 0xD4EF3085);
                    b = self.hh(b, c, d, a, x[i + 6], 23, 0x04881D05);
                    a = self.hh(a, b, c, d, x[i + 9], 4, 0xD9D4D039);
                    d = self.hh(d, a, b, c, x[i + 12], 11, 0xE6DB99E5);
                    c = self.hh(c, d, a, b, x[i + 15], 16, 0x1FA27CF8);
                    b = self.hh(b, c, d, a, x[i + 2], 23, 0xC4AC5665);

                    a = self.ii(a, b, c, d, x[i + 0], 6, 0xF4292244);
                    d = self.ii(d, a, b, c, x[i + 7], 10, 0x432AFF97);
                    c = self.ii(c, d, a, b, x[i + 14], 15, 0xAB9423A7);
                    b = self.ii(b, c, d, a, x[i + 5], 21, 0xFC93A039);
                    a = self.ii(a, b, c, d, x[i + 12], 6, 0x655B59C3);
                    d = self.ii(d, a, b, c, x[i + 3], 10, 0x8F0CCC92);
                    c = self.ii(c, d, a, b, x[i + 10], 15, 0xFFEFF47D);
                    b = self.ii(b, c, d, a, x[i + 1], 21, 0x85845DD1);
                    a = self.ii(a, b, c, d, x[i + 8], 6, 0x6FA87E4F);
                    d = self.ii(d, a, b, c, x[i + 15], 10, 0xFE2CE6E0);
                    c = self.ii(c, d, a, b, x[i + 6], 15, 0xA3014314);
                    b = self.ii(b, c, d, a, x[i + 13], 21, 0x4E0811A1);
                    a = self.ii(a, b, c, d, x[i + 4], 6, 0xF7537E82);
                    d = self.ii(d, a, b, c, x[i + 11], 10, 0xBD3AF235);
                    c = self.ii(c, d, a, b, x[i + 2], 15, 0x2AD7D2BB);
                    b = self.ii(b, c, d, a, x[i + 9], 21, 0xEB86D391);

                    a = self.add(a, olda);
                    b = self.add(b, oldb);
                    c = self.add(c, oldc);
                    d = self.add(d, oldd);
                }
                return self.rhex(a) + self.rhex(b) + self.rhex(c) + self.rhex(d);
            }
            /*
             * Convert a string to a sequence of 16-word blocks, stored as an array.
             * Append padding bits and the length, as described in the MD5 standard.
             */
            , str2blksMD5: function (str) {
                var nblk = ((str.length + 8) >> 6) + 1
                    , blks = new Array(nblk * 16);
                for (var i = 0; i < nblk * 16; i++) blks[i] = 0;
                for (var i = 0; i < str.length; i++)
                    blks[i >> 2] |= str.charCodeAt(i) << ((i % 4) * 8);
                blks[i >> 2] |= 0x80 << ((i % 4) * 8);
                blks[nblk * 16 - 2] = str.length * 8;
                return blks;
            }
            /*
             * Add integers, wrapping at 2^32
             */
            , add: function (x, y) {
                return ((x & 0x7FFFFFFF) + (y & 0x7FFFFFFF)) ^ (x & 0x80000000) ^ (y & 0x80000000);
            }
            /*
             * Bitwise rotate a 32-bit number to the left
             */
            , rol: function (num, cnt) {
                return (num << cnt) | (num >>> (32 - cnt));
            }
            /*
             * These functions implement the basic operation for each round of the
             * algorithm.
             */
            , cmn: function (q, a, b, x, s, t) {
                var self = this;
                return self.add(self.rol(self.add(self.add(a, q), self.add(x, t)), s), b);
            }
            , ff: function (a, b, c, d, x, s, t) {
                var self = this;
                return self.cmn((b & c) | ((~b) & d), a, b, x, s, t);
            }
            , gg: function (a, b, c, d, x, s, t) {
                var self = this;
                return self.cmn((b & d) | (c & (~d)), a, b, x, s, t);
            }
            , hh: function (a, b, c, d, x, s, t) {
                var self = this;
                return self.cmn(b ^ c ^ d, a, b, x, s, t);
            }
            , ii: function (a, b, c, d, x, s, t) {
                var self = this;
                return self.cmn(c ^ (b | (~d)), a, b, x, s, t);
            }
            , rhex: function (num) {
                var hex_chr = '0123456789abcdef'
                    , str = '';
                for (var j = 0; j <= 3; j++)
                    str += hex_chr.charAt((num >> (j * 8 + 4)) & 0x0F) + hex_chr.charAt((num >> (j * 8)) & 0x0F);
                return str;
            }
        }
            , _config = md5.config;
        exports(_config.MOD_NAME, md5);
    });
}(window);