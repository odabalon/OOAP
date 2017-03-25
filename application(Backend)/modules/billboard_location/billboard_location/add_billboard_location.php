<?php
//****************************************************************************************
//Generated by Cobalt, a rapid application development framework. http://cobalt.jvroig.com
//Cobalt developed by JV Roig (jvroig@jvroig.com)
//****************************************************************************************
require 'path.php';
init_cobalt('Add billboard location');

require 'components/get_listview_referrer.php';

if(xsrf_guard())
{
    init_var($_POST['btn_cancel']);
    init_var($_POST['btn_submit']);
    require 'components/query_string_standard.php';
    require 'subclasses/billboard_location.php';
    $dbh_billboard_location = new billboard_location;

    $object_name = 'dbh_billboard_location';
    require 'components/create_form_data.php';
    extract($arr_form_data);

    if($_POST['btn_cancel'])
    {
        log_action('Pressed cancel button');
        redirect("listview_billboard_location.php?$query_string");
    }


    if($_POST['btn_submit'])
    {
        log_action('Pressed submit button');

        $message .= $dbh_billboard_location->sanitize($arr_form_data)->lst_error;
        extract($arr_form_data);
        debug($arr_form_data);
        if($dbh_billboard_location->check_uniqueness($arr_form_data)->is_unique)
        {
            //Good, no duplicate in database
        }
        else
        {
            $message = "Record already exists with the same primary identifiers!";
        }

        if($message=="")
        {
            $dbh_billboard_location->add($arr_form_data);
            $billboard_location_id = $dbh_billboard_location->auto_id;
           


            redirect("listview_billboard_location.php?$query_string");
        }
    }
}
require 'subclasses/billboard_location_html.php';
$html = new billboard_location_html;
$html->draw_header('Add %%', $message, $message_type);
$html->draw_listview_referrer_info($filter_field_used, $filter_used, $page_from, $filter_sort_asc, $filter_sort_desc);

//$html->draw_controls('add');

//***********************************************

$html->draw_container_div_start();
$html->draw_fieldset_header('Customized Form w/ GMaps');
$html->draw_fieldset_body_start();
echo '<table class="input_form">';


$html->draw_field('address');
$html->draw_field('postal_code');
$html->draw_field('latitude');
$html->draw_field('longitude');
require 'thirdparty/googleMaps/samp.php';


echo '<tr><td colspan="2">';

echo '</td></tr>';


echo '</table>';
$html->autofocus('position_title');
$html->draw_fieldset_body_end();
$html->draw_fieldset_footer_start();
$html->draw_submit_cancel(FALSE);

//***************************************************
$html->draw_footer();