<?php



namespace Application\src\Tests;

use Application\src\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;
    public function setUp()
    {
        $this->validator = new Validator();
    }

    public function invalidArgs()
    {
        return [
                ['string'],
                [1],
                [2.5],
                [-3],
            ];
    }

        /**
         * @dataProvider invalidArgs
         * @expectedException InvalidArgumentException
         */
        public function testNonArrayArgumentPassedToValidate($input)
        {
            $this->validator->validate($input, $input);
        }

    public function testArrayKeysCountIsEquals()
    {
        $arr1 = [
                'name',
                'mobno',
                'email',
            ];

        $arr2 = [
                'name',
                'mobno',
                'email',
            ];

        $this->assertTrue($this->validator->validate($arr1, $arr2));
    }

    public function testArrayKeysCountIsNotEquals()
    {
        $arr1 = [
                'name',
                'mobno',
                'email',
            ];

        $arr2 = [
                'name',
                'mobno',
            ];

        $this->assertFalse($this->validator->validate($arr1, $arr2));
    }

    public function testArrayValuesAreEmpty()
    {
        $arr1 = [
                'name' => '' ,
                'mobno' => '',
                'email' => '',
            ];

        $arr2 = [
                'name' ,
                'mobno',
                'email',
            ];

        $this->assertFalse($this->validator->validate($arr1, $arr2));
    }

    public function testArrayValuesAreNotEmpty()
    {
        $arr1 = [
                'name' => '1' ,
                'mobno' => '2',
                'email' => '3',
            ];

        $arr2 = [
                'name' ,
                'mobno',
                'email',
            ];

        $this->assertTrue($this->validator->validate($arr1, $arr2));
    }
}
