
   <li><a href="#requirements">Requirements</a></li>
   <li><a href="#installation">Installation</a></li>
   <li><a href="#loginscreen">Login Screen</a></li>
   <li><a href="#configure">Configuration</a></li>
   <li><a href="#mainscreen">Main Screen</a></li>
   <li><a href="#editusers">Edit Users</a></li>
   <li><a href="#deleteusers">Delete Users</a></li>
   <li><a href="#addalist">Add a List</a></li>
   <li><a href="#addsubs">Add Subscribers</a></li>
   <li><a href="#editresps1">Edit Responder List</a></li>
   <li><a href="#delresps">Delete a Responder</a></li>
   <li><a href="#mailbursts">Mailbursts</a></li>
   <li><a href="#createburst">Create a Burst</a></li>
   <li><a href="#deletebursts">Delete a Burst</a></li>
   <li><a href="#editbursts">Edit Bursts</a></li>
   <li><a href="#editresps2">Edit a Responder</a></li>
   <li><a href="#editrespmsgs">Edit Responder Messages</a></li>
   <li><a href="#codeit">Code-it</a></li>
   <li><a href="#bulkadd">Bulk Add</a></li>
   <li><a href="#addusers">Add Subscribers</a></li>
   <li><a href="#blacklist">Blacklist</a></li>
   <li><a href="#tools">Tools</a></li>
   <li><a href="#bouncers">Bouncers</a></li>
   <li><a href="#regexps">Bouncer Regexps</a></li>
   <li><a href="#templates">Templates</a></li>
   <li><a href="#customfields">Custom Fields</a></li>
   <li><a href="#tags">Message Tags</a></li>
   <li><a href="#sendmails.php">Sendmails.php</a></li>
   <li><a href="#checkers">Bounce and Mail Checker</a></li>
   <li><a href="#remotesub">Remove Subscription Handling</a></li>
   <li><a href="#copyright">License and Copyrights</a></li>
   <li><a href="#support">Getting Help</a></li>
   <li><a href="#custommods">Custom Changes & Additions</a></li>
   <li><a href="#spamtips">Tips for Avoiding Spam Filters</a></li>
   <li><a href="#theend">The End...</a></li>
</ol>

<div id="manual_requirements" style="display:none;">
<p>Requirements</p>
<p>You will need MySQL and PHP and a way to handle external tasks. Later there is a special section of this file dedicated to setting up a *nix crontab. That is the program I recommend for this task scheduling, but you can use any service that you find if it'll do the job.</p>

<p>For this you will need:<br />
A web server (Apache or IIS)<br />
PHP 4.3 or greater (the 5.x series seems to work fine)<br />
MySQL 4 or greater (MySQL 5 is highly recommended)</p>


<div id="manual_installation" style="display:none;">
<p>Install process</p>

<p>
<em>Note:</em> I do offer professional installations of this package for $30 provided that you have the required system (PHP 4+, MySQL 4+). I know that a lot of people won't need this, and that's fine... but given how cheap I'm making it there's no reason to teach yourself MySQL and PHP just to install it. Your time is valuable, use it wisely.
</p>

<p>Installing this app is pretty straight forward. As with any php program that needs database access you first need to set up your database. You can use a previously existing DB if you want, but only 1 copy of Infinite Responder can run per database. Otherwise simply create a new DB, setup a user (user and password) and assign the user to the newly created database. The user needs permission to create, insert, delete, alter and create tables.</p>

<p>After the database is created unpack the Infinite Responder zip file into a directory on your hard drive. Edit config.php and put in the database and user information there. Save the file and upload all of the files to your server, retaining directory structure (there needs to be a templates, images and jscripts folder w/ all of the same subfolders and all of the files in the right subfolders).</p>

<p>Once the files are on the server go to:<br />
http://yourdomain.com/respdir/admin.php</p>

<p>And it'll automatically create the tables you need and populate them with starting data. It should immediately direct you to the config screen where you can change various settings.</p>



CRON

<p>Now that the app is installed you need to setup a scheduler to run sendmails.php on a regular basis. If you don't have access to crontab you can use an 3rd party scheduler service or attach sendmails.php to another page with an include(). Either way, you will need to have this run on a regular basis.</p>

<p>Setting up the crontab:<br />
Crontab is an program that runs the background of most unix servers. All it does it wait for timing instructions and runs things according to the schedule. You can change your scheduled crontabs by running.</p>

