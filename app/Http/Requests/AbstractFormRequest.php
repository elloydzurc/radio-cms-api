<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Dto\AbstractDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AbstractFormRequest
 *
 * @package App\Http\Requests
 */
abstract class AbstractFormRequest extends FormRequest
{
    /**
     * @return \App\Http\Dto\AbstractDto
     */
    abstract public function getData(): AbstractDto;
}
