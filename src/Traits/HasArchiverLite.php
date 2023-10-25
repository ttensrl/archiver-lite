<?php
/**
 * Created by PhpStorm.
 * Filename: HasArchiverLite.php
 * User: Stefano Pimpolari
 * Email: spimpolari@gmail.com
 * Project: laravel-bricks-bootstrap5
 * Date: 07/03/22
 * Time: 16:34
 * MIT License
 *
 * Copyright (c) [2022] [laravel-bricks-bootstrap5]
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

namespace TtenSrl\ArchiverLite\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;
use function PHPUnit\Framework\isNull;

trait HasArchiverLite
{
    use InteractsWithMedia;

    /**
     * @return mixed
     */
    public function getDefaultMedia($collection_name = null)
    {
        if(isNull($collection_name)) {
            return $this->media()->where('default', 1)->first();
        } else {
            return $this->media()->where('collection_name', $collection_name)->where('default', 1)->first();
        }
    }

}
