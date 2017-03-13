<?php
//****************************************************************************************
//Generated by Cobalt, a rapid application development framework. http://cobalt.jvroig.com
//Cobalt developed by JV Roig (jvroig@jvroig.com)
//****************************************************************************************
require 'path.php';
init_cobalt('Add question');

require 'components/get_listview_referrer.php';

if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_submit']);
    require 'components/query_string_standard.php';
    require 'subclasses/question.php';
    $dbh_question = new question;

    $object_name = 'dbh_question';
    require 'components/create_form_data.php';
    extract($arr_form_data);

    if($_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        redirect("listview_question.php?$query_string");
    }


    if($_POST['btn_submit'])
    {
        log_action('Pressed submit button');

        $message .= $dbh_question->sanitize($arr_form_data)->lst_error;
        extract($arr_form_data);

        if($dbh_question->check_uniqueness($arr_form_data)->is_unique)
        {
            //Good, no duplicate in database
        }
        else
        {
            $message = "Record already exists with the same primary identifiers!";
        }

        if($message=="")
        {
            $dbh_question->add($arr_form_data);
            $question_id = $dbh_question->auto_id;
           

            


            redirect("listview_question.php?$query_string");
        }
    }
}
require 'subclasses/question_html.php';
$html = new question_html;
$html->draw_header('Add %%', $message, $message_type);
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);

//Fix-me: this should be "type" instead of "answer"
if(isset($answer) && $answer == 'Multiple Choice')
{
/*    
    $html->relations[]  = array('type'=>'1-M',
                                'table'=>'question_choices',
                                'link_parent'=>'question_id',
                                'link_child'=>'question_id',
                                'where_clause'=>'');                             
*/
}
else
{
    unset($html->relations[2]);
}


$html->draw_controls('add');

$html->draw_footer();