<?php
/**
 * POET_Sniffs_Security_RawParamSniff.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */

/**
 * POET_Sniffs_Security_RawParamSniff.
 *
 * PARAM_RAW performs no security checking or parameter cleansing at all on the data it collects.
 * Generally speaking this is a bad idea and should only be used in cases where the data can be
 * guaranteed to be harmless.  That rarely happens, so PARAM_RAW should not be used in almost all
 * cases.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Security_RawParamSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array The array of tokens to run this sniff on.
     */
    public function register() {
        return array(T_STRING);
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

        // If it's a superglobal, it's a potential security hole.
        if ($content === 'PARAM_RAW') {
            $error = "Potential security issue: %s detected.";
            $data = array($content);
            $phpcsFile->addWarning($error, $stackPtr, 'Superglobal', $data);
        }
    }
}
