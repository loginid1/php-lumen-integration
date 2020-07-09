# Windows Environment Setup

This document will walk you through the process of installing all the dependencies required to run the `laravel/lumen` OIDC integration.

## Git

To install git, you just need to go to [Git download page](https://git-scm.com/download/win), download it and follow the installer instructions.

## PHP

There are many ways to get your PHP environment up and running, for this Windows setup we are going to use WAMP server.

Before installing WAMP, make sure you have `Microsoft Visual C++` installed, if you don't have it installed or you are not sure about it, you can download and install it from this [link](https://aka.ms/vs/16/release/vc_redist.x64.exe).

Download WAMP server from this [link](https://sourceforge.net/projects/wampserver/files/latest/download) and install it following the installer instructions.

After installing WAMP, to avoid `cURL` failing the certificate validation from OIDC requests, download the [cacert.pem](https://curl.haxx.se/ca/cacert.pem) into the PHP folder. Since we are using WAMP with the default installation and, for this setup, we are using `PHP 7.3.12` the path to add the `cacert.pem` is `C:\wamp64\bin\php\php7.3.12\extras\ssl`.

Now you just need to edit the `php.ini` file to map the root certificates and enable SQLite extension. To do this, open `C:\wamp64\bin\php\php7.3.12\php.ini` on your editor of choice and search for `extension=openssl` and `extension=sqlite3` and uncomment these by removing the `;`. In the same file, search for `curl.cainfo` and `openssl.cafile`, uncomment these by removing the `;` and add the `cacert.pem` path (`C:\wamp64\bin\php\php7.3.12\extras\ssl\cacert.pem`). After these changes, you can save, close the editor and start the WAMP server. Your `php.ini` file should look like the following:

```txt
;;;;;;;;;;;;;;;;;;;
; About php.ini   ;
;;;;;;;;;;;;;;;;;;;
; PHP's initialization file, generally called php.ini, is responsible for
; configuring many of the aspects of PHP's behaviour.

...

extension=openssl
extension=sqlite3

...

[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo="C:\wamp64\bin\php\php7.3.12\extras\ssl\cacert.pem"

[openssl]
; The location of a Certificate Authority (CA) file on the local filesystem
; to use when verifying the identity of SSL/TLS peers. Most users should
; not specify a value for this directive as PHP will attempt to use the
; OS-managed cert stores in its absence. If specified, this value may still
; be overridden on a per-stream basis via the "cafile" SSL stream context
; option.
openssl.cafile="C:\wamp64\bin\php\php7.3.12\extras\ssl\cacert.pem"

...
```

## Composer

Download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) - it will install the latest composer version whenever it is executed.

The installer will download composer for you and set up your `Path` environment variable so you can simply call composer from any directory.

## SQLite

To work with SQLite on Windows, you need to [download](https://www.sqlite.org/2020/sqlite-tools-win32-x86-3320300.zip) the command-line shell program. The installation process is simple and straightforward.

- Create a new folder (e.g. `C:\Program Files\SQLite`).
- Extract the content of the file that you downloaded in the previous section to the `C:\Program Files\SQLite` folder. You should see three programs in the `C:\Program Files\SQLite` folder (`sqldiff.exe`, `sqlite3.exe`, `sqlite3_analyzer.exe`).
- Set up your `Path` environment variable so you can simply call `sqlite3` from any directory.

To setup the Windows environment variable first open the Control Panel (`Win` + `R`, type `control`, press `OK`). Navigate to `System and Security`:
![Control Panel](assets/windows_control_panel_001.png?raw=true)
Select `System`:
![Control Panel](assets/windows_control_panel_002.png?raw=true)
Under the `Control Panel` > `System and Security` > `System` menu select `Advanced system settings`:
![Control Panel](assets/windows_control_panel_003.png?raw=true)
Then, under the `Advanced` tab, click on the `Environment Variables...` button:
![Control Panel](assets/windows_control_panel_004.png?raw=true)
Find the `Path` row under `System variables`, select it and click the `Edit...` button:
![Control Panel](assets/windows_control_panel_005.png?raw=true)
Click the `New` button and add the `C:\Program Files\SQLite` folder path as a new row and Click `OK`
![Control Panel](assets/windows_control_panel_006.png?raw=true)
