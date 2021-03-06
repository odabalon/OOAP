<?php
//****************************************************************************************
//Generated by Cobalt, a rapid application development framework. http://cobalt.jvroig.com
//Cobalt developed by JV Roig (jvroig@jvroig.com)
//****************************************************************************************
require 'path.php';
init_cobalt('Edit player');

if(isset($_GET['player_id']))
{
    $player_id = urldecode($_GET['player_id']);
    require 'form_data_player.php';

}
$show_modal = FALSE;
if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_submit']);
    init_var($_POST['btn_cancel2']);
    init_var($_POST['btn_submit2']);
    require 'components/query_string_standard.php';
    require 'subclasses/player.php';
    $dbh_player = new player;

    $object_name = 'dbh_player';
    require 'components/create_form_data.php';

    extract($arr_form_data);

    if($_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        redirect("listview_player.php?$query_string");
    }


    if($_POST['btn_submit'])
    {
        log_action('Pressed submit button');

        $message .= $dbh_player->sanitize($arr_form_data)->lst_error;
        extract($arr_form_data);

        if($dbh_player->check_uniqueness_for_editing($arr_form_data)->is_unique)
        {
            //Good, no duplicate in database
        }
        else
        {
            $message = "Record already exists with the same primary identifiers!";
        }

        if($message=="")
        {
          
            
            require_once 'subclasses/player_answered_question.php';
            $dbh_player_answered_question = new player_answered_question;
            $dbh_player_answered_question->delete_many($arr_form_data);

            for($a=0; $a<$player_answered_question_count;$a++)
            {
                
                $param = array(
                               'question'=>$cf_player_answered_question_question[$a],
                               'player_id'=>$player_id
                              );
                $dbh_player_answered_question->add($param);
            }

            $show_modal = TRUE;
            //$dbh_player->edit($arr_form_data);

            //redirect("listview_player.php?$query_string");
        }
    }

    if($_POST['btn_submit2'])
	{
		$dbh_player->edit($arr_form_data);
		//debug($arr_form_data);
		  redirect("listview_player.php?$query_string");
		 
   
	}
	
	if($_POST['btn_cancel2'])
	{
		$show_modal = FALSE;
	}
}
require 'subclasses/player_html.php';
$html = new player_html;
$modal_message = "Are you sure you want to continue?";
$html->draw_header('Edit %%', $message, $message_type);
if($show_modal)
{
	$html->draw_container_div_start_modal($modal_message);
}
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);
$html->draw_hidden('player_id');

$html->draw_controls('edit');

$html->draw_footer();