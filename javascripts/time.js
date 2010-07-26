var _currentSeconds=0;
var _FontSize=10;
var _AnzElm=0;
var _timerID=0,
    Sekunden;

function init() {
	_AnzElm = document.getElementById("Anzeige");
	jQuery.event.add(window, "game-over", function()
	{
		StopTimer();
	});
}

function SchriftGroesse(str_operator) {
	var newFontSize=0;
	eval("newFontSize = _FontSize" + str_operator + "1");
	_AnzElm.style.fontSize = newFontSize + "em";
	_FontSize = newFontSize;
}

function ResetText() {
	var h_container = document.getElementById("hr");
	var m_container = document.getElementById("min");
	var s_container = document.getElementById("sec");
	
	if (!isNaN(parseInt(h_container.value))) {
		Sekunden =  parseInt(h_container.value)*3600;
	} else {
		alert("Ungültige Stundenangabe!");
		return;
	}
	if (!isNaN(parseInt(m_container.value))) {
		Sekunden +=  parseInt(m_container.value)*60;
	} else {
		alert("Ungültige Minutenangabe!");
		return;
	}	
	if (!isNaN(parseInt(s_container.value))) {
		Sekunden +=  parseInt(s_container.value);
	} else {
		alert("Ungültige Sekundenangabe!");
		return;
	}

	SetCountdownText(Sekunden);
}

function StartTimer() {
	jQuery.event.trigger("timer-start");
	if (_timerID == 0) {
		ResetText();
		_timerID = window.setInterval(CountDownTick, 1000);
	}
}

function ResetTimer() {
	jQuery.event.trigger("timer-reset");
	ResetText();	
	_currentSeconds=0;
	StopTimer();
}

function StopTimer() {
	jQuery.event.trigger("timer-stop");
	if (_timerID > 0) {
		window.clearInterval(_timerID);
		_timerID = 0;
	}
}

function ContinueTimer() {
	jQuery.event.trigger("timer-continue");
	if (_timerID == 0) {
		_timerID = window.setInterval("CountDownTick()", 1000);
	}
}

function CountDownTick() {
	if(_currentSeconds == 0)
		jQuery.event.trigger("game-over");

	if (_currentSeconds <= 0) {
		StopTimer();
		return;
	}
	
	SetCountdownText(_currentSeconds-1);
}

function SetCountdownText(seconds, elem) {
	_currentSeconds = seconds;
	var minutes=parseInt(seconds/60);
	seconds = (seconds%60);
	var hours=parseInt(minutes/60);
	minutes = (minutes%60);
	var strText = AddNull(minutes) + ":" + AddNull(seconds);
	if(!elem)
		document.getElementById('Anzeige').innerHTML = strText;
	else
		elem.innerHTML = strText;
}

function AddNull(num) {
	return ((num >= 0)&&(num < 10))?"0"+num:num+"";
} 

function MM_goToURL() {
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function toggleHelp() {
	var helpAnz = document.getElementById('helptext');
	if (helpAnz.style.visibility=='hidden') {
		helpAnz.style.visibility='visible';
	} else {
		helpAnz.style.visibility='hidden';
	}
}
