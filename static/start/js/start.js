define(['require'], function (require) {
    var Start = (function () {
        function Start() {
        }
        Start.prototype.run = function () {
            this.setFeed();
        };
        Start.prototype.setFeed = function () {
        };
        Start.prototype.setFragment = function (fragment) {
            require([fragment.getUri() + '?'], function () { });
        };
        return Start;
    }());
    var Fragment = (function () {
        function Fragment() {
        }
        Fragment.prototype.getUri = function () {
            return '';
        };
        return Fragment;
    }());
    return new Start();
});
