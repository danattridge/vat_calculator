<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $product_name = null;

    #[ORM\Column]
    private ?float $product_value = null;

    #[ORM\Column]
    private ?int $product_qty = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customer_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customer_email = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $sale_ref = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?float $vat_rate = null;

    #[ORM\Column]
    private ?float $vat_amount = null;

    #[ORM\Column]
    private ?float $total_value_exc_vat = null;

    #[ORM\Column]
    private ?float $total_value_inc_vat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(?string $product_name): static
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getProductValue(): ?float
    {
        return $this->product_value;
    }

    public function setProductValue(float $product_value): static
    {
        $this->product_value = $product_value;

        return $this;
    }

    public function getProductQty(): ?int
    {
        return $this->product_qty;
    }

    public function setProductQty(int $product_qty): static
    {
        $this->product_qty = $product_qty;

        return $this;
    }

    public function getVatRate(): ?float
    {
        return $this->vat_rate;
    }

    public function setVatRate(float $vat_rate): static
    {
        $this->vat_rate = $vat_rate;

        return $this;
    }

    public function getVatAmount(): ?float
    {
        return $this->vat_amount;
    }

    public function setVatAmount(float $vat_amount): static
    {
        $this->vat_amount = $vat_amount;

        return $this;
    }

    public function getTotalValueExcVat(): ?float
    {
        return $this->total_value_exc_vat;
    }

    public function setTotalValueExcVat(float $total_value_exc_vat): static
    {
        $this->total_value_exc_vat = $total_value_exc_vat;

        return $this;
    }

    public function getTotalValueIncVat(): ?float
    {
        return $this->total_value_inc_vat;
    }

    public function setTotalValueIncVat(float $total_value_inc_vat): static
    {
        $this->total_value_inc_vat = $total_value_inc_vat;

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function setCustomerName(?string $customer_name): static
    {
        $this->customer_name = $customer_name;

        return $this;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customer_email;
    }

    public function setCustomerEmail(?string $customer_email): static
    {
        $this->customer_email = $customer_email;

        return $this;
    }

    public function getSaleRef(): ?string
    {
        return $this->sale_ref;
    }

    public function setSaleRef(?string $sale_ref): static
    {
        $this->sale_ref = $sale_ref;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    
}
