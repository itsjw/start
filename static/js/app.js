var dashboard = new Vue({
    el: '#dashboard',
    data: {
        duties: [],
        results: [],
        searching: false,
        query: '',
        online: false,
        stickers_shown: true,
        last_alert: 0
    },
    methods: {
        getDutyIds: function () {
            var ids = [];

            for (i = 0; i < this.duties.length; i++) {
                ids.push(this.duties[i].id);
            }

            return ids;
        },
        toggleOnline: function () {
            this.online = !this.online;
        },
        toStickers: function () {
            this.stickers_shown = true;
        },
        init: function () {
            this.$http.get('/duties').then(function(response) {
                if (response.body.content) {
                    for (var i = 0; i < response.body.content.length; i++) {
                        this.appendDuty(response.body.content[i]);
                    }

                    this.openDuty(this.duties[0]);
                }

                $this = this;

                setInterval(function () {
                    $this.extraDuties();
                }, 10000);
            }, function(response) {
                console.log(response);
            });

            $this = this;

            document.addEventListener('Start.closeDuty', function(event) {
                $this.closeDutyById(event.detail);
            });

            window.addEventListener('message', function(event) {
                $this.closeDutyById(event.data.closeDuty);
            }, false);
        },
        extraDuties: function () {
            if (!this.online) {
                return;
            }

            $this = this;

            var url = '/extra';
            var have_ids = this.getDutyIds();

            if (have_ids.length > 0) {
                url += '?have_ids=' + have_ids.join(',');
            }

            $this.$http.get(url).then(function(response) {
                var content = response.body.content;

                if (content) {
                    for (var i = 0; i < content.length; i++) {
                        if ($this.getDutyIds().indexOf(content[i].id) > -1) {
                            continue;
                        }

                        var process = (function (duty) {
                            return function () {
                                if (duty.validation_url) {
                                    $this.$http.head(duty.validation_url).then(function(response) {
                                        if (response.status === 204) {
                                            $this.$http.post('/duty/remove/' + duty.id);
                                        } else {
                                            $this.prependDuty(duty);

                                            var timestamp = Math.floor(Date.now());

                                            if (timestamp - $this.last_alert > 5000) {
                                                $this.last_alert = timestamp;
                                                $this.newDutyAlert(duty);
                                            }
                                        }
                                    }, function(response) {
                                        console.log(response);
                                    });
                                } else {
                                    $this.prependDuty(duty);

                                    var timestamp = Math.floor(Date.now());

                                    if (timestamp - $this.last_alert > 5000) {
                                        $this.last_alert = timestamp;
                                        $this.newDutyAlert(duty);
                                    }
                                }
                            }
                        })(content[i]);

                        process();
                    }
                }
            }, function(response) {
                console.log(response);
            });
        },
        newDutyAlert: function (duty) {
            document.getElementById('stickers-column').scrollTop = 0;

            var sound = new buzz.sound(DATA.static + "/sound/extra.mp3");
            sound.play();

            if ($this.duties.length === 1) {
                this.openDuty(duty);
            }
        },
        prependDuty: function (data) {
            var duty = new Duty(data);

            if (this.getDutyIds().indexOf(data.id) === -1) {
                this.duties.unshift(duty);
            }

            return duty;
        },
        appendDuty: function (data) {
            var duty = new Duty(data);

            if (this.getDutyIds().indexOf(data.id) === -1) {
                this.duties.push(duty);
            }

            return duty;
        },
        openDutyBySticker: function (duty) {
            this.stickers_shown = false;

            this.openDuty(duty);
        },
        openDuty: function (duty) {
            for (var i = 0; i < this.duties.length; i++) {
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
            duty.commenting_state = true;
        },
        postponeDuty: function (duty) {
            duty.postponing_state = true;
        },
        resetDuty: function (duty) {
            duty.commenting_state = false;
            duty.postponing_state = false;
            duty.tmp_comment = duty.comment;
        },
        closeDutyById: function (duty_id) {
            for (var i = 0; i < this.duties.length; i++) {
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
                this.stickers_shown = true;

                if (this.duties.length > 0) {
                    this.openDuty(this.duties[0]);
                } else {
                    this.extraDuties();
                }
            }, function(response) {
                console.log(response);
            });
        },
        pickDuty: function (duty) {
            if (!confirm('Приступить к задаче?')) {
                return;
            }

            this.$http.post('/duty/pick/' + duty.id).then(function(response) {
                this.appendDuty(duty);
                this.openDutyBySticker(duty);
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
                this.stickers_shown = true;

                if (this.duties.length > 0) {
                    this.openDuty(this.duties[0]);
                } else {
                    this.extraDuties();
                }
            }, function(response) {
                console.log(response);
            });
        },
        search: function () {
            this.$http.get('/search?query=' + this.query, {
                before: function(request) {
                    if (this.previousRequest) {
                        this.previousRequest.abort();
                    }

                    this.previousRequest = request;
                }
            }).then(function(response) {
                this.results = response.body.content;
            }, function(response) {
                console.log(response);
            });
        },
        reloadDuty: function (duty) {
            if (!confirm('Все несохраненные данные будут утеряны')) {
                return;
            }

            var iframe = [duty.iframe][0];
            duty.iframe = null;

            this.$nextTick(function () {
                duty.iframe = iframe;
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
        createDuty: function (nav_id) {
            this.$http.post('/duty/create', {nav_id: nav_id}).then(function(response) {
                var duty = dashboard.appendDuty(response.body.content);
                dashboard.openDutyBySticker(duty);
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
        this.description = '';
        this.comment = null;
        this.tmp_comment = null;
        this.iframe = null;
        this.validation_url = null;
        this.closing = null;
        this.commenting = null;
        this.postponing = null;
        this.postpone_date = null;
        this.postpone_time = '09:00';
        this.open = false;
        this.shown = false;
        this.iframe_open = false;
        this.commenting_state = false;
        this.postponing_state = false;
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
        if (object.description) {
            this.description = object.description;
        }
        if (object.comment) {
            this.comment = object.comment;
            this.tmp_comment = object.comment;
        }
        if (object.iframe) {
            this.iframe = object.iframe;
        }
        if (object.validation_url) {
            this.validation_url = object.validation_url;
        }
        if (object.closing) {
            this.closing = object.closing;
        }
        if (object.commenting) {
            this.commenting = object.commenting;
        }
        if (object.postponing) {
            this.postponing = object.postponing;
        }
    }
    return Duty;
}());