<p>crontab -e</p>

<p>From a *nix command line. Also, a lot of hosts offer a crontab utility that gives you access to the crontab from a control panel. Setting up a crontab isn't simple if you have no unix experience. It's doubly difficult as the standard editor is VI, a very complex editor that is difficult for beginners to learn.</p>

<p>If you have MySQL and PHP on your server I offer custom installations for only $30.</p>

<p>
Once you get into the crontab edit you need to figure out 4 things:<br />
How often do you want it ran?<br />
How do you want to run it?<br />
And where is the file you want to run?<br />
Where do you want output to go?<br />
<p>

<p>
1)<br />
The first is the most complex. There are 5 time entries to crontab. The last 3 are day settings, and as they're not often enough for this script we're going to leave them as just *'s.
</p>

<p>This leaves you with:<br />
minutes hours * * *</p>

<p>Minutes is the minutes that you want to run the script on. Hours is the hours.</p>

<p>Lets say you want to run the script at 3:30 every morning:<br />
30 3 * * *</p>

<p>30 minutes at 3 o'clock, every day.</p>

<p>If you only want to run it every hour, do this:<br />
0 1-24 * * *</p>

<p>That's at the zero minute marker of every hour.</p>

<p>Some people suggest that you run it constantly with:<br />
* * * * *</p>

<p>But in my experience this risks putting a high load on your server if you have a lot users, messages, responders or mails to sort thru. There are 1440 minutes in a day, there is no reason to run it this script 1440 times per day.</p>

<p>Most of the time 10 minute intrevals are enough:<br />
00,10,20,30,40,50 * * * * </p>

<p>That only runs it 144 times per day, which should be enough and not put too much stress on the machine.</p>

<p>If you've got a small list or need to check things more often try this:<br />
0,5,10,15,20,25,30,35,40,45,50,55 * * * *</p>

<p>While that's a big long, it runs the script every 5 minutes. That's 12 times an hour or 288 times per day. </p>

<p>2)<br />
The second thing you need to know is how you're going to call the script. You can set up a seperate shell script or CGI wrapper if you need to, but again... if you don't have a lot of unix experience then doing this would be very time consuming.</p>

<p>You can call the PHP file directly by calling PHP. Depending on how crontab is ran, you may be able to do this by just using:<br />
PHP sendmails.php</p>

<p>But that's not likely. You can also use lynx if you have it available with:</br>
lynx -dump http://www.yourdomain.com/responder/sendmails.php</p>

<p>That works very well, but it does take some time to load lynx. This isn't enough to stop you on a small list, but on a big list... or on a server without lynx, you'll need to do it another way.</p>

<p>The easiest and quickest way is to call PHP by it's complete path name with:<br />
/usr/local/bin/php sendmails.php</p>

<p>Again, that will depend on where your php is. You can find either lynx or php with the whereis command.</p>

<p>Just type:<br />
whereis php<br />
or<br />
whereis lynx<p>

<p>From the command line. If you don't have whereis then ask your admin or tech support.</p>

<p>3)<br />
Where the file you're running is. This is important because cron won't run things from the directory you want it to. It needs the full path of the filename in almost every setup. This isn't a problem. You can get the name of full system path of the install from the first line in the config menu.</p>

<p>It'll look like:<br />
/home/user/www/responder</p>

<p>Then just tack on the name of the script at the end like this:<br />
/home/user/www/responder/sendmails.php</p>

<p>Simple enough.</p>

<p>4)<br />
Now, where do you want output to go? By default, most systems will send it to your email address. You don't want this. Why? Because you'll get an email each and every time it runs. Do you want 300 emails per day telling you that it actually ran your crontab? Yea. I wouldn't either.</p>

<p>At the end of the filename this: <br />
 > /home/user/www/responder/cron.log</p>

<p>And all information will be sent to cron.log Or, if you don't want to use a file (I wouldn't, it takes up space) just send it to a special "black hole" file.<br />
 > /dev/null</p>

<p>Putting it all together:<br />
Now just add all of it together.</p>

<p>0,5,10,15,20,25,30,35,40,45,50,55 * * * * /usr/local/bin/php /home/user/www/responder/sendmails.php > /dev/null</p>

<p>That runs your script thru PHP every 5 minutes and drops the the output into the great void.</p>

<p>A convenient resouce for this can be found at:<br />
<A HREF="http://htmlbasix.com/crontab.shtml" target="_blank">http://htmlbasix.com/crontab.shtml</A></p>






