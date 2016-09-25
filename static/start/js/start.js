define(['require'], function (require) {
    var Start = (function () {
        function Start() {
            var start = this;
            var fragments = document.getElementsByClassName('fragment');
            for (var i = 0; i < fragments.length; i++) {
                var fragment = fragments[i];
                var uri = fragment.dataset.uri;
                fragment.addEventListener('click', function () {
                    start.setFragment(uri);
                }, false);
            }
        }
        Start.prototype.run = function () {
            this.setFeed();
        };
        Start.prototype.setFeed = function () {
        };
        Start.prototype.setFragment = function (uri) {
            require([uri + '?'], function () { });
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
