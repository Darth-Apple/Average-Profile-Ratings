README: 

---------------------------------------------------------------------------------------------------------
KNOWN ISSUE: You MUST link the star_rating.css file to member.php for this plugin to work.  If this stylesheet is 
not manually linked via your ACP (click Options -> Properties on the stylesheet), this plugin will fail
to load the star ratings properly. This will be fixed before release! 
---------------------------------------------------------------------------------------------------------

This plugin calculates the average rating of a user's threads, and displays this average in their profile. 

You are using a beta version of this plugin. You may use this on a live board at your own risk. 
Full release will be coming soon. 

AUTHOR: Darth Apple
Website: http://makestation.net
Version: 0.1 (beta)
MyBB Compatibility: 1.8.x (tested 1.8.22)

This plugin adds a new {$avg_rating} variable below {$reputation} in user profiles. This 
can be configured as needed. 

 - There are two separate usergroup settings. 
   - Enabled Groups: Enables certain usergroups to display their thread averages on their profiles. Use, for 
       example, if you don't want your new members group to display these averages, or if you want 
       to hide these on administrator profiles. 
   - Visible Groups: This defines which groups are allowed to see ratings, regardless of whether 
       they are calculated or not. Use this setting to disable guests from viewing, for example. 

 - Min threshold: Allows you to only calculate ratings if the user has a minimum threshold. This is 
    sometimes necessary because users with only a few ratings can show inaccurate content ratings respective to their actual posts. If, for example, a user has only one rating and this rating is 1 star, this setting prevents a "One Star Average" from displaying in their profile until they have more ratings. 