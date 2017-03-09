var vm = new Vue({
    el: "#compare",
    data: {
        originalText: '',
        newText: '',
        result: [],
        showResult: false,
        disableButton: true
    },
    computed: {
        disableButton: function (val) {
            return this.originalText != '' && this.newText != '';
        }
    },
    methods: {
        compare: function () {
            var data = new FormData();
            data.append('_token', this.getToken());
            data.append('originalText', this.originalText);
            data.append('newText', this.newText);
            this.$http.post('/compare', data).then(
                function (data, status, request) {
                    this.result = data.data;
                    this.showResult = true;
                    console.log(this.result);
                }, function (error) {
                    console.log('error');
                });
        },
        clear: function () {
            this.showResult = false;
            this.originalText = '';
            this.newText = '';
        },
        back: function () {
            this.showResult = false;
        },
        getToken: function () {
            return document.querySelector('#token').getAttribute('value');
        }
    }
});