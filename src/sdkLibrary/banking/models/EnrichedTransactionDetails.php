<?php

namespace Inter\Sdk\sdkLibrary\banking\models;

use JsonException;

/**
 * The EnrichedTransactionDetails class represents additional details related to a transaction,
 * including the type of detail provided.
 */
class EnrichedTransactionDetails
{
    private ?string $detail_type;
    private array $raw_details;

    public function __construct(?string $detail_type = null, array $raw_details = [])
    {
        $this->detail_type = $detail_type;
        $this->raw_details = $raw_details;
    }

    public static function fromJson(mixed $json): self
    {
        $raw = is_array($json) ? $json : [];

        return new self(
            $raw['tipoDetalhe'] ?? null,
            $raw
        );
    }

    /**
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
    }

    public function toArray(): array
    {
        $details = $this->raw_details;
        if (!array_key_exists('tipoDetalhe', $details)) {
            $details['tipoDetalhe'] = $this->detail_type;
        }

        return $details;
    }
}
