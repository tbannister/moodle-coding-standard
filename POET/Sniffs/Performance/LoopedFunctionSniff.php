<?php
/**
 * POET_Sniffs_Performance_LoopedFunctionSniff.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */

if (class_exists('PHP_CodeSniffer_Standards_AbstractScopeSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_AbstractScopeSniff not found');
}

/**
 * POET_Sniffs_Performance_LoopedFunctionSniff.
 *
 * This sniff checks for certain slow running functions and makes sure they are not called in a
 * loop because those functions have the potential to cause disastrously bad performance if used
 * irresponsibly in a loop.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Performance_LoopedFunctionSniff extends PHP_CodeSniffer_Standards_AbstractScopeSniff {
    /**
     * This constructor tells the parent object that we want to find strings (including unquoted) in
     * loops.
     *
     * @return array The array of tokens to run this sniff on.
     */
    public function __construct() {
        parent::__construct(array(T_DO, T_FOR, T_FOREACH, T_WHILE), array(T_STRING));
    }

    /**
     * Check if slow functions are being called in a loop.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     */
    protected function processTokenWithinScope(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $currScope) {
        $tokens = $phpcsFile->getTokens();
        $name = $tokens[$stackPtr]['content'];
        // These Moodle function should not be called inside of a loop.
        $slowfunctions = array(
            'execute',
            'get_recordset',
            'get_recordset_list',
            'get_recordset_select',
            'get_recordset_sql',
            'export_table_recordset',
            'get_records',
            'get_records_list',
            'get_records_select',
            'get_records_sql',
            'get_records_menu',
            'get_records_select_menu',
            'get_records_sql_menu',
            'get_record',
            'get_record_select',
            'get_record_sql',
            'get_field',
            'get_field_select',
            'get_field_sql',
            'get_fieldset_select',
            'get_fieldset_sql',
            'insert_record_raw',
            'insert_record',
            'insert_records',
            'import_record',
            'update_record_raw',
            'update_record',
            'set_field',
            'set_field_select',
            'count_records',
            'count_records_select',
            'count_records_sql',
            'record_exists',
            'record_exists_select',
            'record_exists_sql',
            'delete_records',
            'delete_records_list',
            'delete_records_select',
            'replace_all_text',
            'event_trigger',
        );

        foreach ($slowfunctions as $function) {
            if ($name === $function) {
                $error = "Potential performance issue: Function %s should not be called in a loop.";
                $data = array($name);
                $phpcsFile->addWarning($error, $stackPtr, 'Performance problem', $data);
            }
        }
    }
}
