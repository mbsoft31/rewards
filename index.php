<?php

require 'vendor/autoload.php';

class AlgerianNationalID
{
    protected string $id;

    protected string $sex = '';

    protected int $yearOfBirth = 0;

    protected string $cityOfBirth = '';

    protected string $certificateID = '';

    protected string $registryNumber = '';

    protected bool $processed = false;

    protected bool $isValid = false;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function create(string $id): self
    {
        return new self($id);
    }

    public function process(): bool
    {
        $this->processed = true;
        $this->isValid = false;

        // Validate ID length
        if (strlen($this->id) !== 18) {
            return false;
        }

        // Extract parts of the ID
        $sexCode = substr($this->id, 0, 2);
        $yearOfBirth = substr($this->id, 2, 3);
        $communeOfBirth = substr($this->id, 5, 4);
        $civilStateRegistryID = substr($this->id, 9, 5);
        $registryID = substr($this->id, 14, 4);

        // Validate and set properties
        if (! $this->validateSexCode($sexCode) ||
            ! $this->validateYearOfBirth($yearOfBirth) ||
            ! $this->validateNumericFormat($communeOfBirth, 4) ||
            ! $this->validateNumericFormat($civilStateRegistryID, 5) ||
            ! $this->validateNumericFormat($registryID, 4)) {
            return false;
        }

        $this->cityOfBirth = $communeOfBirth;
        $this->certificateID = $civilStateRegistryID;
        $this->registryNumber = $registryID;

        $this->isValid = true;

        return true;
    }

    protected function validateSexCode(string $sexCode): bool
    {
        if ($sexCode === '10') {
            $this->sex = 'male';
        } elseif ($sexCode === '11') {
            $this->sex = 'female';
        } else {
            return false;
        }

        return true;
    }

    protected function validateYearOfBirth(string $yearOfBirth): bool
    {
        if (! preg_match('/^\d{3}$/', $yearOfBirth)) {
            return false;
        }

        $century = $yearOfBirth[0] === '9' ? '19' : '20';
        $this->yearOfBirth = (int) ($century.substr($yearOfBirth, 1));

        if ($century !== '20') {
            return true;
        }

        if ((new DateTime("01-01-{$this->yearOfBirth}"))->getTimestamp() > (new DateTime('now'))->getTimestamp()) {
            return false;
        }

        return true;
    }

    protected function validateNumericFormat(string $value, int $length): bool
    {
        return preg_match("/^\d{{$length}}$/", $value) === 1;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function isProcessed(): bool
    {
        return $this->processed;
    }

    public function print(): string
    {
        if ($this->isValid) {
            return "The ID is valid.\n".
                (($this->sex === 'male') ? 'Sex: Male/10' : 'Sex: Female/11')."\n".
                "Year of Birth: {$this->yearOfBirth}\n".
                "City of Birth: {$this->cityOfBirth}\n".
                "Certificate ID: {$this->certificateID}\n".
                "Registry Number: {$this->registryNumber}\n";
        }

        return "The ID is invalid.\n";
    }
}

// Example usage
$id = '109941329027780000'; // Replace with actual ID for testing
$algerianID = new AlgerianNationalID($id);
$algerianID->process();

echo $algerianID->print();