<div id="manual_configure" style="display:none;">
<p>Configure</p>
<p>This has various configuration options.</p>

<p><strong>Max sends per sendmails run:</strong> In order to send email you need to have sendmails.php ran on a frequent basis. This script is what processes the queue and sends stuff out. This option  allows you to crank up (or down) the number of messages to process and send per run. This script is pretty efficient in high numbers as most of the data is pre-cached at the start of the program. Still if you're experiencing timeouts then set this number lower. I usually run between 200 and 500, depending on how many other people use the server. A shared server might only want 200, a dedicated might be able to handle 1000 or more.</p>

<p><strong>Daily send limit:</strong> Daily throttle for hosts that have one. You should probably set the throttle just below your host's limit so you can still send emails normally. Example: If you can only send 1000 a day, set it to 900, etc.</p>

<p><strong>Inactivity trim:</strong> Various actions update a user's "last activity" setting. This setting isn't very useful for large newsletter lists, but responder lists or lists where current activity is more important than size can benefit greatly from trimming old, inactive, users. This setting is in months and can be anything from 1 to 9999 or higher. So you can set multiple years by using larger month numbers.</p>

<p><strong>Charset:</strong> This allows you to change the system's charset. Unfortunately php's support of extended multibyte charsets is still a bit lacking, so some sets like korean or japanese might not work correctly. Still, latin-based languages like english, french, spanish, german, and others (sorry if your's isn't listed, but the list is long) should work fine with UTF-8. I strongly suggest UTF-8 as the database is now coded to use it as the default.</p>

<p><strong>Check mail on sendmails.php:</strong> One way or another, if you want to use mail-based subscriptions, you need to run mailchecker. If you never plan to use them, then you don't need to run it. If you do want to use them but need sendmails.php to run as fast as possible you can either run mailchecker manually thru the tools option or set a seperate crontab for it. Turning this on makes the process automatic, but does so at the price of increasing the work load during a sendmails.php call. If you've got a big email list set this to no, it'll probably let you send your bursts out quicker.</p>

<p><strong>Check bounces on sendmails.php</strong> Similar to mailchecker except it also runs the bounce checker too. Good for small lists and easy automation, bad for large lists when you need to streamline your sendmails.php call. Turn it off and run manually or with a seperate crontab, or keep it on for simplicity. Up to you.</p>

<p><strong>Autocall sendmails.php on subscribe:</strong> This will call sendmails.php when a user subscribes. The downside is added server load. If you're concerned about the number of times it's called per hour and you have a lot of subscribers coming in this can overload a server. On the upside it's nice to have if you're sending out 0-minute messages. If enabled this'll make a 0-minute message behave exactly like another welcome message, if disabled the subscriber will have to wait until sendmails.php is called before they can get that message.</p>

<p><strong>Lines on the subscriber add page:</strong> You can add subscribers with this option. This lets you set the number of subscribers you can add at a time.</p>

<p><strong>Subscribers per page:</strong> Controls the page flow of the user list. Set it small or set it high. Up to you.</p>

<p><strong>Site code:</strong> If you've purchased a seperate license you'll be given a code that can disable the promotional banners at the bottom and in your unsub links. Disabling these messages without an appropriate license may effect your ability to receive support.</p>

<p><strong>Admin username/pass:</strong> Simple enough. Set this to whatever you want. Change as often as you want.</p>

<p><strong>Enable TinyMCE:</strong> TinyMCE is a stand-alone plugin designed by Moxiecode. It's under a seperate license (LGPL) and can be enabled or disabled. It's the HTML editor that's used in the various html areas. Disabling this will convert those areas to simple textareas instead of active html areas. I tend to like the html editor, but if you're operating under a stricter licensing situation and don't want to pay for a seperate tinyMCE license then you may need to disable this.</p>

<p>


<div id="manual_mainscreen" style="display:none;">
<p>The main screen</p>
<p>This is the "Edit users" screen. It's a list of responders. If you click on "edit users" you'll be taken to that responder's user list and be able to edit them.</p>

<p>


<div id="manual_editusers" style="display:none;">
<p>Edit users</p>
<p>Here is a list of the users for that responder. You'll see the email address, their subscriber ID and the name of the responder they're subscribed to. Here you can page thru the list, add a bulk list of users or add a smaller list with add subscriber.</p>

