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
            require_once 'subclasses/question_choices.php';
            $dbh_question = new question_choices;
          
		  IF (isset($answer)&& $answer=='Multiple Choice')
		{
			for($a=0; $a<$question_choices_count;$a++)
            {
                
                $param = array(
                               'question_id'=>$question_id,
                               'choice_number'=>$cf_question_choices_choice_number[$a],
                               'choice'=>$cf_question_choices_choice[$a],
                               'is_correct'=>$cf_question_choices_is_correct[$a]
                              );
                $dbh_question->add($param);
            }
		} else 

			{
			 require_once 'subclasses/question_answer.php';
            $dbh_question = new question_answer;
            for($a=0; $a<$question_answer_count;$a++)
            {
                
                $param = array(
                               'question_id'=>$question_id,
                               'answer'=>$cf_question_answer_answer[$a]
                              );
                $dbh_question->add($param);
            }	
			}
			
			
           


            redirect("listview_question.php?$query_string");
        }
    }
}
require 'subclasses/question_html.php';
$html = new question_html;
$html->draw_header('Add %%', $message, $message_type);
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);


IF (isset($answer)&& $answer=='Multiple Choice')
{
unset($html->relations[1]);
}
else
{
    unset($html->relations[0]);
    isset($html->relations[1]);
}


$html->draw_controls('add');

$html->draw_footer();