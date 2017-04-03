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

$properties = [
    [
        'name' => 'name',
        'desc' => 'Der Name, unter dem das erstellte Objekt für nachfolgend ausgeführte'
        . ' Snippets zur Verfügung steht.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'modNamiWrapper',
        'lexicon' => ''
    ],
    [
        'name' => 'config',
        'desc' => 'Das Konfigurations-Array, das an den Konstruktor von modNamiWrapper'
        . ' übergeben wird. Kann nur innerhalb eines Snippets mithilfe von $modx->runSnippet()'
        . ' verwendet werden!',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => ''
    ],
    [
        'name' => 'iniFile',
        'desc' => 'Falls &iniFile ungleich null bzw. \'\' ist, wird $config[\'iniFile\']'
        . ' auf den übergebenen Wert gesetzt.  Relative Pfadangaben sind relativ'
        . ' zu {core_path}components/simplenamiapiextra/model/simplenamiapi/',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => ''
    ],
    [
        'name' => 'saveCookieInFile',
        'desc' => 'Falls saveCookieInFile ungleich null bzw. \'\' ist, wird'
        . ' $config[\'saveCookieInFile\'] auf den übergebenen Wert gesetzt.',
        'type' => 'list',
        'options' => [
            ['text' => 'null','value' => 'null'],
            ['text' => 'true','value' => true],
            ['text' => 'false','value' => false],
        ],
        'value' => 'null',
        'lexicon' => 'combo-boolean'
    ],
    [
        'name' => 'saveCookieInSession',
        'desc' => 'Falls &saveCookieInSession true ist, wird der Inhalt des NaMi-Cookies'
        . ' in $_SESSION[\'simpleNaMiAPIExtra.\' . $name] gespeichert.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
        'lexicon' => ''
    ],
];
return $properties;