<p>


<p>The user edit screen</p>
<p>Click on the pen. Here you are presented with various subcriber options. At the bottom you can edit custom field data. This is self-explanatory, first name, last name, email, html, IP addy, etc. The unique code shouldn't be changed unless you know what you're doing, a unique code is generated for every user as part of the subscription process Also, here you can resend confirm messages, reset the user's join timestamp or resend responder messages.</p>

<p>


<div id="manual_deleteusers" style="display:none;">
<p>The delete user screen</p>
<p>Click on the trash can. Here you are presented with various details of the user and asked to confirm whether you really want them gone. Deletes are permanent and cannot be undone.</p>

<p>


<div id="manual_addalist" style="display:none;">
<p>Add a list</p>
<p>A simple comma spliced list, addy@domain1.com, addy@domain2.com, etc. Select whether or not they should receive HTML email, or upload a csv file.</p>

<p>


<div id="manual_addsubs" style="display:none;">
<p>Add a subscriber</p>
<p>This shows a small set of rows for adding subscribers. Email address, html, first name and last name can be set here.</p>

<p>


<div id="manual_editresps1" style="display:none;">
<p>Responders</p>
<p>This allows to edit the responders themselves. Here you can send a mail burst, edit the responder details, add new responder-style messages or delete the responder completely.</p>

<p>


<div id="manual_delresps" style="display:none;">
<p>Delete a responder</p>
<p>The trash can deletes the responder. Again, this cannot be undone. Confirm if you're sure.</p>

<p>


<div id="manual_mailbursts" style="display:none;">
<p>Mail bursts</p>
<p>The envelope icon takes you to mail bursts. You'll see the list of any bursts you've sent. From this list you can edit an existing burst or delete an old burst. These messages are added to a cache and sent over time. At the bottom-right you'll see where you can create a new burst. The pen icon edits, the trash icon deletes.</p>

<p>


<div id="manual_createburst" style="display:none;">
<p>Create a new burst</p>
<p>The tag reference at the top-right is a list of tags you can use during the message. These are variable run-time tags that allow you to customize messages.</p>

<p>Here you add a subject, a text version and an html version. If you've enabled tinyMCE from the configuration you'll be able to use the html editor to help compose the message.</p>

<p>At the bottom you'll see the scheduler. You can preschedule messages to start whenever you want. If you're running an offer you want broadcasted at a specific time, well that's how you do it. One important detail is that the email is cached whenever you create the message, so subscribers that happen after it's cached may not receive the email. Still, if you're going to be busy and want the message to go out on-time, it's a great way to do it. The time option uses a form of military time. Hours:Minutes using a 24 hour format.</p>

<p>


<div id="manual_deletebursts" style="display:none;">
<p>Delete a burst</p>
<p>Same as before. It presents details. Cannot be undone. Confirm if you're sure. If you delete a burst any messages that haven't gone out yet are stopped.</p>

<p>


<div id="manual_editbursts" style="display:none;">
<p>Edit a burst</p>
<p>Same as before. It presents fields that you can change. These changes occur to the message, any that haven't been sent out yet will be changed. Obviously you can't edit a message once it's been delivered. At the bottom you can deactivate a message without deleting it. This will stop it from being sent any further, but keep it in the queue incase you want to reactivate it at a later date. You'll see the message queue's progress at the bottom, this will tell you how far along the burst is.</p>

<p>


<div id="manual_editresps2" style="display:none;">
<p>Edit a responder</p>
<p>Either from the edit resps list or from the "edit responder messages" you can get to the edit responder screen. If you just want to zoom down to the message list, which appears at the bottom of this screen, you can click on the link at the top.</p>

<p>In the responder screen you can set the name of the responder. You can set the opt-in level to single or double. You can instruct the system to send a notification to the owner when someone joins or leaves. You can set the name of the owner, and both the owner's email and the reply-to email.</p>

<p>The description is an HTML-capable field that's used to describe the responder on list.php or using the description tag.</p>

<p>Below that you have 2 opt redirects. This allows you to redirect to a different URL after a successful opt-in or opt-out. This is especially useful when creating squeeze pages. Below that you have 2 confirmation pages. These are html-capable areas that are presented to the user after they're sent a confirmation code. This allows responder-level changes, if you leave these fields blank the system will default the global confirmation templates. You don't need to use these, but you can if you want a more fine-grained control over these messages.</p>

