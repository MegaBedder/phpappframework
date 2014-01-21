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

class Config {

    private static $singleton;

    public function __construct () {
        $this->mysqlServer = "127.0.0.1";
        $this->mysqlPort = 3306;
        $this->mysqlUsername = "root";
        $this->mysqlPassword = "pass";
        $this->mysqlDatabase = "db";

        // Edit
        $this->rootDir = "/var/www/app";
        $this->siteTitle = "Siamnet";
        $this->pageTitlePrefix = "Siamnet";

        // Not intended to be edited.
        $this->moreConfig = "blah";
    }

    public static function getInstance () {
        if (is_null(self::$singleton)) {
            self::$singleton = new config();
        }
        return self::$singleton;
    }

}
