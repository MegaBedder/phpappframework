<?php

/*
Copyright 2013 Weldon Sams

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

session_start();
$sessid = session_id();

require_once("../lib/Config.php");
require_once("../lib/App.php");
require_once("../lib/WsTmpl.php");

$a = new App();
$a->setup();
$t = new WsTmpl();

ob_start();
ob_implicit_flush(0);

if ($a->isGet("a", "someAction")) {
    print(json_encode(array("var"=>"val")));
}


$a->gzipPrint();
