# POET Coding Standard


## Looping Over Slow Functions
Usage of slow functions from within loops could lead to performance problems.  Often times, database queries in
    loops can be removed from the loop and rewritten to grab the data in a single query.
## Built In Database Methods
Moodle comes with its own database layer.  The base class is *moodle_database*
    and it is accessed by the *$DB* global variable.  This layer takes care of supporting
    various database backends.  All interactions with the database must go through this class.
## Database Table Prefix
SQL written for Moodle should not include the table prefix.  The table name should just be passed into the
    *moodle_database* class method or if using raw SQL, the table name should be surrounded by curly brackets.
  <table>
   <tr>
    <th>Valid: Not using the prefix.</th>
    <th>Invalid: Using the prefix.</th>
   </tr>
   <tr>
<td>

    $DB->get_records('user', ['id' => 1]);
    $DB->get_records_sql('SELECT * FROM {user} WHERE id = ?', [1]);

</td>
<td>

    $DB->get_records('mdl_user', ['id' => 1]);
    $DB->get_records_sql('SELECT * FROM mdl_user WHERE id = ?', [1]);

</td>
   </tr>
  </table>
## Request Variables
Some request variables are not reliable or have been removed in later versions of PHP.  Usage of them should
    be avoided.
## Deprecated Parameter Constants
The constants prefixed with *PARAM_* within Moodle are used for cleaning parameters. Deprecated constants should not be used.
    Always try to use the most specific constant possible, EG: PARAM_TEXT instead of PARAM_CLEAN.
## Modifying PHP Configuration Settings
Cannot use the *ini_set* PHP function.  This can cause unexpected behavior.
  <table>
   <tr>
    <th>Valid: Use Moodle method to modify PHP settings.</th>
    <th>Invalid: Directly calling ini_set.</th>
   </tr>
   <tr>
<td>

    raise_memory_limit(MEMORY_HUGE);

</td>
<td>

    ini_set('memory_limit', '1G');

</td>
   </tr>
  </table>
## Superglobals
Not allowed to read values from PHP superglobals like *$_GET*, *$_POST*, etc.
  <table>
   <tr>
    <th>Valid: Use Moodle methods to access request data.</th>
    <th>Invalid: Use of $_GET.</th>
   </tr>
   <tr>
<td>

    $id = required_param('id', PARAM_INT);
    $action = optional_param('action', 'default', PARAM_ALPHANUMEXT);

</td>
<td>

    $id = $_GET['id'];
    $action = !empty($_GET['action']) ? $_GET['action'] : 'default';

</td>
   </tr>
  </table>
## Warn About Raw SQL Functions
Moodle provides a number of helper functions for accessing the database, including some functions that allow
    the use of raw SQL. This can be problematic if the SQL is complext, inefficient, or includes parameters
    correctly. For this reason, this sniff warns about the use of these functions for further investigation.
  <table>
   <tr>
    <th>Valid: Use placeholders for parameters.</th>
    <th>Invalid: Using string concatenation for parameters.</th>
   </tr>
   <tr>
<td>

    $DB->get_records_sql('SELECT * FROM {course} WHERE shortname = ?', [$get]);

</td>
<td>

    $DB->get_records_sql('SELECT * FROM {course} WHERE shortname = '.$get);

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: Make use of indexes when dealing with large data sets.</th>
    <th>Invalid: There is no index on just username.</th>
   </tr>
   <tr>
