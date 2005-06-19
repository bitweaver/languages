<?php // -*- coding:utf-8 -*-
// parameters:
// lang=xx    : only tranlates language 'xx',
//              if not given all languages are translated
// comments   : generate all comments (equal to close&module)
// close      : look for similar strings that are already translated and
//              generate a comment if a 'match' is made
// module     : generate comments that describe in which .php and/or .tpl
//              module(s) a certain string was found (useful for checking
//              translations in context)
// patch      : looks for the file 'language.patch' in the same directory
//              as the corresponding language.php and overrides any strings
//              in language.php - good if a user does not agree with
//              some translations or if only changes are sent to the maintainer
// spelling   : generates a file 'spellcheck_me.txt' that contains the
//              words used in the translation. It is then easy to check this
//              file for spelling errors (corrections must be done in
//              'language.php, however)
// groupwrite : Sets the generated files permissions to allow the generated
//              language.php also be group writable. This is good for
//              translators if they do not have root access to tiki but
//              are in the same group as the webserver. Please remember
//              to have write access removed when translation is finished
//              for security reasons. (Run script again without this
//              parameter)
// Examples:
// http://www.neonchart.com/get_strings.php?lang=sv
// Will translate langauage 'sv' and (almost) avoiding comment generation

// http://www.neonchart.com/get_strings.php?lang=sv&comments
// Will translate langauage 'sv' and generate all possible comments.
// This is the most usefull mode when working on a translation.

// http://www.neonchart.com/get_strings.php?lang=sv&nohelp&nosections
// These options will only provide the minimal amout of comments.
// Usefull mode when preparing a translation for distribution.

// http://www.neonchart.com/get_strings.php?nohelp&nosections
// Prepare all languages for release 


