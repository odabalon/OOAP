<?php
class billboard_location_dd
{
    static $table_name = 'billboard_location';
    static $readable_name = 'Billboard Location';

    static function load_dictionary()
    {
        $fields = array(
                    'billboard_location_id' => array('value'=>'',
                                          'nullable'=>FALSE,
                                          'data_type'=>'integer',
                                          'length'=>20,
                                          'required'=>FALSE,
                                          'attribute'=>'primary key',
                                          'control_type'=>'none',
                                          'size'=>'60',
                                          'drop_down_has_blank'=>TRUE,
                                          'label'=>'Billboard Location ID',
                                          'extra'=>'',
                                          'companion'=>'',
                                          'in_listview'=>FALSE,
                                          'char_set_method'=>'generate_num_set',
                                          'char_set_allow_space'=>FALSE,
                                          'extra_chars_allowed'=>'-',
                                          'allow_html_tags'=>FALSE,
                                          'trim'=>'trim',
                                          'valid_set'=>array(),
                                          'date_elements'=>array('','',''),
                                          'date_default'=>'',
                                          'list_type'=>'',
                                          'list_settings'=>array(''),
                                          'rpt_in_report'=>TRUE,
                                          'rpt_column_format'=>'normal',
                                          'rpt_column_alignment'=>'center',
                                          'rpt_show_sum'=>TRUE),
                    'address' => array('value'=>'',
                                          'nullable'=>FALSE,
                                          'data_type'=>'varchar',
                                          'length'=>10000,
                                          'required'=>TRUE,
                                          'attribute'=>'none',
                                          'control_type'=>'textarea',
                                          'size'=>'58;5',
                                          'drop_down_has_blank'=>TRUE,
                                          'label'=>'Billboard Address',
                                          'extra'=>'',
                                          'companion'=>'',
                                          'in_listview'=>TRUE,
                                          'char_set_method'=>'',
                                          'char_set_allow_space'=>TRUE,
                                          'extra_chars_allowed'=>'',
                                          'allow_html_tags'=>FALSE,
                                          'trim'=>'trim',
                                          'valid_set'=>array(),
                                          'date_elements'=>array('','',''),
                                          'date_default'=>'',
                                          'list_type'=>'',
                                          'list_settings'=>array(''),
                                          'rpt_in_report'=>TRUE,
                                          'rpt_column_format'=>'normal',
                                          'rpt_column_alignment'=>'left',
                                          'rpt_show_sum'=>FALSE),
                    'postal_code' => array('value'=>'',
                                          'nullable'=>FALSE,
                                          'data_type'=>'integer',
                                          'length'=>4,
                                          'required'=>TRUE,
                                          'attribute'=>'none',
                                          'control_type'=>'textbox',
                                          'size'=>'7',
                                          'drop_down_has_blank'=>TRUE,
                                          'label'=>'Postal Code',
                                          'extra'=>'',
                                          'companion'=>'',
                                          'in_listview'=>TRUE,
                                          'char_set_method'=>'generate_num_set',
                                          'char_set_allow_space'=>FALSE,
                                          'extra_chars_allowed'=>'-',
                                          'allow_html_tags'=>FALSE,
                                          'trim'=>'trim',
                                          'valid_set'=>array(),
                                          'date_elements'=>array('','',''),
                                          'date_default'=>'',
                                          'list_type'=>'',
                                          'list_settings'=>array(''),
                                          'rpt_in_report'=>TRUE,
                                          'rpt_column_format'=>'number_format2',
                                          'rpt_column_alignment'=>'right',
                                          'rpt_show_sum'=>TRUE)
                       );
        return $fields;
    }

    static function load_relationships()
    {
        $relations = array(array('type'=>'1-M',
                                 'table'=>'company_ad',
                                 'link_parent'=>'billboard_location_id',
                                 'link_child'=>'billboard_loc',
                                 'where_clause'=>''));

        return $relations;
    }

    static function load_subclass_info()
    {
        $subclasses = array('html_file'=>'billboard_location_html.php',
                            'html_class'=>'billboard_location_html',
                            'data_file'=>'billboard_location.php',
                            'data_class'=>'billboard_location');
        return $subclasses;
    }

}