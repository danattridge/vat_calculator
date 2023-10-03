<?php 
namespace App\Entity;  

class SalesForm {

   private $productName;
   private $productValue;
   private $productQty;
   private $customerName;
   private $customerEmail; 
   private $saleRef;
   
   
   public function getProductName() { 
      return $this->productName; 
   }  
   public function setProductName($productName) { 
      $this->productName = $productName; 
   }
   public function getProductValue() { 
      return $this->productValue; 
   }  
   public function setProductValue($productValue) { 
      $this->productValue = $productValue; 
   }
   public function getProductQty() { 
      return $this->productQty; 
   }  
   public function setProductQty($productQty) { 
      $this->productQty = $productQty; 
   }
   public function getCustomerName() { 
      return $this->customerName; 
   }  
   public function setCustomerName($customerName) { 
      $this->customerName = $customerName; 
   }
   public function getCustomerEmail() { 
      return $this->customerEmail; 
   }  
   public function setCustomerEmail($customerEmail) { 
      $this->customerEmail = $customerEmail; 
   }
   public function getSaleRef() { 
      return $this->saleRef; 
   }  
   public function setSaleRef($saleRef) { 
      $this->saleRef = $saleRef; 
   }
}