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
 * werden
 *
 * @author Florian
 */
class modNamiWrapper extends NamiWrapper {
    public function __construct($modx, $config = null) {
        parent::__construct($config, null);
    }
}