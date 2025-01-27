<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface ControllerInterface
{
    public function update(Request $request, int $id): JsonResponse;

    public function create(Request $request): JsonResponse;

    public function delete(int $id): JsonResponse;

    public function index(Request $request): JsonResponse;

    public function select(int $id): JsonResponse;
}