<td>

    $DB->get_records_sql('
        SELECT c.*
          FROM {user_enrolments} ue
          JOIN {enrol} e ON e.id = ue.enrolid
          JOIN {course} c ON e.courseid = c.id
          JOIN {user} u ON ue.userid = u.id
         WHERE u.username = ?
           AND u.mnethostid = ?
    ', [$USER->username, $CFG->mnet_localhost_id]);

</td>
<td>

    $DB->get_records_sql('
        SELECT c.*
          FROM {user_enrolments} ue
          JOIN {enrol} e ON e.id = ue.enrolid
          JOIN {course} c ON e.courseid = c.id
          JOIN {user} u ON ue.userid = u.id
         WHERE u.username = ?
    ', [$USER->username]);

</td>
   </tr>
  </table>
## Manual Inclusion of jQuery
Including jQuery and associated libraries manually can cause issues. The versions bundled with Moodle should be used.
  <table>
   <tr>
    <th>Valid: Use Moodle's JQuery library.</th>
    <th>Invalid: Using your own JQuery library.</th>
   </tr>
   <tr>
<td>

    $PAGE->requires->jquery();

</td>
<td>

    $PAGE->requires->js('/mod/foo/jquery.js');

</td>
   </tr>
  </table>
## Unconditional If Statements
If statements that are always evaluated should not be used.
  <table>
   <tr>
    <th>Valid: An if statement that only executes conditionally.</th>
    <th>Invalid: An if statement that is always performed.</th>
   </tr>
   <tr>
<td>

    if ($test) {
        $var = 1;
    }

</td>
<td>

    if (true) {
        $var = 1;
    }

</td>
   </tr>
  </table>
  <table>
   <tr>
    <th>Valid: An if statement that only executes conditionally.</th>
    <th>Invalid: An if statement that is never performed.</th>
   </tr>
   <tr>
<td>

    if ($test) {
        $var = 1;
    }

</td>
<td>

    if (false) {
        $var = 1;
    }

</td>
   </tr>
  </table>
## Todo Comments
FIXME Statements should be taken care of.
  <table>
   <tr>
    <th>Valid: A comment without a fixme.</th>
    <th>Invalid: A fixme comment.</th>
   </tr>
   <tr>
<td>

    // Handle strange case
    if ($test) {
        $var = 1;
    }

</td>
<td>

    // FIXME: This needs to be fixed!
    if ($test) {
        $var = 1;
    }

</td>
   </tr>
  </table>
## Todo Comments
TODO Statements should be taken care of.
  <table>
   <tr>
    <th>Valid: A comment without a todo.</th>
    <th>Invalid: A todo comment.</th>
   </tr>
   <tr>
<td>

    // Handle strange case
    if ($test) {
        $var = 1;
    }

</td>
<td>

    // TODO: This needs to be fixed!
    if ($test) {
        $var = 1;
    }

</td>
   </tr>
  </table>
## Byte Order Marks
Byte Order Marks that may corrupt your application should not be used.  These include 0xefbbbf (UTF-8), 0xfeff (UTF-16 BE) and 0xfffe (UTF-16 LE).
## Multiple Statements On a Single Line
Multiple statements are not allowed on a single line.
  <table>
   <tr>
    <th>Valid: Two statements are spread out on two separate lines.</th>
    <th>Invalid: Two statements are combined onto one line.</th>
   </tr>
   <tr>
<td>

    $foo = 1;
    $bar = 2;

</td>
<td>

    $foo = 1; $bar = 2;

</td>
   </tr>
  </table>
## Space After Casts
Spaces are not allowed after casting operators.
  <table>
   <tr>
    <th>Valid: A cast operator is immediately before its value.</th>
    <th>Invalid: A cast operator is followed by whitespace.</th>
   </tr>
   <tr>
<td>

    $foo = (string)1;

</td>
<td>

    $foo = (string) 1;

</td>
   </tr>
  </table>
## Lowercase Keywords
All PHP keywords should be lowercase.
  <table>
   <tr>
    <th>Valid: Lowercase array keyword used.</th>
    <th>Invalid: Non-lowercase array keyword used.</th>
   </tr>
   <tr>
<td>

    $foo = array();

</td>
<td>

    $foo = Array();

</td>
   </tr>
  </table>
## Line Endings
Unix-style line endings are preferred (&quot;\n&quot; instead of &quot;\r\n&quot;).
## Deprecated Functions
Deprecated functions should not be used.
  <table>
   <tr>
    <th>Valid: A non-deprecated function is used.</th>
    <th>Invalid: A deprecated function is used.</th>
   </tr>
   <tr>
<td>

    $foo = explode('a', $bar);

</td>
<td>

    $foo = split('a', $bar);

</td>
   </tr>
  </table>
## PHP Code Tags
Always use &lt;?php ?&gt; to delimit PHP code, not the &lt;? ?&gt; shorthand. This is the most portable way to include PHP code on differing operating systems and setups.
## Silenced Errors
Suppressing Errors is not allowed.
  <table>
   <tr>
    <th>Valid: isset() is used to verify that a variable exists before trying to use it.</th>
    <th>Invalid: Errors are suppressed.</th>
   </tr>
   <tr>
<td>

    if (isset($foo) && $foo) {
        echo "Hello\n";
    }

</td>
<td>

    if (@$foo) {
        echo "Hello\n";
    }

</td>
   </tr>
  </table>
## Closing PHP Tags
Files should not have closing php tags.
  <table>
   <tr>
    <th>Valid: No closing tag at the end of the file.</th>
    <th>Invalid: A closing php tag is included at the end of the file.</th>
   </tr>
   <tr>
<td>

    <?php
    $var = 1;

</td>
<td>

    <?php
    $var = 1;
    ?>

</td>
   </tr>
  </table>
Documentation generated on Fri, 10 Jun 2016 12:59:10 -0700 by [PHP_CodeSniffer 2.6.0](https://github.com/squizlabs/PHP_CodeSniffer)