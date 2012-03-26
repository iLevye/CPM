	
	function time_date(unix_timestamp){
		var date = new Date(unix_timestamp);
		var day = date.getDay();
		var month = date.getMonth();
		var year = date.getFullYear();

		var date = day + '-' + month + '-' + year;
		return date;
	}

    $.fn.liveDraggable = function (opts) {
      this.live("mouseover", function() {
         if (!$(this).data("init")) {
            $(this).data("init", true).draggable(opts);
         }
      });
      return $();
    };

	$.fn.takvim = function(options) {
		var settings = $.extend( {
		    }, options);

		return this.each(function() {
			var d = new Date(settings.start);
			settings.start = d.getTime() / 1000;

			g1 = settings.start;
			g2 = settings.start + 86400;
			g3 = settings.start + (86400 * 2);
			g4 = settings.start + (86400 * 3);
			g5 = settings.start + (86400 * 4);
			g6 = settings.start + (86400 * 5);
			g7 = settings.start + (86400 * 6);

			$this = $(this);

			$this.append("<table id='taktable'><tr class='baslik' ><td>Personel</td><td>" + time_date(g1) + "</td><td>Salı</td><td>Çarşamba</td><td>Perşembe</td><td>Cuma</td><td>Cumartesi</td><td>Pazar</td></tr></table>");
			$this.append("<div id='tasks'></div>");

	    	$.getJSON(settings.source + "?start=" + settings.start, function(JSON){
	        	for(var i in JSON){
	        		$this.find("tr:last").after("<tr user_id='" + JSON[i]['user_id'] + "'><td>" + JSON[i]['isim'] + "</td><td class='g1'></td><td class='g2'></td><td class='g3'></td><td class='g4'></td><td class='g5'></td><td class='g6'></td><td class='g7'></td></tr>");
	        		
	        		for(var k in JSON[i]['task']){

	        			var d2 = new Date(JSON[i]['task'][k]['baslangic']);
	        			var event_start = d2.getTime() / 1000;

	        			var d3 = new Date(JSON[i]['task'][k]['bitis']);
	        			var event_finish = d3.getTime() / 1000;


	        			if(event_start >= g1 && event_start < g2){
	        				var gun = "g1";
	        			}
	        			if(event_start >= g2 && event_start < g3){
	        				var gun = "g2";
	        			}
	        			if(event_start >= g3 && event_start < g4){
	        				var gun = "g3";
	        			}
	        			if(event_start >= g4 && event_start < g5){
	        				var gun = "g4";
	        			}
	        			if(event_start >= g5 && event_start < g6){
	        				var gun = "g5";
	        			}
	        			if(event_start >= g6 && event_start < g7){
	        				var gun = "g6";
	        			}
	        			if(event_start >= g7 && event_start < (g7 + 86400)){
	        				var gun = "g7";
	        			}

	        			var gun_sayisi = (((event_finish - event_start) / 86400) + 1);
	        			var width = $("[user_id=" + JSON[i]['user_id'] + "] ." + gun).width() * gun_sayisi;

	        			task = $("[user_id=" + JSON[i]['user_id'] + "] ." + gun).position();
						$this.find("#tasks").append("<div class='task' style='width: " + width +"px; left:" + task.left + "px; top: " + (task.top - 70) + "px' task_date='" + JSON[i]['task'][k]['start'] + "'>" + JSON[i]['task'][k]['task_name'] + "</div>");
					}
	        	}
	    	});

	    	$(".task").liveDraggable();
			
		});
	};