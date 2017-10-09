var app = new Vue({
    el: '#dashboard',
    data: {
        stickers: [],
        results: [],
        searching: false,
        query: ''
    },
    methods: {
        init: function () {
            this.$http.get('/duties').then(function(response) {
                if (response.body.content) {
                    this.stickers = response.body.content;
                }

                $this = this;

                setInterval(function () {
                    $this.$http.get('/extra').then(function(response) {
                        if (response.body.content) {
                            $this.stickers += response.body.content;

                            var sound = new buzz.sound(DATA.static + "/sound/extra.mp3");
                            sound.play();
                        }
                    }, function(response) {
                        console.log(response);
                    });
                }, 10000);
            }, function(response) {
                console.log(response);
            });
        },
        search: function () {
            this.$http.get('/search?query=' + this.query).then(function(response) {
                this.results = response.body.content;
            }, function(response) {
                console.log(response);
            });
        },
        focusSearch: function () {
            this.searching = true;
        },
        blurSearch: function () {
            if (!this.query) {
                this.searching = false;
            }
        }
    }
});

app.init();
