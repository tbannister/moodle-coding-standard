<?php

// This line should be OK.
$DB->get_records('testing');

foreach([1, 2, 3] as $value) {
    // This line should cause a warning.
    $DB->get_records('testing', ['id' => $value]);
}

while (false) {
    // This line should cause a warning.
    $DB->get_records('testing');
}

for ($i = 0; $i < 1; $i++) {
    // This line should cause a warning.
    $DB->get_records('testing', ['id' => $i]);
}

do {
    // This line should cause a warning.
    $DB->get_records('testing');
} while (false);

while (false) {
    // All of these should cause a warning.
    $DB->execute();
    $DB->get_recordset();
    $DB->get_recordset_list();
    $DB->get_recordset_select();
    $DB->get_recordset_sql();
    $DB->export_table_recordset();
    $DB->get_records_list();
    $DB->get_records_select();
    $DB->get_records_sql();
    $DB->get_records_menu();
    $DB->get_records_select_menu();
    $DB->get_records_sql_menu();
    $DB->get_record();
    $DB->get_record_select();
    $DB->get_record_sql();
    $DB->get_field();
    $DB->get_field_select();
    $DB->get_field_sql();
    $DB->get_fieldset_select();
    $DB->get_fieldset_sql();
    $DB->insert_record_raw();
    $DB->insert_record();
    $DB->insert_records();
    $DB->import_record();
    $DB->update_record_raw();
    $DB->update_record();
    $DB->set_field();
    $DB->set_field_select();
    $DB->count_records();
    $DB->count_records_select();
    $DB->count_records_sql();
    $DB->record_exists();
    $DB->record_exists_select();
    $DB->record_exists_sql();
    $DB->delete_records();
    $DB->delete_records_list();
    $DB->delete_records_select();
    $DB->replace_all_text();
}