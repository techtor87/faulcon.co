( function( api ) {

	// Extends our custom "wedding-photos" section.
	api.sectionConstructor['wedding-photos'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
