<?php
/**
 * POET_Sniffs_Security_SuperglobalSniff.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */

if (class_exists('PHP_CodeSniffer_Standards_AbstractVariableSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_AbstractVariableSniff not found');
}

/**
 * POET_Sniffs_Security_SuperglobalSniff.
 *
 * Ensures no superglobals are referenced anywhere in the file.  To prevent all
 * manner of security issues, the super globals should only be accessed through Moodle's
 * built-in handlers such as require_param and optional_param.
 *
 * @author    Tyler Bannister <tyler.bannister@remote-learner.net>
 * @copyright 2015 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Security_SuperglobalSniff extends PHP_CodeSniffer_Standards_AbstractVariableSniff {

    /**
     * Member variables are never superglobals so this will always pass.
     *
     * @param PHP_CodeSniffer_File $phpcsfile The file being scanned.
     * @param int                  $stackptr  The position of the current token in the stack passed in $tokens.
     */
    protected function processMemberVar(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
    }

    /**
     * Check if this variable is superglobal.
     *
     * @param PHP_CodeSniffer_File $phpcsfile The file being scanned.
     * @param int                  $stackptr  The position of the current token in the stack passed in $tokens.
     */
    protected function processVariable(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $tokens = $phpcsfile->getTokens();
        $varname = ltrim($tokens[$stackptr]['content'], '$');
        $superglobals = array(
                'GLOBALS', '_SERVER', '_GET', '_POST', '_FILES', '_COOKIE', '_SESSION', '_REQUEST', '_ENV',
        );

        $validcases = array(
                'isset', 'header', 'unset', 'is_null', 'defined', 'empty', '__isset',
                'array_key_exists',
        );
        // If it's a superglobal, it's a potential security hole.
        if (in_array($varname, $superglobals) === true) {
            if ($stackptr > 2) {
               $preglobal = strtolower($tokens[$stackptr - 2]['content']);
               $preglobal = trim($preglobal, '"');
            }
            if ((in_array($preglobal, $validcases) === false) || (stackptr < 2)) {
               $error = 'Superglobal %s detected.  Direct access to superglobals usually indicates a critical security problem.';
               $data = array($varname);
               $phpcsfile->addError($error, $stackptr, 'Superglobal', $data);
            }
        }

        $longarrays = array(
                'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_RAW_POST_VARS',
                'HTTP_SERVER_VARS', 'HTTP_COOKIE_VARS', 'HTTP_ENV_VARS',
        );

        // These are deprecated and won't work in PHP 5.4+ and thus Moodle 2.7 or higher.
        if (in_array($varname, $longarrays) === true) {
            $error = 'Global long array %s detected.  This is not only a critical security issue, but the long variables'.
                     ' were deprecated as of PHP 5.0.0 and removed in PHP 5.4.0, presenting a potentially functionality'.
                     ' issue as well.';
            $data = array($varname);
            $phpcsfile->addError($error, $stackptr, 'Superglobal', $data);
        }

    }

    /**
     * Processes the variable found within a double quoted string.

     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the double quoted string.
     */
    protected function processVariableInString(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $this->processVariable($phpcsfile, $stackptr);
    }
}
