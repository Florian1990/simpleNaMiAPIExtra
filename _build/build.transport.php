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

$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);
 
/* define package names */
define('PKG_NAME','SimpleNaMiAPIExtra');
define('PKG_NAME_LOWER','simplenamiapiextra');
define('PKG_VERSION','1.0');
define('PKG_RELEASE','dev');

/* define build paths */
$root = dirname(dirname(__FILE__)).'/';
$sources = [
    'root' => $root,
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    //'resolvers' => $root . '_build/resolvers/',
    //'chunks' => $root.'core/components/'.PKG_NAME_LOWER.'/chunks/',
    //'lexicon' => $root . 'core/components/'.PKG_NAME_LOWER.'/lexicon/',
    'docs' => $root.'core/components/'.PKG_NAME_LOWER.'/docs/',
    'elements' => $root.'core/components/'.PKG_NAME_LOWER.'/elements/',
    //'source_assets' => $root.'assets/components/'.PKG_NAME_LOWER,
    'source_core' => $root.'core/components/'.PKG_NAME_LOWER,
    ];
unset($root);

/* overwrite with your own defines */
require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');
echo '<pre>'; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
 
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
// register namespace?????

$category = $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category',PKG_NAME);
 
/* add snippets */
$modx->log(modX::LOG_LEVEL_INFO,'Packaging in snippets...');
$snippets = include $sources['data'].'transport.snippets.php';
if (empty($snippets)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in snippets.');
}
$category->addMany($snippets);
 
/* create category vehicle */
$attr = [
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
        'Snippets' => [
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
           ],
       ],
   ];
$vehicle = $builder->createVehicle($category,$attr);
$modx->log(modX::LOG_LEVEL_INFO,'Adding file resolvers to category...');
$vehicle->resolve('file', [
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
   ]);
$builder->putVehicle($vehicle);

$modx->log(modX::LOG_LEVEL_INFO,'Adding package attributes and setup options...');
$builder->setPackageAttributes([
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
    'setup-options' => [''
        . 'source' => $sources['build'].'setup.options.php',
        ],
   ]);

/* zip up package */
$modx->log(modX::LOG_LEVEL_INFO,'Packing up transport package zip...');
$builder->pack();
 
$tend= explode(" ", microtime());
$tend= $tend[1] + $tend[0];
$totalTime= sprintf("%2.4f s",($tend - $tstart));
$modx->log(modX::LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");
exit ();