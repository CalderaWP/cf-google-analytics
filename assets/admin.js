
( function( $){
    if( 'object' == typeof  CF_GA ){
        new CFGA( CF_GA, jQuery );
    }
})( jQuery );

function CFGA( config, $ ){
    Vue.component('cf-ga', {
        template: '#cf-ga-tmpl',
        data: function () {
            return {
                ua: String,
                domain: String
            }
        },
        mounted: function () {
            this.getSettings();
        },
        methods : {
            getSettings: function () {
                var self = this;
                $.ajax({
                    method: 'GET',
                    url: config.api,
                    beforeSend: function ( xhr ) {
                        xhr.setRequestHeader( 'X-WP-Nonce', config.nonce );
                    },
                    complete: function (r) {
                        self.setSettings( r.responseJSON );
                    },
                    error: function (r) {
                        alert('FAIL');
                    }

                });
            },
            updateSettings: function () {
                var self = this;
                var ua = this.ua;
                var domain = this.domain;
				var $spinner = $( '#cf-ga-spinner' );
				var $feedback = $( '#cf-ga-feedback' );
				$spinner.show().attr( 'aria-hidden', false );
				$feedback.html( '' );
                $.ajax({
                    method: 'POST',
                    url: config.api,
                    beforeSend: function ( xhr ) {
                        xhr.setRequestHeader( 'X-WP-Nonce', config.nonce );
                    },
                    data: {
                        ua: ua,
                        domain: domain
                    },
                    complete: function (r) {
                        self.setSettings( r.responseJSON );
                        $( '#cf-ga-feedback' ).html( '<p class="notice notice-success">' + CF_GA.strings.saved + '</p>' );
						$spinner.hide().attr( 'aria-hidden', true );

					},
                    error: function (r) {
                        alert('FAIL');
                    }
                });
            },
            setSettings: function ( settings ) {
                this.$set( this, 'ua', settings.ua );
                this.$set( this, 'domain', settings.domain );
            },
            onSubmit: function () {
                this.updateSettings();
            }
        }
    });

    new Vue({
        el: '#cf-ga',

    });
}