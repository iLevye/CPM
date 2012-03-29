		$.fn.ajaxTemplate = function(options) {
			var settings = $.extend( {
				}, options);
			
			toDiv = $(this);
			return this.each(function() {
				$.getJSON(settings.source, function(JSON){
					$.each(JSON, function(k, v) {
						var html = $(settings.template).html();
						html = html.replace( /\&amp;/g, '&' );
						$.each(JSON[k], function(key, val){
							counter = html.split("{$" + key + "}").length - 1;
							for(i = 0; i < counter; i++){
								html = html.replace("{$" + key + "}", val);	
							}
						});

						var pat = /\{if ([^}]+)\}([^{]+)(\{else\}([^{]+))?\{\/if\}/gm;
						iff = html.match(pat);
						if(iff !== null){
							len = iff.length;
							len = len + 1;
							for(i = 0; i <= len; i++){
								try
								{
									var kosul = pat.exec(html);
									//alert(kosul[0]);
									html = html.replace(kosul[0], if_s(kosul[0], JSON[k]));
								}
								catch(err)
								{
									//alert(err);
								}
								
							}
						}
						
						//JSON[k]['task_status']);
						if(settings.list != undefined){
							$(settings.list).append(html);
						}else{
							toDiv.append(html);
						}
						
					});
				});
			});
		}
		
		function if_s(string, json){
			var pat = /\{if ([^}]+)\}([^{]+)(\{else\}([^{]+))?\{\/if\}/gm;
			iff = string.match(pat);
			for (var i in iff){
				var cevap = "";
		     	var test2 = pat.exec(string);
		        var kosul = test2[1];
		        var if_true = test2[2];
		        var if_false = test2[4];
		        
		        //alert(kosul);

		        hebe = kosul.split('$');
		        for(i=0;i<hebe.length;i++){
		        	heb = hebe[i].split(" ");
		        	if(heb[0] != ""){
		        		kosul = kosul.replace("$" + heb[0], json[heb[0]]);
		        	}
		        }

		        var kod = "if(" + kosul + "){";
		        kod += "cevap += '" + if_true + "';}else{";
		        kod += "cevap += '" + if_false + "';}";
		        eval(kod);
		        //alert(kod);
			}
			if(cevap == "undefined"){
				cevap = "";
			}
			return cevap;
		}