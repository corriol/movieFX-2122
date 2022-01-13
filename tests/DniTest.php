<?php

declare(strict_types=1);

namespace Tests\Dojo;

use App\Dni;
use DomainException;
use LengthException;
use PHPUnit\Framework\TestCase;

class DniTest extends TestCase
{
    private array $arrayDni;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->arrayDni =
            ["00000012N",
            "00000013J",
            "00000011B"];
    }
    protected function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    public function testShouldFailWhenDniLongerThanMaxLength()
    {
        $this->expectException(DomainException::class);
        $dni = new Dni('0123456789');
    }

    public function testShouldFailWhenDniShorterThanMinLength() {
        $this->expectException(DomainException::class);
        $dni = new Dni('01234567');
    }

    public function testShouldFailWhenDniEndsWithANumber(): void {
        $this->expectException(DomainException::class);
        $dni = new Dni("012345678");
    }

    public function testShouldFailWhenDniEndsWithAnInvalidLetter(): void {
        $this->expectException(DomainException::class);
        $dni = new Dni("01234567I");
    }

    public function testShouldFailWhenDniHasLettersInTheMiddle(): void {
        $this->expectException(DomainException::class);
        $dni = new Dni("01234AB7R");
    }

    public function testShouldFailWhenDniStartsWithALetterOtherThanXYZ(): void {
        $this->expectException(DomainException::class);
        $dni = new Dni("A1234567R");
    }

    public function testShouldFailWhenInvalidDni(): void {
        $this->expectException(\InvalidArgumentException::class);
        $dni = new Dni("00000000S");
    }

    public function testShouldConstructValidDniEndingWithT(): void {
        $dni = new Dni("00000000T");
        $this->assertEquals("00000000T", (string) $dni);
    }

    public function testShouldConstructValidDniEndingWithR() : void
    {
        $dni = new Dni('00000001R');
        $this->assertEquals('00000001R', (string) $dni);
    }

    public function testShouldConstructValidDNIEndingWithW() : void
    {
        $dni = new Dni('00000002W');
        $this->assertEquals('00000002W', (string) $dni);
    }

    public function testShouldConstructValidDNIEndingWithF() : void
    {
        $dni = new Dni('86641720F');
        $this->assertEquals('86641720F', (string) $dni);
    }

    public function testShouldConstuctValidDni(): void {
        foreach ($this->arrayDni as $dni) {
            $dni = new Dni($dni);
            $this->assertEquals($dni, (string) $dni);
        }
    }

    public function testShouldConstructValidNIEStartingWithY() : void
    {
        $dni = new Dni('Y0000000Z');
        $this->assertEquals('Y0000000Z', (string) $dni);
    }

    public function testShouldConstructValidNieStartingWithZ() : void
    {
        $dni = new Dni('Z1308173F');
        $this->assertEquals('Z1308173F', (string) $dni);
    }

    public function testShouldConstructValidNieStartingWithX() : void
    {
        $dni = new Dni('X4788063S');
        $this->assertEquals('X4788063S', (string) $dni);
    }
}