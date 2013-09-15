				Library "Help System"
					V1.5
			Copyright (C) 2003 - 2006 Richter

Introduction:
	This is library, which allow you quickly make a help system.
	Contains main help and context-dependent help. Not using DB, only files

Installation:
	Copy "lib_help_system.php" to server and use it like in "using_example"

Using:
	Context help:
		- create and adjust configuration file
		- fill "context_help.dat"
			Format of record of "context_help.dat":
				<ID of context help part>
				<Header>
				<Body>
				###
				<Next record>
		- call in script of context help a function "get_context_content()" for required context
		- now you can call this script from other scripts with function "get_context_href()"

	Main help:
		- fill "main_help_index.dat"
			Format of record of "main_help_index.dat":
				<Type: "sb", "se", "d">|<Title (for "sb", "d")>|<Name of file without extension (for "d")>
		- create data files. Files must be HTML-documents (can include PHP-code) with extension "php"
			Note that file "index.php" will first page of help
		- call in script of main help a functions "get_sections()", "get_content()"
		- now you can call this script from scripts with function "get_main_href()"

		Inadmissible to use "get_sections()" twice on one page!

License Agreement:
	This software is FREEWARE, delivered on principle "AS IS"
	Copyright - Richter (richter@wpdom.com)
	Additional information: http://sbs.wpdom.com

Requirements:
	PHP
	Windows or Unix

Versions History:
	V1.5	16.03.2006	+ Function "get_context_href()": "a"-block is
					improved and work without JavaScript also
				+ Variables "$main_add_parameters",
					"$context_add_parameters" is added
	V1.4	25.01.2006	* Function "require_once" replaced by "require"
					that will allow use several objects of
					help on same page
	V1.3	24.05.2005	- JS-function "toggle_submenu()" is corrected
					for work in Netscape Navigator and
					Mozilla Firefox
	V1.2	15.01.2005	+ Function "get_context_content()" is improved:
					added so named "suffix" in name of data
					file of context help. Variable
					"context_default_suffix" also added in
					class "Help_System"
	V1.1	20.09.2004	* Format of data file of context help is changed
	V1.0	29.08.2004	This is first release. Earlier known as module U18 for SBS WP