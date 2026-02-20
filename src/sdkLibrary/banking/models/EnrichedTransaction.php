<?php

namespace Inter\Sdk\sdkLibrary\banking\models;

use JsonException;

/**
 * The EnrichedTransaction class represents a transaction with enriched details,
 * including identifiers, amounts, and more specific transaction details.
 */
class EnrichedTransaction
{
    private ?string $cpmf;
    private ?string $transaction_id;
    private ?string $inclusion_date;
    private ?string $transaction_date;
    private ?string $transaction_type;
    private ?string $operation_type;
    private ?string $value;
    private ?string $title;
    private ?string $description;
    private ?string $document_number;
    private ?EnrichedTransactionDetails $details;
    private array $raw_transaction;

    public function __construct(
        ?string $cpmf = null,
        ?string $transaction_id = null,
        ?string $inclusion_date = null,
        ?string $transaction_date = null,
        ?string $transaction_type = null,
        ?string $operation_type = null,
        ?string $value = null,
        ?string $title = null,
        ?string $description = null,
        ?string $document_number = null,
        ?EnrichedTransactionDetails $details = null,
        array $raw_transaction = []
    ) {
        $this->cpmf = $cpmf;
        $this->transaction_id = $transaction_id;
        $this->inclusion_date = $inclusion_date;
        $this->transaction_date = $transaction_date;
        $this->transaction_type = $transaction_type;
        $this->operation_type = $operation_type;
        $this->value = $value;
        $this->title = $title;
        $this->description = $description;
        $this->document_number = $document_number;
        $this->details = $details;
        $this->raw_transaction = $raw_transaction;
    }

    public static function fromJson(mixed $json): self
    {
        $raw = is_array($json) ? $json : [];

        return new self(
            $raw['cpmf'] ?? null,
            $raw['idTransacao'] ?? null,
            $raw['dataInclusao'] ?? null,
            $raw['dataTransacao'] ?? null,
            $raw['tipoTransacao'] ?? null,
            $raw['tipoOperacao'] ?? null,
            $raw['valor'] ?? null,
            $raw['titulo'] ?? null,
            $raw['descricao'] ?? null,
            $raw['numeroDocumento'] ?? null,
            isset($raw['detalhes']) ? EnrichedTransactionDetails::fromJson($raw['detalhes']) : null,
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
        $transaction = $this->raw_transaction;
        $transaction['cpmf'] = $this->cpmf;
        $transaction['idTransacao'] = $this->transaction_id;
        $transaction['dataInclusao'] = $this->inclusion_date;
        $transaction['dataTransacao'] = $this->transaction_date;
        $transaction['tipoTransacao'] = $this->transaction_type;
        $transaction['tipoOperacao'] = $this->operation_type;
        $transaction['valor'] = $this->value;
        $transaction['titulo'] = $this->title;
        $transaction['descricao'] = $this->description;
        $transaction['numeroDocumento'] = $this->document_number;
        $transaction['detalhes'] = $this->details?->toArray();

        return $transaction;
    }
}
