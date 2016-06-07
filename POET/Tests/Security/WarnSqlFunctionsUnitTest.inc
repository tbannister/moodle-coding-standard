<?php
$user = $DB->get_record('user', array('id'=>'1'));
$user = $DB->get_record_sql('SELECT * FROM {user} WHERE id = ?', array(1));

/// Question mark placeholders:
$DB->get_record_sql('SELECT * FROM {user} WHERE firstname = ? AND lastname = ?',
    array('James', 'Bond'));

/// Named placeholders:
$DB->get_record_sql('SELECT * FROM {user} WHERE firstname = :firstname AND lastname = :lastname',
    array('firstname'=>'James', 'lastname'=>'Bond'));

$DB->get_records_sql($sql, $params, $limitfrom, $limitnum);
$DB->get_records_sql_menu($sql, $params, $limitfrom, $limitnum);
$DB->count_records_sql($sql, $params);
$DB->record_exists_sql($sql, $params);
$DB->get_field_sql($sql, $params, $strictness);
$DB->get_fieldset_sql($sql, $params);
$DB->execute($sql, $parms);
$DB->get_recordset_sql($sql, $params, $limitfrom, $limitnum);
