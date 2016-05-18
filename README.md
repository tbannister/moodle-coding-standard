# Introduction

This is the POET Group's coding standard.  This standard is primarily focused on assisting with code reviews.  For
example, warning the code reviewer about potential security or performance problems.

Please visit the [coding standard documentation](POET.md) for further details.

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

# Documenting

To update the standard's documentation, use the following command:

```
vendor/bin/phpcs --standard=POET --generator=markdown > POET.md
```

# License

This project is licensed under the GNU GPL v3 or later.  See the [LICENSE](LICENSE) file for details.
