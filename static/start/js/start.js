define(['require'], function (require) {
    var Start = (function () {
        function Start() {
            var start = this;
            var fragments = document.getElementsByClassName('fragment');
            for (var i = 0; i < fragments.length; i++) {
                (function (i) {
                    fragments[i].addEventListener('click', function () {
                        start.setFragment(fragments[i].dataset.id);
                    }, false);
                })(i);
            }
        }
        Start.prototype.run = function () {
            this.setFeed();
        };
        Start.prototype.setFeed = function () {
        };
        Start.prototype.setFragment = function (id) {
            require(['/fragment/' + id + '?' + (new Date()).getTime()], function () { });
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
