
This index.php file is a modification of the original index.php file that ships with ChatScript by Bruce Wilcox which you can obtain here:
http://sourceforge.net/projects/chatscript/

The TTS functionality was adapted from code located here:
http://stephenwalther.com/archive/2015/01/05/using-html5-speech-recognition-and-text-to-speech

Continuous Speech recognition was adapted from code located here:
https://github.com/GoogleChrome/webplatform-samples/tree/master/webspeechdemo

I made various styling and formatting changes to the appearance of the web page.

I have only tested this breifly in chrome Version 43.0.2357.132 m and it is still a work in progress.

I just replaced my existing index.php which on my Windows 7 laptop is located:
C:\inetpub\wwwroot\Chatbot\index.php

The voice recognition works best if you use a headset.

TTS voices can be modified by altering the following lines of code in the file:

function speak(text, callback) {
    var u = new SpeechSynthesisUtterance();
    u.text = text;
    u.lang = 'en-US';
    //u.lang = 'en-GB';
    u.voice = 3;   
    u.rate = .85;  
    u.pitch = .9;  
    u.volume = .5;  
...

Methods of wrtiting code to get a list of languages is discussed at the url:
http://stephenwalther.com/archive/2015/01/05/using-html5-speech-recognition-and-text-to-speech