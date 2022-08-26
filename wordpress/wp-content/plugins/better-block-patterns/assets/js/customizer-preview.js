(function ($, rules, _) {

    $(document).ready(function () {

        var styleSheet = $('#bbp-custom-css').length ? $('#bbp-custom-css')[0].sheet : undefined;

        _.each(rules['layout-rules'], function (current) {
            wp.customize(current.id, function (value) {

                value.bind(function (newval) {
                    var myObj = {};
                    myObj[current.rule] = newval;

                    if ( current.selector == ':root' ) {
                        var prop = current.rule;
                        myObj[prop] = newval + 'px';
					}

                    vein.inject(
                        current.selector.split(','),
                        myObj,
                        {'stylesheet': styleSheet}
                    );
                    
                });
            });
        });

        _.each(rules['color-rules'], function (current) {

            wp.customize(current.id, function (value) {

                value.bind(function (newval) {
                    var myObj = {};
                    myObj[current.rule] = newval;

                    if ( current.selector == ':root' ) {
                        var prop = current.rule;
                        myObj[prop] = newval;
					}

                    vein.inject(
                        current.selector.split(','),
                        myObj,
                        {'stylesheet': styleSheet}
                    );

                });

            });
        });

        _.each(rules['font-rules'], function (current) {
            wp.customize(current.id, function (value) {

                value.bind(function (newval) {
                    var myObj = {};
                    myObj[current.rule] = newval;
                    vein.inject(
                        current.selector.split(','),
                        myObj,
                        {'stylesheet': styleSheet}
                    );
                });
            });
        });

        // For font-size and font-family rules.
        _.each(['font-size', 'font-family', 'letter-spacing', 'line-height'], function (rule) {
            _.each(rules['font-extra-rules'], function (current) {
                wp.customize(rule + '-' + current.id, function (value) {
                    
                    value.bind(function (newval) {
                        var myObj = {};
                        myObj[rule] = (rule === 'font-size') ? newval + 'px' : newval;
                        if (rule === 'font-family') {
                        	// alert(current.id); // var-primary
                        	// alert('Newval: ' + newval); // Noto Serif
                        	// alert('Current selector' + current.selector ); // :root
                            WebFont.load({
                                google: {
                                    families: [newval]
                                },
                                fontactive: function () {
                                    if ( current.selector != ':root' ) {
	                                    vein.inject(
	                                        current.selector.split(','),
	                                        myObj,
	                                        {'stylesheet': styleSheet}
	                                    );
                                	} else {
	                                    var myVarObj = new Object;
	                                    var prop = current.rule;
	                                    myVarObj[prop] = newval;
	                                    vein.inject(
	                                        current.selector.split(','),
	                                        myVarObj,
	                                        {'stylesheet': styleSheet}
	                                    );
                                	}
                                }
                            });
                        } else {
                            vein.inject(
                                current.selector.split(','),
                                myObj,
                                {'stylesheet': styleSheet}
                            );
                        }

                    });
                });
            });
        });

    });
})(jQuery, bbp_css_rules, _, vein);