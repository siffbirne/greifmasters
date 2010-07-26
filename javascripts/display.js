// external display
var dbg = true,
    suspendSubtree = false;

var greif = (function()
{
	var 	extWindow = false,
		mainDisplay = false;
	
	function handle_AjaxSuccess(evt)
	{
		suspendSubtree = true;
		console.log("Suspending Subtree mods");

		var $incoming = jQuery(evt.responseText);
		SetCountdownText(_currentSeconds, $incoming.find("#Anzeige")[0]);
		jQuery("#main_display").html($incoming.find("#main_display").html());

		jQuery("div.play_tournament_team1.play_tournament_team tr:eq(0) td:last")
			.html(jQuery(evt.responseText)
				.find("div.play_tournament_team1.play_tournament_team tr:eq(0) td:last").html()
			);

		jQuery("div.play_tournament_team2.play_tournament_team tr:eq(0) td:first")
			.html(jQuery(evt.responseText)
				.find("div.play_tournament_team2.play_tournament_team tr:eq(0) td:first").html()
			);

		suspendSubtree = false;
		console.log("Enabling Subtree mods");
		setupGoalsHandler();
		handle_DisplayUpdated();

		var scores = document.getElementById("timeandscore").textContent.match(/(\d) - (\d)/);
		console.log(scores);
		scores.shift();
		if(scores[0] >= 5) {
			jQuery.event.trigger("game-over");
		}
		if(scores[1] >= 5) {
			jQuery.event.trigger("game-over");
		}
	}

	function handle_DisplayClick(evt)
	{
		console.log('handle_DisplayClick()');
	};

	function handle_DisplayUpdated(evt)
	{
		console.log('handle_DisplayUpdated(suspended == %b)', suspendSubtree);

		if(suspendSubtree === true) return;
		extWindow.postMessage(mainDisplay.innerHTML, window.location);
	};

	function handle_DOMReady(evt)
	{
		if(dbg)
			console.log('handle_DOMReady()');
		
		$('display_output').addEventListener('click', handle_DisplayClick, true);
		mainDisplay = $('main_display');
		// nothing scheduled
		if(!mainDisplay) return;
		mainDisplay.addEventListener('DOMSubtreeModified', handle_DisplayUpdated, false);
		
		setupGoalsHandler();
		setTimeout(handle_DisplayUpdated, 150);
	};

	function handle_GoalClick(evt)
	{
		var url, method;

		evt.stopPropagation();
		evt.preventDefault();

		if(evt.target.tagName == "INPUT")
		{
			url = evt.target.form.action;
			method = "POST";
			parameters =
			{
				player: evt.target.form.player.value,
				team: evt.target.form.team.value,
				goal: evt.target.form.goal.value
			}

			if(evt.target.form.owngoal.checked)
				parameters.owngoal = 1;

			new Ajax.Request(url,
			{
				method: method,
				parameters: parameters,
				onSuccess: handle_AjaxSuccess
			});
		} else
		{
			url = evt.target.href;
			method = "GET";
			new Ajax.Request(url,
			{
				method: method,
				onSuccess: handle_AjaxSuccess
			});
		}

		return false;
	};

	function handle_Message(evt)
	{
		
		console.log("handle_Message", evt);
	};

	function init()
	{
		console.log('init');
		extWindow = window.open("/greifmasters/cont/playtournament/display_output/display_output_800x600.php","GREIFMASTERS 2010","width=800, height=600, status=no, scrollbars=no, resizable=no");

		extWindow.addEventListener("message", handle_Message, false);

		document.addEventListener("DOMContentLoaded", handle_DOMReady, true);
		jQuery(function()
		{
			jQuery("#horn").bind("game-over", function()
			{
				this.play();
			});
		});

		jQuery(window).bind("timer-start", function()
		{
			updateRanking();
		});
	};

	function setupGoalsHandler()
	{
		var addDeleteGoal = document.getElementsByClassName('change_goal');
		for(var i = 0; i < addDeleteGoal.length; i++)
		{
			addDeleteGoal[i].addEventListener('click', handle_GoalClick, false);
		};
	};

	function updateRanking()
	{
	}

	init();
})()
