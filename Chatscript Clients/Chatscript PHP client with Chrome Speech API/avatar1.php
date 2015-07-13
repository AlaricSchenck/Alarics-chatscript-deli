<!DOCTYPE HTML>
<html>
  <head>
    <title>
      CHATSCRIPT SERVER
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">

      #topPanel {
        min-width: 200px;
        min-height: 200px;
        width: 80vw;
        height: 50vh;
        overflow: auto;
        margin: 0px auto;
      }	
      #responseHolder {
        min-width: 200px;
        min-height: 200px;
        width: calc(100% - 240px);
        height: calc(100% - 20px);
        overflow: auto;
        margin: 0px auto;
        background-color: lightgrey;
	border-radius: 12px;
	padding: 10px;
	float: left;
	font-family: Arial;
	font-size: 12pt;
	font-style: normal;
	font-weight: normal;
        margin-right:3px;
	
      }
      #avatarHolder {
        height: 200px;
        width: 200px;       
        margin: 0px auto;
        background-color: darkgrey;
	border-radius: 12px;
	padding: 0px;
	float: right;
	font-family: Arial;
	font-size: 12pt;
	font-style: normal;
	font-weight: normal;
	}

      #formPanel {
	min-width: 200px;
	min-height: 200px;
	width: 80%;
        overflow: auto;
	margin: 0px auto;
        margin-top:5px;
	font-family: Arial;
	font-size: 10pt;
	font-style: normal;
	font-weight: normal;

      }
      #frmChat {
	min-width: 220px;
	min-height: 200px;
	width: 100%;
        overflow: auto;
	margin: 0px auto;


      }
      #formRow1 {
        margin-top: 10px;
        margin-bottom: 10px;
      }
      
      #txtUser {
	padding: 2px;
        float: none;
        
      }
      #txtMessage {
        width:100%;
	box-sizing:border-box;
	right-margin: 5px;
	padding: 2px;
	float: none;
      }
      #speechcontainer {
	min-width: 200px;
	min-height: 100px;
	margin-top: 5px;
        border-style: solid;
        border-width: 1px;
	border-radius: 12px;
	border-color: darkgrey;
	width: calc(100% - 22px);
	height: 100px;
	padding: 10px;
	font: Arial;
	font-size: 10pt;
	font-style: normal;
	font-weight: normal;
	color: black;
        float: left;
      }
      #button_panel {
        width: 80%;
      }
      #btnMicrophone { 
	margin: 10px;
	float: left;	
	}
      #results {
	font-family: cursive,Arial;
	font-size: 14pt;
	font-style: italic;
	font-weight: normal;
	color: darkgrey;
        margin: 10px;

      }
      #divautosend {
	margin-top: 5px;
        width: 100px;	
        float: left;
      }
      #divttsenabled {
	margin-top: 5px;
        width: 100px;	
        float: left;
      }
      .formRow {
	width: calc(100% - 10px);
        margin-top: 3px;
        margin-bottom: 3px;
        float: left;
      }
      .column1 {
        width: 60px; 
	float:left;
        margin: 2px;
        padding-top: 5px;    
      }
      .column2 {
       width: calc(100% - 160px);
       float: left;
       margin: 2px;       
      }
      .column3 {
       width: 80px;
       float: left;
       margin: 2px;  
       padding-top: 1px;
      }

    </style>
    <script type="text/javascript">
	var cbAutoSend = 'checked';
	var cbTTSEnabled = 'checked';
    </script>
  </head>
  <body>
    <div id="topPanel" >
      <div id="responseHolder"></div>
      <div id="avatarHolder">
          <img src="avatar1.jpg" alt="avatar image" height="200px" width="200px" style="border-radius: 12px;" > 
      </div>
    </div>
    <div id="formPanel">
    <form id="frmChat" action="#" > 
      <div class="formRow">
        Enter your message below:
      </div>
      <div class="formRow">
        <div class="column1">Name:</div>
        <div class="column2" ><input type="text" id="txtUser" name="user" size="10" value="Alaric" /></div>
        <div><input type="hidden" name="send" /></div>
      </div>
      <div class="formRow" >
        <div class="column1">Message:</div>
        <div class="column2" ><input type="text" name="message" id="txtMessage"  /></div>
	<div class="column3"><input type="submit" name="send" value="Send Value" /></div>
      </div>

      <!-----Added this section for Speech Recognition--------------------------------------------------->
 
      <div id="speechcontainer" >
  	<div id="info">Or click on the microphone icon and begin speaking.</div>
  	<div id="button_panel">
    	  <button id="btnMicrophone" type="button" value="microphone" onclick="microphoneClick()">
    	  <img id="start_img" src="mic.gif" alt="Start"></button> 
        </div>
        <div id="results">
          <span id="final_span" class="final"></span>
          <span id="interim_span" class="interim"></span><p>
        </div>
      </div>
	
    </form>
    <!------These checkboxes placed outside of the frmChat so they are not serialized and sent to the Chatscript server.------->
        <div id="divautosend">
		<input type="checkbox" name="autosend" value="checked" checked onclick="if (this.checked) {cbAutoSend = this.value} else { cbAutoSend = '' }"/> Autosend
        </div>
        <div id="divttsenabled">
		<input type="checkbox" name="TTSnabled" value="checked" checked onclick="if (this.checked) {cbTTSEnabled = this.value} else { cbTTSEnabled = '' }"/> TTS Enabled
    	</div>
    </div>
    <!--------------------------------------------------------------------------------------------------->

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">


