<?php
require_once 'trivia_dd.php';
class trivia extends data_abstraction
{
    var $fields = array();


    function __construct()
    {
        $this->fields     = trivia_dd::load_dictionary();
        $this->relations  = trivia_dd::load_relationships();
        $this->subclasses = trivia_dd::load_subclass_info();
        $this->table_name = trivia_dd::$table_name;
        $this->tables     = trivia_dd::$table_name;
    }

    function add($param)
    {
        $this->set_parameters($param);

        if($this->stmt_template=='')
        {
            $this->set_query_type('INSERT');
            $this->set_fields('trivia_id, trivia, company');
            $this->set_values("?,?,?");

            $bind_params = array('isi',
                                 &$this->fields['trivia_id']['value'],
                                 &$this->fields['trivia']['value'],
                                 &$this->fields['company']['value']);

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
            $this->set_update("trivia = ?, company = ?");
            $this->set_where("trivia_id = ?");

            $bind_params = array('sii',
                                 &$this->fields['trivia']['value'],
                                 &$this->fields['company']['value'],
                                 &$this->fields['trivia_id']['value']);

            $this->stmt_prepare($bind_params);
        }
        $this->stmt_execute();

        return $this;
    }

    function delete($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("trivia_id = ?");

        $bind_params = array('i',
                             &$this->fields['trivia_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        return $this;
    }

    function delete_many($param)
    {
        $this->set_parameters($param);
        $this->set_query_type('DELETE');
        $this->set_where("company = ?");

        $bind_params = array('i',
                             &$this->fields['company']['value']);

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
        $this->set_where("trivia_id = ?");

        $bind_params = array('i',
                             &$this->fields['trivia_id']['value']);

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
        $this->set_where("trivia_id = ? AND (trivia_id != ?)");

        $bind_params = array('ii',
                             &$this->fields['trivia_id']['value'],
                             &$this->fields['trivia_id']['value']);

        $this->stmt_prepare($bind_params);
        $this->stmt_execute();
        $this->stmt_close();

        if($this->num_rows > 0) $this->is_unique = FALSE;
        else $this->is_unique = TRUE;

        return $this;
    }
}
