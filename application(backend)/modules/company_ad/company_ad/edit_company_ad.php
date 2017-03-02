<?php
//****************************************************************************************
//Generated by Cobalt, a rapid application development framework. http://cobalt.jvroig.com
//Cobalt developed by JV Roig (jvroig@jvroig.com)
//****************************************************************************************
require 'path.php';
init_cobalt('Edit company ad');

if(isset($_GET['company_ad_id']))
{
    $company_ad_id = urldecode($_GET['company_ad_id']);
    require 'form_data_company_ad.php';

}

if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_submit']);
    require 'components/query_string_standard.php';
    require 'subclasses/company_ad.php';
    $dbh_company_ad = new company_ad;

    $object_name = 'dbh_company_ad';
    require 'components/create_form_data.php';

    extract($arr_form_data);

    if($_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        redirect("listview_company_ad.php?$query_string");
    }


    if($_POST['btn_submit'])
    {
        log_action('Pressed submit button');

        $message .= $dbh_company_ad->sanitize($arr_form_data)->lst_error;
        extract($arr_form_data);

        if($dbh_company_ad->check_uniqueness_for_editing($arr_form_data)->is_unique)
        {
            //Good, no duplicate in database
        }
        else
        {
            $message = "Record already exists with the same primary identifiers!";
        }

        if($message=="")
        {
            require_once 'subclasses/question.php';
            $dbh_question = new question;
            $dbh_question->delete_many($arr_form_data);

            for($a=0; $a<$question_count;$a++)
            {
                
                $param = array(
                               'question'=>$cf_question_question[$a],
                               'points'=>$cf_question_points[$a],
                               'time_limit'=>$cf_question_time_limit[$a],
                               'company_ad'=>$company_ad_id
                              );
                $dbh_question->add($param);
            }


            $dbh_company_ad->edit($arr_form_data);

            redirect("listview_company_ad.php?$query_string");
        }
    }
}
require 'subclasses/company_ad_html.php';
$html = new company_ad_html;
$html->draw_header('Edit %%', $message, $message_type);
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);
$html->draw_hidden('company_ad_id');

$html->draw_controls('edit');

$html->draw_footer();