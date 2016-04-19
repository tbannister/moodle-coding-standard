<?php
/**
 * POET_Sniffs_Security_IniSetSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
/**
 * POET_Sniffs_Security_IniSetSniff.
 *
 * This test checks to see if the Moodle default prefix has been hardcoded or if the MySQL or
 * PostgreSQL database specific tables are being used.  In the first case the plugin would fail
 * on any site with a non-standard prefix, in the second the plugin could fail when run with any
 * other database engine.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Security_IniSetSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array The array of tokens to run this sniff on.
     */
    public function register() {
        return array(T_STRING);
    }
    /* Check if this string has ini_set.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $content = $tokens[$stackPtr]['content'];
        // If it has ini_set, it's a potential security hole.
        if ($content === 'ini_set') {
            $error = 'Use of "ini_set" detected.  Direct access to ini_set usually indicates a critical security problem.';
            $phpcsFile->addError($error, $stackPtr, 'INI_SET', '');
        }
    }
}