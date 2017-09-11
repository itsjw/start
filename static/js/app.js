var dashboard = new Vue({
    el: '#dashboard',
    data: {
        duties: [],
        results: [],
        searching: false,
        query: '',
        online: false
    },
    methods: {
        toggleOnline: function () {
            this.online = !this.online;
        },
        init: function () {
            this.$http.get('/duties').then(function(response) {
                if (response.body.content) {
                    for (i = 0; i < response.body.content.length; i++) {
                        this.addDuty(response.body.content[i]);
                    }

                    this.openDuty(this.duties[0]);
                }

                $this = this;

                setInterval(function () {
                    if (!$this.online) {
                        return;
                    }

                    $this.$http.get('/extra').then(function(response) {
                        if (response.body.content) {
                            for (i = 0; i < response.body.content.length; i++) {
                                $this.addDuty(response.body.content[i]);
                            }

                            var sound = new buzz.sound(DATA.static + "/sound/extra.mp3");
                            sound.play();

                            if ($this.duties.length === 1) {
                                $this.openDuty($this.duties[0]);
                            }
                        }
                    }, function(response) {
                        console.log(response);
                    });
                }, 10000);
            }, function(response) {
                console.log(response);
            });

            $this = this;

            document.addEventListener('Start.closeDuty', function(event) {
                $this.closeDutyById(event.detail);
            });
        },
        addDuty: function (data) {
            this.duties.push(new Duty(data));
        },
        addDutyAndOpen: function (data) {
            var duty = new Duty(data);
            this.duties.push(duty);
            this.openDuty(duty);
        },
        openDuty: function (duty) {
            for (i = 0; i < this.duties.length; i++) {
                var tmp = this.duties[i];

                if (tmp.id === duty.id) {
                    tmp.open = true;
                    tmp.shown = true;
                    tmp.iframe_open = true;
                } else {
                    tmp.shown = false;
                }
            }
        },
        commentDuty: function (duty) {
            duty.commenting = true;
        },
        postponeDuty: function (duty) {
            duty.postponing = true;
        },
        resetDuty: function (duty) {
            duty.commenting = false;
            duty.postponing = false;
            duty.tmp_comment = duty.comment;
        },
        closeDutyById: function (duty_id) {
            for (i = 0; i < this.duties.length; i++) {
                if (this.duties[i].id === parseInt(duty_id)) {
                    this.closeDuty(this.duties[i], false);
                }
            }
        },
        closeDuty: function (duty, to_confirm) {
            if (typeof to_confirm === 'undefined') {
                to_confirm = true;
            }

            if (to_confirm && !confirm('Закрыть задачу?')) {
                return;
            }

            this.$http.post('/duty/close/' + duty.id, {comment: duty.tmp_comment}).then(function(response) {
                this.duties.splice(this.duties.indexOf(duty), 1);
                this.openDuty(this.duties[0]);
            }, function(response) {
                console.log(response);
            });
        },
        pickDuty: function (duty) {
            if (!confirm('Приступить к задаче?')) {
                return;
            }

            this.$http.post('/duty/pick/' + duty.id).then(function(response) {
                this.addDutyAndOpen(duty);
                this.results = [];
                this.searching = false;
                this.query = '';
            }, function(response) {
                console.log(response);
            });
        },
        saveComment: function (duty) {
            $this = this;

            this.$http.post('/duty/comment/' + duty.id, {comment: duty.tmp_comment}).then(function(response) {
                duty.comment = duty.tmp_comment;
                $this.resetDuty(duty);
            }, function(response) {
                console.log(response);
            });
        },
        savePostpone: function (duty, period) {
            var data = {};

            if (period) {
                data.period = period;
            } else if (duty.postpone_time && duty.postpone_date) {
                data.datetime = duty.postpone_date + ' ' + duty.postpone_time;
            } else {
                return;
            }

            if (!confirm('Отложить задачу?')) {
                return;
            }

            this.$http.post('/duty/postpone/' + duty.id, data).then(function(response) {
                this.duties.splice(this.duties.indexOf(duty), 1);
                this.openDuty(this.duties[0]);
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

var navbar = new Vue({
    el: '#navbar',
    methods: {
        createDuty: function (activity_id) {
            if (!confirm('Создать задачу?')) {
                return;
            }

            this.$http.post('/duty/create', {activity_id: activity_id}).then(function(response) {
                dashboard.addDutyAndOpen(response.body.content);
            }, function(response) {
                console.log(response);
            });
        }
    }
});

dashboard.init();

var Duty = (function () {
    function Duty(object) {
        this.id = null;
        this.name = null;
        this.title = null;
        this.color = null;
        this.tags = [];
        this.comment = null;
        this.tmp_comment = null;
        this.iframe = null;
        this.readonly = null;
        this.writable = null;
        this.postponable = null;
        this.postpone_date = null;
        this.postpone_time = '09:00';
        this.open = false;
        this.shown = false;
        this.iframe_open = false;
        this.commenting = false;
        this.postponing = false;
        if (object.id) {
            this.id = object.id;
        }
        if (object.name) {
            this.name = object.name;
        }
        if (object.title) {
            this.title = object.title;
        }
        if (object.color) {
            this.color = object.color;
        }
        if (object.tags) {
            this.tags = object.tags;
        }
        if (object.comment) {
            this.comment = object.comment;
            this.tmp_comment = object.comment;
        }
        if (object.iframe) {
            this.iframe = object.iframe;
        }
        if (object.readonly) {
            this.readonly = object.readonly;
        }
        if (object.writable) {
            this.writable = object.writable;
        }
        if (object.postponable) {
            this.postponable = object.postponable;
        }
    }
    return Duty;
}());
