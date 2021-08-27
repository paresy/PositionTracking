<?php

declare(strict_types=1);
include_once __DIR__ . '/stubs/Validator.php';
class ValidationTest extends TestCaseSymconValidation
{
    public function testValidateVictron(): void
    {
        $this->validateLibrary(__DIR__ . '/..');
    }
    public function testValidateVEDirectModule(): void
    {
        $this->validateModule(__DIR__ . '/../PositionTracking');
    }
}