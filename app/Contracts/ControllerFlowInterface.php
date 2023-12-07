<?php

namespace App\Contracts;

interface ControllerFlowInterface
{
    public function successResponse(string $message, $data = null, int $status = 200);
    public function errorResponse(string $message, int $status = 400);
}