<p>At the bottom, before the message list, you can download all custom data for this responder in a csv file.</p>

<p>You can also edit the POP3 details for mailchecker. This allows you to setup email-based  subscriptions. When someone sends an email to this account it will start a subscription process for them. Despite the name it also supports imap if you want to use that. This area uses the imap() routines in php so you'll need those compiled. There are various related options. The spam header is particularly nice if the address has spamassassin running. The system will ignore these messages and not subscribe them.</p>

<p>Note: It's usually good practice to use an un-used email address for this. Unless you have a specific reason not to, it's best to delete the messages after they're checked. Otherwise these messages will need to be checked every time it connects, slowing your system down and perhaps re-adding users that have unsubscribed. Unless you have another system checking and clearing this mailbox, make sure delete is on.</p>

<p>


<div id="manual_editrespmsgs" style="display:none;">
<p>Edit responder messages</p>
<p>At the bottom of the edit responder screen is where you add or edit responder-style messages. Same as before, trashcan = delete, pen = edit. Changes cannot be undone, so be sure before you save or confirm a delete.</p>

<p>Most of this is self-explanatory. Subject, text version and html version. Towards the bottom are 2 different timing options.</p>

<p>For the most part you'll want sequential timing. This is how sequential responders are done. If you want the message to go out 1 day after they subscribe simply put "1" in the days column. A 0 minute message will be set to send as soon as they subscribe, so you can send specific custom welcome messages that way. You can set messages months in advance if you want.</p>

<p>Then there's absolute timing. Absolute timing adds to sequential timing by re-positioning the timer at a specific moment of that day. For instance if you want a message to be set for the wednesday of the week after they join, you can do that here. You'd set the weeks in sequential to 1, and then set the day to "wednesday" and it'll be set for then. Here you can specify a day, if you do it'll re-position the minutes and hours to midnite so, for example, you can schedule a message to go out on Friday at 8pm, 1 month after their join.</p>

<p>Save when you're ready. Again, tag reference at the top to help you use tags in your messages.</p>

<p>Creating a new responder message follows the same pattern.</p>

<p>


<div id="manual_codeit" style="display:none;">
<p>The Code-it dialog</p>
<p>This allows you to make a quick-n-easy subscription form. It's a simple matter, just pull down and code-it. Down below you can even do a custom code-it. If you change the custom fields you can change the custom code-it template to match if you want. Subscription forms are just that, a simple form. You don't need to use this option but you can if you want. I usually use it as a base, then tweak the colors to fit the site.</p>

<p>


<div id="manual_bulkadd" style="display:none;">
<p>Bulk add</p>
<p>A simple comma spliced list, addy@domain1.com, addy@domain2.com, etc. Select whether or not they should receive HTML email, or upload a csv file.</p>

<p>


<div id="manual_addusers" style="display:none;">
<p>Add users</p>
<p>This shows a small set of rows for adding subscribers. Email address, html, first name and last name can be set here.</p>

<p>


<div id="manual_blacklist" style="display:none;">
<p>Blacklist</p>
<p>Blacklisted users cannot subscribe to any of the lists on your system. Use this if someone is causing trouble, or if they've requested to be removed from all your lists. If you add someone to the blacklist their address will be automatically deleted from all lists on your system. Blacklisted users cannot be added manually or in bulk, nor can they subscribe via form or email.</p>

<p>


<div id="manual_tools" style="display:none;">
<p>Tools</p>
<p>Allows you to run manually run sendmails, bouncechecker or mailchecker. I may add other tools to this area in the future.</p>

<p>


<div id="manual_bouncers" style="display:none;">
<p>Bouncers</p>
<p>Bouncers handle bouncing emails. They aren't assigned to any specific responder (a bad address is a bad address, regardless of which list it's on) but are assigned to specific system email addresses. At the bottom you can add a new bouncer, the pulldown will contain a list of owner and reply-to emails that aren't currently assigned. You can either select one, or select "other address" and add your own.</p>

