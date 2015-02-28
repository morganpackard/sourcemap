<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev
 */

namespace axy\sourcemap;

use axy\errors\ContainerReadOnly;
use axy\sourcemap\parsing\FormatChecker;
use axy\sourcemap\parsing\Context;
use axy\sourcemap\errors\UnsupportedVersion;
use axy\errors\FieldNotExist;

/**
 * The Source Map Class
 *
 * @property-read int $version
 *                the version of the file format
 */
class SourceMap
{
    /**
     * The constructor
     *
     * @param array $data [optional]
     * @throws \axy\sourcemap\errors\InvalidFormat
     */
    public function __construct(array $data = null)
    {
        $this->context = new Context(FormatChecker::check($data));
    }

    /**
     * Returns the data of the json file
     *
     * @return array
     */
    public function getData()
    {
        return $this->context->getOutData();
    }

    /**
     * Magic isset()
     *
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        return array_key_exists($key, $this->context->data);
    }

    /**
     * Magic get
     *
     * @param string $key
     * @return mixed
     * @throws \axy\errors\FieldNotExist
     */
    public function __get($key)
    {
        switch ($key) {
            case 'version':
                return 3;
        }
        throw new FieldNotExist($key, $this, null, $this);
    }

    /**
     * Magic set
     *
     * @param string $key
     * @param mixed $value
     * @throws \axy\errors\FieldNotExist
     */
    public function __set($key, $value)
    {
        switch ($key) {
            case 'version':
                if (($value === 3) || ($value === '3')) {
                    return;
                }
                throw new UnsupportedVersion($value);
        }
        throw new FieldNotExist($key, $this, null, $this);
    }

    /**
     * Magic unset
     *
     * @param string $key
     * @throws \axy\errors\ContainerReadOnly
     */
    public function __unset($key)
    {
        throw new ContainerReadOnly($this, null, $this);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '[Source Map]';
    }

    /**
     * @var \axy\sourcemap\parsing\Context
     */
    private $context;
}
