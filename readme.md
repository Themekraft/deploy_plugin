## Deploy Plugin
Contributors: @themekraft, @gfirem

This is a command line build in php to Download or Upload Freemius plugins. 

#### Download Details
```
Usage:
  download [options] [--] <path>

Arguments:
  path                           The destination path where the zip will be generated.

Options:
      --plugin-id=PLUGIN-ID      The plugin id, is easy to find in the url.
      --dev-id=DEV-ID            The Developer Id, inside product's credentials in SETTINGS -> Keys.
      --public-key=PUBLIC-KEY    The Public Key, inside product's credentials in SETTINGS -> Keys.
      --secret-key=SECRET-KEY    The Secret Key, inside product's credentials in SETTINGS -> Keys.
      --is-premium[=IS-PREMIUM]  Determine if the version to download is the Pro or Free generated zip file. Default is TRUE
      --env[=ENV]                Determine if load the dev-id, public-key and secret-key from environment. Default FALSE. The expected environment variables are FS__API_DEV_ID, FS__API_PUBLIC_KEY and FS__API_SECRET_KEY.
  -h, --help                     Display this help message
  -q, --quiet                    Do not output any message
  -V, --version                  Display this application version
      --ansi                     Force ANSI output
      --no-ansi                  Disable ANSI output
  -n, --no-interaction           Do not ask any interactive question
  -v|vv|vvv, --verbose           Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
  This command line help you to download a zip file as free and/or pro generated version.
```

```
php console.php download freeversion.zip --plugin-id= --dev-id= --public-key='' --secret-key='' --is-premium=false
```
This is a project in progress. Not finished yet. 
