<?php

namespace GeoSocio\EntityUtils;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Parameter Bag
 *
 * @see Symfony\Component\HttpFoundation\ParameterBag
 */
class ParameterBag implements \IteratorAggregate, \Countable
{

   /**
    * Parameter storage.
    *
    * @var array
    */
    protected $parameters;

    /**
     * Constructor.
     *
     * @param array $parameters An array of parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }


    /**
     * Returns the parameters.
     *
     * @return array An array of parameters
     */
    public function all() : array
    {
        return $this->parameters;
    }

    /**
     * Returns the parameter keys.
     *
     * @return array An array of parameter keys
     */
    public function keys() : array
    {
        return array_keys($this->parameters);
    }

    /**
     * Replaces the current parameters by a new set.
     *
     * @param array $parameters An array of parameters
     */
    public function replace(array $parameters = array()) : void
    {
        $this->parameters = $parameters;
    }

    /**
     * Adds parameters.
     *
     * @param array $parameters An array of parameters
     */
    public function add(array $parameters = array()) : void
    {
        $this->parameters = array_replace($this->parameters, $parameters);
    }

    /**
     * Returns a parameter by name.
     *
     * @param string $key     The key
     * @param mixed  $default The default value if the parameter key does not exist
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
    }

    /**
     * Sets a parameter by name.
     *
     * @param string $key   The key
     * @param mixed  $value The value
     */
    public function set(string $key, $value) : void
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Returns true if the parameter is defined.
     *
     * @param string $key The key
     *
     * @return bool true if the parameter exists, false otherwise
     */
    public function has(string $key) : bool
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * Removes a parameter.
     *
     * @param string $key The key
     */
    public function remove(string $key) : void
    {
        unset($this->parameters[$key]);
    }

    /**
     * Returns the parameter value only if it is an int.
     *
     * @param string $key     The parameter key
     * @param int    $default The default value if the parameter key does not exist
     *
     * @return int The filtered value
     */
    public function getInt(string $key, int $default = null) :? int
    {
        $value = $this->get($key);
        return is_int($value) ? $value : $default;
    }

    /**
     * Returns the parameter value only if it is a boolean.
     *
     * @param string $key     The parameter key
     * @param bool  $default The default value if the parameter key does not exist
     *
     * @return bool The filtered value
     */
    public function getBoolean(string $key, bool $default = null) :? bool
    {
        $value = $this->get($key);
        return is_bool($value) ? $value : $default;
    }

    /**
     * Returns the parameter value only if it is a string.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     *
     * @return bool The filtered value
     */
    public function getString(string $key, string $default = null) :? string
    {
        $value = $this->get($key);
        return is_string($value) ? $value : $default;
    }

    /**
     * Returns the parameter value only if it is an array
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     *
     * @return bool The filtered value
     */
    public function getArray(string $key, array $default = null) :? array
    {
        $value = $this->get($key);
        return is_array($value) ? $value : $default;
    }

    /**
     * Returns the parameter value only if it is a valid uuid.
     *
     * @param string $key     The parameter key
     * @param mixed  $default The default value if the parameter key does not exist
     *
     * @return bool The filtered value
     */
    public function getUuid(string $key, string $default = null) :? string
    {
        $value = $this->get($key);
        return is_string($value) && uuid_is_valid($value) ? $value : $default;
    }

    /**
     * Gets a single item from input.
     *
     * @param mixed $data
     * @param string $class
     */
    public function getInstance(string $key, string $class, $default = null)
    {
        return $this->getSingleInstance($this->get($key), $default);
    }

    /**
     * Gets a single item from input.
     *
     * @param mixed $data
     * @param string $class
     */
    public function getCollection(string $key, string $class, Collection $default = null) : Collection
    {
        $value = $this->get($key);
        if ($value instanceof Collection) {
            return $value;
        } elseif (is_array($value)) {
            $value = array_map(function ($item) use ($class) {
                return $this->getSingleInstance($item, $class);
            }, $value);
            $value = array_filter($value, function ($item) use ($class) {
                return $item instanceof $class;
            });
            return new ArrayCollection($value);
        } else {
            return $default;
        }
    }

    /**
     * Gets a single item from input.
     *
     * @param mixed $data
     * @param string $class
     */
    protected function getSingleInstance($data, string $class, $default = null)
    {
        if ($data instanceof $class) {
            return $data;
        } elseif (is_array($data)) {
            return new $class($data);
        } else {
            return $default;
        }
    }

    /**
     * Returns an iterator for parameters.
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }

    /**
     * Returns the number of parameters.
     *
     * @return int The number of parameters
     */
    public function count()
    {
        return count($this->parameters);
    }
}
