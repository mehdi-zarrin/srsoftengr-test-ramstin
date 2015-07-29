<?php



namespace Application\src;

class Validator
{
    public static function validate($queueContents, $validKeys)
    {
        if (!is_array($queueContents)) {
            throw new \InvalidArgumentException();
        }

        if (count($queueContents) != count($validKeys)) {
            return false;
        }

        foreach ($queueContents as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }

        return true;
    }
}
