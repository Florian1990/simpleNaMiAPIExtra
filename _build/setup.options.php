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

$output = '';
$customIniPath = $modx->getOption('core_path') . 'components/simplenamiapiextra/model/simplenamiapi/custom.ini';
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_UPGRADE:
        $iniValues = @parse_ini_file($customIniPath, false, INI_SCANNER_TYPED);
        if (!$iniValues) {
            $iniValues = ['createCustomIni' => false];
        }
        $iniValues['setUsername'] = isset($iniValues['username']);
        $iniValues['setPassword'] = isset($iniValues['password']);
    case xPDOTransport::ACTION_INSTALL:
        if (!(isset($iniValues) && is_array($iniValues))) {
            $iniValues = [];
        }
        // set default values
        $defaultValues = [
            'createCustomIni' => true,
            'serverURL' => 'https://nami.dpsg.de',
            'serverApiPath' => '/ica/rest/',
            'serverLoginLoginValue' => 'API',
            'APIVersionMajor' => 1,
            'APIVersionMinor' => 2,
            'timeout' => 7.0,
            'saveCookieInFile' => false,
            'cookieFile' => 'tmp/cookie.tmp',
            'createDirectoryMode' => '0600',
            'setUsername' => false,
            'username' => '',
            'setPassword' => false,
            'password' => '',
        ];
        
        $currentValues = array_merge($defaultValues, $iniValues);
        
        $currentValues['createCustomIniString'] = $currentValues['createCustomIni'] ? 'checked="checked"' : '';
        $currentValues['saveCookieInFileString'] = $currentValues['saveCookieInFile'] ? 'checked="checked"' : '';
        $currentValues['setUsernameString'] = $currentValues['setUsername'] ? 'checked="checked"' : '';
        $currentValues['setPasswordString'] = $currentValues['setPassword'] ? 'checked="checked"' : '';
        
        $output = '<div id="simpleNaMiAPIExtra_options" style="max-height: calc(80vh - 155px); padding-bottom: 72px;">
    <h2>simpleNaMiAPI-Installer</h2>
    <p>Vielen Dank für die Installation/das Update von simpleNaMiAPIExtra!</p><br />
    <label><input type="checkbox" name="createCustomIni" value="1" '
                . $currentValues['createCustomIniString'] . ' /> Erstelle/aktualisiere „custom.ini“.
                    Sofern sie keine der folgenden Einstellungen ändern, hat das Erstellen einer „custom.ini“ keinen Effekt.</label><br />
    <label>Server-Adresse: <input type="text" name="serverURL" value="' . $currentValues['serverURL'] . '" /></label><br />
    <label>API-Pfad: <input type="text" name="serverApiPath" value="' . $currentValues['serverApiPath'] . '" /></label><br />
    <label>Wert der Variable „login“ bei Login-Anfragen: <input type="text" name="serverLoginLoginValue" value="'
                . $currentValues['serverLoginLoginValue'] . '" /></label><br />
    <label>API-Hauptversionsnummer: <input type="text" name="APIVersionMajor" value="' . $currentValues['APIVersionMajor'] . '" /></label><br />
    <label>API-Nebenversionsnummer: <input type="text" name="APIVersionMinor" value="' . $currentValues['APIVersionMinor'] . '" /></label><br />
    <label>Zeitüberschreigung (s): <input type="text" name="timeout" value="' . $currentValues['timeout'] . '" step="0.1" /></label><br />
    <label><input type="checkbox" name="saveCookieInFile" value="1" '
                . $currentValues['saveCookieInFileString'] . ' /> Cookie in Datei speichern</label><br />
    <label>Cookie-Datei: <input type="text" name="cookieFile" value="' . $currentValues['cookieFile'] . '" />
        <small>Absoluter Pfad oder Pfad der Form „pfad/datei.ext“, welcher zu'
                . ' „{core_path}components/simplenamiapiextra/model/simplenamiapi/pfad/datei.ext“'
                . ' konvertiert wird. Achtung! Stellen Sie sicher, dass auf diese Datei nicht aus dem Web zugegriffen werden kann!</small></label><br />
    <label>Zugriffsberechtigung zum Erstellen des Cookie-Ordners (chmod): <input type="text" name="createDirectoryMode" value="'
                . $currentValues['createDirectoryMode'] . '" /></label><br />
    <label><input type="checkbox" name="setUsername" value="1" '
                . $currentValues['setUsernameString'] . ' /> Nutzername speichern?</label><br />
    <label>Nutzername: <input type="text" name="username" value="' . $currentValues['username'] . '" /></label><br />
    <label><input type="checkbox" name="setPassword" value="1" '
                . $currentValues['setPasswordString'] . ' /> Passwort speichern?
                <small>Achtung! Stellen Sie sicher, dass auf custom.ini nicht aus dem Web zugegriffen werden kann!</small></label><br />
    <label>Passwort: <input type="password" class="x-form-text x-form-field" style="width: 97%;" name="password" value="' . $currentValues['password'] . '" /></label>
</div>';
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}
return $output;