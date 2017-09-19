var duties = new Vue({
    el: '#duties',
    data: {
        duties: [],
        start_index: 1,
        page: 1,
        last_page: false,
        limit: 30,
        activity_id: '',
        activities: []
    },
    watch: {
        activity_id: function (value) {
            this.page = 1;
            this.last_page = false;
            this.activity_id = value;
            this.getDuties();
        }
    },
    methods: {
        init: function () {
            this.getDuties();

            this.$http.get('/api/activities').then(function(response) {
                if (response.body.content) {
                    this.activities = response.body.content;
                }
            }, function(response) {
                console.log(response);
            });
        },
        getDuties: function () {
            var query = 'page=' + this.page;

            if (this.activity_id) {
                query += '&activity_id=' + this.activity_id;
            }

            this.$http.get('/api/duties?' + query).then(function(response) {
                var content = response.body.content;

                if (content && content.length > 0) {
                    this.duties = response.body.content;
                    this.start_index = this.limit * (this.page - 1) + 1;
                } else if (this.page > 1) {
                    this.last_page = true;
                    this.page--;
                } else {
                    this.duties = [];
                    this.last_page = true;
                }
            }, function(response) {
                console.log(response);
            });
        },
        prevPage: function () {
            if (this.page <= 1) {
                return;
            }

            this.last_page = false;
            this.page--;

            this.getDuties();
        },
        nextPage: function () {
            if (this.last_page) {
                return;
            }

            this.page++;

            this.getDuties();
        },
        dutyUser: function (duty) {
            return duty.user ? duty.user.username : '';
        },
        releaseDuty: function (duty) {
            if (!confirm('Вы уверены?')) {
                return;
            }

            var $this = this;

            var data = {
                action: 'release'
            };

            this.$http.patch('/api/duty/' + duty.id, data).then(function(response) {
                if (response.status === 200) {
                    duty.user = null;
                    duty.picked_at = null;
                }
            }, function(response) {
                console.log(response);
            });
        },
        deleteDuty: function (duty) {
            if (!confirm('Вы уверены?')) {
                return;
            }

            var $this = this;

            this.$http.delete('/api/duty/' + duty.id).then(function(response) {
                if (response.status === 200) {
                    $this.duties.splice($this.duties.indexOf(duty), 1);
                }
            }, function(response) {
                console.log(response);
            });
        }
    }
});

duties.init();
