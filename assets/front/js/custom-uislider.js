 (function ($) {
	"use strict";
      jQuery(document).on('ready', function() {

      	          /*================================
                  ============= Hosting Price Choose List =============
                  =================================*/
                    var processor = ['1.4GHz', '2.1 GHz', '3.4 GHz', '3.8 GHz', '4.1 GHz', '4.3 GHz'];
                    var ram = ['1 GB', '2 GB', '3 GB', '4 GB', '8 GB', '16 GB'];
                    var vSwap = ['1 GB', '2 GB', '3 GB', '4 GB', '8 GB', '16 GB'];
                    var storage = ['10 GB', '30 GB', '50 GB', '100 GB', '200 GB', '500 GB'];
                    var bandWidth = ['20 GB', '50 GB', '100 GB', '500 GB', '1000 GB', '5000 GB'];
                    var ip = [1,2,3,4,5,6];
                    var price = [19.99,29.99,39.99,49.99,59.99,89.99];
                    var pricing = $('#pricing-slider');

                    pricing.slider({
                      range: 'min',
                      min: 1,
                      max: 6,     // Input your maximum pricing options here..
                      value: 2,
                      animate: true,
                      slide: function( event, ui ) {

                        var pricing_info = $('#pricing-2 .info-item.processor .value');
                        var pricing_info1 = $('#pricing-2 .info-item.ram .value');
                        var pricing_info2 = $('#pricing-2 .info-item.ram .value');
                        var pricing_info3 = $('#pricing-2 .info-item.storage .value');
                        var pricing_info4 = $('#pricing-2 .info-item.bandw .value');
                        var pricing_info5 = $('#pricing-2 .info-item.ip .value');
                        var pricing_info6 = $('#pricing-2 .order-button .price');

                        pricing_info.html(processor[ui.value - 1]);
                        pricing_info1.html(ram[ui.value - 1]);
                        pricing_info2.html(vSwap[ui.value - 1]);
                        pricing_info3.html(storage[ui.value - 1]);
                        pricing_info4.html(bandWidth[ui.value - 1]);
                        pricing_info5.html(ip[ui.value - 1]);
                        pricing_info6.html('$' + price[ui.value - 1]);
                          }
                });
    });

})(jQuery);