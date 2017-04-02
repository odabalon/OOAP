<?php
//****************************************************************************************
//Generated by Cobalt, a rapid application development framework. http://cobalt.jvroig.com
//Cobalt developed by JV Roig (jvroig@jvroig.com)
//****************************************************************************************
require 'path.php';
init_cobalt('Add question choices');

require 'components/get_listview_referrer.php';
$show_modal = FALSE;
if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_submit']);
	init_var($_POST['btn_cancel2']);	
    init_var($_POST['btn_submit2']);
    require 'components/query_string_standard.php';
    require 'subclasses/question_choices.php';
    $dbh_question_choices = new question_choices;

    $object_name = 'dbh_question_choices';
    require 'components/create_form_data.php';
    extract($arr_form_data);

    if($_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        redirect("listview_question_choices.php?$query_string");
    }


    if($_POST['btn_submit'])
    {
        log_action('Pressed submit button');

        $message .= $dbh_question_choices->sanitize($arr_form_data)->lst_error;
        extract($arr_form_data);

        if($dbh_question_choices->check_uniqueness($arr_form_data)->is_unique)
        {
            //Good, no duplicate in database
        }
        else
        {
            $message = "Record already exists with the same primary identifiers!";
        }

        if($message=="")
        {
            //$dbh_question_choices->add($arr_form_data);
            $show_modal = TRUE;

            //redirect("listview_question_choices.php?$query_string");
        }
    }
	
	if($_POST['btn_submit2'])
	{
		//$arr_form_data['question'] = $_POST['question'];
		//debug($arr_form_data);
		$dbh_question_choices->add($arr_form_data);
            

        redirect("listview_question_choices.php?$query_string");
	}
	
	if($_POST['btn_cancel2'])
	{
		$show_modal = FALSE;
	}
}
require 'subclasses/question_choices_html.php';
$html = new question_choices_html;
$modal_message = "Are you sure you want to continue?";
$html->draw_header('Add %%', $message, $message_type);
//show modal
if($show_modal)
{
	$html->draw_container_div_start_modal($modal_message);
}

$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);
$html->draw_controls('add');

$html->draw_footer();