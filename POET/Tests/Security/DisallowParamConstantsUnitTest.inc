<?php
$mform = $this->_form;

$mform->addElement('text', 'name', get_string('name', 'mymod'), ['size' => '64']);
$mform->setType('name', PARAM_RAW);

$mform->addElement('text', 'name', get_string('name', 'mymod'), ['size' => '64']);
$mform->setType('name', PARAM_CLEAN);

$mform->addElement('text', 'name', get_string('name', 'mymod'), ['size' => '64']);
$mform->setType('name', PARAM_INTEGER);

$mform->addElement('text', 'name', get_string('name', 'mymod'), ['size' => '64']);
$mform->setType('name', PARAM_NUMBER);

$mform->addElement('text', 'name', get_string('name', 'mymod'), ['size' => '64']);
$mform->setType('name', PARAM_ACTION);

$mform->addElement('text', 'name', get_string('name', 'mymod'), ['size' => '64']);
$mform->setType('name', PARAM_FORMAT);

$mform->addElement('text', 'name', get_string('name', 'mymod'), ['size' => '64']);
$mform->setType('name', PARAM_MULTILANG);

$mform->addElement('text', 'name', get_string('name', 'mymod'), ['size' => '64']);
$mform->setType('name', PARAM_CLEANFILE);

$id = optional_param('id', '', PARAM_TEXT);
$id = optional_param('id', '', PARAM_RAW);
$id = optional_param('id', '', PARAM_CLEAN);
$id = optional_param('id', '', PARAM_INTEGER);
$id = optional_param('id', '', PARAM_NUMBER);
$id = optional_param('id', '', PARAM_ACTION);
$id = optional_param('id', '', PARAM_FORMAT);
$id = optional_param('id', '', PARAM_MULTILANG);
$id = optional_param('id', '', PARAM_CLEANFILE);