var botName = 'Harry';		// change this to your bot name

// declare timer variables
var alarm = null;
var callback = null;
var loopback = null;

$(function(){
	$('#frmChat').submit(function(e){
	// this function overrides the form's submit() method, allowing us to use AJAX calls to communicate with the ChatScript server
	e.preventDefault();  // Prevent the default submit() method
	var name = $('#txtUser').val();
        if (name == '') {
		alert('Please provide your name.');
		document.getElementById('txtUser').focus();
         }
	var chatLog = $('#responseHolder').html();
	var youSaid = '<strong>' + name + ':</strong> ' + $('#txtMessage').val() + "<br>\n";
	update(youSaid);
	var data = $(this).serialize();
	sendMessage(data);
	$('#txtMessage').val('').focus();
	});


	// any user typing cancels loopback or callback for this round 
	$('#txtMessage').keypress(function(){
        window.clearInterval(loopback);
        window.clearTimeout(callback);
        });
		
});


function sendMessage(data){ //Sends inputs to the ChatScript server, and returns the response-  data - a JSON string of input information
$.ajax({
	url: 'ui.php',
	dataType: 'text',
	data: data,
    type: 'post',
    success: function(response){
		processResponse(parseCommands(response));
    },
    error: function(xhr, status, error){
		alert('oops? Status = ' + status + ', error message = ' + error + "\nResponse = " + xhr.responseText);
    }
  });
}


function parseCommands(response){ // Response is data from CS server. This processes OOB commands sent from the CS server returning the remaining response w/o oob commands

	var len  = response.length;
	var i = -1;
	while (++i < len )
	{
		if (response.charAt(i) == ' ' || response.charAt(i) == '\t') continue; // starting whitespace
		if (response.charAt(i) == '[') break;	// we have an oob starter
		return response;						// there is no oob data 
	}
	if ( i == len) return response; // no starter found
	var user = $('#txtUser').val();
     
	// walk string to find oob data and when ended return rest of string
	var start = 0;
	while (++i < len )
	{
		if (response.charAt(i) == ' ' || response.charAt(i) == ']') // separation
		{
			if (start != 0) // new oob chunk
			{
				var blob = response.slice(start,i);
				start = 0;

				var commandArr = blob.split('=');
				if (commandArr.length == 1) continue;	// failed to split left=right

				var command = commandArr[0]; // left side is command 
				var interval = (commandArr.length > 1) ? commandArr[1].trim() : -1; // right side is millisecond count
				if (interval == 0)  /* abort timeout item */
				{
					switch (command){
						case 'alarm':
							window.clearTimeout(alarm);
							alarm = null;
							break;
						case 'callback':
							window.clearTimeout(callback);
							callback = null;
							break;
						case 'loopback':
							window.clearInterval(loopback);
							loopback = null;
							break;
					}
				}
				else if (interval == -1) interval = -1; // do nothing
				else
				{
					var timeoutmsg = {user: user, send: true, message: '[' + command + ' ]'}; // send naked command if timer goes off 
					switch (command) {
						case 'alarm':
							alarm = setTimeout(function(){sendMessage(timeoutmsg );}, interval);
							break;
						case 'callback':
							callback = setTimeout(function(){sendMessage(timeoutmsg );}, interval);
							break;
						case 'loopback':
							loopback = setInterval(function(){sendMessage(timeoutmsg );}, interval);
							break;
					}
				}
			} // end new oob chunk
			if (response.charAt(i) == ']') return response.slice(i + 2); // return rest of string, skipping over space after ] 
		} // end if
		else if (start == 0) start = i;	// begin new text blob
	} // end while
	return response;	// should never get here
 }
 
function update(text){ // text is  HTML code to append to the 'chat log' div. This appends the input text to the response div
	var chatLog = $('#responseHolder').html();
	$('#responseHolder').html(chatLog + text);
	var rhd = $('#responseHolder');
	var h = rhd.get(0).scrollHeight;
	rhd.scrollTop(h);
}

