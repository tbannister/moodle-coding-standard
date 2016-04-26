<?php
/**
 * POET_Sniffs_BadRequest_DatabasePrefixSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */

/**
 * POET_Sniffs_Portability_BadRequestSniff.
 *
 * Sometimes developers reference $_REQUEST fields that are not guaranteed to exist. This is an of the
 * "Local Hero" type of bug, by default new PHP installs do not include either the $_SERVER or
 * the $_ENV fields in the $_REQUEST field. This sniff checks for these fields.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Security_BadRequestSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array The array of tokens to run this sniff on.
     */
    public function register() {
        return array(T_CONSTANT_ENCAPSED_STRING);
    }

    /**
     * Check if this string is PARAM_RAW.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $content = trim($tokens[$stackPtr]['content'],"'");
        $badrequest = array(
                       'PHP_SELF',
                       'argv',
                       'argc',
                       'GATEWAY_INTERFACE',
                       'SERVER_ADDR',
                       'SERVER_NAME',
                       'SERVER_SOFTWARE',
                       'SERVER_PROTOCOL',
                       'REQUEST_METHOD',
                       'REQUEST_TIME',
                       'REQUEST_TIME_FLOAT',
                       'QUERY_STRING',
                       'DOCUMENT_ROOT',
                       'HTTP_ACCEPT',
                       'HTTP_ACCEPT_CHARSET',
                       'HTTP_ACCEPT_ENCODING',
                       'HTTP_ACCEPT_LANGUAGE',
                       'HTTP_CONNECTION',
                       'HTTP_HOST',
                       'HTTP_REFERER',
                       'HTTP_USER_AGENT',
                       'HTTPS',
                       'REMOTE_ADDR',
                       'REMOTE_HOST',
                       'REMOTE_USER',
                       'REDIRECT_REMOTE_USER',
                       'SCRIPT_FILENAME',
                       'SERVER_ADMIN',
                       'SERVER_PORT',
                       'SERVER_SIGNATURE',
                       'PATH_TRANSLATED',
                       'SCRIPT_NAME',
                       'REQUEST_URI',
                       'PHP_AUTH_DIGEST',
                       'PHP_AUTH_USER',
                       'PHP_AUTH_PW',
                       'AUTH_TYPE',
                       'PATH_INFO',
                       'ORIG_PATH_INFO',
                      );
        $validfunc = array(
                      '$GLOBALS',
                      '$_SERVER',
                      '$_GET',
                      '$_POST',
                      '$_FILES',
                      '$_COOKIE',
                      '$_SESSION',
                      '$_REQUEST',
                      '$_ENV',
                     );

        $content = trim($content,'"');

        if (in_array($content, $badrequest) === true) {
            $prebad = trim($tokens[$stackPtr - 2]['content']);
            if (in_array($prebad, $validfunc) === false) {
                $warning = 'Variable %s detected. This variable is not guaranteed to exist and should not be referenced.';
                $data = array($content);
                $phpcsFile->addWarning($warning, $stackPtr, 'Badrequest', $data);
            }
        }
    }
}
