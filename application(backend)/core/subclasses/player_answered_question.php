<?php
require_once 'player_answered_question_dd.php';
class player_answered_question extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = player_answered_question_dd::load_dictionary();
        $this->relations  = player_answered_question_dd::load_relationships();
        $this->subclasses = player_answered_question_dd::load_subclass_info();
        $this->table_name = player_answered_question_dd::$table_name;
        $this->tables     = player_answered_question_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('player_answered_question_id, question, player_id, points_attained, time_answered');
            $this->set_values("?,?,?,?,?");

            $bind_params = array('iiiss',
                                 &$this->fields['player_answered_question_id']['value'],
                                 &$this->fields['question']['value'],
                                 &$this->fields['player_id']['value'],
                                 &$this->fields['points_attained']['value'],
                                 &$this->fields['time_answered']['value']);

            $this->stmt_prepare($bind_params);
        }

        $this->stmt_execute();
        return $this;
    }

    function edit($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('UPDATE');
            $this->set_update("question = ?, player_id = ?, points_attained = ?, time_answered = ?");
            $this->set_where("player_answered_question_id = ?");

            $bind_params = array('iissi',
                                 &$this->fields['question']['value'],
                                 &$this->fields['player_id']['value'],
                                 &$this->fields['points_attained']['value'],
                                 &$this->fields['time_answered']['value'],
                                 &$this->fields['player_answered_question_id']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("player_answered_question_id = ?");

        $bind_params = array('i',
                             &$this->fields['player_answered_question_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete_many($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("");

        $bind_params = array('',
                             );

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function select()
    {
        $this->set_query_type('SELECT');
        $this->exec_fetch('array');
        return $this;
    }

    function check_uniqueness($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('SELECT');
        $this->set_where("player_answered_question_id = ?");

        $bind_params = array('i',
                             &$this->fields['player_answered_question_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }

    function check_uniqueness_for_editing($param)
    {
        $this->set_parameters($param);


        $this->set_query_type('SELECT');
        $this->set_where("player_answered_question_id = ? AND (player_answered_question_id != ?)");

        $bind_params = array('ii',
                             &$this->fields['player_answered_question_id']['value'],
                             &$this->fields['player_answered_question_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
