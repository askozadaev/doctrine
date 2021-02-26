<?php


namespace App\Validator;

use Psr\Http\Message\ServerRequestInterface;

class ParametrValidator
{
    private bool $valid = false;

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function validate(ServerRequestInterface $request, array $expectedParameters)
    {
        $this->valid = false;
        if ($request->getMethod() === "GET") {
            $cnt = count($request->getQueryParams());
            if (count($expectedParameters) === $cnt) {
                $this->valid = true;
            } else {
                $this->valid = false;
            }
        }
        if ($request->getMethod() === "POST") {
            $cnt = count(json_decode($request->getBody()->getContents(), true));
            if ($cnt <= 0 || !(count($expectedParameters) === $cnt)) {
                $this->valid = false;
            } else {
                $this->valid = true;
            }
        }
    }
}