$lang=Array(
// ### Start of unused words
// ### Please remove manually!
// ### N.B. Legitimate strings may be marked// ### as unused!
// ### Please see http://tikiwiki.org/tiki-index.php?page=UnusedWords for further info
"Your settings have been updated. <a href='tiki-admin.php?page=general'>Click here</a> or come back later see the changes. That is a known bug that will be fixed in the next release." => "Au fakanofoga ko oti ne fakatoka. <a href='tiki-admin.php?page=general'>Toko ikonei</a> io me toe asi fakamuli ifo ki fakamafuliga. Tena se fakalavelave e iloa kei ka fakalei ite patch ka fakatoka mai mua nei.",
"All Fields must be non empty" => "E tau o fakafonu a vaega katoa",
"You dont have permission to write the mapfile" => "Seai se taliaga ke tusi/fakamafuli ne koe te mapfile",
"You dont have permission to delete the mapfile" => "Seai sau taliaga ke solo ne koe te mapfile",
"You dont have permission to read the mapfile" => "Seai sau taliaga ke faitau ne koe te mapfile",
"This TikiWiki site is prepared for access from a lot of mobile devices, e.g. WAP\nphones, PDA's, i-mode devices and much more." => "Te TikiWiki site tenei ne fakatoka ke maua ne koe o sokotaki kiei mai mea pela mo WAP phones, PDA's, i-mode devices mo nisi aka.",
"You can browse this site on your mobile device by directing your device's browser\ntowards the following URL here on this site:" => "Ke fakatonu tau device's browser kite URL tenei ko te mea ke mafai o fakasokotaki ki te site tenei mai tau mobile device:",
"pageviews" => "pageviews",
"Invalid password.  You current password is required to change your email\naddress." => "Se te password.  Tau password nei e manakogina ke fuli tau e-mail address.",
"Twi" => "Gana Twi",
"Fatal error: nextActivity does not match any candidate in autorouting switch\nactivity" => "Fakalavelave fakamataku: nextActivity does not match any candidate in autorouting\nswitch activity",
"0" => "Automatically creates a link to the appropriate SourceForge object",
"Insert theme styled aligned box on wiki page" => "Faulu se theme styled aligned box\nite itulau ote wiki tenei",
"Reply to parent comment" => "Tali ki te matua ote fekau",
"compose message tpl" => "Tusi te fekau tpl",
"messages tpl" => "Fekau tpl",
"View articles" => "Onoono ki articles",
"Forward messages to this forum to this e-mail address, in a format that can be\nused for sending back to the inbound forum e-mail address" => "Ave a tusi e tusi kite forum \ntenei ki te e-mail address tenei, ite format tela e mafai o toe fakafoki iei kite inbound forum \ne-mail address",
"Older Messages" => "Message ko leva atu",
"Skip to Content" => "Lele ki Content",
"change email" => "fuli te email",
"change password" => "fuli te password",
"You are not permitted to edit someone else\\'s post!" => "Se talia koe ke fulifuli te post sua tino!",
"Name, path and start page are mandatory fields" => "Name, path mote start page e tau o faulu",
"You dont have permissions to edit banners" => "Seai sou taliaga ke fai ne fakamafuliga ki banners",
"You dont have permission to edit this banner" => "Seai sou taliaga ke fai ne fakamafuliga ki te banner tenei",
// ### end of unused words

// ### start of untranslated words
// ### uncomment value pairs as you translate
// ### end of untranslated words
// ###

// ###
// ### start of possibly untranslated words
// ###

"The page {\$mail_page} was changed by {\$mail_user} at {\$mail_date|bit_short_datetime}" => "The page {\$mail_page} was changed by {\$mail_user} at {\$mail_date|bit_short_datetime}",
"tiki-mobile.php" => "tiki-mobile.php",
// ###
// ### end of possibly untranslated words
// ###

"You do not have permission to use this feature." => "Seai sau taliaga ke  fakaoga te mea nei.",
"You must supply all the information, including title and year." => "E tau o tuku mai ne koe a fakamatalaga katoa fakatasi mote ulutala mote tausaga.",
"You do not have permission to use this feature" => "E seai sau taliaga ke fakaoga ne koe te mea nei",
"Czech" => "Gana Czech",
"Danish" => "Gana Danish",
"German" => "Gana Tiamani",
"English" => "Gana Palagi",
"Spanish" => "Gana Spanish",
"Greek" => "Gana Greek",
"French" => "Gana Falani",
"Italian" => "Gana Itali",
"Japanese" => "Gana Tiapani",
"Dutch" => "Gana Dutch",
"Norwegian" => "Gana Nouei",
"Polish" => "Gana Polish",
"Russian" => "Gana Lusia",
"Swedish" => "Gana Swedish",
"Chinese" => "Gana Saina",
"Fatal error: cannot execute automatic activity \$activityId" => "Fakalavelave fakamataku:\ncannot execute automatic activity \$activityId",
"Fatal error: setting next activity to an unexisting activity" => "Fakalavelave \nfakamataku: setting next activity to an unexisting activity",
"Fatal error: non-deterministic decision for autorouting activity" => "Fakalavelave\nfakamataku: non-deterministic decision for autorouting activity",
"Fatal error: trying to send an instance to an activity but no transition found" => "Fakalavelave fakamataku: trying to send an instance to an activity but no transition found",
"Process %d has been activated" => "Te process %d ko oti ne fakaola",
"Process %d has been deactivated" => "Te process %d ko oti ne fakagata",
"This feature is disabled" => "Te mae nei ko oti ne se fakagalue",
"Image Gallery" => "Gallery Ata",
"You are not logged in" => "Koe seki log in",
"Permission denied" => "Se avatu taliaga",
"Click to edit dynamic variable" => "Toko ikonei ke fuli a te dynamic variable",
"Update variables" => "Fakafoou te variables",
"Unknown language" => "Gana Fakatea",
"Include a page" => "Fakaopoopo fakatasi mai se itulau",
"Include an article" => "Fakaopoopo fakatasi mai se article",
"List all pages which link to specific pages" => "Fakaasi mai a itulau kola e isi \nfakasokoga ki ne nai itulau aka",
"Display Tiki objects that have not been categorized" => "Fakaasi a mea ote Tiki \nkola e siki fakasoa ki vaega",
"Displays a snippet of code" => "Fakaasi ne mu mea ote code",
"Search the titles of all pages in this wiki" => "Sala a ulutala o itulau katoa ite wiki nei\nin this wiki",
"No pages found for title search" => "Seai ne itulau e maua ite salaga ote ulutala nei",
"One page found for title search" => "E tasi te itulau e maua ite ulutala tenei",
" pages found for title search" => " itulau e maua ite ulutala tenei",
"Message will be sent to: " => "Fekau ka kave kia: ",
"No more messages" => "Ko seai aka ne fekau",
"No categories defined" => "Seai ne categories ko oti ne",
"Newest first" => "Meafoou ke mua",
"Oldest first" => "Meamua ke mua",
"new reply" => "tali foou",
"click on the map to zoom or pan, do not drag" => "Toko i luga ite mape ke zoom, pan, sa drag",
"you have requested to download the layer:" => "koe ne manako ke download te layer:",
"from\nthe mapfile:" => "mai te\nthe mapfile:",
"Here are the files to download, do not forget to rename them:" => "Konei a files ke download sa puli o toe fakaigoa:",
"stop monitoring this map" => "ko lava te monitor te map",
"You can view this map in your browser using" => "E mafai o matea ne koe te mape tenei i luga i tau browser ma fakaoga",
"of" => "o",
"DATE-of" => "o",
"Create Directory:" => "Faite Directory:",
"Create" => "Faite",
"Message Broadcast" => "Fekau fakapaa",
"Compose Message" => "Tusi te fekau",
"1" => "Strict allows page names with only letters, numbers, underscore, dash, period and\nsemicolon (dash, period and semicolon not allowed at the beginning and the end).",
"2" => "Displayed now for all eligible users even with personal assigned modules",
"remove" => "tapale",
"Maps" => "A mape",
"Monday" => "Aso Gafua",
"Tuesday" => "Aso Lua",
"Wednesday" => "Aso Tolu",
"Thursday" => "Aso Faa",
"Friday" => "Aso Lima",
"Saturday" => "Aso Ono",
"Sunday" => "Asosa",
"Your email could not be validated; make sure you email is correct and click register below." => "E se talia tau e-mail; onoono o toe fakataonu ko ko toko ei register mai lalo.",
"back to homepage" => "foki kite homepage",
"Please" => "Fakamolemole",
"No attachments for this page" => "Seai ne attachment ite itulau tenei",
"left/right" => "fakamaui/fakatamai",
"Tiki Calendar" => "Kalena Tiki",
"Contact Us" => "Fesokotaki kia matou",
"Disallow access to the site (except for those with permission)" => "Se fakatalia\nte ulu ki te site tenei(vagana e isi se taliaga)",
"Message to display when site is closed" => "Fekau ke fakaasi ma pono te site",
"Max average server load threshold in the last minute" => "Max average server load\nthreshold ite minute ko teka",
"Message to display when server is too busy" => "Fekau ke fakasae mafai koi fakalavelave\nte server",
"Store session data in database" => "Tausi te session data i loto ite database",
"Create a group for each user <br />(with the same\nname as the user)" => "Faite se mo user takitasi <br />(with the same\nname as the user)",
"full path to mapfiles" => "te auala katoatoa ki mapfiles",
"complete" => "Ko oti katoatoa",
"Users can subscribe/unsubscribe to this list" => "Tino fakaoga e mafai o subscribe/unsubscribe\nkite list tenei",
"Users can subscribe any email address" => "Tino fakaoga e mafai osubscribe sose email address",
"Validate email addresses" => "Fakamaoni te email addresses",
"Create/Edit External Wiki" => "Faite/fakamafuli External Wiki",
"no display" => "seai se mea e sae",
"Originating e-mail address for mails from this forum" => "Te e-mail address address e fakaasi\ni luga i meli e kave mai te forum tenei",
"EMail notifications" => "Fakailoga kite EMail",
"Any wiki page is changed" => "Sose wiki page e mafuli",
"show publish date" => "Fakaasi te aso ne faite iei",
"Edit Article" => "Fakasao te Article",
"Trash" => "Kaiga",
"Made with" => "Faite ite",
"Assign permissions" => "Fakatoka fakataliaga",
"Edit a topic" => "Fakatonutonu te ulutala",
"Choose a movie" => "Fili se movie",
"remove from this page" => "solo keatea mai te itulau tenei",
"remove from this structure" => "solo keatea mai te structure tenei",
"this page" => "te itulau tenei",
"this structure" => "te structure tenei",
"View Results" => "Onoono ki Results",
"no comments" => "seai ne comments",
"topics in this forum" => "Ulutala ite forum tenei",
"Select" => "Fili tenei",
"Show All" => "Fakaasi katoa",
"replied" => "Ko oti ne tali",
"The passwords don't match" => "Se pau te password",
"Password should be at least" => "Password e tau te aofaki mai iluga atu ite",
"characters long" => "mataimanu te loa",
"Your admin password has been changed" => "Tau password faka Admin ko oti ne fakamafuli",
"Group already exists" => "Group tenei e isi",
"No records were found. Check the file please!" => "Seai ne records ne maua. Toe onoono kite file fakamolemole!",
"User login is required" => "Tino fakaoga e mnakogina ke log in",
"Password is required" => "Manakogina te password",
"Email is required" => "Manakogina te e-mail",
"User already exists" => "Tino tenei ko leva ne iai",
"The passwords dont match" => "A password se pau",
"Password must contain both letters and numbers" => "Password e tau o aofia a mataimanu \nmo napa",
"Permission denied you cannot view this section" => "Taliaga se avatu ke pula koe ki te\nkogaa koga tenei",
"Unknown group" => "Te kulupu tenei se iloagina",
"Group doesnt exist" => "Te kulupu tenei e seai",
"User doesnt exist" => "Te tino tenei e seai",
"Permission denied you cannot edit this post" => "Se maua sou taliaga, e se mafai o fai ne fakamafuliga kite post tenei",
"No blogId specified" => "Seai sau blogId ne fakailoa",
"TOP" => "KI LUGA",
"Permission denied you cannot view this page" => "Taliaga se avatu ke \nonoono koe kite itulau tenei",
"Permission denied you can not view this section" => "Taliaga se avatu ke onoono koe ki te\nkogaa koga tenei",
"Permission denied you cannot remove images from this gallery" => "Taliaga se avatu ke  tapale ne koe a ata i loto i te gallery",
"Permission denied you cannot rotate images in this gallery" => "Taliaga se avatu ke \nfakamio ne koe a ata i loto i te gallery",
"Permission denied you cannot move images from this gallery" => "Taliaga se avatu ke \nfakagasue ne koe ata mai te gallery tenei",
"Permission denied you cannot view the calendar" => "Taliaga se avatu ke onoono koe \nki te Kalena",
"The passwords didn't match" => "A passwords e se pau",
"You can not use the same password again" => "E se mafai o toe fakaoga te password mua",
"Invalid old password" => "E se tau password mua",
"Permission denied to use this feature" => "Taliaga se avatu ke \nfakaoga ne koe te feature tenei",
"No channel indicated" => "Seai se channel ne fakailoa",
"No nickname indicated" => "Seai se nickname ne fakailoa",
"Message sent to" => "Fekau ne ave kia",
"Must enter a name to add a site" => "Faulu se igoa ke faopoopo se site",
"Must enter a url to add a site" => "Faulu se url ke faopoopo se site",
"Must select a category" => "Tau o fili se vaega (category)",
"Banner not found" => "Banner e se maua",
"Language created" => "Gana ko oti ne faite",
"No galleryId specified" => "Seai sau galleryId ne fakailoa",
"No forumId specified" => "Seai sau forumId ne fakailoa",
"You dont have permission to use this feature" => "Seai sau taliaga ke fakaoga ne koe te feature tenei",
"You do not have permissions to view the maps" => "Seai se taliaga ke onoono koe ki mape",
"mapfile name incorrect" => "Te igoa ote mapfile e se",
"This mapfile already exists" => "Te mapfile tenei ko leva ne isi",
"You do not have permissions to view the layers" => "Seai sau taliaga ke onoono koe ki layers",
"Could not upload the file" => "Se maua o upload te faila tenei",
"You do not have permissions to delete a file" => "Seai sau taliaga ke solo keatea a te faila",
"File not found" => "File se maua",
"You do not have permissions to create a directory" => "Seai sau taliaga ke faite se directory",
"The Directory is not empty" => "Te Directory nei koi isi ne mea i loto",
"You do not have permissions to delete a directory" => "E seai sau taliaga ke solo keatea ne koe a te directory",
"Welcome at Hawiki" => "Talofa i Hawiki",
"You are not permitted to remove someone else\\'s post!" => "E se talia ke fakaseai ne koe a te post ate suaa tino!",
"###end###"=>"###end###");
?>
