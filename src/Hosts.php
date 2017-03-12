<?php

namespace Venom;

use Exception;

class Hosts
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var string
     */
    protected $bakPath;

    /**
     * @var array
     */
    protected $lines = [];

    /**
     * Hosts constructor.
     *
     * @param $filePath
     *
     * @throws Exception
     */
    public function __construct($filePath)
    {
        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new Exception(sprintf('Unable to read file: %s', $filePath));
        }

        $this->filePath = realpath($filePath);
        $this->bakPath = realpath($filePath) . '.bak';

        $this->readFile();
    }

    /**
     * Return lines
     *
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Add a line
     *
     * @param        $ip
     * @param        $domain
     * @param string $subDomains
     *
     * @return $this
     * @throws Exception
     */
    public function addLine($ip, $domain, $subDomains = '')
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new Exception(sprintf("'%s', is not a valid ip", $ip));
        }

        if (!filter_var($domain, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/^[a-zA-Z0-9\\.]*[a-zA-Z0-9]+?/"]])) {
            throw new Exception(sprintf("'%s', is not a valid domain", $ip));
        }

        $this->lines[$domain] = ['ip' => $ip, 'subdomains' => $subDomains];

        return $this;
    }

    /**
     * Save the file
     *
     * @param null $filePath
     */
    public function save($filePath = null)
    {
        if (is_null($filePath)) {
            $filePath = $this->filePath;
        }

        $this->writeFile($filePath);
    }

    /**
     * Read the File
     */
    protected function readFile()
    {
        $file = fopen($this->filePath, 'r');

        while(($line = fgets($file)) !== false) {
            $this->parseLine($line);
        }

        fclose($file);
    }

    /**
     * Parse a line
     *
     * @param $line
     */
    protected function parseLine($line)
    {
        $regex = "/^\\s*(?:#.*$)|(?<ip>(?:[0-9\\.]+)|(?:[A-Fa-f0-9:]+))\\s+(?<name>[a-zA-Z0-9\\.]+)\\s*(?:#.*)?$/mi";

        if (preg_match($regex, $line, $matches) > 0) {
            if (isset($matches['ip']) && isset($matches['name'])) {
                $this->addLine($matches['ip'], $matches['name']);
            }
        }
    }

    /**
     * Write lines to the file
     *
     * @param $filePath
     *
     * @return $this
     * @throws Exception
     */
    protected function writeFile($filePath)
    {
        if (is_file($filePath) && !is_writable($filePath)) {
            throw new Exception(sprintf("File '%s' is not writable", $filePath));
        }

        $file = fopen($filePath, 'w');

        foreach ($this->lines as $domainLine => $ip) {
            fwrite($file, "$ip\t\t$domainLine \r\n");
        }

        fclose($file);
    }
}