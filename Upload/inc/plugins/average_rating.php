<?php

 /*     This file is part of AVGRatings.

    AVGRatings is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    AVGRatings is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with AVGRatings.  If not, see <http://www.gnu.org/licenses/>.

*/

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

if(!defined("IN_MYBB")) {
    die("Direct access not allowed.");
}

global $templatelist;
$templatelist.= ',average_profile_ratings';

// Add the hook to the end of the profile. 
if (isset($mybb->settings['average_rating_enabled']) && !empty($mybb->settings['average_rating_enabled'])) {
    $plugins->add_hook("member_profile_end", "average_rating_parse_profile");
}

function average_rating_info() {
    global $lang;

    $lang->load("avg_ratings");
        return array (
            'name'			=> $lang->avg_profile_ratings_name,
            'description'	=> $lang->avg_profile_ratings_desc,
            'website'		=> 'https://community.mybb.com',
            'author'		=> 'Darth Apple',
            'authorsite'	=> 'http://www.makestation.net',
            'version'		=> '0.1',
            "compatibility"	=> "18*"
        );
    }

function average_rating_activate() {
    // Template modifications will go here. 

    require MYBB_ROOT.'/inc/adminfunctions_templates.php';
    find_replace_templatesets('member_profile', '#{\$reputation}#', '{\$reputation}<!-- AVGRating -->{$avg_rating}<!-- /AVGRating -->');
}

function average_rating_deactivate () {
    // Undo any template modifications. 

    require MYBB_ROOT.'/inc/adminfunctions_templates.php';
    find_replace_templatesets('member_profile', '#\<!--\sAVGRating\s--\>\{\$([a-zA-Z_]+)?\}<!--\s/AVGRating\s--\>#is', '', 0);
}

