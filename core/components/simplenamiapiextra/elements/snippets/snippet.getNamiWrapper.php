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

/**
 * getNamiWrapper
 * 
 * BESCHREIBUNG
 * 
 * Dieses Snippet ruft $modx-getService() auf um ein Objekt der Klasse modNamiWrapper
 * bereitzustellen.
 * 
 * EIGENSCHAFTEN
 * 
 * &name string Optional. Standardwert: 'modNamiWrapper'. Der Name, unter dem das
 *     erstellte Objekt für nachfolgend ausgeführte Snippets zur Verfügung steht.
 * &config array Optional. Standardwert: `[]`. Das Konfigurations-Array, das an
 *     den Konstruktor von modNamiWrapper übergeben wird.
 * &iniFile string|null Optional. Standardwert: null. Falls &iniFile ungleich null
 *     bzw. '' ist, wird $config['iniFile'] auf den übergebenen Wert gesetzt.  Relative
 *     Pfadangaben sind relativ zu {core_path}components/simplenamiapiextra/model/simplenamiapi/
 * &saveCookieInFile boolean|null Optional. Standardwert: null. Falls &saveCookieInFile
 *     ungleich null bzw. '' ist, wird $config['saveCookieInFile'] auf den übergebenen
 *     Wert gesetzt.
 * &saveCookieInSession boolean Optional. Standardwert: false. Falls &saveCookieInSession
 *     true ist, wird der Inhalt des NaMi-Cookies in $_SESSION['simpleNaMiAPIExtra.' . &name]
 *     gespeichert.
 */

// process values and set default values
if (!(isset($name) && is_string($name) && '' != $name)) {
    $name = 'modNamiWrapper';
}
if (!(isset($config) && is_array($config))) {
    $config = [];
}
if (isset($iniFile) && is_string($iniFle) && '' != $iniFile) {
    $config['iniFile'] = $iniFile;
}
if (isset($saveCookieInFile) && null != $saveCookieInFile && '' != $saveCookieInFile) {
    $config['saveCookieInFile'] = $saveCookieInFile;
}
if (isset($saveCookieInSession) && $saveCookieInSession) {
    $config['apiSessionNameRef'] =& $_SESSION['simpleNaMiAPIExtra.' . $name]['apiSessionName'];
    $config['apiSessionTokenRef'] =& $_SESSION['simpleNaMiAPIExtra.' . $name]['apiSessionToken'];
}

$modx->getService($name,
        'modNamiWrapper',
        $modx->getOption('simplenamiapiextra.core_path', null, $modx->getOption('core_path') . 'components/simplenamiapiextra/') . 'model/',
        $config);

return '';