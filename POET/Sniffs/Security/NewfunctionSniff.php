<?php
/**
 * POET_Sniffs_Security_NewfunctionSniff.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      https://github.com/POETGroup/poet-coding-standard
 */

/**
 * POET_Sniffs_Security_NewfunctionSniff.
 *
 * Checks for functions present in PHP 7 and above.
 *
 * @author    Derek Henderson <derek.henderson@remote-learner.net>
 * @copyright 2016 Remote-Learner, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @link      http://git.remote-learner.net/private.cgi?p=codelibrary_scripts.git
 */
class POET_Sniffs_Security_NewfunctionSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * A list of new functions not present in older versions of PHP.
     *
     */
    public function register () {
        $newfunctions = array (
        'curl_multi_errno',
        'curl_share_errno',
        'curl_share_strerror',
        'deflate_add',
        'deflate_init',
        'error_clear_last',
        'gc_mem_caches',
        'get_resources',
        'get_return',
        'gmp_random_seed',
        'inflate_add',
        'inflate_init',
        'intdiv',
        'is_iterable',
        'pcntl_async_signals',
        'posix_setrlimit',
        'preg_replace_callback_array',
        'random_bytes',
        'random_int',
        'session_create_id',
        'session_gc',
        'socket_export_stream',
        'unserialize',
         );
        $this->newfunctionnames = ($newfunctions);
        return array(T_STRING);
    }
    public function process(PHP_CodeSniffer_File $phpcsfile, $stackptr) {
        $tokens = $phpcsfile->getTokens();
        $ignore = array(
            T_DOUBLE_COLON,
            T_OBJECT_OPERATOR,
            T_FUNCTION,
            T_CONST,
        );

        $prevtoken = $phpcsfile->findprevious(T_WHITESPACE, ($stackptr - 1), null, true);
        if (in_array($tokens[$prevtoken]['code'], $ignore) === true) {
            return;
        }
        $function = strtolower($tokens[$stackptr]['content']);
        if (in_array($function, $this->newfunctionnames) === true) {
            if ($function === 'unserialize') {
                $closingb = strtolower($tokens[$stackptr + 2]['content']);
                if ($closingb !== ')') {
                    $warning = 'The options on unserialize is supported in newer versions of PHP. It should not be used .';
                    $phpcsfile->addWarning($warning, $stackptr);
                }
            } else {
                $warning = 'The function '.$function .' is a function supported in newer versions of PHP. It should not be used.';
                $phpcsfile->addWarning($warning, $stackptr);
            }
        }
    }
}
