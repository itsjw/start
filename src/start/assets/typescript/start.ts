define(['require'], function (require) {
    class Start {
        private fragments: Array;

        constructor() {
            this.fragments = [];
        }

        public run() {
            this.loadStickers();
        }

        public loadStickers() {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('GET', '/fragments', true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);
                    var fragments = data.content;

                    for (var i = 0; i < fragments.length; i++) {
                        (function(i) {
                            var fragment = new Fragment(fragments[i].id, fragments[i].name, fragments[i].title);
                            start.fragments.push(fragment);
                            start.addSticker(fragment);
                        })(i)
                    }

                    var stickers = document.getElementsByClassName('sticker');

                    for (var i = 0; i < stickers.length; i++) {
                        (function(i) {
                            stickers[i].addEventListener('click', function () {
                                start.addWorkspace(stickers[i].dataset.id);
                            }, false);
                        })(i)
                    }

                    start.addWorkspace(fragments[0].id);
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public closeFragment(id: number) {
            var request = new XMLHttpRequest();
            request.open('POST', '/fragment/' + id, true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("workspaces").removeChild(document.getElementById("workspace" + id));
                    document.getElementById("stickers").removeChild(document.getElementById("sticker" + id));
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public addSticker(fragment: Fragment) {
            document.getElementById("stickers").innerHTML += `<div id="sticker` + fragment.id + `" class="sticker" data-id="` + fragment.id + `">
                <div><span style="color: #cccccc">Для кого:</span> ` + fragment.name + `</div>
                <div><span style="color: #cccccc">Описание:</span> ` + fragment.title + `</div>
            </div>`;
        }

        public addFragment(id: number, html: string) {
            document.getElementById('workspace' + id).innerHTML = html;
        }

        public addWorkspace(id: number) {
            var fragment = document.getElementById("workspace" + id);

            if (fragment == null) {
                document.getElementById("workspaces").innerHTML += '<div id="workspace' + id + '" class="workspace"></div>';
            }

            var workspaces = document.getElementsByClassName('workspace');

            for (var i = 0; i < workspaces.length; i++) {
                (function(i) {
                    workspaces[i].style.display = "none";
                })(i)
            }

            document.getElementById("workspace" + id).style.display = "block";

            require(['/fragment/' + id], function() {});
        }
    }

    class Fragment {
        id: number;
        name: string;
        title: string;

        constructor(id: number, name: string, title: string) {
            this.id = id;
            this.name = name;
            this.title = title;
        }
    }

    return new Start();
});

