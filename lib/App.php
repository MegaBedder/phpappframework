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

require_once("WsTmpl.php");
require_once("Config.php");

class App {

    private $t;
    private $cfg;

    public function __construct() {
        $this->t = new WsTmpl();
        $this->cfg = Config::getInstance();
    }

    public function gzipPrint() {
        global $HTTP_ACCEPT_ENCODING;

        if (headers_sent()) {
            $encoding = false;
        } else if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false) {
            $encoding = 'x-gzip';
        } else if (strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false) {
            $encoding = 'gzip';
        } else {
            $encoding = false;
        }

        if ($encoding) {
            $contents = ob_get_contents();
            ob_end_clean();
            header("Content-Encoding: " . $encoding);
            print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
            $size = strlen($contents);
            $contents = gzcompress($contents, 9);
            $contents = substr($contents, 0, $size);
            print($contents);
            exit();
        } else {
            ob_end_flush();
            exit();
        }
    }

    public function getHumanFilesize($size) {
        if (is_file($size)) {
            $size = filesize($size);
        } else{
            // $size is already assumed to be in bytes.
        }
        // $size = 1 to prevent dividing by zero.
        if ($size == 0) {
            $size = 1;
        }
        $filesizename = array("bytes", "kb", "mb", "gb", "tb", "pb", "eb", "zb", "yb");
        return round($size / pow(1000, ($i = floor(log($size, 1000)))), 2) . $filesizename[$i];
    }

    public function handle($input) {
        print("<pre>");
        if (is_array($input)) {
            print_r($input);
        } elseif(is_object($input)) {
            var_dump($input);
        } else {
            $input = preg_replace("/\n*$/", "", $input);
            print($input . "\n");
        }
        print("</pre>");
    }

    public function getGet($var) {
        $o = "";
        if (isset($_GET[$var])) {
            $o = $_GET[$var];
        }
        return $o;
    }

    public function getPost($var) {
        $o = "";
        if (isset($_POST[$var])) {
            $o = $_POST[$var];
        }
        return $o;
    }

    public function getPageTitle() {
        return $this->cfg->pageTitlePrefix;
    }

    public function getHeader() {
        $this->t->setData(array("page-header"=>"<h1>Welcome</h1>"));
        $this->t->setFile("../tmpl/page-header.tmpl");
        return $this->t->compile();
    }

    public function getFooter() {
        $this->t->setData(array("page-footer"=>"<p class=\"text-muted\">Footer</p>"));
        $this->t->setFile("../tmpl/page-footer.tmpl");
        return $this->t->compile();
    }

    public function getNavigation() {
        $this->t->setData(array("site-title"=>$this->cfg->siteTitle));
        $this->t->setFile("../tmpl/page-navigation.tmpl");
        return $this->t->compile();
    }

    public function getArticle() {
        $this->t->setData(array("page-article"=>"<p>Page content.</p>"));
        $this->t->setFile("../tmpl/page-article.tmpl");
        return $this->t->compile();
    }

    public function collapseChar($char, $dir) {
        return preg_replace("/" . preg_quote($char, "/") 
                . preg_quote($char, "/") . "+/", $char, $dir);
    }

    public function stripLeadingChar($char, $dir) {
        return preg_replace("/^" . preg_quote($char, "/") . "/", "", $dir);
    }

    public function stripTrailingChar($char, $dir) {
        return preg_replace("/" . preg_quote($char, "/") . "$/", "", $dir);
    }

    public function mkdirSafe($dir) {
        if (!file_exists($dir)) {
            mkdir($dir);
        }
    }

    public function mkdirRecursive($dir) {
        $dir = $this->collapseChar("/", $dir);
        $dir = $this->stripLeadingChar("/", $dir);
        $dirs = explode("/", $dir);
        foreach ($dirs as $k=>$d) {
            if ($k === 0) {
                $tomake = "/" . $d;
            } else {
                $tomake = $tomake . "/" . $d;
            }
            if (preg_match("/^" . preg_quote($this->cfg->rootDir, "/") . "\/.+/", $tomake)) {
                $this->mkdirSafe($tomake);
            }
        }
    }

    public function setup() {
    }

}
