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

include_once 'simplenamiapi/NamiWrapper.class.php';

/**
 * Erweiter NamiWrapper und überschreibt den Konstruktor, um MODX-kompatibel zu
 * sein. Außerdem werden alle öffentlichen Methoden überschrieben um Fehler zu
 * loggen.
 *
 * @author Florian
 */
class modNamiWrapper extends NamiWrapper {
    private $modx;
    
    public function __construct($modx, $config = null) {
        $this->modx = $modx;
        try {
            parent::__construct($config, null);
        } catch(Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $e, '', 'modNamiWrapper::__construct(…)', __FILE__, __LINE__);
            throw $e;
        }
    }
    
    public function request($method, $resource, $content = null, $apiMajor = null, $apiMinor = null, $encoding = null, $autoLogin = true) {
        try {
            $result = parent::request($method, $resource, $content, $apiMajor, $apiMinor, $encoding, $autoLogin);
        } catch (Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $e, '', 'modNamiWrapper::request(…)', __FILE__, __LINE__);
            throw $e;
        }
        return $result;
    }
    
    public function login($username = null, $password = null) {
        try {
            $result = parent::login($username, $password);
        } catch (Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $e, '', 'modNamiWrapper::login(…)', __FILE__, __LINE__);
            throw $e;
        }
        return $result;
    }
    
    public function logout($deleteLoginCredentials = false) {
        try {
            $result = parent::logout($deleteLoginCredentials);
        } catch (Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $e, '', 'modNamiWrapper::logout(…)', __FILE__, __LINE__);
            throw $e;
        }
        return $result;
    }
    
    // prevent getNamiWrapper snippet from accidentally printing anything
    public function __toString() {
        return '';
    }
}