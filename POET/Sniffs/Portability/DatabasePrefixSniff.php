<?php
/**
 * POET_Sniffs_Portability_DatabasePrefixSniff.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */

/**
 * POET_Sniffs_Portability_DatabasePrefixSniff.
 *
 * This test checks to see if the Moodle default prefix has been hardcoded or if the MySQL or
 * PostgreSQL database specific tables are being used.  In the first case the plugin would fail
 * on any site with a non-standard prefix, in the second the plugin could fail when run with any
 * other database engine.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Portability_DatabasePrefixSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array The array of tokens to run this sniff on.
     */
    public function register() {
        return array(T_CONSTANT_ENCAPSED_STRING, T_DOUBLE_QUOTED_STRING);
    }

    /**
     * Check if this string is PARAM_RAW.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $content = $tokens[$stackPtr]['content'];

        $prefixes = array('mdl_' => 'Moodle');

        foreach ($prefixes as $prefix => $type) {
            // If it's a superglobal, it's a potential security hole.
            if (strpos($content, $prefix) !== false) {
                $error = "Potential portability issue: String %s appears to have hardcoded %s default table prefix \"%s\".";
                $data = array($content, $type, $prefix);
                $phpcsFile->addWarning($error, $stackPtr, 'Database prefix', $data);
            }
        }
    }
}
