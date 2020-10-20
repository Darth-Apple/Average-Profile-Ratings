README: 

---------------------------------------------------------------------------------------------------------
BETA PLUGIN. USE AT YOUR OWN RISK. 
---------------------------------------------------------------------------------------------------------

This plugin calculates the average rating of a user's threads, and displays in their profile. A special
thanks to Omar G. for contributions, and to tc4me and Sawedoff for feedback and testing!  

You are using a beta version of this plugin. You may use this on a live board at your own risk. 
Full release will be coming soon. 

AUTHOR: Darth Apple
Website: http://makestation.net
Version: 0.1 (beta)
MyBB Compatibility: 1.8.x (tested 1.8.22)

This plugin adds a new {$avg_rating} variable below {$reputation} in user profiles. This 
can be configured as needed. 

This plugin also attaches star_ratings.css to member.php for ALL themes upon activation. If
you add a new theme, you MUST deactivate and reactivate the plugin for the changes to take effect. 

There are two separate usergroup settings. 
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