wp.domReady( () => {

	/* core/group */
	wp.blocks.registerBlockStyle( 'core/group', {
		name: 'box',
		label: 'Box',
		isDefault: false,
	} );

	wp.blocks.registerBlockStyle( 'core/group', {
		name: 'session',
		label: 'Session',
		isDefault: false,
	} );

} );
