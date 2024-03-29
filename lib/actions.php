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

if ($a->isGet("a", "index") && $a->isGet("s", "all")) {
    $a->setPageTitle("All documents index");
    $a->setHeader("All documents index");
    $a->setArticle("Some page content.");
} else if ($a->isGet("a", "view") && $a->isGetSet("d") && $a->isGetSet("f") && $a->isGetSet("t")) {
    $a->setPageTitle($a->getGet("t"));
    $a->setHeader($a->getGet("t"));
    $a->setArticle("Other page content.");
} else {
    $a->setPageTitle("Home");
    $a->setHeader("Welcome");
    $a->setArticle("This is the home page.");
}
