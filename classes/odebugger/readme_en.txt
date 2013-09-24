[PHP5] ODEBUGGER PACKAGE

THis package is a debugging and helper tool.
It overrides the errors and exceptions handling by PHP.
Errors are generated, even if error_reporting is set to 0.
Errors are translated in a more comprehensive way, and hints for a correction is displayed.
Errors can be displayed realtime, and/or logged in an XML file.
This tool can be used by beginners, because it gives them a more comprehensive error message, and hint to debug their code. Gurus can
personalize it to fit their needs.

It's easy to use, you can find some examples in all the indexN.php pages.

Version 20060612

- Localized in : French, English (ENglish being the default language)
- Many errors translated and hinted
- Error types translated
- 2 different kinds of display : the Realtime mode, and the Stats mode.
- Easyly configurable : translations, new error messages, hints, display and so on.



HOW TO :
* How to call the debugger : 

$oDebugger = new odebugger ('EN');

Where 'EN' is the chosen language. 
Check the 'xml/' folder to see which languages are currently supported.
English being the default language, you can call the debugger this way, too, for English :
$oDebugger = new odebugger;

* How to add a new language :
In the xml/ folder, you can find surbolders. Each one contains the XML files for a different language.
'EN/' => English
'FR/' => French.
If you want to add, for example, German, just create a 'GE/' subfolder, and copy both the xml files :
errors.xml and types.xml into the new folder.
Then, edit them.
All you have to do is change the <translation> and <suggestion> nodes in the XML files.
And that's it!
You can then call the debugger in German :
$oDebugger = new odebugger ('GE');

How to add a new error :
Well, just edit the chose language errors.xml file (xml/LANGUAGE/errors.xml), and copy/paste
a node within the <errors></errors> root node. It must follow the others:
<error>
	<label>Undefined index:</label>
	<translation>An index has been used without being defined</translation>
	<suggestion>Check the max and min limits of your array</suggestion>
</error>

Just change the values, save the file, and that's it.
You can, of course, also change an existing node, if you do not like my translations/suggestions ;-)

* How to change the display:
Well, there is currently 2 types of display : realtime, and stats.
IN the folder 'templates/', you can find some files. For example :
default.dat
default_log.dat

default.dat is the default realtime display HTML template, while default_log.dat is the default stat HTML template.
You can create your own, of course. The information supplied by odebugger replace the {INFO_NAME} types of string.
Just make sure you put all the information you want in your templates :-)
For the stats template, there is a slight difference : it has 3 parts.
The first one starts from the...start, and ends on : <--! LINES HERE -->.
This part is fixed. These are the headers!

Then, between <--! LINES HERE -->. and <!-- STATS -->, the logs will be displayed. And of course, the lines here
will be repeated as many times as you have lines in your log.
Then, after <!-- STATS -->, you have your stats :-)

You can set new templates with :
odebugger::HTML 
and
odebugger::HTMLLOG
properties. See the part of this documentation about the OPTIONS.

In the 'css/' folder, you can also find files. These are the CSS files used to modify the HTML templates.
default.dat being the CSS for the default.dat HTML template.
default_log.dat being the CSS for the default_log.dat HTML template.
You can also, of course, set them :
odebugger::CSS 
and
odebugger::CSSLOG



OPTIONS:
Syntax :
$oDebugger -> {OPTION} = {VALEUR};
Foir example :
$oDebugger -> LINES = 2;

odebugger::LINES => integer : gives the number of source code lines to be displayed before and after the error line
default value : 2

odebugger::HTML => string with the name of the file for the HTML template, in the 'templates/' folder, without its extension. 
Used to display the realtime log.
default value : 'default'

odebugger::CSS => string with the name of the file for the CSS template, in the 'css/' folder, without its extension. 
Used to transform the HTML template for realtime log.
default value : 'default'

odebugger::HTMLLOG => string with the name of the file for the HTML template, in the 'templates/' folder, without its extension. 
Used to display the stats log.
default value : 'default_log'

odebugger::CSSLOG => string with the name of the file for the CSS template, in the 'css/' folder, without its extension. 
Used to transform the HTML template for stats log.
default value : 'default_log'

odebugger::REALTIME => boolean : true or false. Activate or de-activate the realtime mode (errors are displayed realtime)
default value : true

odebugger::LOGFILE => boolean : true or false. Activate or de-activate the saving of the log into an xml files (in 'logs/'). These can be displayed via odebugger::showLog () method, and loaded
with the odebugger::loadXML () method.
default value : true

odebugger::ERROR => Boolean : true or false. Activate or de-activate the errors handling.
default value : true

odebugger::EXCEPTION => Boolean : true or false. Activate or de-activate the exceptions handling.
default value : true



METHODS (the ones you can call only) :

odebugger::checkCode (string sString)
Used to check if there are any errors in a string (usually used by retrieving in a string the content of a file. See index3.php to see that in action).

odebugger::loadXML (string sFile)
Used to get an existing log from a file (logs are stored in the 'logs/' folder).
This method erase any previous log (realtime or not).

odebugger::showAll ()
Used to display the whole current log, just as if it was in realtime mode. You can display a loaded log, or the current realtime log.

odebugger::showLog ()
Used to display the whole current log in stats mode. You can display a loaded log, or the current realtime log.

odebugger::saveToFile (optional string sFile)
Used to save the current log to a file. This methods is used automatically when the script ends, if odebugger::LOGFILE is set to true.
But it can be called manually, with a filename.