<?php

/* 
 * Copyright 2017 Florian Will.
 *
 * Licensed under the Universal Permissive License (UPL), Version 1.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      https://opensource.org/licenses/UPL
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

$modx = $object->xpdo;
if ($modx) {
    $customIniPath = $modx->getOption('core_path') . 'components/simplenamiapiextra/model/simplenamiapi/custom.ini';
    switch($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            if (isset($options['createCustomIni']) && $options['createCustomIni']) {
                $modx->log(modX::LOG_LEVEL_INFO, 'Start installing custom.ini.');
                // set default values
                $defaultValues = [
                    'serverURL' => 'https://nami.dpsg.de',
                    'serverApiPath' => '/ica/rest/',
                    'serverLoginLoginValue' => 'API',
                    'APIVersionMajor' => 1,
                    'APIVersionMinor' => 2,
                    'timeout' => 7.0,
                    'saveCookieInFile' => false,
                    'cookieFile' => 'tmp/cookie.tmp',
                    'createDirectoryMode' => '0600',
                    'username' => '',
                    'password' => '',
                ];
                // evaluate binary options (checkboxes!)
                $options['saveCookieInFile'] = isset($options['saveCookieInFile']) && $options['saveCookieInFile'] ? 'true' : 'false';
                $options['setUsername'] = isset($options['setUsername']) && $options['setUsername'] ? 1 : 0;
                $options['setPassword'] = isset($options['setPassword']) && $options['setPassword'] ? 1 : 0;
                // load default options
                $options = array_merge($defaultValues, $options);
                // process floating point number
                $options['timeout'] = str_replace(',', '.', $options['timeout']);
                // template
                $tpl = 'serverURL = "[[+serverURL]]"
serverApiPath = "[[+serverApiPath]]"
serverLoginLoginValue = "[[+serverLoginLoginValue]]"
APIVersionMajor = [[+APIVersionMajor]]
APIVersionMinor = [[+APIVersionMinor]]
timeout = [[+timeout]]
saveCookieInFile = [[+saveCookieInFile]]
cookieFile = "[[+cookieFile]]"
createDirectoryMode = "[[+createDirectoryMode]]" ; Erwartet (oktal kodierte) Ganzzahl als Zeichenkette!
; Falls Benutzername und Passwort unverschlüsselt auf dem Server gespeichert werden
; sollen, kann eine Kopie dieser ini-Datei erstellt werden und nachfolgend die Login-
; Daten eingetragen werden.
[[+setUsername:is=`0`:then=`;`]]username = "[[+setUsername:is=`1`:then=`[[+username]]`]]"
[[+setPassword:is=`0`:then=`;`]]password = "[[+setPassword:is=`1`:then=`[[+password]]`]]"';
                // generate file content
                $chunk = $modx->newObject('modChunk');
                $chunk->setContent($tpl);
                $iniFileContent = $chunk->process($options);
                // save File
                $file = @fopen($customIniPath, 'w');
                if ($file) {
                    $success = fwrite($file, $iniFileContent);
                }
                if ($file && $success) {
                    // set default ini-File to custom.ini
                    $snippet = $modx->getObject('modSnippet', ['name' => 'getNamiWrapper']);
                    $properties = [
                        [
                            'name' => 'iniFile',
                            'desc' => 'Falls &iniFile ungleich null bzw. \'\' ist, wird $config[\'iniFile\']'
                            . ' auf den übergebenen Wert gesetzt.  Relative Pfadangaben sind relativ'
                            . ' zu {core_path}components/simplenamiapiextra/model/simplenamiapi/',
                            'type' => 'textfield',
                            'options' => '',
                            'value' => 'custom.ini',
                            'lexicon' => ''
                            ]
                        ];
                    $snippet->setProperties($properties, true);
                    $snippet->save();
                } else {
                    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not create, open, or write'
                            . ' to custom ini file located at ' . var_export($customIniPath, $true),
                            '', 'simpleNaMiAPIExtra install/upgrade: resolve.ini.php');
                }
                $modx->log(modX::LOG_LEVEL_INFO, 'Finished installing custom.ini!');
            }
            break;
    }
}
return true;