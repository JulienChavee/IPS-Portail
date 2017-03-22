;( function($, _, undefined){
	"use strict";
	
	ips.controller.register('dimension.changeBonus', {
	
		initialize: function () {
			this.on( 'change', 'select[name="dimension_updateForm_portail"]', this.changeBonus );
		},
		
		changeBonus: function (e) {
			var idPortail = $('select[name="dimension_updateForm_portail"]').val();

			ips.getAjax() ( ips.getSetting( 'baseURL' ) + "?app=dimension&module=system&controller=ajax&do=getBonus", {
				type: 'post',
				dataType: 'json',
				data: {
					dimension : idPortail
				}
			})
				.done( function( response ) {
					$('select[name="dimension_updateForm_bonus"]').html( response.bonusHTML );
				})
				.fail( function( response ) {
					Debug.log("fail");
				})
		}

	});
}(jQuery, _));