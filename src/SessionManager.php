<?php declare(strict_types=1);
/**
 * MIT License
 *
 * Copyright (c) 2021 LovePHPForever
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Period;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * The session manager.
 */
final class SessionManager implements ArrayAccess, Countable, IteratorAggregate, SessionManagerInterface, Traversable
{
    /**
     * Construct a new session manager.
     *
     * @param string|null $sessionName The session name to set before session initialisation.
     * @param bool        $key         Should we autostart the session upon class construction?
     *
     * @return void No value is returned.
     */
    public function __construct(?string $sessionName = null, bool $autostart = true)
    {
        if ($sessionName) {
            session_name($sessionName);
        }
        $autostart ? $this->start() : null;
    }

    /**
     * Count the number of active sessions.
     *
     * @return int Returns the number of active sessions.
     */
    public function count()
    {
        //
    }

    /**
     * Delete a key.
     *
     * @param string|int $key The key to delete.
     *
     * @return void No value is returned.
     */
    public function delete(string|int $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Check to see if a session exists.
     *
     * @return bool Returns true on a active session and false if not.
     */
    public function exists(): bool
    {
        if (php_sapi_name() !== 'cli') {
            return session_status() === PHP_SESSION_ACTIVE ? true : false;
        }
        return false;
    }

    /**
     * Key to retrieve.
     *
     * @param string|int $key          The key to retrieve.
     * @param mixed      $defualtValue The defualt value to return.
     *
     * @return mixed Can return all value types.
     */
    public function flash(string|int $key, mixed $defualtValue = null): mixed
    {
        $value = $this->has($key, $defualtValue);
        $this->delete($key);
        return $value;
    }

    /**
     * Key to retrieve.
     *
     * @param string|int $key          The key to retrieve.
     * @param mixed      $defualtValue The defualt value to return.
     *
     * @return mixed Can return all value types.
     */
    public function get(string|int $key, mixed $defualtValue = null): mixed
    {
        return $this->has($key) ? $_SESSION[$key] : $defualtValue;
    }

    /**
     * This iterator allows to unset and modify values and keys while iterating over Arrays and Objects.
     * Type-Hints are not needed for this method.
     *
     * @return void No value is returned.
     */
    public function getIterator()
    {
        return new ArrayIterator($_SESSION);
    }

    /**
     * Whether a key exists.
     *
     * @param string|int $key A key to check for.
     *
     * @return bool Returns true on success or false on failure. 
     */
    public function has(string|int $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Whether an offset exists.
     * Type-Hints are not needed for this method.
     *
     * @param mixed $offset An offset to check for.
     *
     * @return bool Returns true on success or false on failure. 
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Offset to retrieve.
     * Type-Hints are not needed for this method.
     *
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Assign a value to the specified offset.
     * Type-Hints are not needed for this method.
     *
     * @param mixed $offset The offset to assign the value to. 
     * @param mixed $value  The value to set.
     *
     * @return void No value is returned.
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * Unset an offset.
     * Type-Hints are not needed for this method.
     *
     * @param mixed $offset The offset to unset. 
     *
     * @return void No value is returned. 
     */
    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    /**
     * Assign a value to the specified key.
     *
     * @param string|int $key   The key to assign the value to. 
     * @param mixed      $value The value to set.
     *
     * @return void No value is returned.
     */
    public function set(string|int $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Start or resume a session.
     *
     * @param array $override A list of config variables to override.
     *
     * @return bool Returns true on success or false on failure. 
     */
    public function start(array $override = []): bool
    {
        return session_start($override);
    }

    /**
     * Stop a session.
     *
     * @return bool Returns true on success or false on failure. 
     */
    public function stop(): bool
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires'  => time() - 42000,
                'path'     => $params["path"],
                'domain'   => $params["domain"],
                'secure'   => $params["secure"],
                'httponly' => $params["httponly"],
                'samesite' => $params["samesite"],
            ]);
        }
        return session_destroy();
    }
}
