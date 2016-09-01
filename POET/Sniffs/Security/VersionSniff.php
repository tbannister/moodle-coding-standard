<?php
/**
 * POET_Sniffs_Security_VersionSniff.
 *
 * @author    Derek Henderson <derek.hendersonr@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */

if (class_exists('PHP_CodeSniffer_Standards_AbstractVariableSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_AbstractVariableSniff not found');
}

/**
 * POET_Sniffs_Security_VersionSniff.
 *
 * Checks the version file to ensure $module not being used as its deprecated.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */
class POET_Sniffs_Security_VersionSniff implements PHP_CodeSniffer_Sniff {

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array The array of tokens to run this sniff on.
     */
    public function register() {
        return array(T_VARIABLE);
    }

    /**
     * Check if $module used in version.php.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $fn = $phpcsFile->getFilename();
        if (strpos($fn,'version.php')){
            $tokens = $phpcsFile->getTokens();
            $content = $tokens[$stackPtr]['content'];
            if ($content === '$module') {
                $error = 'Use of "$module" detected in version.php. Module was dropped in M3.0 and should not be used.';
                $phpcsFile->addWarning($error, $stackPtr, 'MODULE');
            }
        }
    }
}