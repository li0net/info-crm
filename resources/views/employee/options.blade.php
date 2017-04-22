<?php
/**
 * Created by PhpStorm.
 * User: rbakl
 * Date: 21.04.2017
 * Time: 13:55
 */

@if(!empty($options))
    @foreach($options as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
@endif