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
        $slowfunctions = array('get_records', 'event_trigger');

        foreach ($slowfunctions as $function) {
            if ($name === $function) {
                $error = "Potential performance issue: Function %s should not be called in a loop.";
                $data = array($name);
                $phpcsFile->addWarning($error, $stackPtr, 'Performance problem', $data);
            }
        }
    }
}
