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
            var wrapper = document.getElementById(id.toString());
            if (wrapper == null) {
                document.getElementById("wrapper").innerHTML += '<div id="' + id + '" class="wrapper"></div>';
            }
            var wrappers = document.getElementsByClassName('wrapper');
            for (var i = 0; i < wrappers.length; i++) {
                (function (i) {
                    wrappers[i].style.display = "none";
                })(i);
            }
            document.getElementById(id.toString()).style.display = "block";
            require(['/fragment/' + id], function () { });
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
