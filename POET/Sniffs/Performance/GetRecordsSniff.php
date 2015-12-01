<?php
/**
 * POET_Sniffs_Performance_GetRecordsSniff.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */

/**
 * POET_Sniffs_Performance_GetRecordsSniff.
 *
 * In almost all cases it's better for memory and performance to use get_recordset than get_records.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Performance_GetRecordsSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array The array of tokens to run this sniff on.
     */
    public function register() {
        return array(T_STRING);
    }

    /**
     * Check if slow functions are being called in a loop.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $name = $tokens[$stackPtr]['content'];

        // Check for the get_records function, but skip the get_recordset functions
        if ((substr($name, 0, 11) === 'get_records') && (substr($name, 11, 2) != 'et')) {
            $error = "Potential performance issue: Function %s should not be used.";
            $data = array($name);
            $phpcsFile->addWarning($error, $stackPtr, 'Performance problem', $data);
        }
    }
}
