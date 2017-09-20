var vendors = new Vue({
    el: '#vendors',
    data: {
        vendors: [],
        creating: false,
        index: null,
        form: {}
    },
    methods: {
        init: function () {
            this.resetForm();

            this.$http.get('/api/vendors').then(function(response) {
                if (response.body.content) {
                    this.vendors = response.body.content;
                }
            }, function(response) {
                console.log(response);
            });
        },
        editVendor: function (vendor) {
            this.form = JSON.parse(JSON.stringify(vendor));
            this.creating = true;
            this.index = this.vendors.indexOf(vendor);
        },
        saveForm: function () {
            var $this = this;
            var request = null;

            if (this.form.id) {
                request = this.$http.put('/api/vendor/' + this.form.id, this.form);
            } else {
                request = this.$http.post('/api/vendor', this.form);
            }

            request.then(function(response) {
                if ([200, 201].indexOf(response.status) > -1) {
                    if ($this.index !== null) {
                        $this.vendors[$this.index] = response.body.content;
                    } else {
                        $this.vendors.push(response.body.content);
                    }

                    $this.cancelForm();
                }
            }, function(response) {
                console.log(response);
            });
        },
        deleteVendor: function (vendor) {
            if (!confirm('Вы уверены?')) {
                return;
            }

            var $this = this;

            this.$http.delete('/api/vendor/' + vendor.id).then(function(response) {
                if (response.status === 200) {
                    $this.vendors.splice($this.vendors.indexOf(vendor), 1);
                }
            }, function(response) {
                console.log(response);
            });
        },
        cancelForm: function () {
            this.resetForm();
            this.creating = false;
            this.index = null;
        },
        resetForm: function () {
            this.form = {
                name: '',
                hostname: ''
            };
        }
    }
});

vendors.init();
