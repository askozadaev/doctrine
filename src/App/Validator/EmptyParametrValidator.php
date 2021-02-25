<?php


namespace App\Validator;

use Psr\Http\Message\ServerRequestInterface;

class EmptyParametrValidator
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


/*        var_dump("trace 1");
        var_dump((string) $request->getMethod() === "POST");
        var_dump((int) implode($request->getQueryParams()) == $expectedParameters);
        var_dump(!($expectedParameters === 0));
        var_dump((int) implode($request->getQueryParams()));*/
        /*        if (!($expectedParameters === 0)) {
                    var_dump("trace 2");
                    if ((string) $request->getMethod() === "POST" || (int) implode($request->getQueryParams()) > $expectedParameters) {
                        var_dump("trace 3");
                        $this->valid = false;
                    } else {
        //                var_dump("trace 4");
                        $this->valid = true;
                    }
                }*/
    }
}
