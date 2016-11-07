<?php
/**
 * POET_Sniffs_Security_NewmethodSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_Security_NewfunctionSniff.
 *
 * Checks for methods present in PHP 7 and above.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Security_NewmethodSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * A list of new methods not present in older versions of PHP.
     *
     */
    public function register () {
        $newmethods = array (
        'setcompressionindex',
        'setcompressionname',
        );
        $this->newmethodnames = ($newmethods);
        return array(T_STRING);
    }
    public function process(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $tokens = $phpcsfile->getTokens();
        $method = strtolower($tokens[$stackptr]['content']);
        if (in_array($method, $this->newmethodnames) === true) {
            $warning = 'The method '.$method .' is a function supported in newer versions of PHP. It should not be used. ';
            $phpcsfile->addWarning($warning, $stackptr);
        }
    }
}
