# Introduction

This is the POET Group's coding standard.  This standard is primarily focused on assisting with code reviews.  For
example, warning the code reviewer about potential security or performance problems.

This coding standard checks for the following:
 - the presence of ini_set in PHP files;
 - unconditional if statements;
 - FixMe or ToDo in code;
 - Ensuring the file ends with a newline;
 - byte order marks that may corrupt application work;
 - ensure each if statement is on a line by itself;
 - checks for no space after cast tokens;
 - all php keywords are lower case;
 - displays a message when any code prefixed with an ampersand is encountered;
 - checks to ensure that a file that declares new symbols does not cause any side effects;
 - arrays conform to the coding standard;
 - checks for the logical operators 'and' and 'or';
 - checks for alias and discouraged functions that are kept in php for compatability with older versions;
 - checks for eval;
 - looks for code that can never be executed;
 - looks for double quotes;
 - checks for slow functions in a loop;
 - checks for database portability;
 - looks for the use of RAWPARAM;
 - looks for the use of Superglobals;

# Install

Just add it to your project's `composer.json` file (`--dev` is optional based on your needs):

```
composer require --dev poetgroup/poet-coding-standard
```

# Usage

The following paths may change based on how things are installed, but basically you are looking for the path to
the CodeSniffer command and the path to the `moodle` directory of this project: 

```
vendor/bin/phpcs --standard=POET /path/to/moodle/plugin
```

# Testing

In order to run the unit tests, you must ensure that you install from source otherwise, testing code from
PHP_CodeSniffer would be missing.  Here is an example of re-installing dependencies and running tests:

```
rm -rf vendor/
composer install --prefer-source
vendor/bin/phpunit
```

Please also know that any **new** tests added need the `@group poet` annotation added.  This ensures that only tests
from the `POET` standard are run.

# License

This project is licensed under the GNU GPL v3 or later.  See the [LICENSE](LICENSE) file for details.