function average_rating_install() {
    global $db, $mybb, $lang;
    $lang->load("avg_ratings");

    // We must create the setting group first. 
    $setting_group = array (
        'name' => 'average_rating',
        'title' => $db->escape_string($lang->avg_profile_ratings_name),
        'description' => $db->escape_string($lang->avg_profile_ratings_desc),
        'disporder' => $rows+2,
        'isdefault' => 0
    ); 
    
    $group['gid'] = $db->insert_query("settinggroups", $setting_group); // inserts new group for settings into the database. 
    $settings = array();

    $settings[] = array(
        'name' => 'average_rating_enabled',
        'title' => $db->escape_string($lang->avg_profile_ratings_enabled),
        'description' => $db->escape_string($lang->avg_profile_ratings_enabled_desc),
        'optionscode' => 'yesno',
        'value' => '1',
        'disporder' => 0,
        'isdefault' => 0,
        'gid' => $group['gid']
    );
    
    $settings[] = array(
        'name' => 'average_rating_forums',
        'title' => $db->escape_string($lang->avg_profile_ratings_forums),
        'description' => $db->escape_string($lang->avg_profile_ratings_forums_desc),
        'optionscode' => "forumselect",
        'value' => '-1',
        'disporder' => 1,
        'isdefault' => 0,
        'gid' => $group['gid']
    );
    
    $settings[] = array(
        'name' => 'average_rating_groups',
        'title' => $db->escape_string($lang->avg_profile_ratings_groups),
        'description' => $db->escape_string($lang->avg_profile_ratings_groups_desc),
        'optionscode' => "groupselect",
        'value' => '-1',
        'disporder' => 2,
        'isdefault' => 0,
        'gid' => $group['gid']
    );


    $settings[] = array(
        'name' => 'average_rating_groups_visible',
        'title' => $db->escape_string($lang->avg_profile_ratings_groups_visible),
        'description' => $db->escape_string($lang->avg_profile_ratings_groups_visible_desc),
        'optionscode' => "groupselect",
        'value' => '-1',
        'disporder' => 3,
        'isdefault' => 0,
        'gid' => $group['gid']
    );

    $settings[] = array(
        'name' => 'average_rating_min',
        'title' => $db->escape_string($lang->avg_profile_ratings_min),
        'description' => $db->escape_string($lang->avg_profile_ratings_min_desc),
        'optionscode' => "numeric",
        'value' => '1',
        'disporder' => 4,
        'isdefault' => 0,
        'gid' => $group['gid']
    );
    
    foreach($settings as $array => $setting) {
        $db->insert_query("settings", $setting);
    }

    $template['average_profile_rating'] = '
<tr>
    <td class="trow2"><strong>{$lang->average_profile_ratings_label}</strong></td>
    <td class="trow2" style="padding-left: 0px;">
    
        <div style="float: left; max-width: 110px; {$displaytag}"><table style="padding: 0px; border: 0px;">
            <table style="padding: 0px; border: 0px;">
                <tr>
                    <td align="center" class="{$bgcolor}{$thread_type_class} disappear_on_tablet" id="rating_table_{$ratingData[\'tid\']}">
                        <ul class="star_rating{$not_rated}" id="rating_thread_{$ratingData[\'tid\']}">
                            <li style="width: {$ratingData[\'width\']}%" class="current_rating" id="current_rating_{$ratingData[\'tid\']}">{$ratingvotesav}</li>
                        </ul>
                        <script type="text/javascript">
                            <!--
                            Rating.build_forumdisplay({$ratingData[\'tid\']}, { width: \'{$ratingData[\'width\']}\', extra_class: \'{$not_rated}\', current_average: \'{$ratingvotesav}\' });
                            // -->
                        </script>
                    </td>
                </tr>
            </table>
        </div> 
        <div style="float: left; margin-left: 5px;"> $rating_text $rating_num_text</div>
    </td>
</tr>
';
        
    foreach($template as $title => $template_new){
        $template = array('title' => $db->escape_string($title), 'template' => $db->escape_string($template_new), 'sid' => '-1', 'version' => '1822', 'dateline' => TIME_NOW);
        $db->insert_query('templates', $template);
    }

    rebuild_settings();
}

// Delete the old setting group and the settings. 
function average_rating_uninstall() {
    global $db, $mybb;

    $query = $db->simple_select('settinggroups', 'gid', 'name = "average_rating"'); // remove settings
    $groupid = $db->fetch_field($query, 'gid');
    $db->delete_query('settings','gid = "'.$groupid.'"');
    $db->delete_query('settinggroups','gid = "'.$groupid.'"');

    // Remove templates: 
    $templates_to_remove = array('average_profile_rating'); 
    foreach($templates_to_remove as $data) {
        $db->delete_query('templates', "title = '{$data}'");
    }

    rebuild_settings();
}


// Are we installed? 
function average_rating_is_installed () {
    global $mybb;
    return (isset($mybb->settings['average_rating_enabled']));
}
    

/* DEVELOPERS: HOW TO USE MULTIPLE RATINGS: 
   The function below doubles as a helper function. It can be called as follows: 

   $mynewvariable = average_rating_parse_profile("1,2,3", "average_profile_rating");
   Where the second argument is any template you choose, and the first is a comma delimited list of forums. 

   You will need to set this variable yourself with your own function. 
   This can be done with an additional hook, if desired. 
   This will allow this plugin to generate multiple averages, as needed.
*/
    
function average_rating_parse_profile ($forumSelect = 0, $avg_template = "average_profile_rating") {
    global $mybb, $avg_rating, $templates, $lang;

    $lang->load("avg_ratings");
    $forums = $mybb->settings['average_rating_forums'];

    $avg_rating = ""; // Set this to avoid PHP notices on some servers. 
    $rating = '';
    $not_rated = '';
    $displaytag = ""; // Initialize to prevent server notices. 

    // If this function is called with parameters, let's use the parameters instead of relying on the plugin's settings. 
    if (!empty($forumSelect)) {
        $forums = $forumSelect;
    }

    // Return if the user is not allowed to view ratings at all. 
    if (!average_rating_permissions($mybb->settings['average_rating_groups_visible'])) {
        return;
    }

    // Now we need to see if the user whose profile we are on is in an enabled usergroup. If so, calculate the ratings. 
    if (average_rating_permissions($mybb->settings['average_rating_groups'], intval($mybb->input['uid']))) {

        $ratingData = average_rating_get_ratings($mybb->input['uid'], $forums); // Get the rating data. 

        // Handle if we haven't reached a minimum rating count. 
        if ($ratingData['numratings'] < $mybb->settings['average_rating_min']) {
            $ratingData['averagerating'] = 0;
        }

        // Build the rating values (for use in templates)
        $ratingData['averagerating'] = (float)round($ratingData['averagerating'], 2);
        $ratingsvotesav = (float) $ratingData['averagerating'];
        $ratingData['width'] = (int)round($ratingData['averagerating'])*20;
        $ratingData['numratings'] = (int)$ratingData['numratings'];
        $ratingvotesav = $lang->sprintf($lang->rating_votes_average, $ratingData['numratings'], $ratingData['averagerating']);
        
        if(!isset($ratingData['rated']) || empty($ratingData['rated']) || ($ratingData['numratings'] < $mybb->settings['average_rating_min'])) {
            $not_rated = ' star_rating_notrated';
        }

        // Make sure we don't say "1 stars" but "1 star" instead. 
        if ($ratingData['averagerating'] == 1) {
            $rating_text = (float) $ratingData['averagerating'] . " " . $lang->average_profile_ratings_star;
        } else {
            $rating_text = (float) $ratingData['averagerating'] . " " . $lang->average_profile_ratings_stars;
        }

        // Make sure we don't display "1 ratings" but "1 rating" instead. 
        if ($ratingData['numratings'] == 1) {
            $rating_num_text = "(" . (int) $ratingData['numratings'] . $lang->average_profile_ratings_num . ")";
        } else if ($ratingData['numratings'] > 1) {
            $rating_num_text = "(" . (int) $ratingData['numratings'] . $lang->average_profile_ratings_nums . ")";
        } else {
            $rating_num_text = "(" . $lang->average_profile_ratings_none . ")";
            $rating_text = "";
        }

        // Don't display the average if we haven't reached at least MIN ratings. 
        if ($ratingData['numratings'] < $mybb->settings['average_rating_min']) {
            $rating_text = $lang->average_profile_ratings_min_error;
            $displaytag = "display: none;"; // Don't display the stars.
            $rating_num_text = ""; 
        }

        // If forumselect is passed, we don't set the variable and instead return the value. 
        if (empty($forumSelect)) {
            eval("\$avg_rating = \"".$templates->get("average_profile_rating")."\";");
        } else {
            eval("\$alt_variable = \"".$templates->get($avg_template)."\";");
            return $alt_variable;
        }
    }
}


function average_rating_get_ratings ($userID, $forums) {
    global $mybb, $db;
    $uid = (int) $userID;

    $ratings['rated'] = 0;
    $ratings['tid'] = 0; 
    $rations['averagerating'] = 0;
    $ratings['numratings'] = 0;

    // Build a list of forums available for the query. 
    if ($forums != "-1") {
        $forums = $db->escape_string($forums); 
        $forumClause = " AND t.fid IN (".$forums.")";
    }
    
    // Skip running the queries if no forums are selected. 
    if (!empty($forums)) {
        $qdata = $db->query("SELECT COUNT(*) AS rcount FROM ".TABLE_PREFIX."threadratings r LEFT JOIN ".TABLE_PREFIX."threads t ON r.tid = t.tid WHERE t.uid = ".$uid." " . $forumClause . ";");
        $ratings['numratings'] = (int) $db->fetch_field($qdata, "rcount");
        
        $qdata2 = $db->query("SELECT AVG(rating) avgrating FROM ".TABLE_PREFIX."threadratings r LEFT JOIN ".TABLE_PREFIX."threads t ON r.tid = t.tid WHERE t.uid = ".$uid." " . $forumClause . ";");
        $ratings['averagerating'] = (float) $db->fetch_field($qdata2, "avgrating");
    }
    
    // Necessary for javascript. 
    if ($ratings['averagerating'] != 0) {
        $ratings['rated'] = 1;
    }
    return $ratings;
}


// This function checks whether this user is in an enabled usergroup. 
// We must check both additional usergroups and primary usergroups, hence this function. 
function average_rating_permissions ($avgrating_groups, $userID=0) {
    global $mybb, $db;

    if ($userID != 0) {
        // Get the usergroups of the user whose profile we are on. 
        $uid = (int) $userID; 
        $uQuery = $db->query("SELECT additionalgroups, usergroup FROM ".TABLE_PREFIX."users WHERE `uid` = ".$uid);
        $userRecord = $db->fetch_array($uQuery);
    } else {
        // Get our own (viewers) usergroups.
        $userRecord['additionalgroups'] = $mybb->user['additionalgroups'];
        $userRecord['usergroup'] = $mybb->user['usergroup'];
    }

    // No need to check for permissions if no groups are allowed. 
    if (empty($avgrating_groups)) {
        return false; 
    }

    // No need to check for permissions if all groups are allowed. 
    if ($avgrating_groups == '-1') {
        return true; 
    }

    // Create an array of all usergroups that the current user is a member of. 
    $usergroup = $userRecord['usergroup'];
    $allowed = explode(',', $avgrating_groups);
    $groups = array();
    $groups[0] = (int)$usergroup; 
    $add_groups = explode(',', $userRecord['additionalgroups']);
    $count = 1;
    foreach($add_groups as $new_group) {
        $groups[$count] = $new_group;
        $count++;
    }

    // Check if the user is in a member of an allowed group for this announcement. Return True if permitted. 
    foreach ($allowed as $allowed_group) {
        if (in_array($allowed_group, $groups)) {
            return true;
        }
    }
    // User is not in a valid usergroup to view this announcement. Return false. 
    return false;
}