/* global confirm, redux, redux_change */
jQuery(document).ready(function($) {

	var importBtn = $( '#et-install-demo' );

	importBtn.bind( 'click' , (function(e){
		e.preventDefault();
        		
		if( ! confirm( 'Are you sure you want to install base demo data?' ) ) {
			return false;
		}

		$( 'body' ).before( '<div class="instal-shape"><div class="install-process">Installing demo data... Please wait...</div></div>') ;

		$.ajax({
			method: "POST",
			url: ajaxurl,
			data: {
				'action':'et_import_ajax'
			},

			success: function(data){
				$( '.instal-shape' ).html( '<div class="final-import"><span>Instalation results</span>' + data + '<div class="et-timer">page will reload in<span class="time"></span></div></div>' );
			},

			error: function(data){
				$( '.instal-shape' ).html( '<div class="final-import"><span>Instalation results</span><ul><li class="et-admin-error">Something is wrong</li></ul><div class="et-timer">page will reload in<span class="time"></span></div></div>' );
			},

			complete: function(){
				var time = 5;
				$( '.et-timer .time' ).text( time );
				var interval = setInterval(function() {
					time--;
					$( '.et-timer .time' ).text( time );
					if ( time === 0 ){
						clearInterval( interval );
						location.reload();
					} 
				}, 1000 );
			}
		});
	}));
});