// TTS code taken and modified from here:
// http://stephenwalther.com/archive/2015/01/05/using-html5-speech-recognition-and-text-to-speech
//---------------------------------------------------------------------------------------------------
// say a message
function speak(text, callback) {

    if ( cbTTSEnabled == 'checked' ) {

    	var u = new SpeechSynthesisUtterance();
	u.text = text;
    	u.lang = 'en-US';
    	//u.lang = 'en-GB';
    	u.voice = 3;   
    	u.rate = .85;  
    	u.pitch = .9;  
    	u.volume = .5;  
 
	u.onend = function () {
        	if (callback) {
            	callback();
        	}
	};
 
    	u.onerror = function (e) {
        	if (callback) {
            		callback(e);
        	}
    	};
 
    	speechSynthesis.speak(u);
    }
}
//-----End of TTS Code Block-----------------------------------------------------------------------------

function processResponse(response) { // given the final CS text, converts the parsed response from the CS server into HTML code for adding to the response holder div
	//response = replace('\n','<br>\n');
	//var botSaid = '<strong>' + botName + ':</strong> ' + response + "<br>\n";
	var botSaid = '<strong>' + botName + ':</strong> ' + response + "<br>\n";
	update(botSaid);
	speak(response);
}



// Continuous Speech recognition code taken and modified from here:
// https://github.com/GoogleChrome/webplatform-samples/tree/master/webspeechdemo
//----------------------------------------------------------------------------------------------------
var final_transcript = '';
var recognizing = false;
var ignore_onend;
var start_timestamp;

if (!('webkitSpeechRecognition' in window)) {
  info.innerHTML = "This will not work.  You need to use the Chrome browser. ";
} else {
  btnMicrophone.style.display = 'inline-block';
  var recognition = new webkitSpeechRecognition();
  recognition.continuous = true;
  recognition.interimResults = true;
  recognition.lang = 'en-US';
  recognition.onstart = function() {
    recognizing = true;
    info.innerHTML =  " Speak now.";
    start_img.src = 'mic-animate.gif';
  };

  recognition.onerror = function(event) {
    if (event.error == 'no-speech') {
      start_img.src = 'mic.gif';
      info.innerHTML = "You did not say anything.";
      ignore_onend = true;
    }
    if (event.error == 'audio-capture') {
      start_img.src = 'mic.gif';
      info.innerHTML = "You need a microphone.";
      ignore_onend = true;
    }
    if (event.error == 'not-allowed') {
      if (event.timeStamp - start_timestamp < 100) {
	//Added more detailed message to unblock access to microphone.
        info.innerHTML = " I am blocked. In Chrome go to settings. Click Advanced Settings at the bottom. Under Privacy click the Content Settings button. Under Media click Manage Exceptions Button. Remove this site from the blocked sites list. ";
      } else {
        info.innerHTML = "You did not click the allow button."
      }
      ignore_onend = true;
    }
  };

  recognition.onend = function() {
    recognizing = false;
    if (ignore_onend) {
      return;
    }
    start_img.src = 'mic.gif';
    if (!final_transcript) {
      info.innerHTML = "Click on the microphone icon and begin speaking.";
      return;
    }
    info.innerHTML = "";
   
  };

  recognition.onresult = function(event) {
    var interim_transcript = '';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        final_transcript += event.results[i][0].transcript;
	//----Added this section to integrate with Chatscript submit functionality-----
	processFinalTranscript(final_transcript);
	final_transcript ='';
	//-----------------------------------------------------------------------------
      } else {
        interim_transcript += event.results[i][0].transcript;
      }
    } 
    final_span.innerHTML = final_transcript;
    interim_span.innerHTML = interim_transcript;  
  };



}

function microphoneClick(event) {
  if (recognizing) {
    recognition.stop();
    return;
  }
  final_transcript = '';
  txtMessage.value = '';
  recognition.start();
  ignore_onend = false;
  final_span.innerHTML = '';
  interim_span.innerHTML = '';
  start_img.src = 'mic-slash.gif';
  info.innerHTML = " Click the Allow button above to enable your microphone.";
  start_timestamp = event.timeStamp;
  
}

function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function processFinalTranscript(transcript) {
	
	transcript = transcript.trim();	
	
	var lastWord = transcript.split(" ").slice(-1);

	if ( lastWord == 'cancel') { 
		final_span.innerHTML = '';
                interim_span.innerHTML = '';
		return; 
		}
	else {
		var lastLetter = transcript.slice(-1);
		var firstWord =  transcript.split(' ')[0];
		var punctuation = '.';
		if ( ['who','what','where','how','why','did','do','does','will','can', 'could','would','should','is','are','am','shall',			'whom'].indexOf(firstWord) > -1) { punctuation = '?'; }

		if ( ['.', '?', '!', ',',':',';'].indexOf(lastLetter ) < 0) { transcript += punctuation; }

		transcript = capitalize(transcript);

        	txtMessage.value = transcript;

		final_span.innerHTML = '';
        	interim_span.innerHTML = '';

		if (cbAutoSend == 'checked') { $('#frmChat').submit(); }

	}

}

//End of Continuous Speech Recognition Block
//----------------------------------------------------------------------------------------------------


</script>
</body>
</html>