<p>On the next screen you set the various options. You can set the delete level (clear bounces is the default), you can set notify (it'll send a notify to the assigned email) so that it'll tell you when it removes someone, you can set a spam header to ignore. The rest is fairly self-explanatory.</p>

<p><em>Note:</em> setting a username it's usually good to use the full email address as your username, ex: myuser@mydomain.com. Most systems work best this way. Consult your host's helpdesk or FAQ for more information.</p>

<p>


<div id="manual_regexps" style="display:none;">
<p>Add a regexp</p>
<p>At the top, right, below the "logout" is a "Regexp rules" button. This is where you add regexps.</p>

<p>All regular expression are set case-insensitive and multi-line, so you only need to add the pattern. This is the bouncer rules area. Here you add perl-compat regular expression rules to detect and remove bounced addresses. If you know perl regexp you can add your own. If not, well we have an area in the forums for this. I'll also distribute new regexps as time goes by so you can keep your list up to date without the headache.</p>

<p>This is a very powerful rule system and can allow you to match some very complex bounces. The system will automatically try to detect the bounced address from the list by looking for the first email address in the bounced message. If the bounce message doesn't contain the bounced address then don't make a rule for it, there's no point since the system can't remove anything.</p>

<p>


<div id="manual_templates" style="display:none;">
<p>The templating system</p>
<p>I'm not using any complex template systems, the files in /templates are merely php snippets. Mostly html, but some php code at the top to prepare the options. Here you can change the layout and presentation of any part of the script. I've begun migrating to CSS, so many things can be tweaked by changing the main.css file. The files are named by their location and what file they're attached to, for instance "create.responders.php" is the template for the "create a responder" screen in responders.php.</p>

<p>


<div id="manual_customfields" style="display:none;">
<p>Custom fields</p>
<p>The custom field system isn't quite where I want it to be, but it works. In the next major version I'm going to implement a better interface, but for now it's defined by the rows in your custom fields table. Adding new rows creates new fields named after the row. If you want to refer to their tags you can do so by %cf_fieldname% where fieldname is the name of the field in the custom fields table.</p>

<p>


<div id="manual_tags" style="display:none;">
<p>Tags</p>
<p>The tag list is available in tagref.html. There are numerous ways to customize your messages. For instance if you want a simple "hello firstname" line you'd do:<br />
Hello %subr_firstname%</p>

<p>Pretty straight-forward. These tags are interpreted inside of the subject line, text and html messages for both responder-style messages and newsletter-style mailbursts.</p>

<p>A new tag that was added recently was the "referralsource" tag %subr_referralsource%. You can provide a referral source using "ref" in the subscription form. This is a great way to test co-reg effectiveness, ezine solos, etc. Or you can use it as part of your affiliate marketing campaign. It's a simple matter to put a hoplink's ?hop information in there so you can track which affiliates are providing the best results. You can even use this to rebrand the affiliate links in your messages so your affiliates can get paid for their hard work.</p>

<p>


<div id="manual_sendmails.php" style="display:none;">
<p>Sendmails.php</p>
<p>This script needs to be called on a regular basis. You can do this by setting up a crontab, using an outside scheduler service or by attaching it to one of your pages via an include(). The crontab is probably the most reliable and is the one I recommend, but there are plenty of other options.</p>

<p>When sendmails.php runs it will pre-load most of the data it needs. This reduces the number of database calls it has to make during the process but increases overhead a little. On small batches this is probably not very efficient, but on larger batches with hundreds or thousands of messages to send it ends up being very fast. Responder-style messages are given priority over newsletter-style bursts. Responder messages tend to be more time-sensitive and there tends to be fewer of them being sent at any time, so it makes the most sense to squeeze in newsletter messages after the responder side is done.</p>

<p>Sendmails.php will send straight text messages for those that request them, otherwise it will send multi-part text/html mime alternates for html messages. This makes html messages pretty safe to use since they also include their text counter-part for people that don't want or can't see html in their email. In general these 2 message types should be kept as similar as possible, if you include radically different versions many spam filters will react negatively.</p>

<p>When sendmails.php is called it can also call bouncechecker and mailchecker if you've set that option in the config screen.</p>

<p>


<div id="manual_checkers" style="display:none;">
<p>Bouncechecker and mailchecker</p>
<p>Both of these use imap() routines to run. These routines are a bit tricky to use and if you're having trouble getting them to work talk with your host to make sure your settings are correct. If they are then post for help on the forums. There are ways to get non-standard settings to work, but it usually takes a little time to figure everything out.</p>

<p>


<div id="manual_remotesub" style="display:none;">
<p>Remote subscriptions</p>
<p>Since I designed this to be email-course friendly, I figured someone out there might want to use this to handle subscriptions advertised by others. Ie: Design an email course for your affiliates to give away, but let them handle the form capture from their end to build both of your subscriber bases.</p>

<p>For this reason the subscribe routine has a silent subscription feature that will disable all normal output, including the template files and redirects. It won't, however, disable the confirmation message sent to their email address for double opt-in lists.</p>

<p>
s variables:<br />
e = The email address<br />
f = first name<br />
l = last name<br />
f = full name<br />
r = The responder ID<br />
a = "sub"<br />
h = 1 for HTML email. 0 for text.<br />
s = 1 for silent sub, 0 for normal.<br />
ref = referral source<br />

So lets say you want to set this up from yourdomain.com under /course:<br>
http://www.yourdomain.com/course/s.php?e=$email&r=$resp&a=sub&h=$html&s=1
</p>

<p>Then simply set up your PHP variables: $email, $resp and $html. At that point, all you have to do is call that link somehow. You can use a redirect, a silent post/get or even an image load to seamlessly start the confirmation process from any other site.</p>

<p>if you trust other sites to sign up users directly you can even turn off the silent feature, enable single opt-in and set the redirect to another page. Users passed to it will be signed up and sent on to your redirect.</p>

<p>


<div id="manual_copyright" style="display:none;">
<p>License and copyright</p>
This app is copyright 2004, 2005, 2006 and 2007 by Aaron Colman and Adaptive Business Design and released under the GPL. The GPL requires that you maintain proper credit (the image at the bottom and links in the unsubscribe messages) and that any changes you make be redistributed. You can post code changes to the forum or send them to me via email, I'll repost them for others. Removing the "powered by" and credit links without an alternate license may effect your ability to receive support in the forums.</p>

<p>A copy of the GPL can be found in this distribution as gpl.txt.</p>

<p>Some plugins (namely tinyMCE) operate under a different license. TinyMCE, written by Moxiecode at <A HREF="http://tinymce.moxiecode.com/" target="_blank">http://tinymce.moxiecode.com/</A> is an open source LGPL html editor. It's seperately licensed and any changes you make specifically to it may require something different.</p>

<p>There are, however, some situations where the GPL isn't the perfect option. If you have clients and need to rebrand the script to fit their site, or if you want to operate w/o the image banner or links in the unsub message. We offer additional licensing capabilities that can allow you to rebrand and make changes w/o redistribution. These also usually include free email support for up to a year, too, so they're generally worth it. Check the website for more information about alternate licensing options.</p>

<p>These alternate licenses cannot expand to cover TinyMCE (or any other plugin) however. If you need a license specifically for that you can get one at <A HREF="http://tinymce.moxiecode.com/" target="_blank">http://tinymce.moxiecode.com/</A> that will cover your needs. You can also disable tinyMCE via the config screen if this becomes a problem for you.</p>

<p>


<div id="manual_support" style="display:none;">
<p>Support</p>
<p>Support is provided at the forums for anyone that needs it. Check <A HREF="http://infinite.ibasics.biz" target="_blank">http://infinite.ibasics.biz</A> for more information. For those with more specific needs I can provide some limited email support (or unlimited support can be purchased if you need it) or even a telephone support agreement if you need it. If you've paid for a custom installation you'll have 30 days of unlimited email support where I can step you thru any problems you have.</p>

<p>


<div id="manual_custommods" style="display:none;">
<p>Custom mods</p>
<p>Custom changes or additions to this application are available. Visit <A HREF="http://infinite.ibasics.biz" target="_blank">http://infinite.ibasics.biz</A> for more information.</p>

<p>


<div id="manual_spamtips" style="display:none;">
<p>Tips on avoiding spam filters</p>
<p>This script has been tested with spam assassin at it's tightest levels to ensure that it won't artificially trip spam filters. Infinite Responder's headers are RFC compliant.</p>

<p>If you're having trouble w/ spam filters you should check spam assassin's page on the topic. It has some great tips available at:<br />
<A HREF="http://wiki.apache.org/spamassassin/AvoidingFpsForSenders" target="_blank">http://wiki.apache.org/spamassassin/AvoidingFpsForSenders</A></p>

<p>If you're still having trouble, send to a test address and replicate the problem locally. Then post the headers to the forum. We can take a look at the triggered rules and give you a better idea of what's going on.</p>

<p>


<div id="manual_theend" style="display:none;">
<p>The End...</p>
<p>That's the end of this descriptive manual. If you need help go to:<br />
http://infinite.ibasics.biz</p>

</body>
</html>
