var _rank, _upcoming;
(function()
{
	var 	mainDisplay = false,
		$rank;

	function handle_DOMReady(evt)
	{
		// setup listener for incoming message from parent
		window.addEventListener("message", handle_Message, false);
		mainDisplay = document.getElementById('score');

		//_rank = setInterval(updateRanking, 3000);
		_upcoming = setInterval(updateUpcoming, 3000);
		$rank = jQuery("#rank");
		//updateRanking();
		updateUpcoming();
		setupTimer();
	};
	
	function handle_Message(evt)
	{
		if(mainDisplay)
			mainDisplay.innerHTML = evt.data;
	};

	function setupTimer()
	{
		var $time = jQuery("#time");
		setInterval(function()
		{
			var now = new Date();
			$time.text(now.getHours() + ":" + now.getMinutes());
		}, 1000);
	}

	function updateRanking()
	{
		jQuery.ajax({
			url: "/greifmasters/admin/rpc/rank/10",
			dataType: "json",
			success: function(data)
			{
				$rank.empty();
				$nl = jQuery("<ol></ol>");
				for(var i in data)
				{
					var d = data[i];
					if(!d.team) continue;
					$nl.append("<li>" + d.team + "</li>");
				}
				$rank.append($nl);
			}
		});
	}

	function updateUpcoming()
	{
		console.log("updateUpcoming()");
		jQuery.ajax({
			url: "/greifmasters/admin/rpc/upcoming",
			success: function(data)
			{
				jQuery("#upcoming")
					.html(data)
					.find("tr td:contains(action)").hide();
			}
		});
	}

	document.addEventListener("DOMContentLoaded", handle_DOMReady, true);
})();
