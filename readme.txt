------------------------------------------------------
AVERAGE THREAD RATINGS (FOR USER PROFILES):  
------------------------------------------------------

This plugin displays a user's average thread rating on their profile. A special
thanks to Omar G. for contributions, and to tc4me, Sawedoff, and Eldenroot for feedback and testing!  

AUTHOR: Darth Apple
Website: http://makestation.net
Version: 1.0 
MyBB Compatibility: 1.8.x (tested 1.8.24)

This plugin adds a new {$avg_rating} variable below {$reputation} in user profiles. This 
can be configured as needed. 

This plugin also attaches star_ratings.css to member.php for ALL themes upon activation. If
you add a new theme, you MUST deactivate and reactivate the plugin for the changes to take effect! 

-------------------------------------------
INSTALLATION:      
-------------------------------------------
 - Upload the contents of the /Upload folder to your forum root. 
 - Install and activate via ACP -> Configuration -> Plugins.
 - Many thanks to Jonny (tc4me) from https://autism4all.at for the German translation of this plugin. Both English and German are included with this repository, no external language packs required! 

-------------------------------------------
SETTINGS: 
-------------------------------------------

Average Profile ratings comes with several settings. 
You may configure these via ACP -> Configuration -> Average Profile Ratings


There are two separate usergroup settings available. Each of these serves a different purpose: 

   - Enabled Groups: Enables certain usergroups to display their thread averages on their profiles. 
    use if you don't want your new members group to display these averages, or if you want 
    to hide these on administrator profiles. 

   - Visible Groups: This defines which groups are allowed to see ratings, regardless of whether 
    they are calculated or not. Use this setting to disable guests from viewing, for example. 

Included Forums: 
   - This setting allows this plugin to only include ratings for threads in specific forums. 
     By default, all forums are supported. This can be edited in your ACP. 
     
 Min threshold: Allows you to only calculate ratings if the user has a minimum threshold. This is 
    sometimes necessary because users with only a few ratings can show inaccurate content ratings 
    respective to their actual posts. If, for example, a user has only one rating and this rating 
    is 1 star, this setting prevents a "One Star Average" from displaying in their profile until 
    they have more ratings. 

-------------------------------------------
DEVELOPER FUNCTIONS (ADVANCED): 
-------------------------------------------

AVGratings has a hidden feature to parse additional ratings. This feature is intended for 
developers who need more than one average calculated for different boards/forums on their community. 
To use this, you will need to modify this plugin and add the following function call in global scope: 

average_rating_parse_profile("1,2,3", "myvariable");

 - This will load all ratings from board IDs (1,2,3) and store it in $myvariable, which can 
then be added into your user profile template. 

 - This is an advanced feature intended for developers. If you have any questions, feel free 
to message me (Darth Apple) for support on the MyBB Community Forums! :)

-------------------------------------------
INFORMATION: 
-------------------------------------------

License: GPL, v3. You may modify, change, extend, or otherwise adapt this plugin as needed.
If you distribute a modified version, please provide a link and credit back to the original!

Translations: You may distribute your translation along with the original mod on the appropriate
MyBB community support forum for your language. If you do so, my only request is that you also 
post a link and credit back to the original. Many thanks to all who translate the plugins that we 
develop over at http://makestation.net. Your hard work helps us to reach a larger audience
with our plugins! :)