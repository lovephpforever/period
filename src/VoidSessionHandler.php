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

use SessionHandlerInterface;

/**
 * The void session handler.
 */
class VoidSessionHandler implements SessionHandlerInterface
{
    /**
     * Initialize session.
     * Type-Hints are not needed for this method.
     *
     * @param string $savePath    The path where to store/retrieve the session.
     * @param string $sessionName The session name.
     *
     * @return mixed The return value (usually true on success, false on failure). Note this value is returned internally to PHP for processing.
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * Close the session.
     * Type-Hints are not needed for this method.
     *
     * @return mixed The return value (usually true on success, false on failure). Note this value is returned internally to PHP for processing.
     */
    public function close()
    {
        return true;
    }

    /**
     * Read session data.
     * Type-Hints are not needed for this method.
     *
     * @param string $id The session id.
     *
     * @return string Returns an encoded string of the read data. If nothing was read, it must return an empty string. Note this value is returned internally to PHP for processing.
     */
    public function read($id)
    {
        return "";
    }

    /**
     * Write session data.
     * Type-Hints are not needed for this method.
     *
     * @param string $id   The session id.
     * @param string $data The encoded session data. This data is the result of the PHP internally encoding the $_SESSION superglobal to a serialized string and passing it as this parameter. Please note sessions use an alternative serialization method.
     *
     * @return mixed The return value (usually true on success, false on failure). Note this value is returned internally to PHP for processing.
     */
    public function write($id, $data)
    {
        return true;
    }

    /**
     * Destroy a session.
     * Type-Hints are not needed for this method.
     *
     * @param string $id The session ID being destroyed.
     *
     * @return mixed The return value (usually true on success, false on failure). Note this value is returned internally to PHP for processing.
     */
    public function destroy($id)
    {
        return true;
    }

    /**
     * Cleanup old sessions.
     * Type-Hints are not needed for this method.
     *
     * @param int $maxlifetime Sessions that have not updated for the last max_lifetime seconds will be removed.
     *
     * @return mixed The return value (usually true on success, false on failure). Note this value is returned internally to PHP for processing.
     */
    public function gc($maxlifetime)
    {
        return true;
    }
}
